@extends($activeTemplate.'layouts.master')
@section('content')
<section class="all-sections ptb-60">
    <div class="container-fluid">
        <div class="section-wrapper">
            <div class="row justify-content-center mb-30-none">
                @include($activeTemplate . 'partials.seller_sidebar')
                <div class="col-xl-9 col-lg-12 mb-30">
                    <div class="dashboard-sidebar-open"><i class="las la-bars"></i>@lang('Menu')</div>
                    <div class="card-area">
                        <div class="row justify-content-center">
                            <div class="col-xl-12">
                                <div class="card custom--card">
                                    <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                                        <h4 class="card-title mb-0">
                                           {{__($pageTitle)}}
                                        </h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="card-form-wrapper">
                                            <form action="" method="post" role="form">
                                                @csrf
                                                <div class="row justify-content-center mb-20-none">
                                                    <div class="col-xl-12 form-group">
                                                        <input type="password" name="current_password" class="form-control"
                                                            placeholder="@lang('Current Password')" required="">
                                                    </div>
                                                    <div class="col-xl-12 form-group hover-input-popup">
                                                        <input type="password" name="password" class="form-control"
                                                            placeholder="@lang('New Password')" required="">
                                                        @if($general->secure_password)
                                                            <div class="input-popup">
                                                              <p class="error lower">@lang('1 small letter minimum')</p>
                                                              <p class="error capital">@lang('1 capital letter minimum')</p>
                                                              <p class="error number">@lang('1 number minimum')</p>
                                                              <p class="error special">@lang('1 special character minimum')</p>
                                                              <p class="error minimum">@lang('6 character password')</p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="col-xl-12 form-group">
                                                        <input type="password" name="password_confirmation" class="form-control"
                                                            placeholder="@lang('Confirm Password')" required="">
                                                    </div>
                                                    <div class="col-xl-12 form-group">
                                                        <button type="submit" class="submit-btn w-100">@lang('CHANGE PASSWORD')</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@push('style')
<style>
    .hover-input-popup {
        position: relative;
    }
    .hover-input-popup:hover .input-popup {
        opacity: 1;
        visibility: visible;
    }
    .input-popup {
        position: absolute;
        bottom: 130%;
        left: 50%;
        width: 280px;
        background-color: #1e2746;
        color: #fff;
        padding: 20px;
        border-radius: 5px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        -ms-border-radius: 5px;
        -o-border-radius: 5px;
        -webkit-transform: translateX(-50%);
        -ms-transform: translateX(-50%);
        transform: translateX(-50%);
        opacity: 0;
        visibility: hidden;
        -webkit-transition: all 0.3s;
        -o-transition: all 0.3s;
        transition: all 0.3s;
    }
    .input-popup::after {
        position: absolute;
        content: '';
        bottom: -19px;
        left: 50%;
        margin-left: -5px;
        border-width: 10px 10px 10px 10px;
        border-style: solid;
        border-color: transparent transparent #1a1a1a transparent;
        -webkit-transform: rotate(180deg);
        -ms-transform: rotate(180deg);
        transform: rotate(180deg);
    }
    .input-popup p {
        padding-left: 20px;
        position: relative;
    }
    .input-popup p::before {
        position: absolute;
        content: '';
        font-family: 'Line Awesome Free';
        font-weight: 900;
        left: 0;
        top: 4px;
        line-height: 1;
        font-size: 18px;
    }
    .input-popup p.error {
        text-decoration: line-through;
    }
    .input-popup p.error::before {
        content: "\f057";
        color: #ea5455;
    }
    .input-popup p.success::before {
        content: "\f058";
        color: #28c76f;
    }
</style>
@endpush
@push('script-lib')
<script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
@endpush
@push('script')
<script>
    (function ($) {
        "use strict";
        @if($general->secure_password)
            $('input[name=password]').on('input',function(){
                secure_password($(this));
            });
        @endif
    })(jQuery);
</script>
@endpush
