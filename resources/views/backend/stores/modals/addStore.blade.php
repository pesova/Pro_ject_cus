<div id="addStoreModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addStoreModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStoreModalLabel">Add New Business</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card">
                <div class="card-body">
                    <form id="submitForm" action="{{ route('store.store') }}" method="POST">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="store name">Business Name*</label>
                                <input type="text" name="store_name" class="form-control"
                                    value="{{ old('store_name') }}" placeholder="XYZ Stores" required minlength="2"
                                    maxlength="100">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputTagline">Tagline*</label>
                                <input type="text" name="tagline" class="form-control" id="inputTagline"
                                    value="{{ old('tagline') }}" required minlength="4" maxlength="50">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputPhoneNumber">Phone Number*</label>
                                <input type="tel" class="form-control" id="phone" aria-describedby="helpPhone" name=""
                                    value="{{ old('phone_number') }}" required pattern=".{6,16}"
                                    title="Phone number must be between 6 to 16 characters">
                                <input type="hidden" name="phone_number" id="phone_number" class="form-control">
                                <small id="helpPhone" class="form-text text-muted">Enter your number without the country
                                    code</small>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputEmailAddress"> Email Address*</label>
                                <input type="email" name="email" class="form-control" required
                                    value="{{ old('email') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputAddress">Address*</label>
                            <input type="text" name="shop_address" class="form-control"
                                value="{{ old('shop_address') }}" required minlength="5" maxlength="50">
                        </div>
                        <button type="submit" class="btn btn-success text-white" id="create-store">
                            Create Business
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>