@extends(activeTemplate().'user.layouts.app')
@section('panel')
    <div class="col-lg-12">
        <div class="card">
            <div class="table-responsive table-responsive-xl">
                <table class="table align-items-center table-dark">
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
                                        <strong @if($data->trx_type == '+') class="text-success" @else class="text-danger" @endif> {{($data->trx_type == '+') ? '+':'-'}} {{formatter_money($data->amount)}} {{$general->cur_text}}</strong>
                                    </td>
                                    <td data-label="@lang('Remaining Balance')">
                                        <strong class="text-info">{{formatter_money($data->post_balance)}} {{$general->cur_text}}</strong>
                                    </td>
                                    <td data-label="@lang('Details')">{{$data->details}}</td>
                                    <td data-label="@lang('Date')">{{date('d M, Y', strtotime($data->created_at))}}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4"> @lang('No results found')!</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                    <div class="card-footer py-4">
                    <nav aria-label="...">
                        {{ $logs->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
