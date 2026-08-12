@extends('admin.layouts.master')
@section('title', 'Message de ' . $message->name)

@section('content')
    <section class="content_contents">
        <div class="container mx-auto px-4 py-6">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-3">
                    <i class="fas fa-envelope-open-text text-3xl text-blue-600"></i>
                    <h1 class="text-2xl font-bold text-gray-800">Message de {{ $message->name }}</h1>
                    @if ($message->is_read)
                        <span
                            class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                            <i class="fas fa-envelope-open"></i> Lu
                        </span>
                    @else
                        <span
                            class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                            <i class="fas fa-envelope"></i> Nouveau
                        </span>
                    @endif
                </div>
                <a href="{{ route('admin.contact.messages.index') }}" class="text-gray-600 hover:text-blue-600 transition">
                    <i class="fas fa-arrow-left mr-2"></i>Retour à la liste
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Colonne gauche : Infos expéditeur --}}
                <div class="lg:col-span-1">
                    <div class="bg-white shadow-lg rounded-xl p-6 sticky top-6">
                        <h2 class="text-sm font-semibold text-gray-500 uppercase mb-4">Expéditeur</h2>

                        <div class="space-y-4">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Nom</p>
                                <p class="text-base font-semibold text-gray-800">{{ $message->name }}</p>
                            </div>

                            <div>
                                <p class="text-xs text-gray-500 mb-1">Email</p>
                                <a href="mailto:{{ $message->email }}"
                                    class="text-base text-blue-600 hover:underline break-all">
                                    {{ $message->email }}
                                </a>
                            </div>

                            <div>
                                <p class="text-xs text-gray-500 mb-1">Reçu le</p>
                                <p class="text-base text-gray-800">
                                    {{ $message->created_at->format('d/m/Y à H:i') }}
                                </p>
                            </div>

                            <div class="pt-4 border-t border-gray-200">
                                <form action="{{ route('admin.contact.messages.update', $message->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="is_read" value="{{ $message->is_read ? 0 : 1 }}">
                                    <button type="submit"
                                        class="w-full flex items-center justify-center gap-2 bg-orange-100 text-orange-700 px-4 py-2 rounded-lg font-medium hover:bg-orange-200 transition">
                                        <i class="fas {{ $message->is_read ? 'fa-envelope' : 'fa-envelope-open' }}"></i>
                                        <span>Marquer comme {{ $message->is_read ? 'non lu' : 'lu' }}</span>
                                    </button>
                                </form>

                                <a href="mailto:{{ $message->email }}"
                                    class="w-full flex items-center justify-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-blue-700 transition mt-3">
                                    <i class="fas fa-reply"></i>
                                    <span>Répondre par email</span>
                                </a>

                                <form action="{{ route('admin.contact.messages.destroy', $message->id) }}" method="POST"
                                    class="mt-3" onsubmit="return confirm('Supprimer définitivement ce message ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="w-full flex items-center justify-center gap-2 bg-red-100 text-red-700 px-4 py-2 rounded-lg font-medium hover:bg-red-200 transition">
                                        <i class="fas fa-trash"></i>
                                        <span>Supprimer</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Colonne droite : Contenu du message --}}
                <div class="lg:col-span-2">
                    <div class="bg-white shadow-lg rounded-xl p-8">
                        <div class="flex items-center gap-2 mb-6 pb-4 border-b border-gray-200">
                            <i class="fas fa-comment-dots text-blue-600 text-xl"></i>
                            <h2 class="text-lg font-bold text-gray-800">Contenu du message</h2>
                        </div>

                        <div class="prose max-w-none text-gray-700 leading-relaxed whitespace-pre-wrap">
                            {{ $message->message }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
