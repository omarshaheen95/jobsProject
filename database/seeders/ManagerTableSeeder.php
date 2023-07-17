<?php

namespace Database\Seeders;

use App\Models\Manager;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class ManagerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $manager = Manager::query()->firstOrCreate([
           'email' => 'admin@gmail.com',
        ],[
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt(123456),
            'active' => 1,
        ]);

        $role = Role::query()->where('name', 'مدير عام')->first();

        if ($role) {
            $manager->assignRole($role->id);
        }

    }
}
