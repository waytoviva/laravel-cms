<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="baidu-site-verification" content="{{ cache()->get('setting.baidu-site-verification') }}" />
    <title>{{ cache()->get('setting.site_name') }}  - @section('title')@show</title>
    @include('common.header')
</head>
<body>
@include('common.top')
<div id="body">
        @include('common.nav')
        <div id="content">
        @section('content')
        @show
        </div>
</div>
@section('footer')
    @include('common.footer')
@show
</body>
</html>
