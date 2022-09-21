<!doctype html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> {{ $general->sitename(__($pageTitle)) }}</title>
    @include('partials.seo')

    <link rel="stylesheet" href="{{asset('assets/global/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/global/css/line-awesome.min.css')}}">

    <!-- bootstrap 4  -->
    <link rel="stylesheet" href="{{ asset('assets/global/css/bootstrap.min.css') }}">
    <!-- image and videos view on page plugin -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'/css/lightcase.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'/css/vendor/animate.min.css') }}">
    <!-- custom select css -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'/css/vendor/nice-select.css') }}">
    <!-- slick slider css -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'/css/vendor/slick.css') }}">
    <!-- dashdoard main css -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'/css/main.css') }}">

    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/bootstrap-fileinput.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/custom.css')}}">

    <link rel="stylesheet"
          href="{{asset($activeTemplateTrue.'css/color.php?color='.$general->base_color)}}">

    @stack('style-lib')

    @stack('style')
</head>
<body>


<div class="preloader">
    <div class="preloader__inner">
        <div class="preloader__thumb">
            <img src="{{ asset('assets/images/logoIcon/logo.png') }}" alt="imge" class="mt-3 loaderLogo">
            <img src="{{ asset($activeTemplateTrue.'/images/preloader-dice.png') }}" alt="image" class="loadercircle">
        </div>
    </div>
</div>

