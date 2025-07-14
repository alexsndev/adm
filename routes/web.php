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
use App\Http\Controllers\FinanceDashboardController;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\FixedIncomeController;
use App\Http\Controllers\FixedExpenseController;

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        if (auth()->check() && auth()->user()->is_client) {
            return redirect('/cliente/dashboard');
        }
        return redirect('/dashboard');
    });

    Route::get('/dashboard', function () {
        if (auth()->check() && auth()->user()->is_client) {
            return redirect()->route('cliente.dashboard');
        }
        return app(\App\Http\Controllers\DashboardController::class)->index();
    })->middleware(['auth', 'verified'])->name('dashboard');

    // Rota de teste para a sidebar
    Route::get('/test-sidebar', function () {
        return view('test-sidebar');
    })->middleware(['auth', 'verified'])->name('test-sidebar');

    Route::get('/profile', function () {
        if (auth()->check() && auth()->user()->is_client) {
            return redirect()->route('cliente.dashboard');
        }
        return app(\App\Http\Controllers\ProfileController::class)->edit(request());
    })->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Notificações
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::post('notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::delete('notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
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

// Dashboard Geral (usando o mesmo controller do dashboard principal)
Route::get('/dashboard-geral', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard.geral');

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

Route::get('/finance/dashboard', [FinanceDashboardController::class, 'index'])->name('finance.dashboard')->middleware(['auth', 'verified']);

// Remover middleware 'role:admin' e 'admin' das rotas
Route::get('/painel-admin', function () {
    if (!auth()->check() || !auth()->user()->is_admin) {
        abort(403, 'Acesso não autorizado');
    }
    return view('painel-admin');
});

Route::get('/admin-teste', function () {
    if (!auth()->check() || !auth()->user()->is_admin) {
        abort(403, 'Acesso não autorizado');
    }
    return view('admin-teste');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin', function() {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Acesso não autorizado');
        }
        return redirect()->route('admin.users.index');
    })->name('admin.home');
    Route::get('/admin/users', [\App\Http\Controllers\UserAdminController::class, 'index'])->name('admin.users.index');
    Route::post('/admin/users/{user}/toggle-admin', [\App\Http\Controllers\UserAdminController::class, 'toggleAdmin'])->name('admin.users.toggle');
    Route::post('/admin/users/{user}/toggle-client', [\App\Http\Controllers\UserAdminController::class, 'toggleClient'])->name('admin.users.toggle-client');
    Route::delete('/admin/users/{user}', [\App\Http\Controllers\UserAdminController::class, 'destroy'])->name('admin.users.destroy');
});

// Rotas para criar usuário de cliente no admin
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/cliente-users/create', function() {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Acesso não autorizado');
        }
        return app(\App\Http\Controllers\Admin\ClienteUserController::class)->create();
    })->name('admin.cliente-users.create');
    Route::post('/admin/cliente-users', function() {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Acesso não autorizado');
        }
        return app(\App\Http\Controllers\Admin\ClienteUserController::class)->store(request());
    })->name('admin.cliente-users.store');
});

// Rotas do chat do admin
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/chats', [App\Http\Controllers\Admin\ChatController::class, 'index'])->name('admin.chats.index');
    Route::get('/admin/chats/{client}', [App\Http\Controllers\Admin\ChatController::class, 'show'])->name('admin.chats.show');
    Route::post('/admin/chats/{client}', [App\Http\Controllers\Admin\ChatController::class, 'store'])->name('admin.chats.store');
});

