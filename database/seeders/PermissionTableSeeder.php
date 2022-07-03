<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'general statistics',
            'users management',
            'news management',
            'jobs offers management',
            'governorates management',
            'degrees management',
            'sub degrees management',
            'qualifications management',
            'appreciations management',
            'disabilities management',
            'ministries management',
            'positions management',
            'languages management',
            'external links management',
            'countries management',
            'contact us management',
            'general settings management',
            'pages management',
            'managers management',
            'permissions management',
        ];

        foreach ($permissions as $permission)
        {
                \Spatie\Permission\Models\Permission::query()
                    ->updateOrCreate(['name' => $permission, 'guard_name' => 'manager']);
        }
    }
}
