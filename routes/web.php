<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\playController; 
use App\Http\Controllers\tutorialController;
use App\Http\Controllers\leaderboardController;
use App\Http\Controllers\settingsController;
use App\Http\Controllers\mainmenuController;
use App\Http\Controllers\EasyController; 
use App\Http\Controllers\MediumController; 
use App\Http\Controllers\HardController; // Adjust to your controller's namespace
use App\Http\Controllers\AdminController;


Route::get('/', function () {
    return view('index');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::get('register', [RegistrationController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegistrationController::class, 'register']);


Route::get('/admin/users', [AdminController::class, 'admin'])->name('admin.users');

Route::get('/test', function () {
    return 'Hello Admin';
})->middleware('isAdmin');

Route::middleware(['auth'])->group(function () {
    Route::get('/mainmenu', [mainmenuController::class, 'mainmenu'])->name('mainmenu');
    
    // Admin routes
    Route::prefix('admin')->group(function () {
        Route::get('users', [AdminController::class, 'admin'])->name('admin.users');
        Route::get('users/create', [AdminController::class, 'create'])->name('admin.users.create');
        Route::post('users', [AdminController::class, 'store'])->name('admin.users.store');
        Route::get('users/{id}/edit', [AdminController::class, 'edit'])->name('admin.users.edit');
        Route::put('users/{id}', [AdminController::class, 'update'])->name('admin.users.update');
        Route::delete('users/{id}', [AdminController::class, 'destroy'])->name('admin.users.delete');
        Route::get('/admin/settings', [AdminController::class, 'settings'])->name('admin.settings');
    });    
});

Route::get('/play', [PlayController::class, 'showPlayPage'])->name('play');
Route::post('/play/start', [PlayController::class, 'play'])->name('play.start');
Route::post('/tutorial', [PlayController::class, 'startTutorial']);

Route::get('/leaderboard', [leaderboardController::class, 'index'])->name('leaderboard');

Route::get('/settings', [settingsController::class, 'settings'])->name('settings');


Route::get('/tutorial', [tutorialController::class, 'tutorial'])->name('tutorial'); // for displaying the tutorial page


Route::get('/easy', [EasyController::class, 'easy'])->name('easy');
Route::post('/update-easy-finish/{userId}', [EasyController::class, 'updateEasyFinish'])->name('update.easy.finish');
Route::post('/easy-update-score/{userId}', [EasyController::class, 'updateScore']);

Route::get('/medium', [MediumController::class, 'medium'])->name('medium');
Route::post('/medium-update-score/{userId}', [MediumController::class, 'updateScore']);

Route::get('/hard', [HardController::class, 'hard'])->name('hard');
Route::post('/hard-update-score/{userId}', [HardController::class, 'updateScore']);

// In routes/web.php
Route::post('/save/score', [EasyController::class, 'saveScore'])->name('save.score');



// Route for submitting the score for Medium difficulty
Route::post('/medium/submit-score', [MediumController::class, 'submitScore'])->name('save.medium.score');

// Route for submitting the score for Hard difficulty
Route::post('/hard/submit-score', [HardController::class, 'submitScore'])->name('save.hard.score');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


