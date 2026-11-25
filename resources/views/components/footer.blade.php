<!-- ========== FOOTER ========== -->
<footer class="site-footer">
    <div class="footer-container">

        <div class="footer-grid">
            <!-- Colonne 1 : À propos -->
            <div class="footer-col">
                <h3>@lang('footer.about_section')</h3>
                <p>@lang('footer.about_description')</p>
            </div>

            <!-- Colonne 2 : Liens rapides -->
            <div class="footer-col">
                <h3>@lang('footer.quick_links')</h3>
                <ul class="footer-links">
                    <li><a href="{{ localized_route('home') }}">@lang('footer.home_link')</a></li>
                    <li><a href="{{ localized_route('about') }}">@lang('footer.about_link')</a></li>
                    <li><a href="{{ localized_route('activities') }}">@lang('footer.activities_link')</a></li>
                    <li><a href="{{ localized_route('contact') }}">@lang('footer.contact_link')</a></li>
                </ul>
            </div>

            <!-- Colonne 3 : Contact -->
            <div class="footer-col">
                <h3>@lang('footer.contact_section')</h3>
                <ul class="footer-contact">
                    <li>@lang('footer.contact_address')</li>
                    <li>@lang('footer.contact_phone')</li>
                    <li>@lang('footer.contact_email')</li>
                </ul>
            </div>

            <!-- Colonne 4 : Réseaux & Newsletter -->
            <div class="footer-col">
                <h3>@lang('footer.follow_us')</h3>
                <div class="social-icons">
                    <a href="#" aria-label="Facebook"><img src="{{ asset('assets/images/icons/facebook.png') }}"
                            alt="Facebook"></a>
                    {{-- <a href="#" aria-label="WhatsApp"><img src="{{ asset('assets/images/icons/whatsapp.png') }}"
                            alt="WhatsApp"></a> --}}
                    <a href="#" aria-label="Email"><img src="{{ asset('assets/images/icons/email.png') }}"
                            alt="Email"></a>
                </div>

                <div class="footer-newsletter">
                    {{-- <p class="newsletter-label">Newsletter</p> --}}
                    <div class="newsletter-input-group">
                        <input type="email" placeholder="@lang('footer.newsletter_placeholder')" readonly disabled>
                        <button type="button" disabled>@lang('footer.newsletter_button')</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bas de page -->
        <div class="footer-bottom">
            <p>@lang('footer.copyright', ['year' => date('Y')])</p>
        </div>

    </div>
</footer>
