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

@extends('layouts.layout')
@section('content')
    <div class="w-full">
        <div class="mb-8">
            <h1 class="text-2xl font-bold">Daftar Admin</h1>
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

        <div class="flex justify-between w-full flex-wrap gap-8">
            <form class="flex gap-4"method="GET">
                <input type="text" placeholder="Cari Admin" name="search"
                    class="border px-3 rounded-full min-w-96 outline-none" />
                <button type="submit"
                    class="bg-white hover:bg-secondary hover:text-white text-secondary btn border border-secondary rounded-full w-28">Cari</button>
            </form>

            <div>
                <a class="btn btn-active btn-primary" href="daftar-admin/tambah-admin">Tambah Admin</a>
            </div>
        </div>

        <div class="overflow-x-auto mt-12">
            <table class="table table-zebra border">
                <!-- head -->
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama Pegawai</th>
                        <th class="text-center">Username</th>
                        <th class="text-center">AUM</th>
                        <th class="text-center">Kontrol</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($admin as $index => $item)
                        <tr>
                            <th>{{ ++$index }}</th>
                            <td class="whitespace-nowrap">{{ $item['nickname'] }}</td>
                            <td class="whitespace-nowrap">{{ $item['username'] }}</td>
                            <td class="whitespace-nowrap">{{ $item['namaAum'] }}</td>
                            <td class="flex gap-8 justify-center">
                                <a href="daftar-admin/edit/{{ $item['idUser'] }}"
                                    class="btn-outline btn border border-secondary hover:bg-secondary hover:border-secondary rounded w-20">Edit
                                    User</a>

                                <button class="btn-error btn text-white rounded w-20"
                                    onclick="my_modal_3.showModal(); 
                                    modalGantiStatus(
                                    'Apakah Anda Yakin Untuk Menghapus Data Admin {{ $item['nickname'] }}', 
                                    'Admin Yang Dihapus Tidak Dapat Digunakan Dan Dikembalikan',
                                    'daftar-admin/delete/{{ $item['idUser'] }}')">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-10">
        {{ $admin->links() }}
    </div>

    <script src="{{ asset('javascript/index.js') }}"></script>
@endsection
