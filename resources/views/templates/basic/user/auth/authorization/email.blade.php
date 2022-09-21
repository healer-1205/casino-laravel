@extends($activeTemplate .'layouts.frontend')
@section('content')
    <div class="container pt-120 pb-120">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">@lang('Please Verify Your Email to Get Access')</div>

                    <div class="card-body">

                        <form action="{{route('user.verify.email')}}" method="POST" class="login-form">
                            @csrf

                            <div class="form-group">
                                <p class="text-center">@lang('Your Email'): <strong>{{auth()->user()->email}}</strong>
                                </p>
                            </div>


                            <div class="form-group">
                                <label class="">@lang('Verification Code')</label>
                                <input type="text" name="email_verified_code" class="form-control" maxlength="7"
                                       id="code">
                            </div>


                            <div class="form-group">
                                <div class="btn-area text-center">
                                    <button type="submit" class="cmn-btn">@lang('Submit')</button>
                                </div>
                            </div>


                            <div class="form-group">
                                <p>@lang('Please check including your Junk/Spam Folder. if not found, you can') <a
                                        href="{{route('user.send.verify.code')}}?type=email"
                                        class="forget-pass"> @lang('Resend code')</a></p>
                                @if ($errors->has('resend'))
                                    <br/>
                                    <small class="text-danger">{{ $errors->first('resend') }}</small>
                                @endif
                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        (function ($) {
            "use strict";
            $('#code').on('input change', function () {
                var xx = document.getElementById('code').value;
                
                $(this).val(function (index, value) {
                    value = value.substr(0, 7);
                    return value.replace(/\W/gi, '').replace(/(.{3})/g, '$1 ');
                });

            });
        })(jQuery)
    </script>
@endpush
