<dialog id="my_modal_3" class="modal">
    <div class="modal-box">
        <h1 class="text-center text-lg font-medium mb-2" id="titleModalGantiStatus"></h1>
        <p class="text-red-400 font-light text-center mb-8" id="ketStatus"></p>
        <div class="modal-action flex justify-center">
            <form method="dialog" class="flex justify-center gap-8">
                <button class="btn btn-primary w-40">Batal</button>
                <a id="linkGantiStatus"
                    class="btn-cus border-secondary border flex justify-center items-center rounded-md hover:text-white text-secondary w-40 hover:bg-secondary">Hapus</a>
            </form>
        </div>
    </div>
</dialog>

@extends('layouts.userLayout')
@section('content')
    <div class="w-full">
        <div class="flex justify-between w-full mb-10 items-center">
            <h1 class="text-xl lg:text-2xl font-bold">RIWAYAT PENDIDIKAN NON FORMAL PEGAWAI</h1>

            <div class="flex gap-4">
                <a class="btn btn-active btn-primary" href="/home/add-riwayat-pendidikan-non-formal">Add Riwayat Pendidikan
                    Non Formal</a>
            </div>
        </div>

        @if (session('success'))
            <div role="alert" class="alert alert-success mb-8 text-white font-medium">
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="overflow-x-auto mt-12">
            <table class="table table-zebra border">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Lembaga Penyelenggara</th>
                        <th class="text-center">Jenis Diklat</th>
                        <th class="text-center">Tingkat</th>
                        <th class="text-center">Tahun Lulus</th>
                        <th class="text-center">Sertifikat</th>
                        <th class="text-center">Kontrol</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($riwayatPendidikan as $index => $item)
                        <tr>
                            <th>{{ ++$index }}</th>
                            <td class="whitespace-nowrap">{{ $item['lembagaPenyelenggara'] }}</td>
                            <td class="whitespace-nowrap">{{ $item['jenisDiklat'] }}</td>
                            <td class="whitespace-nowrap">{{ $item['tingkat'] }}</td>
                            <td class="text-center">{{ $item['tahunLulus'] }}</td>
                            <td class="text-center font-bold text-gray-400 underline"><a target="_blank"
                                    href="{{ Storage::url($item['sertifikat']) }}">Download</a>
                            </td>

                            <td class="flex
                                    gap-8 justify-center">
                                <a target="_blank"
                                    href="riwayat-pendidikan-non-formal/edit/{{ $item['idPendidikanNonFormal'] }}"
                                    class="btn btn-secondary text-white rounded w-20">Edit</a>

                                <button class="btn-error btn text-white rounded w-20"
                                    onclick="my_modal_3.showModal(); 
                                    modalGantiStatus(
                                    'Apakah Anda Yakin Untuk Menghapus Data Riwayat Pendidikan Non Formal {{ $item['lembagaPenyelenggara'] }}', 
                                    'Data Yang Telah Dihapus Tidak Dapat Dikembalikan Lagi',
                                    'riwayat-pendidikan-non-formal/delete/{{ $item['idPendidikanNonFormal'] }}'
                                    )">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script src="{{ asset('javascript/index.js') }}"></script>
@endsection
