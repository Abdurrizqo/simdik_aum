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
                <h1 class="text-center font-bold text-xl">EDIT DATA RIWAYAT PENDIDIKAN NON FORMAL</h1>

                <form method="POST" class="mt-6 w-full flex flex-col gap-3" enctype="multipart/form-data">
                    @csrf
                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">Lembaga Penyelenggara<span
                                    class="text-red-400">*</span></span>
                        </div>
                        <input required name="lembagaPenyelenggara"
                            value="{{ $riwayatPendidikanNonFormal['lembagaPenyelenggara'] }}" type="text"
                            placeholder="asal lembaga penyelenggara" class="input input-bordered w-full" />
                        @error('lembagaPenyelenggara')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">Jenis Diklat<span class="text-red-400">*</span></span>
                        </div>
                        <input name="jenisDiklat" value="{{ $riwayatPendidikanNonFormal['jenisDiklat'] }}" type="text"
                            placeholder="jenis diklat" class="input input-bordered w-full" />
                        @error('jenisDiklat')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">Tingkat<span class="text-red-400">*</span></span>
                        </div>
                        <input name="tingkat" value="{{ $riwayatPendidikanNonFormal['tingkat'] }}" type="text"
                            placeholder="tingkat" class="input input-bordered w-full" />
                        @error('tingkat')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">Tahun Lulus<span class="text-red-400">*</span></span>
                        </div>
                        <input required name="tahunLulus" value="{{ $riwayatPendidikanNonFormal['tahunLulus'] }}"
                            type="number" min="1920" max="2100" placeholder="0000"
                            class="input input-bordered w-full" />
                        @error('tahunLulus')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">Dokumen Sertifikat<span
                                    class="text-red-400">*</span></span>
                        </div>
                        <input type="file" name="sertifikat" accept=".pdf"
                            class="file-input file-input-primary file-input-bordered w-full" />
                        @error('sertifikat')
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
