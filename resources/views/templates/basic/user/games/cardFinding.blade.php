@extends($activeTemplate.'layouts.master')
@section('content')

    <section class="pt-120 pb-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card-body h-100 middle-el overflow-hidden">
                        <div class="game-details-left">
                            <div class="fly">
                                <div id="cards" class="d-none"></div>
                                <div class="flying text-center">
                                    <div class="card-holder">
                                        <div class="back"></div>
                                        <div class="flying-card clubs">
                                            <img
                                                src="{{ asset($activeTemplateTrue.'images/play/cards/01.png') }}"
                                                class="w-100">
                                        </div>
                                    </div>
                                    <div class="card-holder">
                                        <div class="back"></div>
                                        <div class="flying-card clubs">
                                            <img
                                                src="{{ asset($activeTemplateTrue.'images/play/cards/34.png') }}"
                                                class="w-100">
                                        </div>
                                    </div>
                                    <div class="card-holder">
                                        <div class="back"></div>
                                        <div class="flying-card clubs">
                                            <img
                                                src="{{ asset($activeTemplateTrue.'images/play/cards/20.png') }}"
                                                class="w-100">
                                        </div>
                                    </div>
                                    <div class="card-holder">
                                        <div class="back"></div>
                                        <div class="flying-card clubs">
                                            <img
                                                src="{{ asset($activeTemplateTrue.'images/play/cards/29.png') }}"
                                                class="w-100">
                                        </div>
                                    </div>
                                    <div class="card-holder">
                                        <div class="back"></div>
                                        <div class="flying-card clubs">
                                            <img
                                                src="{{ asset($activeTemplateTrue.'images/play/cards/09.png') }}"
                                                class="w-100">
                                        </div>
                                    </div>
                                    <div class="card-holder">
                                        <div class="back"></div>
                                        <div class="flying-card clubs">
                                            <img
                                                src="{{ asset($activeTemplateTrue.'images/play/cards/53.png') }}"
                                                class="w-100">
                                        </div>
                                    </div>
                                    <div class="card-holder">
                                        <div class="back"></div>
                                        <div class="flying-card clubs">
                                            <img
                                                src="{{ asset($activeTemplateTrue.'images/play/cards/2.png') }}"
                                                class="w-100">
                                        </div>
                                    </div>
                                    <div class="card-holder">
                                        <div class="back"></div>
                                        <div class="flying-card clubs">
                                            <img
                                                src="{{ asset($activeTemplateTrue.'images/play/cards/52.png') }}"
                                                class="w-100">
                                        </div>
                                    </div>
                                    <div class="card-holder">
                                        <div class="back"></div>
                                        <div class="flying-card clubs">
                                            <img
                                                src="{{ asset($activeTemplateTrue.'images/play/cards/36.png') }}"
                                                class="w-100">
                                        </div>
                                    </div>
                                    <div class="card-holder">
                                        <div class="back"></div>
                                        <div class="flying-card clubs">
                                            <img
                                                src="{{ asset($activeTemplateTrue.'images/play/cards/25.png') }}"
                                                class="w-100">
                                        </div>
                                    </div>
                                    <div class="card-holder">
                                        <div class="back"></div>
                                        <div class="flying-card clubs">
                                            <img
                                                src="{{ asset($activeTemplateTrue.'images/play/cards/40.png') }}"
                                                class="w-100">
                                        </div>
                                    </div>
                                    <div class="card-holder">
                                        <div class="back"></div>
                                        <div class="flying-card clubs">
                                            <img
                                                src="{{ asset($activeTemplateTrue.'images/play/cards/30.png') }}"
                                                class="w-100">
                                        </div>
                                    </div>
                                    <div class="card-holder">
                                        <div class="back"></div>
                                        <div class="flying-card clubs">
                                            <img
                                                src="{{ asset($activeTemplateTrue.'images/play/cards/19.png') }}"
                                                class="w-100">
                                        </div>
                                    </div>
                                    <div class="card-holder">
                                        <div class="back"></div>
                                        <div class="flying-card clubs">
                                            <img
                                                src="{{ asset($activeTemplateTrue.'images/play/cards/53.png') }}"
                                                class="w-100">
                                        </div>
                                    </div>
                                    <div class="card-holder">
                                        <div class="back"></div>
                                        <div class="flying-card clubs">
                                            <img
                                                src="{{ asset($activeTemplateTrue.'images/play/cards/13.png') }}"
                                                class="w-100">
                                        </div>
                                    </div>
                                    <div class="card-holder">
                                        <div class="back"></div>
                                        <div class="flying-card clubs">
                                            <img
                                                src="{{ asset($activeTemplateTrue.'images/play/cards/51.png') }}"
                                                class="w-100">
                                        </div>
                                    </div>
                                    <div class="card-holder">
                                        <div class="back"></div>
                                        <div class="flying-card clubs">
                                            <img
                                                src="{{ asset($activeTemplateTrue.'images/play/cards/16.png') }}"
                                                class="w-100">
                                        </div>
                                    </div>
                                    <div class="card-holder">
                                        <div class="back"></div>
                                        <div class="flying-card clubs">
                                            <img
                                                src="{{ asset($activeTemplateTrue.'images/play/cards/50.png') }}"
                                                class="w-100">
                                        </div>
                                    </div>
                                    <div class="card-holder">
                                        <div class="back"></div>
                                        <div class="flying-card clubs">
                                            <img
                                                src="{{ asset($activeTemplateTrue.'images/play/cards/08.png') }}"
                                                class="w-100">
                                        </div>
                                    </div>
                                    <div class="card-holder">
                                        <div class="back"></div>
                                        <div class="flying-card clubs">
                                            <img
                                                src="{{ asset($activeTemplateTrue.'images/play/cards/47.png') }}"
                                                class="w-100">
                                        </div>
                                    </div>
                                    <div class="card-holder">
                                        <div class="back"></div>
                                        <div class="flying-card clubs">
                                            <img
                                                src="{{ asset($activeTemplateTrue.'images/play/cards/24.png') }}"
                                                class="w-100">
                                        </div>
                                    </div>
                                </div>
                                <div class="d-none res res-thumb-img m-0 t--60px">
                                    <div class="res--card--img">
                                        <div class="back"></div>
                                        <div class="flying-card clubs resImg">
                                            <img
                                                src="{{ asset($activeTemplateTrue.'images/play/cards/24.png') }}"
                                                class="w-100">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mt-lg-0 mt-5">
                    <div class="game-details-right">
                        <form method="post" id="game">
                            @csrf

                            <h3 class="mb-4 text-center f-size--28">@lang('Current Balance'): <span
                                    class="base--color"><span
                                        class="bal">{{ getAmount(auth()->user()->balance) }}</span> {{ $general->cur_text }}</span>
                            </h3>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <input type="text" name="invest"
                                           class="form-control amount-field custom-amount-input"
                                           placeholder="@lang('Enter Amount')" autocomplete="off" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">{{ $general->cur_text }}</span>
                                    </div>
                                </div>
                                <small class="form-text text-muted"><i
                                        class="fas fa-info-circle mr-2"></i> @lang('Minimum')
                                    : {{ getAmount($game->min_limit) }} {{$general->cur_text}} | @lang('Maximum')
                                    : {{ getAmount($game->max_limit) }} {{$general->cur_text}} | <span
                                        class="text-warning">@lang('Win Amount') @if($game->invest_back == 1){{ getAmount($game->win+100) }} @else {{ getAmount($game->win) }} @endif %</span></small>
                            </div>
                            <div class="form-group mt-5 justify-content-center d-flex">
                                <div class="single-select red">
                                    <img src="{{ asset($activeTemplateTrue.'images/play/cards/27.png') }}" class="red"
                                         alt="">
                                </div>
                                <div class="single-select black">
                                    <img src="{{ asset($activeTemplateTrue.'images/play/cards/40.png') }}" class="black"
                                         alt="">
                                </div>
                            </div>

                            <input type="hidden" name="choose">
                            <input type="hidden" name="type" value="ht">

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
    <link href="{{ asset($activeTemplateTrue .'css/deck.css') }}" rel="stylesheet">
    <link href="{{ asset($activeTemplateTrue .'css/card.css') }}" rel="stylesheet">
