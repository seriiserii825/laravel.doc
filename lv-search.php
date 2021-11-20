<?
//controller
$request->validate([
's' => 'required'
]);

$s = $request->s;

$posts = Posts::query()->where('title', 'LIKE', '%$s%')->with('category')->paginate(2);
return view('posts.search', compact('posts', 's'));
