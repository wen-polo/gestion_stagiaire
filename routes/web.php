<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\StagiaireController;
use App\Http\Controllers\RapportController;

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
Route::get('/dashboard/dsi', [DemandeController::class, 'dashboardDsi'])->name('dashboard.dsi');

// Route spécifique pour comptabilite
Route::get('/dashboard/comptabilite', [DemandeController::class, 'dashboardComptabilite'])->name('dashboard.comptabilite');

// Route dynamique pour les autres postes
Route::get('/dashboard/{poste}', [DemandeController::class, 'dashboardPoste'])->name('dashboard.poste');

Route::get('/dashboard/secretaria', [DemandeController::class, 'dashboardSecretaria'])->name('dashboard.secretaria');

Route::get('/demande/analysed', [DemandeController::class, 'analysed'])->name('demande.analysed');
Route::get('/demande/{id}', [DemandeController::class, 'show'])->name('demande.show');
Route::post('/demande/{id}/affecter', [DemandeController::class, 'affecter'])->name('demande.affecter');
Route::post('/demande/{id}/confirmer', [DemandeController::class, 'confirmer'])->name('demande.confirmer');
