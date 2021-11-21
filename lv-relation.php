<?php 
// film migration
$table->foreignId('director_id')->constrained()->onDelete('cascade');

// hasOne Film Model
    public function film()
    {
        return $this->hasOne(Film::class);
    }

// director Model
    public function director()
    {
        return $this->belongsTo(Director::class);
    }

@foreach($directors as $director)
    <li><span>{{ $director->name }}</span> - <strong>{{ $director->film->name }}</strong></li>
@endforeach
