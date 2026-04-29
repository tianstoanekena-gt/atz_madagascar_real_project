<!-- ========== FOOTER SECTION ========== -->
<section id="footer-section">

    <footer class="footer-container">

        <div class="footer-top">
            <div class="footer-column">
                <h3>@lang('footer.about_section')</h3>
                <p>
                    @lang('footer.about_description')
                </p>
            </div>

            <div class="footer-column">
                <h3>@lang('footer.quick_links')</h3>
                <ul>
                    <li><a href="{{ localized_route('home') }}">@lang('footer.home_link')</a></li>
                    <li><a href="{{ localized_route('about') }}">@lang('footer.about_link')</a></li>
                    <li><a href="{{ localized_route('activities') }}">@lang('footer.activities_link')</a></li>
                    <li><a href="{{ localized_route('contact') }}">@lang('footer.contact_link')</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h3>@lang('footer.contact_section')</h3>
                <p>@lang('footer.contact_email')</p>
                <p>@lang('footer.contact_phone')</p>
                <p>@lang('footer.contact_address')</p>
            </div>

            <div class="footer-column">
                <h3>@lang('footer.follow_us')</h3>
                <div class="social-icons">
                    <a href="#">
                        <img src="{{ asset('assets/images/icons/facebook.png') }}" alt="Facebook">
                    </a>

                    <a href="#">
                        <img src="{{ asset('assets/images/icons/instagram.png') }}" alt="Instagram">
                    </a>

                    <a href="#">
                        <img src="{{ asset('assets/images/icons/whatsapp.png') }}" alt="Twitter">
                    </a>

                    <a href="#">
                        <img src="{{ asset('assets/images/icons/email.png') }}" alt="Twitter">
                    </a>
                </div>

                <div class="newsletter">
                    <input type="email" placeholder="@lang('footer.newsletter_placeholder')">
                    <button>@lang('footer.newsletter_button')</button>
                </div>

            </div>
        </div>

        <div class="footer-bottom">
            <p>@lang('footer.copyright')</p>
        </div>

    </footer>

</section>
