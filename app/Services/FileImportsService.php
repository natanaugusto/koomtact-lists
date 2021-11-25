<?php

namespace App\Services;

use App\Handlers\CvsHandler;
use App\Models\FileImport;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\UploadedFile;
use JetBrains\PhpStorm\ArrayShape;

class FileImportsService
{
    /**
     * # TODO: change that to a config file
     * @var string[] $mimeTypeHandlers
     */
    protected static array $mimeTypeHandlers = [
        'text/csv' => CvsHandler::class
    ];
    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Create a file importation
     * @param UploadedFile $file
     * @return FileImport
     */
    public function create(UploadedFile $file): FileImport
    {
        $import = new FileImport();
        $import->user_id = $this->user->id;
        $import->path = $file->store('tmp');
        $import->type = $file->getMimeType();
        $import->save();
        return $import;
    }

    /**
     * Return a multidimensional array with the file and the model columns
     * @param string $hash
     * @param string $model
     * @return array ['file', 'model']
     */
    #[ArrayShape(['file' => "object", 'model' => ""])]
    public function getFromToColumns(string $hash, string $model): array
    {
        if (!is_subclass_of($model, Model::class)) {
            throw new ModelNotFoundException("The {$model} model was not found");
        }
        return [
            'file' => $this->getByHash($hash)->getHeader(),
            'model' => (new $model)->getFillable(),
        ];
    }

    /**
     * Return a FileImport entry based on the hash
     * @param string $hash
     * @return object
     */
    public function getByHash(string $hash): object
    {
        $file = FileImport::byHashUser($hash, $this->user)->firstOrFail();
        return new self::$mimeTypeHandlers[$file->type]($file);
    }
}
