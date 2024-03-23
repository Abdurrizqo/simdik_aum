<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons" rel="stylesheet">
    @vite('resources/css/app.css')
    <title>Document</title>
</head>

<body class="flex flex-col relative">
    <div class="navbar h-20 border-b shadow-md fixed z-40 bg-white text-primary">
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

    <div class="navbar h-20"></div>

    <div class="flex">
        <div
            class="w-48 text-lg lg:w-60 font-medium bg-white text-primary shadow-md border-r-2 h-screen fixed px-3 pt-4 flex flex-col gap4">
            <a href="/home" class="hover:bg-secondary/30 px-2 py-4 rounded-md cursor-pointer mt-2">Profil</a>
            <a href="/home/riwayat-pendidikan-formal"
                class="hover:bg-secondary/30 p-2 py-4 rounded-md cursor-pointer">Riwayat Pendidikan
                Formal</a>
            <a href="/home/riwayat-pendidikan-non-formal"
                class="hover:bg-secondary/30 p-2 py-4 rounded-md cursor-pointer">Riwayat Pendidikan Non Formal</a>
            <a href="/home/riwayat-pekerjaan"
                class="hover:bg-secondary/30 p-2 py-4 rounded-md cursor-pointer mt-2">Riwayat
                Pekerjaan</a>
        </div>

        <div class="w-48 lg:w-60"></div>
        <div class="p-6 flex-1 overflow-auto">
            @yield('content')
        </div>
    </div>
</body>

</html>
