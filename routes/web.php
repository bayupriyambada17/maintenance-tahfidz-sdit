<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\rolesController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\usersController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\HarianController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\TahsinHarianController;
use App\Http\Controllers\UjianMingguanController;
use App\Http\Controllers\UjianTahfidzController;
use App\Http\Controllers\UjianTahsinController;

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

Route::get('/', [authController::class, 'index'])->name('login')->middleware('guest');
// Route::get('/register', [authController::class, 'register'])->middleware('guest');
// Route::post('/register-proses', [authController::class, 'registerProses'])->middleware('guest');
Route::post('/login-proses', [authController::class, 'loginProses'])->middleware('guest');
Route::post('/logout', [authController::class, 'logout'])->middleware('auth');

Route::get('/dashboard', [dashboardController::class, 'index'])->middleware('auth');

Route::get('/users', [usersController::class, 'index'])->middleware('role:admin');
Route::get('/users/tambah-user', [usersController::class, 'tambahUsers'])->middleware('role:admin');
Route::post('/users/import', [usersController::class, 'import'])->middleware('role:admin');
Route::post('/users/tambah-user-proses', [usersController::class, 'tambahUserProses'])->middleware('role:admin');
Route::get('/users/detail/{id}', [usersController::class, 'detail'])->middleware('role:admin');
Route::put('/users/proses-edit/{id}', [usersController::class, 'editUserProses'])->middleware('role:admin');
Route::delete('/users/delete/{id}', [usersController::class, 'deleteUser'])->middleware('role:admin');
Route::get('/users/edit-password/{id}', [usersController::class, 'editPassword'])->middleware('role:admin');
Route::put('/users/edit-password-proses/{id}', [usersController::class, 'editPasswordProses'])->middleware('role:admin');

Route::resource('/roles', rolesController::class)->middleware('role:admin')->except('show');

Route::get('/my-profile', [usersController::class, 'myProfile'])->middleware('auth');
Route::put('/my-profile/update/{id}', [usersController::class, 'myProfileUpdate'])->middleware('auth');
Route::get('/my-profile/edit-password', [usersController::class, 'myProfileEditPassword'])->middleware('auth');
Route::put('/my-profile/update-password/{id}', [usersController::class, 'myProfileUpdatePassword'])->middleware('auth');

Route::get('/kelas', [KelasController::class, 'index'])->middleware('role:admin');
Route::get('/kelas/tambah', [KelasController::class, 'tambah'])->middleware('role:admin');
Route::post('/kelas/insert', [KelasController::class, 'insert'])->middleware('role:admin');
Route::get('/kelas/edit/{id}', [KelasController::class, 'edit'])->middleware('role:admin');
Route::put('/kelas/update/{id}', [KelasController::class, 'update'])->middleware('role:admin');
Route::delete('/kelas/delete/{id}', [KelasController::class, 'delete'])->middleware('role:admin');

Route::get('/siswa', [SiswaController::class, 'index'])->middleware('auth');
Route::get('/siswa/tambah', [SiswaController::class, 'tambah'])->middleware('auth');
Route::post('/siswa/import', [SiswaController::class, 'import'])->middleware('auth');
Route::post('/siswa/insert', [SiswaController::class, 'insert'])->middleware('auth');
Route::get('/siswa/edit/{id}', [SiswaController::class, 'edit'])->middleware('auth');
Route::put('/siswa/update/{id}', [SiswaController::class, 'update'])->middleware('auth');
Route::delete('/siswa/delete/{id}', [SiswaController::class, 'delete'])->middleware('auth');
Route::get('/siswa/target/{id}', [SiswaController::class, 'target'])->middleware('auth');
Route::post('/siswa/target/insert/{id}', [SiswaController::class, 'insertTarget'])->middleware('auth');
Route::get('/siswa/target/edit/{target_id}/{siswa_id}', [SiswaController::class, 'editTarget'])->middleware('auth');
Route::put('/siswa/target/update/{target_id}/{siswa_id}', [SiswaController::class, 'updateTarget'])->middleware('auth');
Route::delete('/siswa/target/delete/{target_id}/{siswa_id}', [SiswaController::class, 'deleteTarget'])->middleware('auth');

