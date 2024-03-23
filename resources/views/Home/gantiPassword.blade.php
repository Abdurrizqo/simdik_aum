@extends('layouts.userLayout')
@section('content')
    <div class="w-full">

        @if (session('error'))
            <div role="alert" class="alert alert-error mb-8 text-white font-medium">
                <span>{{ session('error') }}</span>
            </div>
        @endif
        
        <div class="w-full flex justify-center">

            <div class="w-[20rem] md:w-[28rem] lg:w-[32rem] border shadow rounded-md p-5 md:p-8 lg:p-10 mt-10">
                <h1 class="text-center font-bold text-xl">FORM GANTI PASSWORD</h1>

                <form class="flex flex-col gap-4 mt-8" method="POST">
                    @csrf
                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text text-secondary font-semibold">Username</span>
                        </div>
                        <input name="username" type="text" placeholder="username" class="input input-bordered w-full" />
                        @error('username')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text text-secondary font-semibold">Password</span>
                        </div>
                        <input name="password" type="password" placeholder="password" class="input input-bordered w-full" />
                        @error('password')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text text-secondary font-semibold">Password Baru</span>
                        </div>
                        <input name="passwordBaru" type="password" placeholder="password baru"
                            class="input input-bordered w-full" />
                        @error('passwordBaru')
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
@endsection
