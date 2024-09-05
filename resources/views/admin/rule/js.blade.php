@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            console.log('ready!');
            // $('#modalID').modal('show');

            var table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('rule.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'rule',
                        name: 'rule'
                    },

                    {
                        data: 'support',
                        name: 'support'
                    },
                    {
                        data: 'confidence',
                        name: 'confidence'
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
                    "ajax": "{{ route('rule.index') }}",
                    "columns": [{
                            "data": "rule"
                        },

                        {
                            "data": "support"
                        },
                        {
                            "data": "confidence"
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
                // $('#form').attr('action', "{{ route('rule.store') }}");
            });


            $('#form').on('submit', function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                var id = $('#data_id').val();
                var url = "{{ route('rule.store') }}";
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

                var id = $(this).data('id');

                $.get("{{ route('rule.edit', ':id') }}".replace(':id', id), function(data) {
                    console.log("data_id = " + id);
                    $('#data_id').val(data.data.id);
                    $('#support').val(data.data.support);
                    $('#confidence').val(data.data.confidence);

                    // Clear previous options and checkbox selections
                    $('input[name="produk[]"]').prop('checked', false);


                    // Daftar ID produk yang ingin dicentang
                    var productIdsToCheck = data.data.rule; // to array 
                    console.log(productIdsToCheck);
                    var productIdsToCheck = productIdsToCheck.split(',');

                    // Iterasi melalui daftar ID produk yang ingin dicentang
                    $.each(productIdsToCheck, function(index, productId) {
                        console.log('Checking product ID:', productId);
                        $('input[name="produk[]"][value="' + productId + '"]').prop(
                            'checked', true);
                    });





                    // Update modal title if needed
                    $('#modal-title').text('Edit Rule');
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    console.error('Edit request failed: ', textStatus, errorThrown);
                });
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
                            url: "{{ route('rule.store') }}" + '/' + id,

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