@endpush
@push('style')
    <style type="text/css">
        .game-details-left {
            padding: 10px;
        }
    </style>
@endpush
@push('script-lib')
    <script type="text/javascript" src="{{ asset($activeTemplateTrue .'js/deck.js') }}"></script>
    <script type="text/javascript" src="{{ asset($activeTemplateTrue .'js/deckinit.js') }}"></script>
    <script type="text/javascript" src="{{ asset($activeTemplateTrue .'js/cardgame.js') }}"></script>
@endpush
@push('script')
    <script type="text/javascript">
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
            var url = '{{ route("user.play.playCardFinding") }}';
            game(data, url);
        });


        function startGame(data) {
            animationCard(data);
            $('button[type=submit]').html('<i class="la la-gear fa-spin"></i> Playing...');
            timerA = setInterval(function () {
                succOrError();
                endGame(data);
            }, 10110);
            $('button[type=submit]').html('<i class="la la-gear fa-spin"></i> Playing...');
        }

        function animationCard(data) {
            $('.flying').addClass('d-none');
            $('#cards').removeClass('d-none');
            deck.sort()
            deck.sort()
            deck.sort()
            deck.sort()
            deck.sort()
            deck.sort()
            deck.fan()
            var img = `{{ asset($activeTemplateTrue.'images/play/cards/') }}/${card(data.result)}.png`;
            setTimeout(function () {
                $('.resImg').find('img').attr('src', img)
                $('#cards').addClass('op');
                $('.res').removeClass('d-none');
            }, 10110);
        }


        function success(data) {

            $('.win-loss-popup').addClass('active');
            $('.win-loss-popup__body').find('img').addClass('d-none');
            if (data.type == 'success') {
                $('.win-loss-popup__body').find('.win').removeClass('d-none');
            }else{
                $('.win-loss-popup__body').find('.lose').removeClass('d-none');
            }
            $('.win-loss-popup__footer').find('.data-result').text(data.result);

            
            var bal = parseFloat(data.bal);
            $('.bal').html(bal.toFixed(2));
            $('button[type=submit]').html('Play');
            $('button[type=submit]').removeAttr('disabled');
            $('.single-select').removeClass('active');
            $('.single-select').removeClass('op');
            $('.single-select').find('img').removeClass('op');
            $('img').removeClass('op');
        }

        function endGame(data) {
            var url = '{{ route("user.play.gameEndCardFinding") }}';
            complete(data, url);
        }
    </script>
@endpush
