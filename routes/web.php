<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Finance\IncomeController;
use App\Http\Controllers\Finance\ExpenseController;
use App\Http\Controllers\Finance\BalanceController;
use App\Http\Controllers\Finance\ReportController;
use App\Http\Controllers\Finance\SacramentController;
use App\Http\Controllers\Finance\ZakaController;
use App\Http\Controllers\Finance\SadakaController;
use App\Http\Controllers\Finance\FunguLaKumiController;
use App\Http\Controllers\Finance\ShukraniController;
use App\Http\Controllers\Finance\MichangoMingineController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\ParishionerController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\ApostolicGroupController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Event\EventApprovalController;
use App\Http\Controllers\Event\EventLiturgicalRoleController;
use App\Http\Controllers\Event\EventAttendanceController;
use App\Http\Controllers\Event\EventRegistrationController;
use App\Http\Controllers\Event\EventFinanceController;
use App\Http\Controllers\Event\EventMediaController;
use App\Http\Controllers\Event\EventReportController;
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
use App\Http\Controllers\Settings\FinancialYearController;
use App\Http\Controllers\Settings\SystemSettingsController;
use App\Http\Controllers\Auth\RoleSwitchController;
use App\Http\Controllers\Auth\ImpersonationController;
use App\Http\Controllers\ProfileController;

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/login/2fa/verify', [LoginController::class, 'verify2FA'])->name('login.2fa.verify');
Route::post('/login/2fa/bypass', [LoginController::class, 'bypass2FA'])->name('login.2fa.bypass');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::post('/switch-role', RoleSwitchController::class)->name('switch-role');

    Route::post('/impersonate/start', [ImpersonationController::class, 'start'])->name('impersonate.start');
    Route::post('/impersonate/stop', [ImpersonationController::class, 'stop'])->name('impersonate.stop');

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
        
        // Contribution-specific routes
        Route::prefix('zaka')->name('zaka.')->group(function () {
            Route::get('/', [ZakaController::class, 'index'])->name('index');
            Route::get('/create', [ZakaController::class, 'create'])->name('create');
            Route::post('/', [ZakaController::class, 'store'])->name('store');
            Route::get('/{id}', [ZakaController::class, 'show'])->name('show');
        });
        
        Route::prefix('sadaka')->name('sadaka.')->group(function () {
            Route::get('/', [SadakaController::class, 'index'])->name('index');
            Route::get('/create', [SadakaController::class, 'create'])->name('create');
            Route::post('/', [SadakaController::class, 'store'])->name('store');
            Route::get('/{id}', [SadakaController::class, 'show'])->name('show');
        });
        
        Route::prefix('fungu-la-kumi')->name('fungu-la-kumi.')->group(function () {
            Route::get('/', [FunguLaKumiController::class, 'index'])->name('index');
            Route::get('/create', [FunguLaKumiController::class, 'create'])->name('create');
            Route::post('/', [FunguLaKumiController::class, 'store'])->name('store');
            Route::get('/{id}', [FunguLaKumiController::class, 'show'])->name('show');
        });
        
        Route::prefix('shukrani')->name('shukrani.')->group(function () {
            Route::get('/', [ShukraniController::class, 'index'])->name('index');
            Route::get('/create', [ShukraniController::class, 'create'])->name('create');
            Route::post('/', [ShukraniController::class, 'store'])->name('store');
            Route::get('/{id}', [ShukraniController::class, 'show'])->name('show');
        });
        
        Route::prefix('michango-mingine')->name('michango-mingine.')->group(function () {
            Route::get('/', [MichangoMingineController::class, 'index'])->name('index');
            Route::get('/create', [MichangoMingineController::class, 'create'])->name('create');
            Route::post('/', [MichangoMingineController::class, 'store'])->name('store');
            Route::get('/{id}', [MichangoMingineController::class, 'show'])->name('show');
        });
        
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
        Route::get('/reports/daily/pdf', [ReportController::class, 'dailyPdf'])->name('reports.daily.pdf');
        Route::get('/reports/monthly', [ReportController::class, 'monthly'])->name('reports.monthly');
        Route::get('/reports/monthly/pdf', [ReportController::class, 'monthlyPdf'])->name('reports.monthly.pdf');
        Route::get('/reports/annual', [ReportController::class, 'annual'])->name('reports.annual');
        Route::get('/reports/annual/pdf', [ReportController::class, 'annualPdf'])->name('reports.annual.pdf');
        
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
    Route::get('/events/calendar', [EventController::class, 'calendar'])->name('events.calendar');
    Route::get('/events/{id}/qr-code', [EventController::class, 'qrCode'])->name('events.qr-code');
    Route::resource('events', EventController::class);
    
    // Event sub-features
    Route::prefix('events/{eventId}')->name('events.')->group(function () {
        Route::get('/approvals', [EventApprovalController::class, 'index'])->name('approvals');
        Route::post('/approvals', [EventApprovalController::class, 'store'])->name('approvals.store');
        Route::put('/approvals/{id}', [EventApprovalController::class, 'update'])->name('approvals.update');
        
        Route::get('/volunteers', [EventLiturgicalRoleController::class, 'index'])->name('volunteers.index');
        Route::post('/volunteers', [EventLiturgicalRoleController::class, 'store'])->name('volunteers.store');
        Route::put('/volunteers/{id}', [EventLiturgicalRoleController::class, 'update'])->name('volunteers.update');
        Route::delete('/volunteers/{id}', [EventLiturgicalRoleController::class, 'destroy'])->name('volunteers.destroy');
        
        Route::get('/attendance', [EventAttendanceController::class, 'index'])->name('attendance.index');
        Route::post('/attendance', [EventAttendanceController::class, 'store'])->name('attendance.store');
        Route::put('/attendance/{id}', [EventAttendanceController::class, 'update'])->name('attendance.update');
        
        Route::get('/registrations', [EventRegistrationController::class, 'index'])->name('registrations.index');
        Route::post('/registrations', [EventRegistrationController::class, 'store'])->name('registrations.store');
        Route::put('/registrations/{id}', [EventRegistrationController::class, 'update'])->name('registrations.update');
        
        Route::get('/finances', [EventFinanceController::class, 'index'])->name('finances.index');
        Route::post('/finances', [EventFinanceController::class, 'store'])->name('finances.store');
        Route::put('/finances/{id}', [EventFinanceController::class, 'update'])->name('finances.update');
        
        Route::get('/media', [EventMediaController::class, 'index'])->name('media.index');
        Route::post('/media', [EventMediaController::class, 'store'])->name('media.store');
        Route::delete('/media/{id}', [EventMediaController::class, 'destroy'])->name('media.destroy');
        
        Route::get('/reports', [EventReportController::class, 'index'])->name('reports');
    });
    
    // Leaders Routes
    Route::resource('leaders', LeaderController::class);
    
    // SMS Routes
    Route::prefix('sms')->name('sms.')->group(function () {
        Route::get('/create', [SmsCampaignController::class, 'create'])->name('create');
        Route::post('/store', [SmsCampaignController::class, 'store'])->name('store');
        
        // Templates
        Route::get('/templates', [SmsTemplateController::class, 'index'])->name('templates.index');
        Route::get('/templates/create', [SmsTemplateController::class, 'create'])->name('templates.create');
        Route::post('/templates', [SmsTemplateController::class, 'store'])->name('templates.store');
        Route::get('/templates/{id}/edit', [SmsTemplateController::class, 'edit'])->name('templates.edit');
        Route::put('/templates/{id}', [SmsTemplateController::class, 'update'])->name('templates.update');
        Route::delete('/templates/{id}', [SmsTemplateController::class, 'destroy'])->name('templates.destroy');
        
        // Approval
        Route::get('/approval', [SmsApprovalController::class, 'index'])->name('approval.index');
        Route::post('/approval/{id}/approve', [SmsApprovalController::class, 'approve'])->name('approval.approve');
        Route::post('/approval/{id}/reject', [SmsApprovalController::class, 'reject'])->name('approval.reject');
        
        // Batches
        Route::get('/batches', [SmsBatchController::class, 'index'])->name('batches.index');
        
        // Reports
        Route::get('/reports', [SmsReportController::class, 'index'])->name('reports.index');
    });
    
    // Reports Routes
    Route::get('/reports', [GeneralReportController::class, 'index'])->name('reports.index');
    
    // Settings Routes
    Route::prefix('settings')->name('settings.')->group(function () {
        // System Settings Dashboard
        Route::get('/system', [SystemSettingsController::class, 'index'])->name('system.index');
        Route::get('/system/health', [SystemSettingsController::class, 'health'])->name('system.health');
        Route::post('/system/backup', [SystemSettingsController::class, 'backup'])->name('system.backup');
        
        Route::resource('users', UserController::class);
        Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
        Route::put('/permissions/{id}', [PermissionController::class, 'updatePermissions'])->name('permissions.update');
        Route::get('/general', [GeneralSettingsController::class, 'index'])->name('general');
        Route::post('/general', [GeneralSettingsController::class, 'store'])->name('general.store');
        Route::get('/account', [GeneralSettingsController::class, 'account'])->name('account');
        Route::get('/security', [GeneralSettingsController::class, 'security'])->name('security');
        Route::post('/security/password', [GeneralSettingsController::class, 'updatePassword'])->name('security.password');
        Route::resource('notification-providers', \App\Http\Controllers\Settings\NotificationProviderController::class);
        Route::post('/notification-providers/{id}/set-primary', [\App\Http\Controllers\Settings\NotificationProviderController::class, 'setPrimary'])->name('notification-providers.set-primary');
        Route::post('/notification-providers/{id}/test-email', [\App\Http\Controllers\Settings\NotificationProviderController::class, 'testEmail'])->name('notification-providers.test-email');
        Route::post('/notification-providers/{id}/test-sms', [\App\Http\Controllers\Settings\NotificationProviderController::class, 'testSms'])->name('notification-providers.test-sms');
        Route::get('/notification-providers/{id}/balance', [\App\Http\Controllers\Settings\NotificationProviderController::class, 'checkBalance'])->name('notification-providers.balance');
        
        // Financial Years
        Route::get('/financial-years', [FinancialYearController::class, 'index'])->name('financial-years.index');
        Route::get('/financial-years/create', [FinancialYearController::class, 'create'])->name('financial-years.create');
        Route::post('/financial-years', [FinancialYearController::class, 'store'])->name('financial-years.store');
        Route::post('/financial-years/{id}/set-active', [FinancialYearController::class, 'setActive'])->name('financial-years.set-active');
        Route::post('/financial-years/{id}/close', [FinancialYearController::class, 'close'])->name('financial-years.close');
        Route::get('/financial-years/{id}/transition', [FinancialYearController::class, 'showTransition'])->name('financial-years.transition');
        Route::post('/financial-years/{id}/transition', [FinancialYearController::class, 'transition'])->name('financial-years.transition.store');
        
        // SMS Settings (using notification providers)
        Route::get('/sms', [\App\Http\Controllers\Settings\NotificationProviderController::class, 'smsIndex'])->name('sms.index');
        
        // Email Settings (using notification providers)
        Route::get('/email', [\App\Http\Controllers\Settings\NotificationProviderController::class, 'emailIndex'])->name('email.index');
        
        // Two Factor Authentication
        Route::get('/two-factor', [\App\Http\Controllers\Settings\TwoFactorController::class, 'index'])->name('two-factor.index');
        Route::post('/two-factor/enable', [\App\Http\Controllers\Settings\TwoFactorController::class, 'enable'])->name('two-factor.enable');
        Route::post('/two-factor/disable', [\App\Http\Controllers\Settings\TwoFactorController::class, 'disable'])->name('two-factor.disable');
        Route::post('/two-factor/regenerate', [\App\Http\Controllers\Settings\TwoFactorController::class, 'regenerateRecoveryCodes'])->name('two-factor.regenerate');
        
        // Advanced Settings
        Route::get('/advanced', [\App\Http\Controllers\Settings\AdvancedSettingsController::class, 'index'])->name('advanced.index');
        Route::post('/advanced', [\App\Http\Controllers\Settings\AdvancedSettingsController::class, 'store'])->name('advanced.store');
        Route::post('/advanced/logo', [\App\Http\Controllers\Settings\AdvancedSettingsController::class, 'uploadLogo'])->name('advanced.upload-logo');
    });
    
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Redirect root to dashboard
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });
});
