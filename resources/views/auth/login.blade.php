@extends('layouts.base')
@section('content')
<style>
	.m-login.m-login--2 .m-login__wrapper .m-login__container .m-login__form .m-form__group .form-control {
		padding: 1rem 1.5rem !important;
	}
</style>
<!-- begin::Body -->
<body  class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">
	<div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-2" id="m_login" style="background-image: url({{ asset('assets/app/media/img//bg/bg-3.jpg') }});">
	<div class="m-grid__item m-grid__item--fluid	m-login__wrapper">
		<div class="m-login__container">
			<div class="m-login__logo">
				<img src="{{ asset('assets/app/media/img/misc/dashboard.png') }}" width="220px" height="150px">  	
			</div>
			<div class="m-login__signin">
				<div class="m-login__head">
					<h3 class="m-login__title">Sign In To Admin</h3>
				</div>
				<form class="m-login__form m-form" role="form" action="{{ route('login') }}" method="post" id="form_login">
					{{ csrf_field() }}
					<div class="form-group m-form__group">
						<input class="form-control m-input" type="text" placeholder="Email" name="email" autocomplete="off" value="{{ old('email') }}" required autofocus>
						@if ($errors->has('email'))
	                        <span class="help-block" style="color:red">
	                            <strong>{{ $errors->first('email') }}</strong>
	                        </span>
	                    @endif
					</div>
					<div class="form-group m-form__group">
						<input class="form-control m-input m-login__form-input--last" type="password" placeholder="Password" name="password">
						@if ($errors->has('password'))
	                        <span class="help-block" style="color:red">
	                            <strong>{{ $errors->first('password') }}</strong>
	                        </span>
	                    @endif
					</div>
					<div class="row m-login__form-sub">
						<div class="col m--align-left m-login__form-left">
							<label class="m-checkbox  m-checkbox--focus">
							<input type="checkbox" name="remember" value="1"> Remember me
							<span></span>
							</label>
						</div>
					</div>
					<div class="m-login__form-action">{{-- 
						<span id="execute-loading" style="display: none;"><img src="{{ asset('assets/demo/default/media/img/misc/loading.gif') }}"></span> --}}
						<button id="m_login_signin_submit" type="submit" name="simpan" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">Sign In</button>
					</div>
				</form>
			</div>
		</div>	
	</div>
</div>		
</div>
<!-- end:: Page -->
</body>
<!-- end::Body -->
<!--begin::Page Snippets --> 
{{-- <script src="{{ asset('assets/snippets/custom/pages/user/login.js') }}" type="text/javascript"></script> --}}
<!--end::Page Snippets -->

{!! JsValidator::formRequest('App\Http\Requests\auth\LoginRequest', '#form_login') !!}
<script type="text/javascript">
    $(document).ready(function(){
        /**
        * Action before submit form
        */
        $('#form_login').on('submit', function (e) {
            // form is valid
            is_form_valid = $('#form_login').valid();
            if(is_form_valid == true){
                $('button[name="simpan"]').attr('disabled', 'disabled');
                $('button[name="simpan"]').addClass('m-loader m-loader--light m-loader--left');
                //$('#execute-loading').css({'display': 'block'});
            }
        });
    });
</script>
@endsection