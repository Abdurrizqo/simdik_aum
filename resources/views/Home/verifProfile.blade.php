<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>

<body class="w-full">
    <div class="navbar h-20 border-b shadow-md bg-white text-primary">
        <div class="flex-1 flex gap-4 items-center cursor-default">
            <img src="{{ asset('images/logo.png') }}" alt="Avatar" alt="logo" class="w-12" />
            <h1 class="md:block hidden font-bold text-xl">SIMDIK AUM KUTIM</h1>
        </div>
        <div class=" flex gap-6 justify-between items-center">
            <div class="dropdown dropdown-end">
                @auth
                    <p class="text-lg font-semibold"><span class="text-gray-400">Halo,</span> {{ Auth::user()->nickname }}
                    </p>
                @endauth
            </div>

            <div class="dropdown dropdown-end">
                <button class="btn-cus border text-primary rounded-md px-4 py-2 hover:bg-secondary hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        class="w-5 h-5 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z">
                        </path>
                    </svg>
                </button>
                <ul tabindex="0"
                    class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow border bg-base-100 rounded-box w-52">
                    <li class="font-medium py-2 btn-cus"><a href="/home/ganti-password">Ganti Password</a></li>
                    <li class="font-medium py-2 btn-cus"><a href="/logout">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>

    @if (session('error'))
        <div role="alert" class="alert alert-error mb-8 text-white font-medium">
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="flex justify-center p-10">
        <div class="w-[40rem] bg-white border rounded-md shadow-md p-4">
            <h1 class="text-center text-lg font-semibold">BIODATA PRIBADI</h1>

            <form method="POST" class="mt-10" enctype="multipart/form-data">
                @csrf
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text font-semibold text-lg">Nama Lengkap Beserta Gelar<span
                                class="text-red-400">*</span></span>
                    </div>
                    <input required name="namaLengkap" value="{{ old('namaLengkap') }}" type="text"
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
                        <input required name="nipy" value="{{ old('nipy') }}" type="text" placeholder="xxxxx"
                            class="input input-bordered w-full" />
                        @error('nipy')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">KTAM</span>
                        </div>
                        <input required name="noKTAM" value="{{ old('ktam') }}" type="text" placeholder="xxxxx"
                            class="input input-bordered w-full" />
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
                        <input required name="tempatLahir" value="{{ old('tempatLahir') }}" type="text"
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
                        <input required name="tanggalLahir" value="{{ old('tanggalLahir') }}" type="date"
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
                        <option class="true">Sudah Kawin</option>
                        <option class="false">belum Kawin</option>
                    </select>
                    @error('isMarried')
                        <p class="text-xs text-red-400">*{{ $message }}</p>
                    @enderror
                </label>

                <label class="form-control w-full mt-6">
                    <div class="label">
                        <span class="label-text font-semibold text-lg">Alamat<span class="text-red-400">*</span></span>
                    </div>
                    <textarea name="alamat" class="textarea textarea-bordered h-28" placeholder="Alamat">
                    {{ old('alamat') }}
                </textarea>

                    @error('alamat')
                        <p class="text-xs text-red-400">*{{ $message }}</p>
                    @enderror
                </label>

                <label class="form-control w-full mt-6">
                    <div class="label">
                        <span class="label-text font-semibold text-lg">Foto Profile<span
                                class="text-red-400">*</span></span>
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
</body>

</html>
