<?php 
// director Factory
    public function definition()
    {
        return [
            'name' => $this->faker->name
        ];
    }
//seeders/DatabaseSeeders
 Director::factory(30)->create();

// film Factory
        return [
            'name' => $this->faker->name,
            'director_id' => $this->faker->unique()->numberBetween(1, 30)
        ];
//seeders/DatabaseSeeders
Film::factory(30)->create();


//console
php artisan db:seed

#====== version 2
$factory->define(\App\Category::class, function (Faker $faker) {
    return [
       'title' => $faker->name
    ];
});

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        factory('App\Category', 30)->create();
    }
}