Route::get('/surat', [SuratController::class, 'index'])->middleware('role:admin');
Route::get('/surat/tambah', [SuratController::class, 'tambah'])->middleware('role:admin');
Route::post('/surat/insert', [SuratController::class, 'insert'])->middleware('role:admin');
Route::get('/surat/edit/{id}', [SuratController::class, 'edit'])->middleware('role:admin');
Route::put('/surat/update/{id}', [SuratController::class, 'update'])->middleware('role:admin');
Route::delete('/surat/delete/{id}', [SuratController::class, 'delete'])->middleware('role:admin');
Route::post('/surat/import', [SuratController::class, 'import'])->middleware('role:admin');

Route::get('/pencatatan-harian', [HarianController::class, 'index'])->middleware('auth');
Route::get('/pencatatan-harian/tambah', [HarianController::class, 'tambah'])->middleware('auth');
Route::post('/pencatatan-harian/insert', [HarianController::class, 'insert'])->middleware('auth');
Route::get('/pencatatan-harian/edit/{id}', [HarianController::class, 'edit'])->middleware('auth');
Route::put('/pencatatan-harian/update/{id}', [HarianController::class, 'update'])->middleware('auth');
Route::delete('/pencatatan-harian/delete/{id}', [HarianController::class, 'delete'])->middleware('auth');
Route::get('/pencatatan-harian/export', [HarianController::class, 'export'])->middleware('auth');
Route::get('/pencatatan-harian/getDataTarget', [HarianController::class, 'getDataTarget'])->middleware('auth');
Route::get('/pencatatan-harian/getTargetName', [HarianController::class, 'getTargetName'])->middleware('auth');
Route::get('/pencatatan-harian/getDataSurat', [HarianController::class, 'getDataSurat'])->middleware('auth');

Route::get('/ujian-tahfidz', [UjianTahfidzController::class, 'index'])->middleware('auth');
Route::get('/ujian-tahfidz/tambah', [UjianTahfidzController::class, 'tambah'])->middleware('auth');
Route::post('/ujian-tahfidz/insert', [UjianTahfidzController::class, 'insert'])->middleware('auth');
Route::get('/ujian-tahfidz/edit/{id}', [UjianTahfidzController::class, 'edit'])->middleware('auth');
Route::put('/ujian-tahfidz/update/{id}', [UjianTahfidzController::class, 'update'])->middleware('auth');
Route::delete('/ujian-tahfidz/delete/{id}', [UjianTahfidzController::class, 'delete'])->middleware('auth');
Route::get('/ujian-tahfidz/export', [UjianTahfidzController::class, 'export'])->middleware('auth');

Route::get('/tahsin-harian', [TahsinHarianController::class, 'index'])->middleware('auth');
Route::get('/tahsin-harian/tambah', [TahsinHarianController::class, 'tambah'])->middleware('auth');
Route::post('/tahsin-harian/insert', [TahsinHarianController::class, 'insert'])->middleware('auth');
Route::get('/tahsin-harian/edit/{id}', [TahsinHarianController::class, 'edit'])->middleware('auth');
Route::put('/tahsin-harian/update/{id}', [TahsinHarianController::class, 'update'])->middleware('auth');
Route::delete('/tahsin-harian/delete/{id}', [TahsinHarianController::class, 'delete'])->middleware('auth');
Route::get('/tahsin-harian/export', [TahsinHarianController::class, 'export'])->middleware('auth');

Route::get('/ujian-tahsin', [UjianTahsinController::class, 'index'])->middleware('auth');
Route::get('/ujian-tahsin/tambah', [UjianTahsinController::class, 'tambah'])->middleware('auth');
Route::post('/ujian-tahsin/insert', [UjianTahsinController::class, 'insert'])->middleware('auth');
Route::get('/ujian-tahsin/edit/{id}', [UjianTahsinController::class, 'edit'])->middleware('auth');
Route::put('/ujian-tahsin/update/{id}', [UjianTahsinController::class, 'update'])->middleware('auth');
Route::delete('/ujian-tahsin/delete/{id}', [UjianTahsinController::class, 'delete'])->middleware('auth');
Route::get('/ujian-tahsin/export', [UjianTahsinController::class, 'export'])->middleware('auth');


// terbaru
Route::resource('guru', GuruController::class)->middleware('role:admin');
Route::get('/guru/edit-password/{id}', [GuruController::class, 'showPassword'])->name('guru.edit-password')->middleware('role:admin');
Route::put('/guru/edit-password/{id}', [GuruController::class, 'changePassword'])->name('guru.change-password')->middleware('role:admin');
Route::post('/guru/import-teacher', [GuruController::class, 'importTeacher'])->name('guru.import-teacher')->middleware('role:admin');
