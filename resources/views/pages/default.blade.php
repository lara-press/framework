@extends('app')

@section('body')
    @include('partials._section', ['content' => $page->content, 'title' => $page->post_title])
@stop
