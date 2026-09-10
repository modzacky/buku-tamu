@php
    $labelSumber = [
        'direct' => 'Langsung',
        'whatsapp' => 'WhatsApp',
        'instagram' => 'Instagram',
        'facebook' => 'Facebook',
    ];
    $warnaSumber = [
        'direct' => 'bg-slate-100 text-slate-700 ring-slate-200',
        'whatsapp' => 'bg-green-50 text-green-700 ring-green-200',
        'instagram' => 'bg-pink-50 text-pink-700 ring-pink-200',
        'facebook' => 'bg-blue-50 text-blue-700 ring-blue-200',
    ];
@endphp

@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('body')
    <div class="flex min-h-screen">
        <aside class="hidden w-60 shrink-0 flex-col bg-blue-900 p-4 text-blue-100 md:flex">
            <div class="mb-6 flex items-center gap-2 px-2">
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/10 text-sm font-bold text-white">BPS</div>
                <div>
                    <p class="text-sm font-semibold leading-tight text-white">Buku Tamu</p>
                    <p class="text-xs">BPS Kota Bukittinggi</p>
                </div>
            </div>
            <nav class="space-y-1 text-sm">
                <a href="{{ route('admin.dashboard') }}" class="block rounded-lg bg-white/10 px-3 py-2 font-medium text-white">Dashboard</a>
                <a href="{{ route('admin.guests.index') }}" class="block rounded-lg px-3 py-2 transition hover:bg-white/10">Data Tamu</a>
                <a href="{{ route('guest.form') }}" target="_blank" class="block rounded-lg px-3 py-2 transition hover:bg-white/10">Buka Form Tamu ↗</a>
            </nav>
            <form method="POST" action="{{ route('logout') }}" class="mt-auto">
                @csrf
                <button type="submit" class="w-full rounded-lg px-3 py-2 text-left text-sm transition hover:bg-white/10">Keluar</button>
            </form>
        </aside>

        <div class="flex-1">
            <header class="border-b border-slate-200 bg-white px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-lg font-bold text-slate-900">Dashboard</h1>
                        <p class="text-sm text-slate-600">Ringkasan kunjungan tamu</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="hidden text-sm text-slate-600 sm:block">{{ auth()->user()->name }}</span>
                        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-blue-100 text-sm font-semibold text-blue-800">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    </div>
                </div>
                <nav class="mt-3 flex gap-2 md:hidden">
                    <a href="{{ route('admin.dashboard') }}" class="rounded-lg bg-blue-800 px-3 py-1.5 text-xs font-medium text-white">Dashboard</a>
                    <a href="{{ route('admin.guests.index') }}" class="rounded-lg bg-slate-200 px-3 py-1.5 text-xs font-medium text-slate-700">Data Tamu</a>
                    <form method="POST" action="{{ route('logout') }}" class="ml-auto">
                        @csrf
                        <button type="submit" class="rounded-lg bg-slate-200 px-3 py-1.5 text-xs font-medium text-slate-700">Keluar</button>
                    </form>
                </nav>
            </header>

            <main class="space-y-6 p-6">
                @if (session('sukses'))
                    <div class="rounded-xl border border-green-200 bg-green-50 p-4 text-sm font-medium text-green-800">
                        ✅ {{ session('sukses') }}
                    </div>
                @endif

                <div class="grid gap-4 sm:grid-cols-3">
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <p class="text-sm text-slate-600">Tamu Bulan Ini</p>
                        <p class="mt-2 text-3xl font-bold text-blue-800">{{ $tamuBulanIni }}</p>
                        <p class="mt-1 text-xs text-slate-500">{{ now()->translatedFormat('F Y') }}</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <p class="text-sm text-slate-600">Total Seluruh Tamu</p>
                        <p class="mt-2 text-3xl font-bold text-slate-900">{{ $totalTamu }}</p>
                        <p class="mt-1 text-xs text-slate-500">Sejak aplikasi digunakan</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <p class="mb-3 text-sm text-slate-600">Rekap Sumber Kunjungan</p>
                        <ul class="space-y-2 text-sm">
                            @foreach ($rekapSumber as $sumber => $jumlah)
                                <li class="flex items-center justify-between">
                                    <span class="rounded-full px-2 py-0.5 text-xs font-medium ring-1 {{ $warnaSumber[$sumber] }}">
                                        {{ $labelSumber[$sumber] }}
                                    </span>
                                    <span class="font-semibold text-slate-800">{{ $jumlah }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
                        <h2 class="font-semibold text-slate-900">Kunjungan Terbaru</h2>
                        <a href="{{ route('admin.guests.index') }}" class="text-sm font-medium text-blue-700 hover:underline">Lihat semua →</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-slate-50 text-left text-xs uppercase tracking-wide text-slate-500">
                                <tr>
                                    <th class="px-5 py-3 font-medium">Nama</th>
                                    <th class="px-5 py-3 font-medium">Instansi</th>
                                    <th class="hidden px-5 py-3 font-medium sm:table-cell">Sumber</th>
                                    <th class="px-5 py-3 font-medium">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse ($kunjunganTerbaru as $tamu)
                                    <tr>
                                        <td class="px-5 py-3 font-medium text-slate-800">{{ $tamu->nama }}</td>
                                        <td class="px-5 py-3 text-slate-600">{{ $tamu->instansi }}</td>
                                        <td class="hidden px-5 py-3 sm:table-cell">
                                            <span class="rounded-full px-2 py-0.5 text-xs font-medium ring-1 {{ $warnaSumber[$tamu->sumber] }}">
                                                {{ $labelSumber[$tamu->sumber] }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-3 text-slate-600">{{ $tamu->tanggal_kunjungan->translatedFormat('d M Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-5 py-8 text-center text-slate-500">Belum ada kunjungan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection
