<?php

namespace App\Handlers;

use App\Contracts\FileImportHandler;
use App\Models\FileImport;
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

    public function getFrom(): array
    {
        $this->handler->setHeaderOffset(0);
        return $this->handler->getHeader();
    }

    public function getTo(object $to): array
    {
        return $to->getFillable();
    }

    public function process(): void
    {
        // TODO: Implement process() method.
    }
}
