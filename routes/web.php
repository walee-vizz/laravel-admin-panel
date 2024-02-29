<?php

use App\Models\User;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard\Crm;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CalbackController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\dashboard\Analytics;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\language\LanguageController;
use App\Http\Controllers\laravel_example\UserManagement;
use App\Http\Controllers\settings\UserSettingController;

// Main Page Route
Route::get('/dashboard/analytics', [Analytics::class, 'index'])->name('dashboard-analytics');
Route::get('/dashboard/crm', [Crm::class, 'index'])->name('dashboard-crm');
// locale
Route::get('lang/{locale}', [LanguageController::class, 'swap']);


// Frontend Routes
Route::controller(FrontendController::class)->prefix('')->name()->group(function () {
  Route::get('/', 'index')->name('home');
  Route::get('/home-page', 'index')->name('landing');
  Route::get('/pricing', 'pricing')->name('pricing');
  Route::get('/payment', 'payment')->name('payment');
  Route::get('/checkout', 'checkout')->name('checkout');
  Route::get('/help-center', 'help_center')->name('help-center');
  Route::get('/help-center-article', 'help_center_article')->name('help-center-article');
});
// End Frontend Routes


// Authentication
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::controller(AuthController::class)->prefix('auth')->name('auth.')->middleware(RedirectIfAuthenticated::class)->group(function () {

  Route::get('/login-basic', 'login_basic')->name('login_basic');
  Route::get('/login', 'login_cover')->name('login');
  Route::post('/login', 'login');
  Route::get('/register-basic', 'register_basic')->name('register_basic');
  Route::get('/register-cover', 'register_cover')->name('register_cover');
  Route::get('/register-multisteps', 'register_multisteps')->name('register_multisteps');
  Route::get('/verify-email-basic', 'verify_email_basic')->name('verify_email_basic');
  Route::get('/verify-email-cover', 'verify_email_cover')->name('verify_email_cover');
  Route::get('/reset-password-basic', 'reset_password_basic')->name('reset_password_basic');
  Route::get('/reset-password-cover', 'reset_password_cover')->name('reset_password_cover');
  Route::get('/forgot-password-basic', 'forgot_password_basic')->name('reset_password_basic');
  Route::get('/forgot-password-cover', 'forgot_password_cover')->name('forgot_password_cover');
  Route::get('/two-steps-basic', 'two-steps_basic')->name('two_steps_basic');
  Route::get('/two-steps-cover', 'two_steps_cover')->name('two_steps_cover');
});
// End authentication

// Authenticated only Routes
Route::middleware(Authenticate::class)->group(function () {

  // Dashboard
  Route::controller(DashboardController::class)->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', 'index')->name('dashboard');
    Route::get('/faq', 'faq')->name('faq');
    Route::get('/pricing', 'pricing')->name('pricing');
  });
  // End Dashboard

  // User Routes
  Route::controller(UserController::class)->prefix('user')->name('user.')->group(function () {

    Route::get('/list', 'list_view')->name('list');
    Route::get('/', 'show')->name('profile.show');
    Route::get('/account', 'account')->name('view-account');
    Route::get('/teams', 'teams')->name('teams');
    Route::get('/projects', 'projects')->name('projects');
    Route::get('/connections', 'connections')->name('connections');
    Route::get('assign', function () {
      $user = User::find(7);
      $user->assignRole('user');
      dd($user->roles()->first());
    });
  });
  Route::resource('/users', UserController::class);
  // End User Routes

  // User Settings Routes
  Route::controller(UserSettingController::class)->prefix('user/settings')->name('user.settings.')->group(function () {
    Route::get('/account', 'account_settings')->name('account');
  });
  // End user Settings Routes


  // Roles & Permissions Routes
  Route::controller(RoleController::class)->prefix('role')->name('role.')->group(function () {
    Route::post('/', 'roles_list')->name('list');
    Route::get('/list', 'index')->name('list');
    Route::post('/create', 'store')->name('create');
    Route::PUT('/update/{role}', 'update')->name('update');
    Route::delete('/delete/{role}', 'destroy')->name('destroy');
  });
  Route::controller(PermissionController::class)->prefix('permission')->name('permission.')->group(function () {
    Route::get('/list', 'index')->name('list');
  });
  // End Roles & Permissions Routes
});

// end



// laravel example
Route::get('/laravel/user-management', [UserManagement::class, 'UserManagement'])->name('users.laravel');
// Route::resource('/user-list', UserManagement::class);


// Call Back Pages Routes
Route::controller(CalbackController::class)->prefix('callback')->name('callback.')->group(function () {

  Route::get('/404', 'page_not_found')->name('404');
  Route::get('/under-maintenance', 'under_maintenance')->name('under_maintenance');
  Route::get('/comingsoon', 'coming_soon')->name('coming_soon');
  Route::get('/401', 'un_authorized')->name('401');
});
// End Call back routes
