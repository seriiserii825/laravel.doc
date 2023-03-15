<?php
# migration
$table->softDeletes();

# model
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
  use SoftDeletes;
  protected $dates = ['deleted_at'];
}

# delete
when $model->delete() //- will be soft deletes

# get posts with deleted
App\Post::withTrashed()->get();

# with just soft deleted
App\Post::onlyTrashed()->get();

# non soft deleted
App\Post::withoutTrashed()->get();

# restore softDeletes 
$post = App\Post::withTrashed()->whereId(2)->restore();

# permamently delete
App\Post::onlyTrashed()->forceDelete();
