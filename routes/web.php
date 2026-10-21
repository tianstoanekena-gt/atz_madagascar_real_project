<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\AboutCardController;
use App\Http\Controllers\Admin\AboutInterventionController;
use App\Http\Controllers\Admin\AboutTextController;
use App\Http\Controllers\Admin\AboutVideoController;
use App\Http\Controllers\Admin\ContactTypeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\Admin\LogoController;
use App\Http\Controllers\Admin\SponsorController as AdminSponsorController;
use App\Http\Controllers\Admin\SponsorDetailController;
use App\Http\Controllers\Admin\StaffMemberController;
use App\Http\Controllers\Admin\VolunteerController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\FaqController;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;

// Redirige la racine vers FR
Route::get('/', function () {
    return redirect('/mg');
});

// Groupe multilingue pour les pages publiques
Route::prefix('{locale}')
    ->where(['locale' => 'mg|fr|en'])
    ->middleware(SetLocale::class)
    ->group(function () {
        // Routes pour toutes les pages publiques
        //home
        Route::get('/', [HomeController::class, 'index'])->name('home');
        //about
        Route::get('/about', [AboutController::class, 'index'])->name('about');
        // Documents (frontend)
        Route::get('/documents', [DocumentController::class, 'index'])->name('documents');
        Route::get('/documents/{document}/download', [DocumentController::class, 'download'])
            ->name('documents.download')
            ->where('document', '[0-9]+');
        // FAQ (frontend)
        Route::get('/faq', [FaqController::class, 'index'])->name('faq');
        // Activités (Frontend)
        Route::get('/activities', [App\Http\Controllers\ActivityPageController::class, 'index'])->name('activities');
        Route::get('/activities/{slug}', [App\Http\Controllers\ActivityPageController::class, 'show'])->name('activities.show');
        // Projets (Frontend)
        Route::get('/projects', [\App\Http\Controllers\ProjectPageController::class, 'index'])->name('projects');
        Route::get('/projects/{slug}', [\App\Http\Controllers\ProjectPageController::class, 'show'])->name('projects.show');
        //contact
        Route::get('/contact', [ContactController::class, 'index'])->name('contact');
        Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
        //staff in about page
        Route::get('/staff', [StaffController::class, 'index'])->name('staff');
        // Statistiques (pages publiques)
        Route::get('/stats', [App\Http\Controllers\StatsController::class, 'index'])->name('stats');
        // ==================== PARRAINAGE (FRONTEND) ====================
        // Page publique (liste des enfants)
        Route::get('/parrainage', [App\Http\Controllers\ParrainageController::class, 'index'])->name('parrainage.index');

        // ✅ AJOUTE CETTE LIGNE ICI (Page de détails d'un élève - 100% publique)
        Route::get('/parrainage/{studentId}', [App\Http\Controllers\ParrainageController::class, 'show'])->name('parrainage.show');

        // Sponsoring route (frontend)
        Route::get('/sponsors', [App\Http\Controllers\SponsorController::class, 'index'])->name('sponsor.index');
        // Pages protégées (nécessite d'être connecté via Breeze)
        Route::middleware('auth')->group(function () {
            Route::get('/parrain/{student}/parrainer', [\App\Http\Controllers\ParrainageController::class, 'form'])->name('parrainage.form');
            Route::post('/parrain/{student}/parrainer', [\App\Http\Controllers\ParrainageController::class, 'store'])->name('parrainage.store');
        });
        // Sponsoring route (frontend)
        Route::get('/sponsors', [App\Http\Controllers\SponsorController::class, 'index'])->name('sponsors');
        //sponsor details route (frontend)
        Route::get('/sponsors/{slug}', [App\Http\Controllers\SponsorController::class, 'show'])->name('sponsors.show');
    });



