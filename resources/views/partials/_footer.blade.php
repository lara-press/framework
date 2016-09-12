<footer id="footer">

    <div class="primary-footer-content">
        <div class="column">
            <h3 class="title">Get In Touch</h3>
            <a href="tel:208-634-4367">208-634-GEMS (4367)</a>
            <address>
                207 E. Lake Street<br>
                McCall, ID 83638
            </address>
        </div>
        <div class="column">
            <h3 class="title">Follow Us</h3>
            <ul class="social-media-list">
                <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                <li><a href="#"><i class="fa fa-facebook-official" aria-hidden="true"></i></a></li>
                <li><a href="#"><i class="fa fa-pinterest-square" aria-hidden="true"></i></a></li>
            </ul>
        </div>
        <div class="column">
            <h3 class="title">Newsletter Sign Up</h3>
            <form action="" class="newsletter-sign-up">
                <input type="email" placeholder="Email Address">
                <input class="button tiny" type="submit" value="Submit">
            </form>
        </div>
    </div>

    <nav>
        {!! wp_nav_menu([
            'container'      => false,
            'echo'           => false,
            'menu_class' => 'footer-links',
            'theme_location' => 'footer-nav',
        ]) !!}
    </nav>

    <span class="footer-copyright">
        &copy; {{ \Carbon\Carbon::now()->format('Y') }} mccall jewelry company
    </span>

</footer>