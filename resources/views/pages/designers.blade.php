@extends('app')

@section('body')

    @include('partials._section', ['content' => $page->content, 'title' => $page->post_title])

    <ol class=" section featured-tile-grid">
        @foreach ($designers as $designer)
            <li class="featured-tile">
                <a href="{{ $designer->permalink }}"
                   class="content"
                   style="background-image: url({{ $designer->getFeaturedImageSrc() }})">
                    <span class="text">{{ $designer->post_title }}</span>
                </a>
                <p class="below-tile-content">{{ $designer->excerpt }}</p>
            </li>
        @endforeach
    </ol>
@stop
