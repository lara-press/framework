@extends('pages.products.products')

@section('product-body')
    <ol class="featured-tile-grid">
        @foreach ($collections as $collection)
            <li class="featured-tile">
                <a href="{{ $collection->link }}"
                        class="content"
                        style="background-image: url({{ $collection->featured_image }})">
                    <span class="text">{{ $collection->name }}</span>
                </a>
                <p class="below-tile-content">{{ $collection->excerpt }}</p>
            </li>
        @endforeach
    </ol>
@stop
