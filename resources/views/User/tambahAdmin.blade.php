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
                <h1 class="text-center font-bold text-xl">Tambah Data Admin</h1>

                <form method="POST" class="mt-6 w-full flex flex-col gap-3">
                    @csrf
                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">Nama Admin</span>
                        </div>
                        <input required name="nickname" value="{{ old('nickname') }}" type="text"
                            placeholder="nama pegawai" class="input input-bordered w-full" />
                        @error('nickname')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">Username</span>
                        </div>
                        <input required name="username" value="{{ old('username') }}" type="text" placeholder="xxxxx"
                            class="input input-bordered w-full" />
                        @error('username')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">Password</span>
                        </div>
                        <input required name="password" value="{{ old('password') }}" type="password" placeholder="password"
                            class="input input-bordered w-full" />
                        @error('password')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">Asal AUM</span>
                        </div>
                        <select required name="idAum" class="select select-bordered flex-1">
                            @foreach ($aum as $item)
                                <option value="{{ $item['idAum'] }}">{{ $item['namaAum'] }}</option>
                            @endforeach
                        </select>
                        @error('idAum')
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
