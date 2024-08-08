<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Customer;
use App\Models\Sale;

class HomeController extends Controller
{
    // /**
    //  * Create a new controller instance.
    //  *
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $barang = Barang::all();
        $customer = Customer::all();
        $transaksi = Sale::all();

        return view('dashboard', compact('barang', 'customer', 'transaksi'));
    }

    public function dashboard()
    {
        $barang = Barang::all();
        $customer = Customer::all();
        $transaksi = Sale::all();

        return view('dashboard', compact('barang', 'customer', 'transaksi'));
    }
}
