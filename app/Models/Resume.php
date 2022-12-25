<?php

namespace App\Models;

use Auth;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Resume
 *
 * @method static Builder|Resume newModelQuery()
 * @method static Builder|Resume newQuery()
 * @method static Builder|Resume query()
 * @mixin Eloquent
 * @property int $id
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $avatar
 * @property int $job_duration
 * @property int $salary
 * @property int $salary_unit
 * @property string $phone
 * @property string|null $website
 * @property int|null $status
 * @property-write mixed $password
 * @method static Builder|Resume whereAvatar($value)
 * @method static Builder|Resume whereCreatedAt($value)
 * @method static Builder|Resume whereId($value)
 * @method static Builder|Resume whereJobDuration($value)
 * @method static Builder|Resume wherePhone($value)
 * @method static Builder|Resume whereSalary($value)
 * @method static Builder|Resume whereSalaryUnit($value)
 * @method static Builder|Resume whereStatus($value)
 * @method static Builder|Resume whereUpdatedAt($value)
 * @method static Builder|Resume whereUserId($value)
 * @method static Builder|Resume whereWebsite($value)
 */
class Resume extends Model
{
    use HasFactory;

    // Define model table
    protected $table = 'resume';

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->user_id = Auth::id();
        });
    }

    /**
     * Set skills and binds to the resume
     *
     * @param string $skills
     *
     * @return void
     */
    public function setSkills(string $skills = ""): void
    {
        if (mb_strlen($skills) > 1) {
            $skills = explode(',', $skills);

            if (!empty($skills)) {
                foreach ($skills as $skill) {

                    $skl = Skills::firstOrCreate(
                        ['title' => $skill],
                        ['status' => 1]
                    );

                    SkillsToResume::firstOrCreate([
                        'skill_id'  => $skl->id,
                        'resume_id' => $this->id
                    ]);
                }
            }
        }
    }


    /**
     * Set positions and binds to the resume
     *
     * @param string $positions
     *
     * @return void
     */
    public function setPositions(string $positions = ""): void
    {
        if (mb_strlen($positions) > 1) {
            $positions = explode(',', $positions);

            if (!empty($positions)) {
                foreach ($positions as $position) {

                    $pos = Positions::firstOrCreate(
                        ['title' => $position],
                        ['status' => 1]
                    );

                    PositionsToResume::firstOrCreate([
                        'position_id' => $pos->id,
                        'resume_id'   => $this->id
                    ]);
                }
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
    public function setLanguages(string $languages = ""): void
    {
        if (mb_strlen($languages) > 1) {
            $languages = explode(',', $languages);

            if (!empty($languages)) {
                foreach ($languages as $language) {

                    $loc = Languages::firstOrCreate(['language' => $language]);

                    LanguagesToResume::firstOrCreate([
                        'language_id' => $loc->id,
                        'resume_id'   => $this->id
                    ]);
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
     */
    public function setPortfolio($files): void
    {
        if ($files) {
            foreach ($files as $file) {

                if ($file_path = $file->store('portfolios', 'public')) {

                    $portfolio            = new PortfolioToResume();
                    $portfolio->file      = $file_path;
                    $portfolio->resume_id = $this->id;
                    $portfolio->save();
                }
            }
        }
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }


    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(
            Skills::class,
            'skills_to_resume',
            'resume_id',
            'skill_id');
    }


    public function positions(): BelongsToMany
    {
        return $this->belongsToMany(
            Positions::class,
            'positions_to_resume',
            'resume_id',
            'position_id');
    }
}
