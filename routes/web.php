<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StructureController;
use App\Http\Controllers\MetiersController;
use App\Http\Controllers\SalariesController;
use App\Http\Controllers\CampagnesController;
use App\Http\Controllers\ResultatsController;
use App\Http\Controllers\GroupesController;
use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//user dash 
Route::get('/user', function () {
    return view('userdash');
})->name('user');
Route::middleware(['auth'])->group(function () {
   Route::get('/questions', [QuestionController::class, 'index'])->name('questions.bank');
Route::post('/questions', [QuestionController::class, 'store'])->name('questions.store');
Route::put('/questions/{id}', [QuestionController::class, 'update'])->name('questions.update');
Route::delete('/questions/{id}', [QuestionController::class, 'destroy'])->name('questions.destroy');
//routes for campaigns
Route::get('/questions/campaigns', [CampagnesController::class, 'index'])->name('questions.campaigns');
Route::post('/questions/campaigns', [CampagnesController::class, 'store'])->name('campagnes.store');
Route::put('/questions/campaigns/{id}', [CampagnesController::class, 'update'])->name('questions.campaigns.update');
Route::delete('/questions/campaigns/{id}', [CampagnesController::class, 'destroy'])->name('questions.campaigns.destroy');
Route::get('/questions/campaigns/{id}/results', [ResultatsController::class, 'index'])->name('questions.campaigns.results');
Route::get('/questions/campaigns/{id}/results/export', [ResultatsController::class, 'export'])->name('questions.campaigns.results.export');
Route::get('/questions/campaigns/{id}/results/export/pdf', [ResultatsController::class, 'exportPdf'])->name('questions.campaigns.results.export.pdf');
Route::get('/questions/campaigns/{id}/results/export/excel', [ResultatsController::class, 'exportExcel'])->name('questions.campaigns.results.export.excel');
});
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified', 'subscribed'])->name('dashboard');

Route::middleware(['auth', 'subscribed'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    //show profile
    Route::get('/profile/show', [ProfileController::class, 'show'])->name('profile.show');
});
//for quiz view 
Route::get('/quiz', [CampagnesController::class, 'quiz'])->name('quiz');
Route::get('/structure', [StructureController::class, 'index'])->name('structure');
Route::get('/metiers', [MetiersController::class, 'index'])->name('metiers');
Route::get('/salariers/show', [SalariesController::class, 'index'])->name('salaries');
Route::get('/campagnes', [CampagnesController::class, 'index'])->name('campagnes');
Route::get('/resultats', [ResultatsController::class, 'overview'])->name('resultats');

Route::post('/structure/save', [StructureController::class, 'store'])->name('save.structure');

// Métier
Route::post('/metiers', [MetiersController::class, 'store']);
Route::put('/metiers/{id}', [MetiersController::class, 'update']);

// Salarié
Route::post('/salaries', [SalariesController::class, 'store']);
Route::put('/salaries/{id}', [SalariesController::class, 'update']);

// Groupe
Route::post('/groupes', [GroupesController::class, 'store']);
Route::put('/groupes/{id}', [GroupesController::class, 'update']);

// Quiz submission route
Route::post('/quiz-submit', [CampagnesController::class, 'submitQuiz'])->name('quiz.submit')->middleware('auth');

// Results routes for salariés
Route::get('/mes-resultats', [CampagnesController::class, 'mesResultats'])->name('mes.resultats')->middleware('auth');

require __DIR__.'/auth.php';

// Pricing and Subscription Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/pricing', [App\Http\Controllers\PricingController::class, 'index'])->name('pricing');
    Route::post('/pricing/checkout', [App\Http\Controllers\PricingController::class, 'checkout'])->name('pricing.checkout');
    Route::get('/pricing/success', [App\Http\Controllers\PricingController::class, 'success'])->name('pricing.success');
    Route::get('/pricing/cancel', [App\Http\Controllers\PricingController::class, 'cancel'])->name('pricing.cancel');
});

// Stripe Webhooks (no auth middleware)
Route::post('/stripe/webhook', [App\Http\Controllers\WebhookController::class, 'handleWebhook'])->name('cashier.webhook');
