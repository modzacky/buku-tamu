@php
    $labelSumber = [
        'direct' => 'Kunjungan Langsung',
        'whatsapp' => 'Dari WhatsApp',
        'instagram' => 'Dari Instagram',
        'facebook' => 'Dari Facebook',
    ];
@endphp

@extends('layouts.app')

@section('title', 'Form Buku Tamu')

@section('body')
    <header class="bg-blue-900 text-white">
        <div class="mx-auto flex max-w-3xl items-center justify-between px-4 py-4">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-white/10 text-lg font-bold">BPS</div>
                <div>
                    <p class="font-semibold leading-tight">Buku Tamu Digital</p>
                    <p class="text-sm text-blue-200">BPS Kota Bukittinggi</p>
                </div>
            </div>
            <a href="{{ route('login') }}" class="rounded-lg border border-white/30 px-4 py-2 text-sm font-medium transition hover:bg-white/10">
                Login Admin
            </a>
        </div>
    </header>

    <main class="mx-auto max-w-3xl px-4 py-8">
        @if (session('sukses'))
            <div class="mb-6 rounded-xl border border-green-200 bg-green-50 p-5 text-green-800">
                <p class="flex items-start gap-2 font-medium">
                    <span class="mt-0.5">✅</span>
                    <span>{{ session('sukses') }}</span>
                </p>
                <p class="mt-1 text-sm text-green-700">
                    Data Anda telah tercatat{{ isset($sumber) ? ' sebagai ' . ($labelSumber[$sumber] ?? $sumber) : '' }}.
                </p>
            </div>
        @endif

        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 p-6">
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <div>
                        <h1 class="text-xl font-bold text-slate-900">Silakan Isi Buku Tamu</h1>
                        <p class="mt-1 text-sm text-slate-600">Data kunjungan Anda membantu kami meningkatkan pelayanan.</p>
                    </div>
                    @isset($sumber)
                        <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-800 ring-1 ring-blue-200">
                            {{ $labelSumber[$sumber] ?? $sumber }}
                        </span>
                    @endisset
                </div>
            </div>

            <form method="POST" action="{{ route('guest.store') }}" class="grid gap-5 p-6 sm:grid-cols-2">
                @csrf
                <input type="hidden" name="sumber" value="{{ $sumber ?? 'direct' }}">

                <div class="sm:col-span-2">
                    <label for="nama" class="mb-1 block text-sm font-medium text-slate-700">Nama Lengkap <span class="text-red-600">*</span></label>
                    <input id="nama" type="text" name="nama" value="{{ old('nama') }}" required maxlength="100"
                           placeholder="Contoh: Andi Pratama"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                    @error('nama')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="nomor_hp" class="mb-1 block text-sm font-medium text-slate-700">Nomor HP <span class="text-red-600">*</span></label>
                    <input id="nomor_hp" type="tel" name="nomor_hp" value="{{ old('nomor_hp') }}" required maxlength="20"
                           placeholder="Contoh: 08123456789"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                    @error('nomor_hp')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="email" class="mb-1 block text-sm font-medium text-slate-700">Email <span class="text-red-600">*</span></label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required maxlength="100"
                           placeholder="Contoh: nama@email.com"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                    @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="instansi" class="mb-1 block text-sm font-medium text-slate-700">Instansi <span class="text-red-600">*</span></label>
                    <input id="instansi" type="text" name="instansi" value="{{ old('instansi') }}" required maxlength="150"
                           placeholder="Contoh: Universitas Andalas"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                    @error('instansi')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="tujuan_kunjungan" class="mb-1 block text-sm font-medium text-slate-700">Tujuan Kunjungan <span class="text-red-600">*</span></label>
                    <textarea id="tujuan_kunjungan" name="tujuan_kunjungan" required maxlength="255" rows="3"
                              placeholder="Jelaskan singkat keperluan kunjungan Anda"
                              class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200">{{ old('tujuan_kunjungan') }}</textarea>
                    @error('tujuan_kunjungan')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="tanggal_kunjungan" class="mb-1 block text-sm font-medium text-slate-700">Tanggal Kunjungan <span class="text-red-600">*</span></label>
                    <input id="tanggal_kunjungan" type="date" name="tanggal_kunjungan" value="{{ old('tanggal_kunjungan', now()->toDateString()) }}" required max="{{ now()->toDateString() }}"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                    @error('tanggal_kunjungan')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="flex items-end sm:col-span-2">
                    <button type="submit"
                            class="w-full rounded-lg bg-blue-800 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 sm:w-auto">
                        Simpan Data Kunjungan
                    </button>
                </div>
            </form>
        </div>

        <p class="mt-6 text-center text-xs text-slate-500">
            © {{ date('Y') }} Badan Pusat Statistik Kota Bukittinggi
        </p>
    </main>
@endsection
