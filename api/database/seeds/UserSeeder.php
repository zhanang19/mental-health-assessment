<?php

use App\Enums\UserRoles;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'username' => 'carlomigueldy',
            'first_name' => 'Carlo Miguel',
            'last_name' => 'Dy',
            'is_active' => true,
            'email' => 'admin@admin.com',
            'password' => 'password'
        ]);

        // $admin->assignRole(Role::where('name', 'admin')->first());
        $admin->assignRole(UserRoles::SuperAdministrator);

        factory(User::class, 30)->create();

        $users = User::all()->filter(fn ($data) => !$data->hasRole(UserRoles::Administrator));

        foreach ($users as $user) {
            $user->assignRole(Arr::random([UserRoles::Student, UserRoles::Administrator]));
        }

        foreach ($users->random(18) as $user) {
            if ($user->id != 1) {
                $user->delete();
            }
        }
    }
}
