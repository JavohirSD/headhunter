<?php

namespace console\controllers;

use api\modules\v1\models\Positions;
use yii\console\Controller;
use Yii;


class SeedController extends Controller
{
    public function actionPosition()
    {
        $faker = \Faker\Factory::create();

        for ( $i = 1; $i <= 20; $i++ )
        {
            $title = $faker->jobTitle;

            if(Positions::find()->where(['title' => $title])->exists()){
                $i--;
                continue;
            }

            $position = new Positions();
            $position->title = $faker->jobTitle;
            $position->status = 1;
            $position->created_at = date('Y-m-d H:i:s');
            $position->save();
        }
    }
}
