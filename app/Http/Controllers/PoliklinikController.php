<?php

namespace App\Http\Controllers;

use App\Models\Poliklinik;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

final class PoliklinikController extends BaseController
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
            'status' => ['required', 'string', 'in:Aktif,Nonaktif'],
        ]);

        Poliklinik::create($validated);

        return redirect()->route('dashboard')
            ->with('status', 'Poliklinik berhasil ditambahkan.');
    }

    public function update(Request $request, Poliklinik $poliklinik): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
            'status' => ['required', 'string', 'in:Aktif,Nonaktif'],
        ]);

        $poliklinik->update($validated);

        return redirect()->route('dashboard')
            ->with('status', 'Poliklinik berhasil diperbarui.');
    }

    public function destroy(Poliklinik $poliklinik): RedirectResponse
    {
        $poliklinik->delete();

        return redirect()->route('dashboard')
            ->with('status', 'Poliklinik berhasil dihapus.');
    }
}
