@php
	$captcha = loadCustomCaptcha();
@endphp
@if($captcha)
    <div class="col-lg-12 form-group">
        @php echo $captcha @endphp
    </div>
        <div class="col-lg-12 form-group">
            <input type="text" name="captcha" placeholder="@lang('Enter Code')" class="form-control form--control">
        </div>
    </div>
@endif
