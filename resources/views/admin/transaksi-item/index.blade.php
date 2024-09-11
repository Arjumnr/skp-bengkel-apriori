@extends('admin._layouts.index')
@push('css-vendor')
    <link href="{{ asset('themes/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('themes/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('themes/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/2.1.4/css/dataTables.bootstrap5.css" rel="stylesheet">

    
@endpush

@push('javascript-vendor')
    <script src="{{ asset('themes/assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('themes/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('themes/assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('themes/assets/vendor/php-email-form/validate.js') }}"></script>


    {{-- error  tinymce --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/tinymce.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/jquery.tinymce.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.4/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.4/js/dataTables.bootstrap5.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('content')
    <div class="pagetitle">
        <h1>Transaksi Item</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Transaksi Item</li>
            </ol>
        </nav>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card recent-sales overflow-auto">
                    <div class="card-body">
                        <!-- Tombol Add dengan ikon -->
                        <div class="d-flex mt-3 justify-content-end">
                            <button type="button" class="btn btn-primary mb-3" id="btnTambah" data-bs-toggle="modal"
                                data-bs-target="#basicModal">
                                <i class="bi bi-calendar2-plus me-1"></i> Tambah
                            </button>
                        </div>

                        <!-- Tabel -->
                        <div class="table-responsive">
                            <table class="table table-striped" id="data-table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Produk</th>
                                        <th scope="col">Jumlah</th>
                                        <th scope="col">Bayar</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Isi data akan dimasukkan di sini -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('admin.transaksi-item.modal')
@endsection

@include('admin.transaksi-item.js')
