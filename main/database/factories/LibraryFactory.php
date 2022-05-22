<?php

namespace Database\Factories;

use App\Enum\AddressCityEnum;
use App\Models\Library;
use Illuminate\Database\Eloquent\Factories\Factory;

class LibraryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    protected $model = Library::class;

    public function definition()
    {
        return [
            'name' => $this->faker->title,
            'city' => AddressCityEnum::cases()[rand(0,2)]->value
            // 'email' => $this->faker->unique()->safeEmail(),
            // 'email_verified_at' => now(),
            // 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            // 'remember_token' => Str::random(10),
        ];
    }
}
