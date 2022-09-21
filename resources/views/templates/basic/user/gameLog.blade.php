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
                                        <th scope="col">@lang('Game Name')</th>
                                        <th scope="col">@lang('You Select')</th>
                                        <th scope="col">@lang('Result')</th>
                                        <th scope="col">@lang('Invest')</th>
                                        <th scope="col">@lang('Win or Lost')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($logs as $log)
                                        <tr>
                                            <td data-label="@lang('Game Name')">{{ __($log->game->name) }}</td>
                                            <td data-label="@lang('You Select')">
                                                @if(gettype(json_decode($log->user_select)) == 'array')
                                                    @foreach(json_decode($log->user_select) as $choose)
                                                        {{ __($choose) }}@if($loop->last) @else , @endif
                                                    @endforeach
                                                @else
                                                    {{ __($log->user_select) }}
                                                @endif
                                            </td>
                                            <td data-label="@lang('Result')">
                                                @if(gettype(json_decode($log->result)) == 'array')
                                                    @foreach(json_decode($log->result) as $result)
                                                        {{ __($result) }}@if($loop->last) @else , @endif
                                                    @endforeach
                                                @else
                                                    {{ __($log->result) }}
                                                @endif
                                            </td>
                                            <td data-label="@lang('Invest')">{{ $general->cur_sym }} {{ __(getAmount($log->invest)) }} </td>
                                            <td data-label="@lang('Win or Lost')">
                                                @if($log->win_status != 0)
                                                    <spin class="badge badge--success"><i class="las la-smile"></i> @lang('Win')</spin>
                                                @else
                                                    <spin class="badge badge--danger"><i class="las la-frown"></i> @lang('Lost')</spin>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="100%" class="text-center">@lang('No Data Found')</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        {{$logs->links()}}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
