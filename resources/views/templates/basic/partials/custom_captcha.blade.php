@php
	$captcha = loadCustomCaptcha();
@endphp
@if($captcha)
    <div class="form-group col-md-6">
        @php echo $captcha @endphp
    </div>
    <div class="form-group col-md-6">
        <input type="text" name="captcha" placeholder="@lang('Enter Code')" class="form-control" required>
    </div>
@endif
