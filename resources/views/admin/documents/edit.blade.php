@extends('admin.layouts.master')

@section('title', 'Modifier le Document')

@section('content')
    <section class="content_contents">
        <div class="admin-container">

            <!-- Header -->
            <div class="page-header">
                <h1 class="page-title">
                    <i class="fas fa-edit mr-3"></i>
                    Modifier le Document
                </h1>
                <a href="{{ route('admin.documents.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour à la liste
                </a>
            </div>

            <!-- Formulaire -->
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.documents.update', $document->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Section: Fichier actuel + Upload -->
                        <div class="form-section mb-4">
                            <h5 class="section-title">
                                <i class="fas fa-file mr-2"></i>
                                Fichier
                            </h5>

                            <!-- Fichier actuel -->
                            <div class="mb-3 p-3 bg-light rounded">
                                <label class="form-label fw-bold">Fichier actuel :</label>
                                <div class="d-flex align-items-center gap-3">
                                    <i class="fas {{ $document->icon }} fa-2x {{ $document->type_class }} rounded p-2"></i>
                                    <div>
                                        <strong>{{ $document->file_original_name }}</strong>
                                        <br>
                                        <small class="text-muted">
                                            {{ $document->formatted_size }} •
                                            {{ $document->created_at->format('d/m/Y') }}
                                        </small>
                                    </div>
                                    {{-- <a href="{{ route('documents.download', $document->id) }}" target="_blank"
                                        class="btn btn-sm btn-outline-primary ms-auto">
                                        <i class="fas fa-download mr-1"></i>
                                        Télécharger
                                    </a> --}}
                                </div>
                            </div>

                            <!-- Nouveau fichier (optionnel) -->
                            <div class="mb-3">
                                <label for="file" class="form-label">Remplacer le fichier (optionnel)</label>
                                <input type="file" name="file" id="file"
                                    class="form-control @error('file') is-invalid @enderror"
                                    accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx">
                                <small class="form-text text-muted">
                                    Laissez vide pour conserver le fichier actuel • Max : 10 MB
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
                                        value="{{ old('title_fr', $document->title_fr) }}" maxlength="255"
                                        placeholder="Ex: Rapport annuel 2025">
                                    @error('title_fr')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="title_mg" class="form-label">Titre Malagasy</label>
                                    <input type="text" name="title_mg" id="title_mg"
                                        class="form-control @error('title_mg') is-invalid @enderror"
                                        value="{{ old('title_mg', $document->title_mg) }}" maxlength="255"
                                        placeholder="Ohatra: Tatitra taona 2025">
                                    @error('title_mg')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="title_en" class="form-label">Titre English</label>
                                    <input type="text" name="title_en" id="title_en"
                                        class="form-control @error('title_en') is-invalid @enderror"
                                        value="{{ old('title_en', $document->title_en) }}" maxlength="255"
                                        placeholder="Example: Annual Report 2025">
                                    @error('title_en')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
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
                                        rows="3" maxlength="5000" placeholder="Brève description du document...">{{ old('description_fr', $document->description_fr) }}</textarea>
                                    @error('description_fr')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="description_mg" class="form-label">Description Malagasy</label>
                                    <textarea name="description_mg" id="description_mg" class="form-control @error('description_mg') is-invalid @enderror"
                                        rows="3" maxlength="5000" placeholder="Famaritana fohy momba ny antontan-taratasy...">{{ old('description_mg', $document->description_mg) }}</textarea>
                                    @error('description_mg')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="description_en" class="form-label">Description English</label>
                                    <textarea name="description_en" id="description_en" class="form-control @error('description_en') is-invalid @enderror"
                                        rows="3" maxlength="5000" placeholder="Brief description of the document...">{{ old('description_en', $document->description_en) }}</textarea>
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
                                            id="is_published" value="1"
                                            {{ old('is_published', $document->is_published) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_published">
                                            Publié
                                        </label>
                                        <small class="form-text text-muted d-block">
                                            Si décoché, le document sera en brouillon (non visible sur le site)
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="order" class="form-label">Ordre d'affichage</label>
                                    <input type="number" name="order" id="order"
                                        class="form-control @error('order') is-invalid @enderror"
                                        value="{{ old('order', $document->order) }}" min="0"
                                        placeholder="0 = premier">
                                    <small class="form-text text-muted">
                                        Plus le chiffre est bas, plus le document apparaît en haut
                                    </small>
                                    @error('order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Stats (lecture seule) -->
                            <div class="row mt-4 pt-3 border-top">
                                <div class="col-md-6">
                                    <label class="form-label text-muted">Nombre de vues</label>
                                    <p class="form-control-plaintext fw-bold">
                                        <i class="fas fa-eye mr-2"></i>{{ number_format($document->view_count) }}
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted">Nombre de téléchargements</label>
                                    <p class="form-control-plaintext fw-bold">
                                        <i class="fas fa-download mr-2"></i>{{ number_format($document->download_count) }}
                                    </p>
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
                                Mettre à jour
                            </button>
                        </div>

                    </form>
                </div>
            </div>

            <!-- Zone de danger -->
            <div class="card mt-4 border-danger">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Zone de danger
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">
                        La suppression est irréversible. Le fichier sera définitivement effacé du serveur.
                    </p>
                    <form action="{{ route('admin.documents.destroy', $document->id) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Êtes-vous SÛR de vouloir supprimer ce document ? Cette action est irréversible.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash mr-2"></i>
                            Supprimer définitivement
                        </button>
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

        .fa-file-pdf {
            color: #dc3545;
        }

        .fa-file-word {
            color: #0d6efd;
        }

        .fa-file-excel {
            color: #198754;
        }

        .fa-file-powerpoint {
            color: #fd7e14;
        }

        .pdf-bg {
            background: rgba(220, 53, 69, 0.1);
        }

        .word-bg {
            background: rgba(13, 110, 253, 0.1);
        }

        .excel-bg {
            background: rgba(25, 135, 84, 0.1);
        }

        .ppt-bg {
            background: rgba(253, 126, 20, 0.1);
        }
    </style>
@endsection
