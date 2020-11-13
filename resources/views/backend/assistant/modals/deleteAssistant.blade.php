<div id="deleteModal" class="modal fade bd-example-modal-sm" tabindex="-2" role="dialog"
    aria-labelledby="deleteModal" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModal">
                    Delete Assistant </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Do you want to delete <span class="assistant-name"></span> ?
            </div>
            <div class="modal-footer">
                <form  method="POST" id="deleteForm">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-primary btn-danger">
                        Delete
                    </button>
                </form>
                <button type="button" class="btn btn-warning" data-dismiss="modal">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>
