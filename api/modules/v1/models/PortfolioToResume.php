<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "portfolio_to_resume".
 *
 * @property int $id
 * @property string $file
 * @property int $resume_id
 *
 * @property Resume $resume
 */
class PortfolioToResume extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'portfolio_to_resume';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file', 'resume_id'], 'required'],
            [['resume_id'], 'integer'],
            [['resume_id'], 'exist', 'skipOnError' => true, 'targetClass' => Resume::class, 'targetAttribute' => ['resume_id' => 'id']],
            [['file'], 'file',  'extensions' => ['png', 'jpg','jpeg','bmp','doc','docx','pdf'], 'checkExtensionByMimeType'=>true,'maxSize'=>1024*1024*8],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file' => 'File',
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
}
