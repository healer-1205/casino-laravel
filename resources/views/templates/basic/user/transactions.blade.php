@extends($activeTemplate.'layouts.master')

@section('content')
    <section class="pt-120 pb-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="table--responsive">
                                <table class="table style--two">
                                    <thead>
                                    <tr>
                                        <th scope="col">@lang('Transaction ID')</th>
                                        <th scope="col">@lang('Amount')</th>
                                        <th scope="col">@lang('Remaining Balance')</th>
                                        <th scope="col">@lang('Details')</th>
                                        <th scope="col">@lang('Date')</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @if(count($logs) >0)
                                        @foreach($logs as $k=>$data)
                                            <tr>
                                                <td data-label="#@lang('Trx')">{{$data->trx}}</td>
                                                <td data-label="@lang('Amount')">
                                                    <strong @if($data->trx_type == '+') class="text-success"
                                                            @else class="text-danger" @endif> {{($data->trx_type == '+') ? '+':'-'}} {{getAmount($data->amount)}} {{$general->cur_text}}</strong>
                                                </td>
                                                <td data-label="@lang('Remaining Balance')">
                                                    <strong
                                                        class="text-info">{{getAmount($data->post_balance)}} {{$general->cur_text}}</strong>
                                                </td>
                                                <td data-label="@lang('Details')">{{$data->details}}</td>
                                                <td data-label="@lang('Date')">{{ showDateTime($data->created_at) }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5"> @lang('No results found')!</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
