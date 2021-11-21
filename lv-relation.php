<?php 
// hasOne Film Model
    public function film()
    {
        return $this->hasOne(Film::class);
    }

@foreach($directors as $director)
    <li><span>{{ $director->name }}</span> - <strong>{{ $director->film->name }}</strong></li>
@endforeach
