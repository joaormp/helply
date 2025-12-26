<?php

namespace Database\Seeders;

use App\Models\Central\CentralUser;
use Illuminate\Database\Seeder;

class CentralUserSeeder extends Seeder
{
    public function run(): void
    {
        CentralUser::create([
            'name' => 'João Panoias',
            'email' => 'joaopanoias@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Admin de desenvolvimento
        if (app()->environment('local')) {
            CentralUser::create([
                'name' => 'Admin Dev',
                'email' => 'admin@helply.test',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]);
        }
    }
}
