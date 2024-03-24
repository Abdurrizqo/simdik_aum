<?php

namespace App\Http\Controllers;

use App\Models\Aum;
use App\Models\PendidikanFormal;
use App\Models\PendidikanNonFormal;
use App\Models\Profile;
use App\Models\RiwayatPekerjaan;
use App\Models\TugasMapel;
use App\Models\TugasPokok;
use App\Models\TugasTambahan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Rap2hpoutre\FastExcel\FastExcel;
use Rap2hpoutre\FastExcel\SheetCollection;

class UserController extends Controller
{
    public function userLoginView()
    {
        return view('login');
    }

    public function handleUserLogin(Request $request)
    {
        $validate = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        if (Auth::attempt($validate)) {
            $user = Auth::user();

            if (!$user->isActive) {
                Auth::logout();
                return back()->withErrors([
                    'username' => 'Pegawai telah dinonaktifkan.'
                ])->withInput($request->only('username'));
            }

            $request->session()->regenerate();

            if ($user->role === 'admin' || $user->role === 'adminAum') {
                return redirect()->intended('dashboard');
            } elseif ($user->role === 'user') {
                if ($user->isProfileDone) {
                    return redirect()->intended('home');
                } else {
                    return redirect()->intended('profile-verification');
                }
            }
        }

        return back()->withErrors([
            'username' => 'Username atau Password salah.'
        ])->withInput($request->only('username'));
    }


