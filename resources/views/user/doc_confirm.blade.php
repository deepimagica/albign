@include('layout.app')
<main class="py-4">
    <div class="container full-height">
        <div class="row row-height">
            <div class="col-lg-12 content-right" id="start">
                <div id="wizard_container">
                    {{-- @dd($data['doctor']); --}}
                    <form action="{{ route('post.confirmation', $decodedDoctorId) }}" method="POST" id="detail">
                        @csrf
                        <input type="hidden" name="agree" id="agree_value" value="">
                        <input type="hidden" name="doctor_id" value="{{ $data['doctor']->id }}">
                        <div id="middle-wizard">
                            <div class="step">
                                <div class="nine">
                                    <h1>Participant's<span>Accounting Details</span></h1>
                                </div>
                                <div class="dash-div">
                                    <div class="main-box text-center custom-box">
                                        <h4 style="margin-bottom:50px;" class="heading"><b>I hereby confirm that the
                                                below-mentioned details are correct.</b></h4>
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-12 control-label"><i data-lucide="circle-fading-plus"
                                                    class="icon_logo2"></i> Dr. Name (Name required in Cheque):<span
                                                    class="required"> * </span></label>
                                            <div class="col-md-12">
                                                <input type="text" name="name" id="name"
                                                    class="form-control input-color" placeholder="Enter Doctor name"
                                                    value="{{ $data['doctor']->name }} ">
                                                <span class="text-danger pt-3 col-md-12 control-label"
                                                    id="name_error"></span>
                                                <div class="form-control-focus"> </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-12 control-label"><i data-lucide="smartphone"
                                                    class="icon_logo2"></i> Mobile Number<span class="required"> *
                                                </span></label>
                                            <div class="col-md-12">
                                                <input type="number" name="mobile" class="form-control input-color"
                                                    placeholder="Enter Mobile number" minlength="10" maxlength="10"
                                                    value="{{ $data['doctor']->mobile }}">
                                                <span class="text-danger pt-3 col-md-12 control-label"
                                                    id="mobile_error"></span>
                                                <div class="form-control-focus"> </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-12 control-label"><i data-lucide="building"
                                                    class="icon_logo2"></i> Address / City<span class="required"> *
                                                </span></label>
                                            <div class="col-md-12">
                                                <input type="text" name="address" id="address"
                                                    class="form-control input-color"
                                                    placeholder="Enter MCI Registration No"
                                                    value="{{ old('address', $data['doctor']->address) }}">
                                                <span class="text-danger pt-3 col-md-12 control-label"
                                                    id="address_error"></span>
                                                <div class="form-control-focus"> </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>

                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-12 control-label"><i data-lucide="mails"
                                                    class="icon_logo2"></i> Email<span class="required"> *
                                                </span></label>
                                            <div class="col-md-12">
                                                <input type="text" name="email" class="form-control input-color"
                                                    placeholder="Enter Email" value="{{ $data['doctor']->email }}">
                                                <span class="text-danger pt-3 col-md-12 control-label"
                                                    id="email_error"></span>
                                                <div class="form-control-focus"> </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-12 control-label"><i data-lucide="map-pin-check"
                                                    class="icon_logo2"></i> Pincode<span class="required"> *
                                                </span></label>
                                            <div class="col-md-12">
                                                <input type="text" name="pin_code" class="form-control input-color"
                                                    placeholder="Enter Pincode" value="{{ $data['doctor']->pin_code }}">
                                                <span class="text-danger pt-3 col-md-12 control-label"
                                                    id="pin_code_error"></span>
                                                <div class="form-control-focus"> </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>

                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-12 control-label"><i data-lucide="heart-pulse"
                                                    class="icon_logo2"></i> MCI Registration No<span
                                                    class="required">*
                                                </span></label>
                                            <div class="col-md-12">
                                                <input type="text" name="registration_no"
                                                    class="form-control input-color"
                                                    placeholder="Enter MCI Registration No"
                                                    value="{{ $data['doctor']->registration_no == '' ? $data['doctor']->registration_no : $data['doctor']->registration_no }}">
                                                <span class="text-danger pt-3 col-md-12 control-label"
                                                    id="registration_no_error"></span>
                                                <div class="form-control-focus"> </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class=" main-row">
                                            <div class="col-md-12">
                                                <div class="row mx-auto justify-content-center">
                                                    <div class="col-md-4">
                                                        <button type="button" name="notagree" id="notagreeBtn"
                                                            class="btn btn-primary btn-q-2 w-100 mt-2 btn-submit">I do
                                                            not
                                                            agree</button>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <button type="button" name="agree" id="agreeBtn"
                                                            class="btn btn-primary btn-q-1 w-100 mt-2 btn-submit">I
                                                            agree</button>
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
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>

<script>
    // $(document).ready(function() {
    //     $('.btn-submit').click(function() {
    //         var agreeValue = $(this).data('agree');
    //         $("#agree_value").val(agreeValue);
    //         submitForm();
    //     });

    //     function submitForm(e) {
    //         // $("#detail").submit(function(e) {
    //             // e.preventDefault();
    //             $(".text-danger").text("");
    //             let formData = $(this).serialize();
    //             $.ajax({
    //                 type: "POST",
    //                 url: $(this).attr("action"),
    //                 data: formData,
    //                 dataType: "json",
    //                 success: function(response) {
    //                     if (response.success) {
    //                         window.location.href = response.redirect_url;
    //                     } else {
    //                         console.log(response, "response");
    //                     }
    //                 },
    //                 error: function(response) {
    //                     if (response.status === 401) {
    //                         console.log("Unauthorized");
    //                     } else if (response.responseJSON && response
    //                         .responseJSON.errors) {
    //                         let errors = response.responseJSON.errors;
    //                         $.each(errors, function(key, value) {
    //                             $("#" + key + "_error").text(value[
    //                                 0]);
    //                         });
    //                     }
    //                 },
    //             });
    //         // });
    //     }
    // });


    $(document).ready(function() {
        $('.btn-submit').click(function() {
            var agreeValue = $(this).data('agree');
            $("#agree_value").val(agreeValue);

            var $form = $("#detail");

            $.ajax({
                type: "POST",
                url: $form.attr("action"),
                data: $form.serialize(),
                dataType: "json",
                success: function(response) {
                    console.log(response,"res");
                    
                    if (response.success) {
                        window.location.href = response.redirect_url;
                    } else {
                        console.log("Error in response:", response);
                    }
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 401) {
                        console.log("Unauthorized");
                    } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                        $.each(xhr.responseJSON.errors, function(key, messages) {
                            $("#" + key + "_error").text(messages[0]);
                        });
                    }
                }
            });
        });
    });

    $("#registration_state").select2();
    lucide.createIcons();
</script>
