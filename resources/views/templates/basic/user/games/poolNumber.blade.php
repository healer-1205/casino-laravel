@extends($activeTemplate.'layouts.master')
@section('content')

    <section class="pt-120 pb-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card-body h-100 middle-el p-0">
                        <div class="game-details-left fly">
                            <div class="game-details-left__body">
                                <div class="alt">
                                </div>
                                <div id="slot-view">
                                    <div id="ball-1">
                                        <div class="poolNumber">@lang('1')</div>
                                    </div>
                                    <div id="ball-2">
                                        <div class="poolNumber">@lang('2')</div>
                                    </div>
                                    <div id="ball-3">
                                        <div class="poolNumber">@lang('3')</div>
                                    </div>
                                    <div id="ball-4">
                                        <div class="poolNumber">@lang('4')</div>
                                    </div>
                                    <div id="ball-5">
                                        <div class="poolNumber">@lang('5')</div>
                                    </div>
                                    <div id="ball-6">
                                        <div class="poolNumber">@lang('6')</div>
                                    </div>
                                    <div id="ball-7">
                                        <div class="poolNumber">@lang('7')</div>
                                    </div>
                                    <div id="ball-8">
                                        <div class="poolNumber">@lang('8')</div>
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
                                        class="bal">{{ getAmount(auth()->user()->balance) }}</span> {{ $general->cur_text }}</span>
                            </h3>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <input type="text" name="invest"
                                           class="form-control amount-field custom-amount-input"
                                           placeholder="@lang('Enter Amount')" required>
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
                            <div class="form-group mt-5 justify-content-center d-flex flex-wrap">
                                <div class="single-select pool pool-01">
                                    <img src="{{ asset($activeTemplateTrue.'images/play/pools/01.png') }}"
                                         class="gmimg pool-01" alt="">
                                </div>
                                <div class="single-select pool pool-02">
                                    <img src="{{ asset($activeTemplateTrue.'images/play/pools/02.png') }}"
                                         class="gmimg pool-02" alt="">
                                </div>
                                <div class="single-select pool pool-03">
                                    <img src="{{ asset($activeTemplateTrue.'images/play/pools/03.png') }}"
                                         class="gmimg pool-03" alt="">
                                </div>
                                <div class="single-select pool pool-04">
                                    <img src="{{ asset($activeTemplateTrue.'images/play/pools/04.png') }}"
                                         class="gmimg pool-04" alt="">
                                </div>
                                <div class="single-select pool pool-05">
                                    <img src="{{ asset($activeTemplateTrue.'images/play/pools/05.png') }}"
                                         class="gmimg pool-05" alt="">
                                </div>
                                <div class="single-select pool pool-06">
                                    <img src="{{ asset($activeTemplateTrue.'images/play/pools/06.png') }}"
                                         class="gmimg pool-06" alt="">
                                </div>
                                <div class="single-select pool pool-07">
                                    <img src="{{ asset($activeTemplateTrue.'images/play/pools/07.png') }}"
                                         class="gmimg pool-07" alt="">
                                </div>
                                <div class="single-select pool pool-08">
                                    <img src="{{ asset($activeTemplateTrue.'images/play/pools/08.png') }}"
                                         class="gmimg pool-08" alt="">
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
    <link href="{{ asset($activeTemplateTrue .'css/pool.css') }}" rel="stylesheet">
@endpush
@push('script-lib')

@endpush
@push('style')
    <style type="text/css">
        .coins {
            cursor: pointer;
        }

        .op {
            opacity: 0.5;
        }

        .opc {
            opacity: 0.3;
        }

        .fly {
            height: 554px;
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

        .pool-05 img {
            transform: rotate(-36deg);
        }

        .game-details-left {
            position: relative;
            overflow: hidden;
        }
    </style>
@endpush
@push('script')
    <script src="{{ asset($activeTemplateTrue .'js/pool.js') }}"></script>
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
            $('button[type=submit]').html('<i class="la la-gear fa-spin"></i> Processing...');
            $('button[type=submit]').attr('disabled', '');
            $('.cd-ft').html('');
            var data = $(this).serialize();
            var url = "{{ route('user.play.playPoolNumber') }}"
            $('#slot-view').removeClass('finish');
            game(data, url);
        });

        function endGame(data) {
            var url = '{{ route("user.play.gameEndPoolNumber") }}';
            complete(data, url);
        }
    </script>
@endpush
