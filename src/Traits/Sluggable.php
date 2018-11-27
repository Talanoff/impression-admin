<?php

namespace Talanoff\ImpressionAdmin\Traits;

trait Sluggable
{
    /**
     * Set key for model
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Set the proper slug attribute.
     *
     * @param string $value
     */
    public function setSlugAttribute($value)
    {
        $item = static::whereSlug($slug = str_slug($value));
        if ($item->exists()) {
            $slug = "{$slug}-" . ($item->value('id') + 1);
        }
        $this->attributes['slug'] = $slug;
    }
}
