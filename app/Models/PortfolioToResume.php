<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PortfolioToResume
 *
 * @property int $id
 * @property string $file
 * @property int $resume_id
 *
 * @method static Builder|PortfolioToResume newModelQuery()
 * @method static Builder|PortfolioToResume newQuery()
 * @method static Builder|PortfolioToResume query()
 * @mixin Eloquent
 */
class PortfolioToResume extends Model
{
    use HasFactory;

    protected $table = 'portfolio_to_resume';

    public $timestamps = false;

    protected $fillable = [
        'file',
        'resume_id',
    ];
}
