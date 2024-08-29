<script type="text/javascript">
    $(document).ready(function() {
        // $('#modalID').modal('show');
        $.noConflict();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

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

        // $('#btnTambah').on('click', function() {
        //     console.log('click');
        //     $('#modal-form').trigger("reset");
        //     $('#form').trigger("reset");
        //     // $('#modal-form').modal('show');
        //     // $('#form').attr('action', "{{ route('produk.store') }}");
        // });


        // $('#form').on('submit', function(event) {
        //     event.preventDefault();
        //     var formData = new FormData(this);
        //     var id = $('#data_id').val();
        //     var url = "{{ route('produk.store') }}";
        //     if (id != '') {
        //         //kirim id lewat form data 
        //         formData.append('data_id', id);
        //     }
        //     $.ajax({
        //         url: url,
        //         method: "POST",
        //         data: formData,
        //         contentType: false,
        //         cache: false,
        //         processData: false,
        //         dataType: "json",
        //         success: function(data) {
        //             console.log(data);
        //             if (data.status == 'success') {
        //                 Swal.fire({
        //                     position: 'center',
        //                     icon: 'success',
        //                     title: 'Berhasil',
        //                     showConfirmButton: false,
        //                     timer: 1500
        //                 }).then(function() {
        //                     table.draw();

        //                 })
        //             } else {
        //                 Swal.fire({
        //                     position: 'center',
        //                     icon: 'error',
        //                     title: 'Gagal',
        //                     showConfirmButton: false,
        //                     timer: 1500
        //                 }).then(function() {
        //                     table.draw();

        //                 })
        //             }
        //             $("#basicModal").removeClass("in");
        //             $(".modal-backdrop").remove();
        //             $("#basicModal").hide();

        //             $('#form').trigger("reset");

        //         },
        //         error: function(data) {
        //             console.log(data);


        //         }
        //     })
        // });

        // //edit
        // $('body').on('click', '.edit', function() {

        //     $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         }
        //     });

        //     // $('#btnSave').html('Update Data')

        //     var id = $(this).data('id');

        //     $.get("{{ route('produk.index') }}" + '/' + id + '/edit', function(data) {
        //         console.log("data_id = " + data.id);
        //         // $('#modalHeading').html("Edit User");
        //         // $('#btnSave').val("edit-data");
        //         // $('#basicModal').modal('show');
        //         $('#data_id').val(id);
        //         $('#nama_produk').val(data.nama_produk);
        //         $('#kategori').val(data.kategori).trigger('change');
        //         $('#modal').val(data.modal);
        //         $('#harga').val(data.harga);
        //         $('#stok').val(data.stok);

        //     })

        // });


        //del
        // $('body').on('click', '.delete', function() {

        //     var id = $(this).data("id");
        //     console.log(id)
        //     Swal.fire({
        //         title: 'Are you sure?',
        //         text: "You won't be able to revert this!",
        //         icon: 'warning',
        //         showCancelButton: true,
        //         confirmButtonColor: '#3085d6',
        //         cancelButtonColor: '#d33',
        //         confirmButtonText: 'Yes, delete it!'
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             $.ajax({
        //                 type: "DELETE",
        //                 url: "{{ route('produk.store') }}" + '/' + id,

        //                 success: function(data) {
        //                     Swal.fire({
        //                         position: 'center',
        //                         icon: 'success',
        //                         title: 'Data berhasil dihapus',
        //                         showConfirmButton: false,
        //                         timer: 1500
        //                     }).then(function() {
        //                         table.draw();
        //                     })

        //                 },
        //                 error: function(data) {
        //                     console.log(data)
        //                 }
        //             });

        //         }
        //     })

        // });

    });
</script>