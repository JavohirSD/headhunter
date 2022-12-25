<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LanguagesToResume
 *
 * @method static Builder|LanguagesToResume newModelQuery()
 * @method static Builder|LanguagesToResume newQuery()
 * @method static Builder|LanguagesToResume query()
 * @mixin Eloquent
 */
class LanguagesToResume extends Model
{
    use HasFactory;

    protected $table = 'languages_to_resume';

    public $timestamps = false;

    protected $fillable = [
        'language_id',
        'resume_id',
    ];
}
