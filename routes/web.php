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
use App\Http\Controllers\ContributionController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\FinancialReportController;
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
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\MassController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\CommunicationController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\OfficeReportController;
use App\Http\Controllers\CommunityReportController;
use App\Http\Controllers\SpiritualReportController;
use App\Http\Controllers\GroupReportController;
use App\Http\Controllers\EventReportController as EventReportControllerAlias;
use App\Http\Controllers\Finance\BudgetController as FinanceBudgetController;
use App\Http\Controllers\Finance\AuditController as FinanceAuditController;
use App\Http\Controllers\ReceiptController as FinanceReceiptController;
use App\Http\Controllers\GroupMeetingController;
use App\Http\Controllers\GroupMemberController;
use App\Http\Controllers\GroupProgramController;
use App\Http\Controllers\EventTaskController;
use App\Http\Controllers\EventVolunteerController;
use App\Http\Controllers\GroupScheduleController;
use App\Http\Controllers\OutreachController;
use App\Http\Controllers\VolunteerController;

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/login/2fa/verify', [LoginController::class, 'verify2FA'])->name('login.2fa.verify');
Route::post('/login/2fa/bypass', [LoginController::class, 'bypass2FA'])->name('login.2fa.bypass');
Route::get('/login/2fa/cancel', [LoginController::class, 'cancel2FA'])->name('login.2fa.cancel');
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
        
        // Financial Management Routes
        Route::resource('contributions', ContributionController::class);
        Route::get('/contributions/import', [ContributionController::class, 'import'])->name('contributions.import');
        Route::post('/contributions/import', [ContributionController::class, 'storeImport'])->name('contributions.import.store');
        
        Route::resource('receipts', ReceiptController::class);
        Route::get('/receipts/{receipt}/pdf', [ReceiptController::class, 'pdf'])->name('receipts.pdf');
        
        Route::resource('expenses', ExpenseController::class);
        Route::get('/expenses/import', [ExpenseController::class, 'import'])->name('expenses.import');
        Route::post('/expenses/import', [ExpenseController::class, 'storeImport'])->name('expenses.import.store');
        
        Route::resource('financial-reports', FinancialReportController::class);
        Route::get('/financial-reports/export/{format}', [FinancialReportController::class, 'export'])->name('financial-reports.export');
        
        Route::get('/sacraments/create', [SacramentController::class, 'create'])->name('sacraments.create');
        Route::post('/sacraments', [SacramentController::class, 'store'])->name('sacraments.store');
        Route::get('/sacraments/{id}', [SacramentController::class, 'show'])->name('sacraments.show');
        Route::get('/sacraments/{id}/edit', [SacramentController::class, 'edit'])->name('sacraments.edit');
        Route::put('/sacraments/{id}', [SacramentController::class, 'update'])->name('sacraments.update');
        Route::delete('/sacraments/{id}', [SacramentController::class, 'destroy'])->name('sacraments.destroy');
    });
    
    // Mass Management Routes
    Route::get('/masses', [MassController::class, 'index'])->name('masses.index');
    Route::get('/masses/create', [MassController::class, 'create'])->name('masses.create');
    Route::post('/masses', [MassController::class, 'store'])->name('masses.store');
    Route::get('/masses/{id}', [MassController::class, 'show'])->name('masses.show');
    Route::get('/masses/{id}/edit', [MassController::class, 'edit'])->name('masses.edit');
    Route::put('/masses/{id}', [MassController::class, 'update'])->name('masses.update');
    Route::delete('/masses/{id}', [MassController::class, 'destroy'])->name('masses.destroy');
    
    // Appointment Management Routes
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/{id}', [AppointmentController::class, 'show'])->name('appointments.show');
    Route::get('/appointments/{id}/edit', [AppointmentController::class, 'edit'])->name('appointments.edit');
    Route::put('/appointments/{id}', [AppointmentController::class, 'update'])->name('appointments.update');
    Route::delete('/appointments/{id}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');
    
    // Communication Management Routes
    Route::get('/communications', [CommunicationController::class, 'index'])->name('communications.index');
    Route::get('/communications/create', [CommunicationController::class, 'create'])->name('communications.create');
    Route::post('/communications', [CommunicationController::class, 'store'])->name('communications.store');
    Route::get('/communications/{id}', [CommunicationController::class, 'show'])->name('communications.show');
    Route::get('/communications/{id}/edit', [CommunicationController::class, 'edit'])->name('communications.edit');
    Route::put('/communications/{id}', [CommunicationController::class, 'update'])->name('communications.update');
    Route::delete('/communications/{id}', [CommunicationController::class, 'destroy'])->name('communications.destroy');
    
    // Document Management Routes
    Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
    Route::get('/documents/create', [DocumentController::class, 'create'])->name('documents.create');
    Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
    Route::get('/documents/{id}', [DocumentController::class, 'show'])->name('documents.show');
    Route::get('/documents/{id}/edit', [DocumentController::class, 'edit'])->name('documents.edit');
    Route::put('/documents/{id}', [DocumentController::class, 'update'])->name('documents.update');
    Route::delete('/documents/{id}', [DocumentController::class, 'destroy'])->name('documents.destroy');
    
    // Record Management Routes
    Route::get('/records', [RecordController::class, 'index'])->name('records.index');
    Route::get('/records/create', [RecordController::class, 'create'])->name('records.create');
    Route::post('/records', [RecordController::class, 'store'])->name('records.store');
    Route::get('/records/{id}', [RecordController::class, 'show'])->name('records.show');
    Route::get('/records/{id}/edit', [RecordController::class, 'edit'])->name('records.edit');
    Route::put('/records/{id}', [RecordController::class, 'update'])->name('records.update');
    Route::delete('/records/{id}', [RecordController::class, 'destroy'])->name('records.destroy');
    
    // Group Management Routes
    Route::get('/groups', [GroupController::class, 'index'])->name('groups.index');
    Route::get('/groups/create', [GroupController::class, 'create'])->name('groups.create');
    Route::post('/groups', [GroupController::class, 'store'])->name('groups.store');
    Route::get('/groups/{id}', [GroupController::class, 'show'])->name('groups.show');
    Route::get('/groups/{id}/edit', [GroupController::class, 'edit'])->name('groups.edit');
    Route::put('/groups/{id}', [GroupController::class, 'update'])->name('groups.update');
    Route::delete('/groups/{id}', [GroupController::class, 'destroy'])->name('groups.destroy');
    
    // Office Report Routes
    Route::get('/reports/office', [OfficeReportController::class, 'index'])->name('reports.office');
    Route::get('/reports/office/pdf', [OfficeReportController::class, 'pdf'])->name('reports.office.pdf');
    
    // Community Report Routes
    Route::get('/reports/community', [CommunityReportController::class, 'index'])->name('reports.community');
    Route::get('/reports/community/pdf', [CommunityReportController::class, 'pdf'])->name('reports.community.pdf');
    
    // Spiritual Report Routes
    Route::get('/reports/spiritual', [SpiritualReportController::class, 'index'])->name('reports.spiritual');
    Route::get('/reports/spiritual/pdf', [SpiritualReportController::class, 'pdf'])->name('reports.spiritual.pdf');
    
    // Group Report Routes
    Route::get('/reports/group', [GroupReportController::class, 'index'])->name('reports.group');
    Route::get('/reports/group/pdf', [GroupReportController::class, 'pdf'])->name('reports.group.pdf');
    
    // Event Report Routes
    Route::get('/reports/event', [EventReportController::class, 'index'])->name('reports.event');
    Route::get('/reports/event/pdf', [EventReportController::class, 'pdf'])->name('reports.event.pdf');
    
    // Finance Budget Routes
    Route::get('/finance/budget', [FinanceBudgetController::class, 'index'])->name('finance.budget');
    Route::get('/finance/budget/create', [FinanceBudgetController::class, 'create'])->name('finance.budget.create');
    Route::post('/finance/budget', [FinanceBudgetController::class, 'store'])->name('finance.budget.store');
    Route::get('/finance/budget/{id}/edit', [FinanceBudgetController::class, 'edit'])->name('finance.budget.edit');
    Route::put('/finance/budget/{id}', [FinanceBudgetController::class, 'update'])->name('finance.budget.update');
    Route::delete('/finance/budget/{id}', [FinanceBudgetController::class, 'destroy'])->name('finance.budget.destroy');
    
    // Finance Audit Routes
    Route::get('/finance/audit', [FinanceAuditController::class, 'index'])->name('finance.audit');
    Route::get('/finance/audit/trail', [FinanceAuditController::class, 'trail'])->name('finance.audit.trail');
    
    // Finance Receipt Routes
    Route::get('/finance/receipts', [FinanceReceiptController::class, 'index'])->name('finance.receipts');
    Route::get('/finance/receipts/create', [FinanceReceiptController::class, 'create'])->name('finance.receipts.create');
    Route::post('/finance/receipts', [FinanceReceiptController::class, 'store'])->name('finance.receipts.store');
    Route::get('/finance/receipts/{id}', [FinanceReceiptController::class, 'show'])->name('finance.receipts.show');
    Route::get('/finance/receipts/{id}/download', [FinanceReceiptController::class, 'download'])->name('finance.receipts.download');
    
    // Group Meeting Routes
    Route::get('/groups/meetings', [GroupMeetingController::class, 'index'])->name('groups.meetings');
    Route::get('/groups/meetings/create', [GroupMeetingController::class, 'create'])->name('groups.meetings.create');
    Route::post('/groups/meetings', [GroupMeetingController::class, 'store'])->name('groups.meetings.store');
    Route::get('/groups/meetings/{id}', [GroupMeetingController::class, 'show'])->name('groups.meetings.show');
    Route::get('/groups/meetings/{id}/edit', [GroupMeetingController::class, 'edit'])->name('groups.meetings.edit');
    Route::put('/groups/meetings/{id}', [GroupMeetingController::class, 'update'])->name('groups.meetings.update');
    Route::delete('/groups/meetings/{id}', [GroupMeetingController::class, 'destroy'])->name('groups.meetings.destroy');
    
    // Group Member Routes
    Route::get('/groups/members', [GroupMemberController::class, 'index'])->name('groups.members');
    Route::get('/groups/members/add', [GroupMemberController::class, 'add'])->name('groups.members.add');
    Route::post('/groups/members', [GroupMemberController::class, 'store'])->name('groups.members.store');
    Route::delete('/groups/members/{id}', [GroupMemberController::class, 'remove'])->name('groups.members.remove');
    
    // Group Program Routes
    Route::get('/groups/programs', [GroupProgramController::class, 'index'])->name('groups.programs');
    Route::get('/groups/programs/create', [GroupProgramController::class, 'create'])->name('groups.programs.create');
    Route::post('/groups/programs', [GroupProgramController::class, 'store'])->name('groups.programs.store');
    Route::get('/groups/programs/{id}', [GroupProgramController::class, 'show'])->name('groups.programs.show');
    Route::get('/groups/programs/{id}/edit', [GroupProgramController::class, 'edit'])->name('groups.programs.edit');
    Route::put('/groups/programs/{id}', [GroupProgramController::class, 'update'])->name('groups.programs.update');
    Route::delete('/groups/programs/{id}', [GroupProgramController::class, 'destroy'])->name('groups.programs.destroy');
    
    // Event Task Routes
    Route::get('/events/tasks', [EventTaskController::class, 'index'])->name('events.tasks');
    Route::get('/events/tasks/create', [EventTaskController::class, 'create'])->name('events.tasks.create');
    Route::post('/events/tasks', [EventTaskController::class, 'store'])->name('events.tasks.store');
    Route::get('/events/tasks/{id}', [EventTaskController::class, 'show'])->name('events.tasks.show');
    Route::get('/events/tasks/{id}/edit', [EventTaskController::class, 'edit'])->name('events.tasks.edit');
    Route::put('/events/tasks/{id}', [EventTaskController::class, 'update'])->name('events.tasks.update');
    Route::delete('/events/tasks/{id}', [EventTaskController::class, 'destroy'])->name('events.tasks.destroy');
    
    // Event Volunteer Routes
    Route::get('/events/volunteers', [EventVolunteerController::class, 'index'])->name('events.volunteers');
    Route::get('/events/volunteers/add', [EventVolunteerController::class, 'add'])->name('events.volunteers.add');
    Route::post('/events/volunteers', [EventVolunteerController::class, 'store'])->name('events.volunteers.store');
    Route::get('/events/volunteers/{id}', [EventVolunteerController::class, 'show'])->name('events.volunteers.show');
    Route::delete('/events/volunteers/{id}', [EventVolunteerController::class, 'remove'])->name('events.volunteers.remove');
    
    // Event Report Routes
    Route::get('/events/reports', [EventReportControllerAlias::class, 'index'])->name('events.reports');
    Route::get('/events/reports/{id}', [EventReportControllerAlias::class, 'show'])->name('events.reports.show');
    Route::get('/events/reports/{id}/pdf', [EventReportControllerAlias::class, 'pdf'])->name('events.reports.pdf');
    
    // Group Schedule Routes
    Route::get('/groups/schedule', [GroupScheduleController::class, 'index'])->name('groups.schedule');
    Route::get('/groups/schedule/create', [GroupScheduleController::class, 'create'])->name('groups.schedule.create');
    Route::post('/groups/schedule', [GroupScheduleController::class, 'store'])->name('groups.schedule.store');
    
    // Outreach Routes
    Route::get('/outreach', [OutreachController::class, 'index'])->name('outreach.index');
    Route::get('/outreach/create', [OutreachController::class, 'create'])->name('outreach.create');
    Route::post('/outreach', [OutreachController::class, 'store'])->name('outreach.store');
    Route::get('/outreach/{id}', [OutreachController::class, 'show'])->name('outreach.show');
    Route::get('/outreach/{id}/edit', [OutreachController::class, 'edit'])->name('outreach.edit');
    Route::put('/outreach/{id}', [OutreachController::class, 'update'])->name('outreach.update');
    Route::delete('/outreach/{id}', [OutreachController::class, 'destroy'])->name('outreach.destroy');
    
    // Volunteer Management Routes
    Route::get('/volunteers', [VolunteerController::class, 'index'])->name('volunteers.index');
    Route::get('/volunteers/create', [VolunteerController::class, 'create'])->name('volunteers.create');
    Route::post('/volunteers', [VolunteerController::class, 'store'])->name('volunteers.store');
    Route::get('/volunteers/{id}', [VolunteerController::class, 'show'])->name('volunteers.show');
    Route::get('/volunteers/{id}/edit', [VolunteerController::class, 'edit'])->name('volunteers.edit');
    Route::put('/volunteers/{id}', [VolunteerController::class, 'update'])->name('volunteers.update');
    Route::delete('/volunteers/{id}', [VolunteerController::class, 'destroy'])->name('volunteers.destroy');
    
    // Contribution Routes
    Route::get('/contributions/make', [ContributionController::class, 'make'])->name('contributions.make');
    Route::post('/contributions/process', [ContributionController::class, 'process'])->name('contributions.process');
    Route::get('/contributions/history', [ContributionController::class, 'history'])->name('contributions.history');
    
    // Profile Routes
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    
    // Directory Routes
    Route::get('/parishioners/directory', [ParishionerController::class, 'directory'])->name('parishioners.directory');
    
    // Event Registration Routes
    Route::get('/events/register', [EventRegistrationController::class, 'register'])->name('events.register');
    Route::post('/events/register', [EventRegistrationController::class, 'registerStore'])->name('events.register.store');
    
    // Group Join Routes
    Route::get('/groups/join', [GroupController::class, 'join'])->name('groups.join');
    Route::post('/groups/join', [GroupController::class, 'joinStore'])->name('groups.join.store');
    
    // Certificate Routes
    Route::get('/certificates/my', [CertificateController::class, 'myCertificates'])->name('certificates.my');
    
    });
    
    // Assets Routes
    Route::resource('assets', AssetController::class);
    
    // Parishioners Routes
    // Specific routes must come before parameterized routes
    Route::get('/parishioners', [ParishionerController::class, 'index'])->name('parishioners.index');
    Route::get('/parishioners/create', [ParishionerController::class, 'create'])->name('parishioners.create');
    Route::get('/parishioners/import', [ParishionerController::class, 'import'])->name('parishioners.import');
    Route::post('/parishioners/import', [ParishionerController::class, 'importStore'])->name('parishioners.import.store');
    Route::get('/parishioners/member-types', [ParishionerController::class, 'memberTypes'])->name('parishioners.member-types');
    Route::get('/parishioners/manage', [ParishionerController::class, 'manage'])->name('parishioners.manage');
    Route::post('/parishioners/export', [ParishionerController::class, 'export'])->name('parishioners.export');
    Route::post('/parishioners/bulk-activate', [ParishionerController::class, 'bulkActivate'])->name('parishioners.bulk-activate');
    Route::post('/parishioners/bulk-deactivate', [ParishionerController::class, 'bulkDeactivate'])->name('parishioners.bulk-deactivate');
    
    // Parameterized routes (must come after specific routes)
    Route::post('/parishioners', [ParishionerController::class, 'store'])->name('parishioners.store');
    Route::get('/parishioners/{id}', [ParishionerController::class, 'show'])->name('parishioners.show');
    Route::get('/parishioners/{id}/edit', [ParishionerController::class, 'edit'])->name('parishioners.edit');
    Route::put('/parishioners/{id}', [ParishionerController::class, 'update'])->name('parishioners.update');
    Route::delete('/parishioners/{id}', [ParishionerController::class, 'destroy'])->name('parishioners.destroy');
    
    // Communities Routes
    Route::resource('communities', CommunityController::class);
    
    // Locations Routes - Using closures to bypass Laravel's controller resolution
    // Specific routes must come before parameterized routes
    Route::get('/locations', function() {
        try {
            $controller = new \App\Http\Controllers\LocationController();
            return $controller->index(request());
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    })->name('locations.index');
    
    Route::get('/locations/create', function() {
        try {
            $controller = new \App\Http\Controllers\LocationController();
            return $controller->create();
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    })->name('locations.create');
    
    Route::post('/locations', function() {
        try {
            $controller = new \App\Http\Controllers\LocationController();
            return $controller->store(request());
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    })->name('locations.store');
    
    Route::post('/locations/import', function() {
        try {
            $controller = new \App\Http\Controllers\LocationController();
            return $controller->import(request());
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    })->name('locations.import');
    
    Route::post('/locations/export', function() {
        try {
            $controller = new \App\Http\Controllers\LocationController();
            return $controller->export();
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    })->name('locations.export');
    
    // API Routes for Location Browser
    Route::get('/api/locations/regions', function() {
        try {
            $regions = \App\Models\Location::select('region', 'region_code')
                ->distinct('region_code')
                ->groupBy('region', 'region_code')
                ->get()
                ->map(function($region) {
                    $region->name = $region->region;
                    $region->count = \App\Models\Location::where('region_code', $region->region_code)->count();
                    return $region;
                });
            return response()->json($regions);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    });
    
    Route::get('/api/locations/districts/{regionCode}', function($regionCode) {
        try {
            $districts = \App\Models\Location::where('region_code', $regionCode)
                ->select('district', 'district_code')
                ->distinct('district_code')
                ->groupBy('district', 'district_code')
                ->get()
                ->map(function($district) {
                    $district->name = $district->district;
                    $district->count = \App\Models\Location::where('district_code', $district->district_code)->count();
                    return $district;
                });
            return response()->json($districts);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    });
    
    Route::get('/api/locations/wards/{districtCode}', function($districtCode) {
        try {
            $wards = \App\Models\Location::where('district_code', $districtCode)
                ->select('ward', 'ward_code')
                ->distinct('ward_code')
                ->groupBy('ward', 'ward_code')
                ->get()
                ->map(function($ward) {
                    $ward->name = $ward->ward;
                    $ward->count = \App\Models\Location::where('ward_code', $ward->ward_code)->count();
                    return $ward;
                });
            return response()->json($wards);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    });
    
    Route::get('/api/locations/streets/{wardCode}', function($wardCode) {
        try {
            $streets = \App\Models\Location::where('ward_code', $wardCode)
                ->whereNotNull('street')
                ->where('street', '!=', '')
                ->select('street')
                ->distinct('street')
                ->get()
                ->map(function($street) {
                    $street->name = $street->street;
                    $street->count = \App\Models\Location::where('street', $street->street)->count();
                    return $street;
                });
            return response()->json($streets);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    });
    
    Route::get('/api/locations/places/{streetName}', function($streetName) {
        try {
            $places = \App\Models\Location::where('street', $streetName)
                ->whereNotNull('place')
                ->where('place', '!=', '')
                ->select('place', 'region', 'district', 'ward', 'street', 'is_active')
                ->distinct('place')
                ->get()
                ->map(function($place) {
                    $place->name = $place->place;
                    return $place;
                });
            return response()->json($places);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    });
    
    Route::get('/api/locations/search', function(\Illuminate\Http\Request $request) {
        try {
            $query = $request->get('q');
            if (strlen($query) < 2) {
                return response()->json([]);
            }
            
            $results = \App\Models\Location::where(function($q) use ($query) {
                    $q->where('region', 'like', "%{$query}%")
                      ->orWhere('district', 'like', "%{$query}%")
                      ->orWhere('ward', 'like', "%{$query}%")
                      ->orWhere('street', 'like', "%{$query}%")
                      ->orWhere('place', 'like', "%{$query}%");
                })
                ->select('region', 'region_code', 'district', 'district_code', 'ward', 'ward_code', 'street', 'place', 'is_active')
                ->limit(50)
                ->get()
                ->map(function($result) {
                    $result->name = $result->place ?: $result->street ?: $result->ward ?: $result->district ?: $result->region;
                    return $result;
                });
                
            return response()->json($results);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    });
    
    // Parameterized routes (must come after specific routes)
    Route::get('/locations/{location}', function($location) {
        try {
            $controller = new \App\Http\Controllers\LocationController();
            // Find the location model manually
            $locationModel = \App\Models\Location::findOrFail($location);
            return $controller->show($locationModel);
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    })->name('locations.show');
    
    Route::get('/locations/{location}/edit', function($location) {
        try {
            $controller = new \App\Http\Controllers\LocationController();
            // Find the location model manually
            $locationModel = \App\Models\Location::findOrFail($location);
            return $controller->edit($locationModel);
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    })->name('locations.edit');
    
    Route::put('/locations/{location}', function($location) {
        try {
            $controller = new \App\Http\Controllers\LocationController();
            // Find the location model manually
            $locationModel = \App\Models\Location::findOrFail($location);
            return $controller->update(request(), $locationModel);
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    })->name('locations.update');
    
    Route::delete('/locations/{location}', function($location) {
        try {
            $controller = new \App\Http\Controllers\LocationController();
            // Find the location model manually
            $locationModel = \App\Models\Location::findOrFail($location);
            return $controller->destroy($locationModel);
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    })->name('locations.destroy');
    
    // Apostolic Groups Routes
    Route::resource('apostolic-groups', ApostolicGroupController::class);
    
    // Events Routes
    Route::get('/events/calendar', [EventController::class, 'calendar'])->name('events.calendar');
    Route::get('/events/calendar/feed', [EventController::class, 'calendarFeed'])->name('events.calendar.feed');
    Route::post('/events/calendar/update-dates', [EventController::class, 'calendarUpdateDates'])->name('events.calendar.update-dates');
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
        Route::get('/system/backup', [SystemSettingsController::class, 'backupIndex'])->name('system.backup.index');
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
        Route::get('/financial-years/{id}/edit', [FinancialYearController::class, 'edit'])->name('financial-years.edit');
        Route::put('/financial-years/{id}', [FinancialYearController::class, 'update'])->name('financial-years.update');
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
    
    // Certificate Routes
    Route::prefix('certificates')->name('certificates.')->group(function () {
        Route::get('/log', [CertificateController::class, 'index'])->name('log');
        Route::get('/finalist/create', [CertificateController::class, 'showFinalistForm'])->name('finalist.create');
        Route::post('/finalist', [CertificateController::class, 'generateFinalist'])->name('finalist.store');
        Route::get('/group/create', [CertificateController::class, 'showGroupForm'])->name('group.create');
        Route::post('/group', [CertificateController::class, 'generateGroup'])->name('group.store');
        Route::get('/templates', [CertificateController::class, 'templates'])->name('templates');
        Route::get('/verify', [CertificateController::class, 'showVerificationForm'])->name('verify.form');
        Route::post('/verify', [CertificateController::class, 'verify'])->name('verify');
        Route::get('/my-certificates', [CertificateController::class, 'myCertificates'])->name('my');
        Route::get('/pending', [CertificateController::class, 'pendingApproval'])->name('pending');
        Route::get('/revoked', [CertificateController::class, 'revokedCertificates'])->name('revoked');
        Route::get('/bulk-download', [CertificateController::class, 'bulkDownload'])->name('bulk-download');
        Route::get('/settings', [CertificateController::class, 'settings'])->name('settings');
        Route::post('/settings', [CertificateController::class, 'updateSettings'])->name('settings.update');
        Route::get('/{certificate}/preview', [CertificateController::class, 'preview'])->name('preview');
        Route::post('/{certificate}/revoke', [CertificateController::class, 'revoke'])->name('revoke');
        Route::get('/{certificate}', [CertificateController::class, 'show'])->name('show');
        Route::get('/{certificate}/download', [CertificateController::class, 'download'])->name('download');
    });
    
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Redirect root to dashboard
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

// Public certificate verification (no auth required)
Route::get('/verify-certificate', [CertificateController::class, 'showVerificationForm'])->name('public.verify.form');
Route::post('/verify-certificate', [CertificateController::class, 'verify'])->name('public.verify');
