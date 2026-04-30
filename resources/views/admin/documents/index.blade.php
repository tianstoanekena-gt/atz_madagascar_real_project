@extends('admin.layouts.master')

@section('title', 'Gestion des Documents')

@section('content')
    <section class="content_contents">
        <div class="admin-container mt-11">

            <!-- Header -->
            <div class="page-header">
                <h1 class="page-title">
                    <i class="fas fa-file-alt mr-3"></i>
                    Gestion des Documents
                </h1>
                <a href="{{ route('admin.documents.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus mr-2"></i>
                    Ajouter un document
                </a>
            </div>

            <!-- Stats rapides -->
            <div class="stats-grid mb-6">
                <div class="stat-card">
                    <i class="fas fa-file-pdf text-red-500"></i>
                    <div>
                        <span class="stat-number">{{ \App\Models\Document::ofType('pdf')->count() }}</span>
                        <span class="stat-label">PDF</span>
                    </div>
                </div>
                <div class="stat-card">
                    <i class="fas fa-file-word text-blue-500"></i>
                    <div>
                        <span class="stat-number">{{ \App\Models\Document::ofType('word')->count() }}</span>
                        <span class="stat-label">Word</span>
                    </div>
                </div>
                <div class="stat-card">
                    <i class="fas fa-file-excel text-green-500"></i>
                    <div>
                        <span class="stat-number">{{ \App\Models\Document::ofType('excel')->count() }}</span>
                        <span class="stat-label">Excel</span>
                    </div>
                </div>
                <div class="stat-card">
                    <i class="fas fa-file-powerpoint text-orange-500"></i>
                    <div>
                        <span class="stat-number">{{ \App\Models\Document::ofType('powerpoint')->count() }}</span>
                        <span class="stat-label">PowerPoint</span>
                    </div>
                </div>
            </div>

            <!-- Messages de feedback -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Tableau des documents -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Liste des documents</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Document</th>
                                    <th>Type</th>
                                    <th>Taille</th>
                                    <th>Vues</th>
                                    <th>Téléchargements</th>
                                    <th>Statut</th>
                                    <th>Ordre</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($documents as $document)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i
                                                    class="fas {{ $document->icon }} fa-2x me-3 {{ $document->type_class }}"></i>
                                                <div>
                                                    <strong>{{ $document->title }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $document->file_original_name }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $document->file_type === 'pdf' ? 'danger' : ($document->file_type === 'word' ? 'primary' : ($document->file_type === 'excel' ? 'success' : 'warning')) }}">
                                                {{ strtoupper($document->file_type) }}
                                            </span>
                                        </td>
                                        <td>{{ $document->formatted_size }}</td>
                                        <td>{{ number_format($document->view_count) }}</td>
                                        <td>{{ number_format($document->download_count) }}</td>
                                        <td>
                                            @if ($document->is_published)
                                                <span class="badge bg-success">Publié</span>
                                            @else
                                                <span class="badge bg-secondary">Brouillon</span>
                                            @endif
                                        </td>
                                        <td>{{ $document->order }}</td>
                                        <td class="text-end">
                                            <div class="btn-group">
                                                <a href="{{ route('admin.documents.edit', $document->id) }}"
                                                    class="btn btn-sm btn-outline-primary" title="Modifier">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.documents.destroy', $document->id) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Supprimer ce document ? Cette action est irréversible.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        title="Supprimer">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5 text-muted">
                                            <i class="fas fa-folder-open fa-3x mb-3 d-block"></i>
                                            Aucun document pour le moment.
                                            <br>
                                            <a href="{{ route('admin.documents.create') }}"
                                                class="btn btn-sm btn-primary mt-3">
                                                Ajouter le premier document
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                @if ($documents->hasPages())
                    <div class="card-footer">
                        {{ $documents->links() }}
                    </div>
                @endif
            </div>

        </div>
    </section>
    <!-- Styles additionnels pour les icônes de type -->
    <style>
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
