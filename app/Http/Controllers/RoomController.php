<?php

namespace App\Http\Controllers;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Menampilkan semua data ruangan.
     */
    public function view()
    {
        $rooms = Room::latest()->get(); // Mengambil data urut dari yang terbaru
        return view('admin.keloladata', compact('rooms'));
    }

    /**
     * Menampilkan form untuk membuat ruangan baru.
     */
    public function create()
    {
        return view('admin.createRoom'); 
    }

    /**
     * Menyimpan ruangan baru ke database.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:50',
            'console_type' => 'required|in:Nintendo,Playstation,VIP',
            'price_per_hour' => 'required|numeric|min:0',
            'description' => 'required|string',
            'status' => 'required|in:Available,Booked,Maintenance,Disabled',
        ]);

        Room::create($data);
        
        return redirect()->route('admin.keloladata')->with('success', 'Ruangan berhasil dibuat!');
    }

    /**
     * Menampilkan form untuk mengedit ruangan.
     */
    public function edit(Room $room)
    {
        return view('admin.editRoom', compact('room'));
    }

    /**
     * Memperbarui data ruangan di database.
     */
    public function update(Request $request, Room $room)
    {
        $data = $request->validate([
            'name' => 'required|string|max:50',
            'console_type' => 'required|in:Nintendo,Playstation,VIP',
            'price_per_hour' => 'required|numeric|min:0',
            'description' => 'required|string',
            'status' => 'required|in:Available,Booked,Maintenance,Disabled',
        ]);

        $room->update($data);

        return redirect()->route('admin.keloladata')->with('success', 'Ruangan berhasil diperbarui!');
    }

    /**
     * Menghapus ruangan dari database.
     */
    public function destroy(Room $room)
    {
        $room->delete();
        
        return redirect()->route('admin.keloladata')->with('success', 'Ruangan berhasil dihapus!');
    }

    // ===============================================
    // METHOD BARU UNTUK UPDATE STATUS
    // ===============================================
    /**
     * Memperbarui status ruangan.
     */
    public function updateStatus(Request $request, Room $room)
    {
        $validated = $request->validate([
            'status' => 'required|in:Available,Maintenance,Disabled'
        ]);

        $room->update(['status' => $validated['status']]);

        return back()->with('success', 'Status ruangan berhasil diperbarui.');
    }
}