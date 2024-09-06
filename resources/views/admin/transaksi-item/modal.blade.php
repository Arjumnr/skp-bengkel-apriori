<div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {{-- <div class="alert alert-warning bg-warning border-0 alert-dismissible fade show" role="alert">
                A simple warning alert with solid color—check it out!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div> --}}
            <div class="modal-body">
                <form id="form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="data_id" id="data_id">
                    <div class="mb-3">
                        <label for="name" class="form-label">Pembeli</label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Nama Pembeli" />
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Produk</label>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Select</th>
                                        <th>Produk</th>
                                        <th>Stok</th>
                                        <th>Harga </th>
                                        <th>Jumlah Pembelian</th>
                                        <th>Total Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $produk) <!-- Assumes you have a $products array passed to your view -->
                                    <tr>
                                        <td>
                                            <input class="form-check-input" type="checkbox" name="produk[]" value="{{ $produk->id }}" id="produk{{ $produk->id }}">
                                        </td>
                                        <td>{{ $produk->name }}</td>
                                        <td>{{ $produk->stock }}</td> <!-- Assuming $produk->stock exists -->
                                        <td>Rp {{ number_format($produk->sell, 0, ',', '.') }}</td>                                        <!-- Assuming $produk->price exists -->
                                        <td>
                                            <input type="number" class="form-control" name="qty[{{ $produk->id }}]" min="1" max="{{ $produk->stock }}">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" name="price[{{ $produk->id }}]" readonly>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="total_price" class="form-label">Total Bayar</label>
                        <input type="text" class="form-control" id="total_price" name="total_price"
                            placeholder="0" />
                    </div>

                  
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Keluar
                </button>
                <button type="submit" form="form" class="btn btn-primary" id="btn-simpan">Simpan</button>
            </div>
        </div>
    </div>
</div>
