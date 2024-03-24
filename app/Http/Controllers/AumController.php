<?php

namespace App\Http\Controllers;

use App\Models\Aum;
use Exception;
use Illuminate\Http\Request;

use function Laravel\Prompts\error;
use function PHPUnit\Framework\throwException;

class AumController extends Controller
{
    public function listAumController()
    {
        $listAum = Aum::orderBy('namaAum', 'asc')->get();

        return view('Aum/listAum', ['aum' => $listAum]);
    }

    public function addAum(Request $request)
    {
        $validate = $request->validate(
            [
                'namaAum' => 'required|string|max:255',
                'npsm' => 'required|string|max:255|unique:aum,npsm',
                'lokasi' => 'required|string',
            ]
        );

        $aum = Aum::create($validate);

        if (isset($aum)) {
            return redirect()->refresh()->with('success', 'AUM Berhasil Ditambahkan');
        } else {
            return redirect()->refresh()->withInput()->with('error', 'AUM Gagal Ditambahkan');
        }
    }

    public function gantiStatus($idAum)
    {
        $aum = Aum::where('idAum', $idAum)->first();

        if (isset($aum)) {
            $aum->izinTambahPegawai = !$aum->izinTambahPegawai;

            $aum->save();
            return redirect()->back()->with('success', 'Status AUM Berhasil Diperbarui');
        }

        return redirect()->back()->withInput()->with('error', 'Status AUM Gagal Diperbarui');
    }

    public function editAum(Request $request)
    {
        try {
            $validate = $request->validate([
                'namaAum' => 'required|string|max:255',
                'npsm' => 'required|string|max:255|unique:aum,npsm,' . $request->idAum . ',idAum',
                'lokasi' => 'required|string',
                'idAum' => 'required|string|exists:aum,idAum',
            ], [
                'npsm.unique' => 'NPSN telah digunakan',
                'idAum.exist' => 'Kelasahan ID AUM',
                'namaAum.required' => 'Nama AUM Tidak Boleh Kosong',
                'npsm.required' => 'NPSN AUM Tidak Boleh Kosong',
                'lokasi.required' => 'Lokasi AUM Tidak Boleh Kosong',
            ]);

            $aum = Aum::where('idAum', $validate['idAum'])->update($validate);

            return redirect()->back()->with('success', 'Edit Data AUM Berhasil');
        } catch (\Throwable $th) {
            $mess = $th->getMessage();
            return redirect()->back()->with('error', "Edit Data AUM Berhasil, $mess");
        }
    }
}
