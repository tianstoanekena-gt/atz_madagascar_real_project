@extends('admin.layouts.master')
@section('title', 'Horaires d\'ouverture')

@section('content')
    <section class="content_contents">
        <div class="container mx-auto px-4 py-6">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-3">
                    <i class="fas fa-clock text-3xl text-blue-600"></i>
                    <h1 class="text-2xl font-bold text-gray-800">Horaires d'ouverture</h1>
                </div>
                <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-blue-600 transition">
                    <i class="fas fa-arrow-left mr-2"></i>Tableau de bord
                </a>
            </div>

            @if (session('success'))
                <div
                    class="mb-6 flex items-center gap-3 bg-green-100 border-l-4 border-green-500 text-green-700 px-6 py-4 rounded-lg">
                    <i class="fas fa-check-circle text-2xl"></i><span>{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 px-6 py-4 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.contact.opening-hours.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="p-6 border-b border-gray-200 bg-gray-50">
                        <p class="text-sm text-gray-600">
                            <i class="fas fa-info-circle mr-2"></i>
                            Cochez "Fermé" pour masquer les heures d'ouverture d'un jour donné. Les modifications sont
                            enregistrées pour tous les jours en une seule fois.
                        </p>
                    </div>

                    <div class="divide-y divide-gray-200">
                        @foreach ($hours as $hour)
                            <div
                                class="p-6 grid grid-cols-1 md:grid-cols-12 gap-4 items-center hover:bg-gray-50 transition">
                                {{-- Jour de la semaine --}}
                                <div class="md:col-span-3">
                                    <label class="block text-sm font-bold text-gray-800">{{ $hour->day }}</label>
                                    <input type="hidden" name="hours[{{ $hour->id }}][day]"
                                        value="{{ $hour->day }}">
                                </div>

                                {{-- Heure d'ouverture --}}
                                <div class="md:col-span-3">
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Ouverture</label>
                                    <input type="time" name="hours[{{ $hour->id }}][open_time]"
                                        value="{{ $hour->open_time ? \Carbon\Carbon::parse($hour->open_time)->format('H:i') : '' }}"
                                        class="hour-input w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                        {{ $hour->is_closed ? 'disabled' : '' }}>
                                </div>

                                {{-- Heure de fermeture --}}
                                <div class="md:col-span-3">
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Fermeture</label>
                                    <input type="time" name="hours[{{ $hour->id }}][close_time]"
                                        value="{{ $hour->close_time ? \Carbon\Carbon::parse($hour->close_time)->format('H:i') : '' }}"
                                        class="hour-input w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                        {{ $hour->is_closed ? 'disabled' : '' }}>
                                </div>

                                {{-- Statut Fermé --}}
                                <div class="md:col-span-3 flex items-center justify-end">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="hidden" name="hours[{{ $hour->id }}][is_closed]" value="0">
                                        <input type="checkbox" name="hours[{{ $hour->id }}][is_closed]" value="1"
                                            class="closed-checkbox sr-only peer" {{ $hour->is_closed ? 'checked' : '' }}
                                            onchange="toggleHours({{ $hour->id }}, this.checked)">
                                        <div
                                            class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-500">
                                        </div>
                                        <span class="ms-3 text-sm font-medium text-gray-700">Fermé</span>
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="p-6 bg-gray-50 border-t border-gray-200 flex justify-end">
                        <button type="submit" id="submit-btn"
                            class="flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition shadow-md">
                            <i class="fas fa-save"></i><span>Enregistrer les horaires</span>
                        </button>
                        are
                    </div>
                </div>
            </form>
        </div>
    </section>

    <script>
        function toggleHours(id, isClosed) {
            const openInput = document.querySelector(`input[name="hours[${id}][open_time]"]`);
            const closeInput = document.querySelector(`input[name="hours[${id}][close_time]"]`);

            if (isClosed) {
                openInput.disabled = true;
                closeInput.disabled = true;
                openInput.value = '';
                closeInput.value = '';
            } else {
                openInput.disabled = false;
                closeInput.disabled = false;
                // Valeurs par défaut si vides
                if (!openInput.value) openInput.value = '08:00';
                if (!closeInput.value) closeInput.value = '17:00';
            }
        }

        // Désactiver le bouton pendant l'envoi
        const form = document.querySelector('form');
        const submitBtn = document.getElementById('submit-btn');
        form.addEventListener('submit', function() {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>Enregistrement...</span>';
        });
    </script>
@endsection
