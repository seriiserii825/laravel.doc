<?php
// В yield указываем название секции, где оно будет расположенно в layout, а в section, содержание
@yield('content')

@section('content')
some content
@endsection

// Если нам нужны значение по-умолчанию для секции, то можно задать секцию с show без yield

@section('content')
some content
@show
