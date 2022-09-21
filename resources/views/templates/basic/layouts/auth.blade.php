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
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'/css/main.css') }}?fffffggf">

    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/bootstrap-fileinput.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/custom.css')}}">

    <link rel="stylesheet"
          href="{{asset($activeTemplateTrue.'css/color.php?color='.$general->base_color.'&secondColor='.$general->secondary_color)}}">

    @stack('style-lib')

    @stack('style')
</head>
<body>

@stack('fbComment')

<div class="preloader">
    <div class="preloader__inner">
        <div class="preloader__thumb">
            <img src="{{ asset('assets/images/logoIcon/logo.png') }}" alt="imge" class="mt-3 loaderLogo">
            <img src="{{ asset($activeTemplateTrue.'/images/preloader-dice.png') }}" alt="image" class="loadercircle">
        </div>
    </div>
</div>

<div class="page-wrapper" id="main-scrollbar" data-scrollbar>


@yield('content')


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

@stack('script-lib')

@stack('script')

@include('partials.plugins')

@include('partials.notify')

<script>
    (function ($) {
        "use strict";

        $(document).on("change", ".langSel", function () {
            window.location.href = "{{url('/')}}/change/" + $(this).val();

        });

        //Cookie
        $(document).on('click', '.acceptPolicy', function () {
            $.ajax({
                url: "{{ route('cookie.accept') }}",
                method:'GET',
                success:function(data){
                    if (data.success){
                        $('.cookie__wrapper').addClass('d-none');
                        notify('success', data.success)
                    }
                },
            });
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
    })(jQuery);

</script>

</body>
</html>
