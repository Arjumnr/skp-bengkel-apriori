<div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Form Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="data_id" id="data_id">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Enter your Produk" />
                    </div>

                    <div class="mb-3">
                        <label for="stock" class="form-label">Stok</label>
                        <input type="number" class="form-control" id="stock" name="stock"
                            placeholder="Enter your Stok" />
                    </div>
                    <div class="mb-3">
                        <label for="capital" class="form-label">Harga Beli</label>
                        <input type="number" class="form-control" id="capital" name="capital"
                            placeholder="Enter your Harga Beli" />
                    </div>
                    <div class="mb-3">
                        <label for="sell" class="form-label">Harga Jual</label>
                        <input type="number" class="form-control" id="sell" name="sell"
                            placeholder="Enter your Harga Jual" />
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
