<?php

namespace App\Handlers;

use App\Models\FileImport;
use League\Csv\Reader;

class CvsHandler
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
     * @return string[]
     */
    public function getHeader(): array
    {
        $this->handler->setHeaderOffset(0);
        return $this->handler->getHeader();
    }
}
