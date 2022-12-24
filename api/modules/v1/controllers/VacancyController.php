<?php

namespace api\modules\v1\controllers;

use api\common\controllers\AppController;
use api\modules\v1\models\PositionsToResume;
use api\modules\v1\models\Resume;
use api\modules\v1\models\SkillsToResume;
use api\modules\v1\models\Vacancy;
use api\modules\v1\models\VacancyClicks;
use common\models\User;
use Exception;
use Yii;
use yii\db\Query;

class VacancyController extends AppController
{

    /**
     * Override create action
     *
     * @return array
     */
    public function actions(): array
    {
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }

    /**
     * Get all vacancies list
     *
     * @return array
     * @var string
     */
    public $modelClass = Vacancy::class;


    public function actionIndex(): array
    {
        $query = Vacancy::find();

        if (User::hasRole('admin') === false) {
            $query->where(['user_id' => Yii::$app->user->id]);
        }

        return $this->success($query->all());
    }

    /**
     * Create a vacancy
     *
     * @return array
     */
    public function actionCreate(): array
    {
        $model = new Vacancy();

        if (Yii::$app->user->can('createVacancy')) {

            $transaction = Yii::$app->db->beginTransaction();

            try {
                $model->load(Yii::$app->request->post());

                if ($model->load(Yii::$app->request->post()) && $model->save()) {

                    $transaction->commit();

                    return $this->success($model, 'Created', 201);
                }
            } catch (Exception $e) {
                $transaction->rollBack();
                return $this->error($model->getErrors(), $e->getMessage());
            }
        }

        return $this->error([], 'Not allowed', 401);
    }

    /**
     * Find related jobs for the user
     *
     * @return array
     */
    public function actionRelated(): array
    {
        $user_id      = Yii::$app->user->id;
        $user_resumes = Resume::find()->active()->where(['user_id' => $user_id])->all();

        // Find user skills
        $user_skills = [];
        foreach ($user_resumes as $resume) {
            $skills = SkillsToResume::find()->where(['resume_id' => $resume->id])->all();

            foreach ($skills as $skill) {
                if (!in_array($skill->skill->id, $user_skills)) {
                    $user_skills[] = $skill->skill->id;
                }
            }
        }

        // Find user positions
        $user_positions = [];
        foreach ($user_resumes as $resume) {
            $positions = PositionsToResume::find()->where(['resume_id' => $resume->id])->all();

            foreach ($positions as $position) {
                if (!in_array($position->position->id, $user_positions)) {
                    $user_positions[] = $position->position->id;
                }
            }
        }

        // Find vacancies related to user
        $related_vacancies = (new Query())
            ->select(['vacancy.id', 'vacancy.title'])
            ->from('vacancy')
            ->innerJoin('vacancy_to_skill', 'vacancy_to_skill.vacancy_id = vacancy.id')
            ->where(['IN', 'vacancy_to_skill.skill_id', $user_skills])
            ->where(['IN', 'position_id', $user_positions])
            ->distinct()
            ->all();

        return $this->success($related_vacancies);
    }

    /**
     * Click to vacancy
     *
     * @param $id
     *
     * @return array
     */
    public function actionClick($id): array
    {
        if (User::hasRole('applicant')) {
            $click             = new VacancyClicks();
            $click->vacancy_id = $id;
            $click->user_id    = Yii::$app->user->id;
            return $this->success($click->save(), 'Clicked', 201);
        }

        return $this->error([], 'Not allowed');
    }


    /**
     * Get statistics about click
     *
     * @return array
     */
    public function actionClicks(): array
    {
        if (Yii::$app->user->can('viewClicks')) {
            $clicks = (new Query())
                ->select(['user.username', 'vacancy_clicks.created_at AS clicked_at', 'vacancy.title'])
                ->from('vacancy')
                ->innerJoin('vacancy_clicks', 'vacancy_clicks.vacancy_id = vacancy.id')
                ->innerJoin('user', 'user.id = vacancy_clicks.user_id')
                ->where(['vacancy.user_id' => Yii::$app->user->id])
                ->distinct()
                ->all();

            return $this->success($clicks);
        }
        return $this->error([], 'Now allowed');
    }
}