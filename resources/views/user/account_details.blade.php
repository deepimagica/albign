@include('layout.app')
<div class="loader-div d-none">
    <div class="loading"></div>
</div>
<main class="py-4">
    <div class="container full-height">
        <div class="row row-height">
            <div class="col-lg-12 content-right" id="start">
                <div id="wizard_container">
                    <form action="{{ route('post.accountDetail', $doc_id) }}" id="doctorsInfo" method="POST">
                        @csrf
                        <input type="hidden" name="doctor_id" value="{{ $data['doctor']['id'] }}">
                        <div id="middle-wizard">
                            <div class="step">
                                <div class="nine">
                                    <h1>Participant's<span>Accounting Details</span></h1>
                                </div>
                                <div class="dash-div">
                                    <div class="main-box text-center custom-box">
                                        <h4 style="margin:0 0 30px 0;" class="heading"><b>Please Verify Accounting
                                                Details.</b></h4>
                                        <div class="mx-2" style="margin:30px 0px;">
                                            <label class="container_check mt-3 text-left">I want to edit my account
                                                details.
                                                <input type="checkbox" class="checkbox-one" name="is_edit"
                                                    id="is_edit" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-12 control-label"><i data-lucide="id-card"
                                                    class="icon_logo2"></i> Pan Card Number</label>
                                            <div class="col-md-12">
                                                <input type="text" name="pan_number" id="pan_number" readonly
                                                    class="form-control input-color readonly"
                                                    placeholder="Enter Pan card number" minlength="10" maxlength="10"
                                                    value="{{ $data['doctor']['pan_number'] }}">
                                                <div class="form-control-focus"> </div>
                                                <span class="text-danger pt-3 col-md-12 control-label"
                                                    id="pan_number_error"></span>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-12 control-label"><i data-lucide="credit-card"
                                                    class="icon_logo2"></i> Account Number</label>
                                            <div class="col-md-12">
                                                <input type="text" name="account_number" id="account_number"
                                                    class="form-control input-color readonly"
                                                    placeholder="Enter Account Number"
                                                    value="{{ $data['doctor']['account_number'] }}">
                                                <div class="form-control-focus"> </div>
                                                <span class="text-danger pt-3 col-md-12 control-label"
                                                    id="account_number_error"></span>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-12 control-label"><i data-lucide="landmark"
                                                    class="icon_logo2"></i> IFSC Code</label>
                                            <div class="col-md-12">
                                                <input type="text" name="IFSC_code" id="IFSC_code"
                                                    class="form-control input-color readonly"
                                                    placeholder="Enter IFSC Code"
                                                    value="{{ $data['doctor']['IFSC_code'] }}">
                                                <div class="form-control-focus"> </div>
                                                <span class="text-danger pt-3 col-md-12 control-label"
                                                    id="IFSC_code_error"></span>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-12 control-label"><i data-lucide="banknote"
                                                    class="icon_logo2"></i> Cancel cheque </label>
                                            <div class="col-md-12">
                                                <input type="file" name="cancel_cheque" id="cancel_cheque"
                                                    class="form-control input-color readonly"
                                                    placeholder="Enter IFSC Code">
                                                <span class="text-danger pt-3 col-md-12 control-label"
                                                    id="cancel_cheque_error"></span>
                                                <div class="form-control-focus"> </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="row mx-auto">
                                            <div class="col-md-6 p-0 d-none cropper-div">
                                                <h4 style="margin:0 0 30px 0;" class=""><i><b>Adjust
                                                            photo.</b></i></h4>

                                                <div class="cropper-view-div ">
                                                    <div id="croppedImageContainer1"
                                                        style="width:200px;height:200px;margin:auto"></div>
                                                </div>
                                                <div class="justify-content-around mx-auto col-md-12 row">
                                                    <button id="rotateButton1" type="button"
                                                        class="cheque-rotate btn btn-primary w-100 btn-c-2 mt-2">Rotate</button>
                                                    <button type="button"
                                                        class="cheque-rotate  btn btn-primary w-100 btn-c-2 mt-2"
                                                        id="zoom-button-plus-1">Zoom +</button>
                                                    <button type="button"
                                                        class="cheque-rotate  btn btn-primary w-100 btn-c-2 mt-2"
                                                        id="zoom-button-minus-1">Zoom -</button>
                                                </div>
                                            </div>
                                            <div class="col-md-6  d-none cropper-div">
                                                <h4 style="margin:0 0 30px 0;" class=""><i><b>Cropped
                                                            preview.</b></i></h4>
                                                <div class="cheque_preview" style="height:300px">
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="cancel_cheque_crop" id="cancel_cheque_crop">
                                        <div class=" d-none cropper-div">
                                            <div class="col-md-4 mx-auto mt-3">
                                                <button type="button" id="chequeCrop"
                                                    class="cropbutton border-success text-success mt-2">Crop</button>

                                            </div>
                                        </div>
                                        <div class="main-container2 success d-none">
                                            <div class="check-container2" style="height: 9rem;width: 7.5rem;">
                                                <div class="check-background">
                                                    <svg viewBox="0 0 65 51" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M7 25L27.3077 44L58.5 7" stroke="white"
                                                            stroke-width="13" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                    </svg>
                                                </div>
                                                <div class="check-shadow"></div>
                                            </div>
                                        </div>
                                        <h5 class="success d-none"><i><b>Cheque photo cropped successfully</b></i></h5>
                                        <div class=" main-row">
                                            <div class="col-md-12">
                                                <div class="row mx-auto justify-content-center">
                                                    <div class="col-md-4">
                                                        <button type="submit" name="agree"
                                                            class="btn btn-primary btn-q-1 w-100 mt-2">I
                                                            Confirm
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="{{ asset('assets/js/select2.js') }}"></script>
<script type="text/javascript">
    $("#registration_state").select2();
    lucide.createIcons();

    $("#is_edit").change(function() {
        if ($(this).prop('checked')) {
            // $("#pan_number").removeClass('readonly');
            $("#account_number").removeClass('readonly');
            $("#IFSC_code").removeClass('readonly');
            $("#cancel_cheque").removeClass('readonly');

        } else {
            $("#pan_number").addClass('readonly');
            $("#account_number").addClass('readonly');
            $("#IFSC_code").addClass('readonly');
            $("#cancel_cheque").addClass('readonly');
            $(".success").addClass('d-none');

        }

    })

    $('#chequeCrop').on('click', function() {
        $('#cancel_cheque_crop').attr('value', '');

        $(this).html('<i class="fa fa fa-circle-o-notch fa-spin"></i> wait');
        cropImage(cropper1, 'croppedImageContainer1');
    });

    function cropImage(cropper, containerId) {

        if (cropper) {
            var croppedImageDataUrl = cropper.getCroppedCanvas().toDataURL();
            $('#' + containerId).empty();
            $('#' + containerId).append('<img class="preview-image" src="' + croppedImageDataUrl +
                '" alt="Cropped Image" style="width:150px;">');
            var imagePath = croppedImageDataUrl;

            if (containerId == 'croppedImageContainer1') {
                $("#chequeCrop").html('Crop');
                $(".cropper-div").addClass('d-none');
                $(".success").removeClass('d-none');
                $("#cancel_cheque_crop").val(imagePath);
            }
        }
    }

    $(document).ready(function() {
        var cropper1;
        $('#cancel_cheque').on('change', function(event) {
            var file = event.target.files[0];
            createCropper(file, 'croppedImageContainer1', 1, 'cancel_cheque');
        });

    });

    function createCropper(fileOrUrl, containerId, cropperId, inputId) {
        var image = new Image();

        if (inputId === 'cancel_cheque') {
            var reader = new FileReader();
            reader.onload = function(e) {
                image.src = e.target.result;
                setupCropper(image, containerId, cropperId);
            };
            reader.readAsDataURL(fileOrUrl);
        } else {
            // For pre-existing image, use the provided URL
            image.src = fileOrUrl;
            setupCropper(image, containerId, cropperId);
        }
    }


    function setupCropper(image, containerId, cropperId) {
        $('#' + containerId).empty();
        $('#' + containerId).append(image);

        if (cropperId === 1) {
            $(".success").addClass('d-none');
            $(".cropper-div").removeClass('d-none');
            cropper1 = new Cropper(image, {
                aspectRatio: 16 / 9,
                viewMode: 0,
                dragMode: 'move',
                cropBoxMovable: false,
                preview: '.cheque_preview',

                cropBoxResizable: false,
                rotatable: true,
                crop: function(event) {
                    // console.log(event.detail.x);
                    // console.log(event.detail.y);
                    // console.log(event.detail.width);
                    // console.log(event.detail.height);
                }
            });

            var rotateLeftButton = document.getElementById('rotateButton1');
            rotateLeftButton.addEventListener('click', function() {
                cropper1.rotate(90);
            });
            document.getElementById('zoom-button-plus-1').addEventListener('click', function() {
                cropper1.zoom(0.1);
            });
            document.getElementById('zoom-button-minus-1').addEventListener('click', function() {
                cropper1.zoom(-0.1);
            });
        }
    }

    $(document).ready(function() {
        $('#doctorsInfo').submit(function(event) {
            event.preventDefault();
            let form = $(this);
            let formData = new FormData(this);
            formData.append('cancel_cheque_crop', $('#cancel_cheque_crop')
                .val());
            $.ajax({
                url: form.attr("action"),
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.success) {
                        window.location.href = response.redirect_url;
                    } else {
                        alert("Error: " + response.message);
                    }
                },
                error: function(response) {
                    if (response.status === 401) {} else if (response.responseJSON &&
                        response.responseJSON.errors) {
                        let errors = response.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            $("#" + key + "_error").text(value[0]);
                        });
                    }
                },
            });
        });
    });
</script>
