@extends($activeTemplate.'layouts.master')
@section('content')

    <section class="pt-120 pb-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="payment-prev-card d-flex flex-wrap align-items-center">
                        <div class="thumb">
                            <img src="{{ $data->gatewayCurrency()->methodImage() }}"/>
                        </div>
                        <div class="content">
                            <ul class="payment-prev-card-list d-flex flex-wrap align-items-center">

                                <li>
                                    @lang('Amount'):
                                    <strong>{{getAmount($data->amount)}} </strong> {{$general->cur_text}}
                                </li>
                                <li>
                                    @lang('Charge'):
                                    <strong>{{getAmount($data->charge)}}</strong> {{$general->cur_text}}
                                </li>
                                <li>
                                    @lang('Payable'): <strong> {{$data->amount + $data->charge}}</strong> {{$general->cur_text}}
                                </li>
                                <li>
                                    @lang('Conversion Rate'): <strong>1 {{$general->cur_text}} = {{$data->rate +0}}  {{$data->baseCurrency()}}</strong>
                                </li>
                                <li>
                                    @lang('In') {{$data->baseCurrency()}}:
                                    <strong>{{getAmount($data->final_amo)}}</strong>
                                </li>
                                @if($data->gateway->crypto==1)
                                    <li>
                                        @lang('Conversion with')
                                        <b> {{ $data->method_currency }}</b> @lang('and final value will Show on next step')
                                    </li>
                                @endif
                            </ul>
                            @if($data->method_code<1000)
                                <a href="{{route('user.deposit.confirm')}}" class="btn btn-block py-3 font-weight-bold mt-4 cmn-btn">@lang('Confirm')</a>
                            @else
                                <a href="{{route('user.deposit.manual.confirm')}}" class="btn btn-block py-3 font-weight-bold mt-4 cmn-btn">@lang('Confirm')</a>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
@push('style')
    <style type="text/css">
        .p-prev-list img{
            max-width:100px;
            max-height:100px;
            margin:0 auto;
        }
    </style>
@endpush
