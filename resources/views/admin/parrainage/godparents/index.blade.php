@extends('admin.layouts.master')
@section('title', 'Liste des Parrains')

@section('content')
    <section class="content_contents">
        <div class="container mx-auto px-4 py-6">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-3">
                    <i class="fas fa-user-tie text-3xl text-blue-600"></i>
                    <h1 class="text-2xl font-bold text-gray-800">Parrains enregistrés</h1>
                </div>
            </div>

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-lg">
                    {{ session('success') }}</div>
            @endif

            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Parrain</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Contact</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Parrainages</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Total Donné</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($godparents as $godparent)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold">
                                            {{ strtoupper(substr($godparent->first_name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-800">{{ $godparent->full_name }}</p>
                                            <p class="text-xs text-gray-500">{{ $godparent->address }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    <p>{{ $godparent->email }}</p>
                                    <p class="text-xs text-green-600"><i class="fab fa-whatsapp"></i>
                                        {{ $godparent->whatsapp }}</p>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-800 font-medium">
                                    {{ $godparent->students_count }} enfant(s)
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-800 font-medium">
                                    {{ number_format($godparent->total_donated, 0, ',', ' ') }} Ar
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.godparents.show', $godparent->id) }}"
                                            class="bg-blue-100 text-blue-600 p-2 rounded-full hover:bg-blue-200"><i
                                                class="fas fa-eye"></i></a>
                                        <a href="{{ route('admin.godparents.edit', $godparent->id) }}"
                                            class="bg-yellow-100 text-yellow-600 p-2 rounded-full hover:bg-yellow-200"><i
                                                class="fas fa-edit"></i></a>
                                        @if ($godparent->sponsorships_count == 0)
                                            <form action="{{ route('admin.godparents.destroy', $godparent->id) }}"
                                                method="POST" onsubmit="return confirm('Supprimer ce parrain ?')">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-100 text-red-600 p-2 rounded-full hover:bg-red-200"><i
                                                        class="fas fa-trash"></i></button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-8 text-gray-500">Aucun parrain enregistré.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