<div class="page-wrapper" id="main-scrollbar" data-scrollbar>
    <!-- header-section start  -->
    <header class="header">
        <div class="header__bottom">
            <div class="container">
                <nav class="navbar navbar-expand-xl p-0 align-items-center">
                    <a class="site-logo site-title" href="{{ route('home') }}"><img
                            src="{{ asset('assets/images/logoIcon/logo.png') }}" alt="site-logo"><span
                            class="logo-icon"><i class="flaticon-fire"></i></span></a>
                    <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                        <span class="menu-toggle"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        @auth
                            <ul class="navbar-nav main-menu m-auto">
                                <li><a href="{{ route('user.home') }}">@lang('Dashboard')</a></li>
                                <li class="menu_has_children">
                                    <a href="#">@lang('Deposit')</a>
                                    <ul class="sub-menu">
                                        <li><a href="{{ route('user.deposit') }}">@lang('Deposit')</a></li>
                                        <li><a href="{{ route('user.deposit.history') }}">@lang('Deposit Log')</a></li>
                                    </ul>
                                </li>
                                <li class="menu_has_children">
                                    <a href="#">@lang('Withdraw')</a>
                                    <ul class="sub-menu">
                                        <li><a href="{{ route('user.withdraw') }}">@lang('Withdraw')</a></li>
                                        <li><a href="{{ route('user.withdraw.history') }}">@lang('Withdraw Log')</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="{{ route('user.referrals') }}">@lang('Referrals')</a></li>
                                <li class="menu_has_children">
                                    <a href="#">@lang('Reports')</a>
                                    <ul class="sub-menu">
                                        <li><a href="{{ route('user.gameLog') }}">@lang('Game Log')</a></li>
                                        <li><a href="{{ route('user.commissionLog') }}">@lang('Commission Log')</a></li>
                                        <li><a href="{{ route('user.transactions') }}">@lang('Transactions')</a></li>
                                    </ul>
                                </li>
                                <li class="menu_has_children">
                                    <a href="#">@lang('Support')</a>
                                    <ul class="sub-menu">
                                        <li><a href="{{ route('ticket.open') }}">@lang('Create New')</a></li>
                                        <li><a href="{{ route('ticket') }}">@lang('My Ticket')</a></li>
                                    </ul>
                                </li>
                                <li class="menu_has_children">
                                    <a href="#">@lang('Account')</a>
                                    <ul class="sub-menu">
                                        <li><a href="{{ route('user.change.password') }}">@lang('Change Password')</a>
                                        </li>
                                        <li><a href="{{ route('user.profile.setting') }}">@lang('Profile Setting')</a>
                                        </li>
                                        <li><a href="{{ route('user.twofactor') }}">@lang('2FA Security')</a></li>
                                        <li><a href="{{ route('user.logout') }}">@lang('Logout')</a></li>
                                    </ul>
                                </li>
                            </ul>
                        @endauth

                        <div class="nav-right">
                            <select class="langSel">
                                @foreach($language as $item)
                                    <option value="{{$item->code}}"
                                            @if(session('lang') == $item->code) selected @endif>{{ __($item->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </header>
    <!-- header-section end  -->

    <!--breadcrumb area-->
@include($activeTemplate.'partials.breadcrumb')
<!--/breadcrumb area-->

@yield('content')



@php
    $footer_contents = getContent('footer.content', true);
    $footer_elements = getContent('footer.element');
    $address_content = getContent('address.content', true);
    $extra_pages = getContent('extra.element');
    $blog_elements = getContent('blog.element',false,3);

    $methodContent = getContent('payment_method.content',true);
    $methodElements = getContent('payment_method.element');
@endphp

<!-- scroll-to-top start -->
<div class="scroll-to-top">
    <span class="scroll-icon">
        <i class="las la-arrow-up"></i>
    </span>
</div>
<!-- scroll-to-top end -->

<!-- footer section start -->
<footer class="footer-section">
        <div class="payment-area">
            <div class="container border-bottom pb-5">
                <div class="row">
                    <div class="col-xl-12 text-center">
                        <h3>{{ __($methodContent->data_values->heading) }}</h3>
                    </div>
                    <div class="col-xl-12 mt-4">
                        <div class="payment-slider">
                            @foreach($methodElements as $methodElement)
                                <div class="single-slide">
                                    <div class="payment-item">
                                    <img src="{{ getImage('assets/images/frontend/payment_method/'.@$methodElement->data_values->method_image) }}" alt="image">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-top">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-4 col-md-6 text-md-left text-center">
                        <div class="footer-widget">
                            <a href="{{ route('home') }}" class="footer-logo mb-4">
                                <img src="{{ getImage(imagePath()['logoIcon']['path'] .'/logo.png') }}" alt="image">
                            </a>
                        </div>
                        <!-- footer-widget end -->
                    </div>
                    <div class="col-lg-8 col-md-6">
                        <div class="footer-widget">
                            <ul class="footer-menu justify-content-md-end justify-content-center">
                                @forelse($extra_pages as $item)
                                    <li>
                                        <a href="{{ route('extra.details', [$item->id, @slug($item->data_values->title)]) }}">{{ __(@$item->data_values->title) }}</a>
                                    </li>
                                @empty
                                @endforelse
                            </ul>
                        </div>
                        <!-- footer-widget end -->
                    </div>
                </div>
            </div>
        </div>
        <!-- footer-top end -->
        <div class="footer-bottom">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 text-md-left text-center order-lg-1 order-2">
                        <p>@lang('All rights & Copy right reserved by') <span
                                class="base--color">{{ @$general->sitename }}</span></p>
                    </div>
                    <div class="col-lg-6 col-md-6 mt-md-0 mt-3 order-lg-3 order-3">
                        <ul class="footer-social-links d-flex flex-wrap align-items-center justify-content-md-end justify-content-center">
                            <li><a href="#0"><i class="lab la-facebook-f"></i></a></li>
                            <li><a href="#0"><i class="lab la-twitter"></i></a></li>
                            <li><a href="#0"><i class="lab la-pinterest-p"></i></a></li>
                            <li><a href="#0"><i class="lab la-linkedin-in"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- footer section end -->
</div>

<div class="win-loss-popup">
    <div class="win-loss-popup__bg">
        <div class="win-loss-popup__inner">
            <div class="win-loss-popup__body">
                <img src="{{ asset($activeTemplateTrue.'images/play/lose-message.png') }}" alt="lose message image" class="img-glow lose d-none">
                <img src="{{ asset($activeTemplateTrue.'images/play/win-message.png') }}" alt="win message image" class="img-glow win d-none">
            </div>
            <div class="win-loss-popup__footer">
                <h2 class="result-text">@lang('The result is') <span class="data-result"></span></h2>
            </div>
        </div>
    </div>
</div>
<!-- page-wrapper end -->

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="{{ asset('assets/global/js/jquery-3.6.0.min.js') }}"></script>
<!-- bootstrap js -->
<script src="{{ asset('assets/global/js/bootstrap.bundle.min.js') }}"></script>
<!-- lightcase plugin -->
<script src="{{ asset($activeTemplateTrue.'/js/vendor/lightcase.js') }}"></script>
<!-- custom select js -->
<script src="{{ asset($activeTemplateTrue.'/js/vendor/jquery.nice-select.min.js') }}"></script>
<!-- slick slider js -->
<script src="{{ asset($activeTemplateTrue.'/js/vendor/slick.min.js') }}"></script>
<!-- scroll animation -->
<script src="{{ asset($activeTemplateTrue.'/js/vendor/wow.min.js') }}"></script>
<!-- dashboard custom js -->
<script src="{{ asset($activeTemplateTrue.'/js/app.js') }}"></script>

<script src="{{asset($activeTemplateTrue.'js/bootstrap-fileinput.js')}}"></script>

<script src="{{ asset($activeTemplateTrue.'js/jquery.validate.js') }}"></script>

@stack('script-lib')

@include('partials.notify')

@include('partials.plugins')


@stack('script')


<script>
    (function ($) {
        "use strict";

        $(document).on("change", ".langSel", function () {
            window.location.href = "{{url('/')}}/change/" + $(this).val();

        });

        //Subscribe
        $(document).on('submit', '.subscribe-form', function (e) {

            e.preventDefault();

            var url = '{{ route("subscribe") }}';
            var data = $(this).serialize();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                method: "POST",
                data: data,
                success: function (data) {
                    if (data.success) {
                        notify('success', data.message);
                        $('.subscribe-form').trigger('reset');
                    }

                    if (data.errors) {
                        notify('error', data.errors);
                    }
                },
            });
        });

        $(document).on('click touchstart', function (e){
            $('.win-loss-popup').removeClass('active');
        });
    })(jQuery);
</script>


<script>
    (function ($) {
        "use strict";

        $("form").validate();
        $('form').on('submit', function () {
            if ($(this).valid()) {
                $(':submit', this).attr('disabled', 'disabled');
            }
        });

    })(jQuery);

</script>

</body>
</html>
