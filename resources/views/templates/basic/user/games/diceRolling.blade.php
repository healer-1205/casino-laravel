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
                                <div class="roll">
                                    <div id="wrapper">
                                        <div id="platform">
                                            <div id="dice" class="diceRolling">
                                                <div class="side front">
                                                    <div class="dot center"></div>
                                                </div>
                                                <div class="side front inner"></div>
                                                <div class="side top">
                                                    <div class="dot dtop dleft"></div>
                                                    <div class="dot dbottom dright"></div>
                                                </div>
                                                <div class="side top inner"></div>
                                                <div class="side right">
                                                    <div class="dot dtop dleft"></div>
                                                    <div class="dot center"></div>
                                                    <div class="dot dbottom dright"></div>
                                                </div>
                                                <div class="side right inner"></div>
                                                <div class="side left">
                                                    <div class="dot dtop dleft"></div>
                                                    <div class="dot dtop dright"></div>
                                                    <div class="dot dbottom dleft"></div>
                                                    <div class="dot dbottom dright"></div>
                                                </div>
                                                <div class="side left inner"></div>
                                                <div class="side bottom">
                                                    <div class="dot center"></div>
                                                    <div class="dot dtop dleft"></div>
                                                    <div class="dot dtop dright"></div>
                                                    <div class="dot dbottom dleft"></div>
                                                    <div class="dot dbottom dright"></div>
                                                </div>
                                                <div class="side bottom inner"></div>
                                                <div class="side back">
                                                    <div class="dot dtop dleft"></div>
                                                    <div class="dot dtop dright"></div>
                                                    <div class="dot dbottom dleft"></div>
                                                    <div class="dot dbottom dright"></div>
                                                    <div class="dot center dleft"></div>
                                                    <div class="dot center dright"></div>
                                                </div>
                                                <div class="side back inner"></div>
                                                <div class="side cover x"></div>
                                                <div class="side cover y"></div>
                                                <div class="side cover z"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mt-lg-0 mt-5">
                    <div class="game-details-right">
                        <form id="game">
                            <h3 class="mb-4 text-center f-size--28">@lang('Current Balance') : <span
                                    class="base--color"><span class="bal">{{ getAmount(auth()->user()->balance) }}</span> {{ $general->cur_text }}</span>
                            </h3>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <input type="text" name="invest"
                                           class="form-control custom-amount-input amount-field"
                                           placeholder="@lang('Amount')" autocomplete="off" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">{{ $general->cur_text}}</span>
                                    </div>
                                </div>
                                <small class="form-text text-muted"><i
                                        class="fas fa-info-circle mr-2"></i> @lang('Minimum')
                                    : {{ getAmount($game->min_limit) }} {{$general->cur_text}} | @lang('Maximum')
                                    : {{ getAmount($game->max_limit) }} {{$general->cur_text}} | <span
                                        class="text-warning">@lang('Win Amount') @if($game->invest_back == 1){{ getAmount($game->win+100) }} @else {{ getAmount($game->win) }} @endif %</span></small>
                            </div>
                            <div class="form-group mt-5 justify-content-center d-flex flex-wrap">
                                <div class="single-select dice dice1">
                                    <img src="{{ asset($activeTemplateTrue.'images/play/dice1.png') }}"
                                         class="gmimg dice1" alt="">
                                </div>
                                <div class="single-select dice dice2">
                                    <img src="{{ asset($activeTemplateTrue.'images/play/dice2.png') }}"
                                         class="gmimg dice2" alt="">
                                </div>
                                <div class="single-select dice dice3">
                                    <img src="{{ asset($activeTemplateTrue.'images/play/dice3.png') }}"
                                         class="gmimg dice3" alt="">
                                </div>
                                <div class="single-select dice dice4">
                                    <img src="{{ asset($activeTemplateTrue.'images/play/dice4.png') }}"
                                         class="gmimg dice4" alt="">
                                </div>
                                <div class="single-select dice dice5">
                                    <img src="{{ asset($activeTemplateTrue.'images/play/dice5.png') }}"
                                         class="gmimg dice5" alt="">
                                </div>
                                <div class="single-select dice dice6">
                                    <img src="{{ asset($activeTemplateTrue.'images/play/dice6.png') }}"
                                         class="gmimg dice6" alt="">
                                </div>
                            </div>

                            <input type="hidden" name="choose">
                            <input type="hidden" name="type" value="ht">

                            <div class="mt-5 text-center">
                                <button type="submit" id="flip"
                                        class="cmn-btn w-100 text-center">@lang('Play Now')</button>
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

@push('style-lib')
    <link href="{{ asset($activeTemplateTrue .'css/dice.css') }}" rel="stylesheet">
@endpush
@push('script-lib')
    <script type="text/javascript" src="{{ asset($activeTemplateTrue .'js/dice.js') }}"></script>
@endpush
@push('style')
    <style type="text/css">
        .dices {
            cursor: pointer;
        }

        .op {
            opacity: 0.5;
        }

        .roll {
            height: 263px;
        }

        .none {
            display: none;
        }

        #game .row {
            margin-top: 18px;
        }

        .show {
            height: 100%;
            width: 100%;
            overflow-y: scroll;
            opacity: 1;
        }

        .hide {
            height: 0%;
            width: 0%;
            overflow-y: hidden;
            overflow-x: hidden;
            opacity: 0;
        }
    </style>
@endpush

@push('script')
    <script type="text/javascript">
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
            $('button[type=submit]').html('<i class="la la-gear fa-spin"></i> Processing...');
            $('button[type=submit]').attr('disabled', '');
            $('.cd-ft').html('');
            var url = "{{ route('user.play.playdiceRoll') }}";
            var data = $(this).serialize();
            game(data, url);
        });

        function endGame(data) {
            var url = '{{ route("user.play.gameEnddiceRoll") }}';
            complete(data, url)
        }
    </script>
@endpush
