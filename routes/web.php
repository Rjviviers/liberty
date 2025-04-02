<?php

use App\Http\Controllers\HomeController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// API routes
Route::post('/api/book-appointment', [HomeController::class, 'bookAppointment'])->name('book.appointment');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Auth routes
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Protected routes
    Route::middleware(\App\Http\Middleware\AdminAuth::class)->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Appointment management
        Route::resource('appointments', \App\Http\Controllers\Admin\AppointmentController::class);
        Route::patch('/appointments/{appointment}/status', [\App\Http\Controllers\Admin\AppointmentController::class, 'updateStatus'])->name('appointments.update-status');
        
        // Testimonials management
        Route::resource('testimonials', \App\Http\Controllers\Admin\TestimonialController::class);
        
        // Website content management
        Route::prefix('website')->name('website.')->group(function () {
            // Hero section
            Route::get('/hero', [\App\Http\Controllers\Admin\WebsiteController::class, 'editHero'])->name('hero.edit');
            Route::post('/hero', [\App\Http\Controllers\Admin\WebsiteController::class, 'updateHero'])->name('hero.update');
            
            // About section
            Route::get('/about', [\App\Http\Controllers\Admin\WebsiteController::class, 'editAbout'])->name('about.edit');
            Route::post('/about', [\App\Http\Controllers\Admin\WebsiteController::class, 'updateAbout'])->name('about.update');
            
            // Features section
            Route::get('/features', [\App\Http\Controllers\Admin\WebsiteController::class, 'editFeatures'])->name('features.edit');
            Route::post('/features', [\App\Http\Controllers\Admin\WebsiteController::class, 'updateFeatures'])->name('features.update');
            
            // Services section
            Route::get('/services', [\App\Http\Controllers\Admin\WebsiteController::class, 'editServices'])->name('services.edit');
            Route::post('/services', [\App\Http\Controllers\Admin\WebsiteController::class, 'updateServices'])->name('services.update');
            
            // Testimonials section
            Route::get('/testimonials', [\App\Http\Controllers\Admin\WebsiteController::class, 'editTestimonials'])->name('testimonials.edit');
            Route::post('/testimonials', [\App\Http\Controllers\Admin\WebsiteController::class, 'updateTestimonials'])->name('testimonials.update');
            
            // Contact section
            Route::get('/contact', [\App\Http\Controllers\Admin\WebsiteController::class, 'editContact'])->name('contact.edit');
            Route::post('/contact', [\App\Http\Controllers\Admin\WebsiteController::class, 'updateContact'])->name('contact.update');
        });
    });
});

require __DIR__.'/auth.php';
require __DIR__.'/settings.php';
