<?php

namespace Database\Factories;

use App\Models\FileImport;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FileImportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'path' => $this->faker->filePath(),
            'type' => 'text/csv',
            'from_to' => null,
            'status' => FileImport::STATUS_ON_HOLD,
        ];
    }
}
