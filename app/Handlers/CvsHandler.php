<?php

namespace App\Handlers;

use App\Contracts\FileImportHandler;
use App\Contracts\Validatable;
use App\Models\FileImport;
use App\Models\FileImportLog;
use Illuminate\Support\Facades\Validator;
use League\Csv\Reader;
use Symfony\Component\Process\Exception\ProcessFailedException;

class CvsHandler implements FileImportHandler
{
    /**
     * @var FileImport $fileImport
     */
    protected FileImport $fileImport;

    /**
     * @var Reader $handler
     */
    protected Reader $handler;

    /**
     * @param FileImport $fileImport
     */
    public function __construct(FileImport $fileImport)
    {
        $this->fileImport = $fileImport;
        $this->handler = Reader::createFromPath($this->fileImport->path);
    }

    public function getFrom(): array
    {
        $this->handler->setHeaderOffset(0);
        return $this->handler->getHeader();
    }

    public function getTo(object $to): array
    {
        return $to->getFillable();
    }

    public function process(string $to): void
    {
        $fromTo = $this->fileImport->from_to;
        if (empty($fromTo)) {
            throw new \Exception('The File Cannot be imported cause the from_to columns is empty');
        }

        foreach ($this->handler->getRecords($this->getFrom()) as $record) {
            $this->insert($record, $to, $fromTo);
        }
    }

    private function insert(mixed $record, string $class, array $fromTo): void
    {
        $register = new $class();
        $register->user_id = $this->fileImport->user->id;
        foreach ($fromTo as $to => $from) {
            if (!empty($record[$from])) {
                $register->{$to} = trim($record[$from]);
            }
        }
        if (in_array(Validatable::class, class_implements($register))) {
            $validator = Validator::make($register->toArray(), $register::rules());
            if ($validator->fails()) {
                $this->registerLog(
                    $validator->getMessageBag()->toArray(),
                    get_class($validator->getMessageBag())
                );
            }
        }
        try {
            $register->save();
        } catch (\Throwable $e) {
            $this->registerLog(['message' => $e->getMessage()], get_class($e));
        }
    }

    protected function registerLog(array $log, string $exception): void
    {
        $logImport = new FileImportLog();
        $logImport->file_import_id = $this->fileImport->id;
        $logImport->log = $log;
        $logImport->exception = $exception;
        $logImport->save();
    }
}
