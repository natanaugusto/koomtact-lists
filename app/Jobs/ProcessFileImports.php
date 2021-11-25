<?php

namespace App\Jobs;

use App\Contracts\FileImportHandler;
use App\Models\FileImport;
use App\Models\User;
use App\Services\FileImportsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessFileImports implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected FileImport $fileImport;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(FileImport $fileImport)
    {
        $this->fileImport = $fileImport;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(FileImportsService $service)
    {
        $service->getHandlerInstance($this->fileImport)->process();
    }
}
