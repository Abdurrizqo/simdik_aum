<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons" rel="stylesheet">
    @vite('resources/css/app.css')
    <title>Document</title>
</head>

<body class="flex flex-col relative">
    <div class="navbar shadow fixed z-40 bg-white text-primary">
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
                    <li class="font-medium py-2 btn-cus"><a href="/logout">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>


    <div class="navbar"></div>

    <div class="flex">
        <div
            class="w-48 lg:w-60 bg-secondary text-white shadow-md border-r h-screen fixed px-3 pt-4 flex flex-col gap-8">
            <div class="flex flex-col">
                <h1 class="font-bold">Data Kepegawain</h1>
                <a href="/dashboard" class="hover:bg-primary mr-8 p-2 rounded-md cursor-pointer mt-2">Daftar Pegawai</a>

                @auth
                    @if (Auth::user()->role === 'admin')
                        <a href="/dashboard/daftar-admin" class="hover:bg-primary mr-8 p-2 rounded-md cursor-pointer">Daftar
                            Admin</a>
                    @endif
                @endauth

                <a href="/dashboard/daftar-pegawai-non-aktif"
                    class="hover:bg-primary mr-8 p-2 rounded-md cursor-pointer">Daftar
                    Pegawai Non Aktif</a>
            </div>

            <div class="flex flex-col">
                <h1 class="font-bold">Master Data</h1>
                @auth
                    @if (Auth::user()->role === 'admin')
                        <a href="/dashboard/daftar-aum"
                            class="hover:bg-primary mr-8 p-2 rounded-md cursor-pointer mt-2">Daftar
                            AUM</a>
                    @endif
                @endauth

                <a href="/dashboard/jumlah-pegawai" class="hover:bg-primary mr-8 p-2 rounded-md cursor-pointer">Jumlah
                    Pegawai</a>

                <a href="/dashboard/export-data" class="hover:bg-primary mr-8 p-2 rounded-md cursor-pointer mt-2">Export
                    Data</a>
            </div>

        </div>

        <div class="w-48 lg:w-60"></div>
        <div class="p-6 flex-1 overflow-auto">
            @yield('content')
        </div>
    </div>
</body>

</html>
