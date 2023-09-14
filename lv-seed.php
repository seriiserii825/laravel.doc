<?php 
#Regions
factory(Region::class, 10)->create()->each(function (Region $region) {
   $region->children()->saveMany(factory(Region::class, random_int(3, 10))->create()->each(function (Region $region) {
       $region->children()->saveMany(factory(Region::class, random_int(3, 10))->make());
   }));
});

#UserFactory
factory(User::class, 10)->create();

# user migration
# 2023_09_14_053610_add_is_admin_to_users_table.php
Schema::table('users', function (Blueprint $table) {
    $table->boolean("is_admin")->default(false);
});

#DatabaseSeeder
// create 10 users by default
User::factory(10)->create();
// create 1 user as admin
$this->call(AdminSeeder::class);

#AdminSeeder
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(1)->create(["is_admin" => true]);
    }
}
