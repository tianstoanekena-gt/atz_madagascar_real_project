@extends('layouts.main')

@section('content')
    {{-- Section Projets --}}
    <section id="projects" class="projects-section">
        <div class="project-container">
            {{-- Titre de la section --}}
            <div class="section-header">
                <h2 class="section-title">@lang('project.sec_title')</h2>
                <p class="section-description">
                    @lang('project.sec_descri')
                </p>
                <div class="title-underline"></div>
            </div>

            {{-- Grille de projets --}}
            <div class="projects-grid">
                {{-- Projet 1 - Réalisé --}}
                <a href="{{ route('project.details') }}">
                    <div class="project-card" data-status="completed">
                        <div class="project-image-wrapper">
                            <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?w=500&h=300&fit=crop"
                                alt="Projet Éducation" class="project-image">
                            <span class="project-badge badge-completed">Réalisé</span>
                        </div>
                        <div class="project-content">
                            <h3 class="project-title">Programme de Parrainage Scolaire 2025/2026</h3>
                            <p class="project-description">
                                18 enfants parrainés pour l'année scolaire, avec fournitures et frais de scolarité pris en
                                charge.
                            </p>
                            <div class="project-date">
                                <svg fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                        clip-rule="evenodd" />
                                </svg>
                                Jan 2025 - Déc 2026
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill progress-completed" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>
@endsection
