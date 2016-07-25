@extends('pages.products.products')

@section('product-body')
    <ol class="featured-tile-grid">
        @foreach ($products as $product)
            <li class="featured-tile">
                <a href="{{ $product->permalink }}"
                        class="content"
                        style="background-image: url({{ $product->featured_image }})">
                    <span class="text">{{ $product->post_title }}</span>
                </a>
                <p class="below-tile-content">{{ $product->excerpt }}</p>
            </li>
        @endforeach
    </ol>
@stop
