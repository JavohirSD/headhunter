<?php

namespace App\Models;


use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Vacancy
 * @property int $id
 * @property string $title
 * @property int $position_id
 * @property int $salary
 * @property int $salary_unit
 * @property int $user_id
 * @property string $schedule
 * @property string|null $created_at
 * @property string|null $updated_at
 * @method static Builder|Vacancy newModelQuery()
 * @method static Builder|Vacancy newQuery()
 * @method static Builder|Vacancy query()
 * @mixin Eloquent
 */
class Vacancy extends Model
{
    use HasFactory;

    protected $table = 'vacancy';

    protected $appends = ['views','clicks'];

    public $timestamps = false;

    protected $fillable = [
        'title',
        'position_id',
        'salary',
        'salary_unit',
        'user_id',
        'schedule',
        'status'
    ];

    /**
     * Accessor for positionId attribute
     * @return Attribute
     */
    protected function positionId(): Attribute
    {
        return Attribute::make(
            get: fn ($position_id) => Positions::where('id',$position_id)->first()?->title,
        );
    }

    /**
     * Accessor for views dynamic attribute
     * @return Attribute
     */
    protected function views(): Attribute
    {
        return Attribute::make(
            get: fn ($views) => VacancyViews::where('vacancy_id', $this->id)->count(),
        );
    }

    protected function clicks(): Attribute
    {
        return Attribute::make(
            get: fn ($views) => VacancyClicks::where('vacancy_id', $this->id)->count(),
        );
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

                    VacancyToSkill::firstOrCreate([
                        'skill_id'  => $skl->id,
                        'vacancy_id' => $this->id
                    ]);
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
            'vacancy_to_skill',
            'vacancy_id',
            'skill_id');
    }
}
