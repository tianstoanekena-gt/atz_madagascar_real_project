@extends('admin.layouts.master')
@section('title', 'Détail du Parrainage')

@section('content')
    <section class="content_contents">
        <div class="sponsorship-detail-wrapper">

            {{-- En-tête --}}
            <div class="detail-header">
                <a href="{{ route('admin.sponsorships.index') }}" class="back-link">
                    <i class="fas fa-arrow-left"></i>
                    <span>Retour à la liste</span>
                </a>
                <div class="header-title">
                    <h1 class="page-title">Détail du parrainage</h1>
                    <span class="status-badge status-{{ $sponsorship->payment_status_color }}">
                        <i class="fas fa-circle text-xs mr-1"></i>
                        {{ $sponsorship->payment_status_label }}
                    </span>
                </div>
            </div>

            <div class="detail-grid">
                {{-- COLONNE GAUCHE : LE PARRAIN --}}
                <div class="detail-card">
                    <div class="card-header">
                        <i class="fas fa-user-tie"></i>
                        <h2>Le Parrain</h2>
                    </div>
                    <div class="card-body">
                        <div class="identity-block">
                            <div class="avatar">
                                @if ($sponsorship->godparent->photo)
                                    <img src="{{ $sponsorship->godparent->photo_url }}" alt="Photo"
                                        style="width:100%; height:100%; object-fit:cover; border-radius:50%;">
                                @else
                                    <span>{{ strtoupper(substr($sponsorship->godparent->first_name, 0, 1)) }}</span>
                                @endif
                            </div>
                            <div class="identity-info">
                                <h3 class="name">{{ $sponsorship->godparent->full_name }}</h3>
                                <p class="date">Parrain depuis le
                                    {{ $sponsorship->godparent->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                        <div class="contact-list">
                            <a href="mailto:{{ $sponsorship->godparent->email }}" class="contact-item">
                                <i class="fas fa-envelope"></i>
                                <span>{{ $sponsorship->godparent->email }}</span>
                            </a>
                            <a href="{{ $sponsorship->godparent->whatsapp_link }}" target="_blank"
                                class="contact-item whatsapp">
                                <i class="fab fa-whatsapp"></i>
                                <span>{{ $sponsorship->godparent->whatsapp }}</span>
                            </a>
                            <div class="contact-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>{{ Str::limit($sponsorship->godparent->address, 60) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- COLONNE DROITE : L'ÉLÈVE & LE DON --}}
                <div class="detail-card">
                    <div class="card-header">
                        <i class="fas fa-child"></i>
                        <h2>L'Élève & Le Don</h2>
                    </div>
                    <div class="card-body">
                        <div class="identity-block">
                            <img src="{{ $sponsorship->student->photo_url }}" alt="Photo élève" class="student-photo">
                            <div class="identity-info">
                                <h3 class="name">{{ $sponsorship->student->full_name }}</h3>
                                <p class="date">{{ $sponsorship->student->education_level_label }} •
                                    {{ $sponsorship->student->age }} ans • {{ $sponsorship->student->location }}</p>
                            </div>
                        </div>

                        <div class="donation-block">
                            <p class="donation-label">Montant du parrainage</p>
                            <p class="donation-amount">{{ $sponsorship->formatted_amount }}</p>
                        </div>

                        @if ($sponsorship->validated_at)
                            <div class="validation-info">
                                <i class="fas fa-check-circle"></i>
                                <span>Validé le {{ $sponsorship->validated_at->format('d/m/Y à H:i') }} par
                                    {{ $sponsorship->validator->name ?? 'Admin' }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- MESSAGE DU PARRAIN --}}
            @if ($sponsorship->message)
                <div class="detail-card message-card">
                    <div class="card-header">
                        <i class="fas fa-comment-dots"></i>
                        <h2>Message du parrain</h2>
                    </div>
                    <div class="card-body">
                        <p class="message-text">"{{ $sponsorship->message }}"</p>
                    </div>
                </div>
            @endif

            {{-- ACTIONS (Si en attente) --}}
            @if ($sponsorship->payment_status === 'pending')
                <div class="action-bar">
                    <form action="{{ route('admin.sponsorships.approve', $sponsorship->id) }}" method="POST"
                        class="action-form">
                        @csrf
                        <button type="submit" class="btn btn-approve">
                            <i class="fas fa-check-circle"></i>
                            <span>Valider le parrainage</span>
                        </button>
                    </form>

                    <form action="{{ route('admin.sponsorships.reject', $sponsorship->id) }}" method="POST"
                        class="action-form" id="rejectForm">
                        @csrf
                        <button type="button" onclick="promptReject()" class="btn btn-reject">
                            <i class="fas fa-times-circle"></i>
                            <span>Rejeter la demande</span>
                        </button>
                        <input type="hidden" name="reason" id="rejectReason">
                    </form>
                </div>
            @endif

        </div>
    </section>

    <style>
        :root {
            --sd-primary: #0da3d8;
            --sd-primary-dark: #087eaa;
            --sd-secondary: #0d0c43;
            --sd-yellow: #feed02;
            --sd-green: #10b981;
            --sd-red: #ef4444;
            --sd-orange: #f97316;
            --sd-bg: #f8fafc;
            --sd-white: #ffffff;
            --sd-text: #1f2937;
            --sd-muted: #6b7280;
            --sd-border: #e5e7eb;
            --sd-radius: 12px;
            --sd-shadow: 0 4px 20px rgba(13, 12, 67, 0.08);
            --sd-transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sponsorship-detail-wrapper {
            max-width: 1000px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        .detail-header {
            margin-bottom: 2rem;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--sd-muted);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 1rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all var(--sd-transition);
        }

        .back-link:hover {
            color: var(--sd-primary);
            background: rgba(13, 163, 216, 0.08);
        }

        .header-title {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .page-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--sd-secondary);
            margin: 0;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.4rem 1rem;
            border-radius: 999px;
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .status-badge.status-green {
            background: rgba(16, 185, 129, 0.1);
            color: var(--sd-green);
        }

        .status-badge.status-red {
            background: rgba(239, 68, 68, 0.1);
            color: var(--sd-red);
        }

        .status-badge.status-orange {
            background: rgba(249, 115, 22, 0.1);
            color: var(--sd-orange);
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        @media (min-width: 768px) {
            .detail-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        .detail-card {
            background: var(--sd-white);
            border-radius: var(--sd-radius);
            box-shadow: var(--sd-shadow);
            border: 1px solid var(--sd-border);
            overflow: hidden;
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1.25rem 1.5rem;
            background: linear-gradient(180deg, #fafbfc 0%, #ffffff 100%);
            border-bottom: 1px solid var(--sd-border);
        }

        .card-header i {
            color: var(--sd-primary);
            font-size: 1.1rem;
        }

        .card-header h2 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--sd-secondary);
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .card-body {
            padding: 1.5rem;
        }

        .identity-block {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .avatar,
        .student-photo {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid rgba(13, 163, 216, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--sd-primary);
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
            flex-shrink: 0;
        }

        .identity-info .name {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--sd-secondary);
            margin: 0 0 0.25rem 0;
        }

        .identity-info .date {
            font-size: 0.85rem;
            color: var(--sd-muted);
            margin: 0;
        }

        .contact-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: var(--sd-text);
            text-decoration: none;
            font-size: 0.9rem;
            padding: 0.5rem;
            border-radius: 8px;
            transition: background var(--sd-transition);
        }

        .contact-item:hover {
            background: rgba(13, 163, 216, 0.05);
        }

        .contact-item i {
            width: 20px;
            text-align: center;
            color: var(--sd-primary);
        }

        .contact-item.whatsapp i {
            color: var(--sd-green);
        }

        .donation-block {
            background: linear-gradient(135deg, rgba(13, 163, 216, 0.05), rgba(254, 237, 2, 0.05));
            border: 1px solid rgba(13, 163, 216, 0.1);
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            margin-top: 1rem;
        }

        .donation-label {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--sd-muted);
            font-weight: 600;
            margin: 0 0 0.5rem 0;
        }

        .donation-amount {
            font-size: 2rem;
            font-weight: 800;
            color: var(--sd-primary);
            margin: 0;
            letter-spacing: -0.02em;
        }

        .validation-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 1rem;
            padding: 0.75rem;
            background: rgba(16, 185, 129, 0.1);
            border-radius: 8px;
            color: var(--sd-green);
            font-size: 0.85rem;
            font-weight: 600;
        }

        .message-card .message-text {
            font-size: 1rem;
            line-height: 1.6;
            color: var(--sd-text);
            font-style: italic;
            background: rgba(13, 163, 216, 0.03);
            border-left: 4px solid var(--sd-primary);
            padding: 1.25rem;
            border-radius: 0 8px 8px 0;
            margin: 0;
        }

        .action-bar {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--sd-border);
        }

        .action-form {
            display: inline;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.85rem 1.5rem;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: all var(--sd-transition);
        }

        .btn-approve {
            background: var(--sd-green);
            color: white;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .btn-approve:hover {
            background: #059669;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }

        .btn-reject {
            background: var(--sd-red);
            color: white;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        .btn-reject:hover {
            background: #dc2626;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
        }

        @media (max-width: 600px) {
            .action-bar {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>

    <script>
        function promptReject() {
            const reason = prompt("Veuillez entrer une raison pour le rejet (facultatif) :");
            if (reason !== null) {
                document.getElementById('rejectReason').value = reason;
                document.getElementById('rejectForm').submit();
            }
        }
    </script>
@endsection
