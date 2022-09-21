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
                                <th>@lang('Game Name')</th>
                                <th>@lang('Minimum Invest')</th>
                                <th>@lang('Maximum Invest')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($games as $game)
                            <tr>
                                <td data-label="@lang('Game Name')">{{ $game->name }}</td>
                                <td data-label="@lang('Minimum Invest')">{{ $general->cur_sym }} {{ getAmount($game->min_limit) }}</td>
                                <td data-label="@lang('Maximum Invest')">{{ $general->cur_sym }} {{ getAmount($game->max_limit) }}</td>
                                <td data-label="@lang('Status')">
                                    @if($game->status == 0)
                                    <span class="badge badge--danger">@lang('inactive')</span>
                                    @else
                                    <span class="badge badge--success">@lang('active')</span>
                                    @endif
                                </td>
                                <td data-label="@lang('Action')">
                                    <a href="{{ route('admin.game.'.$game->alias) }}" class="icon-btn"><i class="la la-pencil" data-toggle="tooltip" title="" data-original-title="Edit"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            </div>
        </div>
    </div>
@endsection