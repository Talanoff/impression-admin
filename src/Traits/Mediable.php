<?php

namespace Talanoff\ImpressionAdmin\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Storage;
use Talanoff\ImpressionAdmin\Models\Media;

trait Mediable
{
	/**
	 * @return MorphMany
	 */
	public function media(): MorphMany
	{
		return $this->morphMany(Media::class, 'mediable');
	}

	/**
	 * @param null $collection
	 * @return Collection
	 */
	public function getMedia($collection = null): Collection
	{
		return $this->collection($collection)->get(['path'])->map(function ($image) {
			return Storage::url($image);
		});
	}

	/**
	 * @param null $collection
	 * @return string
	 */
	public function getFirstMedia($collection = null)
	{
		return Storage::url($this->collection($collection)->first(['path'])->path);
	}

	/**
	 * @param null $collection
	 * @return string
	 */
	public function getFirstMediaId($collection = null)
	{
		return optional($this->collection($collection)->first())->id;
	}

	/**
	 * @param $input_name
	 * @param string $collection
	 * @return Mediable
	 */
	public function addMedia($input_name, $collection = 'uploads')
	{
		if (request()->hasFile($input_name)) {
			$this->media()->create([
				'path' => request()->file($input_name)->store($collection),
				'collection' => $collection,
			]);
		}
		return $this;
	}

	/**
	 * @param null $collection
	 * @return bool
	 */
	public function hasMedia($collection = null): bool
	{
		return $this->collection($collection)->count() > 0;
	}

	/**
	 * @param null $collection
	 * @return $this
	 */
	public function clearCollection($collection = null)
	{
		$files = $this->collection($collection)->pluck('path')->all();
		if (count($files)) {
			Storage::delete($files);
		}
		$this->collection($collection)->delete();
		return $this;
	}

	public function removeMedia()
	{
		Storage::delete($this->pluck('path')->all());
		$this->delete();
		return $this;
	}

	/**
	 * @param $collection
	 * @return MorphMany
	 */
	private function collection($collection): MorphMany
	{
		$media = $this->media();
		if ($collection) {
			$media = $media->whereCollection($collection);
		}
		return $media;
	}
}
