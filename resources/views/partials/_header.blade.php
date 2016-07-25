<header id="header">
    <img class="header-logo" src="{{ larapress_assets('images/logo.png') }}" alt="McCall Jewelry Company">
    <nav>
        {!! wp_nav_menu([
            'container'      => false,
            'echo'           => false,
            'menu_class' => 'header-menu',
            'theme_location' => 'header-nav',
        ]) !!}
    </nav>
</header>
