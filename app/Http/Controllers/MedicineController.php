<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Validation\Rule;

final class MedicineController extends BaseController
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:100', 'unique:medicines,code'],
            'stock' => ['required', 'integer', 'min:0'],
            'minimum_stock' => ['required', 'integer', 'min:0'],
            'unit' => ['required', 'string', 'max:50'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'is_active' => ['required', 'in:1,0'],
        ]);

        Medicine::create($validated);

        return redirect()->route('dashboard')
            ->with('status', 'Obat baru berhasil ditambahkan.');
    }

    public function update(Request $request, Medicine $medicine): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:100', Rule::unique('medicines', 'code')->ignore($medicine->id)],
            'stock' => ['required', 'integer', 'min:0'],
            'minimum_stock' => ['required', 'integer', 'min:0'],
            'unit' => ['required', 'string', 'max:50'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'is_active' => ['required', 'in:1,0'],
        ]);

        $medicine->update($validated);

        return redirect()->route('dashboard')
            ->with('status', 'Data obat berhasil diperbarui.');
    }

    public function destroy(Medicine $medicine): RedirectResponse
    {
        $medicine->delete();

        return redirect()->route('dashboard')
            ->with('status', 'Obat berhasil dihapus.');
    }
}
