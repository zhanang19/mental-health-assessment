<?php

use App\Enums\UserRoles;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Faker\Generator as Faker;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    private $faker;

    public function __construct(Faker $faker)
    {
        $this->faker = $faker;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            // 'username' => 'carlomigueldy',
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
            $user->demographicProfile()->create([
                'identification_number' => $user->id . '-' . $this->faker->randomNumber($nbDigits = NULL, $strict = false),
                'age' => $this->faker->numberBetween($min = 16, $max = 23),
                'gender' => Arr::random(['Male', 'Female']),
                'date_of_birth' => $this->faker->dateTimeBetween($startDate = '-20 years', $endDate = 'now', $timezone = null),
                'place_of_birth' => 'Secret',
                'religious_affiliation' => $this->faker->word(),
                'gpa' => Arr::random([1.0, 1.25, 1.5, 1.75, 2.0, 2.25, 2.5, 2.75, 3.0]),
                'citizenship' => $this->faker->word(),
                'ordinal_position' => $this->faker->word(),
                'currently_living_with' => $this->faker->word(),
                'city_address' => $this->faker->word(),
                'home_address' => $this->faker->word(),
                'is_scholar' => Arr::random([true, false]),
                'is_affected_marawi_siege' => Arr::random([true, false]),
                'scholarship_grant' => $this->faker->word(),
                'parents_marital_status' => $this->faker->word(),
                'family_monthly_income' => $this->faker->word(),
                'school_last_attended' => $this->faker->word(),
                'school_address' => $this->faker->word(),
            ]);

            $user->assignRole(Arr::random([UserRoles::Student, UserRoles::Administrator]));
        }

        foreach ($users->random(18) as $user) {
            if ($user->id != 1) {
                $user->delete();
            }
        }
    }
}
