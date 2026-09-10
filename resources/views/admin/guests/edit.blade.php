@extends('layouts.app')

@section('title', 'Edit Tamu')

@section('body')
    <div class="mx-auto max-w-2xl px-4 py-8">
        <a href="{{ route('admin.guests.index') }}" class="mb-4 inline-block text-sm text-slate-600 hover:text-blue-700">← Kembali ke Data Tamu</a>

        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 p-6">
                <h1 class="text-lg font-bold text-slate-900">Edit Data Tamu</h1>
                <p class="mt-1 text-sm text-slate-600">{{ $guest->nama }} — {{ $guest->instansi }}</p>
            </div>

            <form method="POST" action="{{ route('admin.guests.update', $guest) }}" class="grid gap-5 p-6 sm:grid-cols-2">
                @csrf
                @method('PUT')

                <div class="sm:col-span-2">
                    <label for="nama" class="mb-1 block text-sm font-medium text-slate-700">Nama Lengkap <span class="text-red-600">*</span></label>
                    <input id="nama" type="text" name="nama" value="{{ old('nama', $guest->nama) }}" required maxlength="100"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                    @error('nama')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="nomor_hp" class="mb-1 block text-sm font-medium text-slate-700">Nomor HP <span class="text-red-600">*</span></label>
                    <input id="nomor_hp" type="tel" name="nomor_hp" value="{{ old('nomor_hp', $guest->nomor_hp) }}" required maxlength="20"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                    @error('nomor_hp')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="email" class="mb-1 block text-sm font-medium text-slate-700">Email <span class="text-red-600">*</span></label>
                    <input id="email" type="email" name="email" value="{{ old('email', $guest->email) }}" required maxlength="100"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                    @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="instansi" class="mb-1 block text-sm font-medium text-slate-700">Instansi <span class="text-red-600">*</span></label>
                    <input id="instansi" type="text" name="instansi" value="{{ old('instansi', $guest->instansi) }}" required maxlength="150"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                    @error('instansi')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="tujuan_kunjungan" class="mb-1 block text-sm font-medium text-slate-700">Tujuan Kunjungan <span class="text-red-600">*</span></label>
                    <textarea id="tujuan_kunjungan" name="tujuan_kunjungan" required maxlength="255" rows="3"
                              class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200">{{ old('tujuan_kunjungan', $guest->tujuan_kunjungan) }}</textarea>
                    @error('tujuan_kunjungan')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="tanggal_kunjungan" class="mb-1 block text-sm font-medium text-slate-700">Tanggal Kunjungan <span class="text-red-600">*</span></label>
                    <input id="tanggal_kunjungan" type="date" name="tanggal_kunjungan" value="{{ old('tanggal_kunjungan', $guest->tanggal_kunjungan->toDateString()) }}" required
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                    @error('tanggal_kunjungan')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="flex items-end gap-2 sm:col-span-2">
                    <button type="submit" class="rounded-lg bg-blue-800 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-900">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.guests.index') }}" class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
