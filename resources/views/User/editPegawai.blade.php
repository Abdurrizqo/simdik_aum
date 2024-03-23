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
                <h1 class="text-center font-bold text-xl">Edit Data Pegawai</h1>
                <h1 class="text-center font-bold text-xl">{{ $user['nickname'] }}</h1>

                <form method="POST" class="mt-6 w-full flex flex-col gap-3">
                    @csrf
                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">Nama Pegawai<span class="text-red-400">*</span></span>
                        </div>
                        <input required name="nickname" value="{{ $user['nickname'] }}" type="text"
                            placeholder="nama pegawai" class="input input-bordered w-full" />
                        @error('nickname')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">Username<span class="text-red-400">*</span></span>
                        </div>
                        <input required name="username" value="{{ $user['username'] }}" type="text" placeholder="xxxxx"
                            class="input input-bordered w-full" />
                        @error('username')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">Password</span>
                        </div>
                        <input name="password" type="password" placeholder="password" class="input input-bordered w-full" />
                        @error('password')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">Status Pegawai<span class="text-red-400">*</span></span>
                        </div>
                        <select required name="status" class="select select-bordered flex-1">
                            <option @if ($user['status'] === 'Pegawai Tetap Yayasan') selected @endif value="Pegawai Tetap Yayasan">Pegawai
                                Tetap Yayasan</option>
                            <option @if ($user['status'] === 'Guru Tetap Yayasan') selected @endif value="Guru Tetap Yayasan">Guru Tetap
                                Yayasan</option>
                            <option @if ($user['status'] === 'Pegawai Kontrak Yayasan') selected @endif value="Pegawai Kontrak Yayasan">
                                Pegawai Kontrak Yayasan</option>
                            <option @if ($user['status'] === 'Guru Kontrak Yayasan') selected @endif value="Guru Kontrak Yayasan">Guru
                                Kontrak Yayasan</option>
                            <option @if ($user['status'] === 'Guru Honor Sekolah') selected @endif value="Guru Honor Sekolah">Guru Honor
                                Sekolah</option>
                            <option @if ($user['status'] === 'Tenaga Honor Sekolah') selected @endif value="Tenaga Honor Sekolah">Tenaga
                                Honor Sekolah</option>
                            <option @if ($user['status'] === 'Guru Tamu') selected @endif value="Guru Tamu">Guru Tamu</option>
                        </select>
                        @error('status')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">Asal AUM<span class="text-red-400">*</span></span>
                        </div>
                        <select required name="idAum" class="select select-bordered flex-1">
                            @foreach ($aum as $item)
                                <option @if ($user['idAum'] === $item['idAum']) selected @endif value="{{ $item['idAum'] }}">
                                    {{ $item['namaAum'] }}</option>
                            @endforeach
                        </select>
                        @error('idAum')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">Status Aktif User<span
                                    class="text-red-400">*</span></span>
                        </div>

                        <p class="text-red-400 text-sm p-1">Perlu dipahami menonaktifkan form ini akan membuat akun pegawai
                            <span class="font-bold">tidak
                                dapat login</span> dan data
                            pegawai dipindahkan ke menu <span class="font-bold">Pegawai Non Aktif</span></p>
                            
                        <select required name="isActive" class="select select-bordered flex-1">
                            <option @if ($user['isActive'] === 1) selected @endif value="true">Aktif
                            </option>
                            <option @if ($user['isActive'] === 0) selected @endif value="false">Non Aktif
                            </option>
                        </select>
                        @error('isActive')
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