// Rotas da área do cliente
Route::get('/cliente/dashboard', function() {
    if (!auth()->check() || !auth()->user()->is_client) {
        abort(403, 'Acesso não autorizado');
    }
    return app(\App\Http\Controllers\Cliente\DashboardController::class)->index();
})->name('cliente.dashboard');
Route::get('/cliente/projetos', function() {
    if (!auth()->check() || !auth()->user()->is_client) {
        abort(403, 'Acesso não autorizado');
    }
    return app(\App\Http\Controllers\Cliente\ProjetoController::class)->index();
})->name('cliente.projetos');
Route::get('/cliente/projetos/{id}', function($id) {
    if (!auth()->check() || !auth()->user()->is_client) {
        abort(403, 'Acesso não autorizado');
    }
    return app(\App\Http\Controllers\Cliente\ProjetoController::class)->show($id);
})->name('cliente.projetos.show');
Route::get('/cliente/tarefas', function() {
    if (!auth()->check() || !auth()->user()->is_client) {
        abort(403, 'Acesso não autorizado');
    }
    return app(\App\Http\Controllers\Cliente\TarefaController::class)->index();
})->name('cliente.tarefas');
// Corrigindo as rotas do chat do cliente para usar array controller
Route::middleware(['auth'])->group(function () {
    Route::get('/cliente/chat', [\App\Http\Controllers\Cliente\ChatController::class, 'index'])->name('cliente.chat');
    Route::post('/cliente/chat', [\App\Http\Controllers\Cliente\ChatController::class, 'store'])->name('cliente.chat.store');
    Route::get('/cliente/chat/messages', [\App\Http\Controllers\Cliente\ChatController::class, 'getMessages'])->name('cliente.chat.messages');
    Route::delete('/cliente/chat/mensagem/{id}', [\App\Http\Controllers\Cliente\ChatController::class, 'destroy'])->name('cliente.chat.mensagem.destroy');
    Route::delete('/cliente/chat/mensagens', [\App\Http\Controllers\Cliente\ChatController::class, 'destroyAll'])->name('cliente.chat.mensagens.destroyAll');
});
Route::post('/projetos/{id}/chat', [\App\Http\Controllers\Cliente\ProjetoController::class, 'enviarMensagem'])->name('projetos.chat')->middleware('auth');
Route::post('/cliente/projetos/{id}/chat', [\App\Http\Controllers\Cliente\ProjetoController::class, 'enviarMensagem'])->name('cliente.projetos.chat');

// Rota AJAX para chat do admin (mesma lógica do cliente, mas retorna JSON)
Route::post('/admin/projetos/{id}/chat', [\App\Http\Controllers\Cliente\ProjetoController::class, 'enviarMensagemAdmin'])->name('admin.projetos.chat')->middleware('auth');
Route::get('/admin/projetos/{id}/chat', [\App\Http\Controllers\Cliente\ProjetoController::class, 'enviarMensagemAdmin'])->name('admin.projetos.chat.get')->middleware('auth');
Route::get('/cliente/projetos/{id}/chat', [\App\Http\Controllers\Cliente\ProjetoController::class, 'enviarMensagem'])->name('cliente.projetos.chat.get')->middleware('auth');
Route::get('/projetos/{id}/chat', [\App\Http\Controllers\Cliente\ProjetoController::class, 'enviarMensagemAdmin'])->name('projetos.chat.get')->middleware('auth');

Route::middleware(['auth', 'verified'])->prefix('finance')->name('finance.')->group(function () {
    // Receitas Fixas
    Route::get('receitas-fixas', [FixedIncomeController::class, 'index'])->name('fixed-incomes.index');
    Route::get('receitas-fixas/create', [FixedIncomeController::class, 'create'])->name('fixed-incomes.create');
    Route::post('receitas-fixas', [FixedIncomeController::class, 'store'])->name('fixed-incomes.store');
    Route::get('receitas-fixas/{id}/edit', [FixedIncomeController::class, 'edit'])->name('fixed-incomes.edit');
    Route::put('receitas-fixas/{id}', [FixedIncomeController::class, 'update'])->name('fixed-incomes.update');
    Route::delete('receitas-fixas/{id}', [FixedIncomeController::class, 'destroy'])->name('fixed-incomes.destroy');
    Route::post('receitas-fixas/{id}/receive', [FixedIncomeController::class, 'receive'])->name('fixed-incomes.receive');
    // Despesas Fixas
    Route::get('despesas-fixas', [FixedExpenseController::class, 'index'])->name('fixed-expenses.index');
    Route::get('despesas-fixas/create', [FixedExpenseController::class, 'create'])->name('fixed-expenses.create');
    Route::post('despesas-fixas', [FixedExpenseController::class, 'store'])->name('fixed-expenses.store');
    Route::get('despesas-fixas/{id}/edit', [FixedExpenseController::class, 'edit'])->name('fixed-expenses.edit');
    Route::put('despesas-fixas/{id}', [FixedExpenseController::class, 'update'])->name('fixed-expenses.update');
    Route::delete('despesas-fixas/{id}', [FixedExpenseController::class, 'destroy'])->name('fixed-expenses.destroy');
    Route::post('despesas-fixas/{id}/pay', [FixedExpenseController::class, 'pay'])->name('fixed-expenses.pay');
});
