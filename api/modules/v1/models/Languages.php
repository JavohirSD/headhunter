<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "languages".
 *
 * @property int $id
 * @property string $language
 *
 * @property LanguagesToResume[] $languagesToResumes
 */
class Languages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'languages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['language'], 'required'],
            [['language'], 'string', 'max' => 4],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'language' => 'Language',
        ];
    }

    /**
     * Gets query for [[LanguagesToResumes]].
     *
     * @return \yii\db\ActiveQuery|\api\modules\v1\models\query\LanguagesToResumeQuery
     */
    public function getLanguagesToResumes()
    {
        return $this->hasMany(LanguagesToResume::class, ['language_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \api\modules\v1\models\query\LanguagesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \api\modules\v1\models\query\LanguagesQuery(get_called_class());
    }
}
