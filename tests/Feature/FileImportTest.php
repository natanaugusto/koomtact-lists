<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FileImportTest extends TestCase
{
    public function test_post_file_import()
    {
        $user = User::factory()->create();
        $this->actingAs($user)
            ->post(route('file.import'))
            ->assertStatus(200);
    }
}
