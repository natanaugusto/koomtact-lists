<?php

namespace Tests\Feature;

use App\Models\FileImport;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Tests\TestCase;

class FileImportTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    public function test_post_file_import()
    {
        $content = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'sample.csv');
        $response = $this->actingAs($this->user)
            ->post(route('file.import'), [
                'file' => UploadedFile::fake()->createWithContent('test.csv', $content),
            ]);

        $response->assertStatus(SymfonyResponse::HTTP_FOUND)
            ->assertLocation(route(
                'file.from-to',
                ['hash' => FileImport::latest()->first()->hash]
            ));
    }

    public function test_get_from_to()
    {
        $file = FileImport::factory()->create();
        $response = $this->actingAs($this->user)
            ->get(route(
                'file.from-to',
                ['hash' => $file->hash]
            ));
        $response->assertStatus(SymfonyResponse::HTTP_OK);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }
}
