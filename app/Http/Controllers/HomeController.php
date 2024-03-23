<?php

namespace App\Http\Controllers;

use App\Models\Profile;
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
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function beforeHomeView()
    {
        return view('Home/verifProfile');
    }

    public function handleBeforeHome(Request $request)
    {
        DB::beginTransaction();

        try {
            $validate = $request->validate(
                [
                    'namaLengkap' => 'required|string',
                    'noKTAM' => 'string|nullable',
                    'tempatLahir' => 'string|required',
                    'tanggalLahir' => 'required|date',
                    'isMarried' => 'required|string',
                    'nipy' => 'string|nullable',
                    'alamat' => 'required|string',
                    'fotoProfile' => 'image|mimes:jpg,jpeg,png|max:3072'
                ]
            );

            $user = Auth::user();

            if ($validate['isMarried'] === 'true') {
                $validate['isMarried'] = true;
            } else {
                $validate['isMarried'] = false;
            }

            $fileName = Str::random(6) . '_' . time() . '.' . $request->file('fotoProfile')->getClientOriginalExtension();
            $validate['fotoProfile'] = $request->file('fotoProfile')->storeAs('photoProfile', $fileName, 'public');

            $profile = Profile::create([
                'namaLengkap' => $validate['namaLengkap'],
                'noKTAM' => $validate['noKTAM'],
                'tempatLahir' => $validate['tempatLahir'],
                'tanggalLahir' => $validate['tanggalLahir'],
                'isMarried' => $validate['isMarried'],
                'nipy' => $validate['nipy'],
                'alamat' => $validate['alamat'],
                'idAum' => $user['idAum'],
                'idUser' => $user['idUser'],
                'fotoProfile' => $validate['fotoProfile'],
            ]);


            $user['idProfile'] = $profile['idUser'];
            $user['isProfileDone'] = true;
            $user->save();

            DB::commit();
            return redirect()->to('home');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Tambah Profile Gagal');
        }
    }

    public function homeView()
    {
        $user = Auth::user();
        $profile = Profile::select(['profile.idProfile', 'namaLengkap', 'noKTAM', 'tempatLahir', 'tanggalLahir', 'isMarried', 'nipy', 'alamat', 'fotoProfile', 'namaAum', 'totalMasaKerja'])
            ->where('idUser', $user['idUser'])
            ->leftJoin('aum', 'profile.idAum', '=', 'aum.idAum')
            ->first();

        $tugasMapel = TugasMapel::where('idUser', $user['idUser'])->get();
        $tugasTambahan = TugasTambahan::where('idUser', $user['idUser'])->get();
        $tugasPokok = TugasPokok::where('idUser', $user['idUser'])->first();

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

        return view('Home/homepage', ['profile' => $profile, 'usia' => $usia, 'tugasPokok' => $tugasPokok, 'tugasMapel' => $tugasMapel, 'tugasTambahan' => $tugasTambahan]);
    }

    public function addTugasTambahan(Request $request)
    {
        $validate = $request->validate(
            [
                'tugasTambahan' => 'required|string|min:2'
            ]
        );
        $user = Auth::user();

        $tugasTambahan = TugasTambahan::create(
            [
                'tugasTambahan' => $validate['tugasTambahan'],
                'idUser' => $user['idUser']
            ]
        );

        if (isset($tugasTambahan)) {
            return redirect()->back()->with('success', 'Tambah Tugas Tambahan Berhasil');
        }
        return redirect()->back()->withInput()->with('error', 'Tambah Tugas Tambahan Gagal');
    }

    public function addTugasMapel(Request $request)
    {
        $validate = $request->validate(
            [
                'mapelDiampu' => 'required|string|min:2',
                'totalJamSeminggu' => 'required|integer'
            ]
        );

        $user = Auth::user();

        $tugasTambahan = TugasMapel::create(
            [
                'mapelDiampu' => $validate['mapelDiampu'],
                'totalJamSeminggu' => $validate['totalJamSeminggu'],
                'idUser' => $user['idUser']
            ]
        );

        if (isset($tugasTambahan)) {
            return redirect()->back()->with('success', 'Tambah Tugas Mapel Berhasil');
        }
        return redirect()->back()->withInput()->with('error', 'Tambah Tugas Mapel Gagal');
    }

    public function deleteTugasTambahan($idTugasTambahan)
    {
        $user = Auth::user();
        $tugas = TugasTambahan::where('idTugasTambahan', $idTugasTambahan)->where('idUser', $user['idUser'])->delete();

        if (isset($tugas)) {
            return redirect()->back()->with('success', 'Hapus Tugas Tambahan Berhasil');
        }
        return redirect()->back()->with('error', 'Hapus Tugas Tambahan Gagal');
    }

    public function deleteTugasMapel($idTugasMapel)
    {
        $user = Auth::user();
        $tugas = TugasMapel::where('idTugasMapel', $idTugasMapel)->where('idUser', $user['idUser'])->delete();

        if (isset($tugas)) {
            return redirect()->back()->with('success', 'Hapus Tugas Mapel Berhasil');
        }
        return redirect()->back()->with('error', 'Hapus Tugas Mapel Gagal');
    }

    public function editProfilePegawaiView()
    {
        $user = Auth::user();
        $profile = Profile::where('idUser', $user['idUser'])->first();
        return view('Home/editProfilePegawai', ['profile' => $profile]);
    }

    public function handleEditProfilePegawai(Request $request)
    {
        $user = Auth::user();
        $validate = $request->validate(
            [
                'namaLengkap' => 'required|string',
                'noKTAM' => 'string|nullable',
                'tempatLahir' => 'string|required',
                'tanggalLahir' => 'required|date',
                'isMarried' => 'required|string',
                'nipy' => 'string|nullable',
                'alamat' => 'required|string',
                'fotoProfile' => 'image|mimes:jpg,jpeg,png|max:3072|nullable'
            ]
        );

        $updatedProfile = Profile::select(['fotoProfile'])->where('idUser', $user['idUser'])->first();

        if (isset($validate['fotoProfile'])) {
            $fileName = Str::random(6) . '_' . time() . '.' . $request->file('fotoProfile')->getClientOriginalExtension();
            $validate['fotoProfile'] = $request->file('fotoProfile')->storeAs('photoProfile', $fileName, 'public');

            if (Storage::exists("public/$updatedProfile->fotoProfile")) {
                Storage::delete("public/$updatedProfile->fotoProfile");
            }
        }

        if ($validate['isMarried'] === 'true') {
            $validate['isMarried'] = true;
        } else {
            $validate['isMarried'] = false;
        }

        $updatedProfile = Profile::where('idUser', $user['idUser'])->update($validate);

        if ($updatedProfile) {
            return redirect()->to('/home')->with('success', 'Edit Profile Berhasil Berhasil');
        }
        return redirect()->back()->withInput()->with('error', 'Edit Profile Gagal');
    }

    public function GantiPasswordView()
    {
        return view('Home/gantiPassword');
    }

    public function handleGantiPassword(Request $request)
    {
        $validate = $request->validate(
            [
                'username' => 'required|string',
                'password' => 'required|string',
                'passwordBaru' => 'required|string|min:6'
            ]
        );

        $user = User::where('username', $validate['username'])->first();

        $userLogin = Auth::user();

        if ($user['idUser'] === $userLogin['idUser'] && Hash::check($validate['password'], $user['password'])) {
            $user['password'] = Hash::make($validate['passwordBaru']);
            $user->save();
            return redirect()->to('/home')->with('success', 'Ganti Password Berhasil');
        }

        return redirect()->back()->withInput()->with('error', 'Ganti Password Gagal');
    }
}
