<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DiaryEntryController;
use App\Http\Controllers\ConflictController;



Route::post('/profile/photo/update', [UserController::class, 'updateProfilePhoto'])->name('profile.photo.update');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/bio', [UserController::class, 'showBio'])->name('profile.show-bio');
    // Route to handle updating the bio
    Route::patch('/profile/bio', [UserController::class, 'updateBio'])->name('profile.update-bio');
    Route::resource('diary', DiaryEntryController::class);
    Route::get('/get-conflict', [DiaryEntryController::class, 'getConflictingEmotions'])->name('diary.get_conflict');
    Route::get(
        '/display_diary'
        ,
        [
            DiaryEntryController::class,
            'display_diary'
        ]
    )->name('diary.display_diary');
    Route::get(
        '/diary_count'
        ,
        [
            DiaryEntryController::class,
            'diary_count'
        ]
    )->name('diary.diary_count');

});

require __DIR__ . '/auth.php';