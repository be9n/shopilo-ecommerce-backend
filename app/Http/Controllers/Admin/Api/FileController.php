<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Admin\Api\BaseApiController;
use App\Exceptions\MediaDeletionException;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class FileController extends BaseApiController
{
    /**
     * @var MediaService
     */
    protected MediaService $mediaService;

    /**
     * FileController constructor.
     *
     * @param MediaService $mediaService
     */
    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    /**
     * Delete a media file
     *
     * @param Request $request
     * @param Media $media
     * @return JsonResponse
     */
    public function destroy(Request $request, Media $media): JsonResponse
    {
        try {
            $this->mediaService->delete($media);
            return $this->successResponse('File deleted successfully');
        } catch (MediaDeletionException $e) {
            return $this->failResponse($e->getMessage());
        }
    }
}
