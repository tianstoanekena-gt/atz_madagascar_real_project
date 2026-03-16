@extends('layouts.main')

@section('content')
    {{-- Section À propos --}}
    <section id="" class="about-section">
        <div class="about-container">
            {{-- Titre de la section --}}
            <div class="section-header">
                <h2 class="section-title">@lang('about.section_title')</h2>
                <div class="title-underline"></div>
                {{-- Liens de navigation dans la page About --}}
                <div class="about-links-wrapper">
                    <div class="link-container">
                        <!-- Lien Personnel / Staff -->
                        <a href="{{ localized_route('staff') }}" class="about-link" data-category="staff">
                            <i class="fa-solid fa-users link-icon"></i>
                            <span class="link-text">@lang('about.cta_staff_btn')</span>
                            <i class="fa-solid fa-chevron-right link-arrow"></i>
                        </a>

                        <!-- Lien Partenaires / Sponsors -->
                        <a href="{{ localized_route('partenary') }}" class="about-link" data-category="partners">
                            <i class="fa-solid fa-handshake link-icon"></i>
                            <span class="link-text">@lang('about.cta_spons_btn')</span>
                            <i class="fa-solid fa-chevron-right link-arrow"></i>
                        </a>

                        <!-- Lien Documents -->
                        <a href="{{ localized_route('documents') }}" class="about-link" data-category="documents">
                            <i class="fa-solid fa-file-lines link-icon"></i>
                            <span class="link-text">@lang('about.cta_doc_btn')</span>
                            <i class="fa-solid fa-chevron-right link-arrow"></i>
                        </a>

                        <!-- Lien FAQ -->
                        <a href="{{ localized_route('faq') }}" class="about-link" data-category="faq">
                            <i class="fa-solid fa-circle-question link-icon"></i>
                            <span class="link-text">@lang('about.cta_faq_btn')</span>
                            <i class="fa-solid fa-chevron-right link-arrow"></i>
                        </a>

                        <!-- Lien Statistiques -->
                        <a href="{{ localized_route('stat') }}" class="about-link" data-category="stats">
                            <i class="fa-solid fa-chart-line link-icon"></i>
                            <span class="link-text">@lang('about.cta_stat_btn')</span>
                            <i class="fa-solid fa-chevron-right link-arrow"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Texte de présentation --}}
            <div class="about-video-text-parent">
                @php
                    use App\Models\AboutVideo;

                    // Récupérer la vidéo selon la langue actuelle
                    $currentLang = app()->getLocale(); // mg, fr, ou en
                    $video = AboutVideo::where('lang', $currentLang)->first();

                    // Fallback: si pas de vidéo pour cette langue, prendre la première disponible
                    if (!$video) {
                        $video = AboutVideo::first();
                    }

                    // Extraire l'ID YouTube de l'URL
                    $videoId = null;
                    if ($video && $video->video_url) {
                        preg_match('/(?:v=|\/|be\/)([a-zA-Z0-9_-]{11})/', $video->video_url, $matches);
                        $videoId = $matches[1] ?? null;
                    }
                @endphp

                <div class="about-video-text-parent">
                    <div class="about-video-parent">
                        @if ($videoId)
                            <iframe src="https://www.youtube.com/embed/{{ $videoId }}?rel=0&modestbranding=1"
                                frameborder="0" class="videos"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen class="w-full h-64 md:h-96 rounded-lg">
                            </iframe>
                        @else
                            <div class="w-full h-64 md:h-96 bg-gray-200 rounded-lg flex items-center justify-center">
                                <p class="text-gray-500">
                                    <i class="fas fa-video-slash mr-2"></i>
                                    Vidéo non disponible
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
                @php
                    use App\Models\AboutText;

                    $currentLang = app()->getLocale();
                    $aboutText = AboutText::where('lang', $currentLang)->first();

                    if (!$aboutText) {
                        $aboutText = AboutText::first();
                    }
                @endphp

                <div class="about-video-text-parent">
                    <div class="about-video-parent">
                        <!-- Vidéo YouTube (déjà implémentée) -->
                    </div>
                    <div class="about-intro">
                        @if ($aboutText && $aboutText->content)
                            <p class="intro-text">
                                {{ $aboutText->content }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>


            {{-- Mission, Vision, Valeurs --}}
            <div class="values-section">
                <div class="value-card">
                    <div class="value-icon">
                        <svg fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                        </svg>
                    </div>
                    <h3 class="value-title">Notre Mission</h3>
                    <p class="value-text">
                        Soutenir socialement les personnes et familles vulnérables à travers l'éducation, la santé et la
                        nutrition.
                    </p>
                </div>

                <div class="value-card">
                    <div class="value-icon">
                        <svg fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                            <path fill-rule="evenodd"
                                d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="value-title">Notre Vision</h3>
                    <p class="value-text">
                        Chaque enfant a accès à l'éducation, la santé et peut réaliser son plein potentiel.
                    </p>
                </div>

                <div class="value-card">
                    <div class="value-icon">
                        <svg fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="value-title">Nos Valeurs</h3>
                    <p class="value-text">
                        Compassion, solidarité, intégrité et engagement envers les plus vulnérables de notre société.
                    </p>
                </div>
            </div>




            {{-- Cards des domaines d'intervention --}}
            <div class="intervention-cards">
                {{-- Card Santé --}}
                <div class="card">
                    <div class="card-image">
                        <img src="{{ asset('assets/images/activity/sante21.jpg') }}" alt="Santé">
                    </div>
                    <div class="card-content card-health">
                        <h3 class="card-title">La santé :</h3>
                        <p class="card-text">
                            ATZ soutient ses membres en assurant un accès aux soins de santé. Nous organisons des
                            consultations médicales régulières et des campagnes de sensibilisation sanitaire pour garantir
                            le bien-être de nos bénéficiaires.
                        </p>
                    </div>
                </div>

                {{-- Card Nutrition --}}
                <div class="card">
                    <div class="card-image">
                        <img src="{{ asset('assets/images/activity/sakafo.jpg') }}" alt="Nutrition">
                    </div>
                    <div class="card-content card-nutrition">
                        <h3 class="card-title">La nutrition :</h3>
                        <p class="card-text">
                            ATZ soutient ses membres en améliorant leur nutrition. Nous offrons des repas nutritifs aux
                            familles et une éducation nutritionnelle pour favoriser une croissance saine des enfants.
                        </p>
                    </div>
                </div>

                {{-- Card Éducation --}}
                <div class="card">
                    <div class="card-image">
                        <img src="{{ asset('assets/images/activity/494060426_9603831496380796_6965740743675755470_n.jpg') }}"
                            alt="Éducation">
                    </div>
                    <div class="card-content card-education">
                        <h3 class="card-title">L'éducation :</h3>
                        <p class="card-text">
                            ATZ soutient et facilite l'éducation scolaire à travers la prise en charge des frais scolaires
                            et fournitures. Nous offrons également un accompagnement pédagogique personnalisé.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
