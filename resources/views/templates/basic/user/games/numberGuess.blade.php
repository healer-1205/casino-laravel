@extends($activeTemplate.'layouts.master')
@section('content')

    <section class="pt-120 pb-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="game-details-left number--guess">
                        <div class="game-details-left__body d-flex align-items-center">
                            <img src="{{ asset($activeTemplateTrue.'images/play/Down-arrow.png') }}"
                                 class="vert-move-down vert down d-none" height="70" width="70"/>
                            <img src="{{ asset($activeTemplateTrue.'images/play/up-arrow.png') }}"
                                 class="vert-move-up vert up d-none" height="70" width="70"/>
                            <div class="text">
                                <h2 class="text-center custom-font base--color">@lang('You Will Get') {{ $gesBon->count() }} @lang('Chances Per Invest')</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mt-lg-0 mt-5">
                    <div class="game-details-right">
                        <form id="game">
                            <h3 class="mb-4 text-center f-size--28">@lang('Current Balance') : <span class="base--color"><span
                                        class="bal">{{ getAmount(auth()->user()->balance) }}</span> {{ __($general->cur_text)}}</span>
                            </h3>
                            <div class="form-group">
                                <div class="input-group mb-3 amf">
                                    <input type="text" class="form-control amount-field"
                                           placeholder="@lang('Enter amount')" name="invest">
                                    <div class="input-group-append" onclick="myFunc()">
                                        <span class="input-group-text"
                                              id="basic-addon2">{{ __($general->cur_text)}}</span>
                                    </div>
                                </div>
                                <small class="form-text text-muted"><i
                                        class="fas fa-info-circle mr-2"></i> @lang('Minimum')
                                    : {{ __(getAmount($game->min_limit)) }} {{ __($general->cur_text) }}
                                    | @lang('Maximum')
                                    : {{ __(getAmount($game->max_limit)) }} {{ __($general->cur_text) }} | <span
                                        class="text-warning">@lang('Win Bonus For This Chance') <span class="bon">{{ __($gesBon->first()->percent) }}%</span></small>
                            </div>
                            <div class="mt-5 text-center invBtn">
                                <button type="submit"
                                        class="cmn-btn w-100 text-center my-submit-btn">@lang('Start Game')</button>
                                <a data-toggle="modal" data-target="#exampleModalCenter"
                                   class="mt-1 btn btn-link">@lang('Game Instruction') <i
                                        class="las la-info-circle"></i></a>
                            </div>
                        </form>

                        <form id="start" class="startGame">
                            @csrf
                            <input type="hidden" name="game_id">
                            <div class="numberGs numHide">
                                <div class="form-group">
                                    <input type="number" class="form-control guess" name="number"
                                           placeholder="@lang('Guess The Number')" autocomplete="off">
                                </div>
                                <button type="submit" class="btn cmn-btn gmg w-100">@lang('Guess The Number')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <audio id="pop">
        <source src="{{ asset($activeTemplateTrue.'audio/incorrect.mp3') }}" type="audio/mpeg">
    </audio>
    <audio id="pop2">
        <source src="{{ asset($activeTemplateTrue.'audio/incorrect.mp3') }}" type="audio/mpeg">
    </audio>
    <audio id="lost">
        <source src="{{ asset($activeTemplateTrue.'audio/lost.mp3') }}" type="audio/mpeg">
    </audio>
    <audio id="success">
        <source src="{{ asset($activeTemplateTrue.'audio/success.mp3') }}" type="audio/mpeg">
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
    <link href="{{ asset($activeTemplateTrue .'css/guess.css') }}" rel="stylesheet">
@endpush
@push('script-lib')
    <script src="{{ asset($activeTemplateTrue .'js/guess.js') }}"></script>
@endpush
@push('style')
    <style type="text/css">
        .game-details-left__body {
            height: 100%;
            width: 100%;
            background: #d3e0f71a;
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            border-radius: 10px;
            padding: 20px;
        }

        .game-details-left {
            padding: 30px;
            background: url('{{ asset($activeTemplateTrue.'images/play/number.png') }}');
            background-size: 100% 100%;
        }

        .game-details-left h2 {
            font-size: 40px;
            text-shadow: none;
        }
        @media screen and (max-width:991px) {
            .number--guess {
                min-height: 520px;
            }
        }
        @media screen and (max-width:767px) {
            .text h2 {
                font-size: 36px;
                padding: 0 30px
            }
        }
        @media screen and (max-width:450px) {
            .number--guess {
                min-height: 390px
            }
        }
        @media screen and (max-width:575px) {
            .text h2 {
                font-size: 30px;
                padding: 0;
            }
        }
    </style>
@endpush

@push('script')
    <script type="text/javascript">
        "use strict";

        function color() {
            var myArray = [
                "#0060651a",
                "#654f001a",
                "#6500001a",
                "#5f00651a",
                "#000c651a",
                "#0057651a",
            ];

            var randomItem = myArray[Math.floor(Math.random() * myArray.length)];
            return randomItem;
        }

        function myFunc() {
            $('.game-details-left__body').css('background', color());
        }

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
            var data = $(this).serialize();
            var url = '{{ route("user.play.playnumberGuess") }}';
            game(data, url);
        });

        $('#start').on('submit', function (e) {
            e.preventDefault();
            var data = $(this).serialize();
            var url = '{{ route("user.play.gameEndnumberGuess") }}';
            var bon = {{ $gesBon->first()->percent }}
            start(url, data, bon);
        });
    </script>

@endpush
