<?php

use App\Http\Controllers\AdminProfileUpdateController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminRegisterController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserProductController;
use App\Http\Controllers\ApiGeneratorFormController;
use App\Http\Controllers\UserApiGeneratorFormController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LicenseActivationController;
use App\Http\Controllers\LicenseController;
use App\Http\Controllers\UserLicenseController;
use App\Http\Controllers\ProfileUpdateController;
use App\Http\Controllers\UserRegisterAndLoginController;
use App\Http\Controllers\ValidateLicenseController;
use App\Http\Controllers\RedeemCodeController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\AdminPlanManagement;

Route::get('/demo', function () {
    return view('users.demo');
});

Route::get('/admin/export-licenses', [DashboardController::class, 'exportLicenses'])->name('admin.export.licenses');
Route::get('/user/export-licenses', [DashboardController::class, 'exportUserLicenses'])->name('user.export.licenses');


Route::get('/lost-password', [AuthController::class, 'showLostPasswordForm'])->name('password.lost');
Route::post('/send-reset-password', [AuthController::class, 'sendResetPassword'])->name('sendResetPassword');
Route::get('/reset-password', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('password/update/{user_id}', [AuthController::class, 'update'])->name('password.update');

Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/user/dashboard', [DashboardController::class, 'userdash'])->name('userdashboard');




Route::post('/admin/login', [AdminRegisterController::class, 'login'])->name('admin.login');
Route::get('/admin/login', function(){
    return view('admin.login');
})->name('admin.login');
Route::post('/logout', [AdminRegisterController::class, 'destroy'])->name('logout');

Route::get('/register-login', [UserRegisterAndLoginController::class, 'showForm'])->name('register.login');
Route::post('/register', [UserRegisterAndLoginController::class, 'register'])->name('user.register');
Route::post('/login', [UserRegisterAndLoginController::class, 'login'])->name('user.login');
Route::post('/user/logout', [UserRegisterAndLoginController::class, 'destroy'])->name('user.destroy');
Route::get('/', [UserRegisterAndLoginController::class, 'showForm'])->name('user');

// Protect routes with 'auth' middleware
Route::middleware('auth')->group(function () {


    Route::get('/admin/plan-management', [AdminPlanManagement::class, 'index'])->name('admin.plans');
    Route::get('/admin/create/plan-management', [AdminPlanManagement::class, 'create'])->name('admin.create.plans');

    Route::get('/product', [ProductController::class, 'index'])->name('admin.product-show');

    Route::get('user/product', [UserProductController::class, 'userindex'])->name('product-show');
    Route::get('/product-create', function(){
        return view('admin.product.create');
    })->name('products');
    Route::post('/product-create', [ProductController::class, 'store'])->name('products.store');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    
    Route::get('/user-product', [UserProductController::class, 'userindex'])->name('user-product-show');
    Route::get('/user-product-create', function(){
        return view('users.product.create');
    })->name('userproducts');
    Route::post('/user-product-create', [UserProductController::class, 'store'])->name('user.products.store');
    Route::delete('/user-products/{id}', [UserProductController::class, 'destroy'])->name('user.products.destroy');

    // FOr Admin
    Route::get('/licenses', [LicenseController::class, 'index'])->name('licenses.index');
    Route::get('/licenses/create', [LicenseController::class, 'showForm'])->name('licenses.create');
    Route::post('/licenses/generate', [LicenseController::class, 'generateLicenses'])->name('licenses.generate');
    Route::post('/licenses/save', [LicenseController::class, 'saveLicenses'])->name('licenses.save');
    Route::get('/admin/licenses/{id}/edit', [LicenseController::class, 'edit'])->name('admin.licenses.edit');
    Route::put('/admin/licenses/{id}', [LicenseController::class, 'update'])->name('admin.licenses.update');
    Route::delete('/licenses/{id}', [LicenseController::class, 'destroy'])->name('licenses.destroy');
    Route::get('/api-generate-form', [ApiGeneratorFormController::class,'index'])->name('apigenerate');
    Route::get('/generate-api-script', [ApiGeneratorFormController::class, 'generateApiScript'])->name('generate.api.script');

    // For users
    Route::get('/user/licenses', [UserLicenseController::class, 'index'])->name('user.licenses.index');
    Route::get('/user/licenses/create', [UserLicenseController::class, 'showForm'])->name('user.licenses.create');
    Route::post('/user/licenses/generate', [UserLicenseController::class, 'generateLicenses'])->name('user.licenses.generate');
    Route::post('/user/licenses/save', [UserLicenseController::class, 'saveLicenses'])->name('user.licenses.save');
    Route::get('/user/licenses/{id}/edit', [UserLicenseController::class, 'edit'])->name('user.licenses.edit');
    Route::put('/user/licenses/{id}', [UserLicenseController::class, 'update'])->name('user.licenses.update');
    Route::delete('/user/licenses/{id}', [UserLicenseController::class, 'destroy'])->name('user.licenses.destroy');
    Route::get('/user/api-generate-form', [UserApiGeneratorFormController::class,'index'])->name('user.apigenerate');
    Route::get('/user/generate-api-script', [UserApiGeneratorFormController::class, 'generateApiScript'])->name('user.generate.api.script');

    // Redeem codes
    Route::get('/redeem-codes', [RedeemCodeController::class, 'index'])->name('redeemcode');
    Route::get('/redeemcode-create', function(){
        return view('admin.redeemcodes.create');
    })->name('redeemcreate');
    Route::post('/redeem-codes/save', [RedeemCodeController::class, 'save'])->name('redeem_codes.save');


    // Redeem Users
    Route::get('/admin/users/management', [UserManagementController::class, 'redeemindex'])->name('user.management');
    Route::post('/admin/user/register', [UserManagementController::class, 'register'])->name('admin.register');
    Route::get('/admin/user/create', function(){
        return view('admin.usermanage.create');
    })->name('admin.user.register');
    Route::delete('/admin/user/{id}', [UserManagementController::class, 'destroy'])->name('admin.user.destroy');
    Route::put('/admin/user/manage/edit/{id}', [UserManagementController::class, 'updateUser'])->name('admin.usermanage.update');
    Route::get('/admin/user/manage/edit/{id}', [UserManagementController::class, 'editUser'])->name('admin.usermanage.edit');

    
    
    
});


Route::get('/licenses/activations', [LicenseActivationController::class, 'userdash'])->name('license.activations');
Route::get('/license-validate', [ValidateLicenseController::class, 'showForm'])->name('licenses.validate');
Route::get('/licenses/validate', [ValidateLicenseController::class, 'showForm'])->name('licenses.validate');
Route::post('/licenses/validate', [ValidateLicenseController::class, 'validateLicense'])->name('licenses.validate.submit');
Route::post('/deactivate-license', [ValidateLicenseController::class, 'deactivate'])->name('deactivate.license');
Route::post('/activate-license', [ValidateLicenseController::class, 'activate'])->name('activate.license');

// Profile Update Controller
Route::get('/profile/edit', [ProfileUpdateController::class, 'index'])->name('profile.edit');
Route::put('/profile/update', [ProfileUpdateController::class, 'update'])->name('profile.update');

Route::get('/admin/profile/edit', [AdminProfileUpdateController::class, 'index'])->name('admin.profile.edit');
Route::put('/admin/profile/update', [AdminProfileUpdateController::class, 'update'])->name('admin.profile.update');


