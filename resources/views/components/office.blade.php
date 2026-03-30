{{-- Section Bureau/Équipe - Version Horizontale --}}
<section id="office" class="office_section">
    <div class="container">
        {{-- Titre de la section --}}
        <div class="section-header">
            <h2 class="section-title">@lang('staff.sec_title_office')</h2>
            <div class="title-underline"></div>
        </div>

        {{-- Grille des cartes membres --}}
        <div class="office_section_cards">
            {{-- Card 1 - Président --}}
            @php
                use App\Models\StaffMember;
                use Illuminate\Support\Facades\Storage;

                $currentLang = app()->getLocale();

                // Récupérer tous les membres actifs triés par ordre
                $members = StaffMember::with(['translations', 'allContacts.contactType'])
                    ->active()
                    ->ordered()
                    ->get();
            @endphp

            @foreach ($members as $member)
                @php
                    // Obtenir la traduction pour la langue actuelle (fallback FR puis EN)
                    $translation = $member->translation($currentLang);
                @endphp

                <div class="office_card" data-member="{{ Str::slug($member->name) }}">
                    <div class="card-left">
                        <div class="member-image-wrapper">
                            @if ($member->photo && Storage::disk('public')->exists($member->photo))
                                <img src="{{ Storage::url($member->photo) }}" alt="{{ $member->name }}"
                                    class="member-image">
                            @else
                                <img src="{{ asset('assets/images/personnel/default-avatar.jpg') }}"
                                    alt="{{ $member->name }}" class="member-image">
                            @endif
                            <div class="image-badge">{{ $translation->role ?? 'Membre' }}</div>
                        </div>
                    </div>
                    <div class="card-right">
                        <div class="member-header">
                            <h3 class="member-name">{{ $member->name }}</h3>
                            <span class="member-role">{{ $translation->role ?? 'Membre' }}</span>
                        </div>
                        <p class="member-description">
                            {{ $translation->description ?? 'Description non disponible.' }}
                        </p>

                        @if ($member->allContacts->count() > 0)
                            <div class="member-contacts">
                                @foreach ($member->allContacts as $contact)
                                    @php
                                        // Déterminer l'URL (custom ou générée)
$url = $contact->url;

// Déterminer le type pour data-type
$dataType = $contact->type_slug;

// Mapping pour les icônes FontAwesome
$iconMap = [
    'email' => 'fas fa-envelope',
    'whatsapp' => 'fab fa-whatsapp',
    'facebook' => 'fab fa-facebook',
    'linkedin' => 'fab fa-linkedin',
    'instagram' => 'fab fa-instagram',
    'phone' => 'fas fa-phone',
    'website' => 'fas fa-globe',
    'twitter' => 'fab fa-twitter',
    'tiktok' => 'fab fa-tiktok',
    'other' => 'fas fa-link',
];
$iconClass = $iconMap[$dataType] ?? 'fas fa-link';
                                    @endphp

                                    <a href="{{ $url }}" class="contact-link" data-type="{{ $dataType }}"
                                        target="_blank" rel="noopener">
                                        <i class="{{ $iconClass }}"></i>
                                        <span>{{ $contact->contact_value }}</span>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
</section>
{{-- End Section Bureau/Équipe --}}
