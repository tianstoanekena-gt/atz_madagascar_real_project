@extends('admin.layouts.master')

@section('content')
    <section class="content_contents">
        <div class="container mx-auto px-4 py-6">

            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">
                    <i class="fas fa-edit text-blue-600 mr-2"></i>
                    Modifier le Type de Contact
                </h1>
                <a href="{{ route('admin.contact-types.index') }}" class="text-gray-600 hover:text-blue-600 transition">
                    <i class="fas fa-arrow-left mr-2"></i>Retour
                </a>
            </div>

            @if ($errors->any())
                <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow-lg rounded-xl p-8 max-w-3xl">
                <form action="{{ route('admin.contact-types.update', $contactType->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nom -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-tag mr-2"></i>Nom du type *
                            </label>
                            <input type="text" name="name" value="{{ old('name', $contactType->name) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>

                        <!-- Classe d'icône -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-icons mr-2"></i>Classe d'icône *
                            </label>
                            <input type="text" name="icon_class"
                                value="{{ old('icon_class', $contactType->icon_class) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>

                        <!-- Slug -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-link mr-2"></i>Slug *
                            </label>
                            <input type="text" name="slug" value="{{ old('slug', $contactType->slug) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>

                        <!-- Placeholder -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-font mr-2"></i>Placeholder *
                            </label>
                            <input type="text" name="placeholder"
                                value="{{ old('placeholder', $contactType->placeholder) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>

                        <!-- Regex Validation -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-check-double mr-2"></i>Regex de Validation
                            </label>
                            <input type="text" name="validation_regex"
                                value="{{ old('validation_regex', $contactType->validation_regex) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- URL Template -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-globe mr-2"></i>Template d'URL *
                            </label>
                            <input type="text" name="url_template"
                                value="{{ old('url_template', $contactType->url_template) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>

                        <!-- Ordre -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-sort mr-2"></i>Ordre d'affichage *
                            </label>
                            <input type="number" name="order" value="{{ old('order', $contactType->order) }}"
                                min="0"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>

                        <!-- Statut Actif -->
                        <div class="flex items-center gap-3 mt-8">
                            <input type="checkbox" name="is_active" id="is_active" value="1"
                                {{ old('is_active', $contactType->is_active) ? 'checked' : '' }}
                                class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500">
                            <label for="is_active" class="text-sm font-medium text-gray-700">
                                <i class="fas fa-check-circle text-green-500 mr-1"></i>
                                Actif
                            </label>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-3 pt-6 border-t mt-6">
                        <button type="submit"
                            class="flex-1 bg-blue-600 text-white py-3 px-6 rounded-lg font-medium hover:bg-blue-700 transition">
                            <i class="fas fa-save mr-2"></i>Mettre à jour
                        </button>
                        <a href="{{ route('admin.contact-types.index') }}"
                            class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                            Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
