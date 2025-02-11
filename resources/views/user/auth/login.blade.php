@include('layout.header')
<body class="login-body">
    <div class="limiter">
        <div class="col-xl-6 col-lg-8 col-md-12 col-sm-12 col-xs-12 text-center mx-auto">
            <div class="col-md-12 mx-auto ">
                <img src="{{ asset('assets/img/logo.svg') }}" class="logo mt-4 mb-1" width="50%">
            </div>
            <div class="container-login100">
                <div class="subb-div col-xl-12  col-lg-12  col-md-8 col-xs-12 col-sm-12  mx-auto">
                    <form class="login100-form validate-form flex-sb flex-w" id="loginForm"
                        action="{{ route('post.login') }}">
                        @csrf
                        <div class="alert alert-danger alert-block w-100" id="login_error" style="display: none;">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong id="login_error_message"></strong>
                        </div>
                        <div class="wrap-input100 validate-input m-b-12">
                            <input class="input100" type="text" name="employee_code" id="employee_code"
                                placeholder="Employee Code*" />
                            <span class="focus-input100"></span>
                        </div>
                        <span class="text-danger pb-4" id="employee_code_error"></span>
                        {{-- .alert-validate::after and before effect css commented --}}
                        <div class="wrap-input100 validate-input m-b-12">
                            <span class="btn-show-pass">
                                <i class="fa fa-eye"></i>
                            </span>
                            <input class="input100" type="password" id="password" name="password"
                                placeholder="Password*" />
                            <span class="focus-input100"></span>
                        </div>
                        <span class="text-danger" id="password_error"></span>
                        <div class="container-login100-form-btn mt-4">
                            <button type="button" id="loginButton" class="login100-form-btn">Login</button>
                        </div>
                    </form>
                    <div class="flex-sb-m w-full  justify-content-center mt-12">
                        <a class="txt3" href="{{ route('forget-password') }}">Forgot Password</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/admin/signin.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>
</html>
