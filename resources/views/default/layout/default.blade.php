<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>{{ cache()->get('setting.site_name') }}  - @section('title')@show</title>
    @include('common.header')
</head>
<body>
@include('common.nav')
@section('content')
@show
@section('footer')
@include('common.footer')
@show
</body>
</html>
