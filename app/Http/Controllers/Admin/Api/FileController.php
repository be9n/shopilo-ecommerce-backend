<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Admin\Api\BaseApiController;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class FileController extends BaseApiController
{

    public function destroy(Request $request, Media $media)
    {
        $media->delete();
        return $this->successResponse('File deleted successfully');
    }
}
