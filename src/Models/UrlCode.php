<?php

namespace Kulinich\Hillel\Models;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin EloquentBuilder
 * @property int $id
 * @property string $code
 * @property string $url
 * @property string $updated_at
 * @property string $created_at
 */
class UrlCode extends Model
{
    protected $table = 'url_codes';
    protected $fillable = [
        'code',
        'url',
    ];
}