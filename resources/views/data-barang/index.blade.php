@extends('layouts.app')

@section('title')
    Data Barang
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
                        <h1>Data Barang</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">Data Barang</li>
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
                                <h3 class="card-title">Data Barang</h3>
                                <button type="button" class="float-right btn btn-sm btn-success shadow" data-toggle="modal" data-target="#modal-tambah"><i class="fa fa-plus"></i> Tambah Barang</button>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example2" class="table table-sm table-bordered table-hover nowrap">
                                    <thead class="bg-secondary">
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Kode</th>
                                            <th class="text-center">Nama Barang</th>
                                            <th class="text-center">Harga Barang</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $a = 1;
                                        @endphp

                                        @foreach ($dataBarang as $item)
                                            <tr>
                                                <td class="align-middle text-center">{{$a++}}</td>
                                                <td class="align-middle text-center">{{$item->kode}}</td>
                                                <td class="align-middle text-center">{{$item->nama}}</td>
                                                <td class="align-middle text-center">{{number_format($item->harga, 2, '.', ',')}}</td>
                                                <td class="align-middle text-center">
                                                    <button class="btn btn-sm btn-success m-1" data-toggle="modal" data-target="#modal-edit{{$item->id}}">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger m-1" data-toggle="modal" data-target="#modal-hapus{{$item->id}}">
                                                        <i class="fa fa-trash-alt"></i>
                                                    </button>
                                                </td>
                                            </tr>

                                            <!-- Modal Edit Barang -->
                                            <div class="modal fade text-sm" id="modal-edit{{$item->id}}">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-success">
                                                            <h4 class="modal-title">Edit Barang</h4>
                                                        </div>
                                                        <form action="{{url('/data-barang/' . $item->id)}}" method="post">
                                                            @csrf
                                                            @method('put')

                                                            <div class="modal-body">
                                                                <div class="row justify-content-center">
                                                                    <div class="col-12 col-sm-12 col-lg-12">

                                                                        <!-- Kode Barang -->
                                                                        <div class="form-group row">
                                                                            <label for="kode_barang" class="col-12 col-sm-12 col-lg-12 col-form-label">Kode Barang</label>
                                                                            <div class="input-group col-12 col-sm-12 col-lg-12">
                                                                                <input type="text" class="form-control @error('kode_barang') is-invalid @enderror" id="tambah_kode_barang" placeholder="Cth: A001" value="{{old('kode_barang')?old('kode_barang'):$item->kode}}" name="kode_barang" required>

                                                                                <b class="invalid-feedback" role="alert" id="kode_barang_error"></b>
                                                                                
                                                                                @error('kode_barang')
                                                                                    <span class="invalid-feedback" role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>

                                                                        <!-- Nama Barang -->
                                                                        <div class="form-group row">
                                                                            <label for="nama_barang" class="col-12 col-sm-12 col-lg-12 col-form-label">Nama Barang</label>
                                                                            <div class="input-group col-12 col-sm-12 col-lg-12">
                                                                                <input type="text" class="form-control @error('nama_barang') is-invalid @enderror" id="tambah_nama_barang" placeholder="Cth: Barang A" value="{{old('nama_barang')?old('nama_barang'):$item->nama}}" name="nama_barang" required>

                                                                                <b class="invalid-feedback" role="alert" id="nama_barang_error"></b>
                                                                                
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
                                                                                <input type="number" class="form-control @error('harga_barang') is-invalid @enderror" id="harga_barang" placeholder="Cth: 150000" value="{{old('harga_barang')?old('harga_barang'):$item->harga}}" name="harga_barang" required>
                            
                                                                                @error('harga_barang')
                                                                                    <span class="invalid-feedback" role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="modal-footer justify-content-between">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>

                                                                <button type="submit" class="btn btn-success btn-sm mr-2" data-toggle="modal" data-target="#modal-hapus" id="tambahData">Simpan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <!-- /.modal-content -->
                                                </div>
                                                <!-- /.modal-dialog -->
                                            </div>
                                            <!-- /.modal -->

                                            <!-- Modal Hapus -->
                                            <div class="modal fade" id="modal-hapus{{$item->id}}">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-danger">
                                                            <h4 class="modal-title">Hapus Barang</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p class="">Anda yakin ingin menghapus <b>{{$item->nama}}</b>?</p>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>

                                                            <form action="{{url('/data-barang/' . $item->id)}}" method="post" class="">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm mr-2">Hapus</button>
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
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                        <!-- Modal Tambah Barang -->
                        <div class="modal fade text-sm" id="modal-tambah">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-info">
                                        <h4 class="modal-title">Tambah Barang</h4>
                                    </div>
                                    <form action="{{url('/data-barang')}}" method="post">
                                        @csrf

                                        <div class="modal-body">
                                            <div class="row justify-content-center">
                                                <div class="col-12 col-sm-12 col-lg-12">

                                                    <!-- Kode Barang -->
                                                    <div class="form-group row">
                                                        <label for="kode_barang" class="col-12 col-sm-12 col-lg-12 col-form-label">Kode Barang</label>
                                                        <div class="input-group col-12 col-sm-12 col-lg-12">
                                                            <input type="text" class="form-control @error('kode_barang') is-invalid @enderror" id="tambah_kode_barang" placeholder="Cth: A001" value="{{old('kode_barang')}}" name="kode_barang" required>

                                                            <b class="invalid-feedback" role="alert" id="kode_barang_error"></b>
                                                            
                                                            @error('kode_barang')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <!-- Nama Barang -->
                                                    <div class="form-group row">
                                                        <label for="nama_barang" class="col-12 col-sm-12 col-lg-12 col-form-label">Nama Barang</label>
                                                        <div class="input-group col-12 col-sm-12 col-lg-12">
                                                            <input type="text" class="form-control @error('nama_barang') is-invalid @enderror" id="tambah_nama_barang" placeholder="Cth: Barang A" value="{{old('nama_barang')}}" name="nama_barang" required>

                                                            <b class="invalid-feedback" role="alert" id="nama_barang_error"></b>
                                                            
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
                                                            <input type="number" class="form-control @error('harga_barang') is-invalid @enderror" id="harga_barang" placeholder="Cth: 150000" value="{{old('harga_barang')}}" name="harga_barang" required>
        
                                                            @error('harga_barang')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>

                                            <button type="submit" class="btn btn-success btn-sm mr-2" data-toggle="modal" data-target="#modal-hapus" id="tambahData">Tambah</button>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->

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