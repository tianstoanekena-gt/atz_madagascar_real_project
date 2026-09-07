@extends('admin.layouts.master')
@section('title', 'Modifier le Parrain')

@section('content')
    <section class="content_contents">
        <div class="container mx-auto px-4 py-6 max-w-3xl">
            <div class="flex items-center gap-3 mb-6">
                <a href="{{ route('admin.godparents.index') }}" class="text-gray-600 hover:text-blue-600"><i
                        class="fas fa-arrow-left text-xl"></i></a>
                <h1 class="text-2xl font-bold text-gray-800">Modifier le parrain</h1>
            </div>

            <form action="{{ route('admin.godparents.update', $godparent->id) }}" method="POST" enctype="multipart/form-data"
                class="bg-white p-6 rounded-xl shadow-md space-y-6">
                @csrf @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
                        <input type="text" name="first_name" value="{{ old('first_name', $godparent->first_name) }}"
                            class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('first_name') border-red-500 @enderror"
                            required>
                        @error('first_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                        <input type="text" name="last_name" value="{{ old('last_name', $godparent->last_name) }}"
                            class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('last_name') border-red-500 @enderror"
                            required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $godparent->email) }}"
                        class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                        required>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">WhatsApp (Obligatoire)</label>
                    <input type="text" name="whatsapp" value="{{ old('whatsapp', $godparent->whatsapp) }}"
                        placeholder="+261..."
                        class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('whatsapp') border-red-500 @enderror"
                        required>
                    @error('whatsapp')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Adresse</label>
                    <textarea name="address" rows="2"
                        class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('address') border-red-500 @enderror"
                        required>{{ old('address', $godparent->address) }}</textarea>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t">
                    <a href="{{ route('admin.godparents.index') }}"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Annuler</a>
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">Mettre à
                        jour</button>
                </div>
            </form>
        </div>
    </section>
@endsection
