@extends('layouts.auth.app')
@section('content')
    <div class="col-9 col-md-9 col-lg-9 d-flex justify-content-center div-login-image">
        <img class="img-fluid mx-auto d-block image-login" src="{{ asset('images/login3.jpg') }}" />
    </div>
    <div class="col-3 col-md-3 col-lg-3 form-login">
        <form class="form-horizontal" method="POST" action="{{ route('login') }}" style="width: 60%;">
            {{ csrf_field() }}
            <div class="form-group">
                <div class="text-center text-secondary" style="padding: 5%;">
                    {{-- ! Display Errors. --}}
                    @if (count($errors))
                        <div class="col-xs-12 col-md-12 col-lg-12 p-0">
                            <div class="alert alert-danger">
                                {{ $errors->all()[0] }}
                            </div>
                        </div>
                    @endif
                    <h1>Welcome!</h1>
                    <span>Please Login Firsst</span>
                </div>
                <div class="mb-2 input-group">
                    <span class="input-group-text bg-white border-right-0 border-radius-0">
                        <i class="feather icon-users text-primary"></i>
                    </span>
                    <input type="text" name="nik" id="nik"
                        class="form-control text-primary border-left-0 border-radius-0" placeholder="NIK">
                </div>
                <div class="mt-2 input-group">
                    <span class="input-group-text bg-white border-right-0 border-radius-0">
                        <i class="feather icon-lock text-primary"></i>
                    </span>
                    <input type="password" name="password" id="password"
                        class="form-control text-primary border-left-0 border-right-0 border-radius-0"
                        placeholder="Password">
                    <button type="button" id="btn-show-hide-password"
                        class="input-group-text bg-white border-left-0 border-radius-0">
                        <i class="feather icon-eye-off text-primary"></i>
                    </button>
                </div>
                <div class="mt-2">
                    <button type="submit" id="btn-submit" class="btn btn-primary" style="width: 100%;">
                        Login
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('script')
    <script>
        $('body').on('click', '#btn-show-hide-password', function(e) {
            e.preventDefault();
            ShowHidePassword();
        });

        function ShowHidePassword() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
                $('#btn-show-hide-password').children().removeClass('icon-eye-off');
                $('#btn-show-hide-password').children().addClass('icon-eye');
            } else {
                x.type = "password";
                $('#btn-show-hide-password').children().removeClass('icon-eye');
                $('#btn-show-hide-password').children().addClass('icon-eye-off');
            }
        }
    </script>
@endsection
