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
                        name: 'confidence',
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

            



            var tableFrekuensiItemset1 = $('#data-table-frekuensi-itemset-1').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('frekuensi-itemset-1.index') }}", // Add route for fetching data
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    }, // Assuming you want an index column
                    {
                        data: 'product_name',
                        name: 'product_name'
                    },
                    {
                        data: 'purchase_count',
                        name: 'purchase_count'
                    }
                ],
                // Optional: Add extra settings if needed
                // order: [[1, 'desc']], // Example: Order by the second column (purchase_count) in descending order
            });

            var tableSupportMinimum = $('#data-table-support-minimum').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('support-minimum.index') }}",
                    data: function(d) {
                        // Tambahkan parameter tambahan jika diperlukan
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    }, // Index column
                    {
                        data: 'itemset',
                        name: 'itemset'
                    }, // Nama produk atau kombinasi produk
                    {
                        data: 'qty',
                        name: 'qty'
                    }, // Jumlah transaksi
                    {
                        data: 'support',
                        name: 'support'
                    }, // Nilai support
                    {
                        data: 'frequent',
                        name: 'frequent'
                    } // Frequent
                ],
                order: [
                    [2, 'desc'] // Urutkan berdasarkan qty dalam urutan menurun
                ],
            });

            var tableKombinasi2Itemset = $('#data-table-kombinasi-itemset').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('kombinasi-itemset.index') }}",
                    data: function(d) {
                        // Tambahkan parameter tambahan jika diperlukan
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    }, // Index column
                    {
                        data: 'itemset',
                        name: 'itemset'
                    }, // Kombinasi itemset
                    {
                        data: 'qty',
                        name: 'qty'
                    }, // Jumlah kombinasi
                    {
                        data: 'support',
                        name: 'support'
                    }, // Nilai support
                    {
                        data: 'frequent',
                        name: 'frequent'
                    } // Frequent
                ],
                order: [
                    [2, 'desc'] // Urutkan berdasarkan qty dalam urutan menurun
                ],
            });

            var tableHitung = $('#data-table-hitung').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('hitung.index') }}", // Ganti dengan route endpoint yang sesuai
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    }, // Kolom index
                    {
                        data: 'rule',
                        name: 'rule'
                    }, // Kolom untuk aturan asosiasi
                    {
                        data: 'support',
                        name: 'support'
                    }, // Kolom untuk support
                    {
                        data: 'confidence',
                        name: 'confidence'
                    } // Kolom untuk confidence
                ],
                order: [
                    [2, 'desc']
                ] // Urutkan berdasarkan support (kolom ke-3) secara descending
            });


        });
    </script>
@endpush
