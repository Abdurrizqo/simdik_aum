<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\RiwayatPekerjaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RiwayatPekerjaanController extends Controller
{
    public function listRiwayatPekerjaanView()
    {
        $user = Auth::user();
        $listRiwayatPekerjaan = RiwayatPekerjaan::where('idUser', $user['idUser'])->get();
        return view('Home/riwayatPekerjaan', ['riwayatPekerjaan' => $listRiwayatPekerjaan]);
    }

    public function addRiwayatPekerjaanView()
    {
        return view('Home/addRiwayatPekerjaan');
    }

    public function handleAddRiwayatPekerjaan(Request $request)
    {
        $validate = $request->validate([
            'namaAum' => 'required|string|min:4',
            'nomerAum' => 'string|min:2|required',
            'namaPenandatangan' => 'string|min:2|required',
            'jabatanPenandaTangan' => 'string|min:2|required',
            'nomerSK' => 'string|min:2|required',
            'tanggalSK' => 'required|date',
            'masaKerjaDalamBulan' => 'required|integer|min:1',
            'buktiSK' => 'required|file|mimes:pdf|max:3000'
        ]);

        $user = Auth::user();

        $fileName = Str::random(6) . '_' . time() . '.' . $request->file('buktiSK')->getClientOriginalExtension();
        $validate['buktiSK'] = $request->file('buktiSK')->storeAs('dokumen', $fileName, 'public');

        $addRiwayat = RiwayatPekerjaan::create(
            [
                'namaAum' => $validate['namaAum'],
                'nomerAum' => $validate['nomerAum'],
                'namaPenandatangan' => $validate['namaPenandatangan'],
                'jabatanPenandaTangan' => $validate['jabatanPenandaTangan'],
                'nomerSK' => $validate['nomerSK'],
                'tanggalSK' => $validate['tanggalSK'],
                'masaKerjaDalamBulan' => $validate['masaKerjaDalamBulan'],
                'buktiSK' => $validate['buktiSK'],
                'idUser' => $user['idUser']
            ]
        );

        Profile::where('idUser', $user['idUser'])->increment('totalMasaKerja', $validate['masaKerjaDalamBulan']);

        if (isset($addRiwayat)) {
            return redirect()->to('/home/riwayat-pekerjaan')->with('success', 'Tambah Data Riwayat Pekerjaan Berhasil');
        }
        return redirect()->back()->withInput()->with('error', 'Tambah Data Riwayat Pekerjaan Gagal');
    }

    public function editRiwayatPekerjaanView($idRiwayatPekerjaan)
    {
        $user = Auth::user();
        $riwayat = RiwayatPekerjaan::where('idRiwayatPekerjaan', $idRiwayatPekerjaan)->where('idUser', $user['idUser'])->first();

        if (!$riwayat) {
            return abort(404);
        }

        return view('Home/editRiwayatPekerjaan', ['riwayatPekerjaan' => $riwayat]);
    }

    public function handleEditRiwayatPekerjaan($idRiwayatPekerjaan, Request $request)
    {
        $validate = $request->validate([
            'namaAum' => 'required|string|min:4',
            'nomerAum' => 'string|min:2|required',
            'namaPenandatangan' => 'string|min:2|required',
            'jabatanPenandaTangan' => 'string|min:2|required',
            'nomerSK' => 'string|min:2|required',
            'tanggalSK' => 'required|date',
            'masaKerjaDalamBulan' => 'required|integer|min:1',
            'buktiSK' => 'nullable|file|mimes:pdf|max:3000'
        ]);

        $user = Auth::user();

        $updated = RiwayatPekerjaan::select(['buktiSK', 'masaKerjaDalamBulan'])->where('idRiwayatPekerjaan', $idRiwayatPekerjaan)->where('idUser', $user['idUser'])->first();

        if (empty($updated)) {
            return redirect()->back()->withInput()->with('error', 'ID Data Riwayat Pekerjaan Tidak Valid');
        }

        if (isset($validate['buktiSK'])) {
            $fileName = Str::random(6) . '_' . time() . '.' . $request->file('buktiSK')->getClientOriginalExtension();
            $validate['buktiSK'] = $request->file('buktiSK')->storeAs('dokumen', $fileName, 'public');

            if (Storage::exists("public/$updated->buktiSK")) {
                Storage::delete("public/$updated->buktiSK");
            }
        }

        $updatedRiwayat = RiwayatPekerjaan::where('idRiwayatPekerjaan', $idRiwayatPekerjaan)->where('idUser', $user['idUser'])->update($validate);

        Profile::where('idUser', $user['idUser'])->decrement('totalMasaKerja', $updated['masaKerjaDalamBulan']);
        Profile::where('idUser', $user['idUser'])->increment('totalMasaKerja', $validate['masaKerjaDalamBulan']);

        if ($updatedRiwayat) {
            return redirect()->to('/home/riwayat-pekerjaan')->with('success', 'Edit Data Riwayat Pekerjaan Berhasil');
        }
        return redirect()->back()->withInput()->with('error', 'Edit Data Riwayat Pekerjaan Gagal');
    }

    public function deleteRiwayatPekerjaan($idRiwayatPekerjaan)
    {
        $user = Auth::user();

        $deleted = RiwayatPekerjaan::where('idRiwayatPekerjaan', $idRiwayatPekerjaan)->where('idUser', $user['idUser'])->first();

        if (empty($deleted)) {
            return redirect()->back()->withInput()->with('error', 'ID Data Riwayat Pekerjaan Tidak Valid');
        }

        $check = $deleted->delete();

        Profile::where('idUser', $user['idUser'])->decrement('totalMasaKerja', $deleted['masaKerjaDalamBulan']);

        if (Storage::exists("public/$deleted->buktiSK")) {
            Storage::delete("public/$deleted->buktiSK");
        }

        if ($check) {
            return redirect()->back()->with('success', 'Hapus Data Riwayat Pekerjaan Berhasil');
        }
        return redirect()->back()->with('error', 'Hapus Data Riwayat Pekerjaan Gagal');
    }
}
