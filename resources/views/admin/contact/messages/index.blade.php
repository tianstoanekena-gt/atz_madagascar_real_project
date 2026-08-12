@extends('admin.layouts.master')
@section('title', 'Messages de contact')

@section('content')
    <section class="content_contents">
        <div class="container mx-auto px-4 py-6">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-3">
                    <i class="fas fa-envelope-open-text text-3xl text-blue-600"></i>
                    <h1 class="text-2xl font-bold text-gray-800">Messages reçus</h1>
                    @if ($unreadCount > 0)
                        <span
                            class="inline-flex items-center justify-center px-3 py-1 text-sm font-bold bg-red-500 text-white rounded-full">
                            {{ $unreadCount }} non lu{{ $unreadCount > 1 ? 's' : '' }}
                        </span>
                    @endif
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

            @if ($messages->count() > 0)
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Statut</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Nom</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Email</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Message</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Date</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($messages as $message)
                                <tr class="hover:bg-gray-50 transition {{ !$message->is_read ? 'bg-blue-50/30' : '' }}">
                                    <td class="px-6 py-4">
                                        @if ($message->is_read)
                                            <span
                                                class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                                <i class="fas fa-envelope-open text-xs"></i> Lu
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                                <i class="fas fa-envelope text-xs"></i> Nouveau
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-800 font-medium">{{ $message->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        <a href="mailto:{{ $message->email }}" class="hover:text-blue-600">
                                            {{ $message->email }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate">
                                        {{ Str::limit($message->message, 60) }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $message->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('admin.contact.messages.show', $message->id) }}"
                                                class="bg-blue-100 text-blue-600 p-2 rounded-full hover:bg-blue-200 transition"
                                                title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <form action="{{ route('admin.contact.messages.destroy', $message->id) }}"
                                                method="POST" class="inline"
                                                onsubmit="return confirm('Supprimer définitivement ce message ?')">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-100 text-red-600 p-2 rounded-full hover:bg-red-200 transition"
                                                    title="Supprimer">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($messages->hasPages())
                    <div class="mt-6">{{ $messages->links() }}</div>
                @endif
            @else
                <div class="text-center py-16 bg-white rounded-xl shadow-sm border border-dashed border-gray-300">
                    <i class="fas fa-inbox text-5xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-bold text-gray-700 mb-2">Aucun message</h3>
                    <p class="text-gray-500">Les messages envoyés via le formulaire de contact apparaîtront ici.</p>
                </div>
            @endif
        </div>
    </section>
@endsection
