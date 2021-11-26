<?php

namespace App\Services;

use App\Contracts\FileImportHandler;
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
        'text/csv' => CvsHandler::class,
        'application/csv' => CvsHandler::class,
    ];
    /**
     * @var User
     */
    protected User $user;
    protected FileImport $fileImport;

    /**
     * @param User|null $user
     */
    public function __construct(User $user = null)
    {
        if (!empty($user)) {
            $this->user = $user;
        }
    }

    /**
     * Create a file importation
     * @param UploadedFile $file
     * @return FileImport
     */
    public function create(UploadedFile $file): FileImport
    {
        $fileImport = new FileImport();
        $fileImport->user_id = $this->user->id;
        // That's seems ugly
        $fileImport->path = storage_path(
            'app'
            . DIRECTORY_SEPARATOR
            . $file->store('tmp')
        );
        $fileImport->type = $file->getMimeType();
        $fileImport->status = FileImport::STATUS_ON_HOLD;
        $fileImport->save();
        $this->setFileImport($fileImport);
        return $fileImport;
    }

    /**
     * @param FileImport $fileImport
     * @return $this
     */
    public function setFileImport(FileImport $fileImport): self
    {
        $this->fileImport = $fileImport;
        return $this;
    }

    /**
     * Return a multidimensional array with the file and the model columns
     * @param string $model
     * @param ?string $hash
     * @return array ['from', 'to']
     */
    #[ArrayShape(['from' => [], 'to' => []])]
    public function getFromToColumns(string $model, ?string $hash = null): array
    {
        $hash = $hash ?? $this->fileImport->hash;
        if (!is_subclass_of($model, Model::class)) {
            throw new ModelNotFoundException("The {$model} model was not found");
        }
        $handler = $this->getHandlerByHash($hash);
        return [
            'from' => $handler->getFrom(),
            'to' => $handler->getTo(new $model),
        ];
    }

    /**
     * Return a FileImport entry based on the hash
     * @param string $hash
     * @param bool $model
     * @return FileImportHandler|Model
     */
    public function getHandlerByHash(string $hash, bool $model = false): FileImportHandler|Model
    {
        $this->setFileImport(FileImport::byHashUser($hash, $this->user)->firstOrFail());
        return $model
            ? $this->fileImport
            : $this->getHandlerInstance();
    }

    /**
     * @param FileImport|null $fileImport
     * @return FileImportHandler
     */
    public function getHandlerInstance(?FileImport $fileImport = null): FileImportHandler
    {
        $fileImport = $fileImport ?? $this->fileImport;
        return new self::$mimeTypeHandlers[$fileImport->type]($fileImport);
    }

    /**
     * @param User $user
     * @return $this
     */
    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }
}
