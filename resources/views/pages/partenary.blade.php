@extends('layouts.main')

@section('page-name', 'partenaire')

@section('content')
    <section class="sponsor-section">
        <div class="container">
            <h1 class="section-title">Bienvenue dans la page : « partenaires »</h1>
            <p class="section-intro">
                Nous remercions chaleureusement nos partenaires pour leur soutien indéfectible à la mission d’ATZ
                Madagascar.
            </p>

            <div class="sponsor-container">
                <div class="sponsor-card">
                    <div class="logo-wrapper">
                        <img class="logo-sponsor" src="{{ asset('assets/images/logo/baobab logo.jpg') }}" alt="BAOBAB">
                    </div>
                    <div class="sponsor-info">
                        <h2 class="sponsor-name">BAOBAB</h2>
                        <p class="sponsor-desc">
                            Partenaire stratégique depuis 20XX, BAOBAB soutient nos programmes éducatifs et nutritionnels
                            à travers Madagascar.
                        </p>
                    </div>
                    <a href="#" class="sponsor-link">Détails</a>
                </div>

            </div>
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
