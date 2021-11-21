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
