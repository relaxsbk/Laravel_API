<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ResourceSeeder::class,
        ]);

        //Не стал выносить одного пользователя
        User::factory()->create([
            'name' => 'Pavel',
            'email' => config('seed.mail_admin'),
            'password' => Hash::make(config('seed.password')),
            'role' => RoleEnum::Admin,
        ]);
    }
}