// Routes admin (hors multilingue)
Route::middleware(['auth', 'verified'])
    ->group(function () {

        // Tableau de bord
        Route::get('/dashboard', function () {
            return view('admin.home.index');
        })->name('dashboard');

        // Gestion des paramètres globaux
        //logo
        Route::get('dashboard/logos', [LogoController::class, 'index'])->name('admin.logos.index');
        Route::get('/dashboard/logos/create', [LogoController::class, 'create'])
            ->name('admin.logos.create');
        Route::post('/dashboard/logos', [LogoController::class, 'store'])
            ->name('admin.logos.store');
        Route::get('/dashboard/logos/{logo}/edit', [LogoController::class, 'edit'])
            ->name('admin.logos.edit');
        Route::put('/dashboard/logos/{logo}', [LogoController::class, 'update'])
            ->name('admin.logos.update');
        Route::delete('/dashboard/logos/{logo}', [LogoController::class, 'destroy'])
            ->name('admin.logos.destroy');

        // Gestion slides
        Route::get('dashboard/hero-slides', [\App\Http\Controllers\Admin\HeroSlideController::class, 'index'])->name('admin.hero-slides.index');
        Route::get('/dashboard/hero-slides/create', [\App\Http\Controllers\Admin\HeroSlideController::class, 'create'])
            ->name('admin.hero-slides.create');
        Route::post('/dashboard/hero-slides', [\App\Http\Controllers\Admin\HeroSlideController::class, 'store'])
            ->name('admin.hero-slides.store');
        Route::get('/dashboard/hero-slides/{heroSlide}/edit', [\App\Http\Controllers\Admin\HeroSlideController::class, 'edit'])
            ->name('admin.hero-slides.edit');
        Route::put('/dashboard/hero-slides/{heroSlide}', [\App\Http\Controllers\Admin\HeroSlideController::class, 'update'])
            ->name('admin.hero-slides.update');
        Route::delete('/dashboard/hero-slides/{heroSlide}', [\App\Http\Controllers\Admin\HeroSlideController::class, 'destroy'])
            ->name('admin.hero-slides.destroy');

        // Gestion vidéos about
        Route::resource('dashboard/about-videos', AboutVideoController::class)
            ->except(['show'])
            ->names('admin.about-videos');

        // Gestion textes about
        Route::resource('dashboard/about-texts', AboutTextController::class)
            ->except(['show'])
            ->names('admin.about-texts');

        //gestino du vlaue card dans la page about
        Route::resource('dashboard/about-cards', AboutCardController::class)
            ->except(['show'])
            ->names('admin.about-cards');

        // Gestion des interventions about
        Route::resource('dashboard/about-interventions', AboutInterventionController::class)
            ->except(['show'])
            ->names('admin.about-interventions');

        // Gestion des types de contacts
        Route::resource('dashboard/contact-types', ContactTypeController::class)
            ->except(['show'])
            ->names('admin.contact-types');

        // Gestion des membres du staff
        Route::resource('dashboard/staff-members', StaffMemberController::class)
            ->except(['show'])
            ->names('admin.staff-members');

        // Gestion des bénévoles
        Route::resource('dashboard/volunteers', VolunteerController::class)
            ->except(['show'])
            ->names('admin.volunteers');

        // Gestion des sponsors
        Route::resource('dashboard/sponsors', AdminSponsorController::class)
            ->except(['show'])
            ->names('admin.sponsors');

        // Gestion des détails sponsors
        Route::get('dashboard/sponsors/{sponsorId}/details', [SponsorDetailController::class, 'edit'])
            ->name('admin.sponsors.details.edit');
        Route::put('dashboard/sponsors/{sponsorId}/details', [SponsorDetailController::class, 'update'])
            ->name('admin.sponsors.details.update');
        Route::delete('dashboard/sponsor-photos/{photoId}', [SponsorDetailController::class, 'destroyPhoto'])
            ->name('admin.sponsors.details.photo.destroy');

        // Gestion des docs
        Route::resource('dashboard/documents', \App\Http\Controllers\Admin\DocumentController::class)
            ->except(['show'])
            ->names('admin.documents');

        // Gestion des FAQs
        Route::resource('dashboard/faq', \App\Http\Controllers\Admin\FaqController::class)
            ->except(['show'])
            ->names('admin.faq');

        // Gestion des Statistiques (Admin)
        Route::resource('dashboard/stats/main', \App\Http\Controllers\Admin\StatMainController::class)
            ->except(['show'])
            ->parameters(['main' => 'stat_main'])
            ->names('admin.stats.main');

        Route::resource('dashboard/stats/education', \App\Http\Controllers\Admin\StatEducationController::class)
            ->except(['show'])
            ->parameters(['education' => 'stat_education'])
            ->names('admin.stats.education');

        Route::resource('dashboard/stats/nutrition', \App\Http\Controllers\Admin\StatNutritionController::class)
            ->except(['show'])
            ->parameters(['nutrition' => 'stat_nutrition'])
            ->names('admin.stats.nutrition');

        Route::resource('dashboard/stats/health', \App\Http\Controllers\Admin\StatHealthController::class)
            ->except(['show'])
            ->parameters(['health' => 'stat_health'])
            ->names('admin.stats.health');


        Route::resource('dashboard/activities', \App\Http\Controllers\Admin\ActivityController::class)
            ->except(['show'])
            ->names('admin.activities');


        // Gestion des Projets (Admin)
        Route::resource('dashboard/projects', \App\Http\Controllers\Admin\ProjectController::class)
            ->except(['show'])
            ->names('admin.projects');

        // Réseaux sociaux
        Route::resource('dashboard/contact/social-media', \App\Http\Controllers\Admin\ContactSocialMediaController::class)
            ->except(['show'])
            ->names('admin.contact.social-media');

        // Horaires d'ouverture (page unique d'édition)
        Route::get('dashboard/contact/opening-hours', [\App\Http\Controllers\Admin\OpeningHourController::class, 'index'])
            ->name('admin.contact.opening-hours.index');
        Route::put('dashboard/contact/opening-hours', [\App\Http\Controllers\Admin\OpeningHourController::class, 'update'])
            ->name('admin.contact.opening-hours.update');

        // Messages reçus (lecture + suppression)
        Route::get('dashboard/contact/messages', [\App\Http\Controllers\Admin\ContactMessageController::class, 'index'])
            ->name('admin.contact.messages.index');
        Route::get('dashboard/contact/messages/{message}', [\App\Http\Controllers\Admin\ContactMessageController::class, 'show'])
            ->name('admin.contact.messages.show');
        Route::put('dashboard/contact/messages/{message}', [\App\Http\Controllers\Admin\ContactMessageController::class, 'update'])
            ->name('admin.contact.messages.update');
        Route::delete('dashboard/contact/messages/{message}', [\App\Http\Controllers\Admin\ContactMessageController::class, 'destroy'])
            ->name('admin.contact.messages.destroy');


        // ==================== PARRAINAGE (ADMIN) ====================
        // Gestion des élèves à parrainer
        Route::resource('dashboard/parrainage/students', \App\Http\Controllers\Admin\StudentController::class)
            ->except(['show'])
            ->names('admin.students');

        // Gestion des parrains
        Route::get('dashboard/parrainage/godparents', [\App\Http\Controllers\Admin\GodparentController::class, 'index'])
            ->name('admin.godparents.index');
        Route::get('dashboard/parrainage/godparents/{godparent}', [\App\Http\Controllers\Admin\GodparentController::class, 'show'])
            ->name('admin.godparents.show');
        Route::get('dashboard/parrainage/godparents/{godparent}/edit', [\App\Http\Controllers\Admin\GodparentController::class, 'edit'])
            ->name('admin.godparents.edit');
        Route::put('dashboard/parrainage/godparents/{godparent}', [\App\Http\Controllers\Admin\GodparentController::class, 'update'])
            ->name('admin.godparents.update');
        Route::delete('dashboard/parrainage/godparents/{godparent}', [\App\Http\Controllers\Admin\GodparentController::class, 'destroy'])
            ->name('admin.godparents.destroy');

        // Gestion des demandes de parrainage (workflow CM)
        Route::get('dashboard/parrainage/sponsorships', [\App\Http\Controllers\Admin\SponsorshipController::class, 'index'])
            ->name('admin.sponsorships.index');
        Route::get('dashboard/parrainage/sponsorships/{sponsorship}', [\App\Http\Controllers\Admin\SponsorshipController::class, 'show'])
            ->name('admin.sponsorships.show');
        Route::post('dashboard/parrainage/sponsorships/{sponsorship}/approve', [\App\Http\Controllers\Admin\SponsorshipController::class, 'approve'])
            ->name('admin.sponsorships.approve');
        Route::post('dashboard/parrainage/sponsorships/{sponsorship}/reject', [\App\Http\Controllers\Admin\SponsorshipController::class, 'reject'])
            ->name('admin.sponsorships.reject');
        Route::post('dashboard/parrainage/sponsorships/{sponsorship}/reset', [\App\Http\Controllers\Admin\SponsorshipController::class, 'resetStatus'])
            ->name('admin.sponsorships.reset');
        Route::delete('dashboard/parrainage/sponsorships/{sponsorship}', [\App\Http\Controllers\Admin\SponsorshipController::class, 'destroy'])
            ->name('admin.sponsorships.destroy');
    });






Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
