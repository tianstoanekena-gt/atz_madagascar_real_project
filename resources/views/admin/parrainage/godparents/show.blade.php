@extends('admin.layouts.master')
@section('title', 'Détail du Parrain')

@section('content')
    <section class="content_contents">
        <div class="container mx-auto px-4 py-6 max-w-5xl">
            <div class="flex items-center gap-3 mb-6">
                <a href="{{ route('admin.godparents.index') }}" class="text-gray-600 hover:text-blue-600"><i
                        class="fas fa-arrow-left text-xl"></i></a>
                <h1 class="text-2xl font-bold text-gray-800">Fiche de {{ $godparent->full_name }}</h1>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Infos Parrain -->
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <div class="text-center mb-4">
                        <div
                            class="w-24 h-24 mx-auto rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-3xl font-bold mb-3">
                            {{ strtoupper(substr($godparent->first_name, 0, 1)) }}
                        </div>
                        <h2 class="text-xl font-bold text-gray-800">{{ $godparent->full_name }}</h2>
                        <p class="text-sm text-gray-500">Parrain depuis le {{ $godparent->created_at->format('d/m/Y') }}</p>
                    </div>
                    <div class="space-y-3 text-sm">
                        <p><i class="fas fa-envelope text-blue-500 w-5"></i> {{ $godparent->email }}</p>
                        <p><i class="fab fa-whatsapp text-green-500 w-5"></i> <a href="{{ $godparent->whatsapp_link }}"
                                target="_blank" class="text-green-600 hover:underline">{{ $godparent->whatsapp }}</a></p>
                        <p><i class="fas fa-map-marker-alt text-red-500 w-5"></i> {{ $godparent->address }}</p>
                    </div>
                    <div class="mt-6 pt-4 border-t flex justify-between text-center">
                        <div>
                            <p class="text-2xl font-bold text-blue-600">{{ $godparent->students_count }}</p>
                            <p class="text-xs text-gray-500">Enfants parrainés</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-green-600">
                                {{ number_format($godparent->total_donated, 0, ',', ' ') }} Ar</p>
                            <p class="text-xs text-gray-500">Total donné</p>
                        </div>
                    </div>
                </div>

                <!-- Historique des parrainages -->
                <div class="md:col-span-2 bg-white p-6 rounded-xl shadow-md">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Historique des parrainages</h3>
                    @if ($godparent->sponsorships->count() > 0)
                        <div class="space-y-4">
                            @foreach ($godparent->sponsorships as $sponsorship)
                                <div
                                    class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-100">
                                    <div class="flex items-center gap-4">
                                        <img src="{{ $sponsorship->student->photo_url }}"
                                            class="w-12 h-12 rounded-full object-cover">
                                        <div>
                                            <p class="font-medium text-gray-800">{{ $sponsorship->student->full_name }}</p>
                                            <p class="text-xs text-gray-500">
                                                {{ $sponsorship->student->education_level_label }} -
                                                {{ $sponsorship->student->location }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-gray-800">{{ $sponsorship->formatted_amount }}</p>
                                        <span
                                            class="inline-block px-2 py-1 text-xs font-medium rounded-full bg-{{ $sponsorship->payment_status_color }}-100 text-{{ $sponsorship->payment_status_color }}-700">
                                            {{ $sponsorship->payment_status_label }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">Ce parrain n'a encore parrainé aucun enfant.</p>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
