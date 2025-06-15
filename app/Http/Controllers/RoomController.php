<?php

namespace App\Http\Controllers;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    

    public function view()
    {
        $rooms = Room::all();
        return view('admin.keloladata', compact('rooms'));
    }

    public function create()
    {
        return view('admin.createRoom'); 
    }

    
    public function store(Request $request)
    {
        
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'console_type' => 'required|string|max:255',
            'price_per_hour' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // 'description' => 'required|string|max:2000',
        ]);

        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/rooms', $imageName);
            $data['image'] = 'rooms/' . $imageName;
        }

        
        Room::create($data);

        
        return redirect()->route('admin.keloladata')->with('success', 'Room created successfully!');
    }

    public function edit($id)
    {
        $room = Room::findOrFail($id);
        return view('admin.editRoom', compact('room'));
    }

    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);
        
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'console_type' => 'required|string|max:255',
            'price_per_hour' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // 'description' => 'required|string|max:2000',
        ]);

        // Handle file upload if new image is provided
        if ($request->hasFile('image')) {
            // Delete old image
            if ($room->image) {
                Storage::delete('public/' . $room->image);
            }
            
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/rooms', $imageName);
            $data['image'] = 'rooms/' . $imageName;
        }

        $room->update($data);
        return redirect()->route('admin.keloladata')->with('success', 'Room updated successfully!');
    }

    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        
        
        if ($room->image) {
            Storage::delete('public/' . $room->image);
        }
        
        $room->delete();
        return redirect()->route('admin.keloladata')->with('success', 'Room deleted successfully!');
    }
}
