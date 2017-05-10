@extends('layout.default')

@section('title'){{ $post->post_title }}@stop

@section('keywords'){{ $post->meta_keywords }}@stop

@section('description'){{ $post->meta_description }}@stop

@section('content')
    <ul>
        @foreach ($post_list as $post)
            <li>
                <a href="{{ route('cms.post.show', ['id' => $post->id]) }}">
                    <p>{{ $post->post_title }}</p>
                    <p><em>{{ $post->created_at->format('Y-m-d') }}</em></p>
                    <p>{{ str_limit($post->post_excerpt, 220) }}...<em>[更多+]</em></p>
                </a>
            </li>
        @endforeach
    </ul>

    <!-- 分页器 -->
    {!! $post_list->links() !!}
    <!-- 分页器 end -->
@stop
