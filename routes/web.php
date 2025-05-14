<?php

use App\Http\Controllers\AuthManager;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\StoryControllers;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FollowController;

// Signup
Route::get('/signup', [AuthManager::class, 'signup'])->name('signup');

Route::middleware(['web', 'throttle:60,1'])->group(function () {

    // delet account
    Route::post('/delaccount', [AuthManager::class, 'deleteAccount'])->name('delacount');
    
    // notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    
    // follow request
    Route::post('/accept-request', [FollowController::class, 'acceptRequest'])->name('acceptRequest');
    Route::post('/delete-request', [FollowController::class, 'deleteRequest'])->name('deleteRequest');

    // Add / Edit Post
    Route::get('/post', [PostController::class, "postRoute"])->name('post');
    Route::post('/post', [PostController::class, "create"])->name('post.store');
    Route::post('/post/update', [PostController::class, "update"])->name('post.update');

    // view post
    Route::get('/p/{id}', [PostController::class, "viewPost"])->name('viewPost');

    // Home page
    Route::get('/', [UserController::class, "home"])->name('home');

    // explore page
    Route::get('/explore', [UserController::class, "explore"])->name('explore');

    // Edit User
    Route::get('/settings', [UserController::class, "settingsRoute"])->name('settings');
    Route::post('/settings', [UserController::class, "settingsPost"])->name('settings.post');

    // Delete Post
    Route::get('/delete', [PostController::class, "delete"])->name('post.delete');

    // add/show story
    Route::get('/story', [StoryControllers::class, "show"])->name('show.story');
    Route::post('/story', [StoryControllers::class, "create"])->name('crate.story');

    // Logout/signin Page
    Route::get('/signin/{r?}', [AuthManager::class, 'signin'])->name('signin');
    Route::post('/signin/{redirect?}', [AuthManager::class, 'signinPost'])->name('signin.post');
    Route::post('/logout', [AuthManager::class, 'logoutPost'])->name('logout.post');
    Route::get('/logout', [AuthManager::class, 'logoutRoute'])->name('logout.route');

    // forgetPassword
    Route::get('/forgot-password', [AuthManager::class, 'forgotPassword'])->name('forgot-password');
    
    // profile
    Route::get('/user/{user_name}', [UserController::class, "profile"])->name('profile');

    // chat page
    Route::get('/chat', [ChatController::class, "index"])->name('chat');
});

