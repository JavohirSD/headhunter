<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "vacancy_to_skill".
 *
 * @property int $id
 * @property int $vacancy_id
 * @property int $skill_id
 */
class VacancyToSkill extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vacancy_to_skill';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vacancy_id', 'skill_id'], 'required'],
            [['vacancy_id', 'skill_id'], 'integer'],
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
            'skill_id' => 'Skill ID',
        ];
    }

    public function getVacancy()
    {
        return $this->hasOne(Vacancy::class, ['id' => 'vacancy_id']);
    }


    public function getSkills()
    {
        return $this->hasOne(Skills::class, ['id' => 'skill_id']);
    }
}
