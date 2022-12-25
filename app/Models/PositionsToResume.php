<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\PositionsToResume
 *
 * @method static Builder|PositionsToResume newModelQuery()
 * @method static Builder|PositionsToResume newQuery()
 * @method static Builder|PositionsToResume query()
 * @mixin Eloquent
 */
class PositionsToResume extends Model
{
    use HasFactory;

    protected $table = 'positions_to_resume';

    public $timestamps = false;

    protected $fillable = [
        'position_id',
        'resume_id'
    ];

    /**
     * @return BelongsTo
     */
    public function position(): BelongsTo
    {
        return $this->belongsTo(Positions::class, 'position_id','id');
    }
}
