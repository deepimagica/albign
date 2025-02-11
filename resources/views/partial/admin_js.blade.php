<script src="{{ asset('assets/js/jquery-3.4.0.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/common_scripts.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/lucide.min.js') }}"></script>

<script src="{{ asset('assets/js/main.js') }} "></script>
<script src="{{ asset('assets/js/sweetalert.js') }} "></script>
<script src="{{ asset('assets/js/fengyuanchen.github.io_cropperjs_js_cropper.js') }} "></script>
<script src="{{ asset('assets/js/select2.js') }} "></script>
<script src="{{ asset('assets/js/jquery-confirm.min.js') }}"></script>
<script>
    function showErrorDialog(message) {
        $.confirm({
            title: 'Error',
            content: message,
            type: 'red', // Error color
            typeAnimated: true,
            buttons: {
                ok: {
                    text: 'OK',
                    btnClass: 'btn-red',
                    action: function() {
                    }
                }
            }
        });
    }
</script>