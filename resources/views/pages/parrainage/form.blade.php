@extends('layouts.main')

@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/pages/parrainage.css') }}">

    <section class="parrainage-section">
        <div class="parrainage-container">

            {{-- Toasts --}}
            @if ($errors->any())
                <x-toast type="error" :message="'Veuillez corriger les erreurs ci-dessous.'" />
            @endif

            <div class="form-wrapper">
                <h2 class="parrainage-title" style="text-align: left; font-size: 2rem;">@lang('parrainage.form_title')</h2>

                {{-- Récapitulatif de l'élève --}}
                <div class="student-recap">
                    <img src="{{ $student->photo_url }}" alt="{{ $student->full_name }}" class="recap-photo">
                    <div class="recap-info">
                        <h3>{{ $student->full_name }}</h3>
                        <p><i class="fas fa-birthday-cake"></i> {{ $student->age }} ans -
                            {{ $student->education_level_label }}</p>
                        <p><i class="fas fa-map-marker-alt"></i> {{ $student->location }}</p>
                        <p style="margin-top: 8px; font-weight: 600; color: var(--color-blue);">
                            Objectif : {{ number_format($student->target_amount, 0, ',', ' ') }} Ar
                        </p>
                    </div>
                </div>

                {{-- Formulaire --}}
                <form action="{{ route('parrainage.store', $student->id) }}" method="POST" enctype="multipart/form-data"
                    class="parrainage-form">
                    @csrf

                    <div class="form-row">
                        <div class="form-group">
                            <label for="first_name">@lang('parrainage.form_first_name')</label>
                            <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}"
                                class="form-input @error('first_name') border-red-500 @enderror" required>
                            @error('first_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="last_name">@lang('parrainage.form_last_name')</label>
                            <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}"
                                class="form-input @error('last_name') border-red-500 @enderror" required>
                            @error('last_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">@lang('parrainage.form_email')</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                class="form-input @error('email') border-red-500 @enderror" required>
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="whatsapp">@lang('parrainage.form_whatsapp')</label>
                            <input type="text" id="whatsapp" name="whatsapp" value="{{ old('whatsapp') }}"
                                placeholder="+261..." class="form-input @error('whatsapp') border-red-500 @enderror"
                                required>
                            @error('whatsapp')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address">@lang('parrainage.form_address')</label>
                        <input type="text" id="address" name="address" value="{{ old('address') }}"
                            class="form-input @error('address') border-red-500 @enderror" required>
                        @error('address')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="amount">@lang('parrainage.form_amount')</label>
                        <input type="number" id="amount" name="amount" value="{{ old('amount') }}" min="10000"
                            class="form-input @error('amount') border-red-500 @enderror" required>
                        @error('amount')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror

                        {{-- Boutons de suggestion --}}
                        <div class="amount-suggestions">
                            <button type="button" class="amount-btn" onclick="setAmount(50000)">50 000 Ar</button>
                            <button type="button" class="amount-btn" onclick="setAmount(100000)">100 000 Ar</button>
                            <button type="button" class="amount-btn" onclick="setAmount(200000)">200 000 Ar</button>
                            <button type="button" class="amount-btn" onclick="setAmount(500000)">500 000 Ar</button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="message">@lang('parrainage.form_message') (Optionnel)</label>
                        <textarea id="message" name="message" rows="3" class="form-textarea">{{ old('message') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="payment_proof">@lang('parrainage.form_proof') (Optionnel)</label>
                        <input type="file" id="payment_proof" name="payment_proof" accept="image/*,application/pdf"
                            class="form-input">
                        @error('payment_proof')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="submit-btn">@lang('parrainage.form_submit')</button>
                </form>
            </div>
        </div>
    </section>

    <script>
        function setAmount(val) {
            document.getElementById('amount').value = val;
            // Retirer la classe active de tous les boutons
            document.querySelectorAll('.amount-btn').forEach(btn => btn.classList.remove('active'));
            // Ajouter la classe active au bouton cliqué (via event.target si besoin, ici simple)
            event.target.classList.add('active');
        }
    </script>
@endsection
