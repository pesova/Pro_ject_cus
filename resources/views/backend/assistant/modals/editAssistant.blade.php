<div id="editAssistant" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="addAssistantModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAssistantModalLabel">Edit Store Assistant</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="editForm">
                    @csrf
                    @method('PUT')

                    <div class="form-group row mb-2">
                        <label for="edit_name" class="col-md-3 col-form-label my-label">Name:</label>
                        <br>
                        <div class="col-md-9">
                            <input name="edit_name" type="text" class="form-control" id="edit_name" placeholder="Enter name here"
                            >
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <label for="address" class="col-md-3 col-form-label my-label">Email:</label>
                        <br>
                        <div class="col-md-9">
                            <input name="edit_email" type="email" class="form-control" id="edit_email" required
                                placeholder="Enter Address">
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <label for="inputphone" class="col-md-3 col-form-label my-label">Phone Number:</label>
                        <br>
                        <div class="col-md-9">
                            <input type="tel" name="edit_phone" id="edit_phone" class="form-control"
                                 required>
                            <input type="hidden" name="edit_phone_number" id="edit_phone_number" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <label for="number" class="col-md-3 col-form-label my-label">Store:</label>
                        <br>
                        <div class="col-md-9">
                            <select name="edit_store_id" id="edit_store_id"  class="form-control">
                                <option value=""> Select Store</option>
                                @foreach($stores as $store)
                                @if(is_array($store))
                                <option value="{{$store[0]->_id}}"
                                    >
                                    {{$store[0]->store_name}}</option>
                                @else
                                <option value="{{$store->_id}}">
                                    {{$store->store_name}}
                                </option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group my-4 text-right">
                        <button type="submit" class="btn btn-primary my-button">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
