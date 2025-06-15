<?php

namespace App\Http\Controllers;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VoucherController extends Controller
{
    

    public function view()
    {
        $vouchers = Voucher::all();
        return view('admin.voucher', compact('vouchers'));
    }

    public function create()
    {
        return view('admin.vouchercreate'); 
    }


    
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_voucher'     => 'required|string|max:50',
            'description'      => 'required|string',
            'point_required'   => 'required|integer|min:0',
            'voucher_code'     => 'required|string|unique:vouchers,voucher_code',
            'discount_amount'  => 'required|numeric|min:0',
            'start_date'       => 'required|date',
            'end_date'         => 'required|date|after_or_equal:start_date',
            'is_active'        => 'required|boolean',
        ]);

        Voucher::create($data);

        return redirect()->route('admin.voucher')
        ->with('success', 'Voucher berhasil ditambahkan!');
    }

    public function edit($id)
{
    $voucher = Voucher::findOrFail($id);
    return view('admin.editvoucher', compact('voucher'));
}

    public function update(Request $request, $id)
{
    $voucher = Voucher::findOrFail($id);
    
    $data = $request->validate([
        'nama_voucher' => 'required|string|max:255',
        'description' => 'required|string|max:2000',
        'point_required' => 'required|integer|min:0',
        'voucher_code' => 'required|string|max:255|unique:vouchers,voucher_code,' . $voucher->id,
        'discount_amount' => 'required|numeric|min:0',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'is_active' => 'required|boolean',
    ]);

    // Update semua kolom
    $voucher->update($data);
    
    return redirect()->route('admin.voucher')->with('success', 'Voucher updated successfully!');
}

    public function destroy($id)
    {
            $voucher = Voucher::findOrFail($id);
            
            $voucher->delete();
            return redirect()->route('admin.voucher')->with('success', 'voucher deleted successfully!');
        }

}
