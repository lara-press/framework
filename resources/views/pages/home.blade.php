@extends('app')

@section('body')

    @include('partials._section', ['content' => $__post->content, 'title' => 'About'])

    <div class="section featured-tile-grid">
        <section class="featured-tile">
            <h2 class="title">Featured Designer</h2>
            <div class="content" style="background-image: url({{ $featuredDesignerBackgroundImage }})">
                <span class="text">Megan Thorne</span>
            </div>
        </section>
        <section class="featured-tile">
            <h2 class="title">Featured Collection</h2>
            <div class="content" style="background-image: url({{ $featuredCollectionBackgroundImage }})">
                <span class="text">Bertusomethin Watches</span>
            </div>
        </section>
        <section class="featured-tile">
            <h2 class="title">Custom Jewelry Design</h2>
            <div class="content" style="background-image: url({{ $customJewelryDesignBackgroundImage }}" />
        </section>
    </div>

@stop
