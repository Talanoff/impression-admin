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
	public function getMedia($collection = 'uploads'): Collection
	{
		return $this->collection($collection)->get(['path'])->map(function ($image) {
			return Storage::url($image);
		});
	}

	/**
	 * @param null $collection
	 * @param null $lang
	 * @return string
	 */
	public function getFirstMedia($collection = 'uploads', $lang = null)
	{
		if (!$this->collection($collection)->first()) {
			return null;
		}
		return Storage::url($this->collection($collection)->whereLang($lang)->first()->path);
	}

	/**
	 * @param null $collection
	 * @param null $lang
	 * @return bool|string
	 */
	public function getFirstMediaName($collection = 'uploads', $lang = null)
	{
		$str = $this->collection($collection)->whereLang($lang)->first()->path;
		return substr($str, strrpos($str, '/') + 1);
	}

	/**
	 * @param null $collection
	 * @param null $lang
	 * @return string
	 */
	public function getFirstMediaId($collection = 'uploads', $lang = null)
	{
		return optional($this->collection($collection)->whereLang($lang)->first())->id;
	}

	/**
	 * @param $input_name
	 * @param string $collection
	 * @param bool $originalName
	 * @param null $lang
	 * @return Mediable
	 */
	public function addMedia($input_name, $collection = 'uploads', $originalName = false, $lang = null)
	{
		if (request()->hasFile($input_name)) {
			$file = request()->file($input_name);
			$data = [
				'collection' => $collection,
				'lang' => $lang,
			];

			if (!$originalName) {
				$data['path'] = $file->store($collection);
			} else {
				$data['path'] = $file->storeAs($collection, $file->getClientOriginalName());
			}

			$this->media()->create($data);
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
	 * @param null $lang
	 * @return bool
	 */
	public function hasMedia($collection = 'uploads', $lang = null): bool
	{
		return $this->collection($collection)->whereLang($lang)->count() > 0;
	}

	/**
	 * @param null $collection
	 * @return $this
	 */
	public function clearMedia($collection = 'uploads')
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
