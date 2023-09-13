<!-- index.blade.php ================================================== -->
<a class="btn btn-primary" href="{{route('post.show', ['post_id' => $post->id])}}">Read
more →</a>

<!-- web.php ================================================== -->
<?php
/* web.php */

Route::get('/post/{post_id}', [\App\Http\Controllers\PostController::class, 'show'])->name('post.show');
?>

<!-- PostController.php ================================================== -->
<?php
public function show($post_id)
{
    $post = Post::findOrFail($post_id);
    return view('post', compact('post'));
}
?>

<!-- post.blade.php ================================================== -->
<div class="text-center my-5">
    <h1 class="fw-bolder">{{$post->title}}</h1>
</div>
