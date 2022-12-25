<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\VacancyClicks
 *
 * @property int $id
 * @property int $user_id
 * @property int $vacancy_id
 * @property Carbon|null $created_at
 * @method static Builder|VacancyClicks newModelQuery()
 * @method static Builder|VacancyClicks newQuery()
 * @method static Builder|VacancyClicks query()
 * @method static Builder|VacancyClicks whereCreatedAt($value)
 * @method static Builder|VacancyClicks whereId($value)
 * @method static Builder|VacancyClicks whereUserId($value)
 * @method static Builder|VacancyClicks whereVacancyId($value)
 * @mixin Eloquent
 */
class VacancyClicks extends Model
{
    use HasFactory;

    protected $table = 'vacancy_clicks';

    public $timestamps = false;

    protected $fillable = [
        'vacancy_id',
        'user_id'
    ];
}
