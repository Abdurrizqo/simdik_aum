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
                <h1 class="text-center font-bold text-xl">TAMBAH DATA RIWAYAT PENDIDIKAN FORMAL</h1>

                <form method="POST" class="mt-6 w-full flex flex-col gap-3" enctype="multipart/form-data">
                    @csrf
                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">Lembaga Pendidikan<span
                                    class="text-red-400">*</span></span>
                        </div>
                        <input required name="lembagaPendidikan" value="{{ old('lembagaPendidikan') }}" type="text"
                            placeholder="asal lembaga pendidikan" class="input input-bordered w-full" />
                        @error('lembagaPendidikan')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">Fakultas</span>
                        </div>
                        <input name="fakultas" value="{{ old('fakultas') }}" type="text" placeholder="fakultas"
                            class="input input-bordered w-full" />
                        @error('fakultas')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">Jurusan / Program Studi</span>
                        </div>
                        <input name="jurusanProgStud" value="{{ old('jurusanProgStud') }}" type="text"
                            placeholder="Jurusan / Program Studi" class="input input-bordered w-full" />
                        @error('jurusanProgStud')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">Tahun Lulus<span class="text-red-400">*</span></span>
                        </div>
                        <input required name="tahunLulus" value="{{ old('tahunLulus') }}" type="number" min="1920"
                            max="2100" placeholder="0000" class="input input-bordered w-full" />
                        @error('tahunLulus')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">Dokumen Ijazah<span class="text-red-400">*</span></span>
                        </div>
                        <input required type="file" name="ijazah" accept=".pdf"
                            class="file-input file-input-primary file-input-bordered w-full" />
                        @error('ijazah')
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
