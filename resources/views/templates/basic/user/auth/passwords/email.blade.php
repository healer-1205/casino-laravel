@extends('templates.basic.layouts.frontend')

@section('content')
    <section class="pb-120 pt-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="account-wrapper">
                        <div class="text-center">
                            <h2 class="title mb-3">{{ __('Reset Password') }}</h2>
                        </div>

                        <form method="POST" action="{{ route('user.password.email') }}" class="action-form">
                            @csrf

                            <div class="form-group">
                                <label for="">@lang('Select One')</label>
                                <select class="form-control mb-3" name="type">
                                    <option value="email">@lang('E-Mail Address')</option>
                                    <option value="username">@lang('Username')</option>
                                </select>
                            </div><!-- form-group end -->

                            <div class="form-group">
                                <label for="email" class="my_value">@lang('Email address')</label>
                                <input id="email" type="text" class="form-control" name="value"
                                       value="{{ old('value') }}" required>
                            </div><!-- form-group end -->

                            <div class="text-center">
                                <button type="submit" class="cmn-btn">{{ __('Send Password Reset Code') }}</button>
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

            myVal();
            $('select[name=type]').on('change', function () {
                myVal();
            });

            function myVal() {
                $('.my_value').text($('select[name=type] :selected').text());
            }
        })(jQuery)
    </script>
@endpush
