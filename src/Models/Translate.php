<?php

namespace Talanoff\ImpressionAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Translate extends Model
{
	protected $fillable = [
		'lang',
		'title',
		'description',
		'body',
		'field',
	];

	/**
	 * @return MorphTo
	 */
	public function translateble(): MorphTo
	{
		return $this->morphTo();
	}
}