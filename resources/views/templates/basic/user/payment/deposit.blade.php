@extends($activeTemplate.'layouts.master')

@section('content')
    <section class="pt-120 pb-120">
        <div class="container">
            <div class="row justify-content-center">

                @foreach($gatewayCurrency as $data)
                    <div class="col-lg-3 col-md-5 col-sm-12 mb-4">
                        <div class="p-method-card">
                            <div class="thumb">
                                <img src="{{$data->methodImage()}}" class="card-img-top w-100" alt="{{$data->name}}">
                            </div>
                            <div class="content">
                                <ul class="p-method-card-list text-center mt-4">
                                    <li>
                                        {{__($data->name)}}</li>
                                    <li>@lang('Limit')
                                        : {{getAmount($data->min_amount)}}
                                        - {{getAmount($data->max_amount)}} {{$general->cur_text}}</li>
                                    <li> @lang('Charge')
                                        - {{getAmount($data->fixed_charge)}} {{$general->cur_text}}
                                        + {{getAmount($data->percent_charge)}}%
                                    </li>
                                    <li>
                                        <button type="button"  data-id="{{$data->id}}" data-resource="{{$data}}"
                                                data-base_symbol="{{$data->baseSymbol()}}"
                                                class=" btn btn-md deposit p-method-card-btn  w-100 mt-3" data-toggle="modal" data-target="#exampleModal">
                                            @lang('Deposit')</button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>



    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content section--bg">
                <div class="modal-header">
                    <h6 class="modal-title method-name" id="exampleModalLabel"></h6>
                    <a href="javascript:void(0)" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                <form action="{{route('user.deposit.insert')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="currency" class="edit-currency" value="">
                            <input type="hidden" name="method_code" class="edit-method-code" value="">
                        </div>
                        <div class="form-group">
                            <label>@lang('Enter Amount'):</label>
                            <div class="input-group">
                                <input id="amount" type="text" class="form-control form-control-lg" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" name="amount" placeholder="0.00" required  value="{{old('amount')}}">
                                <div class="input-group-append">
                                    <span class="input-group-text currency-addon addon-bg">{{$general->cur_text}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn base--bg">@lang('Confirm')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection



@push('script')
    <script>
        $(document).ready(function(){
            "use strict";
            $('.deposit').on('click', function () {
                var id = $(this).data('id');
                var result = $(this).data('resource');
                var minAmount = $(this).data('min_amount');
                var maxAmount = $(this).data('max_amount');
                var baseSymbol = "{{$general->cur_text}}";
                var fixCharge = $(this).data('fix_charge');
                var percentCharge = $(this).data('percent_charge');

                var depositLimit = `@lang('Deposit Limit:') ${minAmount} - ${maxAmount}  ${baseSymbol}`;
                $('.depositLimit').text(depositLimit);
                var depositCharge = `@lang('Charge:') ${fixCharge} ${baseSymbol}  ${(0 < percentCharge) ? ' + ' +percentCharge + ' % ' : ''}`;
                $('.depositCharge').text(depositCharge);
                $('.method-name').text(`@lang('Payment By') ${result.name}`);
                $('.currency-addon').text(baseSymbol);


                $('.edit-currency').val(result.currency);
                $('.edit-method-code').val(result.method_code);
            });
        });
    </script>
@endpush


@push('style')
<style type="text/css">

</style>
@endpush
