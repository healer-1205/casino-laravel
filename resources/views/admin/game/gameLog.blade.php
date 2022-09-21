@extends('admin.layouts.app')

@section('panel')
    <div class="row">

        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">

                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th class="text-center">@lang('Game Name')</th>
                                <th class="text-center">@lang('Username')</th>
                                <th class="text-center">@lang('User Select')</th>
                                <th class="text-center">@lang('Result')</th>
                                <th class="text-center">@lang('Invest')</th>
                                <th class="text-center">@lang('Win or fail')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($logs as $log)
                                <tr>
                                    <td data-label="@lang('Game Name')"
                                        class="text-center">{{ __($log->game->name) }}</td>
                                    <td data-label="@lang('Username')" class="text-center">
                                        <a href="{{ route('admin.users.detail', $log->user->id) }}"> {{ $log->user->username }}</a>
                                    </td>
                                    <td data-label="@lang('User Select')" class="text-center">
                                        @if(gettype(json_decode($log->user_select)) == 'array')
                                            @foreach(json_decode($log->user_select) as $choose)
                                                {{ __($choose) }}@if($loop->last) @else , @endif
                                            @endforeach
                                        @else
                                            {{ __($log->user_select) }}
                                        @endif
                                    </td>
                                    <td data-label="@lang('Result')" class="text-center">
                                        @if(gettype(json_decode($log->result)) == 'array')
                                            @foreach(json_decode($log->result) as $result)
                                                {{ __($result) }}@if($loop->last) @else , @endif
                                            @endforeach
                                        @else
                                            {{ __($log->result) }}
                                        @endif
                                    </td>
                                    <td data-label="@lang('Invest')"
                                        class="text-center">{{ $general->cur_sym }} {{ __(getAmount($log->invest)) }} </td>
                                    <td data-label="@lang('Win or fail')" class="text-center">
                                        @if($log->win_status != 0)
                                            <spin class="badge badge--success">@lang('Win')</spin>
                                        @else
                                            <spin class="badge badge--danger">@lang('Lost')</spin>
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
                <div class="card-footer py-4">
                    {{ $logs->links('admin.partials.paginate') }}
                </div>
            </div>
        </div>
    </div>
@endsection
