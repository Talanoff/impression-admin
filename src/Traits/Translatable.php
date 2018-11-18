<?php

namespace Talanoff\ImpressionAdmin\Traits;

use App\Models\Translate;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Translatable
{
    /**
     * Get all translates
     * @return MorphMany
     */
    public function translates(): MorphMany
    {
        return $this->morphMany(Translate::class, 'translatable');
    }

    /**
     * @param $field
     * @param string $lang
     * @return string
     */
    public function translate($field, $lang = null): string
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
	 * @param $langs
	 * @return $this
	 */
	public function makeTranslation($langs)
	{
		foreach ($langs as $lang) {
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
	 * @param $langs
	 * @return $this
	 */
	public function updateTranslation($langs)
	{
		foreach ($langs as $lang) {
			$this->translates()->whereLang($lang)->update([
				'title' => request($lang)['title'],
				'description' => request($lang)['description'] ?? null,
				'body' => request($lang)['body'] ?? null,
			]);
		}
		return $this;
    }
}
