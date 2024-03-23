<?php

namespace App\Http\Controllers;

use App\Models\PendidikanNonFormal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PendidikanNonFormalController extends Controller
{
    public function listRiwayatPendidikanNonFormalView()
    {
        $user = Auth::user();
        $listRiwayatPendidikanNonFormal = PendidikanNonFormal::where('idUser', $user['idUser'])->get();
        return view('home/riwayatPendidikanNonFormal', ['riwayatPendidikan' => $listRiwayatPendidikanNonFormal]);
    }

    public function addRiwayatPendidikanNonFormalView()
    {
        return view('home/addRiwayatPendidikanNonFormal');
    }

    public function handleAddRiwayatPendidikanNonFormal(Request $request)
    {
        $validate = $request->validate([
            'lembagaPenyelenggara' => 'required|string|min:4',
            'jenisDiklat' => 'string|min:2|required',
            'tingkat' => 'string|min:2|required',
            'tahunLulus' => 'required|string|size:4',
            'sertifikat' => 'required|file|mimes:pdf|max:3000'
        ]);

        $user = Auth::user();

        $fileName = Str::random(6) . '_' . time() . '.' . $request->file('sertifikat')->getClientOriginalExtension();
        $validate['sertifikat'] = $request->file('sertifikat')->storeAs('dokumen', $fileName, 'public');

        $addRiwayat = PendidikanNonFormal::create(
            [
                'lembagaPenyelenggara' => $validate['lembagaPenyelenggara'],
                'jenisDiklat' => $validate['jenisDiklat'],
                'tingkat' => $validate['tingkat'],
                'tahunLulus' => $validate['tahunLulus'],
                'sertifikat' => $validate['sertifikat'],
                'idUser' => $user['idUser']
            ]
        );

        if (isset($addRiwayat)) {
            return redirect()->to('/home/riwayat-pendidikan-non-formal')->with('success', 'Tambah Data Riwayat Pendidikan Non Formal Berhasil');
        }
        return redirect()->back()->withInput()->with('error', 'Tambah Data Riwayat Pendidikan Non Formal Gagal');
    }

    public function editRiwayatPendidikanNonFormalView($idPendidikanNonFormal)
    {
        $user = Auth::user();
        $riwayat = PendidikanNonFormal::where('idPendidikanNonFormal', $idPendidikanNonFormal)->where('idUser', $user['idUser'])->first();
        if (!$riwayat) {
            return abort(404);
        }
        return view('home/editRiwayatPendidikanNonFormal', ['riwayatPendidikanNonFormal' => $riwayat]);
    }

    public function handleEditRiwayatPendidikanNonFormal($idPendidikanNonFormal, Request $request)
    {
        $validate = $request->validate([
            'lembagaPenyelenggara' => 'required|string|min:4',
            'jenisDiklat' => 'string|min:2|required',
            'tingkat' => 'string|min:2|required',
            'tahunLulus' => 'required|string|size:4',
            'sertifikat' => 'nullable|file|mimes:pdf|max:3000'
        ]);

        $user = Auth::user();

        $updated = PendidikanNonFormal::select(['sertifikat'])->where('idPendidikanNonFormal', $idPendidikanNonFormal)->where('idUser', $user['idUser'])->first();

        if (empty($updated)) {
            return redirect()->back()->withInput()->with('error', 'ID Data Riwayat Pendidikan Non Formal Tidak Valid');
        }

        if (isset($validate['sertifikat'])) {
            $fileName = Str::random(6) . '_' . time() . '.' . $request->file('sertifikat')->getClientOriginalExtension();
            $validate['sertifikat'] = $request->file('sertifikat')->storeAs('dokumen', $fileName, 'public');

            if (Storage::exists("public/$updated->sertifikat")) {
                Storage::delete("public/$updated->sertifikat");
            }
        }

        $updatedRiwayat = PendidikanNonFormal::where('idPendidikanNonFormal', $idPendidikanNonFormal)->where('idUser', $user['idUser'])->update($validate);

        if ($updatedRiwayat) {
            return redirect()->to('/home/riwayat-pendidikan-non-formal')->with('success', 'Edit Data Riwayat Pendidikan Non Formal Berhasil');
        }
        return redirect()->back()->withInput()->with('error', 'Edit Data Riwayat Pendidikan Non Formal Gagal');
    }

    public function deleteRiwayatPendidikanNonFormal($idPendidikanNonFormal)
    {
        $user = Auth::user();

        $deleted = PendidikanNonFormal::where('idPendidikanNonFormal', $idPendidikanNonFormal)->where('idUser', $user['idUser'])->first();

        if (empty($deleted)) {
            return redirect()->back()->withInput()->with('error', 'ID Data Riwayat Pendidikan Non Formal Tidak Valid');
        }

        $check = $deleted->delete();

        if (Storage::exists("public/$deleted->sertifikat")) {
            Storage::delete("public/$deleted->sertifikat");
        }

        if ($check) {
            return redirect()->back()->with('success', 'Hapus Data Riwayat Pendidikan Non Formal Berhasil');
        }
        return redirect()->back()->with('error', 'Hapus Data Riwayat Pendidikan Non Formal Gagal');
    }
}
