<dialog id="my_modal_2" class="modal">
    <div class="modal-box">
        <h1 class="text-center text-lg font-medium mb-8" id="titleModal"></h1>
        <form onsubmit="return validationEditAum()" method="POST" action="daftar-aum/edit-aum"
            class="w-full flex flex-col gap-3">
            @csrf
            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text font-semibold">Nama AUM<span class="text-red-400">*</span></span>
                </div>
                <input name="idAum" id="idAum" type="hidden" class="input input-bordered w-full" />
                <input name="namaAum" id="namaAum" type="text" class="input input-bordered w-full" />
                <p id="errornamaAum" class="text-xs text-red-400"></p>
            </label>

            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text font-semibold">NPSN<span class="text-red-400">*</span></span>
                </div>
                <input name="npsm" id="npsm" type="text" class="input input-bordered w-full" />
                <p id="errornpsm" class="text-xs text-red-400"></p>
            </label>

            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text font-semibold">Lokasi<span class="text-red-400">*</span></span>
                </div>

                <input name="lokasi" id="lokasi" type="text" class="input input-bordered w-full" />
                <p id="errorlokasi" class="text-xs text-red-400"></p>

            </label>

            <div class="mt-10 w-full flex justify-end">
                <button class="btn btn-primary w-40" type="submit">Simpan</button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

<dialog id="my_modal_3" class="modal">
    <div class="modal-box">
        <h1 class="text-center text-lg font-medium mb-2" id="titleModalGantiStatus"></h1>
        <p class="text-red-400 font-light text-center mb-8" id="ketStatus"></p>
        <div class="modal-action flex justify-center">
            <form method="dialog" class="flex justify-center gap-8">
                <button class="btn btn-primary w-40">Close</button>
                <a id="linkGantiStatus"
                    class="btn-cus border-secondary border flex justify-center items-center rounded-md hover:text-white text-secondary w-40 hover:bg-secondary">Non
                    Aktif</a>
            </form>
        </div>
    </div>
</dialog>

@extends('layouts.layout')
@section('content')
    <div class="w-full">
        <div class="mb-8">
            <h1 class="text-2xl font-bold">Daftar Aum</h1>
        </div>

        @if (session('success'))
            <div role="alert" class="alert alert-success mb-8 text-white font-medium">
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div role="alert" class="alert alert-error mb-8 text-white font-medium">
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <div class="flex justify-between w-full gap-8">
            <form class="flex gap-4 flex-wrap" method="post">
                @csrf
                <div class="flex flex-col gap-2">
                    <input type="text" placeholder="Masukan Nama AUM" name="namaAum"
                        class="input input-bordered w-80 rounded-full" />
                    @error('namaAum')
                        <p class="text-xs text-red-400">*{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col gap-2">
                    <input type="text" placeholder="Masukan NPSN AUM" name="npsm"
                        class="input input-bordered rounded-full" />
                    @error('npsm')
                        <p class="text-xs text-red-400">*{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col gap-2">
                    <input type="text" placeholder="Masukan alamat AUM" name="lokasi"
                        class="input input-bordered rounded-full w-96" />
                    @error('lokasi')
                        <p class="text-xs text-red-400">*{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="bg-white hover:bg-secondary hover:text-white text-secondary btn border border-secondary rounded-full w-28">Simpan</button>
            </form>

        </div>

        <div class="overflow-x-auto mt-12">
            <table class="table table-zebra border">
                <!-- head -->
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama AUM</th>
                        <th class="text-center">NPSN</th>
                        <th class="text-center">Alamat</th>
                        <th class="text-center">Izin Tambah Pegawai</th>
                        <th class="text-center">Kontrol</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($aum as $index => $item)
                        <tr>
                            <th>{{ ++$index }}</th>
                            <td>{{ $item['namaAum'] }}</td>
                            <td>{{ $item['npsm'] }}</td>
                            <td>{{ $item['lokasi'] }}</td>
                            <td>
                                <div class="flex justify-center">
                                    @if ($item['izinTambahPegawai'] === 0)
                                        <p class="badge badge-error text-white p-3 font-medium">Dibatasi</p>
                                    @else
                                        <p class="badge badge-success text-white p-3 font-medium">Izinkan</p>
                                    @endif
                                </div>
                            </td>
                            <td class="flex gap-8 justify-center">
                                <button
                                    class="btn-outline btn border border-secondary hover:bg-secondary hover:border-secondary rounded w-20"
                                    onclick="my_modal_2.showModal(); modalEditUser('{{ $item['namaAum'] }}','{{ $item['npsm'] }}','{{ $item['lokasi'] }}','{{ $item['idAum'] }}')">Edit
                                    Aum</button>

                                <button class="btn-primary btn text-white rounded w-20"
                                    onclick="my_modal_3.showModal(); modalGantiStatus('{{ $item['namaAum'] }}','{{ $item['idAum'] }}','{{ $item['izinTambahPegawai'] }}')">
                                    Ganti Status
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function modalEditUser(namaAum, npsn, lokasi, idAum) {
            const modal = document.getElementById("titleModal");
            const form_namaAum = document.getElementById("namaAum");
            const form_npsn = document.getElementById("npsm");
            const form_lokasi = document.getElementById("lokasi");
            const form_idAum = document.getElementById("idAum");

            form_namaAum.value = namaAum;
            form_npsn.value = npsn;
            form_lokasi.value = lokasi;
            form_idAum.value = idAum;
            modal.textContent = namaAum;
        }

        function validationEditAum() {
            var form_namaAum = document.getElementById("namaAum").value;
            var form_npsn = document.getElementById("npsm").value;
            var form_lokasi = document.getElementById("lokasi").value;
            var error_form_namaAum = document.getElementById("errornamaAum");
            var error_form_npsn = document.getElementById("errornpsm");
            var error_form_lokasi = document.getElementById("errorlokasi");

            var isValid = true;

            if (form_namaAum.length < 1) {
                error_form_namaAum.textContent = "*NIP Tidak Boleh Kosong.";
                isValid = false;
            } else {
                error_form_namaAum.textContent = "";
            }

            if (form_npsn.length < 1) {
                error_form_npsn.textContent =
                    "*NPSN Tidak Boleh Kosong.";
                isValid = false;
            } else {
                error_form_npsn.textContent = "";
            }

            if (form_lokasi.length < 1) {
                error_form_lokasi.textContent =
                    "*Lokasi Tidak Boleh Kosong.";
                isValid = false;
            } else {
                error_form_lokasi.textContent = "";
            }

            return isValid;
        }

        function modalGantiStatus(namaAum, idAum, status) {
            const titleModalGantiStatus = document.getElementById("titleModalGantiStatus");
            const linkGantiStatus = document.getElementById("linkGantiStatus");
            const ketStatus = document.getElementById("ketStatus");

            linkGantiStatus.setAttribute("href", `/dashboard/daftar-aum/ganti-status/${idAum}`);
            titleModalGantiStatus.textContent = `Apakah Anda Yakin Untuk Mengubah Status Data AUM ${namaAum}`;

            if (status == 1) {
                ketStatus.textContent = `Menonaktifkan Izin Tambah Pegawai Akan Berakibat Kepada
                Admin AUM Tersebut Tidak Dapat Menambahkan Pegawai`;
            } else {
                ketStatus.textContent = `Mengaktifkan Izin Tambah Pegawai Akan Berakibat Kepada
                Admin AUM Tersebut Dapat Menambahkan Pegawai Baru`;
            }
        }
    </script>
@endsection
