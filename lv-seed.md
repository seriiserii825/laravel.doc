#Regions
factory(Region::class, 10)->create()->each(function (Region $region) {
   $region->children()->saveMany(factory(Region::class, random_int(3, 10))->create()->each(function (Region $region) {
       $region->children()->saveMany(factory(Region::class, random_int(3, 10))->make());
   }));
});

#Users
factory(User::class, 10)->create();

#DatabaseSeeder
$this->call(RegionsTableSeeder::class);
