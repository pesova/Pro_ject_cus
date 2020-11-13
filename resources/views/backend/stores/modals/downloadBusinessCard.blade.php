<div class="modal fade" tabindex="-1" role="dialog" id="downloadCard">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Choose Format</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('download', $store->_id)}}" method="post" id="download-form">
                    @csrf
                    <input type="hidden" name="version" class="version">
                    <input type="hidden" name="type">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="format" id="exampleRadios1" value="image"
                            checked>
                        <label class="form-check-label" for="exampleRadios1">
                            Image Format
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="format" id="exampleRadios2" value="pdf">
                        <label class="form-check-label" for="exampleRadios2">
                            PDF Format
                        </label>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button id="download" class="btn btn-success mr-2">
                    <i class="far mr-2 fa-card">
                    </i>Download
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    id="close-download-options">Close</button>
            </div>
        </div>
    </div>
</div>