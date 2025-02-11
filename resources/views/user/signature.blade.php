@include('layout.app')
<main class="py-4">
    <div class="container full-height">
        <div class="row row-height">
            <div class="col-lg-12 content-right" id="start">
                <div id="wizard_container">
                    <form action="{{ route('verify.signature', $doc_id) }}" method="POST" id="add-signature">
                        @csrf
                        <div id="middle-wizard">
                            <div class="step">
                                <div class="nine">
                                    <h1>E Signature<span>Please sign here</span></h1>
                                </div>
                                <div class="dash-div">
                                    <div class="main-box custom-box">
                                        <input type="hidden" name="signature" value="" id="signature">
                                        <div class="border-main-on text-center">
                                            <div class="wrapper border bg-light">
                                                <canvas id="signature-pad" class="signature-pad"
                                                    style="width: 100%;height: 350px;"></canvas>
                                            </div>
                                            <div class="col-md-4 mx-auto  mt-2">
                                                <button type="button" id="clear"
                                                    class="btn btn-primary btn-c-2 w-100 mt-2">CLEAR
                                                </button>
                                            </div>
                                        </div>
                                        <div class=" main-row  mt-2">
                                            <div class="col-md-12">
                                                <div class="row mx-auto justify-content-center">
                                                    <div class="col-md-4">
                                                        <a href="{{ route('dashboard') }}"
                                                            class="btn btn-primary btn-q-2 w-100 mt-2">BACK</a>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <button type="submit" name="agree"
                                                            class="btn btn-primary btn-q-1 w-100 mt-2">I agree</button>
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
<script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
<script type="text/javascript">
    var sign = '';
    var canvas = document.getElementById('signature-pad');

    function resizeCanvas() {
        var ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext("2d").scale(ratio, ratio);
    }

    resizeCanvas();

    var signaturePad = new SignaturePad(canvas, {
        backgroundColor: 'rgba(255, 255, 255, 0)'
    });


    document.getElementById('clear').addEventListener('click', function() {
        signaturePad.clear();
    });

    function download(dataURL, filename) {
        if (navigator.userAgent.indexOf("Safari") > -1 && navigator.userAgent.indexOf("Chrome") === -1) {
            window.open(dataURL);
        } else {
            var blob = dataURLToBlob(dataURL);
            var url = window.URL.createObjectURL(blob);

            var a = document.createElement("a");
            a.style = "display: none";
            a.href = url;
            a.download = filename;

            document.body.appendChild(a);
            a.click();

            window.URL.revokeObjectURL(url);
        }
    }

    function dataURLToBlob(dataURL) {
        // Code taken from https://github.com/ebidel/filer.js
        var parts = dataURL.split(';base64,');
        var contentType = parts[0].split(":")[1];
        var raw = window.atob(parts[1]);
        var rawLength = raw.length;
        var uInt8Array = new Uint8Array(rawLength);

        for (var i = 0; i < rawLength; ++i) {
            uInt8Array[i] = raw.charCodeAt(i);
        }

        return new Blob([uInt8Array], {
            type: contentType
        });
    }

    $("#add-signature").submit(function() {
        var data = signaturePad.toDataURL('image/png');
        if (!signaturePad.isEmpty()) {
            $('#signature').val(data);
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Doctor signature is required.',
                showCancelButton: false,
                allowOutsideClick: false,
                confirmButtonColor: '#202a44',
                confirmButtonText: 'Ok',
                timer: 3000,
                timerProgressBar: true,
            })
            return false;
        }
    });
</script>
