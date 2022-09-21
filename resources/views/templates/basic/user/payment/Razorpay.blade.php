@extends($activeTemplate.'layouts.master')
@section('content')

    <section class="pt-120 pb-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <img src="{{$deposit->gatewayCurrency()->methodImage()}}" class="card-img-top w-100" alt="..">
                                </div>
                                <div class="col-md-8 text-center">
                                    <form action="{{$data->url}}" method="{{$data->method}}">
                                        <ul class="list-group text-center">
                                            <li class="list-group-item bg-transparent">
                                                @lang('Please Pay: '){{getAmount($deposit->final_amo)}} {{$deposit->method_currency}}
                                            </li>
                                            <li class="list-group-item bg-transparent">
                                                @lang('You will get: '){{getAmount($deposit->amount)}}  {{__($general->cur_text)}}
                                            </li>
                                            <li class="list-group-item bg-transparent">
                                                <script src="{{$data->checkout_js}}"
                                                        @foreach($data->val as $key=>$value)
                                                        data-{{$key}}="{{$value}}"
                                                    @endforeach >
                                                </script>
                                                <input type="hidden" custom="{{$data->custom}}" name="hidden">
                                            </li>
                                        </ul>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@push('script')
    <script>
        (function ($) {
            "use strict";
            $('input[type="submit"]').addClass("cmn-btn");
            $('input[type="submit"]').css("border","none");
        })(jQuery);
    </script>
@endpush
