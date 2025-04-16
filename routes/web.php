<?php

use App\Http\Controllers\AuthManager;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\StoryControllers;

// SignUp
Route::get('/signup', [AuthManager::class, 'signup'])->name('signup');
// Route::post('/signup', [AuthManager::class, 'signupPost'])->name('signup.post'); #### Written by Livw Wire ####

Route::middleware(['web', 'throttle:600,1'])->group(function () {

    // delet account
    Route::post('/delaccount', [AuthManager::class, 'deleteAccount'])->name('delacount');

    
    // notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    
    // follow request
    Route::post('/accept-request', [AuthManager::class, 'acceptRequest'])->name('acceptRequest');
    Route::post('/delete-request', [AuthManager::class, 'deleteRequest'])->name('deleteRequest');

    // Add / Edit Post
    Route::get('/post', [PostController::class, "postRoute"])->name('post');
    Route::post('/post', [PostController::class, "create"])->name('post.store'); // Store route
    Route::post('/post/update', [PostController::class, "update"])->name('post.update'); // Update route

    // view post
    Route::get('/p/{id}', [PostController::class, "viewPost"])->name('viewPost');

    // Home page
    Route::get('/', [PostController::class, "home"])->name('home');

    // Home page
    Route::get('/explore', [PostController::class, "explore"])->name('explore');

    // Edit User
    Route::get('/settings', [AuthManager::class, "settings"])->name('settings');
    Route::post('/settings', [AuthManager::class, "update"])->name('settings.post');

    // Delete Post
    Route::get('/delete', [PostController::class, "delete"])->name('post.delete');

    // Save post
    Route::post('/save', [PostController::class, "save"])->name('save.post');


    // add/show story
    Route::get('/story', [StoryControllers::class, "show"])->name('show.story');
    Route::post('/story', [StoryControllers::class, "create"])->name('crate.story');

    // Logout/signin Page
    Route::get('/signin/{r?}', [AuthManager::class, 'signin'])->name('signin');
    Route::post('/signin/{redirect?}', [AuthManager::class, 'signinPost'])->name('signin.post');
    
    Route::get('/logout', function(){
        return redirect()->route('signin');
    });
    
    Route::post('/logout', [AuthManager::class, 'logout'])->name('logout');

    // forgetPassword
    Route::get('/forgot-password', [AuthManager::class, 'forgotPassword'])->name('forgot-password');
    
    // profile
    Route::get('/user/{user_name}', [AuthManager::class, "profile"])->name('profile');

    // chat
    Route::get('/chat', [ChatController::class, "index"])->name('chat');
    Route::get('/chat/{query}', [ChatController::class, "show"])->name('user.chat');

    Route::post('/chat', [ChatController::class, "makaConversation"])->name('conversation');

});

