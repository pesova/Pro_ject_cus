<div class="modal fade" id="businessCard1" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Available Cards</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Carousel markup goes in the modal body -->
                <div id="businessCardCarousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active" data-version="v2">
                            <img class="d-block w-100" src="{{asset('backend/assets/images/card_v2.PNG')}}">
                        </div>
                        <div class="carousel-item" data-version="v1">
                            <img class="d-block w-100" src="{{asset('backend/assets/images/card_vv1.PNG')}}">
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#businessCardCarousel" role="button" data-slide="prev">
                    <span aria-hidden="true" class="text-dark"><i class="fa fa-chevron-left"></i></span>
                    <span class="sr-only" class="text-dark">Previous</span>
                </a>
                <a class="carousel-control-next" href="#businessCardCarousel" role="button" data-slide="next">
                    <span aria-hidden="true" class="text-dark"><i class="fa fa-chevron-right"></i></span>
                    <span class="sr-only" class="text-dark">Next</span>
                </a>
            </div>
        </div>
        <div class="modal-footer" style="display: none">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close-light-box">Close</button>
        </div>

    </div>
    <div class="text-center padup">
        <form action="{{route('preview', $store->_id)}}" method="post" id="preview-form">
            @csrf
            <input type="hidden" name="version" class="version">
        </form>
        <button data-dismiss="modal" data-toggle="modal" data-target="#downloadCard" id="first_download_button"
            class="btn btn-success mr-2">
            <i class="far mr-2 fa-card"></i> Download
        </button>
        <button id="previewBtn" class="btn btn-primary mr-2">
            <i class="far mr-2 fa-card"></i> Preview
        </button>
    </div>
</div>
