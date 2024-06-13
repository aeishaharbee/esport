<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\TournamentTeamController;
use App\Http\Controllers\MatchController;

// Route::get('/', function () {
//     return view('home');
// })->name('home');

Route::get('/dashboard', function () {
    return view('home');
})->middleware(['auth', 'user','verified'])->name('dashboard');

// Route::get('/home', [HomeController::class, 'index'] );

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// ADMIN
Route::get('/', [HomeController::class,'home'])->name('home');
Route::get('/dashboard', [HomeController::class,'home'])->name('dashboard');
Route::get('admin/dashboard', [HomeController::class,'index'])->middleware(['auth', 'admin'])->name('admin.dashboard');
Route::get('admin/tournament', [TournamentController::class, 'index'])->middleware(['auth','admin'])->name('admin.tournament.index');
Route::get('admin/tournament/create', [TournamentController::class, 'create'])->middleware(['auth','admin'])->name('admin.tournament.create');
Route::post('admin/tournament', [TournamentController::class, 'store'])->middleware(['auth','admin'])->name('admin.tournament.store');

Route::get('admin/tournament/{tournament}/edit', [TournamentController::class, 'edit'])->middleware(['auth','admin'])->name('admin.tournament.edit');
Route::put('admin/tournament/{tournament}/update', [TournamentController::class, 'update'])->middleware(['auth','admin'])->name('admin.tournament.update');
Route::delete('admin/tournament/{tournament}/destroy', [TournamentController::class, 'destroy'])->middleware(['auth','admin'])->name('admin.tournament.destroy');
Route::get('admin/tournament/{tournament}/details', [TournamentController::class, 'showTournamentDetails'])->middleware(['auth','admin'])->name('admin.tournament.details');

Route::delete('admin/tournament/{tournament}/teams/{team}', [TournamentTeamController::class, 'destroy'])->middleware(['auth','admin'])->name('admin.tournament.teams.destroy');

Route::get('admin/tournament/{tournament}/match', [MatchController::class, 'showAssignMatchesForm'])->middleware(['auth','admin'])->name('admin.tournament.match');
Route::post('admin/tournament/{tournament}/match', [MatchController::class, 'assignMatches'])->middleware(['auth','admin'])->name('admin.tournament.match.store');
Route::get('admin/tournament/{tournament}/match/{match}/edit', [MatchController::class, 'edit'])->middleware(['auth','admin'])->name('admin.match.edit');
Route::put('admin/tournament/{tournament}/match/{match}', [MatchController::class, 'update'])->middleware(['auth','admin'])->name('admin.match.update');
Route::delete('admin/tournament/{tournament}/match/{match}', [MatchController::class, 'destroy'])->middleware(['auth','admin'])->name('admin.match.destroy');
Route::post('admin/tournament/{tournament}/match/{match}/complete', [MatchController::class, 'completeMatch'])->middleware(['auth','admin'])->name('admin.match.complete');

Route::get('admin/team', [TeamController::class, 'indexAdmin'])->middleware(['auth','admin'])->name('admin.team.index');
Route::delete('admin/team/{team}/destroy', [TeamController::class, 'destroyAdmin'])->middleware(['auth','admin'])->name('admin.team.destroy');
// Route::get('admin/team/{id}', [TeamController::class, 'details'])->name('admin.team.details');

// Route::get('admin/rank', [TeamController::class, 'rank'])->middleware(['auth','admin'])->name('admin.rank.index');

// USER
Route::get('/tournament', [TournamentController::class, 'indexUser'])->name('tournament.index');
Route::get('/tournament/{tournament}/details', [TournamentTeamController::class, 'detailsUser'])->name('tournament.details');
Route::post('/tournament/{tournament}/register-team', [TournamentTeamController::class, 'store'])->middleware(['auth','user'])->name('tournament.team.register');

Route::get('/team', [TeamController::class, 'index'])->name('team.index');
Route::get('/team/create', [TeamController::class, 'create'])->middleware(['auth','user'])->name('team.create');
Route::post('/team', [TeamController::class, 'store'])->middleware(['auth','user'])->name('team.store');
Route::get('/team/{team}/edit', [TeamController::class, 'edit'])->middleware(['auth','user'])->name('team.edit');
Route::put('/team/{team}/update', [TeamController::class, 'update'])->middleware(['auth','user'])->name('team.update');
Route::delete('/team/{team}/destroy', [TeamController::class, 'destroy'])->middleware(['auth','user'])->name('team.destroy');
Route::get('/team/{id}', [TeamController::class, 'details'])->name('team.details');

Route::get('/rank', [TeamController::class, 'rank'])->name('rank.index');
