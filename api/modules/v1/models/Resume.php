<?php

namespace api\modules\v1\models;

use common\models\User;
use Yii;
use yii\base\Exception;

/**
 * This is the model class for table "resume".
 *
 * @property int $id
 * @property int $user_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $avatar
 * @property int $job_duration
 * @property int $salary
 * @property int $salary_unit
 * @property string $phone
 * @property string|null $website
 * @property int|null $status
 *
 * @property LanguagesToResume[] $languagesToResumes
 * @property PortfolioToResume[] $portfolioToResumes
 * @property PositionsToResume[] $positionsToResumes
 * @property SkillsToResume[] $skillsToResumes
 * @property User $user
 */
class Resume extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'resume';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['avatar', 'job_duration', 'salary', 'salary_unit', 'phone'], 'required'],
            [['user_id', 'job_duration', 'salary', 'salary_unit', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['website'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 16],
            [['user_id'], 'default', 'value'=> Yii::$app->user->id],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['avatar'], 'file',  'extensions' => ['png', 'jpg','jpeg','bmp'], 'checkExtensionByMimeType'=>true,'maxSize'=>1024*1024*8],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'avatar' => 'Avatar',
            'job_duration' => 'Job Duration',
            'salary' => 'Salary',
            'salary_unit' => 'Salary Unit',
            'phone' => 'Phone',
            'website' => 'Website',
            'status' => 'Status',
        ];
    }


    public function fields()
    {
        return [
            'id',
            'user' => function($model){
                return User::find()->select(['id','username'])->where(['id' => $model->user_id])->one();
            },
            'created_at',
            'updated_at',
            'avatar',
            'job_duration',
            'salary',
            'salary_unit',
            'phone',
            'website',
            'status',
            'skills' => function($model){
                    return Skills::find()
                        ->innerJoin('skills_to_resume','skills.id =skills_to_resume.skill_id')
                        ->where(['skills_to_resume.resume_id' => $model->id])
                        ->all();
            },
            'positions' => function($model){
                return Positions::find()
                    ->innerJoin('positions_to_resume','positions.id =positions_to_resume.position_id')
                    ->where(['positions_to_resume.resume_id' => $model->id])
                    ->all();
            },
        ];
    }


    public function getBasePath(): string
    {
       return Yii::getAlias('@api') . '/web/uploads/';
    }

    /**
     * Gets query for [[LanguagesToResumes]].
     *
     * @return \yii\db\ActiveQuery|\api\modules\v1\models\query\LanguagesToResumeQuery
     */
    public function getLanguagesToResumes()
    {
        return $this->hasMany(LanguagesToResume::class, ['resume_id' => 'id']);
    }

    /**
     * Gets query for [[PortfolioToResumes]].
     *
     * @return \yii\db\ActiveQuery|\api\modules\v1\models\query\PortfolioToResumeQuery
     */
    public function getPortfolioToResumes()
    {
        return $this->hasMany(PortfolioToResume::class, ['resume_id' => 'id']);
    }

    /**
     * Gets query for [[PositionsToResumes]].
     *
     * @return \yii\db\ActiveQuery|\api\modules\v1\models\query\PositionsToResumeQuery
     */
    public function getPositionsToResumes()
    {
        return $this->hasMany(PositionsToResume::class, ['resume_id' => 'id']);
    }

    /**
     * Gets query for [[SkillsToResumes]].
     *
     * @return \yii\db\ActiveQuery|\api\modules\v1\models\query\SkillsToResumeQuery
     */
    public function getSkillsToResume()
    {
        return $this->hasMany(SkillsToResume::class, ['resume_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|\api\modules\v1\models\query\UserQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return \api\modules\v1\models\query\ResumeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \api\modules\v1\models\query\ResumeQuery(get_called_class());
    }


    /**
     * Set positions and binds to the resume
     *
     * @param string $positions
     *
     * @return void
     */
    public function setPositions(string $positions = "")
    {
        if(mb_strlen($positions) > 1){
            $positions = explode(',',$positions);

            if(!empty($positions)){
                foreach ($positions as $position){

                    $pos = Positions::findOrCreate($position);

                    $model = new PositionsToResume();
                    $model->position_id = $pos->id;
                    $model->resume_id   = $this->id;
                    $model->save();
                }
            }
        }
    }


    /**
     * Upload/Save portfolio files
     *
     * @param $files
     *
     * @return void
     * @throws Exception
     */
    public function setPortfolio($files)
    {
        if ($files) {

            foreach ($files as $file) {

                $fileName = Yii::$app->security->generateRandomString().'.'.$file->extension;

                $porfolio = new PortfolioToResume();
                $porfolio->file = $fileName;
                $porfolio->resume_id = $this->id;

                if ($file->saveAs($this->getBasePath() . $fileName)) {
                    $porfolio->save();

                }
            }
        }
    }


    /**
     * Upload resume avatar image
     *
     * @param $file
     *
     * @return void
     * @throws Exception
     */
    public function setAvatar($file)
    {
        if (!empty($file)) {

            $fileName = Yii::$app->security->generateRandomString();

            if ($file->saveAs($this->getBasePath() . "." . $fileName)) {
                $this->avatar = $fileName;
            }
        }
    }


    /**
     * Set languages and binds to the resume
     *
     * @param string $languages
     *
     * @return void
     */
    public function setLanguages(string $languages = "")
    {
        if(mb_strlen($languages) > 1){
            $languages = explode(',',$languages);

            if(!empty($languages)){
                foreach ($languages as $language){

                    $loc = Languages::find()->where(['language' => $language])->one();

                    if($loc === null){
                        $loc = new Languages();
                        $loc->language  = $language;
                        $loc->save();
                    }

                    $model = new LanguagesToResume();
                    $model->language_id = $loc->id;
                    $model->resume_id   = $this->id;
                    $model->save();
                }
            }
        }
    }


    /**
     * Set skills and binds to the resume
     *
     * @param string $skills
     *
     * @return void
     */
    public function setSkills(string $skills = "")
    {
        if(mb_strlen($skills) > 1){
            $skills = explode(',',$skills);

            if(!empty($skills)){
                foreach ($skills as $skill){

                    $skl = Skills::findOrCreate($skill);

                    $model = new SkillsToResume();
                    $model->skill_id  = $skl->id;
                    $model->resume_id = $this->id;
                    $model->save();
                }
            }
        }
    }
}
