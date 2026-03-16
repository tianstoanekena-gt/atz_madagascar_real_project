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
            @php
                use App\Models\AboutCard;
                use Illuminate\Support\Facades\Storage;

                $currentLang = app()->getLocale();

                // Récupérer toutes les cartes pour la langue actuelle
                $cards = AboutCard::where('lang', $currentLang)->get();

                // Fallback sur français si pas trouvé
                if ($cards->count() === 0) {
                    $cards = AboutCard::where('lang', 'fr')->get();
                }
            @endphp

            <div class="values-section">
                @forelse ($cards as $card)
                    <div class="value-card">
                        <div class="value-icon">
                            @if (Storage::disk('public')->exists($card->card_icon))
                                <img src="{{ Storage::url($card->card_icon) }}" alt="{{ $card->card_title }}"
                                    class="w-12 h-12 object-contain">
                            @endif
                        </div>
                        <h3 class="value-title">{{ $card->card_title }}</h3>
                        <p class="value-text">{{ $card->card_description }}</p>
                    </div>
                @empty
                @endforelse
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
