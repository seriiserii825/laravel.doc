#============== Create user and project migration
<?php
//user
$table->id();
$table->string('name');
$table->string('email')->unique();
$table->string('password');
$table->timestamps;

//project
$table->id();
$table->string('name');
$table->timestamps;

//project_user -> by alphabet, start "p" adn after "u", and need to be in singular
Schema::create('project_user');
$table->foreign_id('project_id')->constrained();
$table->foreign_id('user_id')->constrained();

if(
  Schema::create('projects_users');
  $table->foreign_id('projects_id')->constrained();
  $table->foreign_id('users_id')->constrained();
  ){
  public function users(){
    return $this->belongsTo(User::class, 'projects_users', 'projects_id', 'users_id');
  }
}
?>
## Models
<?php 
//Project

public function users(){
  return $this->belongsTo(User::class);
}

?>

## Seeders
<?php 

public function run(){
  factory(Project::class, 10)->create();

  foreach(Project::all() as $project){
    $users = User::inRandomOrder()->take(rand(1,3))->pluck('id');
    $project->users()->attach($users);
  }
}

?>

## HomeController
<?php 

public function index(){
  $projects = Project::with('users')->get();
  return view('index', compact('projects')); 
}
?>

#====================== Add timestamps
<?php 
  //In migration
  $table->foreign_id('project_id')->constrained();
  $table->foreign_id('user_id')->constrained();
  $table->timestamps();

  // In Project model
  public function users(){
    return $this->belongsTo(User::class)->withTimestamps();
  }

?>
## in blade show created_at
<?php 
  foreach($project->users as $user){
    <div>{{$user->name}} ({{$user->pivot->created_at}})</div>
  }
?>

#===================== Add is_manager
<?php
  // In migration
  $table->foreign_id('project_id')->constrained();
  $table->foreign_id('user_id')->constrained();
  $table->timestamps();
  $table->boolean('is_manager')->default(false);

  // In Project model
  public function users(){
    return $this->belongsTo(User::class)->withTimestamps()->withPivot(['is_manager']);
  }

  //Seeders
public function run(){
  factory(Project::class, 10)->create();

  foreach(Project::all() as $project){
    $users = User::inRandomOrder()->take(rand(1,3))->pluck('id');
    foreach($users as $user){
      $project->users()->attach($user, ['is_manager' => rand(0,1)]);
    }
  }
}
//Blade
foreach($project->users as $user){
  <div>{{$user->name}} ({{$user->pivot->is_manager}})</div>
  }
?>
