@extends($activeTemplate.'layouts.master')

@section('content')
    <div class="container pt-120 pb-120">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card border">

                    <div class="card-body p-sm-5 p-3">

                        <div class="reset-header mb-5 text-center">
                            <div class="icon"><i class="las la-lock"></i></div>
                            <h3 class="mt-3">@lang('Reset Password')</h3>
                            <p>@lang('Enter your current password and new password')</p>
                        </div>

                        <form action="" method="post" class="register">
                            @csrf
                            <div class="form-group">
                                <label for="password">{{trans('Current Password')}}</label>
                                <input id="password" type="password" class="form-control" name="current_password" required
                                       autocomplete="current-password">
                            </div>

                            <div class="form-group">
                                <label for="password">{{trans('Password')}}</label>
                                <input id="password" type="password" class="form-control" name="password" required
                                       autocomplete="current-password">
                            </div>


                            <div class="form-group">
                                <label for="confirm_password">{{trans('Confirm Password')}}</label>
                                <input id="password_confirmation" type="password" class="form-control"
                                       name="password_confirmation" required autocomplete="current-password">
                            </div>


                            <div class="form-group">
                                <button type="submit" class="mt-4 cmn-btn btn-block">@lang('Change Password')</button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection


@push('script')

@endpush

