@extends('admin.layouts.master')
@section('title', 'Demandes de parrainage')

@section('content')
    <section class="content_contents">
        <div class="container mx-auto px-4 py-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-3">
                    <i class="fas fa-hand-holding-heart text-3xl text-blue-600"></i> Demandes de parrainage
                </h1>
            </div>

            {{-- Filtres --}}
            <form method="GET" action="{{ route('admin.sponsorships.index') }}"
                class="bg-white p-4 rounded-xl shadow-sm mb-6 flex flex-wrap gap-4 items-end">
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Statut</label>
                    <select name="status"
                        class="border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                        <option value="">Tous les statuts</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                        <option value="validated" {{ request('status') == 'validated' ? 'selected' : '' }}>Validé</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejeté</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Élève</label>
                    <select name="student_id"
                        class="border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                        <option value="">Tous les élèves</option>
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}"
                                {{ request('student_id') == $student->id ? 'selected' : '' }}>{{ $student->full_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">Filtrer</button>
            </form>

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-lg">
                    {{ session('success') }}</div>
            @endif

            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Date</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Parrain</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Élève</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Montant</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Statut</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($sponsorships as $sponsorship)
                            <tr
                                class="hover:bg-gray-50 transition {{ $sponsorship->payment_status == 'pending' ? 'bg-yellow-50/30' : '' }}">
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $sponsorship->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-medium text-gray-800">{{ $sponsorship->godparent->full_name }}</p>
                                    <p class="text-xs text-gray-500">{{ $sponsorship->godparent->email }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <img src="{{ $sponsorship->student->photo_url }}"
                                            class="w-8 h-8 rounded-full object-cover">
                                        <p class="text-sm text-gray-800">{{ $sponsorship->student->full_name }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm font-bold text-gray-800">{{ $sponsorship->formatted_amount }}
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2 py-1 text-xs font-medium rounded-full bg-{{ $sponsorship->payment_status_color }}-100 text-{{ $sponsorship->payment_status_color }}-700">
                                        {{ $sponsorship->payment_status_label }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.sponsorships.show', $sponsorship->id) }}"
                                            class="bg-blue-100 text-blue-600 p-2 rounded-full hover:bg-blue-200"><i
                                                class="fas fa-eye"></i></a>

                                        @if ($sponsorship->payment_status == 'pending')
                                            <form action="{{ route('admin.sponsorships.approve', $sponsorship->id) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="bg-green-100 text-green-600 p-2 rounded-full hover:bg-green-200"
                                                    title="Valider"><i class="fas fa-check"></i></button>
                                            </form>
                                            <form action="{{ route('admin.sponsorships.reject', $sponsorship->id) }}"
                                                method="POST" class="inline"
                                                onsubmit="return confirm('Rejeter cette demande ?')">
                                                @csrf
                                                <button type="submit"
                                                    class="bg-red-100 text-red-600 p-2 rounded-full hover:bg-red-200"
                                                    title="Rejeter"><i class="fas fa-times"></i></button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 text-gray-500">Aucune demande trouvée.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">{{ $sponsorships->links() }}</div>
        </div>
    </section>
@endsection
