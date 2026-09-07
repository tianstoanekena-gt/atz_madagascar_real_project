@extends('admin.layouts.master')
@section('title', 'Détail de la demande')

@section('content')
    <section class="content_contents">
        <div class="container mx-auto px-4 py-6 max-w-4xl">
            <div class="flex items-center gap-3 mb-6">
                <a href="{{ route('admin.sponsorships.index') }}" class="text-gray-600 hover:text-blue-600"><i
                        class="fas fa-arrow-left text-xl"></i></a>
                <h1 class="text-2xl font-bold text-gray-800">Détail de la demande</h1>
                <span
                    class="ml-4 px-3 py-1 text-sm font-medium rounded-full bg-{{ $sponsorship->payment_status_color }}-100 text-{{ $sponsorship->payment_status_color }}-700">
                    {{ $sponsorship->payment_status_label }}
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Infos Parrain -->
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase mb-4">Parrain</h3>
                    <div class="flex items-center gap-4 mb-4">
                        <div
                            class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-xl font-bold">
                            {{ strtoupper(substr($sponsorship->godparent->first_name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-bold text-gray-800 text-lg">{{ $sponsorship->godparent->full_name }}</p>
                            <p class="text-sm text-gray-500">Fait le {{ $sponsorship->created_at->format('d/m/Y à H:i') }}
                            </p>
                        </div>
                    </div>
                    <div class="space-y-2 text-sm">
                        <p><i class="fas fa-envelope text-blue-500 w-5"></i> {{ $sponsorship->godparent->email }}</p>
                        <p><i class="fab fa-whatsapp text-green-500 w-5"></i> {{ $sponsorship->godparent->whatsapp }}</p>
                        <p><i class="fas fa-map-marker-alt text-red-500 w-5"></i> {{ $sponsorship->godparent->address }}</p>
                    </div>
                </div>

                <!-- Infos Élève & Don -->
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase mb-4">Élève & Don</h3>
                    <div class="flex items-center gap-4 mb-4">
                        <img src="{{ $sponsorship->student->photo_url }}"
                            class="w-14 h-14 rounded-full object-cover border-2 border-blue-100">
                        <div>
                            <p class="font-bold text-gray-800 text-lg">{{ $sponsorship->student->full_name }}</p>
                            <p class="text-sm text-gray-500">{{ $sponsorship->student->education_level_label }} -
                                {{ $sponsorship->student->age }} ans</p>
                        </div>
                    </div>
                    <div class="bg-blue-50 p-4 rounded-lg text-center">
                        <p class="text-xs text-blue-600 uppercase font-semibold">Montant du don</p>
                        <p class="text-2xl font-bold text-blue-800 mt-1">{{ $sponsorship->formatted_amount }}</p>
                    </div>
                </div>
            </div>

            <!-- Message du parrain -->
            @if ($sponsorship->message)
                <div class="bg-white p-6 rounded-xl shadow-md mt-6">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase mb-3">Message du parrain</h3>
                    <p class="text-gray-700 italic bg-gray-50 p-4 rounded-lg border-l-4 border-blue-400">
                        "{{ $sponsorship->message }}"
                    </p>
                </div>
            @endif

            <!-- Actions CM -->
            @if ($sponsorship->payment_status == 'pending')
                <div class="mt-6 flex justify-end gap-4">
                    <form action="{{ route('admin.sponsorships.approve', $sponsorship->id) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium flex items-center gap-2">
                            <i class="fas fa-check-circle"></i> Valider le paiement
                        </button>
                    </form>
                    <form action="{{ route('admin.sponsorships.reject', $sponsorship->id) }}" method="POST"
                        onsubmit="return confirm('Rejeter définitivement cette demande ?')">
                        @csrf
                        <button type="submit"
                            class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium flex items-center gap-2">
                            <i class="fas fa-times-circle"></i> Rejeter
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </section>
@endsection
