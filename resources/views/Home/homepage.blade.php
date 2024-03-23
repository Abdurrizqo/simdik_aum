@extends('layouts.userLayout')
@section('content')
    <div class="w-full">
        <div class="flex justify-between w-full mb-10 items-center">
            <h1 class="text-xl lg:text-2xl font-bold">PROFIL PEGAWAI</h1>

            <div class="flex gap-4">
                <a class="btn btn-active btn-primary" href="home/edit-profile-pegawai">Edit Profile Pribadi</a>
            </div>
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

        <div class="flex rounded-lg border shadow-lg p-5 gap-16">
            <div class="w-40 lg:w-52">
                @isset($profile['fotoProfile'])
                    <div class="w-full h-40 lg:h-52 rounded bg-cover bg-center"
                        style="background-image: url('{{ Storage::url($profile['fotoProfile']) }}')">
                    </div>
                @else
                    <div class="w-full bg-gray-300 h-40 lg:h-52 rounded">
                    </div>
                @endisset
            </div>

            <div class="flex-1">
                <div class="flex flex-col gap-2">
                    <div class="flex-1 flex md:gap-4 flex-wrap">
                        <p class="font-medium col-span-2 inline-block w-52">Nama Pegawai</p>
                        <p class="col-span-3">{{ $profile['namaLengkap'] }}</p>
                    </div>

                    <div class="flex-1 flex md:gap-4 flex-wrap">
                        <p class="font-medium col-span-2 inline-block w-52">Status Perkawinan</p>
                        <p class="col-span-3">
                            @if ($profile['isMarried'])
                                Sudah Kawin
                            @else
                                Belum Kawin
                            @endif
                        </p>
                    </div>

                    <div class="flex-1 flex md:gap-4 flex-wrap">
                        <p class="font-medium col-span-2 inline-block w-52">NIPY</p>
                        <p class="col-span-3">{{ $profile['nipy'] }}</p>
                    </div>

                    <div class="flex-1 flex md:gap-4 flex-wrap">
                        <p class="font-medium col-span-2 inline-block w-52">KTAM</p>
                        <p class="col-span-3">{{ $profile['noKTAM'] }}</p>
                    </div>

                    <div class="flex-1 flex md:gap-4 flex-wrap">
                        <p class="font-medium col-span-2 inline-block w-52">Total Masa Kerja</p>
                        <p class="col-span-3">{{ $profile['totalMasaKerja'] }}</p>
                    </div>

                    <div class="flex-1 flex md:gap-4 flex-wrap">
                        <p class="font-medium col-span-2 inline-block w-52">Tempat / Tanggal Lahir</p>
                        <p class="col-span-3">{{ $profile['tempatLahir'] }} / {{ $profile['tanggalLahir'] }}</p>
                    </div>

                    <div class="flex-1 flex md:gap-4 flex-wrap">
                        <p class="font-medium col-span-2 inline-block w-52">Usia</p>
                        <p class="col-span-3">{{ $usia }}</p>
                    </div>

                    <div class="flex-1 flex md:gap-4 flex-wrap">
                        <p class="font-medium col-span-2 inline-block w-52">Asal AUM</p>
                        <p class="col-span-3">{{ $profile['namaAum'] }}</p>
                    </div>

                    <div class="flex-1 flex md:gap-4 flex-wrap">
                        <p class="font-medium col-span-2 inline-block w-52">Alamat</p>
                        <p class="col-span-3">{{ $profile['alamat'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        @empty($tugasPokok)
            <div class="rounded-lg border shadow-lg p-5 mt-16 flex justify-center flex-col items-center gap-5">
                <h1 class="font-medium text-gray-500 text-xl">Tugas Pokok Belum Di Tambahkan</h1>
            </div>
        @endempty

        @isset($tugasPokok)
            <div class="rounded-lg border shadow-lg p-5 mt-16 gap-5 flex flex-wrap justify-between items-center">
                <div class="flex-1">
                    <h1 class="font-medium text-xl">{{ $tugasPokok['tugasPokok'] }}</h1>
                    <h3 class="mb-3">Nomer SK {{ $tugasPokok['nomerSK'] }}</h3>
                    <p class="text-gray-400">Tugas diberikan dan dikaji oleh <span
                            class="text-gray-500">{{ $tugasPokok['namaPenandatangan'] }}</span> selaku
                        <span class="text-gray-500">{{ $tugasPokok['jabatanPenandatangan'] }}</span>
                    </p>
                    <p class="text-gray-400">Dilaksanakan Di <span class="text-gray-500">{{ $tugasPokok['namaAUm'] }}</span>
                        Per Tanggal <span class="text-gray-500">{{ $tugasPokok['tanggalSK'] }}</span>
                    </p>
                </div>

                <div class="w-40 flex flex-col gap-3 justify-center items-center">
                    <a class="material-icons text-primary md-40" target="_blank"
                        href="{{ Storage::url($tugasPokok['buktisk']) }}">
                        download_for_offline</a>
                </div>
            </div>
        @endisset

        <div class="mt-16 mb-20 grid grid-cols-1 lg:grid-cols-2 gap-12">
            <div class="border rounded-md shadow p-4 w-full">
                <form method="post" class="flex flex-col w-full" action="home/tugas-tambahan">
                    @csrf
                    <div class="label">
                        <span class="label-text font-semibold">Tugas Tambahan</span>
                    </div>

                    <div class="flex gap-4 justify-between items-center">
                        <input required name="tugasTambahan" value="{{ old('tugasTambahan') }}" type="text"
                            placeholder="tugas tambahan" class="input input-bordered w-full" />
                        <button class="btn btn-primary rounded-full w-32">Simpan</button>
                    </div>

                    @error('tugasTambahan')
                        <p class="text-xs text-red-400">*{{ $message }}</p>
                    @enderror
                </form>

                <div class="mt-6 h-80 overflow-auto">
                    @foreach ($tugasTambahan as $index => $item)
                        <div class="p-2 w-full border shadow rounded flex gap-4 mb-6 items-center">
                            <p class="w-10 text-center font-bold">{{ ++$index }}</p>
                            <p class="flex-1">{{ $item['tugasTambahan'] }}</p>
                            <a href="home/tugas-tambahan/delete/{{ $item['idTugasTambahan'] }}"
                                class="btn-cus material-icons text-red-400">
                                cancel
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>


            <div class="border rounded-md shadow p-4 w-full">
                <form method="post" class="grid grid-cols-2 gap-x-4 gap-y-8 w-full" action="home/tugas-mapel">
                    @csrf
                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">Tugas Mapel</span>
                        </div>
                        <input required name="mapelDiampu" value="{{ old('mapelDiampu') }}" type="text"
                            placeholder="mapel diampu" class="input input-bordered w-full" />
                        @error('mapelDiampu')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">Jam Per Minggu</span>
                        </div>
                        <input required name="totalJamSeminggu" value="{{ old('totalJamSeminggu') }}" type="number"
                            placeholder="Total Jam Per Minggu" class="input input-bordered w-full" />
                        @error('totalJamSeminggu')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <button class="btn btn-primary rounded-full w-full col-span-2">Simpan</button>
                </form>

                <div class="mt-6 h-80 overflow-auto">
                    @foreach ($tugasMapel as $index => $item)
                        <div class="p-2 w-full border shadow rounded flex gap-4 mb-6 items-center">
                            <p class="w-10 text-center font-bold">{{ ++$index }}</p>
                            <div class="flex-1">
                                <p>{{ $item['mapelDiampu'] }}</p>
                                <p class="text-gray-400 text-sm">{{ $item['totalJamSeminggu'] }} Jam Per Minggu</p>
                            </div>
                            <a href="home/tugas-mapel/delete/{{ $item['idTugasMapel'] }}"
                                class="btn-cus material-icons text-red-400">
                                cancel
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
