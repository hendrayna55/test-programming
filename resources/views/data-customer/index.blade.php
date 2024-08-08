@extends('layouts.app')

@section('title')
    Data Customer
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
                        <h1>Data Customer</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">Data Customer</li>
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
                                <h3 class="card-title">Data Customer</h3>
                                <button type="button" class="float-right btn btn-sm btn-success shadow" data-toggle="modal" data-target="#modal-tambah"><i class="fa fa-plus"></i> Tambah Customer</button>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example2" class="table table-sm table-bordered table-hover nowrap">
                                    <thead class="bg-secondary">
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Kode</th>
                                            <th class="text-center">Nama Customer</th>
                                            <th class="text-center">Telp Customer</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $a = 1;
                                        @endphp

                                        @foreach ($dataCustomer as $item)
                                            <tr>
                                                <td class="align-middle text-center">{{$a++}}</td>
                                                <td class="align-middle text-center">{{$item->kode}}</td>
                                                <td class="align-middle text-center">{{$item->name}}</td>
                                                <td class="align-middle text-center">
                                                    @php
                                                        if ($item->telp[0] != 0) {
                                                            $nomorWA = $item->telp;
                                                        }else{
                                                            $nomorWA = 62 . substr($item->telp,1,12);
                                                        }
                                                    @endphp

                                                    <a href="https://wa.me/{{$nomorWA}}" class="btn btn-sm btn-success"><i class="fab fa-whatsapp"></i> {{$item->telp}}</a>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <button class="btn btn-sm btn-success m-1" data-toggle="modal" data-target="#modal-edit{{$item->id}}">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger m-1" data-toggle="modal" data-target="#modal-hapus{{$item->id}}">
                                                        <i class="fa fa-trash-alt"></i>
                                                    </button>
                                                </td>
                                            </tr>

                                            <!-- Modal Edit Customer -->
                                            <div class="modal fade text-sm" id="modal-edit{{$item->id}}">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-success">
                                                            <h4 class="modal-title">Edit Customer</h4>
                                                        </div>
                                                        <form action="{{url('/data-customer/' . $item->id)}}" method="post">
                                                            @csrf
                                                            @method('put')
                    
                                                            <div class="modal-body">
                                                                <div class="row justify-content-center">
                                                                    <div class="col-12 col-sm-12 col-lg-12">
                    
                                                                        <!-- Kode Customer -->
                                                                        <div class="form-group row">
                                                                            <label for="kode_customer" class="col-12 col-sm-12 col-lg-12 col-form-label">Kode Customer</label>
                                                                            <div class="input-group col-12 col-sm-12 col-lg-12">
                                                                                <input type="text" class="form-control @error('kode_customer') is-invalid @enderror" id="tambah_kode_customer" placeholder="Cth: C2" value="{{old('kode_customer')?old('kode_customer'):$item->kode}}" name="kode_customer" required>
                    
                                                                                <b class="invalid-feedback" role="alert" id="kode_customer_error"></b>
                                                                                
                                                                                @error('kode_customer')
                                                                                    <span class="invalid-feedback" role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                    
                                                                        <!-- Nama Customer -->
                                                                        <div class="form-group row">
                                                                            <label for="nama_customer" class="col-12 col-sm-12 col-lg-12 col-form-label">Nama Customer</label>
                                                                            <div class="input-group col-12 col-sm-12 col-lg-12">
                                                                                <input type="text" class="form-control @error('nama_customer') is-invalid @enderror" id="tambah_nama_customer" placeholder="Cth: Customer E" value="{{old('nama_customer')?old('nama_customer'):$item->name}}" name="nama_customer" required>
                    
                                                                                <b class="invalid-feedback" role="alert" id="nama_customer_error"></b>
                                                                                
                                                                                @error('nama_customer')
                                                                                    <span class="invalid-feedback" role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                    
                                                                        <!-- Telp Customer -->
                                                                        <div class="form-group row">
                                                                            <label for="telp_customer" class="col-12 col-sm-12 col-lg-12 col-form-label">Telp Customer</label>
                                                                            <div class="input-group col-12 col-sm-12 col-lg-12">
                                                                                <input type="number" class="form-control @error('telp_customer') is-invalid @enderror" id="telp_customer" placeholder="Cth: 08xxxxxxxxxx" value="{{old('telp_customer')?old('telp_customer'):$item->telp}}" name="telp_customer" required>
                            
                                                                                @error('telp_customer')
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
                                                            <h4 class="modal-title">Hapus Customer</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p class="">Anda yakin ingin menghapus <b>{{$item->name}}</b>?</p>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>

                                                            <form action="{{url('/data-customer/' . $item->id)}}" method="post" class="">
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

                        <!-- Modal Tambah Customer -->
                        <div class="modal fade text-sm" id="modal-tambah">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-info">
                                        <h4 class="modal-title">Tambah Customer</h4>
                                    </div>
                                    <form action="{{url('/data-customer')}}" method="post">
                                        @csrf

                                        <div class="modal-body">
                                            <div class="row justify-content-center">
                                                <div class="col-12 col-sm-12 col-lg-12">

                                                    <!-- Kode Customer -->
                                                    <div class="form-group row">
                                                        <label for="kode_customer" class="col-12 col-sm-12 col-lg-12 col-form-label">Kode Customer</label>
                                                        <div class="input-group col-12 col-sm-12 col-lg-12">
                                                            <input type="text" class="form-control @error('kode_customer') is-invalid @enderror" id="tambah_kode_customer" placeholder="Cth: C2" value="{{old('kode_customer')}}" name="kode_customer" required>

                                                            <b class="invalid-feedback" role="alert" id="kode_customer_error"></b>
                                                            
                                                            @error('kode_customer')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <!-- Nama Customer -->
                                                    <div class="form-group row">
                                                        <label for="nama_customer" class="col-12 col-sm-12 col-lg-12 col-form-label">Nama Customer</label>
                                                        <div class="input-group col-12 col-sm-12 col-lg-12">
                                                            <input type="text" class="form-control @error('nama_customer') is-invalid @enderror" id="tambah_nama_customer" placeholder="Cth: Customer E" value="{{old('nama_customer')}}" name="nama_customer" required>

                                                            <b class="invalid-feedback" role="alert" id="nama_customer_error"></b>
                                                            
                                                            @error('nama_customer')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <!-- Telp Customer -->
                                                    <div class="form-group row">
                                                        <label for="telp_customer" class="col-12 col-sm-12 col-lg-12 col-form-label">Telp Customer</label>
                                                        <div class="input-group col-12 col-sm-12 col-lg-12">
                                                            <input type="number" class="form-control @error('telp_customer') is-invalid @enderror" id="telp_customer" placeholder="Cth: 08xxxxxxxxxx" value="{{old('telp_customer')}}" name="telp_customer" required>
        
                                                            @error('telp_customer')
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