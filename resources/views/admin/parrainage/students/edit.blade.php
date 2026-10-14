@extends('admin.layouts.master')
@section('title', 'Modifier un élève')

@section('content')
    <section class="content_contents">
        <div class="student-form-wrapper">

            {{-- En-tête --}}
            <div class="form-header">
                <a href="{{ route('admin.students.index') }}" class="back-link">
                    <i class="fas fa-arrow-left"></i>
                    <span>Retour à la liste</span>
                </a>
                <div class="header-title">
                    <div class="title-icon">
                        <i class="fas fa-user-edit"></i>
                    </div>
                    <div>
                        <h1 class="form-title">Modifier un élève</h1>
                        <p class="form-subtitle">Mettez à jour les informations du profil de parrainage</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.students.update', $student->id) }}" method="POST" enctype="multipart/form-data"
                class="student-form">
                @csrf
                @method('PUT')

                {{-- SECTION 1 : IDENTITÉ & CONTACT --}}
                <div class="form-section">
                    <div class="section-header">
                        <div class="section-icon bg-blue">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <div>
                            <h2 class="section-title">Identité & Contact</h2>
                            <p class="section-desc">Informations personnelles de l'élève</p>
                        </div>
                    </div>

                    <div class="form-grid">
                        {{-- Photo --}}
                        <div class="form-group full-width">
                            <label class="form-label">
                                <i class="fas fa-camera"></i>
                                Photo de l'élève <span class="optional">(Laisser vide pour garder l'actuelle)</span>
                            </label>
                            <div class="photo-upload">
                                <input type="file" name="photo" accept="image/*" id="photo-input" class="photo-input">
                                <label for="photo-input" class="photo-label">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span>Cliquez pour changer la photo</span>
                                    <small>JPG, PNG - Max 5 Mo</small>
                                </label>
                                <div class="photo-preview" id="photo-preview">
                                    @if ($student->photo_url)
                                        <img src="{{ $student->photo_url }}" alt="{{ $student->full_name }}">
                                    @endif
                                </div>
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
                            <input type="text" name="first_name" value="{{ old('first_name', $student->first_name) }}"
                                class="form-input @error('first_name') input-error @enderror" placeholder="Ex: Faly"
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
                            <input type="text" name="last_name" value="{{ old('last_name', $student->last_name) }}"
                                class="form-input @error('last_name') input-error @enderror" placeholder="Ex: Rakoto"
                                required>
                            @error('last_name')
                                <p class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Date de naissance --}}
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-birthday-cake"></i>
                                Date de naissance <span class="required">*</span>
                            </label>
                            <input type="date" name="birth_date"
                                value="{{ old('birth_date', $student->birth_date->format('Y-m-d')) }}"
                                max="{{ date('Y-m-d') }}" class="form-input @error('birth_date') input-error @enderror"
                                required>
                            @error('birth_date')
                                <p class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Genre --}}
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-venus-mars"></i>
                                Genre <span class="required">*</span>
                            </label>
                            <select name="gender" class="form-select @error('gender') input-error @enderror" required>
                                <option value="">-- Sélectionner --</option>
                                <option value="M" {{ old('gender', $student->gender) == 'M' ? 'selected' : '' }}>
                                    Masculin</option>
                                <option value="F" {{ old('gender', $student->gender) == 'F' ? 'selected' : '' }}>
                                    Féminin</option>
                            </select>
                            @error('gender')
                                <p class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Localisation --}}
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-map-marker-alt"></i>
                                Localisation <span class="required">*</span>
                            </label>
                            <input type="text" name="location" value="{{ old('location', $student->location) }}"
                                class="form-input @error('location') input-error @enderror" placeholder="Ex: Antananarivo"
                                required>
                            @error('location')
                                <p class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        {{-- WhatsApp --}}
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fab fa-whatsapp"></i>
                                WhatsApp <span class="optional">(Facultatif)</span>
                            </label>
                            <input type="text" name="whatsapp" value="{{ old('whatsapp', $student->whatsapp) }}"
                                class="form-input @error('whatsapp') input-error @enderror"
                                placeholder="+261 34 XX XXX XX">
                            @error('whatsapp')
                                <p class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- SECTION 2 : SCOLARITÉ & HISTOIRE --}}
                <div class="form-section">
                    <div class="section-header">
                        <div class="section-icon bg-yellow">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div>
                            <h2 class="section-title">Scolarité & Histoire</h2>
                            <p class="section-desc">Contexte éducatif et situation personnelle</p>
                        </div>
                    </div>

                    <div class="form-grid">
                        {{-- Niveau d'éducation --}}
                        <div class="form-group full-width">
                            <label class="form-label">
                                <i class="fas fa-book-open"></i>
                                Niveau d'éducation <span class="required">*</span>
                            </label>
                            <select name="education_level"
                                class="form-select @error('education_level') input-error @enderror" required>
                                <option value="">-- Sélectionner le niveau --</option>
                                <option value="primaire"
                                    {{ old('education_level', $student->education_level) == 'primaire' ? 'selected' : '' }}>
                                    Primaire</option>
                                <option value="college"
                                    {{ old('education_level', $student->education_level) == 'college' ? 'selected' : '' }}>
                                    Collège</option>
                                <option value="lycee"
                                    {{ old('education_level', $student->education_level) == 'lycee' ? 'selected' : '' }}>
                                    Lycée</option>
                                <option value="superieur"
                                    {{ old('education_level', $student->education_level) == 'superieur' ? 'selected' : '' }}>
                                    Études supérieures</option>
                                <option value="formation_pro"
                                    {{ old('education_level', $student->education_level) == 'formation_pro' ? 'selected' : '' }}>
                                    Formation professionnelle</option>
                            </select>
                            @error('education_level')
                                <p class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="form-group full-width">
                            <label class="form-label">
                                <i class="fas fa-align-left"></i>
                                Description (Situation actuelle) <span class="required">*</span>
                            </label>
                            <textarea name="description" rows="4" class="form-textarea @error('description') input-error @enderror"
                                placeholder="Décrivez la situation actuelle de l'élève..." required>{{ old('description', $student->description) }}</textarea>
                            @error('description')
                                <p class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                            @enderror
                            {{-- Description en Malgache --}}
                            <div class="form-group full-width">
                                <label class="form-label">
                                    <i class="fas fa-language"></i>
                                    Description (Malgache) <span class="optional">(Facultatif)</span>
                                </label>
                                <textarea name="description_mg" rows="3" class="form-textarea"
                                    placeholder="Famaritana amin'ny teny malagasy...">{{ old('description_mg', $student->description_mg) }}</textarea>
                            </div>

                            {{-- Description en Anglais --}}
                            <div class="form-group full-width">
                                <label class="form-label">
                                    <i class="fas fa-language"></i>
                                    Description (English) <span class="optional">(Optional)</span>
                                </label>
                                <textarea name="description_en" rows="3" class="form-textarea" placeholder="Description in English...">{{ old('description_en', $student->description_en) }}</textarea>
                            </div>
                        </div>

                        {{-- Besoins spécifiques --}}
                        <div class="form-group full-width">
                            <label class="form-label">
                                <i class="fas fa-hands-helping"></i>
                                Besoins spécifiques <span class="required">*</span>
                            </label>
                            <textarea name="needs" rows="3" class="form-textarea @error('needs') input-error @enderror"
                                placeholder="Listez les besoins prioritaires..." required>{{ old('needs', $student->needs) }}</textarea>
                            @error('needs')
                                <p class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                            @enderror
                            {{-- Besoins en Malgache --}}
                            <div class="form-group full-width">
                                <label class="form-label">
                                    <i class="fas fa-language"></i>
                                    Besoins spécifiques (Malgache) <span class="optional">(Facultatif)</span>
                                </label>
                                <textarea name="needs_mg" rows="2" class="form-textarea" placeholder="Filana amin'ny teny malagasy...">{{ old('needs_mg', $student->needs_mg) }}</textarea>
                            </div>

                            {{-- Besoins en Anglais --}}
                            <div class="form-group full-width">
                                <label class="form-label">
                                    <i class="fas fa-language"></i>
                                    Besoins spécifiques (English) <span class="optional">(Optional)</span>
                                </label>
                                <textarea name="needs_en" rows="2" class="form-textarea" placeholder="Specific needs in English...">{{ old('needs_en', $student->needs_en) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SECTION 3 : OBJECTIF & STATUT --}}
                <div class="form-section">
                    <div class="section-header">
                        <div class="section-icon bg-green">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <div>
                            <h2 class="section-title">Objectif & Statut</h2>
                            <p class="section-desc">Paramètres financiers et visibilité</p>
                        </div>
                    </div>

                    <div class="form-grid">
                        {{-- Objectif financier --}}
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-coins"></i>
                                Objectif (Ar) <span class="required">*</span>
                            </label>
                            <div class="input-with-icon">
                                <i class="fas fa-coins"></i>
                                <input type="number" name="target_amount"
                                    value="{{ old('target_amount', $student->target_amount) }}" min="10000"
                                    class="form-input @error('target_amount') input-error @enderror"
                                    placeholder="Ex: 500000" required>
                            </div>
                            @error('target_amount')
                                <p class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Statut --}}
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-flag"></i>
                                Statut <span class="required">*</span>
                            </label>
                            <select name="status" class="form-select">
                                <option value="pending"
                                    {{ old('status', $student->status) == 'pending' ? 'selected' : '' }}>En attente
                                </option>
                                <option value="active"
                                    {{ old('status', $student->status) == 'active' ? 'selected' : '' }}>En cours</option>
                                <option value="completed"
                                    {{ old('status', $student->status) == 'completed' ? 'selected' : '' }}>Terminé</option>
                            </select>
                        </div>

                        {{-- Mettre en avant --}}
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-star"></i>
                                Visibilité
                            </label>
                            <div class="checkbox-card">
                                <input type="checkbox" name="is_featured" value="1" id="is_featured"
                                    {{ old('is_featured', $student->is_featured) ? 'checked' : '' }}>
                                <label for="is_featured" class="checkbox-label">
                                    <div class="checkbox-icon">
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <div class="checkbox-text">
                                        <span class="checkbox-title">Mettre en avant</span>
                                        <span class="checkbox-desc">Afficher cet élève en priorité sur la page
                                            publique</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- BOUTONS D'ACTION --}}
                <div class="form-actions">
                    <a href="{{ route('admin.students.index') }}" class="btn btn-cancel">
                        <i class="fas fa-times"></i>
                        <span>Annuler</span>
                    </a>
                    <button type="submit" class="btn btn-submit">
                        <i class="fas fa-save"></i>
                        <span>Mettre à jour</span>
                        <span class="btn-shine"></span>
                    </button>
                </div>
            </form>
        </div>
    </section>

    <style>
        /* =========================================================
                                               VARIABLES & BASE
                                               ========================================================= */
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

        .student-form-wrapper {
            max-width: 1000px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        /* =========================================================
                                               HEADER
                                               ========================================================= */
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
            letter-spacing: -0.02em;
        }

        .form-subtitle {
            color: var(--form-muted);
            font-size: 0.95rem;
            margin: 0;
        }

        /* =========================================================
                                               SECTIONS
                                               ========================================================= */
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

        .section-icon.bg-yellow {
            background: linear-gradient(135deg, var(--form-yellow), #d8c900);
            color: var(--form-secondary);
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

        /* =========================================================
                                               GRID & FORM GROUPS
                                               ========================================================= */
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

        /* =========================================================
                                               INPUTS & SELECTS
                                               ========================================================= */
        .form-input,
        .form-select,
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
        .form-select:focus,
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
            min-height: 100px;
        }

        .input-error {
            border-color: var(--form-red) !important;
            background: rgba(239, 68, 68, 0.02);
        }

        .input-error:focus {
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        }

        /* =========================================================
                                               PHOTO UPLOAD
                                               ========================================================= */
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
            max-width: 200px;
            max-height: 200px;
            border-radius: 12px;
            box-shadow: var(--form-shadow);
            border: 3px solid var(--form-white);
        }

        /* =========================================================
                                               INPUT WITH ICON
                                               ========================================================= */
        .input-with-icon {
            position: relative;
        }

        .input-with-icon i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--form-muted);
            pointer-events: none;
        }

        .input-with-icon .form-input {
            padding-left: 2.5rem;
        }

        /* =========================================================
                                               CHECKBOX CARD
                                               ========================================================= */
        .checkbox-card {
            position: relative;
        }

        .checkbox-card input[type="checkbox"] {
            display: none;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            border: 2px solid var(--form-border);
            border-radius: 8px;
            cursor: pointer;
            transition: all var(--form-transition);
        }

        .checkbox-label:hover {
            border-color: var(--form-primary);
            background: rgba(13, 163, 216, 0.02);
        }

        .checkbox-card input[type="checkbox"]:checked+.checkbox-label {
            border-color: var(--form-primary);
            background: rgba(13, 163, 216, 0.05);
        }

        .checkbox-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: var(--form-border);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--form-muted);
            transition: all var(--form-transition);
        }

        .checkbox-card input[type="checkbox"]:checked+.checkbox-label .checkbox-icon {
            background: var(--form-yellow);
            color: var(--form-secondary);
        }

        .checkbox-title {
            display: block;
            font-weight: 600;
            color: var(--form-text);
            font-size: 0.95rem;
        }

        .checkbox-desc {
            display: block;
            font-size: 0.8rem;
            color: var(--form-muted);
            margin-top: 0.25rem;
        }

        /* =========================================================
                                               ERROR MESSAGES
                                               ========================================================= */
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

        /* =========================================================
                                               FORM ACTIONS
                                               ========================================================= */
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

        /* =========================================================
                                               RESPONSIVE
                                               ========================================================= */
        @media (max-width: 768px) {
            .student-form-wrapper {
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

        @media (max-width: 480px) {
            .form-title {
                font-size: 1.4rem;
            }

            .section-title {
                font-size: 1.1rem;
            }

            .form-section {
                padding: 1.25rem;
            }
        }
    </style>

    <script>
        // Preview de la photo uploadée
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
                // Si l'utilisateur annule la sélection, on remet l'ancienne photo si elle existe
                const currentPhoto = "{{ $student->photo_url }}";
                if (currentPhoto) {
                    preview.innerHTML = `<img src="${currentPhoto}" alt="{{ $student->full_name }}">`;
                } else {
                    preview.innerHTML = '';
                }
            }
        });
    </script>
@endsection
