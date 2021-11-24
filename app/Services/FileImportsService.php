<?php

namespace App\Services;

use App\Models\FileImport;
use App\Models\User;
use Illuminate\Http\UploadedFile;

abstract class FileImportsService
{
    /**
     * # TODO: change that to a config file
     * @var string[] $mimeTypeHandlers
     */
    public static $mimeTypeHandlers = [
        'text/csv' => \App\Handlers\CvsHandler::class
    ];

    /**
     * Create a file importation
     * @param UploadedFile $file
     * @param User $user
     * @return FileImport
     */
    public static function create(UploadedFile $file, User $user): FileImport
    {
        $import = new FileImport();
        $import->user_id = $user->id;
        $import->path = $file->store('tmp');
        $import->handler = self::identifyHandler($file);
        $import->save();
        return $import;
    }

    /**
     * Get the right handler to the mime type
     * @param UploadedFile $file
     * @return string
     */
    protected static function identifyHandler(UploadedFile $file): string
    {
        return self::$mimeTypeHandlers[$file->getMimeType()];
    }
}
