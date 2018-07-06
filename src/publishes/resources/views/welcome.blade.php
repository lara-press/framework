<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>

    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ wp_title('|', false, 'right') }} {{ bloginfo( 'name' ) }}</title>

    <!-- Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Roboto:300' rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <style type="text/css">

        html, body {
            height: 100vh;
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
        }

        body, main {
            display: flex;
            flex-direction: column;
            flex: 1 0 auto;
            align-items: center;
            justify-content: center;
        }

        main, footer {
            padding: 1rem;
        }

        img.logo {
            max-width: 100%;
        }

        h3.tag-line {
            font-weight: 300;
            margin: 2rem 1rem;
        }

        ul.nav {
            display: flex;
            margin: 0;
            padding: 0;
            list-style-type: none;
        }

        ul.nav li a {
            display: inline-block;
            background: #F68D3E;
            border-radius: .25rem;
            padding: 1rem;
            margin: 0 .5rem;
            color: #FFFFFF;
            text-decoration: none;
        }

        footer {
            font-size: 13px;
            text-align: center;
        }

        @media all and (max-width: 400px) {
            ul.nav {
                flex-direction: column;
                align-items: center;
            }

            ul.nav li {
                margin-bottom: 1rem;
            }
        }
    </style>

    @wphead

</head>

<body>
<main>

    @if(is_home() || is_front_page())
        <img class="logo" src="{{ larapress_assets('images/larapress.png') }}" alt="LaraPress">

        <h3 class="tag-line">Develop with the popularity of WordPress and the power of Laravel</h3>

        <ul class="nav">
            <li><a href="https://github.com/lara-press/docs" target="_blank">Documentation</a></li>
            <li><a href="https://github.com/lara-press/framework" target="_blank">GitHub</a></li>
        </ul>
    @elseif(is_single() || is_page())
        {{ post()->post_title }}
    @elseif(is_category() || is_archive())
        {{ get_the_archive_title() }}
    @elseif(is_search())
        Search: {{ request('s') }}
    @endif

</main>

<footer>
    <p class="disclaimer">
        WordPress is a trademark of WordPress Foundation. Laravel is a trademark of Taylor Otwell.
    </p>
</footer>
@wpfooter
</body>

</html>
