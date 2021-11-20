<?php 
$request->validate([
    'title' => 'required',
    'description' => 'required',
    'content' => 'required',
    'category_id' => 'required|integer',
    'thumbnail' => 'nullable|image',
]);
