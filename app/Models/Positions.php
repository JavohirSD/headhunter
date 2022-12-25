<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Positions
 *
 * @property int $id
 * @property string $title
 * @property Carbon|null $created_at
 * @property int|null $status
 * @method static Builder|Positions newModelQuery()
 * @method static Builder|Positions newQuery()
 * @method static Builder|Positions query()
 * @method static Builder|Positions whereCreatedAt($value)
 * @method static Builder|Positions whereId($value)
 * @method static Builder|Positions whereStatus($value)
 * @method static Builder|Positions whereTitle($value)
 * @mixin Eloquent
 */
class Positions extends Model
{
    use HasFactory;

    protected $table = 'positions';

    public $timestamps = false;

    protected $fillable = [
        'title',
        'status'
    ];

    protected $hidden = [
        'created_at',
        'status'
    ];

}
