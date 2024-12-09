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
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PreprocessingController;
use App\Http\Controllers\PostprocessingController;
use App\Http\Controllers\StorylineController;


Route::get('/', function () {
    return view('index');
});
Route::get('/stage1', [PreprocessingController::class, 'stage1'])->name('stage1');
Route::get('/stage2', [PreprocessingController::class, 'stage2'])->name('stage2');
Route::get('/stage3', [PreprocessingController::class, 'stage3'])->name('stage3');
Route::get('/stage4', [PreprocessingController::class, 'stage4'])->name('stage4');
Route::get('/preprocessingquiz', [PreprocessingController::class, 'preprocessingquiz'])->name('preprocessingquiz');

Route::get('/poststage1', [PostprocessingController::class, 'stage1'])->name('poststage1');
Route::get('/poststage2', [PostprocessingController::class, 'stage2'])->name('poststage2');
Route::get('/poststage3', [PostprocessingController::class, 'stage3'])->name('poststage3');
Route::get('/postprocessingquiz', [PostprocessingController::class, 'postprocessingquiz'])->name('postprocessingquiz');

Route::get('/storylinestage1', [StorylineController::class, 'storylinestage1'])->name('storylinestage1');
Route::get('/storylinestage2', [StorylineController::class, 'storylinestage2'])->name('storylinestage2');
Route::get('/storylinestage3', [StorylineController::class, 'storylinestage3'])->name('storylinestage3');
Route::get('/storylinestage4', [StorylineController::class, 'storylinestage4'])->name('storylinestage4');

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
Route::post('/update-medium-notif', [PlayController::class, 'updateMediumNotif']);
Route::post('/update-hard-notif', [PlayController::class, 'updateHardNotif']);
Route::post('/update-difficulties', [PlayController::class, 'updateDifficulties']);



Route::get('/leaderboard', [leaderboardController::class, 'index'])->name('leaderboard');

Route::get('/settings', [settingsController::class, 'settings'])->name('settings');
// routes/web.php
Route::post('/toggle-sound', [settingsController::class, 'toggleSound'])->name('toggle-sound');



Route::get('/tutorial', [tutorialController::class, 'tutorial'])->name('tutorial'); // for displaying the tutorial page


Route::get('/preprocessing', [EasyController::class, 'preprocessing'])->name('preprocessing');
Route::post('/update-easy-finish/{userId}', [EasyController::class, 'updateEasyFinish'])->name('update.easy.finish');
Route::post('/easy-update-score/{userId}', [EasyController::class, 'updateScore']);
Route::get('/get-current-performance/{userId}', [EasyController::class, 'getCurrentPerformance']);


Route::get('/postprocessing', [MediumController::class, 'postprocessing'])->name('postprocessing');
Route::post('/update-medium-finish/{userId}', [MediumController::class, 'updateMediumFinish'])->name('update.medium.finish');
Route::post('/medium-update-score/{userId}', [MediumController::class, 'updateScore']);
Route::get('/get-medium-current-performance/{userId}', [MediumController::class, 'getCurrentPerformance']);

Route::get('/hard', [HardController::class, 'hard'])->name('hard');
Route::post('/hard-update-score/{userId}', [HardController::class, 'updateScore']);
Route::post('/update-hard-finish/{userId}', [HardController::class, 'updateHardFinish'])->name('update.hard.finish');
Route::get('/certificate-data', [HardController::class, 'displayCertificate']);
Route::get('/get-hard-current-performance/{userId}', [HardController::class, 'getCurrentPerformance']);
Route::post('/send-certificate-email', [HardController::class, 'sendCertificateEmail']);



// In routes/web.php
Route::post('/save/score', [EasyController::class, 'saveScore'])->name('save.score');



// Route for submitting the score for Medium difficulty
Route::post('/medium/submit-score', [MediumController::class, 'submitScore'])->name('save.medium.score');

// Route for submitting the score for Hard difficulty
Route::post('/hard/submit-score', [HardController::class, 'submitScore'])->name('save.hard.score');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::post('/update-gender', [StorylineController::class, 'updateGender']);
Route::post('/save-player-name', [StorylineController::class, 'savePlayerName']);
Route::get('/isPlayerNameExist', [StorylineController::class, 'isPlayerNameExist']);
Route::get('/isPlayerGenderExist', [StorylineController::class, 'isPlayerGenderExist']);

Route::get('/get-game-state', [PreprocessingController::class, 'getGameState']);



