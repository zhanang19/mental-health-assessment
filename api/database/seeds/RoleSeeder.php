<?php

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

        $parentManagement = [
            'create parent',
            'read parent',
            'update parent',
            'delete parent',
            'archive parent',
            'restore parent'
        ];

        $childManagement = [
            'create child',
            'read child',
            'update child',
            'delete child',
            'archive child',
            'restore child'
        ];

        $employeeManagement = [
            'create employee',
            'read employee',
            'update employee',
            'delete employee',
            'archive employee',
            'restore employee'
        ];

        $facilityManagement = [
            'create daycare facility',
            'read daycare facility',
            'update daycare facility',
            'delete daycare facility',
            'archive daycare facility',
            'restore daycare facility'
        ];

        $expensesManagement = [
            'create expenses',
            'read expenses',
            'update expenses',
            'delete expenses',
            'archive expenses',
            'restore expenses'
        ];

        $paymentManagement = [
            'create payment',
            'read payment',
            'update payment',
            'delete payment',
            'archive payment',
            'restore payment'
        ];

        $permissions = Arr::collapse([
            $userManagement,
            $parentManagement,
            $childManagement,
            $employeeManagement,
            $facilityManagement,
            $expensesManagement,
            $paymentManagement
        ]);

        foreach ($permissions as $key => $value) {
            Permission::create([
                'name' => $value
            ]);
        }

        $superadmin = Role::create([ 'name' => 'super-admin' ]);
        $admin = Role::create([ 'name' => 'admin' ]);
        $user = Role::create([ 'name' => 'user' ]);

        $superadmin->givePermissionTo(Permission::all());
        $admin->givePermissionTo(Permission::all());
        $user->givePermissionTo(Permission::get()
            ->filter(fn($data) => strpos($data->name, 'user') == false)
        );
    }
}
