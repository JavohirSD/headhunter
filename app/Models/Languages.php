<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Languages
 *
 * @property int $id
 * @property string $language
 * @method static Builder|Languages newModelQuery()
 * @method static Builder|Languages newQuery()
 * @method static Builder|Languages query()
 * @method static Builder|Languages whereId($value)
 * @method static Builder|Languages whereLanguage($value)
 * @mixin Eloquent
 */
class Languages extends Model
{
    use HasFactory;

    protected $table = 'languages';

    public $timestamps = false;

    protected $fillable = [
        'language'
    ];
}
