@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            console.log('ready!');
            // $('#modalID').modal('show');

            var table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('transaksi.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'total_price',
                        name: 'total_price',
                        render: function(data, type, row) {
                            //set Rp. 
                            return 'Rp. ' + data.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g,
                                '$1.'); //number format to currency
                        }
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
                    "ajax": "{{ route('transaksi.index') }}",
                    "columns": [{
                            "data": "name"
                        },
                        {
                            "data": "total_price"
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
            });


            $('#form').on('submit', function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                var id = $('#data_id').val();
                var url = "{{ route('transaksi.store') }}";
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
                            url: "{{ route('transaksi.store') }}" + '/' + id,

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