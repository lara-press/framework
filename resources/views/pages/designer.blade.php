@extends('app')

@section('body')

    <section class="section primary-content designer-header">
        <h1 class="title">{{ $designer->post_title }}</h1>
        <div class="content">
            <div class="featured-image-container">
                <img class="designer-featured-image" src="{{ $designer->getFeaturedImageSrc() }}"
                     alt="{{ $designer->post_title }}">
            </div>
            <div class="post-content">
                {!! $designer->content !!}
            </div>
        </div>
    </section>

    <ol class="section featured-tile-grid">
        @foreach ($products as $product)
            <li class="featured-tile">
                <a href="{{ $product->permalink }}"
                   class="content"
                   style="background-image: url({{ $product->getFeaturedImageSrc() }})">
                    <span class="text">{{ $product->post_title }}</span>
                </a>
                <p class="below-tile-content">{{ $product->excerpt }}</p>
            </li>
        @endforeach
    </ol>
@stop
