@extends($activeTemplate.'layouts.master')
@section('content')

    <section class="pt-120 pb-120">
        <div class="container">
            <div class="row number-slot-wrapper">
                <div class="col-lg-6 number-slot-box">
                    <div class='machine'>
                        <div class='slots'>
                            <ul class='slot' id="slot1">
                                <li class='numbers'>0</li>
                                <li class='numbers'>1</li>
                                <li class='numbers'>2</li>
                                <li class='numbers'>3</li>
                                <li class='numbers'>4</li>
                                <li class='numbers'>5</li>
                                <li class='numbers'>6</li>
                                <li class='numbers'>7</li>
                                <li class='numbers'>8</li>
                                <li class='numbers'>9</li>
                            </ul>
                            <ul class='slot' id="slot2">
                                <li class='numbers'>0</li>
                                <li class='numbers'>1</li>
                                <li class='numbers'>2</li>
                                <li class='numbers'>3</li>
                                <li class='numbers'>4</li>
                                <li class='numbers'>5</li>
                                <li class='numbers'>6</li>
                                <li class='numbers'>7</li>
                                <li class='numbers'>8</li>
                                <li class='numbers'>9</li>
                            </ul>
                            <ul class='slot' id="slot3">
                                <li class='numbers'>0</li>
                                <li class='numbers'>1</li>
                                <li class='numbers'>2</li>
                                <li class='numbers'>3</li>
                                <li class='numbers'>4</li>
                                <li class='numbers'>5</li>
                                <li class='numbers'>6</li>
                                <li class='numbers'>7</li>
                                <li class='numbers'>8</li>
                                <li class='numbers'>9</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 number-slot-box number-slot-box-right mt-lg-0 mt-5">
                    <div class="game-details-right h-100 d-flex flex-wrap align-items-center justify-content-center">
                        <form id="game" method="post" class="w-100">
                            @csrf
                            <h3 class="mb-4 text-center f-size--28">@lang('Current Balance') : <span
                                    class="base--color"><span
                                        class="bal">{{ getAmount(auth()->user()->balance) }}</span> {{ $general->cur_text }}</span>
                            </h3>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" name="invest"
                                           class="form-control amount-field custom-amount-input"
                                           placeholder="@lang('Enter Amount')" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">{{ $general->cur_text }}</span>
                                    </div>
                                </div>
                                <small class="form-text text-muted mb-0"><i
                                        class="fas fa-info-circle mr-2"></i> @lang('Minimum')
                                    : {{ getAmount($game->min_limit) }} {{$general->cur_text}} | @lang('Maximum')
                                    : {{ getAmount($game->max_limit) }} {{$general->cur_text}}</small>
                                <small class="form-text text-muted mb-3">Win Amount : <span style="color:#ffc107;">Single (150%)</span> | <span style="color:#ffc107;">Double (350%)</span> | <span style="color:#ffc107;">Triple (800%)</span></small>
                                <div class="input-group mb-3">
                                    <input type="number" min="0" max="9"
                                           class="form-control amount-field custom-amount-input" name="number"
                                           placeholder="@lang('Enter Number')" required>
                                </div>
                            </div>
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
    <link href="{{ asset($activeTemplateTrue .'css/slot.css') }}" rel="stylesheet">
@endpush
@push('style')
    <style type="text/css">
        .gmimg {
            max-width: 30%;
            cursor: pointer;
            margin-top: 14px;
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

        @media (max-width: 991px) {
            .game-details-left {
                height: 465px;
            }
        }

        @media (max-width: 800px) {
            .game-details-left {
                height: 400px;
            }
        }

        @media (max-width: 575px) {
            .game-details-left {
                height: 288px;
            }
        }

        @media (max-width: 425px) {
            .game-details-left {
                height: 220px;
            }
        }

        @media (max-width: 375px) {
            .game-details-left {
                height: 178px;
            }
        }
    </style>
@endpush
@push('script-lib')
    <script src="{{ asset($activeTemplateTrue .'js/slot.js') }}"></script>
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
            $('.alert').remove();
            var data = $(this).serialize();
            var url = '{{ route("user.play.PlayNumberSlot") }}';
            game(data, url);
        });

        function endGame(data) {
            var url = '{{ route("user.play.gameEndnumberSlot") }}';
            complete(data, url);
        }

    </script>
@endpush
