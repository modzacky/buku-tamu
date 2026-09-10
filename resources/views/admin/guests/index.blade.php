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

@section('title', 'Data Tamu')

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
                <a href="{{ route('admin.dashboard') }}" class="block rounded-lg px-3 py-2 transition hover:bg-white/10">Dashboard</a>
                <a href="{{ route('admin.guests.index') }}" class="block rounded-lg bg-white/10 px-3 py-2 font-medium text-white">Data Tamu</a>
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
                        <h1 class="text-lg font-bold text-slate-900">Data Tamu</h1>
                        <p class="text-sm text-slate-600">Daftar seluruh kunjungan tamu</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="hidden text-sm text-slate-600 sm:block">{{ auth()->user()->name }}</span>
                        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-blue-100 text-sm font-semibold text-blue-800">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    </div>
                </div>
                <nav class="mt-3 flex gap-2 md:hidden">
                    <a href="{{ route('admin.dashboard') }}" class="rounded-lg bg-slate-200 px-3 py-1.5 text-xs font-medium text-slate-700">Dashboard</a>
                    <a href="{{ route('admin.guests.index') }}" class="rounded-lg bg-blue-800 px-3 py-1.5 text-xs font-medium text-white">Data Tamu</a>
                    <form method="POST" action="{{ route('logout') }}" class="ml-auto">
                        @csrf
                        <button type="submit" class="rounded-lg bg-slate-200 px-3 py-1.5 text-xs font-medium text-slate-700">Keluar</button>
                    </form>
                </nav>
            </header>

            <main class="space-y-4 p-6">
                @if (session('sukses'))
                    <div class="rounded-xl border border-green-200 bg-green-50 p-4 text-sm font-medium text-green-800">
                        ✅ {{ session('sukses') }}
                    </div>
                @endif

                <form method="GET" action="{{ route('admin.guests.index') }}" class="flex max-w-md gap-2">
                    <input type="search" name="q" value="{{ $keyword }}" placeholder="Cari tamu berdasarkan nama..."
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                    <button type="submit" class="rounded-lg bg-blue-800 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-900">
                        Cari
                    </button>
                    @if ($keyword !== '')
                        <a href="{{ route('admin.guests.index') }}" class="rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-600 transition hover:bg-slate-50">Reset</a>
                    @endif
                </form>

                <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-slate-50 text-left text-xs uppercase tracking-wide text-slate-500">
                                <tr>
                                    <th class="px-5 py-3 font-medium">Nama</th>
                                    <th class="hidden px-5 py-3 font-medium sm:table-cell">Kontak</th>
                                    <th class="hidden px-5 py-3 font-medium lg:table-cell">Instansi</th>
                                    <th class="hidden px-5 py-3 font-medium xl:table-cell">Tujuan</th>
                                    <th class="px-5 py-3 font-medium">Sumber</th>
                                    <th class="px-5 py-3 font-medium">Tanggal</th>
                                    <th class="px-5 py-3 text-right font-medium">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse ($guests as $tamu)
                                    <tr>
                                        <td class="px-5 py-3">
                                            <p class="font-medium text-slate-800">{{ $tamu->nama }}</p>
                                            <p class="text-xs text-slate-500 sm:hidden">{{ $tamu->nomor_hp }}</p>
                                        </td>
                                        <td class="hidden px-5 py-3 text-slate-600 sm:table-cell">
                                            <p>{{ $tamu->nomor_hp }}</p>
                                            <p class="text-xs text-slate-500">{{ $tamu->email }}</p>
                                        </td>
                                        <td class="hidden px-5 py-3 text-slate-600 lg:table-cell">{{ $tamu->instansi }}</td>
                                        <td class="hidden max-w-[220px] truncate px-5 py-3 text-slate-600 xl:table-cell" title="{{ $tamu->tujuan_kunjungan }}">{{ $tamu->tujuan_kunjungan }}</td>
                                        <td class="px-5 py-3">
                                            <span class="rounded-full px-2 py-0.5 text-xs font-medium ring-1 {{ $warnaSumber[$tamu->sumber] }}">
                                                {{ $labelSumber[$tamu->sumber] }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-3 text-slate-600">{{ $tamu->tanggal_kunjungan->translatedFormat('d M Y') }}</td>
                                        <td class="px-5 py-3">
                                            <div class="flex justify-end gap-2">
                                                <a href="{{ route('admin.guests.edit', $tamu) }}" class="rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-medium text-slate-700 transition hover:bg-slate-50">Edit</a>
                                                <form method="POST" action="{{ route('admin.guests.destroy', $tamu) }}" onsubmit="return confirm('Hapus data tamu {{ $tamu->nama }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="rounded-lg border border-red-200 px-3 py-1.5 text-xs font-medium text-red-600 transition hover:bg-red-50">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-5 py-10 text-center text-slate-500">
                                            @if ($keyword !== '')
                                                Tidak ada tamu dengan nama "<strong>{{ $keyword }}</strong>".
                                            @else
                                                Belum ada data tamu.
                                            @endif
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="border-t border-slate-200 px-5 py-3">
                        {{ $guests->onEachSide(1)->links() }}
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection
