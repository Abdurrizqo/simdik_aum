@extends('layouts.userLayout')
@section('content')
    <div class="w-full">

        @if (session('error'))
            <div role="alert" class="alert alert-error mb-8 text-white font-medium">
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <div class="w-full flex justify-center">
            <div class="w-[40rem] bg-white border rounded-md shadow-md p-4">
                <h1 class="text-center text-lg font-semibold">EDIT BIODATA PRIBADI</h1>

                <form method="POST" class="mt-10" enctype="multipart/form-data">
                    @csrf
                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold text-lg">Nama Lengkap Beserta Gelar<span
                                    class="text-red-400">*</span></span>
                        </div>
                        <input required name="namaLengkap" value="{{ $profile['namaLengkap'] }}" type="text"
                            placeholder="nama lengkap" class="input input-bordered w-full" />
                        @error('namaLengkap')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <div class="grid grid-cols-2 gap-6 mt-6">
                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text font-semibold">NIPY</span>
                            </div>
                            <input required name="nipy" value="{{ $profile['nipy'] }}" type="text" placeholder="xxxxx"
                                class="input input-bordered w-full" />
                            @error('nipy')
                                <p class="text-xs text-red-400">*{{ $message }}</p>
                            @enderror
                        </label>

                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text font-semibold">KTAM</span>
                            </div>
                            <input required name="noKTAM" value="{{ $profile['noKTAM'] }}" type="text"
                                placeholder="xxxxx" class="input input-bordered w-full" />
                            @error('noKTAM')
                                <p class="text-xs text-red-400">*{{ $message }}</p>
                            @enderror
                        </label>
                    </div>

                    <div class="grid grid-cols-2 gap-6 mt-6">
                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text font-semibold">Tempat Lahir<span
                                        class="text-red-400">*</span></span>
                            </div>
                            <input required name="tempatLahir" value="{{ $profile['tempatLahir'] }}" type="text"
                                placeholder="tempat lahir" class="input input-bordered w-full" />
                            @error('tempatLahir')
                                <p class="text-xs text-red-400">*{{ $message }}</p>
                            @enderror
                        </label>

                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text font-semibold">Tanggal Lahir<span
                                        class="text-red-400">*</span></span>
                            </div>
                            <input required name="tanggalLahir" value="{{ $profile['tanggalLahir'] }}" type="date"
                                class="input input-bordered w-full" />
                            @error('tanggalLahir')
                                <p class="text-xs text-red-400">*{{ $message }}</p>
                            @enderror
                        </label>
                    </div>

                    <label class="form-control w-full mt-6">
                        <div class="label">
                            <span class="label-text font-semibold text-lg">Status Perkawinan<span
                                    class="text-red-400">*</span></span>
                        </div>
                        <select required name="isMarried" class="select select-bordered w-full">
                            <option>Status Perkawinan</option>
                            <option @if ($profile['isMarried'] === 1) selected @endif class="true">Sudah Kawin</option>
                            <option @if ($profile['isMarried'] === 0) selected @endif class="false">belum Kawin</option>
                        </select>
                        @error('isMarried')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full mt-6">
                        <div class="label">
                            <span class="label-text font-semibold text-lg">Alamat<span class="text-red-400">*</span></span>
                        </div>
                        <textarea name="alamat" class="textarea textarea-bordered h-28" placeholder="Alamat">{{ $profile['alamat'] }}</textarea>

                        @error('alamat')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full mt-6">
                        <div class="label">
                            <span class="label-text font-semibold text-lg">Foto Profile</span>
                        </div>
                        <input type="file" accept="image/*" name="fotoProfile"
                            class="file-input file-input-primary file-input-bordered w-full" />

                        @error('fotoProfile')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <button class="btn btn-primary w-full mt-10">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection
