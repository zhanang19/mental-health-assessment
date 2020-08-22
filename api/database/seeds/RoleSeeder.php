<?php

use App\Enums\UserRoles;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $userManagement = [
            'create user',
            'read user',
            'update user',
            'delete user',
            'archive user',
            'restore user'
        ];

        $permissions = Arr::collapse([
            $userManagement,
        ]);

        foreach ($permissions as $key => $value) {
            Permission::create([
                'name' => $value
            ]);
        }

        $superadmin = Role::create([ 'name' => UserRoles::SuperAdministrator ]);
        $admin = Role::create([ 'name' => UserRoles::Administrator ]);
        $student = Role::create([ 'name' => UserRoles::Student ]);

        $superadmin->givePermissionTo(Permission::all());
        $admin->givePermissionTo(Permission::all());
        $student->givePermissionTo(Permission::get()
            ->filter(fn($data) => strpos($data->name, UserRoles::Student) == false)
        );
    }
}
