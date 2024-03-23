@extends('layouts.layout')
@section('content')
    <div class="w-full">
        <div class="mb-8">
            <h1 class="text-2xl font-bold">Rekap Daftar Pegawai Seluruh AUM</h1>
        </div>

        <div class="mt-10">
            <h1 class="text-lg font-bold">Keterangan</h1>

            <div class="flex gap-6 text-lg">
                <div class="flex gap-2 items-center">
                    <div class="w-4 h-4 bg-primary"></div>
                    <p>Total Keseluruhan</p>
                </div>

                <div class="flex gap-2 items-center">
                    <div class="w-4 h-4 bg-green-600"></div>
                    <p>Total Pegawai Aktif</p>
                </div>

                <div class="flex gap-2 items-center">
                    <div class="w-4 h-4 bg-orange-600"></div>
                    <p>Total Pegawai Non Aktif</p>
                </div>
            </div>
        </div>

        <div class="mt-10 text-gray-700 w-[28rem]">
            <div>Total Seluruh Pegawai <span class="font-bold">{{ $totalSeluruhPegawai }}</span> dengan jumlah pegawai aktif
                sebanyak
                <span class="font-bold">{{ $totalSeluruhPegawaiAktif }}</span> serta pegawai yang telah di non aktifkan
                sejumlah
                <span class="font-bold">{{ $totalSeluruhPegawaiNonAktif }}</span>
            </div>
        </div>

        <div class="overflow-x-auto mt-4">
            <table class="table table-zebra border">
                <!-- head -->
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama AUM</th>
                        <th class="text-center">Total Pegawai</th>
                        <th class="text-center">Total Pegawai Tetap Yayasan</th>
                        <th class="text-center">Total Guru Tetap Yayasan</th>
                        <th class="text-center">Total Pegawai Kontrak Yayasan</th>
                        <th class="text-center">Total Guru Kontrak Yayasan</th>
                        <th class="text-center">Total Guru Honor Sekolah</th>
                        <th class="text-center">Total Tenaga Honor Sekolah</th>
                        <th class="text-center">Total Guru Tamu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detailUserPerAum as $index => $item)
                        <tr>
                            <th class="text-center">{{ ++$index }}</th>
                            <td class="whitespace-nowrap">{{ $item['namaAum'] }}</td>

                            <td class="text-center">
                                <div class="flex flex-col justify-center items-center font-semibold">
                                    <div
                                        class="h-10 w-20 flex justify-center items-center text-white bg-primary rounded-t-md">
                                        {{ $item['total_user'] }}</div>
                                    <div class="flex items-center justify-center">
                                        <div
                                            class="bg-green-600 flex flex-col w-10 h-10 items-center justify-center text-white rounded-bl-md">
                                            <p>{{ $item['total_user_active'] }}</p>
                                        </div>
                                        <div
                                            class="bg-orange-600 flex flex-col w-10 h-10 items-center justify-center text-white rounded-br-md">
                                            <p>{{ $item['total_user_inactive'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="text-center">
                                <div class="flex flex-col justify-center items-center font-semibold">
                                    <div
                                        class="h-10 w-20 flex justify-center items-center text-white bg-primary rounded-t-md">
                                        {{ $item['total_pegawai_tetap_yayasan'] }}</div>
                                    <div class="flex items-center justify-center">
                                        <div
                                            class="bg-green-600 flex flex-col w-10 h-10 items-center justify-center text-white rounded-bl-md">
                                            <p>{{ $item['total_pegawai_tetap_yayasan_aktif'] }}</p>
                                        </div>
                                        <div
                                            class="bg-orange-600 flex flex-col w-10 h-10 items-center justify-center text-white rounded-br-md">
                                            <p>{{ $item['total_pegawai_tetap_yayasan_tidak_aktif'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="text-center">
                                <div class="flex flex-col justify-center items-center font-semibold">
                                    <div
                                        class="h-10 w-20 flex justify-center items-center text-white bg-primary rounded-t-md">
                                        {{ $item['total_guru_tetap_yayasan'] }}</div>
                                    <div class="flex items-center justify-center">
                                        <div
                                            class="bg-green-600 flex flex-col w-10 h-10 items-center justify-center text-white rounded-bl-md">
                                            <p>{{ $item['total_guru_tetap_yayasan_aktif'] }}</p>
                                        </div>
                                        <div
                                            class="bg-orange-600 flex flex-col w-10 h-10 items-center justify-center text-white rounded-br-md">
                                            <p>{{ $item['total_guru_tetap_yayasan_tidak_aktif'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="text-center">
                                <div class="flex flex-col justify-center items-center font-semibold">
                                    <div
                                        class="h-10 w-20 flex justify-center items-center text-white bg-primary rounded-t-md">
                                        {{ $item['total_pegawai_kontrak_yayasan'] }}</div>
                                    <div class="flex items-center justify-center">
                                        <div
                                            class="bg-green-600 flex flex-col w-10 h-10 items-center justify-center text-white rounded-bl-md">
                                            <p>{{ $item['total_pegawai_kontrak_yayasan_aktif'] }}</p>
                                        </div>
                                        <div
                                            class="bg-orange-600 flex flex-col w-10 h-10 items-center justify-center text-white rounded-br-md">
                                            <p>{{ $item['total_pegawai_kontrak_yayasan_tidak_aktif'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="text-center">
                                <div class="flex flex-col justify-center items-center font-semibold">
                                    <div
                                        class="h-10 w-20 flex justify-center items-center text-white bg-primary rounded-t-md">
                                        {{ $item['total_guru_kontrak_yayasan'] }}</div>
                                    <div class="flex items-center justify-center">
                                        <div
                                            class="bg-green-600 flex flex-col w-10 h-10 items-center justify-center text-white rounded-bl-md">
                                            <p>{{ $item['total_guru_kontrak_yayasan_aktif'] }}</p>
                                        </div>
                                        <div
                                            class="bg-orange-600 flex flex-col w-10 h-10 items-center justify-center text-white rounded-br-md">
                                            <p>{{ $item['total_guru_kontrak_yayasan_tidak_aktif'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="text-center">
                                <div class="flex flex-col justify-center items-center font-semibold">
                                    <div
                                        class="h-10 w-20 flex justify-center items-center text-white bg-primary rounded-t-md">
                                        {{ $item['total_guru_honor_sekolah'] }}</div>
                                    <div class="flex items-center justify-center">
                                        <div
                                            class="bg-green-600 flex flex-col w-10 h-10 items-center justify-center text-white rounded-bl-md">
                                            <p>{{ $item['total_guru_honor_sekolah_aktif'] }}</p>
                                        </div>
                                        <div
                                            class="bg-orange-600 flex flex-col w-10 h-10 items-center justify-center text-white rounded-br-md">
                                            <p>{{ $item['total_guru_honor_sekolah_tidak_aktif'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="text-center">
                                <div class="flex flex-col justify-center items-center font-semibold">
                                    <div
                                        class="h-10 w-20 flex justify-center items-center text-white bg-primary rounded-t-md">
                                        {{ $item['total_tenaga_honor_sekolah'] }}</div>
                                    <div class="flex items-center justify-center">
                                        <div
                                            class="bg-green-600 flex flex-col w-10 h-10 items-center justify-center text-white rounded-bl-md">
                                            <p>{{ $item['total_tenaga_honor_sekolah_aktif'] }}</p>
                                        </div>
                                        <div
                                            class="bg-orange-600 flex flex-col w-10 h-10 items-center justify-center text-white rounded-br-md">
                                            <p>{{ $item['total_tenaga_honor_sekolah_tidak_aktif'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="text-center">
                                <div class="flex flex-col justify-center items-center font-semibold">
                                    <div
                                        class="h-10 w-20 flex justify-center items-center text-white bg-primary rounded-t-md">
                                        {{ $item['total_guru_tamu'] }}</div>
                                    <div class="flex items-center justify-center">
                                        <div
                                            class="bg-green-600 flex flex-col w-10 h-10 items-center justify-center text-white rounded-bl-md">
                                            <p>{{ $item['total_guru_tamu_aktif'] }}</p>
                                        </div>
                                        <div
                                            class="bg-orange-600 flex flex-col w-10 h-10 items-center justify-center text-white rounded-br-md">
                                            <p>{{ $item['total_guru_tamu_tidak_aktif'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
