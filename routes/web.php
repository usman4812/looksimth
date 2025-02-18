<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PlansContoller;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\MealsController;
use App\Http\Controllers\Admin\PagesController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\WorkerController;
use App\Http\Controllers\Admin\AppUserController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\GiftCardController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\MealsTypeController;
use App\Http\Controllers\Admin\MenuOrdersController;
use App\Http\Controllers\Admin\TransactionsController;


// Route::get('/', function () {
//     return view('welcome');
// });

//***********************/
//Admin Routes
//*********************/

// Route::group(['prefix' => 'admin'], function () {

Route::any('login', [AdminAuthController::class, 'admin_login'])->name('admin.login')->middleware('laravelguest');

Route::group(['middleware' => 'laravelauth:superadmin'], function () {

    Route::get('logout', [AdminAuthController::class, 'logout'])->name("admin.logout");

    Route::controller(AdminController::class)->group(function () {
        Route::get('/', 'dashboard')->name('admin.dashboard');
    });


    Route::prefix('settings')->controller(SettingsController::class)->group(function () {
        Route::group(['middleware' => ['permission:manage settings']], function () {
            Route::match(['get', 'post'], 'general', 'setting')->name('admin.settings');
        });

    });
    // Start New Routes
    Route::prefix('category')->controller(CategoryController::class)->group(function () {
        Route::group(['middleware' => ['permission:manage categories']], function () {
            Route::match(['get', 'post'], '/', 'category_list')->name('category');
        });
        Route::group(['middleware' => ['permission:create categories']], function () {
            Route::match(['get', 'post'], 'add', 'add_category')->name('category.add');
        });
        Route::group(['middleware' => ['permission:edit categories']], function () {
            Route::match(['get', 'post'], 'edit/{id}', 'edit_category')->name('category.edit');
        });
        Route::group(['middleware' => ['permission:delete categories']], function () {
            Route::post('delete/{id}', 'delete_category')->name('category.delete');
        });
    });
    Route::prefix('service')->controller(ServiceController::class)->group(function () {
        Route::group(['middleware' => ['permission:manage services']], function () {
            Route::match(['get', 'post'], '/', 'service_list')->name('service');
        });
        Route::group(['middleware' => ['permission:create services']], function () {
            Route::match(['get', 'post'], 'add', 'add_service')->name('service.add');
        });
        Route::group(['middleware' => ['permission:edit services']], function () {
            Route::match(['get', 'post'], 'edit/{id}', 'edit_service')->name('service.edit');
        });
        Route::group(['middleware' => ['permission:delete services']], function () {
            Route::post('delete/{id}', 'delete_service')->name('service.delete');
        });
    });
    Route::prefix('worker')->controller(WorkerController::class)->group(function () {
        Route::group(['middleware' => ['permission:manage workers']], function () {
            Route::match(['get', 'post'], '/', 'worker_list')->name('worker');
        });
        Route::group(['middleware' => ['permission:create workers']], function () {
            Route::match(['get', 'post'], 'add', 'add_worker')->name('worker.add');
        });
        Route::group(['middleware' => ['permission:edit workers']], function () {
            Route::match(['get', 'post'], 'edit/{id}', 'edit_worker')->name('worker.edit');
        });
        Route::group(['middleware' => ['permission:delete workers']], function () {
            Route::post('delete/{id}', 'delete_worker')->name('worker.delete');
        });
    });
    // Banner Routes
    Route::prefix('banner')->controller(BannerController::class)->group(function () {
        Route::group(['middleware' => ['permission:manage banners']], function () {
            Route::match(['get', 'post'], '/', 'banner_list')->name('banner');
        });
        Route::group(['middleware' => ['permission:create banners']], function () {
            Route::match(['get', 'post'], 'add', 'add_banner')->name('banner.add');
        });
        Route::group(['middleware' => ['permission:edit banners']], function () {
            Route::match(['get', 'post'], 'edit/{id}', 'edit_banner')->name('banner.edit');
        });
        Route::group(['middleware' => ['permission:delete banners']], function () {
            Route::post('delete/{id}', 'delete_banner')->name('banner.delete');
        });
    });
    Route::prefix('app-user')->controller(AppUserController::class)->group(function () {
        Route::group(['middleware' => ['permission:manage users']], function () {
            Route::match(['get', 'post'], '/', 'app_user_list')->name('app.user');
        });
    });
    Route::prefix('booking')->controller(BookingController::class)->group(function () {
        Route::group(['middleware' => ['permission:manage bookings']], function () {
            Route::match(['get', 'post'], '/', 'booking_list')->name('booking');
        });
        Route::group(['middleware' => ['permission:create bookings']], function () {
            Route::match(['get', 'post'], 'add', 'add_booking')->name('booking.add');
        });
        Route::group(['middleware' => ['permission:edit bookings']], function () {
            Route::match(['get', 'post'], 'edit/{id}', 'edit_booking')->name('booking.edit');
        });
        Route::group(['middleware' => ['permission:delete bookings']], function () {
            Route::post('delete/{id}', 'delete_booking')->name('booking.delete');
        });
    });

    // End New Route
    Route::prefix('users')->controller(UserController::class)->group(function () {
        Route::group(['middleware' => ['permission:manage users']], function () {
            Route::match(['get', 'post'], '/', 'user_list')->name('admin.users');
        });
        Route::group(['middleware' => ['permission:create users']], function () {
            Route::match(['get', 'post'], 'add', 'add_user')->name('admin.user.add');
        });
        Route::group(['middleware' => ['permission:edit users']], function () {
            Route::match(['get', 'post'], 'edit/{uuid}', 'edit_user')->name('admin.user.edit');
        });
        Route::group(['middleware' => ['permission:delete users']], function () {
            Route::get('delete/{uuid}', 'delete_user')->name('admin.user.delete');
        });
    });
    Route::prefix('roles')->controller(UserController::class)->group(function () {
        Route::group(['middleware' => ['permission:manage roles']], function () {
            Route::get('/', 'all_roles')->name('admin.roles');
        });
        Route::group(['middleware' => ['permission:create roles']], function () {
            Route::post('add', 'add_admin_role')->name('admins.roles.add');
        });
        Route::group(['middleware' => ['permission:edit roles']], function () {
            Route::post('update/{id}', 'update_admin_role')->name('admins.roles.edit');
        });
        Route::group(['middleware' => ['permission:delete roles']], function () {
            Route::delete('delete/{id}', 'delete_admin_role')->name('admins.roles.delete');
        });
        // Route::any('edit/{id}', 'edit_user')->name('admin.user.edit');

    });




    Route::prefix('drivers')->controller(UserController::class)->group(function () {
        Route::group(['middleware' => ['permission:manage drivers']], function () {
            Route::match(['get', 'post'], '/', 'driver_number')->name('admin.driver_number');
        });
    });
    Route::prefix('plans')->controller(PlansContoller::class)->group(function () {
        Route::group(['middleware' => ['permission:manage plans']], function () {
            Route::match(['get', 'post'], '/', 'plans_list')->name('admin.plans');
        });
        Route::group(['middleware' => ['permission:create plans']], function () {
            Route::match(['get', 'post'], 'add', 'add_plan')->name('admin.plans.add');
        });
        Route::group(['middleware' => ['permission:edit plans']], function () {
            Route::match(['get', 'post'], 'edit/{uuid}', 'edit_plan')->name('admin.plans.edit');
        });
        Route::group(['middleware' => ['permission:delete plans']], function () {
            Route::delete('delete/{uuid}', 'delete_plan')->name('admin.plans.delete');
        });
    });
    Route::prefix('meals')->controller(MealsController::class)->group(function () {
        Route::group(['middleware' => ['permission:manage meals']], function () {
            Route::match(['get', 'post'], '/', 'meals_list')->name('admin.meals');
        });
        Route::group(['middleware' => ['permission:create meals']], function () {
            Route::match(['get', 'post'], 'add', 'add_meals')->name('admin.meals.add');
            Route::post('add-media', 'add_media')->name('admin.meals.media.add');
        });
        Route::group(['middleware' => ['permission:edit meals']], function () {
            Route::match(['get', 'post'], 'edit/{uuid}', 'edit_meals')->name('admin.meals.edit');
        });
        Route::group(['middleware' => ['permission:delete meals']], function () {
            Route::delete('delete/{uuid}', 'delete_meals')->name('admin.meals.delete');
            Route::post('delete-file', 'delete_meal_file')->name('admin.meals.file.delete');
        });
        Route::group(['middleware' => ['permission:edit settings']], function () {
            // Ajax Return meal type model view
            Route::get('/get-add-meal-type-modal', 'get_add_meal_type_model')->name('get.add.meal.type.modal');
            Route::get('/get-meal-types', 'get_meal_types')->name('admin.settings.get.meal.types');
            // Ajax Return Ingredient modal view
            Route::get('/get-ingredient-modal', 'get_ingredient_model')->name('get.ingredient.modal');
            Route::get('/get-ingredients', 'get_ingredients')->name('get.ingredients');
            // Ajax Return Diet modal view
            Route::get('/get-diet-modal', 'get_diet_model')->name('get.diet.modal');
            Route::get('/get-diets', 'get_diets')->name('get.diets');
            // Ajax Return Nutrition modal view
            Route::get('/get-meal-size-modal', 'get_meal_size_model')->name('get.meal.size.modal');
            Route::get('/get-meal-size', 'get_meal_size')->name('get.meal.size');
            // Ajax Return Vendor modal view
            Route::get('/get-vendor-modal', 'get_vendor_modal')->name('get.vendor.modal');
            Route::get('/get-vendors', 'get_vendors')->name('get.vendors');
        });
    });
});
// });
