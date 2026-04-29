@extends('layouts.main')

@section('page-name', 'partenaire')

@section('content')
    <section class="sponsor-section">
        <div class="container">
            <h1 class="section-title">@lang('sponsor.section_title')</h1>
            <p class="section-intro">
                @lang('sponsor.section_intro')
            </p>

            {{-- Section Sponsors - Version Dynamique --}}
            <section id="sponsors" class="sponsors-section">

                {{-- Grille des cartes sponsors --}}
                <div class="sponsor-container">
                    @php
                        use App\Models\Sponsor;
                        use Illuminate\Support\Facades\Storage;

                        $currentLang = app()->getLocale();
                        $sponsors = Sponsor::with('translations')->active()->ordered()->get();
                    @endphp

                    @forelse ($sponsors as $sponsor)
                        @php
                            $translation = $sponsor->translation($currentLang);
                        @endphp

                        <div class="sponsor-card">
                            <div class="logo-wrapper">
                                @if ($sponsor->logo && Storage::disk('public')->exists($sponsor->logo))
                                    <img class="logo-sponsor" src="{{ Storage::url($sponsor->logo) }}"
                                        alt="{{ $sponsor->name }}">
                                @else
                                    <img class="logo-sponsor" src="{{ asset('assets/images/logo/default-sponsor.png') }}"
                                        alt="{{ $sponsor->name }}">
                                @endif
                            </div>
                            <div class="sponsor-info">
                                <h2 class="sponsor-name">{{ $sponsor->name }}</h2>
                                <p class="sponsor-desc">
                                    {{ $translation->short_description ?? 'Partenaire de l\'association.' }}
                                </p>
                            </div>
                            {{-- <a href="{{ localized_route('sponsors.show', ['slug' => $sponsor->slug]) }}"
                                class="sponsor-link">
                                @lang('sponsor.section_cta_btn')
                            </a> --}}
                            <a href="{{ route('sponsors.show', ['locale' => app()->getLocale(), 'slug' => $sponsor->slug]) }}"
                                class="sponsor-link">
                                @lang('sponsor.section_cta_btn')
                            </a>
                        </div>
                    @empty
                        <!-- Fallback si aucun sponsor en BDD -->
                        <div class="sponsor-card">
                            <div class="logo-wrapper">
                                <img class="logo-sponsor" src="{{ asset('assets/images/logo/baobab logo.jpg') }}"
                                    alt="BAOBAB">
                            </div>
                            <div class="sponsor-info">
                                <h2 class="sponsor-name">BAOBAB</h2>
                                <p class="sponsor-desc">
                                    Partenaire stratégique depuis 20XX, BAOBAB soutient nos programmes éducatifs et
                                    nutritionnels
                                    à travers Madagascar.
                                </p>
                            </div>
                            <a href="#" class="sponsor-link">@lang('sponsor.section_cta_btn')</a>
                        </div>
                    @endforelse
                </div>
        </div>
    </section>
    {{-- End Section Sponsors --}}
    </div>
    </section>


    <script>
        // Vanilla JS – léger, propre, évolutif
        document.addEventListener('DOMContentLoaded', function() {
            console.log('✅ Page Sponsors chargée');

            // Optionnel : ajouter un effet au clic sur "Détails"
            const detailLinks = document.querySelectorAll('.sponsor-link');
            detailLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    // e.preventDefault(); // si tu veux gérer via JS plus tard
                    this.classList.add('clicked');
                });
            });
        });
    </script>

@endsection



{{-- <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam, dolorum totam. Ut incidunt amet aspernatur sequi nihil natus quis minima eveniet. Quisquam doloremque quasi reiciendis excepturi laudantium distinctio deleniti. Accusamus labore odit repellendus iusto vitae consectetur corrupti. Maxime ullam ipsum labore distinctio iure alias dolor.</p> --}}
