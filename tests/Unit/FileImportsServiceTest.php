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

        $fromTo = $this->service->getFromToColumns($fileImport->hash, Contact::class);
        $this->assertIsArray($fromTo['file']);
        $this->assertEquals($fromTo['file'], $this->getIncludeArray('sample_csv_header.php'));
        $this->assertIsArray($fromTo['model']);
        $this->assertEquals($fromTo['model'], (new Contact())->getFillable());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new FileImportsService(
            $this->getUser()
        );
    }
}
