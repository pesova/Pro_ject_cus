<div id="deleteModal-{{$response->_id}}" class="modal fade bd-example-modal-sm" tabindex="-2" role="dialog"
    aria-labelledby="deleteModal-{{$response->_id}}" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModal-{{$response->_id}}">
                    Delete Complaint </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Do you want to delete <b> {{$response->subject}}</b>?
            </div>
            <div class="modal-footer">
                <form action="{{ route('complaint.destroy', $response->_id) }}" method="POST" id="form">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-primary btn-danger">
                        Delete
                    </button>
                </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No,
                    I changed my mind
                </button>
            </div>
        </div>
    </div>
</div>
