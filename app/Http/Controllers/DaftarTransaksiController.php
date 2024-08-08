<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\SalesDet;
use App\Models\Customer;
use App\Models\Barang;
use Carbon\Carbon;
use Alert;

class DaftarTransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $daftarTransaksi = Sale::orderBy('created_at', 'desc')->get();
        $grandTotal = 0;
        for ($i=0; $i < $daftarTransaksi->count(); $i++) { 
            $grandTotal += $daftarTransaksi[$i]->total_bayar;
        }
        return view('daftar-transaksi.index', compact('daftarTransaksi', 'grandTotal'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::orderBy('name', 'asc')->get();
        $barangs = Barang::orderBy('nama', 'asc')->get();
        $now = Carbon::now();
        $month = $now->month; // Mengambil bulan dari $now
        $year = $now->year; // Mengambil tahun dari $now
        
        // Mengambil data yang memiliki bulan dan tahun yang sama dengan $now
        $sale = Sale::whereMonth('tgl', $month)
                    ->whereYear('tgl', $year)
                    ->get();
        
        // Menambahkan padding agar nomor_transaksi selalu memiliki 4 digit
        $nomor_transaksi = str_pad($sale->count() + 1, 4, '0', STR_PAD_LEFT);
        
        return view('daftar-transaksi.create', compact('now', 'customers', 'barangs', 'nomor_transaksi'));
    }

    public function createOrder(Request $request)
    {
        $barang = Barang::find($request->barang_id);
        $request->qty != null ? $qty = $request->qty : $qty = 1;
        $request->diskon != null ? $diskon = $request->diskon : $diskon = 0;

        if ($barang) {
            # code...
            if ($qty) {
                # code...
                $barang_id = $barang->id;
                $kode_barang = $barang->kode;
                $nama_barang = $barang->nama;
                $qty = $qty;
                $harga_bandrol = $barang->harga;

                $diskon_pct = $diskon;
                if ($diskon_pct >= 0) {
                    # code...
                    $diskon_persen = $diskon_pct/100;
                }else{
                    $diskon_persen = 0;
                }

                $diskon_nilai = $harga_bandrol * $diskon_persen;
                $harga_diskon = $harga_bandrol - $diskon_nilai;
                $total = $harga_diskon * $qty;

                $status = 200;
                $message = "Barang Ditemukan";
                $data = [
                    'barang_id' => $barang_id,
                    'kode_barang' => $kode_barang,
                    'nama_barang' => $nama_barang,
                    'qty' => round($qty, 2),
                    'harga_bandrol' => round($harga_bandrol, 2),
                    'diskon_pct' => round($diskon_pct, 2),
                    'diskon_nilai' => round($diskon_nilai, 2),
                    'harga_diskon' => round($harga_diskon, 2),
                    'total' => round($total, 2),
                ];
            } else {
                # code...
                $status = 404;
                $message = "Barang Ada tapi Qty kosong";
                $data = null;
            }
        } else {
            # code...
            $status = 404;
            $message = "Barang Tidak Ditemukan";
            $data = null;
        }
        
        return response()->json(['status' => $status,'message' => $message, 'data' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeTransaksi(Request $request)
    {
        $now = Carbon::now();
        $month = $now->month; // Mengambil bulan dari $now
        $year = $now->year; // Mengambil tahun dari $now

        // Mengambil data yang memiliki bulan dan tahun yang sama dengan $now
        $allSale = Sale::whereMonth('tgl', $month)
                    ->whereYear('tgl', $year)
                    ->get();
        
        // Menambahkan padding agar nomor_transaksi selalu memiliki 4 digit
        $nomor_transaksi = str_pad($allSale->count() + 1, 4, '0', STR_PAD_LEFT);
        $request->nomor_transaksi != null ? $kodeTransaksi = $request->nomor_transaksi : $kodeTransaksi = date('Ym', strtotime($now)) . '-' . $nomor_transaksi;

        $request->tanggal_transaksi != null ? $tgl = $request->tanggal_transaksi : $tgl = $now->format('Y-m-d H:i:s');
        $customer = Customer::where('id', $request->customer_id)->first();

        if ($customer) {
            # code...
            $dataOrder = $request->data_order;
            if ($dataOrder != null) {
                # code...
                $subTotal = $request->sub_total;
                $request->diskon != null ? $diskonTransaksi = $request->diskon : $diskonTransaksi = 0;
                $request->ongkir != null ? $ongkirTransaksi = $request->ongkir : $ongkirTransaksi = 0;
                $totalBayar = $request->total_bayar;

                $sale = Sale::create([
                    'kode' => $kodeTransaksi,
                    'tgl' => $tgl,
                    'cust_id' => $customer->id,
                    'subtotal' => $subTotal,
                    'diskon' => $diskonTransaksi,
                    'ongkir' => $ongkirTransaksi,
                    'total_bayar' => $totalBayar
                ]);

                $dataSale = [];
                for ($i=0; $i < count($dataOrder); $i++) { 
                    # code...
                    $salesDet = SalesDet::create([
                        'sales_id' => $sale->id,
                        'barang_id' => $dataOrder[$i]['barang_id'],
                        'harga_bandrol' => $dataOrder[$i]['harga_bandrol'],
                        'qty' => $dataOrder[$i]['qty'],
                        'diskon_pct' => $dataOrder[$i]['diskon_pct'],
                        'diskon_nilai' => $dataOrder[$i]['diskon_nilai'],
                        'harga_diskon' => $dataOrder[$i]['harga_diskon'],
                        'total' => $dataOrder[$i]['total'],
                    ]);

                    $dataSale[] = $salesDet;
                }

                $status = 200;
                $message = 'Berhasil tambah data';
                $data = [
                    't_sales' => $sale,
                    'data_order' => $dataSale
                ];
            } else {
                # code...
                $status = 400;
                $message = 'Data order tidak ada';
                $data = [];
            }
            
        }else{
            $status = 400;
            $message = 'Customer tidak ada';
            $data = [];
        }

        return response()->json(['status' => $status,'message' => $message, 'data' => $data]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $sale = Sale::find($id);
        $saleDet = SalesDet::where('sales_id', $sale->id)->get();

        $customers = Customer::orderBy('name', 'asc')->get();
        $barangs = Barang::orderBy('nama', 'asc')->get();

        return view('daftar-transaksi.edit', compact('sale', 'saleDet', 'customers', 'barangs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Sale::find($id);
        $data->delete();
        alert()->success('Hapus Transaksi', $data->kode);
        return back();
    }
}
