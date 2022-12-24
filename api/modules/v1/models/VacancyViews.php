<?php

namespace api\modules\v1\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "vacancy_views".
 *
 * @property int $id
 * @property int|null $vacancy_id
 * @property int|null $user_id
 * @property string|null $created_at
 *
 * @property User $user
 * @property Vacancy $vacancy
 */
class VacancyViews extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vacancy_views';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vacancy_id', 'user_id'], 'integer'],
            [['created_at'], 'safe'],
            [['vacancy_id', 'user_id'], 'unique', 'targetAttribute' => ['vacancy_id', 'user_id']],
            [['vacancy_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vacancy::class, 'targetAttribute' => ['vacancy_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vacancy_id' => 'Vacancy ID',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Gets query for [[Vacancy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVacancy()
    {
        return $this->hasOne(Vacancy::class, ['id' => 'vacancy_id']);
    }

    /**
     * @param $vacancy_id
     *
     * @return VacancyViews|null
     */
    public static function findOrCreate($vacancy_id)
    {
        $view = VacancyViews::find()->where(
            [
                'user_id' => Yii::$app->user->id,
                'vacancy_id' => $vacancy_id
            ]
        )->one();

        if($view === null){
            $view = new VacancyViews();
            $view->vacancy_id = $vacancy_id;
            $view->user_id = Yii::$app->user->id;
            $view->save();
        }

        return $view;
    }
}
