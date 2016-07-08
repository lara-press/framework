<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/5.5.2/css/foundation.css">
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

{{--<title>{{ wp_title('|', false, 'right') }}</title>--}}

<!-- Modernizr -->
{!! HTML::script(larapress_assets('js/modernizr.js')) !!}

<!-- Google Fonts - Lusitana -->
    <link href='https://fonts.googleapis.com/css?family=Lusitana:400,700' rel='stylesheet' type='text/css'>

    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="{{ get_bloginfo('pingback_url') }}">

    @wphead

    {!! HTML::style(larapress_assets('css/app.css')) !!}

    @if (!empty(get_field('google_analytics_key', 'options')))

        <script>
            (function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function () {
                            (i[r].q = i[r].q || []).push(arguments)
                        }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                        m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

            ga('create', '{{ get_field('google_analytics_key', 'options') }}', 'auto');
            ga('send', 'pageview');

        </script>

    @endif

</head>

<body <?php body_class(!empty($page) ? $page->slug : '') ?>>

@include('partials.header')

@if ($showHero)
    @include('partials.hero', ['backgroundImage' => $heroBackgroundImage, 'overlayText' => $heroOverlayText])
@endif

@if (!empty($__template))
    @include('templates.' . $__template)
@else
    <main id="main-content">
        @yield('body')
    </main>
@endif

@include('partials.footer')

{!! HTML::script(larapress_assets('js/app.js')) !!}

@wpfooter
</body>

</html>
