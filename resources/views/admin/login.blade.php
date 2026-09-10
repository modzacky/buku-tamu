@extends('layouts.app')

@section('title', 'Login Admin')

@section('body')
    <main class="flex min-h-screen items-center justify-center px-4 py-10">
        <div class="w-full max-w-sm">
            <div class="mb-6 text-center">
                <div class="mx-auto mb-3 flex h-14 w-14 items-center justify-center rounded-xl bg-blue-900 text-lg font-bold text-white">BPS</div>
                <h1 class="text-xl font-bold text-slate-900">Login Admin</h1>
                <p class="mt-1 text-sm text-slate-600">Buku Tamu Digital — BPS Kota Bukittinggi</p>
            </div>

            <form method="POST" action="{{ route('login.store') }}" class="space-y-4 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                @csrf

                <div>
                    <label for="login" class="mb-1 block text-sm font-medium text-slate-700">Username atau Email</label>
                    <input id="login" type="text" name="login" value="{{ old('login') }}" required autofocus autocomplete="username"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                    @error('login')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="password" class="mb-1 block text-sm font-medium text-slate-700">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                    @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-sm text-slate-600">
                        <input type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-300 text-blue-700 focus:ring-blue-400">
                        Ingat saya
                    </label>
                </div>

                <button type="submit"
                        class="w-full rounded-lg bg-blue-800 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2">
                    Masuk
                </button>
            </form>

            <p class="mt-4 text-center text-xs text-slate-500">
                <a href="{{ route('guest.form') }}" class="hover:text-blue-700">← Kembali ke Buku Tamu</a>
            </p>
        </div>
    </main>
@endsection
