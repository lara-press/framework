<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>

    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="{{ get_bloginfo('pingback_url') }}">

    @wphead

    {{--<link rel="stylesheet" href="{!! webpack('css', 'app') !!}">--}}

</head>

<body <?php body_class(! empty($page) ? $page->slug : '') ?>>

@include('partials._header')

@if (isset($showHero) && $showHero && isset($heroBackgroundImage))
    @include('partials._hero', ['backgroundImage' => $heroBackgroundImage, 'overlayText' => $heroOverlayText])
@endif

@if (!empty($__template))
    @include('templates.' . $__template)
@else
    <main id="main-content">
        {!! yoast_breadcrumb('<div id="breadcrumbs">', '</div>', false) !!}
        @yield('body')
    </main>
@endif

@include('partials._footer')

@wpfooter

<script src="{!! webpack('js', 'vendor') !!}"></script>
<script src="{!! webpack('js', 'app') !!}"></script>

</body>

</html>
