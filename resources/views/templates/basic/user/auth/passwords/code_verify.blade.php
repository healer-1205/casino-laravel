@extends($activeTemplate.'layouts.frontend')
@section('content')
    <section class="pb-120 pt-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="account-wrapper">
                        <div class="text-center">
                            <h2 class="title mb-3">{{ __('Verification Code') }}</h2>
                        </div>
                        <form action="{{ route('user.password.verify.code') }}" method="POST" class="action-form">
                            @csrf

                            <input type="hidden" name="email" value="{{ $email }}">

                            <div class="form-group">
                                <input type="text" name="code" id="code" class="form-control">
                            </div>

                            <div class="text-center">
                                <button type="submit" class="cmn-btn">@lang('Verify Code') <i
                                        class="las la-sign-in-alt"></i></button>
                                <p class="mt-4">@lang('Please check including your Junk/Spam Folder. if not found, you can ')
                                    <a href="{{ route('user.password.request') }}">@lang('Try to send again')</a></p>
                            </div>

                        </form>
                    </div><!-- account-wrapper end -->
                </div>
            </div>
        </div>
    </section>
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
