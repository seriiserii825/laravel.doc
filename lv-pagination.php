<?php 
//controller
$posts = Post::query()->paginate(3);

//template
{{ $posts->links()  }}

//template search
{{ $posts->appends(['s'=>request()])->links()  }}

