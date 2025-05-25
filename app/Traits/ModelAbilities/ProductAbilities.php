<?php

namespace App\Traits\ModelAbilities;

use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait ProductAbilities
{
    use BaseAbilities;
    public function canDeleteMedia(Media $media): array
    {
        $mediaCount = $this->getMedia($media->collection_name)->count();
        if ($mediaCount <= 1) {
            return $this->abilityFail(__('You cannot delete the only media for this product'));
        }

        return $this->abilitySuccess();
    }
}