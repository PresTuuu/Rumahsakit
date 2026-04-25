<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

final class RoomController extends BaseController
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'room_name' => ['required', 'string', 'max:255'],
            'room_type' => ['required', 'string', 'max:100'],
            'floor' => ['required', 'integer', 'min:0'],
            'capacity' => ['required', 'integer', 'min:1'],
            'available' => ['required', 'integer', 'min:0'],
            'price_per_day' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:Aktif,Nonaktif'],
        ]);

        Room::create($validated);

        return redirect()->route('dashboard')
            ->with('status', 'Ruangan baru berhasil ditambahkan.');
    }

    public function update(Request $request, Room $room): RedirectResponse
    {
        $validated = $request->validate([
            'room_name' => ['required', 'string', 'max:255'],
            'room_type' => ['required', 'string', 'max:100'],
            'floor' => ['required', 'integer', 'min:0'],
            'capacity' => ['required', 'integer', 'min:1'],
            'available' => ['required', 'integer', 'min:0'],
            'price_per_day' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:Aktif,Nonaktif'],
        ]);

        $room->update($validated);

        return redirect()->route('dashboard')
            ->with('status', 'Data ruangan berhasil diperbarui.');
    }

    public function destroy(Room $room): RedirectResponse
    {
        $room->delete();

        return redirect()->route('dashboard')
            ->with('status', 'Ruangan berhasil dihapus.');
    }
}
