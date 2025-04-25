<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Models\Concert;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ConcertController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TicketController;

Route::get('/', function () {
    $concerts = Concert::withCount('tickets')->get();

    // Calculate available tickets for each concert
    $concerts->each(function ($concert) {
        $concert->available_tickets = $concert->quota - $concert->tickets_count;
    });

    return view('welcome', compact('concerts'));
});




// Authentication Routes
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Protected dashboard route
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // routes for user only
    Route::middleware(['role:user'])->group(function () {
        // User booked tickets view
        Route::get('tickets/my', [TicketController::class, 'myTickets'])->name('tickets.my');
        // Ticket booking and redemption routes
        Route::post('concerts/{concert}/tickets/book', [TicketController::class, 'bookTicket'])->name('tickets.book');
        Route::post('concerts/{concert}/tickets/book-new', [TicketController::class, 'bookTicketNew'])->name('tickets.bookNew');
        
        
    });

    // routes for admin only
    Route::middleware(['role:admin'])->group(function () {
        // Define all concert routes individually except show
        Route::get('concerts', [ConcertController::class, 'index'])->name('concerts.index');
        Route::get('concerts/create', [ConcertController::class, 'create'])->name('concerts.create');
        Route::get('/concerts/{concert}/detail', [ConcertController::class, 'detail'])->name('concerts.detail');
        Route::post('concerts', [ConcertController::class, 'store'])->name('concerts.store');
        Route::get('concerts/{concert}/edit', [ConcertController::class, 'edit'])->name('concerts.edit');
        Route::put('concerts/{concert}', [ConcertController::class, 'update'])->name('concerts.update');
        Route::delete('concerts/{concert}', [ConcertController::class, 'destroy'])->name('concerts.destroy');

        Route::resource('users', UserController::class);

        // User ticket management routes
        Route::post('tickets/redeem', [TicketController::class, 'redeemTicket'])->name('tickets.redeem');
        // Redeem ticket form
        Route::get('tickets/redeem', [TicketController::class, 'redeemForm'])->name('tickets.redeem.form');
        Route::delete('tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');

        // User ticket detail view
        Route::get('tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');

        // Admin ticket list page
        Route::get('tickets', [TicketController::class, 'indexAdmin'])->name('tickets.index')->middleware('role:admin');

        // New route to fetch tickets filtered by concert id (AJAX)
        Route::get('tickets/filter-by-concert/{concertId?}', [TicketController::class, 'filterByConcert'])->name('tickets.filterByConcert')->middleware('role:admin');
        
    });

});
Route::get('/concerts/{concert}', [ConcertController::class, 'show'])->name('concerts.show');
