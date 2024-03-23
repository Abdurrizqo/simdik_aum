@extends('layouts.userLayout')
@section('content')
    <div class="w-full">

        @if (session('error'))
            <div role="alert" class="alert alert-error mb-8 text-white font-medium">
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <div class="w-full flex justify-center">
            <div class="w-[32rem] border shadow rounded-md p-10">
                <h1 class="text-center font-bold text-xl">EDIT RIWAYAT PEKERJAAN</h1>

                <form method="POST" class="mt-6 w-full flex flex-col gap-3" enctype="multipart/form-data">
                    @csrf
                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">Nama AUM<span class="text-red-400">*</span></span>
                        </div>
                        <input required name="namaAum" value="{{ $riwayatPekerjaan['namaAum'] }}" type="text"
                            placeholder="nama AUM" class="input input-bordered w-full" />
                        @error('namaAum')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">NPSN<span class="text-red-400">*</span></span>
                        </div>
                        <input name="nomerAum" value="{{ $riwayatPekerjaan['nomerAum'] }}" type="text"
                            placeholder="xxxxxx" class="input input-bordered w-full" />
                        @error('nomerAum')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">Nama Penanda Tangan SK<span
                                    class="text-red-400">*</span></span>
                        </div>
                        <input name="namaPenandatangan" value="{{ $riwayatPekerjaan['namaPenandatangan'] }}" type="text"
                            placeholder="Nama Penanda Tangan SK" class="input input-bordered w-full" />
                        @error('namaPenandatangan')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">Jabatan Penanda Tangan SK<span
                                    class="text-red-400">*</span></span>
                        </div>
                        <input name="jabatanPenandaTangan" value="{{ $riwayatPekerjaan['jabatanPenandaTangan'] }}"
                            type="text" placeholder="Jabatan Penanda Tangan SK" class="input input-bordered w-full" />
                        @error('jabatanPenandaTangan')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">Nomer SK<span class="text-red-400">*</span></span>
                        </div>
                        <input name="nomerSK" value="{{ $riwayatPekerjaan['nomerSK'] }}" type="text" placeholder="xxxxxx"
                            class="input input-bordered w-full" />
                        @error('nomerSK')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">Tanggal Mulai SK<span
                                    class="text-red-400">*</span></span>
                        </div>
                        <input name="tanggalSK" value="{{ $riwayatPekerjaan['tanggalSK'] }}" type="date"
                            class="input input-bordered w-full" />
                        @error('tanggalSK')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">Lama Pelaksanaan SK Dalam Bulan<span
                                    class="text-red-400">*</span></span>
                        </div>
                        <input name="masaKerjaDalamBulan" value="{{ $riwayatPekerjaan['masaKerjaDalamBulan'] }}"
                            type="number" placeholder="0" min="1" max="1000"
                            class="input input-bordered w-full" />
                        @error('masaKerjaDalamBulan')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">Dokumen SK<span class="text-red-400">*</span></span>
                        </div>
                        <input type="file" name="buktiSK" accept=".pdf"
                            class="file-input file-input-primary file-input-bordered w-full" />
                        @error('buktiSK')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <div class="mt-10 w-full flex justify-end">
                        <button class="btn btn-primary w-40" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
