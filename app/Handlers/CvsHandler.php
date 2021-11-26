<?php

namespace App\Handlers;

use App\Contracts\FileImportHandler;
use App\Contracts\Validatable;
use App\Models\FileImport;
use App\Models\FileImportLog;
use Illuminate\Support\Facades\Validator;
use League\Csv\Exception;
use League\Csv\Reader;

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

    /**
     * @return array
     * @throws Exception
     */
    public function getFrom(): array
    {
        $this->handler->setHeaderOffset(0);
        return $this->handler->getHeader();
    }

    /**
     * @param object $to
     * @return array
     */
    public function getTo(object $to): array
    {
        return $to->getFillable();
    }

    /**
     * Process
     * @param string $to
     * @throws \Exception
     */
    public function process(string $to): void
    {
        $fromTo = $this->fileImport->from_to;
        if (empty($fromTo)) {
            throw new \Exception('The File Cannot be imported cause the from_to columns is empty');
        }
        if ($this->fileImport->status !== FileImport::STATUS_ON_HOLD) {
            return;
        }
        $this->fileImport->switchProcessing();

        try {
            foreach ($this->handler->getRecords($this->getFrom()) as $record) {
                $this->insert($record, $to, $fromTo);
            }
            $this->fileImport->switchFinished();
        } catch (\Throwable $e) {
            $this->fileImport->switchFailed();
            $this->registerLog(['message' => $e->getMessage()], get_class($e));
        }
    }

    /**
     * Create a new register
     * @param mixed $record
     * @param string $class
     * @param array $fromTo
     */
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

    /**
     * Register log
     * @param array $log
     * @param string $exception
     */
    protected function registerLog(array $log, string $exception): void
    {
        $logImport = new FileImportLog();
        $logImport->file_import_id = $this->fileImport->id;
        $logImport->log = $log;
        $logImport->exception = $exception;
        $logImport->save();
    }
}
