@include('layout.app')
<main class="py-4">
    <div class="container full-height">
        <div class="row row-height">
            <div class="col-lg-12 content-right" id="start">
                <div id="wizard_container">
                    <form action="{{ route('verify.otp', $doc_id) }}" class="form-otp" method="POST" id="wrapped" name="detail" onsubmit = return validateForm()>
                        @csrf
                        <input type="hidden" name="doctor_id" value="{{ $doc_id }}">
                        <div id="middle-wizard">
                            <div class="nine">
                                <h1>Agreement<span>Signature Validation</span></h1>
                            </div>
                            <div class="step dash-div">
                                <div class="main-box text-center custom-box">
                                    <div class="otp-icon-div">
                                        <img src="{{ asset('asstes/img/otp.svg') }}" class="icon_logo" alt="">
                                    </div>
                                    <div class="form-group form-md-line-input">
                                        <h5 class="col-md-12 mt-3 mb-3 text-center">Enter OTP<span class="required"> *
                                            </span></h5>
                                        <div class="col-md-12 p-0">
                                            <div class="input-field">
                                                <input type="number" name="otpp[]" class="form-control otpp" />
                                                <input type="number" name="otpp[]" class="form-control otpp"
                                                    disabled />
                                                <input type="number" name="otpp[]" class="form-control otpp"
                                                    disabled />
                                                <input type="number" name="otpp[]" class="form-control otpp"
                                                    disabled />
                                            </div>
                                            <input type="hidden" name="otp" class="form-control" id="otp"
                                                placeholder="Enter 4 digit OTP" minlength="4" maxlength="4">
                                            <div class="form-control-focus"> </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <p class="mmcounter mt-2"> <i data-lucide="timer"></i>
                                            <span class='e-m-minutes'>00</span> :
                                            <span class='e-m-seconds'>30</span>
                                        </p>
                                    </div>
                                    <div class="main-row">
                                        <div class="col-md-12">
                                            <div class="row mx-auto justify-content-center">
                                                <div class="col-md-4">
                                                    <a href="" style="pointer-events: none;"
                                                        class="btn btn-primary btn-disabled-1 w-100 mt-2"
                                                        id="btn_resend_otp">Resend OTP</a>
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="submit" name="submit"
                                                        class="btn btn-primary btn-q-2 w-100 mt-2">SUBMIT
                                                    </button>
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
<script type="text/javascript">
    lucide.createIcons();

    $(".otpp").keyup(function() {
        var sample = new Array();

        $.each($("input[name='otpp[]']"), function() {
            sample.push($(this).val());
        });

        var otpValues = sample.join("");

        $("#otp").val(otpValues);

    });


    const inputs = document.querySelectorAll("input"),
        button = document.querySelector("button");

    // iterate over all inputs
    inputs.forEach((input, index1) => {
        input.addEventListener("keyup", (e) => {
            const currentInput = input,
                nextInput = input.nextElementSibling,
                prevInput = input.previousElementSibling;

            if (currentInput.value.length > 1) {
                currentInput.value = "";
                return;
            }
            if (nextInput && nextInput.hasAttribute("disabled") && currentInput.value !== "") {
                nextInput.removeAttribute("disabled");
                nextInput.focus();
            }

            if (e.key === "Backspace") {
                inputs.forEach((input, index2) => {
                    if (index1 <= index2 && prevInput) {
                        input.setAttribute("disabled", true);
                        input.value = "";
                        prevInput.focus();
                    }
                });
            }
            if (!inputs[3].disabled && inputs[3].value !== "") {
                button.classList.add("active");
                return;
            }
            button.classList.remove("active");
        });
    });

    window.addEventListener("load", () => inputs[0].focus());

    function validateForm() {
        var otp = document.forms["detail"]["otp"].value;
        if (otp == "") {
            Swal.fire({
                icon: 'error',
                title: 'Please enter 4 digit OTP!',
                showCancelButton: false,
                allowOutsideClick: false,
                confirmButtonColor: '#202a44',
                confirmButtonText: 'Ok',
                timer: 3000,
                timerProgressBar: true,

            })
            return false;
        }
        var otp = new String(otp);
        var otp = otp.valueOf();
        if (otp.length < 4 || otp.length > 4) {
            Swal.fire({
                icon: 'error',
                title: 'Please enter valid 4 digit OTP!',
                showCancelButton: false,
                allowOutsideClick: false,
                confirmButtonColor: '#202a44',
                confirmButtonText: 'Ok',
                timer: 3000,
                timerProgressBar: true,

            })
            return false;
        }
    }

    $(function() {
        function getCounterData(obj) {
            var minutes = parseInt($('.e-m-minutes', obj).text());
            var seconds = parseInt($('.e-m-seconds', obj).text());
            return seconds + (minutes * 60);
        }

        function setCounterData(s, obj) {
            var minutes = Math.floor((s % (60 * 60)) / 60);
            var seconds = Math.floor(s % 60);
            $('.e-m-minutes', obj).html(minutes);
            $('.e-m-seconds', obj).html(seconds);
        }

        var count = getCounterData($(".mmcounter"));


        var timer = setInterval(function() {
            count--;
            if (count < 0) {
                $('#btn_resend_otp').css('background', 'var(--primary)');
                $('#btn_resend_otp').css('border-color', 'var(--primary)');
                $('#btn_resend_otp').addClass('resend-otp-important');
                $('#btn_resend_otp').css('pointer-events', 'auto');
                return;
            }
            setCounterData(count, $(".mmcounter"));
        }, 1000);
    });
</script>
