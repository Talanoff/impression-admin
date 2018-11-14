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
	public function hasTranslate($field, $lang = null)
	{
		if (is_null($lang)) {
			$lang = app()->getLocale();
		}
		return !$this->translates()->whereLang($lang)->value($field)->isEmpty();
    }
}
