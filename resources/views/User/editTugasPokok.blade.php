@extends('layouts.layout')
@section('content')
    <div class="w-full">

        @if (session('error'))
            <div role="alert" class="alert alert-error mb-8 text-white font-medium">
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <div class="w-full flex justify-center">
            <div class="w-[32rem] border shadow rounded-md p-10">
                <h1 class="text-center font-bold text-xl">EDIT TUGAS POKOK PEGAWAI</h1>
                <h1 class="text-center font-bold text-xl">{{ $dataUser['nickname'] }}</h1>

                <form method="POST" class="mt-6 w-full flex flex-col gap-3" enctype="multipart/form-data">
                    @csrf
                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">Tugas Pokok<span class="text-red-400">*</span></span>
                        </div>
                        <input required name="tugasPokok" value="{{ $tugasPokok['tugasPokok'] }}" type="text"
                            placeholder="Tugas Pokok" class="input input-bordered w-full" />
                        @error('tugasPokok')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">Nama AUM<span class="text-red-400">*</span></span>
                        </div>
                        <input required name="namaAUm" value="{{ $tugasPokok['namaAUm'] }}" type="text" placeholder="nama AUM"
                            class="input input-bordered w-full" />
                        @error('namaAUm')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">NPSN<span class="text-red-400">*</span></span>
                        </div>
                        <input name="nomerAum" value="{{ $tugasPokok['nomerAum'] }}" type="text" placeholder="xxxxxx"
                            class="input input-bordered w-full" />
                        @error('nomerAum')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">Nama Penanda Tangan SK<span
                                    class="text-red-400">*</span></span>
                        </div>
                        <input name="namaPenandatangan" value="{{ $tugasPokok['namaPenandatangan'] }}" type="text"
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
                        <input name="jabatanPenandatangan" value="{{ $tugasPokok['jabatanPenandatangan'] }}" type="text"
                            placeholder="Jabatan Penanda Tangan SK" class="input input-bordered w-full" />
                        @error('jabatanPenandatangan')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">Nomer SK<span class="text-red-400">*</span></span>
                        </div>
                        <input name="nomerSK" value="{{ $tugasPokok['nomerSK'] }}" type="text" placeholder="xxxxxx"
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
                        <input name="tanggalSK" value="{{ $tugasPokok['tanggalSK'] }}" type="date"
                            class="input input-bordered w-full" />
                        @error('tanggalSK')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">Dokumen SK</span>
                        </div>
                        <input type="file" name="buktisk" accept=".pdf"
                            class="file-input file-input-primary file-input-bordered w-full" />
                        @error('buktisk')
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
