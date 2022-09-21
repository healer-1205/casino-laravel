@extends($activeTemplate.'layouts.auth')
@section('content')
    <!-- account section start -->
    @php
        $loginContent = getContent('login.content',true);
    @endphp
    <section class="login-section bg_img" style="background-image: url( {{ getImage('assets/images/frontend/login/' . @$loginContent->data_values->image, '1920x1280') }} );">
        <div class="login-area">
            <div class="login-area-inner">
                <div class="text-center">
                    <a class="site-logo mb-4" href="{{ route('home') }}"><img
                            src="{{ asset('assets/images/logoIcon/logo.png') }}" alt="site-logo"></a>
                    <h2 class="title mb-2">{{ __($loginContent->data_values->title) }}</h2>
                    <p>{{ __($loginContent->data_values->sub_title) }}</p>
                </div>
                <form method="POST" action="{{ route('user.login')}}" onsubmit="return submitUserForm();" class="login-form mt-50">
                    @csrf
                    <div class="form-group">
                        <label>@lang('Username or Email')</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="las la-user"></i></div>
                            </div>
                            <input type="text" class="form-control" value="{{ old('username') }}" name="username" placeholder="@lang('Username or Email')">
                        </div>
                    </div><!-- form-group end -->
                    <div class="form-group">
                        <label>@lang('Password')</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="las la-key"></i></div>
                            </div>
                            <input type="password" class="form-control" name="password" placeholder="@lang('Password')">
                        </div>
                    </div><!-- form-group end -->

                    <div class="d-flex justify-content-center mb-3">
                        @php echo loadReCaptcha() @endphp
                    </div>

                    @include($activeTemplate.'partials.custom_captcha')

                    <div class="mt-5">
                        <button type="submit" class="cmn-btn rounded-0 w-100">@lang('Login Now')</button>
                        <div class="mt-20 d-flex flex-wrap justify-content-between">
                            <p>@lang("Haven't an account?") <a href="{{ route('user.register') }}"  class="text--base">@lang('Create an account')</a></p>
                            <p><a href="{{ route('user.password.request') }}"  class="text--base">@lang('Forget password?')</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- account section end -->
@endsection

@push('script')
    <script>
        "use strict";
        function submitUserForm() {
            var response = grecaptcha.getResponse();
            if (response.length == 0) {
                document.getElementById('g-recaptcha-error').innerHTML = '<span class="text-danger">@lang("Captcha field is required.")</span>';
                return false;
            }
            return true;
        }

    </script>
@endpush
