<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\VacanciesController;
use App\Http\Controllers\ApplicationsController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [AuthenticatedSessionController::class, 'create'])
    ->name('login');

//Route::get('/', function () {
//    route('login');
//});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    ////Добавление Компание
    Route::post('/add/companies', [CompaniesController::class, 'addCompanies'])->name('add.companies');
    Route::post('/change/companies', [CompaniesController::class, 'changeCompanies'])->name('change.companies');

    ////Добавление Вакансии
    Route::get('/index/vacancies', [VacanciesController::class, 'index'])->name('view.vacancies');
    Route::post('/add/vacancies', [VacanciesController::class, 'addVacancies'])->name('add.vacancies');
    Route::post('/get/edit/vacancies', [VacanciesController::class, 'getEditVacancies'])->name('get.edit.vacancies');
    Route::post('/edit/vacancies', [VacanciesController::class, 'editVacancies'])->name('edit.vacancies');

    ////Изменение Удаление Вакансии
    Route::post('/edit/vacancies', [VacanciesController::class, 'editDeleteVacancies'])->name('edit.vacancies');
    //// Заявка
    Route::get('/index/applications/', [ApplicationsController::class, 'index'])->name('view.applications');
    //// Показать Модельное окно чата ОТЛИКОВ
    Route::post('/show/user/chat/', [ApplicationsController::class, 'showUserChat'])->name('show.user.chat');
    Route::post('/send/user/chat/', [ApplicationsController::class, 'sendUserChat'])->name('send.user.chat');
    Route::post('/application/role/status/',[ApplicationsController::class,'applicationRole'])->name('application.role');
});

require __DIR__.'/auth.php';
