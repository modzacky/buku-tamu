<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGuestRequest;
use App\Models\Guest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class GuestBookController extends Controller
{
    public function create(string $sumber = 'direct'): View
    {
        return view('guests.form', [
            'sumber' => $sumber,
        ]);
    }

    public function store(StoreGuestRequest $request): RedirectResponse
    {
        $guest = Guest::query()->create($request->validated());

        $url = $guest->sumber === 'direct'
            ? route('guest.form')
            : route('guest.form.sumber', ['sumber' => $guest->sumber]);

        return redirect()
            ->to($url)
            ->with('sukses', "Terima kasih, {$guest->nama}! Data kunjungan Anda berhasil disimpan.");
    }
}
