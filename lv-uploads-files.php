<?php
$entry = scandir(public_path('uploads'));

foreach ($entry as $key => $value) {
  if ($value != "." && $value != "..") {
    $image =  Media::where('name', $value)->first();
    if (!$image) {
      Media::create([
        'name' => "$value",
        'url' => "/uploads/$value",
      ]);
    }
  }
}
