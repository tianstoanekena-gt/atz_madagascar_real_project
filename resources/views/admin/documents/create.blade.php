@extends('admin.layouts.master')

@section('title', 'Ajouter un Document')

@section('content')
    <section class="content_contents">
        <div class="admin-container">

            <!-- Header -->
            <div class="page-header">
                <h1 class="page-title">
                    <i class="fas fa-plus-circle mr-3"></i>
                    Ajouter un Document
                </h1>
                <a href="{{ route('admin.documents.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour à la liste
                </a>
            </div>

            <!-- Formulaire -->
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.documents.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Section: Fichier -->
                        <div class="form-section mb-4">
                            <h5 class="section-title">
                                <i class="fas fa-upload mr-2"></i>
                                Fichier
                            </h5>

                            <div class="mb-3">
                                <label for="file" class="form-label required">Fichier *</label>
                                <input type="file" name="file" id="file"
                                    class="form-control @error('file') is-invalid @enderror"
                                    accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx" required>
                                <small class="form-text text-muted">
                                    Types autorisés : PDF, Word, Excel, PowerPoint • Max : 10 MB
                                </small>
                                @error('file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Section: Titres multilingues -->
                        <div class="form-section mb-4">
                            <h5 class="section-title">
                                <i class="fas fa-language mr-2"></i>
                                Titres (au moins un requis)
                            </h5>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="title_fr" class="form-label">Titre Français</label>
                                    <input type="text" name="title_fr" id="title_fr"
                                        class="form-control @error('title_fr') is-invalid @enderror"
                                        value="{{ old('title_fr') }}" maxlength="255" placeholder="Ex: Rapport annuel 2025">
                                    @error('title_fr')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="title_mg" class="form-label">Titre Malagasy</label>
                                    <input type="text" name="title_mg" id="title_mg"
                                        class="form-control @error('title_mg') is-invalid @enderror"
                                        value="{{ old('title_mg') }}" maxlength="255"
                                        placeholder="Ohatra: Tatitra taona 2025">
                                    @error('title_mg')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="title_en" class="form-label">Titre English</label>
                                    <input type="text" name="title_en" id="title_en"
                                        class="form-control @error('title_en') is-invalid @enderror"
                                        value="{{ old('title_en') }}" maxlength="255"
                                        placeholder="Example: Annual Report 2025">
                                    @error('title_en')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            @error('title_fr')
                                @if (!$errors->has('title_mg') && !$errors->has('title_en'))
                                    <div class="text-danger small">* Au moins un titre est requis</div>
                                @endif
                            @enderror
                        </div>

                        <!-- Section: Descriptions multilingues -->
                        <div class="form-section mb-4">
                            <h5 class="section-title">
                                <i class="fas fa-align-left mr-2"></i>
                                Descriptions (optionnel)
                            </h5>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="description_fr" class="form-label">Description Français</label>
                                    <textarea name="description_fr" id="description_fr" class="form-control @error('description_fr') is-invalid @enderror"
                                        rows="3" maxlength="5000" placeholder="Brève description du document...">{{ old('description_fr') }}</textarea>
                                    @error('description_fr')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="description_mg" class="form-label">Description Malagasy</label>
                                    <textarea name="description_mg" id="description_mg" class="form-control @error('description_mg') is-invalid @enderror"
                                        rows="3" maxlength="5000" placeholder="Famaritana fohy momba ny antontan-taratasy...">{{ old('description_mg') }}</textarea>
                                    @error('description_mg')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="description_en" class="form-label">Description English</label>
                                    <textarea name="description_en" id="description_en" class="form-control @error('description_en') is-invalid @enderror"
                                        rows="3" maxlength="5000" placeholder="Brief description of the document...">{{ old('description_en') }}</textarea>
                                    @error('description_en')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Section: Paramètres -->
                        <div class="form-section mb-4">
                            <h5 class="section-title">
                                <i class="fas fa-cog mr-2"></i>
                                Paramètres
                            </h5>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_published"
                                            id="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_published">
                                            Publier immédiatement
                                        </label>
                                        <small class="form-text text-muted d-block">
                                            Si décoché, le document sera en brouillon
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="order" class="form-label">Ordre d'affichage</label>
                                    <input type="number" name="order" id="order"
                                        class="form-control @error('order') is-invalid @enderror"
                                        value="{{ old('order', 0) }}" min="0" placeholder="0 = premier">
                                    <small class="form-text text-muted">
                                        Plus le chiffre est bas, plus le document apparaît en haut
                                    </small>
                                    @error('order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                            <a href="{{ route('admin.documents.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times mr-2"></i>
                                Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-2"></i>
                                Enregistrer le document
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </section>
    <!-- Styles additionnels -->
    <style>
        .form-section {
            background: #f8f9fa;
            padding: 1.25rem;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #0d6efd;
        }

        .required::after {
            content: " *";
            color: #dc3545;
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }
    </style>

    <!-- Script: Prévisualisation du nom de fichier -->
    <script>
        document.getElementById('file').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name;
            if (fileName) {
                // Optionnel : afficher un aperçu du nom sélectionné
                console.log('Fichier sélectionné :', fileName);
            }
        });
    </script>
@endsection
