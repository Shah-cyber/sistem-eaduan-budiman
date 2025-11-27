<?php

use App\Models\User;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AuditTrailController;
use App\Http\Controllers\Admin\Access\RoleController;
use App\Http\Controllers\Admin\Users\AdminUserController;
use App\Http\Controllers\Public\PublicComplaintController;
use App\Http\Controllers\Admin\Access\PermissionController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\Complaints\ComplaintController;
use App\Http\Controllers\Admin\ComplaintTypes\ComplaintTypeController;
use App\Http\Controllers\Admin\Panel\DashboardController as PanelDashboardController;
use App\Http\Controllers\Admin\Panel\AuditTrailController as PanelAuditTrailController;
use App\Http\Controllers\Admin\Websites\BizHubController;
use App\Http\Controllers\Admin\Websites\AktivitiController;
use App\Http\Controllers\Admin\Websites\FasilitiController;
use App\Http\Controllers\Admin\Websites\AhliJawatanKuasaController as AJKController;
use App\Http\Controllers\Admin\Websites\AnnouncementController as AnnouncementController;

// Landing page - show login page, redirect authenticated users to dashboard
Route::get('/', function () {
    // If user is authenticated, redirect to appropriate dashboard
    if (Auth::check()) {
        /** @var User|null $user */
        $user = Auth::user();
        
        if ($user && method_exists($user, 'hasRole')) {
            if ($user->hasRole('Super Admin')) {
                return redirect()->route('admin.dashboard');
            }
            if ($user->hasRole('Admin')) {
                return redirect()->route('admin.panel.dashboard');
            }
        }
        
        // Fallback for authenticated users without admin roles
        return redirect()->route('dashboard');
    }
    
    // Show login page for guests
    return app(AuthenticatedSessionController::class)->create();
});

Route::get('/dashboard', function () {
    $user = request()->user();

    // Redirect admins to their proper dashboards
    if ($user && method_exists($user, 'hasRole')) {
        if ($user->hasRole('Super Admin')) {
            return redirect()->route('admin.dashboard');
        }
        if ($user->hasRole('Admin')) {
            return redirect()->route('admin.panel.dashboard');
        }
    }
    
    // Fallback for non-admin users (if any)
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Super Admin dashboard & management
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:Super Admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Manage Admin Users
    Route::resource('admins', AdminUserController::class)->except(['show']);
    Route::get('admins/{admin}/permissions', [AdminUserController::class, 'editPermissions'])->name('admins.permissions.edit');
    Route::put('admins/{admin}/permissions', [AdminUserController::class, 'updatePermissions'])->name('admins.permissions.update');

    // Roles & Permissions
    Route::resource('roles', RoleController::class)->except(['show']);
    Route::get('roles/{role}/permissions', [RoleController::class, 'editPermissions'])->name('roles.permissions.edit');
    Route::put('roles/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('roles.permissions.update');

    Route::resource('permissions', PermissionController::class)->except(['show']);

    // Complaint Types Management
    Route::resource('complaint-types', ComplaintTypeController::class)->except(['show']);

    // Complaints Management
    Route::resource('complaints', ComplaintController::class);

    // Audit Trails
    Route::get('audit-trails', [AuditTrailController::class, 'index'])->name('audit-trails.index');

    // Websites Management (Project B Integration)
    Route::prefix('websites')->name('websites.')->group(function () {
        Route::resource('bizhub', BizHubController::class)->names('bizhub');
        Route::resource('aktiviti', AktivitiController::class)->names('aktiviti');
        Route::resource('fasiliti', FasilitiController::class)->names('fasiliti');
        Route::resource('ahli-jawatan-kuasa', AJKController::class)->names('ajk');
        Route::resource('pengumuman', AnnouncementController::class)->names('pengumuman');
    });
});

// Normal Admin dashboard (limited panel)
Route::prefix('admin/panel')->name('admin.panel.')->middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/', [PanelDashboardController::class, 'index'])->name('dashboard');

    // Complaint Types Management (Admin can also manage)
    Route::resource('complaint-types', ComplaintTypeController::class)->except(['show']);

    // Complaints Management (Admin can also manage)
    Route::resource('complaints', ComplaintController::class);

    // Audit Trails
    Route::get('audit-trails', [PanelAuditTrailController::class, 'index'])->name('audit-trails.index');

    Route::prefix('websites')->name('websites.')->group(function () {
        Route::resource('bizhub', BizHubController::class)->names('bizhub');
        Route::resource('aktiviti', AktivitiController::class)->names('aktiviti');
        Route::resource('fasiliti', FasilitiController::class)->names('fasiliti');
        Route::resource('ahli-jawatan-kuasa', AJKController::class)->names('ajk');
        Route::resource('pengumuman', AnnouncementController::class)->names('pengumuman');
    });
});

// WORK IN PROGRESS!!!!!!!
// DO NOT TOUCH THIS UNLESS THE PERMISSION IS WORKING FOR _PENGUMUMAN_
Route::resource('pengumuman', AnnouncementController::class)->names('asdasd');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Public/User Routes (No authentication required)
Route::get('/user', function () {
    return view('public.mukadepan');
})->name('public.home');

Route::get('/user/tambah-aduan', [PublicComplaintController::class, 'create'])->name('public.complaint.create');
Route::post('/user/tambah-aduan', [PublicComplaintController::class, 'store'])
    ->middleware('throttle:5,1') // Max 5 submissions per minute per IP
    ->name('public.complaint.store');

Route::get('/user/semak-status', [PublicComplaintController::class, 'checkStatus'])->name('public.status.check');
Route::get('/user/list-aduan', [PublicComplaintController::class, 'list'])->name('public.complaints.list');
Route::get('/user/status-aduan/{complaint}', [PublicComplaintController::class, 'show'])->name('public.complaint.show');




require __DIR__ . '/auth.php';
require __DIR__ . '/admin_auth.php';
