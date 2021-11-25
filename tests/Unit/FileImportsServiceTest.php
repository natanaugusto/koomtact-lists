<?php

namespace Tests\Unit;

use App\Models\Contact;
use App\Models\FileImport;
use App\Services\FileImportsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\SampleFilesTrait;
use Tests\Traits\UserTrait;

class FileImportsServiceTest extends TestCase
{
    use RefreshDatabase, SampleFilesTrait, UserTrait;

    protected FileImportsService $service;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_create()
    {
        $this->assertInstanceOf(FileImport::class, $this->service->create(
            $this->getUploadedFake('sample.csv')
        ));
    }

    public function test_from_to_columns()
    {
        $fileImport = FileImport::factory()->create([
            'user_id' => $this->getUser()->id,
            'path' => $this->getPath('sample.csv')
        ]);

        // Another approach
        // $fromTo = $this->service->getFromToColumns(Contact::class, $fileImport->hash);
        $fromTo = $this->service
            ->setFileImport($fileImport)
            ->getFromToColumns(Contact::class);
        $this->assertIsArray($fromTo['from']);
        $this->assertEquals($fromTo['from'], $this->getIncludeArray('sample_csv_header.php'));
        $this->assertIsArray($fromTo['to']);
        $this->assertEquals($fromTo['to'], (new Contact())->getFillable());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new FileImportsService(
            $this->getUser()
        );
    }
}
