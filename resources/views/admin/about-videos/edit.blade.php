@extends('admin.layouts.master')

@section('content')
    <section class="content_contents">
        <div class="container mx-auto px-4 py-6">

            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">
                    <i class="fab fa-youtube text-red-600 mr-2"></i>
                    Modifier la Vidéo #{{ $aboutVideo->id }}
                </h1>
                <a href="{{ route('admin.about-videos.index') }}" class="text-gray-600 hover:text-blue-600 transition">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour à la liste
                </a>
            </div>

            @if (session('success'))
                <div
                    class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded flex items-center gap-2">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div
                    class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded flex items-center gap-2">
                    <i class="fas fa-exclamation-circle"></i>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow-lg rounded-xl p-8 max-w-2xl">
                <form action="{{ route('admin.about-videos.update', $aboutVideo->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Aperçu Vidéo Actuelle -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-video mr-2"></i>
                            Vidéo actuelle
                        </label>
                        @php
                            $videoId = preg_replace(
                                '/.*(?:v=|\/|be\/)([a-zA-Z0-9_-]{11}).*/',
                                '$1',
                                $aboutVideo->video_url,
                            );
                        @endphp
                        <iframe src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allowfullscreen
                            class="w-full h-64 rounded-lg border-2 border-gray-200">
                        </iframe>
                        <p class="text-sm text-gray-500 mt-2">
                            <i class="fas fa-link mr-1"></i>
                            {{ $aboutVideo->video_url }}
                        </p>
                    </div>

                    <!-- Sélection Langue -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-language mr-2"></i>
                            Langue
                        </label>
                        <select name="lang"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            required>
                            @foreach ($languages as $code => $name)
                                <option value="{{ $code }}" {{ $aboutVideo->lang == $code ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                        @error('lang')
                            <p class="mt-2 text-sm text-red-600 flex items-center gap-2">
                                <i class="fas fa-exclamation-triangle"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- URL YouTube -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fab fa-youtube mr-2"></i>
                            Nouvelle URL YouTube
                        </label>
                        <input type="url" name="video_url" value="{{ old('video_url', $aboutVideo->video_url) }}"
                            placeholder="https://youtu.be/NGZ20jYANjg"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            required>
                        @error('video_url')
                            <p class="mt-2 text-sm text-red-600 flex items-center gap-2">
                                <i class="fas fa-exclamation-triangle"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-3 pt-6 border-t border-gray-200">
                        <button type="submit"
                            class="flex-1 flex items-center justify-center gap-2 bg-blue-600 text-white py-3 px-6 rounded-lg font-medium hover:bg-blue-700 transition shadow-md">
                            <i class="fas fa-save"></i>
                            <span>Mettre à jour la vidéo</span>
                        </button>
                        <a href="{{ route('admin.about-videos.index') }}"
                            class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition text-center">
                            <i class="fas fa-times mr-2"></i>
                            Annuler
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </section>
@endsection
