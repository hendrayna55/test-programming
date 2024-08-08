@extends('layouts.app')

@section('title')
    Daftar Transaksi
@endsection

@push('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('AdminLTE')}}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{asset('AdminLTE')}}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{asset('AdminLTE')}}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endpush

@push('scripts')
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
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "responsive": false,
                "scrollX" : true,
                "buttons": ["excel", "pdf", "colvis"]
            }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
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
                            <li class="breadcrumb-item">Data Transaksi</li>
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
                        <div class="card">
                            <div class="card-header bg-info">
                                <h3 class="card-title">Data Transaksi</h3>
                                <a href="{{url('/daftar-transaksi/tambah')}}" class="float-right btn btn-sm btn-success shadow"><i class="fa fa-plus"></i> Tambah Transaksi</a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example2" class="table table-sm table-bordered table-hover nowrap">
                                    <thead class="bg-secondary">
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Nomor Transaksi</th>
                                            <th class="text-center">Tanggal</th>
                                            <th class="text-center">Nama Customer</th>
                                            <th class="text-center">Jumlah Barang</th>
                                            <th class="text-center">Sub Total</th>
                                            <th class="text-center">Diskon</th>
                                            <th class="text-center">Ongkir</th>
                                            <th class="text-center">Total</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $a = 1;
                                        @endphp

                                        @foreach ($daftarTransaksi as $item)
                                            <tr>
                                                <td class="align-middle text-center">{{$a++}}</td>
                                                <td class="align-middle text-center">{{$item->kode}}</td>
                                                <td class="align-middle text-center">{{date('d-M-Y', strtotime($item->tgl))}}</td>
                                                <td class="align-middle text-center">{{$item->customer->name}}</td>
                                                <td class="align-middle text-center">{{$item->sales_dets->count()}}</td>
                                                <td class="align-middle text-center">{{number_format($item->subtotal, 2, '.', ',')}}</td>
                                                <td class="align-middle text-center">{{$item->diskon != null ? number_format($item->diskon, 2, '.', ',') : '-'}}</td>
                                                <td class="align-middle text-center">{{$item->ongkir != null ? number_format($item->ongkir, 2, '.', ',') : '-'}}</td>
                                                <td class="align-middle text-center">{{number_format($item->total_bayar, 2, '.', ',')}}</td>
                                                <td class="align-middle text-center">
                                                    {{-- <a href="{{url('/daftar-transaksi/edit/' . $item->id)}}" class=" btn btn-sm btn-success">
                                                        <i class="fa fa-edit"></i>
                                                    </a> --}}

                                                    <button type="button" class=" btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-hapus-{{$item->id}}">
                                                        <i class="fa fa-trash-alt"></i>
                                                    </button>
                                                </td>
                                            </tr>

                                            <!-- Modal Hapus -->
                                            <div class="modal fade" id="modal-hapus-{{$item->id}}">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-danger">
                                                            <h4 class="modal-title">Hapus Transaksi</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row justify-content-center">
                                                                <div class="col-12 col-sm-12 col-lg-12">

                                                                    <p>Apakah anda yakin ingin menghapus transaksi <b>{{$item->kode}}</b>?</p>

                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>

                                                            <form action="{{url('/daftar-transaksi/' . $item->id)}}" method="post">
                                                                @csrf
                                                                @method('delete')

                                                                <button type="submit" class="btn btn-danger btn-sm mr-2">Batalkan</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <!-- /.modal-content -->
                                                </div>
                                                <!-- /.modal-dialog -->
                                            </div>
                                            <!-- /.modal -->
                                        @endforeach
                                    </tbody>
                                    <tfoot class="bg-primary">
                                        <tr>
                                            <th class="text-center" colspan="8">Grand Total</th>
                                            <th class="text-center">{{number_format($grandTotal, 2, '.', ',')}}</th>
                                            <th class="text-center bg-dark"></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
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