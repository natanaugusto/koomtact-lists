<?php

namespace Tests\Feature;

use App\Models\FileImport;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Tests\TestCase;
use Tests\Traits\SampleFilesTrait;
use Tests\Traits\UserTrait;

class FileImportTest extends TestCase
{
    use RefreshDatabase, SampleFilesTrait, UserTrait;

    public function test_post_file_import()
    {
        $response = $this->actingAs($this->getUser())
            ->post(route('file.import'), [
                'file' => $this->getUploadedFake('sample.csv'),
            ]);

        $response->assertStatus(SymfonyResponse::HTTP_FOUND)
            ->assertLocation(route(
                'file.from-to',
                ['hash' => FileImport::latest()->first()->hash]
            ));
    }

    public function test_get_from_to()
    {
        $fileImport = FileImport::factory()->create([
            'user_id' => $this->getUser()->id,
            'path' => $this->getPath('sample.csv')
        ]);
        $response = $this->actingAs($this->getUser())
            ->get(route(
                'file.from-to',
                ['hash' => $fileImport->hash]
            ));
        $response->assertStatus(SymfonyResponse::HTTP_OK);
    }

    public function test_store_from_to()
    {
        $fileImport = FileImport::factory()->create([
            'user_id' => $this->getUser()->id,
            'path' => $this->getPath('sample.csv'),
        ]);
        $post = $this->getIncludeArray('sample_from_to.php');
        $response = $this->actingAs($this->getUser())
            ->put(route(
                'file.from-to',
                ['hash' => $fileImport->hash]
            ), $post);
        $response->assertStatus(SymfonyResponse::HTTP_CREATED);
    }
}
