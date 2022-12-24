<?php

namespace api\common\controllers;

use Yii;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\filters\Cors;
use yii\helpers\Json;
use yii\rest\ActiveController;
use yii\web\Response;

class AppController extends ActiveController
{
    public $modelClass = '';

    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        //     Set authentication for custom actions only
        //   $behaviors['authentificator']['only'] = ['create','update','delete','index','view'];

        $behaviors['authenticator'] = [
            'class'       => CompositeAuth::class,
            'except'      => ['login', 'signup'],
            'authMethods' => [
                HttpBearerAuth::class,
            ],
        ];
        return $behaviors;
    }

    /**
     * Success response template
     *
     * @param mixed $data
     * @param string $message
     * @param int $code
     *
     * @return array
     */
    public function success(mixed $data, string $message = "", int $code = 200): array
    {
        Yii::$app->response->statusCode = $code;
        return [
            'success' => true,
            'message' => Yii::t('yii', $message),
            'data'    => $data,
        ];
    }


    /**
     * Error response template
     *
     * @param mixed $data
     * @param string $message
     * @param int $code
     *
     * @return array
     */
    public function error(mixed $data, string $message = "", int $code = 200): array
    {
        Yii::$app->response->statusCode = $code;
        return [
            'success' => false,
            'message' => Yii::t('yii', $message),
            'data'    => $data,
        ];
    }
}