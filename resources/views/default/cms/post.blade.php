@extends('layout.default')

@section('title')
    {{ $post->post_title }}
@stop

@section('top')

@stop

@section('content')

    <h2>{{ $post->post_title }}</h2>

    <div>
        <em>{{ $post->created_at->format('Y-m-d') }}</em>&nbsp;&nbsp;|&nbsp;&nbsp;
        <i>{{ $post->post_hits }}</i>
    </div>

    <div>
        {!! $post->post_content !!}
    </div>

    <div>

        @if ($previous != '')
            <a href="{{ route('cms.post.show', ['id'=>$previous]) }}">&lt;&lt; 上一篇</a>
        @endif
        @if ($previous != '' && $next != '')
            &nbsp;&nbsp;|&nbsp;&nbsp;
        @endif
        @if ($next != '')
            <a href="{{ route('cms.post.show', ['id'=>$next]) }}">下一篇 &gt;&gt;</a>
        @endif
    </div>

@stop
