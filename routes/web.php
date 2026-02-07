<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Finance\IncomeController;
use App\Http\Controllers\Finance\ExpenseController;
use App\Http\Controllers\Finance\BalanceController;
use App\Http\Controllers\Finance\ReportController;
use App\Http\Controllers\Finance\SacramentController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\ParishionerController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\ApostolicGroupController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\LeaderController;
use App\Http\Controllers\Sms\SmsCampaignController;
use App\Http\Controllers\Sms\SmsTemplateController;
use App\Http\Controllers\Sms\SmsApprovalController;
use App\Http\Controllers\Sms\SmsBatchController;
use App\Http\Controllers\Sms\SmsReportController;
use App\Http\Controllers\ReportController as GeneralReportController;
use App\Http\Controllers\Settings\UserController;
use App\Http\Controllers\Settings\PermissionController;
use App\Http\Controllers\Settings\GeneralSettingsController;

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Finance Routes
    Route::prefix('finance')->name('finance.')->group(function () {
        Route::get('/income', [IncomeController::class, 'index'])->name('income.index');
        Route::get('/income/create', [IncomeController::class, 'create'])->name('income.create');
        Route::post('/income', [IncomeController::class, 'store'])->name('income.store');
        Route::get('/income/{id}', [IncomeController::class, 'show'])->name('income.show');
        Route::get('/income/{id}/edit', [IncomeController::class, 'edit'])->name('income.edit');
        Route::put('/income/{id}', [IncomeController::class, 'update'])->name('income.update');
        Route::delete('/income/{id}', [IncomeController::class, 'destroy'])->name('income.destroy');
        Route::get('/income/{id}/print', [IncomeController::class, 'print'])->name('income.print');
        Route::get('/income/{id}/pdf', [IncomeController::class, 'pdf'])->name('income.pdf');
        
        Route::get('/expenses', [ExpenseController::class, 'index'])->name('expenses.index');
        Route::get('/expenses/create', [ExpenseController::class, 'create'])->name('expenses.create');
        Route::post('/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
        Route::get('/expenses/{id}', [ExpenseController::class, 'show'])->name('expenses.show');
        Route::get('/expenses/{id}/edit', [ExpenseController::class, 'edit'])->name('expenses.edit');
        Route::put('/expenses/{id}', [ExpenseController::class, 'update'])->name('expenses.update');
        Route::delete('/expenses/{id}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');
        
        Route::get('/balance', [BalanceController::class, 'index'])->name('balance');
        
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/daily', [ReportController::class, 'daily'])->name('reports.daily');
        Route::get('/reports/monthly', [ReportController::class, 'monthly'])->name('reports.monthly');
        Route::get('/reports/annual', [ReportController::class, 'annual'])->name('reports.annual');
        
        Route::get('/sacraments', [SacramentController::class, 'index'])->name('sacraments.index');
        Route::get('/sacraments/create', [SacramentController::class, 'create'])->name('sacraments.create');
        Route::post('/sacraments', [SacramentController::class, 'store'])->name('sacraments.store');
        Route::get('/sacraments/{id}', [SacramentController::class, 'show'])->name('sacraments.show');
        Route::get('/sacraments/{id}/edit', [SacramentController::class, 'edit'])->name('sacraments.edit');
        Route::put('/sacraments/{id}', [SacramentController::class, 'update'])->name('sacraments.update');
        Route::delete('/sacraments/{id}', [SacramentController::class, 'destroy'])->name('sacraments.destroy');
    });
    
    // Assets Routes
    Route::resource('assets', AssetController::class);
    
    // Parishioners Routes
    Route::get('/parishioners', [ParishionerController::class, 'index'])->name('parishioners.index');
    Route::get('/parishioners/create', [ParishionerController::class, 'create'])->name('parishioners.create');
    Route::post('/parishioners', [ParishionerController::class, 'store'])->name('parishioners.store');
    Route::get('/parishioners/{id}', [ParishionerController::class, 'show'])->name('parishioners.show');
    Route::get('/parishioners/{id}/edit', [ParishionerController::class, 'edit'])->name('parishioners.edit');
    Route::put('/parishioners/{id}', [ParishionerController::class, 'update'])->name('parishioners.update');
    Route::delete('/parishioners/{id}', [ParishionerController::class, 'destroy'])->name('parishioners.destroy');
    
    // Communities Routes
    Route::resource('communities', CommunityController::class);
    
    // Apostolic Groups Routes
    Route::resource('apostolic-groups', ApostolicGroupController::class);
    
    // Events Routes
    Route::resource('events', EventController::class);
    
    // Leaders Routes
    Route::resource('leaders', LeaderController::class);
    
    // SMS Routes
    Route::prefix('sms')->name('sms.')->group(function () {
        Route::get('/create', [SmsCampaignController::class, 'create'])->name('create');
        Route::post('/store', [SmsCampaignController::class, 'store'])->name('store');
        Route::get('/templates', [SmsTemplateController::class, 'index'])->name('templates.index');
        Route::get('/approval', [SmsApprovalController::class, 'index'])->name('approval.index');
        Route::post('/approval/{id}/approve', [SmsApprovalController::class, 'approve'])->name('approval.approve');
        Route::post('/approval/{id}/reject', [SmsApprovalController::class, 'reject'])->name('approval.reject');
        Route::get('/batches', [SmsBatchController::class, 'index'])->name('batches.index');
        Route::get('/reports', [SmsReportController::class, 'index'])->name('reports.index');
    });
    
    // Reports Routes
    Route::get('/reports', [GeneralReportController::class, 'index'])->name('reports.index');
    
    // Settings Routes
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::resource('users', UserController::class);
        Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
        Route::get('/general', [GeneralSettingsController::class, 'index'])->name('general');
        Route::get('/account', [GeneralSettingsController::class, 'account'])->name('account');
        Route::get('/security', [GeneralSettingsController::class, 'security'])->name('security');
        Route::resource('notification-providers', \App\Http\Controllers\Settings\NotificationProviderController::class);
        Route::post('/notification-providers/{id}/set-primary', [\App\Http\Controllers\Settings\NotificationProviderController::class, 'setPrimary'])->name('notification-providers.set-primary');
    });
    
    // Profile Routes
    Route::get('/profile', function () {
        return view('profile.show');
    })->name('profile.show');
    
    // Redirect root to dashboard
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });
});
