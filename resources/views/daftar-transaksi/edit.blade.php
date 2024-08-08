@extends('layouts.app')

@section('title')
    Daftar Transaksi
@endsection

@push('styles')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('AdminLTE')}}/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{asset('AdminLTE')}}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('AdminLTE')}}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{asset('AdminLTE')}}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{asset('AdminLTE')}}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    <style>
        .nowrap {
            white-space: nowrap;
        }
    </style>
@endpush

@push('scripts')
    <!-- Tambahkan skrip jQuery (jika belum ada) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Select2 -->
    <script src="{{asset('AdminLTE')}}/plugins/select2/js/select2.full.min.js"></script>

    <!-- Inisiasi Select2 pada Class dan ID -->
    <script>
        
    </script>

    <!-- DataTables  & Plugins -->
    <script src="{{asset('AdminLTE')}}/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{asset('AdminLTE')}}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{asset('AdminLTE')}}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{asset('AdminLTE')}}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="{{asset('AdminLTE')}}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{asset('AdminLTE')}}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="{{asset('AdminLTE')}}/plugins/jszip/jszip.min.js"></script>
    <script src="{{asset('AdminLTE')}}/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="{{asset('AdminLTE')}}/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="{{asset('AdminLTE')}}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="{{asset('AdminLTE')}}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="{{asset('AdminLTE')}}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

    <!-- Page specific script -->
    <script>
        $(function () {
            $("#example1").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

            $('#example2').DataTable({
                "paging": false,
                "lengthChange": false,
                "searching": false,
                "ordering": false,
                "info": false,
                "autoWidth": false,
                "responsive": false,
                "scrollX" : true,
            });
        });
    </script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).ready(function () {
            // Format number menjadi contoh : 200,000.00
            function formatNumber(num) {
                return num.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
            }

            $('#kode_customer').change(function(){
                // Ambil nilai dari data atribut pada opsi yang dipilih
                var selectedOption = $(this).find('option:selected');
                var name = selectedOption.data('name');
                var telp = selectedOption.data('telp');

                // Isi input dengan nilai yang diambil
                $('#nama_customer').val(name);
                $('#telp_customer').val(telp);
            });

            $('#kode_barang_tambah').change(function(){
                // Ambil nilai dari data atribut pada opsi yang dipilih
                var selectedOption = $(this).find('option:selected');
                var nama = selectedOption.data('name');
                var harga = selectedOption.data('price');

                // Isi input dengan nilai yang diambil
                $('#nama_barang').val(nama);
                $('#harga_barang').val(harga);
            });

            //Initialize Select2 Elements
            $(function () {
                $('.select2').select2();
                $('#kode_customer').select2();
                $('#kode_barang_tambah').select2();
            });

            // Deklarasi barangOrder di cakupan global
            let barangOrder = [];
            const kumpulan_order = document.getElementById('kumpulan_order');
            const kumpulan_modal_edit = document.getElementById('kumpulan_modal_edit');
            const defaultDataHTML = `
                <tr id="default-data">
                    <td colspan="10" class="text-center">No data here</td>
                </tr>
            `;
    
            function tampilkanBarangOrder(data) {
                // Membersihkan kumpulan_order dan kumpulan_modal_edit sebelum menambah baris dan modal baru
                kumpulan_order.innerHTML = '';
                kumpulan_modal_edit.innerHTML = '';
    
                if (data.length === 0) {
                    kumpulan_order.innerHTML = defaultDataHTML;
                } else {
                    data.forEach((order, index) => {
                        const row = document.createElement('tr');
    
                        row.innerHTML = `
                            <td class="text-center align-middle">${index + 1}</td>
                            <td class="text-center align-middle">${order.kode_barang}</td>
                            <td class="text-center align-middle">${order.nama_barang}</td>
                            <td class="text-center align-middle">${order.qty}</td>
                            <td class="text-center align-middle">${formatNumber(parseFloat(order.harga_bandrol))}</td>
                            <td class="text-center align-middle">${parseFloat(order.diskon_pct)}%</td>
                            <td class="text-center align-middle">${formatNumber(parseFloat(order.diskon_nilai))}</td>
                            <td class="text-center align-middle">${formatNumber(parseFloat(order.harga_diskon))}</td>
                            <td class="text-center align-middle">${formatNumber(parseFloat(order.total))}</td>
                            <td class="text-center align-middle">
                                <button class="btn btn-sm btn-success" type="button" data-toggle="modal" data-target="#modal-edit-${index}"><i class="fa fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger" type="button" onClick="hapusOrder(${index})"><i class="fa fa-trash-alt"></i></button>
                            </td>
                        `;
    
                        kumpulan_order.appendChild(row);
    
                        const modalHTML = `
                            <div class="modal fade text-sm" id="modal-edit-${index}">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-success">
                                            <h4 class="modal-title">Edit Order</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row justify-content-center">
                                                <div class="col-12 col-sm-12 col-lg-12">
    
                                                    <!-- Kode Barang -->
                                                    <div class="form-group row">
                                                        <label for="kode_barang_${index}" class="col-12 col-sm-12 col-lg-12 col-form-label">Kode Barang</label>
                                                        <div class="input-group col-12 col-sm-12 col-lg-12">
                                                            <select name="kode_barang" id="kode_barang_${index}" class="form-control" required style="width: 100%">
                                                                <option value="" selected disabled>-- Pilih Barang --</option>
                                                                @foreach ($barangs as $barang)
                                                                    <option value="{{$barang->id}}" data-name="{{$barang->nama}}" data-price="{{number_format($barang->harga, 2, '.', ',')}}" ${'{{$barang->nama}}' == order.nama_barang ? 'selected' : ''}>
                                                                        {{$barang->kode}} - {{$barang->nama}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
    
                                                    <!-- Nama Barang -->
                                                    <div class="form-group row">
                                                        <label for="nama_barang_${index}" class="col-12 col-sm-12 col-lg-12 col-form-label">Nama Barang</label>
                                                        <div class="input-group col-12 col-sm-12 col-lg-12">
                                                            <input type="text" class="form-control" id="nama_barang_${index}" placeholder="Belum memilih data" value="${order.nama_barang}" name="nama_barang" readonly>
                                                        </div>
                                                    </div>
    
                                                    <!-- Harga Barang -->
                                                    <div class="form-group row">
                                                        <label for="harga_barang_${index}" class="col-12 col-sm-12 col-lg-12 col-form-label">Harga Barang</label>
                                                        <div class="input-group col-12 col-sm-12 col-lg-12">
                                                            <input type="text" class="form-control" id="harga_barang_${index}" placeholder="Belum memilih data" value="${order.harga_bandrol}" name="harga_barang" readonly>
                                                        </div>
                                                    </div>
    
                                                    <!-- Jumlah dan Diskon Barang -->
                                                    <div class="form-group row">
                                                        <div class="col-6 row">
                                                            <label for="qty_barang_${index}" class="col-12 col-sm-12 col-lg-12 col-form-label">Jumlah (Qty)</label>
                                                            <div class="input-group col-12 col-sm-12 col-lg-12">
                                                                <input type="number" class="form-control" id="qty_barang_${index}" placeholder="Cth: 5" value="${order.qty}" name="qty_barang" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 row">
                                                            <label for="diskon_barang_${index}" class="col-12 col-sm-12 col-lg-12 col-form-label">Diskon (%)</label>
                                                            <div class="input-group col-12 col-sm-12 col-lg-12">
                                                                <input type="number" class="form-control" id="diskon_barang_${index}" placeholder="Cth: 20" value="${order.diskon_pct}" name="diskon_barang" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                                            <button type="button" class="btn btn-success btn-sm mr-2" id="updateDataBarang_${index}" data-index="${index}" data-dismiss="modal">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        kumpulan_modal_edit.innerHTML += modalHTML;
    
                        // Inisialisasi select2 setelah elemen dimasukkan ke DOM
                        setTimeout(() => {
                            $(`#kode_barang_${index}`).select2();
                        }, 0);
                    });
    
                    // Attach event listeners for update buttons after modals are created
                    data.forEach((order, index) => {
                        $(`#updateDataBarang_${index}`).on('click', function () {
                            updateOrder(index);
                        });

                        $(`#kode_barang_${index}`).change(function(){
                            // Ambil nilai dari data atribut pada opsi yang dipilih
                            var selectedOption = $(this).find('option:selected');
                            var nama = selectedOption.data('name');
                            var harga = selectedOption.data('price');

                            // Isi input dengan nilai yang diambil
                            $('#nama_barang').val(nama);
                            $('#harga_barang').val(harga);
                        });
                    });
                }
            }
    
            function updateOrder(index) {
                var token = "{{ csrf_token() }}";
                const id_barang = $(`#kode_barang_${index}`).val();
                const qty_barang = $(`#qty_barang_${index}`).val();
                const diskon_barang = $(`#diskon_barang_${index}`).val();
    
                $.ajax({
                    url: "{{url('/order')}}",
                    method: 'POST',
                    data: {
                        _token: token,
                        barang_id: id_barang,
                        qty: qty_barang,
                        diskon: diskon_barang,
                    },
                    success: function(response) {
                        const { status, message, data } = response;
    
                        if (data) {
                            // Harga Lama
                            const total_lama = barangOrder[index].total;
    
                            // Update barangOrder with new data
                            barangOrder[index] = data;
    
                            tampilkanBarangOrder(barangOrder);
                            updateOrderTotal(total_lama, data.total);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Terjadi kesalahan:', error);
                        console.error('Response:', xhr.responseText);
                    }
                });
            }
    
            var subTotal = 0;
            var totalBayar = 0;
            var inputDiskon = $('#diskon_transaksi');
            var inputOngkir = $('#ongkir');
            $('#diskon_transaksi').val(0);
            $('#ongkir').val(0);
            $('#sub_total').val(formatNumber(parseFloat(subTotal)));
            $('#total_bayar').val(formatNumber(parseFloat(totalBayar)));
    
            function updateTotalBayar() {
                var diskon = parseFloat(inputDiskon.val()) || 0;
                var ongkir = parseFloat(inputOngkir.val()) || 0;
                var setelahDiskonOngkir = subTotal - diskon + ongkir;
                totalBayar = setelahDiskonOngkir;
                $('#total_bayar').val(formatNumber(parseFloat(setelahDiskonOngkir)));
            }
    
            // Fungsi penambahan order
            function penambahanOrder(harga){
                subTotal += harga;
                totalBayar += harga;
                $('#sub_total').val(formatNumber(parseFloat(subTotal)));
                updateTotalBayar();
            };
    
            function updateOrderTotal(hargaLama, hargaBaru) {
                subTotal -= hargaLama;
                subTotal += hargaBaru;
                totalBayar -= hargaLama;
                totalBayar += hargaBaru;
                $('#sub_total').val(formatNumber(parseFloat(subTotal)));
                updateTotalBayar();
            }
    
            // Deklarasi hapusOrder di cakupan global
            window.hapusOrder = function(index) {
                subTotal -= barangOrder[index].total;
                barangOrder.splice(index, 1);
                tampilkanBarangOrder(barangOrder);
                $('#sub_total').val(formatNumber(parseFloat(subTotal)));
                updateTotalBayar();
            }
    
            inputDiskon.on('input', updateTotalBayar);
            inputOngkir.on('input', updateTotalBayar);
    
            // Fungsi ketika button #tambahDataBarang di klik
            $('#tambahDataBarang').on('click', function () {
                var token = "{{ csrf_token() }}";
                const id_barang = $('#kode_barang_tambah').val();
                const qty_barang = $('#qty_barang').val();
                const diskon_barang = $('#diskon_barang').val();
                
                $.ajax({
                    url: "{{url('/order')}}",
                    method: 'POST',
                    data: {
                        _token: token,
                        barang_id: id_barang,
                        qty: qty_barang,
                        diskon: diskon_barang,
                    },
                    success: function(response) {
                        const { status, message, data } = response;
    
                        if (data) {
                            barangOrder.push(data);
                            $('#default-data').remove();
                            tampilkanBarangOrder(barangOrder);
                            penambahanOrder(data.total);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Terjadi kesalahan:', error);
                        console.error('Response:', xhr.responseText);
                    }
                });
    
                $('#kode_barang_tambah').val('').trigger('change');
                $('#qty_barang').val('');
                $('#diskon_barang').val('');
            });
    
            $('#createTransaksi').on('click', function () {
                var token = "{{ csrf_token() }}";
                const nomor_transaksi = $('#kode_transaksi').val();
                const tanggal_transaksi = $('#tanggal_transaksi').val();
                const customer_id = $('#kode_customer').val();
                const sub_total = subTotal;
                const diskon = parseFloat($('#diskon_transaksi').val());
                const ongkir = parseFloat($('#ongkir').val());
                const total_bayar = totalBayar;
                const keranjangOrder = barangOrder;
    
                // Menonaktifkan tombol dan mengubah teks
                $(this).prop('disabled', true).text('Menyimpan...');
                $('#cancelCreateTransaksi').prop('disabled', true);
                $('#buttonTambah').prop('disabled', true);
    
                $.ajax({
                    url: "{{url('/order/createSale')}}",
                    method: 'POST',
                    data: {
                        _token: token,
                        nomor_transaksi: nomor_transaksi,
                        tanggal_transaksi: tanggal_transaksi,
                        customer_id: customer_id,
                        sub_total: sub_total,
                        diskon: diskon,
                        ongkir: ongkir,
                        total_bayar: total_bayar,
                        data_order: keranjangOrder,
                    },
                    success: function (response) {
                        const { status, message, data } = response;
    
                        if (status == 200) {
                            // Tampilkan sweetalert success
                            swal("Berhasil Menyimpan!", response.message, "success");
    
                            // Atur timeout untuk kembali ke halaman form dalam waktu tertentu
                            setTimeout(() => {
                                // Mengaktifkan kembali tombol dan mengubah teks kembali ke 'Simpan'
                                $(this).prop('disabled', false).text('Simpan');
                                $('#cancelCreateTransaksi').prop('disabled', false);
                                $('#buttonTambah').prop('disabled', false);
    
                                // Redirect ke halaman /daftar-transaksi
                                window.location.href = '/daftar-transaksi';
                            }, 3000); // Gantilah 3000 dengan waktu yang diperlukan untuk proses penyimpanan
                        } else {
                            if (message == "Customer tidak ada") {
                                swal("Gagal menyimpan!", response.message, "error");
                            } else {
                                swal("Gagal menyimpan!", response.message, "error");
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Terjadi kesalahan:', error);
                        console.error('Response:', xhr.responseText);
                    }
                });
            });
        });
    </script>

@endpush

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Data Transaksi</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Data Transaksi</li>
                            <li class="breadcrumb-item">Tambah</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <form action="" method="post">
                            @csrf

                            <div class="card">
                                <div class="card-header bg-info">
                                    <h3 class="card-title">Tambah Data Transaksi</h3>
                                    <a href="{{url('/daftar-transaksi')}}" class="float-right btn btn-sm btn-success shadow"><i class="fa fa-angle-left"></i> Kembali</a>
                                </div>
                                <!-- /.card-header -->

                                <div class="card-body">
                                    <div class="row">
                                        <!-- Transaksi -->
                                        <div class="col-12 col-lg-6">
                                            <label for="transaksi" class="col-form-label"><u>Transaksi</u></label>
                                            <div class="form-group row text-sm">
                                                <label for="kode_transaksi" class="col-12 col-sm-12 col-lg-3 col-form-label">Nomor Transaksi</label>
                                                <div class="input-group col-12 col-sm-12 col-lg-7">
                                                    <input type="text" class="form-control form-control-sm @error('kode_transaksi') is-invalid @enderror" id="kode_transaksi" value="{{old('kode_transaksi')?old('kode_transaksi'):$sale->kode}}" name="kode_transaksi" required>
                                                </div>
                                            </div>
    
                                            <div class="form-group row text-sm">
                                                <label for="tanggal_transaksi" class="col-12 col-sm-12 col-lg-3 col-form-label">Tanggal</label>
                                                {{-- value="{{date('d-M-Y', strtotime($now))}}" --}}
                                                <div class="input-group col-12 col-sm-12 col-lg-7">
                                                    <input type="datetime-local" class="form-control form-control-sm @error('tanggal_transaksi') is-invalid @enderror" id="tanggal_transaksi" value="{{old('tanggal_transaksi')?old('tanggal_transaksi'):$sale->tgl}}" name="tanggal_transaksi" required>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Customer -->
                                        <div class="col-12 col-lg-6 mb-4">
                                            <label for="customer" class="col-form-label"><u>Customer</u></label>
                                            <div class="form-group row text-sm">
                                                <label for="kode_customer" class="col-12 col-sm-12 col-lg-2 col-form-label">Kode</label>
                                                <div class="input-group col-12 col-sm-12 col-lg-8">
                                                    <select name="kode_customer" id="kode_customer" class="form-control form-control-sm @error('kode_customer') is-invalid @enderror" required>
                                                        <option value="" selected disabled>-- Pilih Customer --</option>

                                                        @foreach ($customers as $item)
                                                            <option value="{{$item->id}}" data-name="{{$item->name}}" data-telp="{{$item->telp}}" {{ (old('kode_customer', $sale->kode) == $item->id) ? 'selected' : '' }}>{{$item->kode}} - {{$item->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row text-sm">
                                                <label for="nama_customer" class="col-12 col-sm-12 col-lg-2 col-form-label">Nama</label>
                                                <div class="input-group col-12 col-sm-12 col-lg-8">
                                                    <input type="text" class="form-control form-control-sm @error('nama_customer') is-invalid @enderror" id="nama_customer" value="{{$sale->customer->name}}" readonly>
                                                </div>
                                            </div>

                                            <div class="form-group row text-sm">
                                                <label for="telp_customer" class="col-12 col-sm-12 col-lg-2 col-form-label">Telp</label>
                                                <div class="input-group col-12 col-sm-12 col-lg-8">
                                                    <input type="text" class="form-control form-control-sm @error('telp_customer') is-invalid @enderror" id="telp_customer" value="{{$sale->customer->kode}}" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Tabel Order -->
                                        <div class="col-12 col-lg-12 table-responsive">
                                            <h5 class="text-center"><b>Data Order</b></h5>
                                            <table class="table table-sm text-sm table-bordered table-hover nowrap" style="width: 100%;">
                                                <thead class="bg-secondary">
                                                    <tr>
                                                        <th class="text-center align-middle" rowspan="2">No</th>
                                                        <th class="text-center align-middle" rowspan="2">Kode Barang</th>
                                                        <th class="text-center align-middle" rowspan="2">Nama Barang</th>
                                                        <th class="text-center align-middle" rowspan="2">Qty</th>
                                                        <th class="text-center align-middle" rowspan="2">Harga Bandrol</th>
                                                        <th class="text-center align-middle" colspan="2">Diskon</th>
                                                        <th class="text-center align-middle" rowspan="2">Harga Diskon</th>
                                                        <th class="text-center align-middle" rowspan="2">Total</th>
                                                        <th class="text-center align-middle bg-light" rowspan="2">
                                                            <button type="button" class="btn btn-sm btn-primary shadow" data-toggle="modal" data-target="#modal-tambah" id="buttonTambah">Tambah</button>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-center align-middle">(%)</th>
                                                        <th class="text-center align-middle">(Rp)</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="kumpulan_order">
                                                    <tr id="default-data">
                                                        <td colspan="10" class="text-center">No data here</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="col-12 mt-4">
                                            <div class="row">
                                                <div class="col-12 col-lg-6"></div>

                                                <!-- Info di bawah tabel -->
                                                <div class="col-12 col-lg-6 float-right">
                                                    <!-- Sub Total -->
                                                    <div class="form-group row text-sm">
                                                        <label for="sub_total" class="col-12 col-sm-12 col-lg-3 col-form-label">Sub Total</label>
                                                        <div class="input-group col-12 col-sm-12 col-lg-9">
                                                            <input type="text" class="form-control form-control-sm @error('sub_total') is-invalid @enderror" id="sub_total" value="" readonly>
                                                        </div>
                                                    </div>

                                                    <!-- Diskon -->
                                                    <div class="form-group row text-sm">
                                                        <label for="diskon_transaksi" class="col-12 col-sm-12 col-lg-3 col-form-label">Diskon</label>
                                                        <div class="input-group col-12 col-sm-12 col-lg-9">
                                                            <input type="number" class="form-control form-control-sm @error('diskon_transaksi') is-invalid @enderror" id="diskon_transaksi" value="">
                                                        </div>
                                                    </div>

                                                    <!-- Ongkir -->
                                                    <div class="form-group row text-sm">
                                                        <label for="ongkir" class="col-12 col-sm-12 col-lg-3 col-form-label">Ongkir</label>
                                                        <div class="input-group col-12 col-sm-12 col-lg-9">
                                                            <input type="number" class="form-control form-control-sm @error('ongkir') is-invalid @enderror" id="ongkir" value="">
                                                        </div>
                                                    </div>

                                                    <!-- Total Bayar -->
                                                    <div class="form-group row text-sm">
                                                        <label for="total_bayar" class="col-12 col-sm-12 col-lg-3 col-form-label">Total Bayar</label>
                                                        <div class="input-group col-12 col-sm-12 col-lg-9">
                                                            <input type="text" class="form-control form-control-sm @error('total_bayar') is-invalid @enderror" id="total_bayar" value="" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                
                                <div class="card-footer">
                                    <div class="row justify-content-between">
                                        <button type="button" class="btn btn-danger" id="cancelCreateTransaksi" data-toggle="modal" data-target="#modal-batal">Batal</button>
                                        <button class="btn btn-success" id="createTransaksi" type="button">Simpan</button>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card -->
                        </form>

                        <!-- Modal Tambah Barang -->
                        <div class="modal fade text-sm" id="modal-tambah">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-info">
                                        <h4 class="modal-title">Tambah Order</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row justify-content-center">
                                            <div class="col-12 col-sm-12 col-lg-12">

                                                <!-- Kode Barang -->
                                                <div class="form-group row">
                                                    <label for="kode_barang" class="col-12 col-sm-12 col-lg-12 col-form-label">Kode Barang</label>
                                                    <div class="input-group col-12 col-sm-12 col-lg-12">
                                                        <select name="kode_barang" id="kode_barang_tambah" class="form-control @error('kode_barang') is-invalid @enderror" required style="width: 100%">
                                                            <option value="" selected disabled>-- Pilih Barang --</option>
    
                                                            @foreach ($barangs as $barang)
                                                                <option value="{{$barang->id}}" data-name="{{$barang->nama}}" data-price="{{number_format($barang->harga, 2, '.', ',')}}" {{old('kode_barang') ? 'selected' : ''}}>
                                                                    {{$barang->kode}} - {{$barang->nama}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Nama Barang -->
                                                <div class="form-group row">
                                                    <label for="nama_barang" class="col-12 col-sm-12 col-lg-12 col-form-label">Nama Barang</label>
                                                    <div class="input-group col-12 col-sm-12 col-lg-12">
                                                        <input type="text" class="form-control @error('nama_barang') is-invalid @enderror" id="nama_barang" placeholder="Belum memilih data" value="{{old('nama_barang')}}" name="nama_barang" readonly>
                                                        
                                                        @error('nama_barang')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- Harga Barang -->
                                                <div class="form-group row">
                                                    <label for="harga_barang" class="col-12 col-sm-12 col-lg-12 col-form-label">Harga Barang</label>
                                                    <div class="input-group col-12 col-sm-12 col-lg-12">
                                                        <input type="text" class="form-control @error('harga_barang') is-invalid @enderror" id="harga_barang" placeholder="Belum memilih data" value="{{old('harga_barang')}}" name="harga_barang" readonly>
    
                                                        @error('harga_barang')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- Jumlah dan Diskon Barang -->
                                                <div class="form-group row">
                                                    <div class="col-6 row">
                                                        <label for="qty_barang" class="col-12 col-sm-12 col-lg-12 col-form-label">Jumlah (Qty)</label>
                                                        <div class="input-group col-12 col-sm-12 col-lg-12">
                                                            <input type="number" class="form-control @error('qty_barang') is-invalid @enderror" id="qty_barang" placeholder="Cth: 5" value="{{old('qty_barang')}}" name="qty_barang" required>
        
                                                            @error('qty_barang')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-6 row">
                                                        <label for="diskon_barang" class="col-12 col-sm-12 col-lg-12 col-form-label">Diskon (%)</label>
                                                        <div class="input-group col-12 col-sm-12 col-lg-12">
                                                            <input type="number" class="form-control @error('diskon_barang') is-invalid @enderror" id="diskon_barang" placeholder="Cth: 20" value="{{old('diskon_barang')}}" name="diskon_barang" required>
        
                                                            @error('diskon_barang')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>

                                        <button type="button" class="btn btn-success btn-sm mr-2" id="tambahDataBarang" data-dismiss="modal">Tambah</button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->

                        <!-- Modal Batal -->
                        <div class="modal fade text-sm" id="modal-batal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger">
                                        <h4 class="modal-title">Batalkan Transaksi</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row justify-content-center">
                                            <div class="col-12 col-sm-12 col-lg-12">

                                                <p>anda yakin ingin membatalkan transaksi ini?</p>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>

                                        <a href="{{url('/daftar-transaksi')}}" class="btn btn-danger btn-sm mr-2">Batalkan</a>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->

                        <div id="kumpulan_modal_edit"></div>

                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection