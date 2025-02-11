@include('layout.header')
<body>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <img src="{{ asset('assets/img/logo.svg') }}" style="width: 100px;margin: 0;">
        </a>
    </nav>
    <div id="app">
        <main class="py-4">
            <div class="container full-height">
                <div class="row row-height">
                    <div class="col-lg-12 content-right" id="start">
                        <div id="wizard_container">
                            <input type="hidden" id="csrf_name">
                            <div class="nine">
                                <h1>Forgot Password<span>Trouble Logging In?</span></h1>
                            </div>
                            <div id="middle-wizard">
                                <div class="step ">
                                    <div class="login" style="text-align: center;">
                                        <div class="dash-div">
                                            <div class="main-box text-center custom-box">
                                                <h4 style="margin-bottom:50px;" class="heading"><b><i>Enter your
                                                            email/mobile no and we'll send you a link to get back into
                                                            your
                                                            account.</i></b></h4>
                                                {{-- <div class="alert alert-danger alert-block">
                                                <button type="button" class="close" data-dismiss="alert">×</button>
                                                <strong></strong>
                                            </div> --}}
                                                <div class="col-md-12">
                                                    <div class="row mx-auto justify-content-center">
                                                        <div class="col-4 text-center">
                                                            <label class="container_check mt-3 text-left">Mail
                                                                <input type="radio" class="checkbox-one"
                                                                    name="is_send" value="0" checked>
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </div>
                                                        <div class="col-4 text-center">
                                                            <label class="container_check mt-3 text-left">SMS
                                                                <input type="radio" class="checkbox-one"
                                                                    name="is_send" value="1">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <label class="col-md-12 control-label">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" data-lucide="mails"
                                                        class="lucide lucide-mails icon_logo2">
                                                        <rect width="16" height="13" x="6" y="4" rx="2">
                                                        </rect>
                                                        <path d="m22 7-7.1 3.78c-.57.3-1.23.3-1.8 0L6 7"></path>
                                                        <path d="M2 8v11c0 1.1.9 2 2 2h14"></path>
                                                    </svg>Email
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="col-md-12">
                                                    <input class="form-control" type="text" name="email"
                                                        placeholder="Email Id or Mobile No">
                                                    <div class="form-control-focus"> </div>
                                                </div>
                                                <div class=" main-row">
                                                    <div class="col-md-12">
                                                        <div class="row mx-auto justify-content-center">
                                                            <div class="col-md-4">
                                                                <button type="submit" name="submit"
                                                                    class="btn btn-primary btn-q-1 w-100 mt-2">SUBMIT</button>
                                                            </div>
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
    </div>
    <script>
        // lucide.createIcons();
    </script>
</body>

</html>
