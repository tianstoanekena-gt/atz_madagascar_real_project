@extends('layouts.main')

@section('content')
    {{-- Section Contact --}}
    <section id="contact" class="contact-section">
        <div class="contact-container">
            {{-- Titre de la section --}}
            <div class="section-header">
                <h2 class="section-title">@lang('contact.sec_title')</h2>
                <p class="section-description">@lang('contact.sec_desc')</p>
                <div class="title-underline"></div>
            </div>

            <div class="contact-wrapper">
                {{-- Informations de contact --}}
                <div class="contact-info">
                    <h3 class="info-title">@lang('contact.coordonates')</h3>

                    {{-- Réseaux sociaux et contacts --}}
                    <div class="contact-links">
                        {{-- Facebook --}}
                        <a href="#" class="contact-link">
                            <div class="contact-icon icon-facebook">
                                <img src="{{ asset('assets/images/icons/facebook.png') }}" alt="">
                            </div>
                            <span class="contact-text">Akany Tia Zaza Madagascar</span>
                        </a>

                        {{-- Instagram --}}
                        <a href="#" class="contact-link">
                            <div class="contact-icon icon-instagram">
                                <img src="{{ asset('assets/images/icons/instagram.png') }}" alt="">
                            </div>
                            <span class="contact-text">Akany Tia Zaza Madagascar</span>
                        </a>

                        {{-- Messenger --}}
                        <a href="#" class="contact-link">
                            <div class="contact-icon icon-messenger">
                                <img src="{{ asset('assets/images/icons/messenger.png') }}" alt="">
                            </div>
                            <span class="contact-text">Akany Tia Zaza Madagascar</span>
                        </a>

                        {{-- WhatsApp --}}
                        <a href="https://wa.me/" class="contact-link">
                            <div class="contact-icon icon-whatsapp">
                                <img src="{{ asset('assets/images/icons/whatsapp.png') }}" alt="">
                            </div>
                            <span class="contact-text">+261 34 XX XXX X</span>
                        </a>

                        {{-- Email --}}
                        <a href="mailto:atzmadag@gmail.com" class="contact-link">
                            <div class="contact-icon icon-email">
                                <img src="{{ asset('assets/images/icons/email.png') }}" alt="">
                            </div>
                            <span class="contact-text">atzmadag@gmail.com</span>
                        </a>

                        {{-- Téléphone --}}
                        <a href="" class="contact-link">
                            <div class="contact-icon icon-phone">
                                <img src="{{ asset('assets/images/icons/telephone.png') }}" alt="">
                            </div>
                            <span class="contact-text">+261 34 XX XXX X</span>
                        </a>
                    </div>

                    {{-- Horaires --}}
                    <div class="schedule-box">
                        <h4 class="schedule-title">
                            <svg fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z" />
                            </svg>
                            @lang('contact.hour')
                        </h4>
                        <p class="schedule-text">@lang('contact.dayly')</p>
                    </div>
                </div>

                {{-- Formulaire de contact --}}
                <div class="contact-form-wrapper">
                    <h3 class="form-title">@lang('contact.form_title')</h3>
                    <form action="#" method="POST" class="contact-form">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="form-label">@lang('contact.form_name')</label>
                            <input type="text" id="name" name="name" class="form-input"
                                placeholder="@lang('contact.form_name')" required>
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">@lang('contact.form_email')</label>
                            <input type="email" id="email" name="email" class="form-input"
                                placeholder="@lang('contact.form_email')" required>
                        </div>

                        <div class="form-group">
                            <label for="message" class="form-label">@lang('contact.form_message')</label>
                            <textarea id="message" name="message" rows="5" class="form-textarea" placeholder="@lang('contact.form_message')" required></textarea>
                        </div>

                        <button type="submit" class="submit-btn">
                            <svg fill="currentColor" viewBox="0 0 24 24">
                                <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z" />
                            </svg>
                            @lang('contact.form_button')
                        </button>
                    </form>
                </div>
            </div>

            {{-- Section Localisation avec Map et Adresse --}}
            <div class="map-section">
                <h3 class="map-title">@lang('contact.location')</h3>

                <div class="map-wrapper">
                    {{-- Boîte d'informations d'adresse --}}
                    <div class="location-info-box">
                        <div class="location-header">
                            <svg class="location-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <h4 class="location-title">ATZ Madagascar</h4>
                        </div>

                        <div class="location-details">
                            <div class="location-item">
                                <svg class="item-icon" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div class="item-content">
                                    <span class="item-label">@lang('contact.address')</span>
                                    <span class="item-value">FJKM Andranovelona Fihavanana</span>
                                </div>
                            </div>

                            <div class="location-item">
                                <svg class="item-icon" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                </svg>
                                <div class="item-content">
                                    <span class="item-label">@lang('contact.quarter')</span>
                                    <span class="item-value">Andranovelona</span>
                                </div>
                            </div>

                            <div class="location-item">
                                <svg class="item-icon" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div class="item-content">
                                    <span class="item-label">@lang('contact.city')</span>
                                    <span class="item-value">Antananarivo</span>
                                </div>
                            </div>

                            <div class="location-item">
                                <svg class="item-icon" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M3 6a3 3 0 013-3h10a1 1 0 01.8 1.6L14.25 8l2.55 3.4A1 1 0 0116 13H6a1 1 0 00-1 1v3a1 1 0 11-2 0V6z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div class="item-content">
                                    <span class="item-label">@lang('contact.province')</span>
                                    <span class="item-value">Analamanga</span>
                                </div>
                            </div>

                            <div class="location-item">
                                <svg class="item-icon" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.05 3.636a1 1 0 010 1.414 7 7 0 000 9.9 1 1 0 11-1.414 1.414 9 9 0 010-12.728 1 1 0 011.414 0zm9.9 0a1 1 0 011.414 0 9 9 0 010 12.728 1 1 0 11-1.414-1.414 7 7 0 000-9.9 1 1 0 010-1.414zM7.879 6.464a1 1 0 010 1.414 3 3 0 000 4.243 1 1 0 11-1.415 1.414 5 5 0 010-7.07 1 1 0 011.415 0zm4.242 0a1 1 0 011.415 0 5 5 0 010 7.072 1 1 0 01-1.415-1.415 3 3 0 000-4.242 1 1 0 010-1.415zM10 9a1 1 0 011 1v.01a1 1 0 11-2 0V10a1 1 0 011-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div class="item-content">
                                    <span class="item-label">@lang('contact.postal_code')</span>
                                    <span class="item-value">101</span>
                                </div>
                            </div>

                            <div class="location-item">
                                <svg class="item-icon" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM4.332 8.027a6.012 6.012 0 011.912-2.706C6.512 5.73 6.974 6 7.5 6A1.5 1.5 0 019 7.5V8a2 2 0 004 0 2 2 0 011.523-1.943A5.977 5.977 0 0116 10c0 .34-.028.675-.083 1H15a2 2 0 00-2 2v2.197A5.973 5.973 0 0110 16v-2a2 2 0 00-2-2 2 2 0 01-2-2 2 2 0 00-1.668-1.973z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div class="item-content">
                                    <span class="item-label">@lang('contact.country')</span>
                                    <span class="item-value">Madagascar</span>
                                </div>
                            </div>

                            <div class="location-item">
                                <svg class="item-icon" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div class="item-content">
                                    <span class="item-label">@lang('contact.way')</span>
                                    <span class="item-value">Route Nationale 3 (RN3)</span>
                                </div>
                            </div>
                        </div>

                        {{-- Bouton directions --}}
                        <a href="https://www.google.com/maps/dir/?api=1&destination=FJKM+Andranovelona+Fihavanana"
                            target="_blank" class="directions-btn">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                            </svg>
                            @lang('contact.take_itinery')
                        </a>
                    </div>

                    {{-- Carte Google Maps --}}
                    <div class="map-container">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d295.3090520640444!2d47.591633294964765!3d-18.841666930046905!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x21f085e3e72ca579%3A0xd228b035a477d3ad!2sFJKM%20Andranovelona%20Fihavanana!5e1!3m2!1sfr!2smg!4v1768889050014!5m2!1sfr!2smg"
                            width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
