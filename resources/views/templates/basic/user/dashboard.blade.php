@extends($activeTemplate.'layouts.master')
@section('content')
<section class="pt-120 pb-120">
    <div class="container">
        <div class="row mb-3">
            <div class="col-lg-4 col-md-6 mb-30">
                <div class="d-widget d-flex flex-wrap align-items-center">
                    <div class="d-widget-icon">
                        <i class="las la-wallet"></i>
                    </div>
                    <div class="d-widget-content">
                        <p>@lang('Total Balance')</p>
                        <h2 class="title">{{ getAmount(auth()->user()->balance) }} {{ $general->cur_text }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-30">
                <div class="d-widget d-flex flex-wrap align-items-center d-widget-deposit">
                    <div class="d-widget-icon">
                        <i class="las la-hand-holding-usd"></i>
                    </div>
                    <div class="d-widget-content">
                        <p>@lang('Total Deposit')</p>
                        <h2 class="title">{{ getAmount(auth()->user()->deposits->where('status',1)->sum('amount')) }} {{ $general->cur_text }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-30">
                <div class="d-widget d-flex flex-wrap align-items-center d-widget-withdraw">
                    <div class="d-widget-icon">
                    <i class="las la-arrow-up"></i>
                    </div>
                    <div class="d-widget-content">
                        <p>@lang('Total Withdraw')</p>
                        <h2 class="title">{{ getAmount(auth()->user()->withdrawals->where('status',1)->sum('amount')) }} {{ $general->cur_text }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            @forelse($games as $game)
            <div class="col-xl-3 col-lg-4 col-sm-6 mb-30 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.3s">
                <div class="game-card style--two">
                    <div class="game-card__thumb">
                        <img src="{{ getImage(imagePath()['game']['path'].'/'.$game->image,imagePath()['game']['size']) }}" alt="image">
                    </div>
                    <div class="game-card__content">
                        <h4 class="game-name" data-css='margin-top:100px,padding-bottom:100px'>{{ __($game->name) }}</h4>
                        <a href="{{ route('user.play.'.$game->alias) }}" class="cmn-btn d-block text-center btn-sm mt-3 btn--capsule">@lang('Play Now')</a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-center">@lang('No Games Found')</h5>
                    </div>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
@push('script')
<script type="text/javascript">
    "use strict";

    (function dynamicStyle() {
      var customAttr = $('*[data-css]');
      var allStyle = customAttr.attr('data-css');
      var styles = allStyle.split(',');
      for (var i = 0; i < styles.length; i++) {
          var singleStyle = styles[i].split(':');
          customAttr.css(singleStyle[0], function () {
            var styleCss = ($(this).data('css_val'));
            return styleCss;
          });
      }
    })();


</script>
@endpush
