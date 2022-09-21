@extends($activeTemplate.'layouts.master')
@section('content')

    <section class="pt-120 pb-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card-body h-100 middle-el">
                        <div class="cd-ft"></div>
                        <div class="game-details-left">
                            <div class="game-details-left__body">
                                <div class="spin-card">
                                    <div class="wheel-wrapper">
                                        <div class="arrow text-center">
                                            <img src="{{ asset($activeTemplateTrue .'images/play/down.png') }}"
                                                 height="50"
                                                 width="50">
                                        </div>
                                        <div class="wheel text-center the_wheel">
                                            <canvas id="canvas" width="434" height="434" class="w-100">
                                                <p class="text-white"
                                                   align="center">@lang("Sorry, your browser doesn't support canvas. Please try another.")</p>
                                            </canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mt-lg-0 mt-5">
                    <div class="game-details-right">
                        <form method="post" id="game">
                            @csrf
                            <h3 class="mb-4 text-center f-size--28">@lang('Current Balance') : <span class="base--color"><span
                                        class="bal">{{ __(getAmount(auth()->user()->balance)) }}</span> {{ __($general->cur_text) }}</span>
                            </h3>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <input type="text" name="invest" class="form-control amount-field"
                                           placeholder="Enter amount">
                                    <div class="input-group-append">
                                        <span class="input-group-text"
                                              id="basic-addon2">{{ __($general->cur_text) }}</span>
                                    </div>
                                </div>
                                <small class="form-text text-muted"><i
                                        class="fas fa-info-circle mr-2"></i> @lang('Minimum :') {{ $game->min_limit +0 }} {{$general->cur_text}}
                                    | @lang('Maximum :') {{ getAmount($game->max_limit+0) }} {{__($general->cur_text)}}
                                    | <span
                                        class="text-warning"> @lang('Win Amount') @if($game->invest_back == 1){{ getAmount($game->win+100) }} @else {{ getAmount($game->win) }} @endif @lang('%') </span></small>
                            </div>
                            <div class="form-group mt-5 justify-content-center d-flex">
                                <div class="single-select black gmimg">
                                    <img src="{{ asset($activeTemplateTrue.'images/play/moneyblack.png') }}"
                                         alt="game-image">
                                </div>
                                <div class="single-select red gmimg">
                                    <img src="{{ asset($activeTemplateTrue.'images/play/money.png') }}"
                                         alt="game-image">
                                </div>
                            </div>
                            <input type="hidden" name="choose">
                            <div class="mt-5 text-center">
                                <button type="submit" class="cmn-btn w-100 text-center">@lang('Play Now')</button>
                                <a data-toggle="modal" data-target="#exampleModalCenter"
                                   class="mt-1 btn btn-link">@lang('Game Instruction') <i
                                        class="las la-info-circle"></i></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <audio id="pop">
        <source src="{{ asset($activeTemplateTrue.'audio/spinWheel.mp3') }}" type="audio/mpeg">
    </audio>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content section--bg">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">@lang('Game Rule')</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @php echo __($game->instruction) @endphp
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <style type="text/css">
        .the_wheel {
            max-width: 450px;
        }

        @media (max-width: 425px) {
            .game-details-left {
                display: -ms-flexbox;
                display: flex;
                -ms-flex-wrap: wrap;
                flex-wrap: wrap;
                justify-content: center;
                align-items: center;
                padding: 20px;
            }
        }
    </style>
@endpush
@push('script-lib')
    <script src="{{ asset($activeTemplateTrue .'js/TweenMax.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue .'js/Winwheel.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue .'js/spinFunctions.js') }}"></script>
@endpush
@push('script')
    <script>
        "use strict";

        $('input[name=invest]').keypress(function (e) {
            var character = String.fromCharCode(e.keyCode)
            var newValue = this.value + character;
            if (isNaN(newValue) || hasDecimalPlace(newValue, 3)) {
                e.preventDefault();
                return false;
            }
        });

        function hasDecimalPlace(value, x) {
            var pointIndex = value.indexOf('.');
            return pointIndex >= 0 && pointIndex < value.length - x;
        }

        $('#game').on('submit', function (e) {
            e.preventDefault();
            beforeProcess();
            var data = $(this).serialize();
            var url = '{{ route("user.play.playspinWheel") }}';
            game(url, data);
        });

        function endGame(data) {
            var url = '{{ route("user.play.gameEndSpinWheel") }}'
            complete(data, url)
        }
    </script>
@endpush
