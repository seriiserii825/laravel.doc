#Users

```
$factory->define(User::class, function (Faker $faker) {
    $active = $faker->boolean();
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'verify_token' => $active ? null : Str::uuid(),
        'remember_token' => Str::random(10),
        'status' => $active ? User::STATUS_ACTIVE : User::STATUS_WAIT,
        'role' => $active ? $faker->randomElement([User::ROLE_USER, User::ROLE_ADMIN]) : User::ROLE_USER
        "worker_id" => Worker::inRandomOrder()->first()->id,
    ];
});
```

#Regions

```
$factory->define(Region::class, function (Faker $faker) {
    $name = $faker->unique()->city();
    return [
        'name' => $name,
        'slug' => Str::slug($name),
        'parent_id' => null
    ];
});
```
