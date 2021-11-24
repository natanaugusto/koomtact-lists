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

    public function test_post_file_import()
    {
        $user = User::factory()->create();
        $content = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'sample.csv');
        $response = $this->actingAs($user)
            ->post(route('file.import'), [
                'file' => UploadedFile::fake()->createWithContent('test.csv', $content),
            ]);

        $response->assertStatus(SymfonyResponse::HTTP_FOUND)
            ->assertLocation(route(
                'file.from-to',
                ['hash' => FileImport::latest()->first()->hash]
            ));
    }
}
