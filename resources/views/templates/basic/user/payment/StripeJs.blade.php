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
                                    <img src="{{$deposit->gatewayCurrency()->methodImage()}}" class="card-img-top w-100"
                                         alt="..">
                                </div>
                                <div class="col-md-8 text-center">
                                    <form action="{{$data->url}}" method="{{$data->method}}">
                                        <ul class="list-group text-center">
                                            <li class="list-group-item bg-transparent">
                                                @lang('Please Pay: '){{getAmount($deposit->final_amo)}} {{$deposit->method_currency}}
                                            </li>
                                            <li class="list-group-item bg-transparent">
                                                @lang('To get: '){{getAmount($deposit->amount)}}  {{__($general->cur_text)}}
                                            </li>
                                            <li class="list-group-item bg-transparent">
                                                <script src="{{$data->src}}"
                                                        class="stripe-button"
                                                        @foreach($data->val as $key=> $value)
                                                        data-{{$key}}="{{$value}}"
                                                    @endforeach
                                                >
                                                </script>
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

@push('style')
    <style>
        .StripeElement {
            box-sizing: border-box;
            height: 40px;
            padding: 10px 12px;
            border: 1px solid transparent;
            border-radius: 4px;
            background-color: white;
            box-shadow: 0 1px 3px 0 #e6ebf1;
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
        }

        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }

        .StripeElement--invalid {
            border-color: #fa755a;
        }

        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }

        .card button {
            padding-left: 0px !important;
        }
    </style>
@endpush

@push('script')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        (function ($) {
            "use strict";
            $('button[type="submit"]').addClass("cmn-btn w-100 btn-round custom-success text-center btn-lg");
        })(jQuery);
    </script>
@endpush
