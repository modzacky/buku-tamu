<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GuestController extends Controller
{
    public function index(Request $request): View
    {
        $keyword = trim((string) $request->query('q', ''));

        $guests = Guest::query()
            ->cariNama($keyword)
            ->orderByDesc('tanggal_kunjungan')
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('admin.guests.index', [
            'guests' => $guests,
            'keyword' => $keyword,
        ]);
    }

    public function edit(Guest $guest): View
    {
        return view('admin.guests.edit', [
            'guest' => $guest,
        ]);
    }

    public function update(Request $request, Guest $guest): RedirectResponse
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'nomor_hp' => ['required', 'string', 'max:20', 'regex:/^[0-9+\-\s()]+$/'],
            'email' => ['required', 'email:rfc', 'max:100'],
            'instansi' => ['required', 'string', 'max:150'],
            'tujuan_kunjungan' => ['required', 'string', 'max:255'],
            'tanggal_kunjungan' => ['required', 'date'],
        ]);

        $guest->update($data);

        return redirect()
            ->route('admin.guests.index')
            ->with('sukses', 'Data tamu berhasil diperbarui.');
    }

    public function destroy(Guest $guest): RedirectResponse
    {
        $guest->delete();

        return redirect()
            ->route('admin.guests.index')
            ->with('sukses', 'Data tamu berhasil dihapus.');
    }
}
