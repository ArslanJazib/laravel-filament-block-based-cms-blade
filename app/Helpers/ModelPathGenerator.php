<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ModelPathGenerator implements PathGenerator
{
    public function getPath(Media $media): string
    {
        $model = class_basename($media->model_type);
        $model = Str::plural(Str::kebab($model));
        return "{$model}/{$media->model_id}/";
    }

    public function getPathForConversions(Media $media): string
    {
        return $this->getPath($media) . 'conversions/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getPath($media) . 'responsive/';
    }
}
