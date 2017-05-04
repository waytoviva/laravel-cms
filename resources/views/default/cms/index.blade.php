@extends('layout.default')


@section('title'){{ $post->post_title }}@stop

@section('keywords'){{ $post->meta_keywords }}@stop

@section('description'){{ $post->meta_description }}@stop

@section('content')

@stop

