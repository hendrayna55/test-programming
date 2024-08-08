<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Alert;

class DataCustomerController extends Controller
{
    public function index()
    {
        $dataCustomer = Customer::orderBy('created_at', 'desc')->get();
        return view('data-customer.index', compact('dataCustomer'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_customer' => ['required'],
            'nama_customer' => ['required'],
            'telp_customer' => ['required'],
        ]);

        Customer::create([
            'kode' => $request->kode_customer,
            'name' => $request->nama_customer,
            'telp' => $request->telp_customer,
        ]);

        alert()->success('Tambah Customer', $request->nama_customer);
        return back();
    }

    public function update(Request $request, string $id)
    {
        $data = Customer::find($id);

        $request->validate([
            'kode_customer' => ['required'],
            'nama_customer' => ['required'],
            'telp_customer' => ['required'],
        ]);

        Customer::find($id)->update([
            'kode' => $request->kode_customer,
            'name' => $request->nama_customer,
            'telp' => $request->telp_customer,
        ]);

        alert()->success('Update Customer', $request->nama_customer);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::find($id);
        $customer->delete();
        alert()->success('Hapus Customer', $customer->name);
        return back();
    }
}
