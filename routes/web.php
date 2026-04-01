<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ActivitiesController;
use App\Http\Controllers\ActivitiesDetailsController;
use App\Http\Controllers\Admin\AboutCardController;
use App\Http\Controllers\Admin\AboutInterventionController;
use App\Http\Controllers\Admin\AboutTextController;
use App\Http\Controllers\Admin\AboutVideoController;
use App\Http\Controllers\Admin\ContactTypeController;
use App\Http\Controllers\BecomeParrainController;
use App\Http\Controllers\BecomeSponsorsController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PartenaryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectDetailController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\Admin\LogoController;
use App\Http\Controllers\Admin\StaffMemberController;
use App\Http\Controllers\Admin\VolunteerController;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;

// Redirige la racine vers FR
Route::get('/', function () {
    return redirect('/fr');
});

// Groupe multilingue pour les pages publiques
Route::prefix('{locale?}')
    ->where(['locale' => 'mg|fr|en'])
    ->middleware(SetLocale::class)
    ->group(function () {

        // Routes pour toutes les pages publiques
        //home
        Route::get('/', [HomeController::class, 'index'])->name('home');
        //about
        Route::get('/about', [AboutController::class, 'index'])->name('about');
        //about documents
        Route::get('about/documents', [AboutController::class, 'documents'])->name('documents');
        //about faq
        Route::get('about/faq', [AboutController::class, 'faq'])->name('faq');
        //about stat
        Route::get('about/stat', [AboutController::class, 'stat'])->name('stat');
        //about staff
        Route::get('about/staff', [AboutController::class, 'staff'])->name('staff');
        //activities
        Route::get('/activities', [ActivitiesController::class, 'index'])->name('activities');
        Route::get('/activity/details', [ActivitiesDetailsController::class, 'index'])->name('activity.details');
        //projects
        Route::get('/projects', [ProjectController::class, 'index'])->name('projects');
        Route::get('/project/details', [ProjectDetailController::class, 'index'])->name('project.details');
        //contact
        Route::get('/contact', [ContactController::class, 'index'])->name('contact');
        //staff in about page
        Route::get('/staff', [StaffController::class, 'index'])->name('staff');
        //partenary in about page
        Route::get('/partenary', [PartenaryController::class, 'index'])->name('partenary');
        //sponsors in about page
        Route::get('/sponsors', [SponsorController::class, 'index'])->name('sponsors');

        //routing parrain
        Route::get('/parrain', [BecomeParrainController::class, 'index'])->name('auth.parrain');
        //routing sponsor
        Route::get('/sponsor', [BecomeSponsorsController::class, 'index'])->name('auth.sponsor');
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
    });






Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
