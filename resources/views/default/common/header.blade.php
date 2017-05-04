<meta name="viewport" content="width=device-width, initial-scale=1.0">

<meta name="keywords" content="@section('keywords')@show" />
<meta name="author" content="{{ cache()->get('setting.meta_author') }}" />
<meta name="description" content="@section('description')@show" />

@section('css')
@show
<link rel="stylesheet" href="{{ mix('css/app.css') }}"/>

<link rel="shortcut icon" href="{!! asset('favicon.ico') !!}">
<script type="text/javascript" src="{{ mix('js/app.js') }}"></script>