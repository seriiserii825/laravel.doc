<?php 
// foreign keys
$table->tinyInteger('category_id')->unsigned()->default(1);
$table->foreign('category_id')->references('id')->on('categories');
