<?php

namespace Talanoff\ImpressionAdmin\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Translatable
{
	/**
	 * Get all translates
	 * @return MorphMany
	 */
	public function translates(): MorphMany
	{
		return $this->morphMany(config('impression-admin.translatable_class'), 'translatable');
	}

	/**
	 * @param $field
	 * @param null $lang
	 * @return mixed
	 */
	public function translate($field, $lang = null)
	{
		if (is_null($lang)) {
			$lang = app()->getLocale();
		}
		return $this->translates()->whereLang($lang)->value($field);
	}

	/**
	 * @param $field
	 * @param null $lang
	 * @return bool
	 */
	public function hasTranslation($field, $lang = null): bool
	{
		if (is_null($lang)) {
			$lang = app()->getLocale();
		}
		return !is_null($this->translates()->whereLang($lang)->value($field));
	}

	/**
	 * @return $this
	 */
	public function makeTranslation()
	{
		foreach (config('app.locales') as $lang) {
			$this->translates()->create([
				'lang' => $lang,
				'title' => request($lang)['title'],
				'description' => request($lang)['description'] ?? null,
				'body' => request($lang)['body'] ?? null,
			]);
		}
		return $this;
	}

	/**
	 * @return $this
	 */
	public function updateTranslation()
	{
		foreach (config('app.locales') as $lang) {
			$this->translates()->whereLang($lang)->update([
				'title' => request($lang)['title'],
				'description' => request($lang)['description'] ?? null,
				'body' => request($lang)['body'] ?? null,
			]);
		}
		return $this;
	}

	/**
	 * @return string
	 */
	public function getTitleAttribute(): string
	{
		return $this->translate('title');
	}

	/**
	 * @return mixed
	 */
	public function getDescriptionAttribute()
	{
		return $this->translate('description');
	}

	/**
	 * @return mixed
	 */
	public function getBodyAttribute()
	{
		return $this->translate('body');
	}
}
