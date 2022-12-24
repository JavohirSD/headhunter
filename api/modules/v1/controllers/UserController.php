<?php

namespace api\modules\v1\controllers;


use api\common\controllers\AppController;
use common\models\LoginForm;
use common\models\User;
use Exception;
use frontend\models\SignupForm;
use Yii;


class UserController extends AppController
{
    public $modelClass = User::class;

    // Change API's default actions like - create,update,view,index,delete
    // https://stackoverflow.com/questions/36300972/yii2-rest-api-actions-in-activecontroller


    /**
     * Login user
     *
     * @return array
     */
    public function actionLogin(): array
    {
        $model = new LoginForm();

        // Load post data to model and validate
        if ($model->load(\Yii::$app->request->post(), '') && ($model->login())) {

            return $this->success([
                'user_id'  => Yii::$app->user->id,
                'username' => Yii::$app->user->identity->username,
                'auth_key' => Yii::$app->user->identity->getAuthKey()
            ], 'Successfully logged in');

        }
        return $this->error([]);
    }


    /**
     * Create a new user
     *
     * @return array
     * @throws Exception
     */
    public function actionSignup(): array
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post(), '')) {

            if ($user = $model->signup()) {
                return $this->success([
                    'user_id'  => $user->id,
                    'username' => $user->username,
                    'auth_key' => $user->auth_key
                ], 'Successfully created', 201);
            }
        }

        return $this->error($model->getErrors(), 'Validation error');
    }


}