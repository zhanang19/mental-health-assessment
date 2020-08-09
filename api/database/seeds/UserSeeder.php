<?php

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
        $admin->assignRole('super-admin');

        factory(User::class, 30)->create();

        $users = User::all()->filter(fn ($data) => !$data->hasRole('admin'));

        foreach ($users as $user) {
            $user->assignRole(Arr::random(['user', 'admin']));
        }

        foreach ($users->random(18) as $user) {
            if ($user->id != 1) {
                $user->delete();
            }
        }
    }
}
