@extends('pages.products.products')

@section('product-body')
    <article>

        <h1 class="product-title">{{ $product->post_title }}</h1>

        <div class="product-top-content">

            <div class="product-image-container">
                <img class="product-main-image"
                        src="{{ $product->getFeaturedImageSrc() }}"
                        alt="{{ $product->post_title }}">
            </div>

            <ul class="product-other-images">
                @foreach ($product->fields['product_images'] as $productImage)
                    <li>
                        <a href="#biggerImage">
                            <img src="{{ $productImage['sizes']['thumbnail'] }}"
                                    alt="{{ $productImage['alt'] }}"
                                    title="{{ $productImage['title'] }}">
                        </a>
                    </li>
                @endforeach
            </ul>
            <div class="product-details">
                <dl>
                    @if (!empty($product->fields['product_brand_manufacturer']))
                        <dt>Brand</dt>
                        <dd>{{ $product->fields['product_brand_manufacturer']->name }}</dd>
                    @endif
                    @if (!empty($product->fields['product_collection']))
                        <dt>Collection</dt>
                        <dd>{{ $product->fields['product_collection']->name }}</dd>
                    @endif
                    @if (!empty($product->fields['product_designer']))
                        <dt>Designer</dt>
                        <dd>{{ $product->fields['product_designer']->post_title }}</dd>
                    @endif
                    @if (!empty($product->fields['product_price']))
                        <dt>Price</dt>
                        @if (!empty($product->fields['product_sale_price']))
                            <dd>
                                <span style="text-decoration: line-through;">{{ $product->fields['product_price'] }}</span> {{ $product->fields['product_sale_price'] }}
                            </dd>
                        @else
                            <dd>{{ $product->fields['product_price'] }}</dd>
                        @endif
                    @endif
                </dl>
            </div>

        </div>

        <section class="product-information">
            {!! $product->content !!}
        </section>

    </article>
@stop
