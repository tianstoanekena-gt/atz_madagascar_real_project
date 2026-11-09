@extends('admin.layouts.master')
@section('title', 'Nouveau Parrainage')

@section('content')
    <section class="content_contents">
        <div class="container mx-auto px-4 py-6 max-w-3xl">
            <div class="flex items-center gap-3 mb-6">
                <a href="{{ route('admin.sponsorships.index') }}" class="text-gray-600 hover:text-blue-600">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
                <h1 class="text-2xl font-bold text-gray-800">Créer un nouveau parrainage</h1>
            </div>

            <form action="{{ route('admin.sponsorships.store') }}" method="POST"
                class="bg-white p-6 rounded-xl shadow-md space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Sélection du Parrain --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Parrain <span
                                class="text-red-500">*</span></label>
                        <select name="godparent_id"
                            class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('godparent_id') border-red-500 @enderror"
                            required>
                            <option value="">-- Sélectionner un parrain --</option>
                            @foreach ($godparents as $gp)
                                <option value="{{ $gp->id }}" {{ $selectedGodparent == $gp->id ? 'selected' : '' }}>
                                    {{ $gp->full_name }} ({{ $gp->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('godparent_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Sélection de l'Élève --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Élève à parrainer <span
                                class="text-red-500">*</span></label>
                        <select name="student_id"
                            class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('student_id') border-red-500 @enderror"
                            required>
                            <option value="">-- Sélectionner un élève --</option>
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}"
                                    {{ $selectedStudent == $student->id ? 'selected' : '' }}>
                                    {{ $student->full_name }} - {{ $student->education_level_label }} (Reste:
                                    {{ number_format($student->remaining_amount, 0, ',', ' ') }} Ar)
                                </option>
                            @endforeach
                        </select>
                        @error('student_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Montant --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Montant promis (Ar) <span
                            class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="number" name="amount" value="{{ old('amount') }}" min="1000" step="1000"
                            class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('amount') border-red-500 @enderror pl-4 pr-12"
                            required>
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 font-medium">Ar</span>
                    </div>
                    @error('amount')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Ce montant sera ajouté directement au total collecté de l'élève.
                    </p>
                </div>

                {{-- Message --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Message / Notes (Facultatif)</label>
                    <textarea name="message" rows="3"
                        class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('message') border-red-500 @enderror"
                        placeholder="Ex: Engagement pris par téléphone le 12/10, paiement prévu en 3 fois...">{{ old('message') }}</textarea>
                    @error('message')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Boutons --}}
                <div class="flex justify-end gap-3 pt-4 border-t">
                    <a href="{{ route('admin.sponsorships.index') }}"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium">Annuler</a>
                    <button type="submit"
                        class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium flex items-center gap-2">
                        <i class="fas fa-check-circle"></i>
                        <span>Valider et créer le parrainage</span>
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection
