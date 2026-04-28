@extends('layouts.main')

@php
    use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
    <section class="sponsor-detail-section py-16 bg-gray-50">
        <div class="container mx-auto px-4">

            <!-- Retour -->
            <div class="mb-8">
                <a href="{{ url('/#sponsors') }}"
                    class="inline-flex items-center text-blue-600 hover:text-blue-800 transition">
                    <i class="fas fa-arrow-left mr-2"></i>
                    <span>@lang('sponsor.back_to_list')</span>
                </a>
            </div>

            <!-- Header Sponsor -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
                <div class="flex flex-col md:flex-row items-center gap-8 p-8 md:p-12">
                    @if ($sponsor->logo && Storage::disk('public')->exists($sponsor->logo))
                        <div class="sponsor-logo-wrapper flex-shrink-0">
                            <img src="{{ Storage::url($sponsor->logo) }}" alt="{{ $sponsor->name }}"
                                class="w-40 h-40 md:w-48 md:h-48 object-contain rounded-xl shadow-lg border-4 border-gray-100">
                        </div>
                    @endif
                    <div class="sponsor-header-info text-center md:text-left flex-1">
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3">{{ $sponsor->name }}</h1>
                        @if ($sponsor->since_year)
                            <p class="text-gray-600 text-lg mb-2">
                                <i class="fas fa-calendar-alt mr-2 text-blue-600"></i>
                                @lang('sponsor.partner_since') {{ $sponsor->since_year }}
                            </p>
                        @endif
                        @if ($sponsor->website)
                            <a href="{{ $sponsor->website }}" target="_blank" rel="noopener"
                                class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium transition mt-2">
                                <i class="fas fa-external-link-alt mr-2"></i>
                                <span>@lang('sponsor.visit_website')</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Description Courte -->
            @php
                $translation = $sponsor->translation(app()->getLocale());
            @endphp
            @if ($translation->short_description)
                <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-info-circle mr-3 text-blue-600"></i>
                        <span>@lang('sponsor.about')</span>
                    </h2>
                    <p class="text-gray-700 text-lg leading-relaxed">
                        {{ $translation->short_description }}
                    </p>
                </div>
            @endif

            <!-- Histoire du Partenariat (Longue Description Multilingue) -->
            @if ($sponsor->details && $sponsor->details->getLongDescription(app()->getLocale()))
                <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-book-open mr-3 text-blue-600"></i>
                        <span>@lang('sponsor.our_story')</span>
                    </h2>
                    <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                        {!! nl2br(e($sponsor->details->getLongDescription(app()->getLocale()))) !!}
                    </div>
                </div>
            @endif

            <!-- Galerie Photos -->
            @if ($sponsor->details && $sponsor->details->photos->count() > 0)
                <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-images mr-3 text-blue-600"></i>
                        <span>@lang('sponsor.gallery')</span>
                    </h2>
                    <p class="text-gray-600 mb-6">@lang('sponsor.gallery_desc')</p>

                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                        @foreach ($sponsor->details->photos as $photo)
                            <div class="group relative cursor-pointer overflow-hidden rounded-xl shadow-md hover:shadow-xl transition"
                                onclick="openLightbox('{{ Storage::url($photo->photo) }}', '{{ $photo->caption ?? '' }}')">
                                <img src="{{ Storage::url($photo->photo) }}" alt="{{ $photo->caption ?? 'Photo sponsor' }}"
                                    class="w-full h-40 md:h-48 object-cover group-hover:scale-110 transition duration-300">
                                @if ($photo->caption)
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-4">
                                        <p class="text-white text-sm font-medium line-clamp-2">{{ $photo->caption }}</p>
                                    </div>
                                @endif
                                <div
                                    class="absolute top-3 right-3 bg-white bg-opacity-90 rounded-full p-2 opacity-0 group-hover:opacity-100 transition duration-300">
                                    <i class="fas fa-search-plus text-blue-600"></i>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- CTA : Devenir Partenaire -->
            <div
                class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-2xl shadow-xl p-8 md:p-12 text-center text-white">
                <h2 class="text-2xl md:text-3xl font-bold mb-4">
                    <i class="fas fa-heart mr-3"></i>
                    <span>@lang('sponsor.cta_title')</span>
                </h2>
                <p class="text-blue-100 text-lg mb-8 max-w-2xl mx-auto">
                    @lang('sponsor.cta_description')
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('contact') }}"
                        class="inline-flex items-center justify-center bg-white text-blue-600 px-8 py-4 rounded-xl font-semibold hover:bg-gray-100 transition shadow-lg">
                        <i class="fas fa-envelope mr-2"></i>
                        <span>@lang('sponsor.cta_contact')</span>
                    </a>
                    <a href="{{ url('/#sponsors') }}"
                        class="inline-flex items-center justify-center bg-blue-500 text-white px-8 py-4 rounded-xl font-semibold hover:bg-blue-400 transition">
                        <i class="fas fa-users mr-2"></i>
                        <span>@lang('sponsor.cta_see_all')</span>
                    </a>
                </div>
            </div>

        </div>
    </section>

    <!-- Lightbox Galerie -->
    <div id="lightbox" class="fixed inset-0 bg-black bg-opacity-95 hidden flex items-center justify-center z-50 p-4"
        onclick="closeLightbox()">
        <div class="relative max-w-5xl w-full" onclick="event.stopPropagation()">
            <!-- Image -->
            <img id="lightbox-image" src="" class="w-full h-auto max-h-[80vh] rounded-lg shadow-2xl"
                alt="Photo agrandie">

            <!-- Légende -->
            <p id="lightbox-caption" class="text-white text-center mt-4 text-lg font-medium"></p>

            <!-- Bouton Fermer -->
            <button onclick="closeLightbox()"
                class="absolute -top-6 -right-6 bg-white text-gray-800 rounded-full w-14 h-14 flex items-center justify-center hover:bg-gray-100 transition shadow-lg"
                title="@lang('sponsor.close')">
                <i class="fas fa-times text-2xl"></i>
            </button>

            <!-- Navigation (optionnel si plus de 1 photo) -->
            @if ($sponsor->details && $sponsor->details->photos->count() > 1)
                <button onclick="previousPhoto()"
                    class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-16 bg-white bg-opacity-20 text-white rounded-full w-12 h-12 flex items-center justify-center hover:bg-opacity-40 transition">
                    <i class="fas fa-chevron-left text-xl"></i>
                </button>
                <button onclick="nextPhoto()"
                    class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-16 bg-white bg-opacity-20 text-white rounded-full w-12 h-12 flex items-center justify-center hover:bg-opacity-40 transition">
                    <i class="fas fa-chevron-right text-xl"></i>
                </button>
            @endif
        </div>
    </div>

    <!-- Scripts Lightbox -->
    <script>
        // Données des photos pour navigation
        const photos = [
            @foreach ($sponsor->details?->photos ?? [] as $photo)
                {
                    src: '{{ Storage::url($photo->photo) }}',
                    caption: '{{ $photo->caption ?? '' }}'
                },
            @endforeach
        ];
        let currentPhotoIndex = 0;

        // Ouvrir la lightbox
        function openLightbox(src, caption) {
            document.getElementById('lightbox-image').src = src;
            document.getElementById('lightbox-caption').textContent = caption;
            document.getElementById('lightbox').classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            // Trouver l'index de la photo
            currentPhotoIndex = photos.findIndex(p => p.src === src);
            if (currentPhotoIndex === -1) currentPhotoIndex = 0;
        }

        // Fermer la lightbox
        function closeLightbox() {
            document.getElementById('lightbox').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Photo précédente
        function previousPhoto() {
            currentPhotoIndex = (currentPhotoIndex - 1 + photos.length) % photos.length;
            updateLightbox();
        }

        // Photo suivante
        function nextPhoto() {
            currentPhotoIndex = (currentPhotoIndex + 1) % photos.length;
            updateLightbox();
        }

        // Mettre à jour l'affichage
        function updateLightbox() {
            const photo = photos[currentPhotoIndex];
            document.getElementById('lightbox-image').src = photo.src;
            document.getElementById('lightbox-caption').textContent = photo.caption;
        }

        // Navigation clavier
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'ArrowLeft' && photos.length > 1) previousPhoto();
            if (e.key === 'ArrowRight' && photos.length > 1) nextPhoto();
        });
    </script>

    <!-- Styles Lightbox -->
    <style>
        #lightbox {
            backdrop-filter: blur(5px);
        }

        #lightbox-image {
            animation: lightboxFadeIn 0.3s ease-out;
        }

        @keyframes lightboxFadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @media (max-width: 768px) {
            #lightbox button {
                -top-4 -right-4 w-10 h-10
            }

            #lightbox .fa-chevron-left,
            #lightbox .fa-chevron-right {
                display: none;
            }
        }
    </style>
@endsection
