<?php

namespace api\modules\v1\controllers;

use api\common\controllers\AppController;
use api\modules\v1\models\Resume;
use common\models\User;
use Yii;
use yii\base\Exception;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use yii\web\UploadedFile;

class ResumeController extends AppController
{
    /**
     * Override create action
     *
     * @return array
     */
    public function actions(): array
    {
        $actions = parent::actions();
        unset($actions['create']);
        unset($actions['index']);
        unset($actions['delete']);
        return $actions;
    }



    /**
     * Bind a model to the controller
     *
     * @var string
     */
    public $modelClass = Resume::class;


    /**
     * Create a new resume
     *
     * @return array
     */
    public function actionCreate(): array
    {
        $model = new Resume();

        if ($post = Yii::$app->request->post()) {

            $transaction = Yii::$app->db->beginTransaction();

            try {
                $model->job_duration = $post['job_duration'];
                $model->salary_unit  = $post['salary_unit'];
                $model->salary       = $post['salary'];
                $model->phone        = $post['phone'];
                $model->website      = $post['website'];

                $model->setAvatar(UploadedFile::getInstanceByName("avatar"));

                if ($model->save()) {

                    $model->setSkills($post['skills'] ?? "");
                    $model->setPositions($post['positions'] ?? "");
                    $model->setLanguages($post['languages'] ?? "");
                    $model->setPortfolio(UploadedFile::getInstancesByName("portfolio"));

                    $transaction->commit();

                    return $this->success($model, 'Created successfully', 201);
                }
            } catch (Exception $e) {
                $transaction->rollBack();
                return $this->error($model->getErrors(), $e->getMessage());
            }
        }

        return $this->error([], 'Empty request body',204);
    }


    /** Get all resumes
     *
     * @return array
     */
    public function actionIndex(): array
    {
        $query = Resume::find()->with('user')->active();

        if(User::hasRole('applicant')){
            $query->andWhere(['user_id' => Yii::$app->user->id]);
        }

        return $this->success($query->all());
    }


    /**
     * Delete resume
     *
     * @param $id
     *
     * @return array
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function actionDelete($id): array
    {
        $query =  Resume::find()->where(['id' => $id]);

        if(User::hasRole('applicant')){
            $query->andWhere(['user_id' => Yii::$app->user->id]);
        }

        if(Yii::$app->user->can('deleteResume')){
            $query->one()->delete();
        }

        return $this->success([],'Deleted');
    }


}