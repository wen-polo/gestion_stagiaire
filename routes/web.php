<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\StagiaireController;
use App\Http\Controllers\RapportController;
use App\Http\Controllers\DsiController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::get('/user/dashboard', function () {
    return view('user.dashboard');
})->name('user.dashboard');

Route::get('/admin/demandes', [DemandeController::class, 'index'])->name('admin.demandes');
Route::get('/admin/stagiaires', [StagiaireController::class, 'index'])->name('admin.stagiaires');
Route::get('/admin/rapports', [RapportController::class, 'index'])->name('admin.rapports');

Route::get('/demande/create', [DemandeController::class, 'create'])->name('demande.create');
Route::post('/demande', [DemandeController::class, 'store'])->name('demande.store');

// Tableau de bord SG
Route::get('/dashboard-sg', [DemandeController::class, 'dashboardSg'])->name('dashboard.sg');
Route::post('/demande/{id}/transferer-sg', [DemandeController::class, 'transfererSg'])->name('demande.transferer.sg');

// Tableau de bord DPAF
Route::get('/dashboard-dpaf', [DemandeController::class, 'dashboardDpaf'])->name('dashboard.dpaf');
Route::post('/demande/{id}/transferer-dpaf', [DemandeController::class, 'transfererDpaf'])->name('demande.transfererDpaf');
Route::get('/dashboard/dpaf_post', [DemandeController::class, 'dashboardDpafPost'])->name('dashboard.dpaf_post');

// Tableau de bord SRHDS
Route::get('/dashboard-srhds', [DemandeController::class, 'dashboardSrhds'])->name('dashboard.srhds');

// Tableau de bord DSI
Route::get('/dashboard-dsi', [DsiController::class, 'dashboard'])->name('dashboard.dsi');
Route::get('/dsi/profile', [DsiController::class, 'profile'])->name('dsi.profile');
Route::get('/dsi/documents', [DsiController::class, 'documents'])->name('dsi.documents');
Route::post('/dsi/logout', [DsiController::class, 'logout'])->name('dsi.logout');
Route::get('/dsi/tasks', [DsiController::class, 'tasks'])->name('dsi.tasks');
Route::get('/dsi/demande/{id}', [DemandeController::class, 'showDsi'])->name('dsi.show');

// Route spécifique pour comptabilite
Route::get('/dashboard/comptabilite', [DemandeController::class, 'dashboardComptabilite'])->name('dashboard.comptabilite');
Route::get('/dashboard-comptabilite', [ComptabiliteController::class, 'dashboard'])->name('dashboard.comptabilite');
Route::get('/comptabilite/demande/{id}', [DemandeController::class, 'showComptabilite'])->name('comptabilite.show');

// Route dynamique pour les autres postes
Route::get('/dashboard/{poste}', [DemandeController::class, 'dashboardPoste'])->name('dashboard.poste');

Route::get('/dashboard/secretaria', [DemandeController::class, 'dashboardSecretaria'])->name('dashboard.secretaria');

Route::get('/demande/analysed', [DemandeController::class, 'analysed'])->name('demande.analysed');
Route::get('/demande/{id}', [DemandeController::class, 'show'])->name('demande.show');
Route::post('/demande/{id}/affecter', [DemandeController::class, 'affecter'])->name('demande.affecter');
Route::post('/demande/{id}/confirmer', [DemandeController::class, 'confirmer'])->name('demande.confirmer');

Route::get('/stagiaire/{poste}/{email}', [DemandeController::class, 'showStagiaire'])->name('stagiaire.show');

Route::get('/login', [StagiaireController::class, 'showLoginForm'])->name('login');
Route::post('/login', [StagiaireController::class, 'login'])->name('login.post');

Route::get('/stagiaire/dashboard', [StagiaireController::class, 'dashboard'])->name('stagiaire.dashboard');
Route::get('/stagiaire/profile', [StagiaireController::class, 'profile'])->name('stagiaire.profile');
Route::get('/stagiaire/documents', [StagiaireController::class, 'documents'])->name('stagiaire.documents');
Route::post('/stagiaire/logout', [StagiaireController::class, 'logout'])->name('stagiaire.logout');

Route::get('/demande/tasks', [DemandeController::class, 'tasks'])->name('demande.tasks');

Route::get('/dpaf/demande/{id}', [DemandeController::class, 'showDpaf'])->name('dpaf.show');

Route::get('/secretaria/demande/{id}', [DemandeController::class, 'showSecretaria'])->name('secretaria.show');
