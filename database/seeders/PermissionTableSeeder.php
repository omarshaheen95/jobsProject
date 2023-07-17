<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

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

            'grades management',
            'applicants management',

//            'lotteries management',
//            'discrimination lotteries management',
//            'top lotteries management',
//            'governor lotteries management',
//
//            'lotteries ministries management',
//            'lotteries histories management',

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

        $role = Role::query()->updateOrCreate(
            ['guard_name' => 'manager', 'name' => 'مدير عام'],
            ['guard_name' => 'manager', 'name' => 'مدير عام']
        );

        $permissions = \Spatie\Permission\Models\Permission::query()->get()->pluck('id')->toArray();
        $role->syncPermissions($permissions);
    }
}
