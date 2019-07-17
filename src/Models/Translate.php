<?php

namespace Talanoff\ImpressionAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Translate extends Model
{
    protected $fillable = [
        'lang',
        'title',
        'content',
        'field',
    ];

    protected $casts = [
        'content' => 'array',
    ];

	/**
	 * @return MorphTo
	 */
	public function translateble(): MorphTo
	{
		return $this->morphTo();
	}
}