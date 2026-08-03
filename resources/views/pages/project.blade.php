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
            {{-- Grille de projets dynamique --}}
            <div class="projects-grid">
                @forelse ($projects as $project)
                    <a href="{{ localized_route('projects.show', ['slug' => $project->slug]) }}">
                        <div class="project-card" data-status="{{ $project->status }}">
                            <div class="project-image-wrapper">
                                @if ($project->hero_image)
                                    <img src="{{ Storage::url($project->hero_image) }}" alt="{{ $project->title }}"
                                        class="project-image">
                                @else
                                    <div class="project-image"
                                        style="background: #e2e8f0; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-image text-4xl text-gray-400"></i>
                                    </div>
                                @endif

                                {{-- Badge dynamique selon le statut --}}
                                <span class="project-badge badge-{{ $project->status }}">
                                    @if ($project->status === 'completed')
                                        Réalisé
                                    @elseif ($project->status === 'ongoing')
                                        En cours
                                    @else
                                        À venir
                                    @endif
                                </span>
                            </div>

                            <div class="project-content">
                                <h3 class="project-title">{{ $project->title }}</h3>
                                <p class="project-description">
                                    {{ Str::limit($project->short_description, 100) }}
                                </p>

                                <div class="project-date">
                                    <svg fill="currentColor" viewBox="0 0 20 20" class="w-4 h-4 mr-2">
                                        <path fill-rule="evenodd"
                                            d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    @if ($project->start_date && $project->end_date)
                                        {{ $project->start_date->format('M Y') }} - {{ $project->end_date->format('M Y') }}
                                    @elseif ($project->start_date)
                                        Depuis {{ $project->start_date->format('M Y') }}
                                    @else
                                        Date à définir
                                    @endif
                                </div>

                                {{-- Barre de progression (si un objectif financier est défini) --}}
                                @if ($project->target_amount > 0)
                                    <div class="progress-bar">
                                        <div class="progress-fill progress-{{ $project->status }}"
                                            style="width: {{ $project->progress_percentage }}%"></div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-12 text-gray-500">
                        <i class="fas fa-folder-open text-4xl mb-3"></i>
                        <p>@lang('project.fallback')</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
