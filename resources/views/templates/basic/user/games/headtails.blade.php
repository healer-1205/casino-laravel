@extends($activeTemplate.'layouts.master')
@section('content')

    <section class="pt-120 pb-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card-body h-100 middle-el">
                        <div class="alt"></div>
                        <div class="game-details-left">
                            <div class="game-details-left__body">
                                <div class="flp">
                                    <div id="coin-flip-cont">
                                        <div id="coin" class="flipcoin">
                                            <div class="flpng coins-wrapper">
                                                <div class="front"><img src="{{ asset($activeTemplateTrue.'images/play/head.png') }}" alt=""></div>
                                                <div class="back"><img src="{{ asset($activeTemplateTrue.'images/play/tail.png') }}" alt=""></div>
                                            </div>
                                            <div class="headCoin d-none">
                                                <div class="front"><img src="{{ asset($activeTemplateTrue.'images/play/head.png') }}" alt=""></div>
                                                <div class="back"><img src="{{ asset($activeTemplateTrue.'images/play/tail.png') }}" alt=""></div>
                                            </div>
                                            <div class="tailCoin d-none">
                                                <div class="front"><img src="{{ asset($activeTemplateTrue.'images/play/tail.png') }}" alt=""></div>
                                                <div class="back"><img src="{{ asset($activeTemplateTrue.'images/play/head.png') }}" alt=""></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="cd-ft"></div>
                    </div>
                </div>
                <div class="col-lg-6 mt-lg-0 mt-5">
                    <div class="game-details-right">
                        <form method="post" id="game">
                            @csrf
                            <h3 class="mb-4 text-center f-size--28">@lang('Current Balance :') <span
                                    class="base--color"><span
                                        class="bal">{{ __(getAmount(auth()->user()->balance)) }}</span> {{ __($general->cur_text) }}</span>
                            </h3>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <input type="text" name="invest" class="form-control amount-field"
                                           placeholder="@lang('Enter amount')">
                                    <div class="input-group-append">
                                        <span class="input-group-text"
                                              id="basic-addon2">{{ __($general->cur_text) }}</span>
                                    </div>
                                </div>
                                <small class="form-text text-muted"><i
                                        class="fas fa-info-circle mr-2"></i>@lang('Minimum')
                                    : {{ getAmount($game->min_limit) }} {{ __($general->cur_text) }} | @lang('Maximum')
                                    : {{ __($game->max_limit) }} {{ __($general->cur_text) }} | <span
                                        class="text-warning">@lang('Win Amount') @if($game->invest_back == 1){{ getAmount($game->win+100) }} @else {{ getAmount($game->win) }} @endif %</span></small>
                            </div>
                            <div class="form-group mt-5 justify-content-center d-flex">
                                <div class="single-select head gmimg">
                                    <img src="{{ asset($activeTemplateTrue.'/images/play/head.png') }}"
                                         alt="game-image">
                                </div>
                                <div class="single-select tail gmimg">
                                    <img src="{{ asset($activeTemplateTrue.'/images/play/tail.png') }}"
                                         alt="game-image">
                                </div>
                                <input type="hidden" name="choose">
                            </div>
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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @php echo __($game->instruction) @endphp
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('style-lib')
    <link href="{{ asset($activeTemplateTrue .'css/coinflipping.min.css') }}" rel="stylesheet">
@endpush
@push('script-lib')
    <script type="text/javascript" src="{{ asset($activeTemplateTrue .'js/coin.js') }}"></script>
@endpush
@push('script')
    <script type="text/javascript">
        "use strict";

        $('#game').on('submit', function (e) {
            e.preventDefault();

            $('.flipcoin').removeClass('animateClick');
            $('.flpng').removeClass('d-none');
            $('#coin .headCoin').addClass('d-none');
            $('#coin .tailCoin').addClass('d-none');

            $('.cmn-btn').html('<i class="la la-gear fa-spin"></i> Processing...');
            $('.cmn-btn').attr('disabled', true);
            var data = $(this).serialize();
            var url = '{{ route("user.play.playheadTail") }}';
            game(data, url);
        });

        function endGame(data) {
            var url = '{{ route("user.play.gameEndHeadTail") }}';
            complete(data, url);
        }

        //close when click off of container


    </script>
@endpush
