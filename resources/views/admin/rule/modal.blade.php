    {{-- <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
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
                            <label for="name" class="form-label">Rule</label>
                            @foreach ($dataProduk as $item)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="produk{{ $item->id }}" name="produk[]" value="{{ $item->id }}">
                                <label class="form-check-label" for="produk{{ $item->id }}">
                                    {{ $item->name }}
                                </label>
                            </div>
                        @endforeach
                        </div>

                        <div class="mb-3">
                            <label for="support" class="form-label">Support</label>
                            <input type="number" class="form-control" id="support" name="support"
                                placeholder="Enter your support" />
                        </div>
                        <div class="mb-3">
                            <label for="confidence" class="form-label">Confidence</label>
                            <input type="number" class="form-control" id="confidence" name="confidence"
                                placeholder="Enter your confidence" />
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
    </div> --}}