    public function logoutUser(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function listUser(Request $request)
    {
        $user = Auth::user();
        $aum = Aum::get();

        $search = $request->query('search');
        $status = $request->query('status');
        $idAum = $request->query('idAum');
        $filterVerifProfile = $request->query('filterVerifProfile');

        $query = User::select(['users.idUser', 'users.idAum', 'nickname', 'username', 'isProfileDone', 'role', 'status', 'idTugasPokok', 'idProfile', 'namaAum'])
            ->where('role', 'user')
            ->where('isActive', 1)
            ->leftJoin('aum', 'users.idAum', '=', 'aum.idAum')
            ->orderBy('nickname', 'asc');

        if ($user->role === 'admin') {
            if ($idAum === null && $status === null && $filterVerifProfile === null && $search === null) {
                $listUser = $query->paginate(10);
            } else {
                $idAum ? $query->where('users.idAum', $idAum) : null;
                $status ? $query->where('status', $status) : null;

                if ($filterVerifProfile) {
                    $filterVerifProfile === 'true' ? $query->where('isProfileDone', true) : $query->where('isProfileDone', false);
                }

                $listUser = $query->paginate(10)
                    ->withQueryString();
            }
        } else {
            if ($idAum && $status && $filterVerifProfile && $search) {
                $listUser = $query->paginate(10);
            } else {
                if ($filterVerifProfile) {
                    $filterVerifProfile === 'true' ? $query->where('isProfileDone', true) : $query->where('isProfileDone', false);
                }

                $status ? $query->where('status', $status) : null;

                $search ? $query->where(function ($query) use ($search) {
                    $query->where('username', 'like', "%$search%")
                        ->orWhere('nickname', 'like', "%$search%");
                }) : null;

                $listUser = $query->where('users.idAum', $user->idAum)->paginate(10)
                    ->withQueryString();
            }
        }

        return view('User/listUser', ['user' => $listUser, 'aum' => $aum]);
    }

    public function listUserNonAktif(Request $request)
    {
        $user = Auth::user();
        $aum = Aum::get();

        $search = $request->query('search');
        $status = $request->query('status');
        $idAum = $request->query('idAum');
        $filterVerifProfile = $request->query('filterVerifProfile');

        $query = User::select(['users.idUser', 'users.idAum', 'nickname', 'username', 'isProfileDone', 'role', 'status', 'idTugasPokok', 'idProfile', 'namaAum'])
            ->where('role', 'user')
            ->where('isActive', 0)
            ->leftJoin('aum', 'users.idAum', '=', 'aum.idAum')
            ->orderBy('nickname', 'asc');

        if ($user->role === 'admin') {
            if ($idAum === null && $status === null && $filterVerifProfile === null && $search === null) {
                $listUser = $query->paginate(10);
            } else {
                $idAum ? $query->where('users.idAum', $idAum) : null;
                $status ? $query->where('status', $status) : null;

                if ($filterVerifProfile) {
                    $filterVerifProfile === 'true' ? $query->where('isProfileDone', true) : $query->where('isProfileDone', false);
                }

                $listUser = $query->paginate(10)
                    ->withQueryString();
            }
        } else {
            if ($idAum && $status && $filterVerifProfile && $search) {
                $listUser = $query->paginate(10);
            } else {
                if ($filterVerifProfile) {
                    $filterVerifProfile === 'true' ? $query->where('isProfileDone', true) : $query->where('isProfileDone', false);
                }

                $status ? $query->where('status', $status) : null;

                $search ? $query->where(function ($query) use ($search) {
                    $query->where('username', 'like', "%$search%")
                        ->orWhere('nickname', 'like', "%$search%");
                }) : null;

                $listUser = $query->where('users.idAum', $user->idAum)->paginate(10)
                    ->withQueryString();
            }
        }

        return view('User/listUserNonAktif', ['user' => $listUser, 'aum' => $aum]);
    }

    public function listAdmin(Request $request)
    {
        $search = $request->query('search');

        if (empty($search)) {
            $listAdmin = User::select(['users.idUser', 'nickname', 'username', 'namaAum'])
                ->where('role', 'adminaum')
                ->leftJoin('aum', 'users.idAum', '=', 'aum.idAum')
                ->paginate(10)
                ->orderBy('nickname', 'asc');
        } else {
            $listAdmin = User::select(['users.idUser', 'nickname', 'username', 'namaAum'])
                ->where('role', 'adminaum')
                ->where(function ($query) use ($search) {
                    $query->where('username', 'like', "%$search%")
                        ->orWhere('nickname', 'like', "%$search%");
                })
                ->leftJoin('aum', 'users.idAum', '=', 'aum.idAum')
                ->paginate(10)
                ->withQueryString();
        }

        return view('User/listAdmin', ['admin' => $listAdmin]);
    }

    public function addPegawaiView()
    {
        $aum = Aum::get();
        return view('User/tambahPegawai', ['aum' => $aum]);
    }

    public function handleAddPegawai(Request $request)
    {
        $validate = $request->validate(
            [
                'nickname' => 'required|string|min:4|unique:users,nickname',
                'username' => 'required|string|min:4|unique:users,username',
                'password' => 'required|string|min:6',
                'status' => 'required|in:Pegawai Tetap Yayasan,Guru Tetap Yayasan,Pegawai Kontrak Yayasan,Guru Kontrak Yayasan,Guru Honor Sekolah,Tenaga Honor Sekolah,Guru Tamu',
                'idAum' => 'required|string|exists:aum,idAum',
            ]
        );

        $aum = Aum::select('izinTambahPegawai')->where('idAum', $validate['idAum'])->first();

        if ($aum->izinTambahPegawai) {
            $user = User::create([
                'nickname' => $validate['nickname'],
                'username' => $validate['username'],
                'password' => Hash::make($validate['password']),
                'idAum' => $validate['idAum'],
                'role' => 'user'
            ]);

            if (isset($user)) {
                return redirect()->to('/dashboard')->with('success', 'Tambah Pegawai Berhasil');
            }
            return redirect()->back()->withInput()->with('error', 'Tambah Admin Gagal');
        }

        return redirect()->back()->with('error', 'Jumlah Pegawai Telah Dibatasi, Silahkan Hubungi Admin');
    }

    public function addAdminView()
    {
        $aum = Aum::get();
        return view('User/tambahAdmin', ['aum' => $aum]);
    }

    public function handleAddAdmin(Request $request)
    {
        $validate = $request->validate(
            [
                'nickname' => 'required|string|min:4|unique:users,nickname',
                'username' => 'required|string|min:4|unique:users,username',
                'password' => 'required|string|min:6',
                'idAum' => 'required|string|exists:aum,idAum',
            ]
        );

        $user = User::create([
            'nickname' => $validate['nickname'],
            'username' => $validate['username'],
            'password' => Hash::make($validate['password']),
            'idAum' => $validate['idAum'],
            'role' => 'adminaum'
        ]);

        if (isset($user)) {
            return redirect()->to('/dashboard/daftar-admin')->with('success', 'Tambah Admin Berhasil');
        }
        return redirect()->back()->withInput()->with('error', 'Tambah Pegawai Gagal');
    }

    public function editUser($idUser)
    {
        $aum = Aum::get();
        $user = User::select(['idUser', 'nickname', 'username', 'status', 'idAum', 'isActive'])->where('idUser', $idUser)->where('role', 'user')->first();

        if (!$user) {
            return abort(404);
        }
        return view('User/editPegawai', ['aum' => $aum, 'user' => $user]);
    }

    public function handleEditUser($idUser, Request $request)
    {
        $validate = $request->validate(
            [
                'nickname' => 'required|string|min:4|unique:users,nickname,' . $idUser . ',idUser',
                'username' => 'required|string|min:4|unique:users,username,' . $idUser . ',idUser',
                'password' => 'string|min:6|nullable',
                'status' => 'required|in:Pegawai Tetap Yayasan,Guru Tetap Yayasan,Pegawai Kontrak Yayasan,Guru Kontrak Yayasan,Guru Honor Sekolah,Tenaga Honor Sekolah,Guru Tamu',
                'idAum' => 'required|string|exists:aum,idAum',
                'isActive' => 'required|string|in:true,false',
            ]
        );

        DB::beginTransaction();
        try {
            $aum = Aum::select('izinTambahPegawai')->where('idAum', $validate['idAum'])->first();
            $user = User::where('idUser', $idUser)->first();

            if (!$aum->izinTambahPegawai) {
                return redirect()->back()->with('error', 'Jumlah Pegawai Telah Dibatasi, Silahkan Hubungi Admin');
            }

            if (!$user) {
                return redirect()->to('/dashboard')->with('error', 'Edit Data Pegawai Gagal, ID User Tidak Valid');
            }

            $validate['isActive'] = $validate['isActive'] === 'true' ? true : false;

            if (isset($validate['password'])) {
                $user->update([
                    'nickname' => $validate['nickname'],
                    'username' => $validate['username'],
                    'password' => Hash::make($validate['password']),
                    'status' => $validate['status'],
                    'idAum' => $validate['idAum'],
                    'isActive' => $validate['isActive']
                ]);
            } else {
                $user->update([
                    'nickname' => $validate['nickname'],
                    'username' => $validate['username'],
                    'status' => $validate['status'],
                    'isActive' => $validate['isActive'],
                    'idAum' => $validate['idAum']
                ]);
            }

            Profile::where('idUser', $idUser)->update(['idAum' => $validate['idAum']]);

            DB::commit();
            return redirect()->to('/dashboard')->with('success', 'Edit Data Pegawai Berhasil');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Edit Data Pegawai Gagal');
        }
    }

    public function AktifkanUser($idUser)
    {
        $user = User::where('idUser', $idUser)->update(['isActive' => true]);
        if ($user) {
            return redirect()->back()->with('success', 'User Berhasil Diaktifkan');
        }
        return redirect()->back()->with('error', 'User Gagal Diaktifkan');
    }

    public function editAdminAumView($idUser)
    {
        $aum = Aum::get();
        $user = User::select(['idUser', 'nickname', 'username', 'idAum'])->where('idUser', $idUser)->where('role', 'adminaum')->first();
        if (!$user) {
            return abort(404);
        }
        return view('User/editAdmin', ['aum' => $aum, 'user' => $user]);
    }

    public function handleEditAdminAum($idUser, Request $request)
    {
        $validate = $request->validate([
            'nickname' => 'required|string|min:4|unique:users,nickname,' . $idUser . ',idUser',
            'username' => 'required|string|min:4|unique:users,username,' . $idUser . ',idUser',
            'password' => 'nullable|string|min:6',
            'idAum' => 'required|string|exists:aum,idAum',
        ]);

        $user = User::where('idUser', $idUser)->where('role', 'adminaum')->first();

        if ($user) {
            try {
                if (isset($validate['password'])) {
                    $validate['password'] = Hash::make($validate['password']);
                } else {
                    unset($validate['password']);
                }

                $user->update($validate);

                return redirect()->to('/dashboard/daftar-admin')->with('success', 'Edit Data Admin AUM Berhasil');
            } catch (\Throwable $th) {
                return redirect()->back()->withInput()->with('error', 'Edit Data Admin AUM Gagal');
            }
        } else {
            return redirect()->to('/dashboard/daftar-admin')->with('error', 'Edit Data Admin AUM Gagal, Kesalahan ID');
        }
    }

    public function deleteAdminAum($idUser)
    {
        $user = User::where('idUser', $idUser)->where('role', 'adminaum')->delete();

        if ($user) {
            return redirect()->back()->with('success', 'Admin AUM Berhasil Dihapus');
        }
        return redirect()->back()->with('success', 'Admin AUM Gagal Dihapus');
    }

    public function detailUser($idUser)
    {
        $user = User::where('idUser', $idUser)->first();

        if (!$user) {
            return abort(404);
        }

        $profile = Profile::select(['profile.idProfile', 'namaLengkap', 'noKTAM', 'tempatLahir', 'tanggalLahir', 'isMarried', 'nipy', 'alamat', 'fotoProfile', 'namaAum', 'totalMasaKerja'])
            ->where('idUser', $idUser)
            ->leftJoin('aum', 'profile.idAum', '=', 'aum.idAum')
            ->first();

        $tugasMapel = TugasMapel::where('idUser', $idUser)->get();
        $tugasTambahan = TugasTambahan::where('idUser', $idUser)->get();
        $tugasPokok = TugasPokok::where('idUser', $idUser)->first();
        $usia = 0;

        if (isset($profile)) {
            if (isset($tugasPokok)) {
                $tanggalSKMulai = Carbon::parse($tugasPokok['tanggalSK']);
                $tanggalSekarang = Carbon::now();
                $totalBulan = $tanggalSKMulai->diffInMonths($tanggalSekarang);
                $profile['totalMasaKerja'] += $totalBulan;
            }

            $tahun = floor($profile['totalMasaKerja'] / 12);
            $sisaBulan = $profile['totalMasaKerja'] % 12;
            $hasil = '';

            if ($tahun > 0) {
                $hasil .= $tahun . ' tahun';
                if ($sisaBulan > 0) {
                    $hasil .= ' ';
                }
            }

            if ($sisaBulan > 0) {
                $hasil .= $sisaBulan . ' bulan';
            }

            if ($tahun == 0 && $sisaBulan == 0) {
                $hasil = '0 bulan';
            }

            $profile['totalMasaKerja'] = $hasil;

            $usia = Carbon::createFromFormat('Y-m-d', $profile['tanggalLahir'])->age;
        }



        $listRiwayatPendidikanFormal = PendidikanFormal::where('idUser', $idUser)->get();
        $listRiwayatPendidikanNonFormal = PendidikanNonFormal::where('idUser', $idUser)->get();
        $listRiwayatPekerjaan = RiwayatPekerjaan::where('idUser', $idUser)->get();

        return view(
            'User/detailUser',
            [
                'profile' => $profile,
                'usia' => $usia,
                'tugasPokok' => $tugasPokok,
                'tugasMapel' => $tugasMapel,
                'tugasTambahan' => $tugasTambahan,
                'listRiwayatPendidikanFormal' => $listRiwayatPendidikanFormal,
                'listRiwayatPendidikanNonFormal' => $listRiwayatPendidikanNonFormal,
                'listRiwayatPekerjaan' => $listRiwayatPekerjaan,
                'idUser' => $idUser
            ]
        );
    }

    public function addTugasTambahan(Request $request, $idUser)
    {
        $validate = $request->validate(
            [
                'tugasTambahan' => 'required|string|min:2'
            ]
        );

        $tugasTambahan = TugasTambahan::create(
            [
                'tugasTambahan' => $validate['tugasTambahan'],
                'idUser' => $idUser
            ]
        );

        if (isset($tugasTambahan)) {
            return redirect()->back()->with('success', 'Tambah Tugas Tambahan Berhasil');
        }
        return redirect()->back()->withInput()->with('error', 'Tambah Tugas Tambahan Gagal');
    }

    public function addTugasMapel(Request $request, $idUser)
    {
        $validate = $request->validate(
            [
                'mapelDiampu' => 'required|string|min:2',
                'totalJamSeminggu' => 'required|integer'
            ]
        );

        $tugasTambahan = TugasMapel::create(
            [
                'mapelDiampu' => $validate['mapelDiampu'],
                'totalJamSeminggu' => $validate['totalJamSeminggu'],
                'idUser' => $idUser
            ]
        );

        if (isset($tugasTambahan)) {
            return redirect()->back()->with('success', 'Tambah Tugas Mapel Berhasil');
        }
        return redirect()->back()->withInput()->with('error', 'Tambah Tugas Mapel Gagal');
    }

    public function deleteTugasTambahan($idUser, $idTugasTambahan)
    {
        $tugas = TugasTambahan::where('idTugasTambahan', $idTugasTambahan)->where('idUser', $idUser)->delete();

        if ($tugas) {
            return redirect()->back()->with('success', 'Hapus Tugas Tambahan Berhasil');
        }
        return redirect()->back()->with('error', 'Hapus Tugas Tambahan Gagal');
    }

    public function deleteTugasMapel($idUser, $idTugasMapel)
    {
        $tugas = TugasMapel::where('idTugasMapel', $idTugasMapel)->where('idUser', $idUser)->delete();

        if ($tugas) {
            return redirect()->back()->with('success', 'Hapus Tugas Mapel Berhasil');
        }
        return redirect()->back()->with('error', 'Hapus Tugas Mapel Gagal');
    }

    public function addTugasPokok($idUser)
    {
        $dataUser = User::select('nickname')->where('idUser', $idUser)->first();
        return view('User/tambahTugasPokok', ['dataUser' => $dataUser]);
    }

    public function handleAddTugasPokok($idUser, Request $request)
    {
        $validate = $request->validate([
            'tugasPokok' => 'required|string|min:4',
            'namaAUm' => 'required|string|min:4',
            'nomerAum' => 'string|min:2|required',
            'namaPenandatangan' => 'string|min:2|required',
            'jabatanPenandatangan' => 'string|min:2|required',
            'nomerSK' => 'string|min:2|required',
            'tanggalSK' => 'required|date',
            'buktisk' => 'required|file|mimes:pdf|max:3000'
        ]);

        $tugasPokok = TugasPokok::create(array_merge($validate, ['idUser' => $idUser]));

        if ($tugasPokok) {
            return redirect()->route('detailUserRoute', ['idUser' => $idUser])->with('success', 'Tambah Tugas Pokok Berhasil');
        }
        return redirect()->back()->with('error', 'Tambah Tugas Pokok Gagal');
    }

    public function selesaikanTugasPokok($idUser, $idTugasPokok)
    {
        DB::beginTransaction();

        try {
            $tugasPokok = TugasPokok::where('idTugasPokok', $idTugasPokok)->where('idUser', $idUser)->first();

            $tanggalSKMulai = Carbon::parse($tugasPokok['tanggalSK']);
            $tanggalSekarang = Carbon::now();

            $totalBulan = $tanggalSKMulai->diffInMonths($tanggalSekarang);

            RiwayatPekerjaan::create(
                [
                    'namaAum' => $tugasPokok['namaAUm'],
                    'nomerAum' => $tugasPokok['nomerAum'],
                    'namaPenandatangan' => $tugasPokok['namaPenandatangan'],
                    'jabatanPenandaTangan' => $tugasPokok['jabatanPenandatangan'],
                    'nomerSK' => $tugasPokok['nomerSK'],
                    'tanggalSK' => $tugasPokok['tanggalSK'],
                    'masaKerjaDalamBulan' => $totalBulan,
                    'buktiSK' => $tugasPokok['buktisk'],
                    'idUser' => $idUser
                ]
            );

            Profile::where('idUser', $idUser)->increment('totalMasaKerja', $totalBulan);
            $tugasPokok->delete();

            DB::commit();

            return redirect()->route('detailUserRoute', ['idUser' => $idUser])->with('success', 'Tugas Pokok Berhasil Diselesaikan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Tugas Pokok Gagal Diselesaikan');
        }
    }

    public function jumlahPegawaiView()
    {
        $totalSeluruhPegawai = User::where('role', 'user')->count();
        $totalSeluruhPegawaiAktif = User::where('role', 'user')->where('isActive', true)->count();
        $totalSeluruhPegawaiNonAktif = User::where('role', 'user')->where('isActive', false)->count();

        $totalPegawaiPerAUM = User::selectRaw("COUNT(*) as total_user,
        SUM(CASE WHEN users.isActive = 1 THEN 1 ELSE 0 END) as total_user_active,
        SUM(CASE WHEN users.isActive = 0 THEN 1 ELSE 0 END) as total_user_inactive,

        SUM(CASE WHEN users.status = 'Pegawai Tetap Yayasan' THEN 1 ELSE 0 END) as total_pegawai_tetap_yayasan,
        SUM(CASE WHEN users.status = 'Guru Tetap Yayasan' THEN 1 ELSE 0 END) as total_guru_tetap_yayasan,
        SUM(CASE WHEN users.status = 'Pegawai Kontrak Yayasan' THEN 1 ELSE 0 END) as total_pegawai_kontrak_yayasan,
        SUM(CASE WHEN users.status = 'Guru Kontrak Yayasan' THEN 1 ELSE 0 END) as total_guru_kontrak_yayasan,
        SUM(CASE WHEN users.status = 'Guru Honor Sekolah' THEN 1 ELSE 0 END) as total_guru_honor_sekolah,
        SUM(CASE WHEN users.status = 'Tenaga Honor Sekolah' THEN 1 ELSE 0 END) as total_tenaga_honor_sekolah,
        SUM(CASE WHEN users.status = 'Guru Tamu' THEN 1 ELSE 0 END) as total_guru_tamu,

        SUM(CASE WHEN users.status = 'Pegawai Tetap Yayasan' AND users.isActive = 1 THEN 1 ELSE 0 END) as total_pegawai_tetap_yayasan_aktif,
        SUM(CASE WHEN users.status = 'Guru Tetap Yayasan' AND users.isActive = 1 THEN 1 ELSE 0 END) as total_guru_tetap_yayasan_aktif,
        SUM(CASE WHEN users.status = 'Pegawai Kontrak Yayasan' AND users.isActive = 1 THEN 1 ELSE 0 END) as total_pegawai_kontrak_yayasan_aktif,
        SUM(CASE WHEN users.status = 'Guru Kontrak Yayasan' AND users.isActive = 1 THEN 1 ELSE 0 END) as total_guru_kontrak_yayasan_aktif,
        SUM(CASE WHEN users.status = 'Guru Honor Sekolah' AND users.isActive = 1 THEN 1 ELSE 0 END) as total_guru_honor_sekolah_aktif,
        SUM(CASE WHEN users.status = 'Tenaga Honor Sekolah' AND users.isActive = 1 THEN 1 ELSE 0 END) as total_tenaga_honor_sekolah_aktif,
        SUM(CASE WHEN users.status = 'Guru Tamu' AND users.isActive = 1 THEN 1 ELSE 0 END) as total_guru_tamu_aktif,
        
        SUM(CASE WHEN users.status = 'Pegawai Tetap Yayasan' AND users.isActive = 0 THEN 1 ELSE 0 END) as total_pegawai_tetap_yayasan_tidak_aktif,
        SUM(CASE WHEN users.status = 'Guru Tetap Yayasan' AND users.isActive = 0 THEN 1 ELSE 0 END) as total_guru_tetap_yayasan_tidak_aktif,
        SUM(CASE WHEN users.status = 'Pegawai Kontrak Yayasan' AND users.isActive = 0 THEN 1 ELSE 0 END) as total_pegawai_kontrak_yayasan_tidak_aktif,
        SUM(CASE WHEN users.status = 'Guru Kontrak Yayasan' AND users.isActive = 0 THEN 1 ELSE 0 END) as total_guru_kontrak_yayasan_tidak_aktif,
        SUM(CASE WHEN users.status = 'Guru Honor Sekolah' AND users.isActive = 0 THEN 1 ELSE 0 END) as total_guru_honor_sekolah_tidak_aktif,
        SUM(CASE WHEN users.status = 'Tenaga Honor Sekolah' AND users.isActive = 0 THEN 1 ELSE 0 END) as total_tenaga_honor_sekolah_tidak_aktif,
        SUM(CASE WHEN users.status = 'Guru Tamu' AND users.isActive = 0 THEN 1 ELSE 0 END) as total_guru_tamu_tidak_aktif,

        aum.namaAum")
            ->where('role', 'user')
            ->leftJoin('aum', 'users.idAum', 'aum.idAum')
            ->groupBy('aum.namaAum')
            ->get();

        // return response()->json($totalPegawaiPerAUM);
        return view('User/jumlahPegawai', [
            'detailUserPerAum' => $totalPegawaiPerAUM,
            'totalSeluruhPegawai' => $totalSeluruhPegawai,
            'totalSeluruhPegawaiAktif' => $totalSeluruhPegawaiAktif,
            'totalSeluruhPegawaiNonAktif' => $totalSeluruhPegawaiNonAktif
        ]);
    }

    public function editTugasPokokView($idUser, $idTugasPokok)
    {
        $dataUser = User::where('idUser', $idUser)->first();
        $tugasPokok = TugasPokok::where('idUser', $idUser)->where('idTugasPokok', $idTugasPokok)->first();
        if (!$tugasPokok) {
            return abort(404);
        }
        return view('User/editTugasPokok', ['dataUser' => $dataUser, 'tugasPokok' => $tugasPokok]);
    }

    public function handleEditTugasPokok($idUser, $idTugasPokok, Request $request)
    {
        $validate = $request->validate([
            'tugasPokok' => 'required|string|min:4',
            'namaAUm' => 'required|string|min:4',
            'nomerAum' => 'string|min:2|required',
            'namaPenandatangan' => 'string|min:2|required',
            'jabatanPenandatangan' => 'string|min:2|required',
            'nomerSK' => 'string|min:2|required',
            'tanggalSK' => 'required|date',
            'buktisk' => 'nullable|file|mimes:pdf|max:3000'
        ]);

        $tugasPokok = TugasPokok::select(['buktisk'])->where('idUser', $idUser)->where('idTugasPokok', $idTugasPokok)->first();

        if (isset($tugasPokok)) {
            if (isset($validate['buktisk'])) {
                $fileName = Str::random(6) . '_' . time() . '.' . $request->file('buktisk')->getClientOriginalExtension();
                $validate['buktisk'] = $request->file('buktisk')->storeAs('dokumen', $fileName, 'public');

                if (Storage::exists("public/$tugasPokok->buktisk")) {
                    Storage::delete("public/$tugasPokok->buktisk");
                }
            }

            $check = TugasPokok::where('idUser', $idUser)->where('idTugasPokok', $idTugasPokok)->update($validate);

            if ($check) {
                return redirect()->route('detailUserRoute', ['idUser' => $idUser])->with('success', 'Edit Tugas Pokok Berhasil');
            }
            return redirect()->back()->with('error', 'Edit Tugas Pokok Gagal');
        }
        return redirect()->route('detailUserRoute', ['idUser' => $idUser])->with('error', 'Edit Tugas Pokok Gagal, ID Tugas Pokok Tidak Valid');
    }

    public function exportDataView()
    {
        $aum = Aum::get();
        return view('User/exportData', ['aum' => $aum]);
    }

    public function handleExportDataView(Request $request)
    {
        $validate = $request->validate(
            [
                'idAum' => 'nullable|string|exists:aum,idAum',
                'statusAktif' => 'required|in:true,false',
                'status' => 'nullable|in:Pegawai Tetap Yayasan,Guru Tetap Yayasan,Pegawai Kontrak Yayasan,Guru Kontrak Yayasan,Guru Honor Sekolah,Tenaga Honor Sekolah,Guru Tamu',
            ]
        );

        $validate['statusAktif'] = $validate['statusAktif'] === 'true' ? 1 : 0;

        $query = User::with('pedidikanFormal')
            ->with('pedidikanNonFormal')
            ->with('riwayatPekerjaan')
            ->with('tugasTambahan')
            ->with('tugasMapel')
            ->where('role', 'user')
            ->where('isProfileDone', 1)
            ->where('isActive', $validate['statusAktif'])
            ->leftJoin('aum', 'users.idAum', '=', 'aum.idAum')
            ->leftJoin('profile', 'users.idUser', '=', 'profile.idUser')
            ->leftJoin('tugas_pokok', 'users.idUser', '=', 'tugas_pokok.idUser');

        isset($validate['idAum']) ? $query->where('users.idAum', $validate['idAum']) : null;
        isset($validate['status']) ? $query->where('status', $validate['status']) : null;

        $result = $query->select([
            'users.idUser as ID User',
            'nickname as Nama User',
            'username as Username',
            'status as Status Kepegawaian',
            'aum.namaAum as Nama AUM',
            'namaLengkap as Nama Lengkap',
            'noKTAM as Nomer KTAM',
            'nipy as Nomer NIPY',
            'tempatLahir as Tempat Lahir',
            'tanggalLahir as Tanggal Lahir',
            'profile.alamat as Alamat Rumah',
            'tugasPokok as Tugas Pokok Yang Diemban',
            'nomerSK as Nomer SK',
            'tanggalSK as Tanggal SK',
            'namaPenandatangan as Nama Penanda Tangan SK',
            'jabatanPenandatangan as Jabatan Penanda Tangan SK',
        ])->get();

        $pedidikanFormal = collect($result)->flatMap(function ($user) {
            return collect($user['pedidikanFormal'])->map(function ($pendidikanFormal) use ($user) {
                $pendidikanFormal['Nama Lengkap'] = $user['Nama Lengkap'];
                return $pendidikanFormal;
            });
        });

        $pedidikanNonFormal = collect($result)->flatMap(function ($user) {
            return collect($user['pedidikanNonFormal'])->map(function ($pendidikanNonFormal) use ($user) {
                $pendidikanNonFormal['Nama Lengkap'] = $user['Nama Lengkap'];
                return $pendidikanNonFormal;
            });
        });

        $riwayatPekerjaan = collect($result)->flatMap(function ($user) {
            return collect($user['riwayatPekerjaan'])->map(function ($pekerjaan) use ($user) {
                $pekerjaan['Nama Lengkap'] = $user['Nama Lengkap'];
                return $pekerjaan;
            });
        });

        $tugasTambahan = collect($result)->flatMap(function ($user) {
            return collect($user['tugasTambahan'])->map(function ($tugas) use ($user) {
                $tugas['Nama Lengkap'] = $user['Nama Lengkap'];
                return $tugas;
            });
        });

        $tugasMapel = collect($result)->flatMap(function ($user) {
            return collect($user['tugasMapel'])->map(function ($tugas) use ($user) {
                $tugas['Nama Lengkap'] = $user['Nama Lengkap'];
                return $tugas;
            });
        });

        $sheets = new SheetCollection([
            'Profile' => $result,
            'Riwayat Pendidikan Formal' => $pedidikanFormal,
            'Riwayat Pendidikan Non Formal' => $pedidikanNonFormal,
            'Riwayat Pekerjaan' => $riwayatPekerjaan,
            'Tugas Tambahan' => $tugasTambahan,
            'Tugas Mapel' => $tugasMapel,
        ]);

        return (new FastExcel($sheets))->download('file.xlsx');
    }
}
