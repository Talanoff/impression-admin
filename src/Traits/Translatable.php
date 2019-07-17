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
		return $this->morphMany(config('ib-admin.translatable_class'), 'translatable');
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
            $attrs = [
                'lang' => $lang,
                'title' => request($lang)['title'],
            ];

            if (isset(request($lang)['content'])) {
                foreach (request($lang)['content'] as $key => $data) {
                    $attrs['content'][$key] = $data;
                }
            }

            $this->translates()->create($attrs);
        }
        return $this;
    }

    /**
     * @return $this
     */
    public function updateTranslation()
    {
        foreach (config('app.locales') as $lang) {
            $attrs = [
                'title' => request($lang)['title'],
            ];

            if (isset(request($lang)['content'])) {
                foreach (request($lang)['content'] as $key => $data) {
                    $attrs['content'][$key] = $data;
                }
            }

            $this->translates()->updateOrCreate([
                'lang' => $lang,
            ], $attrs);
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitleAttribute()
    {
        return $this->translate('title');
    }

    /**
     * @return mixed
     */
    public function getContentAttribute()
    {
        return (object)$this->translate('content');
    }
}
