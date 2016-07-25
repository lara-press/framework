@extends('app')

@section('body')

    @if (!empty($blurbContent))
        <section class="primary-content">
            <div class="content">{!! $blurbContent !!}</div>
        </section>
    @endif

    @yield('product-body')

@endsection
