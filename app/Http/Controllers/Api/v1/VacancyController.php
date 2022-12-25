<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\VacancyRequest;
use App\Models\PositionsToResume;
use App\Models\Resume;
use App\Models\SkillsToResume;
use App\Models\Vacancy;
use App\Models\VacancyClicks;
use App\Models\VacancyViews;
use Auth;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class VacancyController extends Controller
{

    /**
     * Create a new Resume
     *
     * @param VacancyRequest $request
     *
     * @return JsonResponse
     * @throws Throwable
     */
    public function create(VacancyRequest $request): JsonResponse
    {
        if (!Gate::allows('create_vacancy')) {
            return $this->error([], 'Not allowed');
        }

        DB::beginTransaction();

        try {
            $vacancy = new Vacancy();
            $vacancy->title       = $request->input('title');
            $vacancy->salary      = $request->input('salary');
            $vacancy->salary_unit = $request->input('salary_unit');
            $vacancy->schedule    = $request->input('schedule');
            $vacancy->position_id = $request->input('position_id');
            $vacancy->user_id     = Auth::id();

            if ($vacancy->save()) {
                $vacancy->setSkills($request->input('skills'));

                DB::commit();
                return $this->success($vacancy, 'Created successfully', Response::HTTP_CREATED);
            }
        } catch (Exception $e) {
            DB::rollback();
            return $this->error([], $e->getMessage());
        }

        return $this->error([], 'Error');
    }


    /**
     * Get list of vacancies
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $vacancy = Vacancy::with(['user','skills'])->where('status',1);

        if(!Gate::allows('view_all_vacancy')){
            $vacancy->where('user_id',Auth::id());
        }

        return $this->success($vacancy->get());
    }


    /**
     * View a vacancy
     *
     * @param $id
     *
     * @return JsonResponse
     */
    public function view($id): JsonResponse
    {
       if($vacancy = Vacancy::with('skills')->find($id)){
           VacancyViews::firstOrCreate([
               'vacancy_id' => $id,
               'user_id' => Auth::id()
           ]);

           return $this->success($vacancy);
       }
       return $this->error([],'Not found', Response::HTTP_NOT_FOUND);
    }


    /**
     * Click to vacancy
     *
     * @param $id
     *
     * @return JsonResponse
     */
    public function click($id): JsonResponse
    {
        if(Gate::allows('click_vacancy')){

            if(Vacancy::where('id',$id)->exists()){
                $click = VacancyClicks::firstOrCreate([
                    'vacancy_id' => $id,
                    'user_id' => Auth::id()
                ]);

                return $this->success($click,'Clicked', Response::HTTP_CREATED);
            }

            return $this->error([],'Wrong vacancy ID');
        }

        return $this->error([],'Not allowed');
    }


    /**
     * Find recommended vacancies for user
     *
     * @return JsonResponse
     */
    public function related(): JsonResponse
    {
        $user_resumes = Resume::where('user_id', Auth::id())
                        ->where('status',1)
                        ->get();

        // Find user skills
        $user_skills = [];
        foreach ($user_resumes as $resume) {
            $skills = SkillsToResume::where('resume_id',$resume->id)->get();

            foreach ($skills as $skill) {
                if (!in_array($skill->skill->id, $user_skills)) {
                    $user_skills[] = $skill->skill->id;
                }
            }
        }

        // Find user positions
        $user_positions = [];
        foreach ($user_resumes as $resume) {
            $positions = PositionsToResume::where('resume_id', $resume->id)->get();

            foreach ($positions as $position) {
                if (!in_array($position->position->id, $user_positions)) {
                    $user_positions[] = $position->position->id;
                }
            }
        }

        // Find vacancies related to user
        $related_vacancies = DB::table('vacancy')
            ->select(['vacancy.id AS vacancy_id', 'vacancy.title'])
            ->join('vacancy_to_skill', 'vacancy_to_skill.vacancy_id','=','vacancy.id')
            ->whereIn('vacancy_to_skill.skill_id', $user_skills)
            ->whereIn('position_id', $user_positions)
            ->distinct()
            ->get();

        return $this->success(['related_vacancies' => $related_vacancies]);
    }



    /**
     * Get statistics about click
     *
     * @return JsonResponse
     */
    public function clicks(): JsonResponse
    {
        if (Gate::allows('view_statistics')) {
            $clicks = DB::table('vacancy')
                ->select(['users.username', 'vacancy_clicks.created_at AS clicked_at', 'vacancy.title'])
                ->join('vacancy_clicks', 'vacancy_clicks.vacancy_id','=','vacancy.id')
                ->join('users', 'users.id','=','vacancy_clicks.user_id')
                ->where(['vacancy.user_id' => Auth::id()])
                ->distinct()
                ->get();

            return $this->success($clicks);
        }
        return $this->error([], 'Now allowed');
    }



}
