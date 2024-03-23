<?php

namespace App\Http\Controllers;

use App\Models\PendidikanFormal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PendidikanFormalController extends Controller
{
    public function listRiwayatPendidikanFormalView()
    {
        $user = Auth::user();
        $listRiwayatPendidikanFormal = PendidikanFormal::where('idUser', $user['idUser'])->get();
        return view('home/riwayatPendidikanFormal', ['riwayatPendidikan' => $listRiwayatPendidikanFormal]);
    }

    public function addRiwayatPendidikanFormalView()
    {
        return view('home/addRiwayatPendidikanFormal');
    }

    public function handleAddRiwayatPendidikanFormal(Request $request)
    {
        $validate = $request->validate([
            'lembagaPendidikan' => 'required|string|min:4',
            'fakultas' => 'string|min:2|nullable',
            'jurusanProgStud' => 'string|min:2|nullable',
            'tahunLulus' => 'required|string|size:4',
            'ijazah' => 'required|file|mimes:pdf|max:3000'
        ]);

        $user = Auth::user();

        $fileName = Str::random(6) . '_' . time() . '.' . $request->file('ijazah')->getClientOriginalExtension();
        $validate['ijazah'] = $request->file('ijazah')->storeAs('dokumen', $fileName, 'public');

        $addRiwayat = PendidikanFormal::create(
            [
                'lembagaPendidikan' => $validate['lembagaPendidikan'],
                'fakultas' => isset($validate['fakultas']) ? $validate['fakultas'] : '-',
                'jurusanProgStud' => isset($validate['jurusanProgStud']) ? $validate['jurusanProgStud'] : '-',
                'tahunLulus' => $validate['tahunLulus'],
                'ijazah' => $validate['ijazah'],
                'idUser' => $user['idUser']
            ]
        );

        if (isset($addRiwayat)) {
            return redirect()->to('/home/riwayat-pendidikan-formal')->with('success', 'Tambah Data Riwayat Pendidikan Formal Berhasil');
        }
        return redirect()->back()->withInput()->with('error', 'Tambah Data Riwayat Pendidikan Formal Gagal');
    }

    public function editRiwayatPendidikanFormalView($idPendidikanFormal)
    {
        $user = Auth::user();
        $riwayat = PendidikanFormal::where('idPendidikanFormal', $idPendidikanFormal)->where('idUser', $user['idUser'])->first();

        if (empty($riwayat)) {
            return abort('404');
        }

        return view('home/editRiwayatPendidikanFormal', ['riwayatPendidikanFormal' => $riwayat]);
    }

    public function handleEditRiwayatPendidikanFormal($idPendidikanFormal, Request $request)
    {
        $validate = $request->validate([
            'lembagaPendidikan' => 'required|string|min:4',
            'fakultas' => 'string|nullable',
            'jurusanProgStud' => 'string|nullable',
            'tahunLulus' => 'required|string|size:4',
            'ijazah' => 'file|mimes:pdf|max:3000|nullable'
        ]);

        $user = Auth::user();

        $updated = PendidikanFormal::select(['ijazah'])->where('idPendidikanFormal', $idPendidikanFormal)->where('idUser', $user['idUser'])->first();

        if (empty($updated)) {
            return redirect()->back()->withInput()->with('error', 'ID Data Riwayat Pendidikan Formal Tidak Valid');
        }

        if (isset($validate['ijazah'])) {
            $fileName = Str::random(6) . '_' . time() . '.' . $request->file('ijazah')->getClientOriginalExtension();
            $validate['ijazah'] = $request->file('ijazah')->storeAs('dokumen', $fileName, 'public');

            if (Storage::exists("public/$updated->ijazah")) {
                Storage::delete("public/$updated->ijazah");
            }
        }

        $updatedRiwayat = PendidikanFormal::where('idPendidikanFormal', $idPendidikanFormal)->where('idUser', $user['idUser'])->update($validate);

        if ($updatedRiwayat) {
            return redirect()->to('/home/riwayat-pendidikan-formal')->with('success', 'Edit Data Riwayat Pendidikan Formal Berhasil');
        }
        return redirect()->back()->withInput()->with('error', 'Edit Data Riwayat Pendidikan Formal Gagal');
    }

    public function deleteRiwayatPendidikanFormal($idPendidikanFormal)
    {
        $user = Auth::user();
        $deleted = PendidikanFormal::where('idPendidikanFormal', $idPendidikanFormal)->where('idUser', $user['idUser'])->first();

        if (empty($deleted)) {
            return redirect()->back()->withInput()->with('error', 'ID Data Riwayat Pendidikan Formal Tidak Valid');
        }

        $check = $deleted->delete();

        if (Storage::exists("public/$deleted->ijazah")) {
            Storage::delete("public/$deleted->ijazah");
        }

        if ($check) {
            return redirect()->back()->with('success', 'Hapus Data Riwayat Pendidikan Formal Berhasil');
        }
        return redirect()->back()->with('error', 'Hapus Data Riwayat Pendidikan Formal Gagal');
    }
}
