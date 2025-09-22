@extends('frontend.layouts.master')

@section('content')
    <div class="h-screen w-full flex items-center justify-center">
        <div class="w-full min-w-full sm:min-w-sm sm:max-w-sm flex flex-col items-center justify-center px-4">
            <a href="{{ route('login') }}">
                <div class="w-full flex flex-col gap-2 border border-slate-300 rounded-lg px-8 py-4 shadow-lg">
                    <div class="avatar">
                        <div class="size-28 sm:size-32 md:size-36 lg:size-40 mx-auto rounded-full border border-slate-400">
                            <img src="{{ asset('img/logo.png') }}" alt="Logo" />
                        </div>
                    </div>
                    <hr class="w-[50%] mx-auto border-t-2 my-2" />
                    <h1 class="w-full text-xs md:text-sm lg:text-base text-center font-semibold">
                        Aplikasi Permohonan Verifikasi Produk Hukum
                    </h1>
                </div>
            </a>
        </div>
    </div>
@endsection
