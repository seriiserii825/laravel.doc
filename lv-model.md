### model info
```
php artisan model:show User
```

### make Model

```
php artisan make:model Car -mcr // migration controller resource
php artisan make:model Car -mcr --api // migration api-controller resource
php artisan make:model Car -mcr -R // migration controller  request
php artisan make:model Car -fs // factory seeder
php artisan make:model Car -a // all

```

### plural

```
php artisan make:model ProjectsType
//projects_types
//in phpmyadmin will be after projects table
```

### Fillable Guarded
```
// to guarded add just fields that don't need to be fillable

//To view errors in laravel 9.4 add to AppServiceProvider
public function boot(){
    Model::shouldBeStrict(!app()->environment('production'));
}

// will fill all fields
$user = new User();
$user->name = fake()->name();
$user->email = fake()->email();

// will fill fields just in fillable User model
User::create([
    'name' => fake()->name(),
    'email' => fake()->email(),
])
```

### relations

```
    public function parent()
    {
        return $this->belongsTo(static::class, 'parent_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(static::class, 'parent_id', 'id');
    }


```
