@extends('admin.layout', ['title' => 'Dashboard'])
@section('content')
    @include('admin.components.menu')
    <main class="flex flex-col items-center justify-center gap-4 mt-4">
        <div class="lg:w-1/2 p-2">
            <div class="title">
                <div class="flex flex-row gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z" />
                    </svg>
                    <h1 class="font-bold">Statistik Arsip Surat</h1>
                </div>  
            </div>
            <div class="statistik grid grid-cols-1 sm:grid-cols-2 gap-2 mt-4">
                <div class="bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                    <div class="flex justify-between items-center">
                        <img src="{{ asset('image/file.png') }}" alt="PDF Icon" class="w-10 h-10">
                        <div>
                            <h5 class="leading-none text-3xl font-bold text-gray-900 dark:text-white pb-2">
                                {{ $pdf }} PDF</h5>
                            <p class="text-base font-normal text-gray-500 dark:text-gray-400">Total PDF Files</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                    <div class="flex justify-between items-center">
                        <img src="{{ asset('image/xls.png') }}" alt="Excel Icon" class="w-10 h-10">
                        <div>
                            <h5 class="leading-none text-3xl font-bold text-gray-900 dark:text-white pb-2">
                                {{ $xls }} Excel</h5>
                            <p class="text-base font-normal text-gray-500 dark:text-gray-400">Total Excel Files</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                    <div class="flex justify-between items-center">
                        <img src="{{ asset('image/docx-file.png') }}" alt="DOCX Icon" class="w-10 h-10">
                        <div>
                            <h5 class="leading-none text-3xl font-bold text-gray-900 dark:text-white pb-2">
                                {{$doc}} DOCX</h5>
                            <p class="text-base font-normal text-gray-500 dark:text-gray-400">Total DOCX Files</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                    <div class="flex justify-between items-center">
                        <img src="{{ asset('image/pptx.png') }}" alt="PPTX Icon" class="w-10 h-10">
                        <div>
                            <h5 class="leading-none text-3xl font-bold text-gray-900 dark:text-white pb-2">
                                {{ $pptx}} PPTX</h5>
                            <p class="text-base font-normal text-gray-500 dark:text-gray-400">Total PPTX Files</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="statistik grid grid-cols-2 gap-2 mt-4">
                <div class=" bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                    <div class="flex justify-between">
                        <div>
                            <h5 class="leading-none text-3xl font-bold text-gray-900 dark:text-white pb-2">
                                {{ $data_bulan_ini }} Surat</h5>
                            <p class="text-base font-normal text-gray-500 dark:text-gray-400">Arsip Surat Bulan Ini</p>
                        </div>
                    </div>
                </div>
                <div class=" bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                    <div class="flex justify-between">
                        <div>
                            <h5 class="leading-none text-3xl font-bold text-gray-900 dark:text-white pb-2">
                                {{ $total_arsip }} Surat</h5>
                            <p class="text-base font-normal text-gray-500 dark:text-gray-400">Total Di Arsipkan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
