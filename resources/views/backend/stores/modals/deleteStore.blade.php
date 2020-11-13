<div class="modal fade" id="deleteStore-{{ $store->_id }}" tabindex="-1" role="dialog"
    aria-labelledby="storeDeleteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="storeDeleteLabel">Delete Business</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="POST"
                action="{{ route('store.destroy', $store->_id) }}">
                <div class="modal-body">
                    @csrf
                    @method('DELETE')
                    <h6>Are you sure you want to
                        delete {{ $store->store_name }}</h6>
                </div>
                <div class="modal-footer">
                    <div class="">
                        <button type="submit" class="btn btn-primary mr-3"
                            data-dismiss="modal"><i data-feather="x"></i>
                            Close
                        </button>
                        <button type="submit" class="btn btn-danger"><i
                                data-feather="trash-2"></i> Delete
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>