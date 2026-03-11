@extends('layouts.main')

@section('title', 'staff page')

@section('content')

    <section class="staff">
        <h1>@lang('staff.sec_title')</h1>
        <div class="team-intro-wrapper">
            <p class="team-intro-text">
                @lang('staff.sec_descri')
                <a href="#office" class="team-link" data-category="bureaucrate">@lang('staff.staff_cta_bureaucrat')</a>,
                {{-- <a href="#field-team" class="team-link" data-category="terrain">équipe terrain</a>, --}}
                <a href="#volunteers" class="team-link" data-category="benevoles">@lang('staff.staff_cta_benevol')</a>
                @lang('staff.sec_descri_two')
            </p>
        </div>

        <div>
            <x-office />
            <x-benevol />
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ajouter des effets interactifs aux liens
            const teamLinks = document.querySelectorAll('.team-link');

            teamLinks.forEach(link => {
                // Effet de pulse au hover
                link.addEventListener('mouseenter', function() {
                    this.style.animation = 'pulse 0.6s ease';
                });

                link.addEventListener('mouseleave', function() {
                    this.style.animation = 'none';
                });

                // Scroll fluide vers la section
                link.addEventListener('click', function(e) {
                    const href = this.getAttribute('href');
                    if (href.startsWith('#')) {
                        e.preventDefault();
                        const targetId = href.substring(1);
                        const targetElement = document.getElementById(targetId);

                        if (targetElement) {
                            targetElement.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }
                    }
                });
            });

            // Ajouter l'animation pulse dans le style
            const style = document.createElement('style');
            style.textContent = `
            @keyframes pulse {
                0%, 100% {
                    transform: scale(1);
                }
                50% {
                    transform: scale(1.05);
                }
            }
        `;
            document.head.appendChild(style);
        });
    </script>

@endsection
