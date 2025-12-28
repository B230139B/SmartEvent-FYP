<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\VenueController;
use App\Http\Controllers\EventProposalController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AdminDashboardController;

// Models
use App\Models\EventProposal;

// Middleware
use App\Http\Middleware\AdminOnly;

/*
|--------------------------------------------------------------------------
| HOME — AUTO REDIRECT BASED ON ROLE
|--------------------------------------------------------------------------
*/
Route::get('/', function () {

    if (!auth()->check()) {
        return view('welcome');
    }

    return auth()->user()->is_admin
        ? redirect()->route('admin.dashboard')
        : redirect()->route('dashboard');

})->name('home');


/*
|--------------------------------------------------------------------------
| USER DASHBOARD
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->get('/dashboard', function () {

    $userId = auth()->id();

    return view('user.dashboard', [
        'totalProposals'    => EventProposal::where('user_id', $userId)->count(),
        'pendingProposals'  => EventProposal::where('user_id', $userId)->where('status', 'Pending')->count(),
        'approvedProposals' => EventProposal::where('user_id', $userId)->where('status', 'Approved')->count(),
        'latestProposals'   => EventProposal::where('user_id', $userId)->latest()->take(5)->get(),
    ]);

})->name('dashboard');


/*
|--------------------------------------------------------------------------
| ADMIN DASHBOARD
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', AdminOnly::class])
    ->get('/admin', [AdminDashboardController::class, 'index'])
    ->name('admin.dashboard');


/*
|--------------------------------------------------------------------------
| PUBLIC — VENUES
|--------------------------------------------------------------------------
*/
Route::get('/venues', [VenueController::class, 'index'])
    ->name('venues.index');


/*
|--------------------------------------------------------------------------
| ADMIN — VENUES CRUD
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', AdminOnly::class])
    ->prefix('admin/venues')
    ->name('venue.admin.')
    ->group(function () {

        Route::get('/', [VenueController::class, 'adminIndex'])->name('index');
        Route::get('/create', [VenueController::class, 'create'])->name('create');
        Route::post('/', [VenueController::class, 'store'])->name('store');
        Route::get('/{venue}/edit', [VenueController::class, 'edit'])->name('edit');
        Route::put('/{venue}', [VenueController::class, 'update'])->name('update');
        Route::delete('/{venue}', [VenueController::class, 'destroy'])->name('destroy');

    });


/*
|--------------------------------------------------------------------------
| USER — EVENT PROPOSALS
|--------------------------------------------------------------------------
*/
Route::middleware('auth')
    ->prefix('proposal')
    ->name('proposal.')
    ->group(function () {

        Route::get('/', [EventProposalController::class, 'userIndex'])->name('index');
        Route::get('/create', [EventProposalController::class, 'create'])->name('create');
        Route::post('/', [EventProposalController::class, 'store'])->name('store');
        Route::get('/{proposal}', [EventProposalController::class, 'show'])->name('show');

    });


/*
|--------------------------------------------------------------------------
| ADMIN — EVENT PROPOSALS REVIEW
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', AdminOnly::class])
    ->prefix('admin/proposals')
    ->name('admin.proposals.')
    ->group(function () {

        Route::get('/', [EventProposalController::class, 'adminIndex'])->name('index');
        Route::get('/{proposal}', [EventProposalController::class, 'adminView'])->name('view');
        Route::post('/{proposal}/update', [EventProposalController::class, 'adminUpdate'])->name('update');

    });


/*
|--------------------------------------------------------------------------
| PUBLIC — BUDGETING
|--------------------------------------------------------------------------
*/
Route::get('/budgeting', [BudgetController::class, 'index'])
    ->name('budget.index');


/*
|--------------------------------------------------------------------------
| ADMIN — BUDGET CRUD
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', AdminOnly::class])
    ->prefix('admin/budgeting')
    ->name('budget.admin.')
    ->group(function () {

        Route::get('/', [BudgetController::class, 'adminIndex'])->name('index');
        Route::get('/create', [BudgetController::class, 'create'])->name('create');
        Route::post('/', [BudgetController::class, 'store'])->name('store');
        Route::get('/{budget}/edit', [BudgetController::class, 'edit'])->name('edit');
        Route::put('/{budget}', [BudgetController::class, 'update'])->name('update');
        Route::delete('/{budget}', [BudgetController::class, 'destroy'])->name('destroy');

    });


/*
|--------------------------------------------------------------------------
| PUBLIC — COMMUNITY
|--------------------------------------------------------------------------
*/
Route::get('/community', [CommunityController::class, 'index'])
    ->name('community.index');

Route::get('/community/{event}', [CommunityController::class, 'show'])
    ->name('community.show');

Route::post('/community/rate/{event}', [CommunityController::class, 'rate'])
    ->middleware('auth')
    ->name('community.rate');


/*
|--------------------------------------------------------------------------
| ADMIN — COMMUNITY CONTROL
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', AdminOnly::class])
    ->prefix('admin/community')
    ->name('community.admin.')
    ->group(function () {

        Route::post('/publish/{event}', [CommunityController::class, 'publish'])->name('publish');
        Route::post('/unpublish/{event}', [CommunityController::class, 'unpublish'])->name('unpublish');

    });


/*
|--------------------------------------------------------------------------
| PUBLIC — ACTIVITIES
|--------------------------------------------------------------------------
*/
Route::get('/activities', [ActivityController::class, 'index'])
    ->name('activities.index');


/*
|--------------------------------------------------------------------------
| ADMIN — ACTIVITIES CRUD
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', AdminOnly::class])
    ->prefix('admin/activities')
    ->name('activity.admin.')
    ->group(function () {

        Route::get('/', [ActivityController::class, 'adminIndex'])->name('index');
        Route::get('/create', [ActivityController::class, 'create'])->name('create');
        Route::post('/', [ActivityController::class, 'store'])->name('store');
        Route::get('/{activity}/edit', [ActivityController::class, 'edit'])->name('edit');
        Route::put('/{activity}', [ActivityController::class, 'update'])->name('update');
        Route::delete('/{activity}', [ActivityController::class, 'destroy'])->name('destroy');

    });


/*
|--------------------------------------------------------------------------
| GUIDANCE PAGE
|--------------------------------------------------------------------------
*/
Route::view('/guidance', 'guidance')->name('guidance');


/*
|--------------------------------------------------------------------------
| AUTH (Laravel Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
