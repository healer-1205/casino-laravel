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
                                <th>@lang('Commission From')</th>
                                <th>@lang('Commission To')</th>
                                <th>@lang('Commission Level')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Title')</th>
                                <th>@lang('Transaction')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($commissionLog as $log)
                            <tr>
                                <td data-label="@lang('Commission From')"><a href="{{ route('admin.users.detail', $log->userFrom->id) }}">{{ $log->userFrom->username }}</a></td>
                                <td data-label="@lang('Commission To')"><a href="{{ route('admin.users.detail', $log->userTo->id) }}"> {{ $log->userTo->username }}</a></td>
                                <td data-label="@lang('Commission Level')">{{ $log->level }}</td>
                                <td data-label="@lang('Amount')">{{ $log->amount }} {{ $general->cur_text }}</td>
                                <td data-label="@lang('Title')">{{ $log->title }}</td>
                                <td data-label="@lang('Transaction')">{{ $log->trx }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="100%" class="text-center">@lang('Log Not found')</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
                <div class="card-footer py-4">
                    {{ $commissionLog->links('admin.partials.paginate') }}
                </div>
            </div>
        </div>
    </div>
@endsection
