<div id="deactivateModal-{{$user->_id}}" class="modal fade bd-example-modal-sm" tabindex="-2" role="dialog"
     aria-labelledby="deleteModal-{{$user->_id}}" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deactivateModal-{{$user->_id}}">
                    Deactivate User </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Do you want to deactivate {{$user->local->first_name}} {{$user->local->last_name}}?
            </div>
            <div class="modal-footer">
                <form action="{{ route('users.deactivate', $user->local->phone_number) }}" method="POST" id="form">
                    @method('POST')
                    @csrf
                    <button type="submit" class="btn btn-primary btn-danger">
                        Deactivate
                    </button>
                </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No,
                    I changed my mind
                </button>
            </div>
        </div>
    </div>
</div>
