<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "skills_to_resume".
 *
 * @property int $id
 * @property int $skill_id
 * @property int $resume_id
 *
 * @property Resume $resume
 * @property Skills $skill
 */
class SkillsToResume extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'skills_to_resume';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['skill_id', 'resume_id'], 'required'],
            [['skill_id', 'resume_id'], 'integer'],
            [['resume_id'], 'exist', 'skipOnError' => true, 'targetClass' => Resume::class, 'targetAttribute' => ['resume_id' => 'id']],
            [['skill_id'], 'exist', 'skipOnError' => true, 'targetClass' => Skills::class, 'targetAttribute' => ['skill_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'skill_id' => 'Skill ID',
            'resume_id' => 'Resume ID',
        ];
    }

    /**
     * Gets query for [[Resume]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResume()
    {
        return $this->hasOne(Resume::class, ['id' => 'resume_id']);
    }

    /**
     * Gets query for [[Skill]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSkill()
    {
        return $this->hasOne(Skills::class, ['id' => 'skill_id']);
    }
}
