<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use Alert;

class DataBarangController extends Controller
{
    public function index()
    {
        $dataBarang = Barang::orderBy('created_at', 'desc')->get();
        return view('data-barang.index', compact('dataBarang'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => ['required'],
            'nama_barang' => ['required'],
            'harga_barang' => ['required'],
        ]);

        Barang::create([
            'kode' => $request->kode_barang,
            'nama' => $request->nama_barang,
            'harga' => $request->harga_barang,
        ]);

        alert()->success('Tambah Barang', $request->nama_barang);
        return back();
    }

    public function update(Request $request, string $id)
    {
        $dataBarang = Barang::find($id);

        $request->validate([
            'kode_barang' => ['required'],
            'nama_barang' => ['required'],
            'harga_barang' => ['required'],
        ]);

        Barang::find($id)->update([
            'kode' => $request->kode_barang,
            'nama' => $request->nama_barang,
            'harga' => $request->harga_barang,
        ]);

        alert()->success('Update Barang', $request->nama_barang);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dataBarang = Barang::find($id);
        $dataBarang->delete();
        alert()->success('Hapus Barang', $dataBarang->nama);
        return back();
    }
}
