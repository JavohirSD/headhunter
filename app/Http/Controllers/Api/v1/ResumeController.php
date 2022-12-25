<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResumeRequest;
use App\Models\Resume;
use Auth;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ResumeController extends Controller
{

    /**
     * Create a new Resume
     *
     * @param ResumeRequest $request
     *
     * @return JsonResponse
     * @throws Throwable
     */
    public function create(ResumeRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $image_path = $request->file('avatar')->store('avatars', 'public');

            $resume               = new Resume();
            $resume->job_duration = $request->input('job_duration');
            $resume->salary_unit  = $request->input('salary_unit');
            $resume->salary       = $request->input('salary');
            $resume->phone        = $request->input('phone');
            $resume->website      = $request->input('website');
            $resume->avatar       = $image_path;

            if ($resume->save()) {

                $resume->setSkills($request->input('skills'));
                $resume->setPositions($request->input('positions'));
                $resume->setLanguages($request->input('languages'));
                $resume->setPortfolio($request->file('portfolio'));

                DB::commit();

                return $this->success($resume, 'Created successfully', Response::HTTP_CREATED);
            }
        } catch (Exception $e) {
            DB::rollback();
            return $this->error([], $e->getMessage());
        }

        return $this->error([], 'Error');
    }


    /**
     * Get all resumes
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {

        $query = Resume::with(['user','skills','positions']);

        if(!Gate::allows('view_all_resumes')){
            $query->where('user_id', Auth::id());
        }

        return $this->success($query->get());
    }


    /**
     * Delete a resume
     *
     * @param $id
     *
     * @return JsonResponse
     */
    public function delete($id): JsonResponse
    {
        $query = Resume::where('id',$id)->first();

            if ($query && Gate::allows('delete_resume', $query)) {
                return $this->success([], 'Deleted');
            }

        return $this->error([],'Not found or not allowed');
    }
}
