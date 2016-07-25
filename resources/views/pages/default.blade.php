@extends('app')

@section('body')
    @include('partials._section', ['content' => $post->content, 'title' => $post->post_title])
@stop
