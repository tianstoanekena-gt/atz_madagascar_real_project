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
                        {{-- <a href="{{ localized_route('sponsors') }}" class="about-link" data-category="partners"> --}}
                        <a href="{{ url(app()->getLocale() . '/sponsors') }}" class="about-link" data-category="partners">
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

            <h3 class="semi_section_title">@lang('about.first_semi_section_title')</h3>
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
            @php
                use App\Models\AboutIntervention;

                $currentLang = app()->getLocale();
                $interventions = AboutIntervention::with('translations')->orderBy('order')->get();
            @endphp

            <h3 class="semi_section_title">@lang('about.second_semi_section_title')</h3>
            <div class="intervention-cards">
                @foreach ($interventions as $intervention)
                    @php
                        $translation = $intervention->translation($currentLang);
                    @endphp

                    @if ($translation)
                        <div class="card">
                            <div class="card-image">
                                @if (Storage::disk('public')->exists($intervention->image))
                                    <img src="{{ Storage::url($intervention->image) }}" alt="{{ $translation->title }}">
                                @endif
                            </div>
                            <div class="card-content">
                                <h3 class="card-title">{{ $translation->title }}</h3>
                                <p class="card-text">{{ $translation->description }}</p>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

        </div>
    </section>
@endsection
