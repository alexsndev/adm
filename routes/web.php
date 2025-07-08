<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DebtController;
use App\Http\Controllers\DebtPaymentController;
use App\Http\Controllers\FinancialGoalController;
use App\Http\Controllers\GoalContributionController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\TimeEntryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\HouseholdTaskController;
use App\Http\Controllers\TaskCategoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PredictabilityPersonController;
use App\Http\Controllers\CreditCardController;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rotas resource para o sistema financeiro
Route::resource('accounts', AccountController::class)->middleware(['auth']);
Route::get('accounts/{account}/transactions', [AccountController::class, 'transactions'])->name('accounts.transactions')->middleware(['auth']);
Route::resource('categories', CategoryController::class)->middleware(['auth']);
Route::resource('transactions', TransactionController::class)->middleware(['auth']);

// Rotas para gestão de dívidas e futuro verde
Route::resource('debts', DebtController::class)->middleware(['auth']);
Route::resource('debt-payments', DebtPaymentController::class)->middleware(['auth']);
Route::resource('financial-goals', FinancialGoalController::class)->middleware(['auth']);

// Rotas para contribuições das metas financeiras
Route::resource('financial-goals.contributions', GoalContributionController::class)->middleware(['auth']);
Route::post('financial-goals/{financialGoal}/quick-contribution', [GoalContributionController::class, 'quickContribution'])->name('financial-goals.quick-contribution')->middleware(['auth']);

// Rota para listar todas as contribuições (redireciona para metas)
Route::get('goal-contributions', function () {
    return redirect()->route('financial-goals.index');
})->name('goal-contributions.index')->middleware(['auth']);

// Dashboard Geral
Route::get('/dashboard-geral', function () {
    return view('dashboard-geral');
})->middleware(['auth', 'verified'])->name('dashboard.geral');

// Módulo Projetos Profissionais
Route::resource('projetos', ProjectController::class)
    ->parameters(['projetos' => 'project'])
    ->middleware(['auth', 'verified']);
Route::resource('tarefas', TaskController::class)->middleware(['auth', 'verified']);
Route::resource('clientes', ClientController::class)->middleware(['auth', 'verified']);
Route::resource('registros-horas', TimeEntryController::class)->middleware(['auth', 'verified']);
Route::resource('faturas', InvoiceController::class)->middleware(['auth', 'verified']);
Route::get('faturas/{id}/pdf', [InvoiceController::class, 'generatePDF'])->name('faturas.pdf')->middleware(['auth', 'verified']);

// Módulo Tarefas Domésticas
Route::prefix('tarefas-domesticas')->name('household-tasks.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [HouseholdTaskController::class, 'index'])->name('index');
    Route::get('/dashboard', [HouseholdTaskController::class, 'dashboard'])->name('dashboard');
    Route::get('/create', [HouseholdTaskController::class, 'create'])->name('create');
    Route::post('/', [HouseholdTaskController::class, 'store'])->name('store');
    Route::get('/{householdTask}', [HouseholdTaskController::class, 'show'])->name('show');
    Route::get('/{householdTask}/edit', [HouseholdTaskController::class, 'edit'])->name('edit');
    Route::put('/{householdTask}', [HouseholdTaskController::class, 'update'])->name('update');
    Route::delete('/{householdTask}', [HouseholdTaskController::class, 'destroy'])->name('destroy');
    
    // Ações rápidas
    Route::post('/{householdTask}/complete', [HouseholdTaskController::class, 'complete'])->name('complete');
    Route::post('/{householdTask}/reopen', [HouseholdTaskController::class, 'reopen'])->name('reopen');
    Route::post('/{householdTask}/start', [HouseholdTaskController::class, 'start'])->name('start');
    Route::post('/{householdTask}/pause', [\App\Http\Controllers\HouseholdTaskController::class, 'pause'])->name('pause');
    Route::post('/{householdTask}/resume', [\App\Http\Controllers\HouseholdTaskController::class, 'resume'])->name('resume');
    Route::post('/{householdTask}/to-pending', [\App\Http\Controllers\HouseholdTaskController::class, 'toPending'])->name('toPending');
    Route::post('/{householdTask}/reset-timer', [\App\Http\Controllers\HouseholdTaskController::class, 'resetTimer'])->name('reset-timer');
    Route::post('/{householdTask}/update-time', [\App\Http\Controllers\HouseholdTaskController::class, 'updateTime'])->name('update-time');
    // Upload e remoção de fotos
    Route::post('/{householdTask}/upload-photo', [HouseholdTaskController::class, 'uploadPhoto'])->name('upload-photo');
    Route::delete('/{householdTask}/delete-photo/{photo}', [HouseholdTaskController::class, 'deletePhoto'])->name('delete-photo');
});

