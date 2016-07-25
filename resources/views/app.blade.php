<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/5.5.2/css/foundation.css">
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="{{ get_bloginfo('pingback_url') }}">

    @wphead

    {!! HTML::style('css/app.css') !!}

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

{!! HTML::script('js/app.js') !!}

@wpfooter
</body>

</html>
