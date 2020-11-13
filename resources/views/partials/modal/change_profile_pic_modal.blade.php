<div id="profilePhoto" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="profilePhotoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profilePhotoLabel">Change Profile Picture</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('upload_image') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row py-4">
                                <div class="col-lg-8 mx-auto">
                                    <!-- Upload image input-->
                                    <div class="input-group mb-3 px-2 py-2 rounded-pill bg-white shadow-sm">
                                        <input id="upload" type="file" onchange="readURL(this);"
                                            name="profile_picture" class="form-control border-0">
                                        <label id="upload-label" for="upload"
                                            class="font-weight-light text-muted">Choose Picture</label>
                                        <div class="input-group-append">
                                            <label for="upload" class="btn btn-light m-0 rounded-pill px-4">
                                                <i class="fa fa-cloud-upload mr-2 text-muted"></i>
                                                <small class="text-uppercase font-weight-bold text-muted">Choose
                                                    file</small>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="image-area mt-4"><img id="imageResult" src="#" alt=""
                                            class="img-fluid rounded shadow-sm mx-auto d-block"></div>

                                </div>
                            </div>
                        <div class=" text-center mt-4">
                            <button class="btn btn-primary" id='financeButton' type="submit">
                                <i class="fa fa-fw fa-lg fa-check-circle"></i> Update</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->