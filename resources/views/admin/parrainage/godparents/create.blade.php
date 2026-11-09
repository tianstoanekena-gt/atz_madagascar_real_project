@extends('admin.layouts.master')
@section('title', 'Ajouter un Parrain')

@section('content')
    <section class="content_contents">
        <div class="godparent-form-wrapper">

            {{-- En-tête --}}
            <div class="form-header">
                <a href="{{ route('admin.godparents.index') }}" class="back-link">
                    <i class="fas fa-arrow-left"></i>
                    <span>Retour à la liste</span>
                </a>
                <div class="header-title">
                    <div class="title-icon">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div>
                        <h1 class="form-title">Ajouter un parrain</h1>
                        <p class="form-subtitle">Enregistrez les informations d'un nouveau parrain</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.godparents.store') }}" method="POST" enctype="multipart/form-data"
                class="godparent-form">
                @csrf

                {{-- SECTION 1 : IDENTITÉ --}}
                <div class="form-section">
                    <div class="section-header">
                        <div class="section-icon bg-blue">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <div>
                            <h2 class="section-title">Identité</h2>
                            <p class="section-desc">Informations personnelles du parrain</p>
                        </div>
                    </div>

                    <div class="form-grid">
                        {{-- Photo --}}
                        <div class="form-group full-width">
                            <label class="form-label">
                                <i class="fas fa-camera"></i>
                                Photo <span class="optional">(Facultatif)</span>
                            </label>
                            <div class="photo-upload">
                                <input type="file" name="photo" accept="image/*" id="photo-input" class="photo-input">
                                <label for="photo-input" class="photo-label">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span>Cliquez pour uploader une photo</span>
                                    <small>JPG, PNG - Max 2 Mo</small>
                                </label>
                                <div class="photo-preview" id="photo-preview"></div>
                            </div>
                            @error('photo')
                                <p class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Prénom --}}
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-user"></i>
                                Prénom <span class="required">*</span>
                            </label>
                            <input type="text" name="first_name" value="{{ old('first_name') }}"
                                class="form-input @error('first_name') input-error @enderror" placeholder="Ex: Jean"
                                required>
                            @error('first_name')
                                <p class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Nom --}}
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-user"></i>
                                Nom <span class="required">*</span>
                            </label>
                            <input type="text" name="last_name" value="{{ old('last_name') }}"
                                class="form-input @error('last_name') input-error @enderror" placeholder="Ex: Rakoto"
                                required>
                            @error('last_name')
                                <p class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- SECTION 2 : CONTACT --}}
                <div class="form-section">
                    <div class="section-header">
                        <div class="section-icon bg-green">
                            <i class="fas fa-address-book"></i>
                        </div>
                        <div>
                            <h2 class="section-title">Contact</h2>
                            <p class="section-desc">Moyens de communication du parrain</p>
                        </div>
                    </div>

                    <div class="form-grid">
                        {{-- Email --}}
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-envelope"></i>
                                Email <span class="required">*</span>
                            </label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="form-input @error('email') input-error @enderror" placeholder="exemple@email.com"
                                required>
                            @error('email')
                                <p class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        {{-- WhatsApp --}}
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fab fa-whatsapp"></i>
                                WhatsApp <span class="required">*</span>
                            </label>
                            <input type="text" name="whatsapp" value="{{ old('whatsapp') }}"
                                class="form-input @error('whatsapp') input-error @enderror" placeholder="+261 34 XX XXX XX"
                                required>
                            @error('whatsapp')
                                <p class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Adresse --}}
                        <div class="form-group full-width">
                            <label class="form-label">
                                <i class="fas fa-map-marker-alt"></i>
                                Adresse <span class="required">*</span>
                            </label>
                            <textarea name="address" rows="2" class="form-textarea @error('address') input-error @enderror"
                                placeholder="Adresse complète du parrain" required>{{ old('address') }}</textarea>
                            @error('address')
                                <p class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- BOUTONS D'ACTION --}}
                <div class="form-actions">
                    <a href="{{ route('admin.godparents.index') }}" class="btn btn-cancel">
                        <i class="fas fa-times"></i>
                        <span>Annuler</span>
                    </a>
                    <button type="submit" class="btn btn-submit">
                        <i class="fas fa-save"></i>
                        <span>Enregistrer le parrain</span>
                        <span class="btn-shine"></span>
                    </button>
                </div>
            </form>
        </div>
    </section>

    <style>
        :root {
            --form-primary: #0da3d8;
            --form-primary-dark: #087eaa;
            --form-secondary: #0d0c43;
            --form-yellow: #feed02;
            --form-green: #10b981;
            --form-red: #ef4444;
            --form-bg: #f8fafc;
            --form-white: #ffffff;
            --form-text: #1f2937;
            --form-muted: #6b7280;
            --form-border: #e5e7eb;
            --form-radius: 12px;
            --form-shadow: 0 4px 20px rgba(13, 12, 67, 0.08);
            --form-shadow-hover: 0 8px 30px rgba(13, 12, 67, 0.12);
            --form-transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .godparent-form-wrapper {
            max-width: 900px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        .form-header {
            margin-bottom: 2rem;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--form-muted);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 1.5rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all var(--form-transition);
        }

        .back-link:hover {
            color: var(--form-primary);
            background: rgba(13, 163, 216, 0.08);
        }

        .header-title {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .title-icon {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--form-primary), var(--form-primary-dark));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            box-shadow: 0 8px 20px rgba(13, 163, 216, 0.3);
        }

        .form-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--form-secondary);
            margin: 0 0 0.25rem 0;
        }

        .form-subtitle {
            color: var(--form-muted);
            font-size: 0.95rem;
            margin: 0;
        }

        .form-section {
            background: var(--form-white);
            border-radius: var(--form-radius);
            padding: 2rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--form-shadow);
            border: 1px solid var(--form-border);
            transition: all var(--form-transition);
        }

        .form-section:hover {
            box-shadow: var(--form-shadow-hover);
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--form-border);
        }

        .section-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: white;
            flex-shrink: 0;
        }

        .section-icon.bg-blue {
            background: linear-gradient(135deg, var(--form-primary), var(--form-primary-dark));
        }

        .section-icon.bg-green {
            background: linear-gradient(135deg, var(--form-green), #059669);
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--form-secondary);
            margin: 0 0 0.25rem 0;
        }

        .section-desc {
            color: var(--form-muted);
            font-size: 0.85rem;
            margin: 0;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--form-text);
            margin-bottom: 0.5rem;
        }

        .form-label i {
            color: var(--form-primary);
            font-size: 0.85rem;
        }

        .required {
            color: var(--form-red);
            font-weight: 700;
        }

        .optional {
            color: var(--form-muted);
            font-weight: 400;
            font-size: 0.8rem;
        }

        .form-input,
        .form-textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid var(--form-border);
            border-radius: 8px;
            font-size: 0.95rem;
            font-family: inherit;
            color: var(--form-text);
            background: var(--form-white);
            transition: all var(--form-transition);
        }

        .form-input:focus,
        .form-textarea:focus {
            outline: none;
            border-color: var(--form-primary);
            box-shadow: 0 0 0 3px rgba(13, 163, 216, 0.1);
        }

        .form-input::placeholder,
        .form-textarea::placeholder {
            color: #9ca3af;
        }

        .form-textarea {
            resize: vertical;
            min-height: 80px;
        }

        .input-error {
            border-color: var(--form-red) !important;
            background: rgba(239, 68, 68, 0.02);
        }

        .input-error:focus {
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        }

        .photo-upload {
            position: relative;
        }

        .photo-input {
            display: none;
        }

        .photo-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 2rem;
            border: 2px dashed var(--form-border);
            border-radius: 12px;
            background: rgba(13, 163, 216, 0.02);
            cursor: pointer;
            transition: all var(--form-transition);
            text-align: center;
        }

        .photo-label:hover {
            border-color: var(--form-primary);
            background: rgba(13, 163, 216, 0.05);
        }

        .photo-label i {
            font-size: 2rem;
            color: var(--form-primary);
        }

        .photo-label span {
            font-weight: 600;
            color: var(--form-text);
        }

        .photo-label small {
            color: var(--form-muted);
            font-size: 0.8rem;
        }

        .photo-preview {
            margin-top: 1rem;
            display: flex;
            justify-content: center;
        }

        .photo-preview img {
            max-width: 180px;
            max-height: 180px;
            border-radius: 12px;
            box-shadow: var(--form-shadow);
        }

        .error-message {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            color: var(--form-red);
            font-size: 0.8rem;
            font-weight: 500;
            margin-top: 0.4rem;
        }

        .error-message i {
            font-size: 0.75rem;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 2px solid var(--form-border);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: all var(--form-transition);
            position: relative;
            overflow: hidden;
        }

        .btn-cancel {
            background: var(--form-bg);
            color: var(--form-text);
            border: 2px solid var(--form-border);
        }

        .btn-cancel:hover {
            background: var(--form-border);
            border-color: var(--form-muted);
        }

        .btn-submit {
            background: linear-gradient(135deg, var(--form-primary), var(--form-primary-dark));
            color: white;
            box-shadow: 0 4px 12px rgba(13, 163, 216, 0.3);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(13, 163, 216, 0.4);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .btn-shine {
            position: absolute;
            top: 0;
            left: -100%;
            width: 60%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.6s ease;
        }

        .btn-submit:hover .btn-shine {
            left: 130%;
        }

        @media (max-width: 768px) {
            .godparent-form-wrapper {
                padding: 1rem;
            }

            .form-section {
                padding: 1.5rem;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .header-title {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .form-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>

    <script>
        document.getElementById('photo-input').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('photo-preview');
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" alt="Aperçu photo">`;
                };
                reader.readAsDataURL(file);
            } else {
                preview.innerHTML = '';
            }
        });
    </script>
@endsection
