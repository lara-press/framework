@extends('app')

@section('body')

    <section class="primary-content">
        <h1 class="title">About</h1>
        <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer malesuada risus massa, dapibus tincidunt
            turpis
            ultricies
            et. Aliquam auctor finibus euismod. Donec lobortis ante vitae lacus blandit egestas. Suspendisse nunc
            sapien,
            pretium eu
            lectus a, fermentum rutrum est.
        </p>
    </section>

    <div class="home-featured-content">
        <section class="home-feature">
            <h2 class="title">Featured Designer</h2>
            <div class="content" style="background-image: url({{ $featuredDesignerBackgroundImage }}">
                <span class="text">Megan Thorne</span>
            </div>
        </section>
        <section class="home-feature">
            <h2 class="title">Featured Collection</h2>
            <div class="content" style="background-image: url({{ $featuredCollectionBackgroundImage }}">
                <span class="text">Bertusomethin Watches</span>
            </div>
        </section>
    </div>

    <section class="home-feature fixed-width">
        <h2 class="title">Custom Jewelry Design</h2>
        <div class="content" style="background-image: url({{ $customJewelryDesignBackgroundImage }}"/>
    </section>

@stop
