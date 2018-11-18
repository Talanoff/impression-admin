<?php

namespace Talanoff\ImpressionAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Media extends Model
{
    protected $fillable = [
        'path',
        'collection',
    ];

    /**
     * @return MorphTo
     */
    public function mediable(): MorphTo
    {
        return $this->morphTo();
    }
}
