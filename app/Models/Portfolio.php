<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Portfolio
 *
 * @property int $id
 * @property string $file
 * @property int $status
 *
 * @method static Builder|Portfolio newModelQuery()
 * @method static Builder|Portfolio newQuery()
 * @method static Builder|Portfolio query()
 * @mixin \Eloquent
 */
class Portfolio extends Model
{
    use HasFactory;

    protected $table = 'portfolio';

    public $timestamps = false;

    protected $fillable = [
        'file',
        'status',
    ];
}
