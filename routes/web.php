<?php

use App\Http\Controllers\AumController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PendidikanFormalController;
use App\Http\Controllers\PendidikanNonFormalController;
use App\Http\Controllers\RiwayatPekerjaanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [UserController::class, 'userLoginView'])->middleware('guestcheck');
Route::post('/', [UserController::class, 'handleUserLogin'])->middleware('guestcheck');

Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [UserController::class, 'logoutUser']);

    Route::middleware(['user.role'])->group(function () {
        Route::get('/profile-verification', [HomeController::class, 'beforeHomeView'])->middleware('user.profile.verification');
        Route::post('/profile-verification', [HomeController::class, 'handleBeforeHome'])->middleware('user.profile.verification');

        Route::middleware(['user.profile.done'])->group(function () {
            Route::get('/home', [HomeController::class, 'homeView']);

            Route::get('/home/ganti-password', [HomeController::class, 'GantiPasswordView']);
            Route::post('/home/ganti-password', [HomeController::class, 'handleGantiPassword']);

            Route::get('/home/edit-profile-pegawai', [HomeController::class, 'editProfilePegawaiView']);
            Route::post('/home/edit-profile-pegawai', [HomeController::class, 'handleEditProfilePegawai']);

            Route::post('/home/tugas-tambahan', [HomeController::class, 'addTugasTambahan']);
            Route::post('/home/tugas-mapel', [HomeController::class, 'addTugasMapel']);
            Route::get('/home/tugas-tambahan/delete/{idTugasTambahan}', [HomeController::class, 'deleteTugasTambahan']);
            Route::get('/home/tugas-mapel/delete/{idTugasMapel}', [HomeController::class, 'deleteTugasMapel']);

            Route::get('/home/riwayat-pendidikan-formal', [PendidikanFormalController::class, 'listRiwayatPendidikanFormalView']);
            Route::get('/home/riwayat-pendidikan-formal/edit/{idPendidikanFormal}', [PendidikanFormalController::class, 'editRiwayatPendidikanFormalView']);
            Route::post('/home/riwayat-pendidikan-formal/edit/{idPendidikanFormal}', [PendidikanFormalController::class, 'handleEditRiwayatPendidikanFormal']);
            Route::get('/home/riwayat-pendidikan-formal/delete/{idPendidikanFormal}', [PendidikanFormalController::class, 'deleteRiwayatPendidikanFormal']);
            Route::get('/home/add-riwayat-pendidikan-formal', [PendidikanFormalController::class, 'addRiwayatPendidikanFormalView']);
            Route::post('/home/add-riwayat-pendidikan-formal', [PendidikanFormalController::class, 'handleAddRiwayatPendidikanFormal']);

            Route::get('/home/riwayat-pendidikan-non-formal', [PendidikanNonFormalController::class, 'listRiwayatPendidikanNonFormalView']);
            Route::get('/home/riwayat-pendidikan-non-formal/edit/{idPendidikanNonFormal}', [PendidikanNonFormalController::class, 'editRiwayatPendidikanNonFormalView']);
            Route::post('/home/riwayat-pendidikan-non-formal/edit/{idPendidikanNonFormal}', [PendidikanNonFormalController::class, 'handleEditRiwayatPendidikanNonFormal']);
            Route::get('/home/riwayat-pendidikan-non-formal/delete/{idPendidikanNonFormal}', [PendidikanNonFormalController::class, 'deleteRiwayatPendidikanNonFormal']);
            Route::get('/home/add-riwayat-pendidikan-non-formal', [PendidikanNonFormalController::class, 'addRiwayatPendidikanNonFormalView']);
            Route::post('/home/add-riwayat-pendidikan-non-formal', [PendidikanNonFormalController::class, 'handleAddRiwayatPendidikanNonFormal']);

            Route::get('/home/riwayat-pekerjaan', [RiwayatPekerjaanController::class, 'listRiwayatPekerjaanView']);
            Route::get('/home/riwayat-pekerjaan/edit/{idRiwayatPekerjaan}', [RiwayatPekerjaanController::class, 'editRiwayatPekerjaanView']);
            Route::post('/home/riwayat-pekerjaan/edit/{idRiwayatPekerjaan}', [RiwayatPekerjaanController::class, 'handleEditRiwayatPekerjaan']);
            Route::get('/home/riwayat-pekerjaan/delete/{idRiwayatPekerjaan}', [RiwayatPekerjaanController::class, 'deleteRiwayatPekerjaan']);
            Route::get('/home/add-riwayat-pekerjaan', [RiwayatPekerjaanController::class, 'addRiwayatPekerjaanView']);
            Route::post('/home/add-riwayat-pekerjaan', [RiwayatPekerjaanController::class, 'handleAddRiwayatPekerjaan']);
        });
    });

    Route::middleware(['admin.role'])->group(function () {
        Route::get('/dashboard', [UserController::class, 'listUser']);

        Route::get('/dashboard/daftar-pegawai-non-aktif', [UserController::class, 'listUserNonAktif']);

        Route::get('/dashboard/user/detail/{idUser}', [UserController::class, 'detailUser'])->name('detailUserRoute');

        Route::get('/dashboard/user/edit/{idUser}', [UserController::class, 'editUser']);
        Route::post('/dashboard/user/edit/{idUser}', [UserController::class, 'handleEditUser']);

        Route::get('/dashboard/user/aktifkan/{idUser}', [UserController::class, 'aktifkanUser']);

        Route::get('/dashboard/user/detail/{idUser}/add-tugas-pokok', [UserController::class, 'addTugasPokok']);
        Route::post('/dashboard/user/detail/{idUser}/add-tugas-pokok', [UserController::class, 'handleAddTugasPokok']);
        Route::get('/dashboard/user/detail/{idUser}/selesaikan-tugas-pokok/{idTugasPokok}', [UserController::class, 'selesaikanTugasPokok']);
        Route::get('/dashboard/user/detail/{idUser}/edit-tugas-pokok/{idTugasPokok}', [UserController::class, 'editTugasPokokView']);
        Route::post('/dashboard/user/detail/{idUser}/edit-tugas-pokok/{idTugasPokok}', [UserController::class, 'handleEditTugasPokok']);

        Route::post('/dashboard/user/detail/{idUser}/add-tugas-tambahan', [UserController::class, 'addTugasTambahan']);
        Route::post('/dashboard/user/detail/{idUser}/add-tugas-mapel', [UserController::class, 'addTugasMapel']);
        Route::get('/dashboard/user/detail/{idUser}/delete-tugas-tambahan/{idTugasTambahan}', [UserController::class, 'deleteTugasTambahan']);
        Route::get('/dashboard/user/detail/{idUser}/delete-tugas-mapel/{idTugasMapel}', [UserController::class, 'deleteTugasMapel']);

        Route::get('/dashboard/tambah-pegawai', [UserController::class, 'addPegawaiView']);
        Route::post('/dashboard/tambah-pegawai', [UserController::class, 'handleAddPegawai']);

        Route::get('/dashboard/daftar-admin', [UserController::class, 'listAdmin']);
        Route::get('/dashboard/daftar-admin/edit/{idUser}', [UserController::class, 'editAdminAumView']);
        Route::post('/dashboard/daftar-admin/edit/{idUser}', [UserController::class, 'handleEditAdminAum']);
        Route::get('/dashboard/daftar-admin/delete/{idUser}', [UserController::class, 'deleteAdminAum']);
        Route::get('/dashboard/daftar-admin/tambah-admin', [UserController::class, 'addAdminView']);
        Route::post('/dashboard/daftar-admin/tambah-admin', [UserController::class, 'handleAddAdmin']);

        Route::get('/dashboard/daftar-aum', [AumController::class, 'listAumController']);
        Route::post('/dashboard/daftar-aum', [AumController::class, 'addAum']);
        Route::get('/dashboard/daftar-aum/ganti-status/{idAum}', [AumController::class, 'gantiStatus']);
        Route::post('/dashboard/daftar-aum/edit-aum', [AumController::class, 'editAum']);

        Route::get('/dashboard/jumlah-pegawai', [UserController::class, 'jumlahPegawaiView']);

        Route::get('/dashboard/export-data', [UserController::class, 'exportDataView']);
        Route::post('/dashboard/export-data', [UserController::class, 'handleExportDataView']);
    });
});
