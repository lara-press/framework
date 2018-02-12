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

        html, body, main {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
        }

        main {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        main, footer {
            padding: 15px;
            box-sizing: border-box;
        }

        img.logo {
            max-width: 100%;
            align-self: center;
        }

        h3.tag-line {
            font-weight: 300;
            margin: 2rem 15px;
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
            border-radius: 4px;
            padding: 15px;
            margin: 0 5px;
            color: #FFFFFF;
            text-decoration: none;
        }

        footer {
            position: fixed;
            left: 0;
            right: 0;
            bottom: 0;
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

    <img class="logo" src="{{ larapress_assets('images/larapress.png') }}" alt="LaraPress">

    <h3 class="tag-line">Develop with the popularity of WordPress and the power of Laravel</h3>

    <ul class="nav">
        <li><a href="https://github.com/lara-press/docs" target="_blank">Documentation</a></li>
        <li><a href="https://github.com/lara-press/framework" target="_blank">GitHub</a></li>
    </ul>

</main>

<footer>
    <p class="disclaimer">
        WordPress is a trademark of WordPress Foundation. Laravel is a trademark of Taylor Otwell.
    </p>
</footer>
@wpfooter
</body>

</html>
