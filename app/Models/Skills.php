<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Skills
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $created_at
 * @property int|null $status
 * @method static Builder|Skills newModelQuery()
 * @method static Builder|Skills newQuery()
 * @method static Builder|Skills query()
 * @method static Builder|Skills whereCreatedAt($value)
 * @method static Builder|Skills whereId($value)
 * @method static Builder|Skills whereStatus($value)
 * @method static Builder|Skills whereTitle($value)
 * @mixin Eloquent
 */
class Skills extends Model
{
    use HasFactory;

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
