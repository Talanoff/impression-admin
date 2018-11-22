<?php

namespace Talanoff\ImpressionAdmin\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\File;
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
		if (!$this->collection($collection)->first()) {
			return null;
		}
		return Storage::url($this->collection($collection)->first()->path);
	}

	public function getFirstMediaName($collection = null)
	{
		$str = $this->collection($collection)->first()->path;
		return substr($str, strrpos($str, '/') + 1);
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
	public function addMedia($input_name, $collection = 'uploads', $originalName = false)
	{
		if (request()->hasFile($input_name)) {
			if (!$originalName) {
				$this->media()->create([
					'path' => request()->file($input_name)->store($collection),
					'collection' => $collection,
				]);
			} else {
				$this->media()->create([
					'path' => request()->file($input_name)->storeAs($collection, request()->file($input_name)->getClientOriginalName()),
					'collection' => $collection,
				]);
			}
		}
		return $this;
	}

	/**
	 * @param string $file_path
	 * @param string $collection
	 * @return mixed
	 */
	public function storeMedia($file_path, $collection = 'uploads')
	{
		$image = Storage::putFile($collection, new File($file_path));
		Storage::delete('mediatemp' . substr($file_path, strrpos($file_path, '/')));
		return $image;
	}

	/**
	 * @return $this
	 */
	public function removeMedia()
	{
		Storage::delete($this->path);
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
	public function clearMedia($collection = null)
	{
		$files = $this->collection($collection)->pluck('path')->all();
		if (count($files)) {
			Storage::delete($files);
		}
		$this->collection($collection)->delete();
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
