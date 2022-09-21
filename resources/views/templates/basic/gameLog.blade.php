@extends(activeTemplate().'user.layouts.app')
@section('panel')
    <div class="col-lg-12">
        <div class="card">
            <div class="table-responsive table-responsive-xl">
                <table class="table align-items-center table-dark">
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
                            <td>{{ __($log->game->name) }}</td>
                            <td>
                                @if(gettype(json_decode($log->user_select)) == 'array')
                                 @foreach(json_decode($log->user_select) as $choose)
                                    {{ __($choose) }}@if($loop->last) @else , @endif
                                 @endforeach
                                @else
                                {{ __($log->user_select) }}
                                @endif
                            </td>
                            <td>
                                @if(gettype(json_decode($log->result)) == 'array')
                                 @foreach(json_decode($log->result) as $result)
                                    {{ __($result) }}@if($loop->last) @else , @endif
                                @endforeach
                                @else
                                    {{ __($log->result) }}
                                @endif
                            </td>
                            <td>{{ __($log->invest) }} {{ $general->cur_sym }}</td>
                            <td>
                                @if($log->win_status != 0)
                                 <spin class="badge badge-success">@lang('Win')</spin>
                                @else
                                 <spin class="badge badge-danger">@lang('Lost')</spin>
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
                <div class="card-footer py-4">
                    <nav aria-label="...">
                        {{ $logs->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection