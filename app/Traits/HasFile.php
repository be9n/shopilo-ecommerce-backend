<?php

namespace App\Traits;
use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\InteractsWithMedia;

trait HasFile
{
    use InteractsWithMedia;

    /**
     * Delete the first file from the collection if it exists
     * @param string $collection
     * @return void
     */
    public function deleteFirstFileFromCollectionIfExisted(string $collection): void
    {
        if ($file = $this->getFirstMedia($collection)) {
            $file->delete();
        }
    }

    /**
     * Update the file in the collection by deleting the old file and storing the new one
     * @param UploadedFile $newFile
     * @param string $collection
     * @return void
     */
    public function updateFile(UploadedFile $newFile, string $collection = 'images'): void
    {
        $this->deleteFirstFileFromCollectionIfExisted($collection);
        $this->storeFile($newFile, $collection);
    }

    /**
     * Store a file in the collection
     * @param UploadedFile $file
     * @param string $collection
     * @return void
     */
    public function storeFile(UploadedFile $file, string $collection = 'images'): void
    {
        $this->addMedia($file)->toMediaCollection($collection);
    }

    /**
     * Store multiple files in the collection
     * @param array $files
     * @param string $collection
     * @return void
     */
    public function storeMultipleFiles(array $files, string $collection = 'images'): void
    {
        foreach ($files as $file) {
            $this->storeFile($file, $collection);
        }
    }

    /**
     * Store a file in the collection and preserve the original file
     * @param UploadedFile $file
     * @param string $collection
     * @return void
     */
    public function storeFileWithPreserving(UploadedFile $file, string $collection = 'images'): void
    {
        $this->addMedia($file)->preservingOriginal()->toMediaCollection($collection);
    }

    /**
     * Store multiple files in the collection and preserve the original files
     * @param array $files
     * @param string $collection
     * @return void
     */
    public function storeMultipleFilesWithPreserving(array $files, string $collection = 'images'): void
    {
        foreach ($files as $file) {
            $this->storeFileWithPreserving($file, $collection);
        }
    }
}
