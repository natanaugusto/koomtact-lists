<?php

namespace App\Contracts;

use App\Models\FileImport;
use Illuminate\Database\Eloquent\Model;

interface FileImportHandler
{

    public function __construct(FileImport $fileImport);

    public function process(): void;

    public function getFrom(): array;

    public function getTo(Model $to): array;
}
