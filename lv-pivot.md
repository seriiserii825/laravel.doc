### Methods

```
attach - add to table, also duplicate
detach - delete from table
toggle - add or remove if exists
sync - delete all except current
```

### unique fields
```
Schema::create('project_workers', function (Blueprint $table) {
    $table->id();
    $table->foreignId('project_id')->constrained('projects');
    $table->foreignId('worker_id')->constrained('workers');
    $table->unique(['project_id', 'worker_id']);
    $table->timestamps();
});
```

### attach

```
$project = Project::find(2);
$worker = Worker::find(1);
$worker->projects()->attach($project->id);
dd($project->toArray(), $worker->toArray(), $project->workers->pluck('name')->toArray());
```
