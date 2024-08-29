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
    <script src="http://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/jquery.tinymce.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.4/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.4/js/dataTables.bootstrap5.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('content')
    <div class="pagetitle">
        <h1>Produk</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Produk</li>
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
                                        <th scope="col">Produk</th>
                                        <th scope="col">Stok</th>
                                        <th scope="col">Harga Beli</th>
                                        <th scope="col">Harga Jual</th>
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
    @include('admin.produk.modal')
@endsection

@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            console.log('ready!');
            // $('#modalID').modal('show');

            var table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('produk.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'stock',
                        name: 'stock'
                    },
                    {
                        data: 'capital',
                        name: 'capital'
                    },
                    {
                        data: 'sell',
                        name: 'sell'
                    },

                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],


            });

            if ($.fn.dataTable.isDataTable('#data-table')) {
                table = $('#data-table').DataTable();
            } else {
                table = $('#data-table').DataTable({
                    "ajax": "{{ route('produk.index') }}",
                    "columns": [{
                            "data": "name"
                        },
                        {
                            "data": "stock"
                        },
                        {
                            "data": "capital"
                        },
                        {
                            "data": "sell"
                        },
                        {
                            "data": "action"
                        },
                    ]
                });
            }

            $('#btnTambah').on('click', function() {
                console.log('click');
                $('#modal-form').trigger("reset");
                $('#form').trigger("reset");
                // $('#modal-form').modal('show');
                // $('#form').attr('action', "{{ route('produk.store') }}");
            });


            $('#form').on('submit', function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                var id = $('#data_id').val();
                var url = "{{ route('produk.store') }}";
                if (id != '') {
                    //kirim id lewat form data 
                    formData.append('data_id', id);
                }
                $.ajax({
                    url: url,
                    method: "POST",
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        if (data.status == 'success') {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Berhasil',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                table.draw();

                            })
                        } else {
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: 'Gagal',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                table.draw();

                            })
                        }
                        $("#basicModal").removeClass("in");
                        $(".modal-backdrop").remove();
                        $("#basicModal").hide();

                        $('#form').trigger("reset");

                    },
                    error: function(data) {
                        console.log(data);


                    }
                })
            });

            // //edit
            $('body').on('click', '.edit', function() {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                // $('#btnSave').html('Update Data')

                var id = $(this).data('id');

                $.get("{{ route('produk.index') }}" + '/' + id + '/edit', function(data) {
                    console.log("data_id = " + data.id);
                    $('#data_id').val(id);
                    $('#name').val(data.name);
                    $('#stock').val(data.stock);
                    $('#capital').val(data.capital);
                    $('#sell').val(data.sell);

                })

            });


            //del
            $('body').on('click', '.delete', function() {
               
                var id = $(this).data("id");
                console.log(id)
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: "{{ route('produk.store') }}" + '/' + id,

                            success: function(data) {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: 'Data berhasil dihapus',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(function() {
                                    table.draw();
                                })

                            },
                            error: function(data) {
                                console.log(data)
                            }
                        });

                    }
                })

            });

        });
    </script>
@endpush
