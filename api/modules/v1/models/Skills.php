<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "skills".
 *
 * @property int $id
 * @property string|null $title
 * @property string $created_at
 * @property int|null $status
 *
 * @property SkillsToResume[] $skillsToResumes
 */
class Skills extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'skills';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at'], 'safe'],
            [['status'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'created_at' => 'Created At',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[SkillsToResumes]].
     *
     * @return \yii\db\ActiveQuery|\api\modules\v1\models\query\SkillsToResumeQuery
     */
    public function getSkillsToResumes()
    {
        return $this->hasMany(SkillsToResume::class, ['skill_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \api\modules\v1\models\query\SkillsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \api\modules\v1\models\query\SkillsQuery(get_called_class());
    }


    public static function findOrCreate($title)
    {
        $skl = Skills::find()->active()->where(['title' => $title])->one();

        if($skl === null){
            $skl = new Skills();
            $skl->title  = $title;
            $skl->status = 1;
            $skl->save();
        }

        return $skl;
    }
}
