<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.png') }}">
    @vite('resources/css/app.css')
    <title>SIMDIK AUM KUTIM</title>
</head>

<body>
    <div class="flex justify-center items-center h-screen w-screen">
        <div
            class="border rounded bg-white px-8 py-20 w-[24rem] md:w-[44rem] lg:w-[52rem] mx-4 flex justify-center gap-20">
            <div class="hidden md:flex md:flex-col justify-center items-center flex-1">
                <img src="{{ asset('images/logo.png') }}" alt="Avatar" alt="logo" class="w-40" />
                <p class="text-center">
                    Majelis Pendidikan Dasar Menengah dan Pendidikan Non Formal
                </p>

                <h1 class="text-xl font-bold mt-16">PDM Kutai Timur</h1>
            </div>

            <div class="flex-1">
                <h1 class="text-center text-xl font-bold text-primary-color">
                    LOGIN SIMDIK
                </h1>

                <p class="text-center mt-2 text-secondary">
                    Masukan Detail Akun Untuk Login
                </p>

                <form class="flex flex-col gap-4 mt-8" method="POST">
                    @csrf
                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text text-secondary font-semibold">Username</span>
                        </div>
                        <input name="username" type="text" placeholder="username"
                            class="input input-bordered w-full" />
                        @error('username')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text text-secondary font-semibold">Password</span>
                        </div>
                        <input name="password" type="password" placeholder="password"
                            class="input input-bordered w-full" />
                        @error('password')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <div class="w-full flex justify-end">
                        <input type="submit" value="Login"
                            class="btn btn-secondary rounded outline-none py-1 px-2 text-white w-32 cursor-pointer" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
