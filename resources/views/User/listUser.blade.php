<dialog id="my_modal_2" class="modal">
    <div class="modal-box">
        <h1 class="text-center text-lg font-medium mb-8" id="titleModal"></h1>
        <form method="GET" class="w-full flex flex-col gap-3">
            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text font-semibold">Pencarian</span>
                </div>
                <input name="search" id="namaAum" placeholder="Cari berdasarkan username atau nama pegawai"
                    type="text" class="input input-bordered w-full" />
            </label>

            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text font-semibold">STATUS</span>
                </div>
                <select name="status" class="select select-bordered flex-1">
                    <option value="">SEMUA STATUS</option>
                    <option value="Pegawai Tetap Yayasan">Pegawai Tetap Yayasan</option>
                    <option value="Guru Tetap Yayasan">Guru Tetap Yayasan</option>
                    <option value="Pegawai Kontrak Yayasan">Pegawai Kontrak Yayasan</option>
                    <option value="Guru Kontrak Yayasan">Guru Kontrak Yayasan</option>
                    <option value="Guru Honor Sekolah">Guru Honor Sekolah</option>
                    <option value="Tenaga Honor Sekolah">Tenaga Honor Sekolah</option>
                    <option value="Guru Tamu">Guru Tamu</option>
                </select>
                @error('status')
                    <p class="text-xs text-red-400">*{{ $message }}</p>
                @enderror
            </label>

            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text font-semibold">Asal AUM</span>
                </div>
                @auth
                    @if (Auth::user()->role === 'admin')
                        <select name="idAum" class="select select-bordered flex-1">
                            <option value="">SEMUA AUM</option>
                            @foreach ($aum as $item)
                                <option value="{{ $item['idAum'] }}">{{ $item['namaAum'] }}</option>
                            @endforeach
                        </select>
                    @else
                        <select disabled name="idAum" class="select select-bordered flex-1">
                            @foreach ($aum as $item)
                                @if ($item['idAum'] === Auth::user()->idAum)
                                    <option value="{{ $item['idAum'] }}">{{ $item['namaAum'] }}</option>
                                @endif
                            @endforeach
                        </select>
                    @endif
                @endauth
                @error('idAum')
                    <p class="text-xs text-red-400">*{{ $message }}</p>
                @enderror
            </label>

            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text font-semibold">Verifikasi Profil</span>
                </div>

                <div class="flex flex-wrap gap-4 items-center">
                    <div class="label flex gap-2 items-center">
                        <input type="radio" name="filterVerifProfile" class="radio radio-secondary" checked
                            value="" />
                        <span class="label-text font-semibold">Semua Profile</span>
                    </div>

                    <div class="label flex gap-2 items-center">
                        <input type="radio" name="filterVerifProfile" class="radio radio-secondary" value="true" />
                        <span class="label-text font-semibold">Profile Terverifikasi</span>
                    </div>

                    <div class="label flex gap-2 items-center">
                        <input type="radio" name="filterVerifProfile" class="radio radio-secondary" value="false" />
                        <span class="label-text font-semibold">Pofile Belum Terverifikasi</span>
                    </div>
                </div>
            </label>


            <div class="mt-10 w-full flex justify-end">
                <button class="btn btn-primary w-40" type="submit">Cari</button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

@extends('layouts.layout')
@section('content')
    <div class="w-full">
        <div class="mb-8 flex flex-wrap justify-between items-center">
            <h1 class="text-2xl font-bold">Daftar Pegawai</h1>

            <a class="btn btn-active btn-primary" href="dashboard/tambah-pegawai">Tambah Pegawai</a>
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
            <button onclick="my_modal_2.showModal()"
                class="btn-cus bg-white rounded-md text-secondary border border-secondary w-48 py-3 flex-wrap flex justify-center items-center gap-3 hover:bg-secondary hover:text-white"><span
                    class="material-icons">
                    tune
                </span>
                <p>Filter Pencarian</p>
            </button>
        </div>

        <div class="flex flex-wrap gap-4 items-center mt-3">
            @if (request()->query('search'))
                <p class="px-3 py-1 bg-secondary text-white rounded-full">Pencarian Oleh :
                    <span class="font-bold">{{ request()->query('search') }}</span>
                </p>
            @endif

            @if (request()->query('status'))
                <p class="px-3 py-1 bg-secondary text-white rounded-full">Filter Berdasarkan Status Pegawai : <span
                        class="font-bold">{{ request()->query('status') }}</span></p>
            @endif

            @if (request()->query('idAum'))
                <p class="px-3 py-1 bg-secondary text-white rounded-full">Filter Berdasarkan AUM :
                    @foreach ($aum as $item)
                        @if (request()->query('idAum') === $item['idAum'])
                            <span class="font-bold">{{ $item['namaAum'] }}</span>
                        @endif
                    @endforeach
                </p>
            @endif

            @if (request()->query('filterVerifProfile'))
                <p class="px-3 py-1 bg-secondary text-white rounded-full">Filter Berdasarkan AUM : <span class="font-bold">
                        @if (request()->query('filterVerifProfile') === 'true')
                            Terverifikasi
                        @else
                            Belum Terverifikasi
                        @endif
                    </span></p>
            @endif
        </div>

        <div class="overflow-x-auto mt-12">
            <table class="table table-zebra border">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama Pegawai</th>
                        <th class="text-center">Username</th>
                        <th class="text-center">AUM</th>
                        <th class="text-center">STATUS</th>
                        <th class="text-center">Profile</th>
                        <th class="text-center">Kontrol</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user as $index => $item)
                        <tr>
                            <th>{{ ++$index }}</th>
                            <td class="whitespace-nowrap">{{ $item['nickname'] }}</td>
                            <td class="whitespace-nowrap">{{ $item['username'] }}</td>
                            <td class="whitespace-nowrap">{{ $item['namaAum'] }}</td>
                            <td class="whitespace-nowrap">{{ $item['status'] }}</td>
                            <td>
                                @isset($item['idProfile'])
                                    <p class="text-green-500 text-center">Terverifikasi</p>
                                @endisset

                                @empty($item['idProfile'])
                                    <p class="text-red-500 text-center">Belum Terverifikasi</p>
                                @endisset
                            </td>
                            <td class="flex gap-8 justify-center">
                                <a href="dashboard/user/detail/{{ $item['idUser'] }}"
                                    class="btn btn-primary rounded w-20">Detail User</a>
                                <a href="dashboard/user/edit/{{ $item['idUser'] }}"
                                    class="btn-outline btn border border-secondary hover:bg-secondary hover:border-secondary rounded w-20">Edit
                                    User</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-10">
        {{ $user->links() }}
    </div>
@endsection
