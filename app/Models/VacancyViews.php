<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\VacancyViews
 *
 * @property int $id
 * @property int|null $vacancy_id
 * @property int|null $user_id
 * @property Carbon|null $created_at
 * @method static Builder|VacancyViews newModelQuery()
 * @method static Builder|VacancyViews newQuery()
 * @method static Builder|VacancyViews query()
 * @method static Builder|VacancyViews whereCreatedAt($value)
 * @method static Builder|VacancyViews whereId($value)
 * @method static Builder|VacancyViews whereUserId($value)
 * @method static Builder|VacancyViews whereVacancyId($value)
 * @mixin Eloquent
 */
class VacancyViews extends Model
{
    use HasFactory;

    protected $table = 'vacancy_views';

    public $timestamps = false;

    protected $fillable = [
        'vacancy_id',
        'user_id'
    ];

}
