@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            console.log('ready!');


            // $('#modalID').modal('show');

            var table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('transaksi-item.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'get_transaction.name',
                        name: 'get_transaction.name'
                    },
                    {
                        data: 'get_product.name',
                        name: 'get_product.name'
                    },
                    {
                        data: 'qty',
                        name: 'qty'
                    },
                    {
                        data: 'price',
                        name: 'price',
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
                    "ajax": "{{ route('transaksi-item.index') }}",
                    "columns": [{
                            "data": "get_transaction.name"
                        },
                        {
                            "data": "get_product.name",
                        },
                        {
                            "data": "qty"
                        },
                        {
                            "data": "price",
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



            // Function to calculate total payment
            function calculateTotal() {
                let total = 0;

                // Iterate through each checked product and calculate total
                $('input[name^="produk"]:checked').each(function() {
                    let productId = $(this).val();
                    let qty = parseInt($(`input[name="qty[${productId}]"]`).val()) || 0;
                    let priceText = $(this).closest('tr').find('td:nth-child(4)').text().replace('Rp', '')
                        .replace(/\./g, '').trim();
                    let price = parseFloat(priceText) || 0;

                    // Calculate total price for each selected product
                    let totalPrice = qty * price;
                    total += totalPrice;

                    // Update the Total Harga input for the specific product
                    $(`input[name="price[${productId}]"]`).val(totalPrice);
                });

                // Set the calculated total to the Total Bayar input
                $('#total_price').val(total);
            }

            // Event listener for qty input change
            $('body').on('input', 'input[name^="qty"]', function() {
                calculateTotal();
            });

            // Event listener for checkbox change (selecting product)
            $('body').on('change', 'input[name^="produk"]', function() {
                calculateTotal();
            });
            // Other existing event listeners and functions...

            $('#form').on('submit', function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                var id = $('#data_id').val();
                var url = "{{ route('transaksi-item.store') }}";
                if (id != '') {
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
                                //reload url
                                window.location.reload();

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

            // Edit event handler
            $('body').on('click', '.edit', function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var id = $(this).data('id');

                $.get("{{ route('transaksi-item.index') }}" + '/' + id + '/edit', function(data) {
                    console.log(JSON.stringify(data));
                    

                    $('#data_id').val(id);
                    console.log(id);
                    $('#name').val(data.transaction.name);
                    $('#total_price').val(data.transaction
                    .total_price); // Assuming this is 'Total Bayar'

                    // Clear existing product checkboxes and quantities
                    $('input[name="produk[]"]').prop('checked', false);
                    $('input[name^="qty["]').val('');

                    // Populate product checkboxes and quantities
                    $.each(data.data, function(index, product) {
                        // Set checkbox for the specific product to checked
                        $('#produk' + product.product_id).prop('checked', true);
                        // Set quantity for the specific product
                        $('input[name="qty[' + product.product_id + ']"]').val(product.qty);
                        // Set price for the specific product
                        $('input[name="price[' + product.product_id + ']"]').val(product.price);
                    });


                    //if produk is unchecked
                    $('input[name^="produk"]').on('change', function() {
                        if ($(this).is(':checked')) {
                            $('input[name="qty[' + $(this).val() + ']"]').prop('disabled', false);
                        } else {
                            $('input[name="qty[' + $(this).val() + ']"]').val('');
                            $('input[name="price[' + $(this).val() + ']"]').val('');
                        }
                    });



                    // Show the modal
                    $('#basicModal').modal('show');
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    console.error("Failed to fetch data: " + textStatus, errorThrown);
                    alert('Terjadi kesalahan saat memuat data. Silakan coba lagi.');
                });
            });



            // Delete event handler
            $('body').on('click', '.delete', function() {
                var id = $(this).data("id");
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
                            url: "{{ route('transaksi-item.store') }}" + '/' + id,
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
