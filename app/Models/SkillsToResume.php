<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\SkillsToResume
 *
 * @property int $id
 * @property int $skill_id
 * @property int $resume_id
 * @method static Builder|SkillsToResume newModelQuery()
 * @method static Builder|SkillsToResume newQuery()
 * @method static Builder|SkillsToResume query()
 * @method static Builder|SkillsToResume whereId($value)
 * @method static Builder|SkillsToResume whereResumeId($value)
 * @method static Builder|SkillsToResume whereSkillId($value)
 * @mixin Eloquent
 */
class SkillsToResume extends Model
{
    use HasFactory;

    protected $table = 'skills_to_resume';

    public $timestamps = false;

    protected $fillable = [
        'skill_id',
        'resume_id'
    ];

    /**
     * @return BelongsTo
     */
    public function skill(): BelongsTo
    {
        return $this->belongsTo(Skills::class, 'skill_id','id');
    }




}
