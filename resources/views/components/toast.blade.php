{{-- Composant Toast réutilisable --}}
@props(['type' => 'success', 'message' => ''])

@if ($message)
    <div id="toast-container" class="toast-slide-in">
        <div class="toast-wrapper">
            {{-- Barre de progression --}}
            <div class="toast-progress"></div>

            {{-- Contenu --}}
            <div class="toast-content">
                {{-- Icône selon le type --}}
                @if ($type === 'success')
                    <div class="toast-icon toast-icon-success">
                        <svg fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                @elseif($type === 'error')
                    <div class="toast-icon toast-icon-error">
                        <svg fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                @elseif($type === 'warning')
                    <div class="toast-icon toast-icon-warning">
                        <svg fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                @else
                    <div class="toast-icon toast-icon-info">
                        <svg fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                @endif

                {{-- Message --}}
                <div class="toast-message">
                    {{ $message }}
                </div>

                {{-- Bouton fermer --}}
                <button onclick="closeToast()" class="toast-close">
                    <svg fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Styles inline pour le Toast --}}
    <style>
        /* Variables de couleur */
        :root {
            --toast-primary: #feed02;
            --toast-secondary: #0d0c43;
            --toast-accent: #0da3d8;
            --toast-success: #10b981;
            --toast-error: #ef4444;
            --toast-warning: #f59e0b;
            --toast-info: #3b82f6;
        }

        /* Animation d'entrée */
        @keyframes toastSlideIn {
            from {
                opacity: 0;
                transform: translateX(100%);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes toastSlideOut {
            from {
                opacity: 1;
                transform: translateX(0);
            }

            to {
                opacity: 0;
                transform: translateX(100%);
            }
        }

        @keyframes progressBar {
            from {
                width: 100%;
            }

            to {
                width: 0%;
            }
        }

        /* Container principal - Positionné juste sous la navbar */
        #toast-container {
            position: fixed;
            top: 96px;
            /* 84px navbar + 12px marge */
            right: 48px;
            /* 3rem = 48px */
            z-index: 999;
            /* Juste en dessous de la navbar (1000) */
            animation: toastSlideIn 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .toast-slide-out {
            animation: toastSlideOut 0.4s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        /* Wrapper principal */
        .toast-wrapper {
            position: relative;
            min-width: 320px;
            max-width: 420px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(13, 12, 67, 0.15);
            overflow: hidden;
            border-left: 4px solid var(--toast-success);
        }

        .toast-wrapper.toast-error {
            border-left-color: var(--toast-error);
        }

        .toast-wrapper.toast-warning {
            border-left-color: var(--toast-warning);
        }

        .toast-wrapper.toast-info {
            border-left-color: var(--toast-info);
        }

        /* Barre de progression */
        .toast-progress {
            position: absolute;
            top: 0;
            left: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--toast-primary), var(--toast-accent));
            animation: progressBar 5s linear forwards;
        }

        /* Contenu */
        .toast-content {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px 20px;
        }

        /* Icône */
        .toast-icon {
            flex-shrink: 0;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .toast-icon svg {
            width: 18px;
            height: 18px;
        }

        .toast-icon-success {
            background: rgba(16, 185, 129, 0.1);
            color: var(--toast-success);
        }

        .toast-icon-error {
            background: rgba(239, 68, 68, 0.1);
            color: var(--toast-error);
        }

        .toast-icon-warning {
            background: rgba(245, 158, 11, 0.1);
            color: var(--toast-warning);
        }

        .toast-icon-info {
            background: rgba(59, 130, 246, 0.1);
            color: var(--toast-info);
        }

        /* Message */
        .toast-message {
            flex: 1;
            font-size: 14px;
            line-height: 1.5;
            color: var(--toast-secondary);
            font-weight: 500;
        }

        /* Bouton fermer */
        .toast-close {
            flex-shrink: 0;
            width: 24px;
            height: 24px;
            border-radius: 6px;
            background: transparent;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9ca3af;
            transition: all 0.2s;
        }

        .toast-close:hover {
            background: #f3f4f6;
            color: var(--toast-secondary);
        }

        .toast-close svg {
            width: 16px;
            height: 16px;
        }

        /* ================= TABLET ================= */
        @media (max-width: 992px) {
            #toast-container {
                top: 92px;
                /* Navbar plus petite sur tablette */
                right: 32px;
            }
        }

        /* ================= MOBILE ================= */
        @media (max-width: 576px) {
            #toast-container {
                top: 82px;
                /* Navbar mobile ~70px + 12px marge */
                right: 16px;
                left: 16px;
            }

            .toast-wrapper {
                min-width: auto;
                width: 100%;
            }
        }
    </style>

    {{-- Script pour auto-dismiss --}}
    <script>
        // Auto-dismiss après 5 secondes
        const toastTimeout = setTimeout(() => {
            closeToast();
        }, 5000);

        function closeToast() {
            clearTimeout(toastTimeout);
            const container = document.getElementById('toast-container');
            if (container) {
                container.classList.remove('toast-slide-in');
                container.classList.add('toast-slide-out');
                setTimeout(() => {
                    container.remove();
                }, 400);
            }
        }
    </script>
@endif
