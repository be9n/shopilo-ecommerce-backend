<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Exceptions\MediaDeletionException;

class MediaService
{
    /**
     * Delete media with model-specific validation
     *
     * @param Media $media
     * @return bool
     * @throws MediaDeletionException
     */
    public function delete(Media $media): bool
    {
        // Get the related model
        $model = $media->model;

        if (!$model) {
            // If no model attached, we can safely delete
            return $this->performDelete($media);
        }

        // Check if the model has media deletion rules
        if (method_exists($model, 'canDeleteMedia')) {
            if (!$model->canDeleteMedia($media)) {
                throw new MediaDeletionException('Media cannot be deleted due to model-specific rules.');
            }
        }

        return $this->performDelete($media);
    }

    /**
     * Perform the actual deletion
     *
     * @param Media $media
     * @return bool
     */
    protected function performDelete(Media $media): bool
    {
        return $media->delete();
    }
}