// Rotas para categorias de tarefas
Route::resource('task-categories', TaskCategoryController::class)->middleware(['auth', 'verified']);

// Sistema de Previsibilidade - Eventos
Route::resource('events', EventController::class)->middleware(['auth', 'verified']);
Route::get('events-calendar', [EventController::class, 'calendar'])->name('events.calendar')->middleware(['auth', 'verified']);
Route::post('event-occurrences/{occurrence}/status', [EventController::class, 'updateOccurrenceStatus'])->name('event-occurrences.status')->middleware(['auth', 'verified']);
Route::post('events/{event}/generate-occurrences', [EventController::class, 'generateOccurrences'])->name('events.generate-occurrences')->middleware(['auth', 'verified']);
Route::post('/events/force-generate-occurrences', [\App\Http\Controllers\EventController::class, 'forceGenerateAllOccurrences'])->name('events.force-generate-occurrences');
Route::get('/events/search', [EventController::class, 'search'])->name('events.search');

// Rotas resource para previsibilidade
Route::resource('previsibilidade', PredictabilityPersonController::class);
Route::post('previsibilidade/{id}/anexos', [\App\Http\Controllers\PredictabilityPersonController::class, 'addAttachment'])->name('previsibilidade.anexos');

// Rotas resource para cartões de crédito
Route::resource('credit-cards', CreditCardController::class)->middleware('auth');

Route::patch('tarefas/{task}/status', [App\Http\Controllers\TaskController::class, 'updateStatus'])->name('tarefas.updateStatus')->middleware(['auth', 'verified']);

// Anexos de projetos
Route::post('projetos/{project}/attachments', [\App\Http\Controllers\AttachmentController::class, 'store'])->name('projetos.attachments.store')->middleware(['auth', 'verified']);
Route::delete('projetos/{project}/attachments/{attachment}', [\App\Http\Controllers\AttachmentController::class, 'destroy'])->name('projetos.attachments.destroy')->middleware(['auth', 'verified']);
Route::get('projetos/{project}/attachments/{attachment}/download', [\App\Http\Controllers\AttachmentController::class, 'download'])->name('projetos.attachments.download')->middleware(['auth', 'verified']);

Route::post('/projetos/{project}/anexos', [App\Http\Controllers\ProjectController::class, 'uploadAttachment'])->name('projetos.anexos.upload');
Route::delete('/projetos/anexos/{mediaId}', [App\Http\Controllers\ProjectController::class, 'deleteAttachment'])->name('projetos.anexos.destroy');

// Rotas de timer para projetos profissionais
Route::post('/projetos/{project}/start-timer', [App\Http\Controllers\ProjectController::class, 'startTimer'])->name('projetos.start-timer');
Route::post('/projetos/{project}/pause-timer', [App\Http\Controllers\ProjectController::class, 'pauseTimer'])->name('projetos.pause-timer');
Route::post('/projetos/{project}/resume-timer', [App\Http\Controllers\ProjectController::class, 'resumeTimer'])->name('projetos.resume-timer');
Route::post('/projetos/{project}/reset-timer', [App\Http\Controllers\ProjectController::class, 'resetTimer'])->name('projetos.reset-timer');
Route::post('/projetos/{project}/update-time', [App\Http\Controllers\ProjectController::class, 'updateTime'])->name('projetos.update-time');

Route::post('/projetos/{project}/update-notes', [App\Http\Controllers\ProjectController::class, 'updateNotes'])->name('projetos.update-notes');

Route::prefix('projetos/{project}/links')->name('projetos.links.')->middleware(['auth', 'verified'])->group(function () {
    Route::post('/', [App\Http\Controllers\ProjectLinkController::class, 'store'])->name('store');
    Route::post('/{link}', [App\Http\Controllers\ProjectLinkController::class, 'update'])->name('update');
    Route::delete('/{link}', [App\Http\Controllers\ProjectLinkController::class, 'destroy'])->name('destroy');
});

require __DIR__.'/auth.php';
