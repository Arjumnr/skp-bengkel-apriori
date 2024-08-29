    <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Form Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="data_id" id="data_id">
                        <div class="mb-3">
                            <label for="nama_barang" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" id="nama_barang" name="nama_barang"
                                placeholder="Enter your Barang" />
                        </div>
                        {{-- gambar --}}
                        <div class="mb-3">
                            <label for="gambar" class="form-label">Gambar</label>
                            <input type="file" class="form-control" id="gambar" name="gambar"
                                placeholder="Enter your Gambar" />
                        </div>
                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori</label>
                            <select class="form-select" id="kategori" name="kategori">
                                <option selected>--- Pilih Kategori ---</option>
                                <option value="voucher">Vaucher</option>
                                <option value="kartu_data">Kartu Data</option>
                                <option value="kartu_biasa">Kartu Biasa</option>
                                <option value="token">Token</option>
                                <option value="pulsa">Pulsa</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="modal" class="form-label">Modal</label>
                            <input type="number" class="form-control" id="modal" name="modal"
                                placeholder="Enter your Modal" />
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="number" class="form-control" id="harga" name="harga"
                                placeholder="Enter your Harga" />
                        </div>
                        <div class="mb-3">
                            <label for="stok" class="form-label">Stok</label>
                            <input type="number" class="form-control" id="stok" name="stok"
                                placeholder="Enter your Stok" />
                        </div>
                       
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" form="form" class="btn btn-primary" id="btn-simpan">Save</button>
                </div>
            </div>
        </div>
    </div>
    