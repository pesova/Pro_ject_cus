<div id="editStore" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editStoreModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStoreModalLabel">Edit Business</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card">
                <div class="card-body">
                    <form id="editStore_form" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="edit_store_name">Business Name*</label>
                                <input type="text" name="edit_store_name" class="form-control" placeholder="XYZ Stores"
                                    id="edit_store_name" required minlength="2" maxlength="16">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="edit_Tagline">Tagline*</label>
                                <input type="text" name="edit_tagline" class="form-control" id="edit_tagline" required
                                    minlength="4" maxlength="50">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="form-control-label">Phone Number</label>
                                <div class="input-group input-group-merge">
                                    <div class="input-group-prepend">
                                    </div>
                                    <input type="tel" id="editphone" name="" class="form-control"
                                        style="width: 100%; max-width:100%;" value="" aria-describedby="helpPhone"
                                        required>
                                    <input type="hidden" name="edit_phone_number" id="edit_phone_number"
                                        class="form-control">
                                </div>
                                <small id="helpPhone" class="form-text text-muted">Enter your number
                                    without the country code</small>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="inputEmailAddress"> Email Address*</label>
                                <input type="email" id="edit_email" name="edit_email" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputAddress">Address*</label>
                            <input type="text" name="edit_shop_address" class="form-control" required minlength="5"
                                id="edit_shop_address" maxlength="50">
                        </div>
                        <button type="submit" class="btn btn-success text-white">
                            Update Business
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>