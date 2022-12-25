<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\VacancyToSkill
 *
 * @method static Builder|VacancyToSkill newModelQuery()
 * @method static Builder|VacancyToSkill newQuery()
 * @method static Builder|VacancyToSkill query()
 * @mixin Eloquent
 */
class VacancyToSkill extends Model
{
    use HasFactory;

    protected $table = 'vacancy_to_skill';

    public $timestamps = false;

    protected $fillable = [
        'skill_id',
        'vacancy_id'
    ];
}
