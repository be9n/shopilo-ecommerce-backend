<?php

declare(strict_types=1);

namespace App\Http\Services\Admin;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Exceptions\ModelAbilityException;

class MediaService
{
    /**
     * Delete media with model-specific validation
     *
     * @param Media $media
     * @return bool
     * @throws ModelAbilityException
     */
    public function delete(Media $media): bool
    {
        // Get the related model
        $model = $media->model;
        if (!$model) {
            // If no model attached, we can safely delete
            return $this->performDelete($media);
        }

        // Check if this media can be deleted
        $model->ensureAbility('canDeleteMedia', $media);

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