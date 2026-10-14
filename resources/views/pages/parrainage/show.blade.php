@extends('layouts.main')
@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/pages/parrainage.css') }}">

    <section class="parrainage-section">
        <div class="parrainage-container" style="max-width: 1000px;">

            {{-- Bouton Retour --}}
            <div class="mb-6">
                <a href="{{ route('parrainage.index') }}"
                    class="inline-flex items-center gap-2 text-sm font-semibold text-gray-600 hover:text-[#0da3d8] transition">
                    <i class="fas fa-arrow-left"></i>
                    <span>Retour à la liste des élèves</span>
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                <div class="grid grid-cols-1 lg:grid-cols-2">

                    {{-- COLONNE GAUCHE : PHOTO & INFO CLÉS --}}
                    <div
                        class="relative bg-gradient-to-br from-[#0d0c43] to-[#191854] p-8 text-white flex flex-col justify-between">
                        <div>
                            <div
                                class="relative w-48 h-48 mx-auto lg:mx-0 mb-6 rounded-full overflow-hidden border-4 border-[#feed02] shadow-2xl">
                                <img src="{{ $student->photo_url }}" alt="{{ $student->full_name }}"
                                    class="w-full h-full object-cover">
                            </div>

                            <h1 class="text-3xl lg:text-4xl font-extrabold mb-2 text-center lg:text-left">
                                {{ $student->full_name }}</h1>

                            <div class="flex flex-wrap gap-3 justify-center lg:justify-start mb-6">
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/10 backdrop-blur-sm rounded-full text-sm font-medium border border-white/20">
                                    <i class="fas fa-birthday-cake text-[#feed02]"></i> {{ $student->age }} ans
                                </span>
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/10 backdrop-blur-sm rounded-full text-sm font-medium border border-white/20">
                                    <i class="fas fa-graduation-cap text-[#feed02]"></i>
                                    {{ $student->education_level_label }}
                                </span>
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/10 backdrop-blur-sm rounded-full text-sm font-medium border border-white/20">
                                    <i class="fas fa-map-marker-alt text-[#feed02]"></i> {{ $student->location }}
                                </span>
                            </div>
                        </div>

                        {{-- Barre de progression dans la colonne gauche --}}
                        <div class="bg-white/10 backdrop-blur-md rounded-xl p-5 border border-white/10">
                            <div class="flex justify-between items-end mb-3">
                                <div>
                                    <p class="text-xs uppercase tracking-wider text-gray-300 font-semibold mb-1">Objectif
                                    </p>
                                    <p class="text-2xl font-bold text-[#feed02]">
                                        {{ number_format($student->target_amount, 0, ',', ' ') }} <small
                                            class="text-sm">Ar</small></p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs uppercase tracking-wider text-gray-300 font-semibold mb-1">Collecté
                                    </p>
                                    <p class="text-xl font-bold text-white">
                                        {{ number_format($student->collected_amount, 0, ',', ' ') }} <small
                                            class="text-sm">Ar</small></p>
                                </div>
                            </div>
                            <div class="w-full bg-gray-700 rounded-full h-3 mb-2">
                                <div class="bg-gradient-to-r from-[#feed02] to-[#0da3d8] h-3 rounded-full transition-all duration-1000"
                                    style="width: {{ $student->progress }}%"></div>
                            </div>
                            <p class="text-center text-sm font-semibold text-[#feed02]">{{ $student->progress }}% atteint
                            </p>
                        </div>
                    </div>

                    {{-- COLONNE DROITE : HISTOIRE & ACTION --}}
                    <div class="p-8 lg:p-10 flex flex-col">
                        <div class="mb-8">
                            <h2 class="text-xl font-bold text-[#0d0c43] mb-4 flex items-center gap-2">
                                <i class="fas fa-book-open text-[#0da3d8]"></i>
                                Son histoire
                            </h2>
                            <div
                                class="prose prose-blue max-w-none text-gray-600 leading-relaxed bg-blue-50/50 p-5 rounded-xl border-l-4 border-[#0da3d8]">
                                {!! nl2br(e($student->description_translated)) !!}
                            </div>
                        </div>

                        <div class="mb-8">
                            <h2 class="text-xl font-bold text-[#0d0c43] mb-4 flex items-center gap-2">
                                <i class="fas fa-hands-helping text-[#0da3d8]"></i>
                                Ses besoins spécifiques
                            </h2>
                            <div
                                class="text-gray-600 leading-relaxed bg-yellow-50/50 p-5 rounded-xl border-l-4 border-[#feed02]">
                                {!! nl2br(e($student->needs_translated)) !!}
                            </div>
                        </div>

                        {{-- CTA FINAL --}}
                        <div class="mt-auto pt-6 border-t border-gray-100">
                            <div class="bg-gradient-to-r from-[#0d0c43] to-[#191854] rounded-xl p-6 text-center text-white">
                                <h3 class="text-xl font-bold mb-2">Vous souhaitez parrainer
                                    {{ explode(' ', $student->first_name)[0] }} ?</h3>
                                <p class="text-gray-300 text-sm mb-5">Notre équipe se fera un plaisir de vous accompagner
                                    dans cette belle démarche. Contactez-nous pour initier le parrainage.</p>

                                <a href="{{ route('contact') }}"
                                    class="inline-flex items-center justify-center gap-2 w-full sm:w-auto px-8 py-4 bg-[#feed02] text-[#0d0c43] font-extrabold rounded-xl hover:bg-[#0da3d8] hover:text-white transition-all duration-300 transform hover:-translate-y-1 shadow-lg hover:shadow-xl">
                                    <i class="fas fa-heart"></i>
                                    <span>Contacter pour parrainer</span>
                                    <i class="fas fa-arrow-right"></i>
                                </a>

                                <p class="text-xs text-gray-400 mt-4">
                                    <i class="fas fa-shield-alt"></i> Démarche 100% sécurisée et accompagnée par notre
                                    équipe.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
