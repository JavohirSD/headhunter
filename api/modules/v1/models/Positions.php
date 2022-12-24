<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "positions".
 *
 * @property int $id
 * @property string $title
 * @property string $created_at
 * @property int|null $status
 *
 * @property PositionsToResume[] $positionsToResumes
 */
class Positions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'positions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
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
     * Gets query for [[PositionsToResumes]].
     *
     * @return \yii\db\ActiveQuery|\api\modules\v1\models\query\PositionsToResumeQuery
     */
    public function getPositionsToResumes()
    {
        return $this->hasMany(PositionsToResume::class, ['position_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \api\modules\v1\models\query\PositionsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \api\modules\v1\models\query\PositionsQuery(get_called_class());
    }

    public static function findOrCreate($position)
    {
        $pos = Positions::find()->active()->where(['title' => $position])->one();

        if($pos === null){
            $pos = new Positions();
            $pos->title  = $position;
            $pos->status = 1;
            $pos->save();
        }

        return $pos;
    }
}
