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
                            @forelse($commissions as $log)
                            <tr>
                                <td data-label="@lang('Commission From')">{{ __($log->userFrom->username) }}</td>
                                <td data-label="@lang('Commission To')">{{ __($log->userTo->username) }}</td>
                                <td data-label="@lang('Commission Level')">{{ __($log->level) }}</td>
                                <td data-label="@lang('Amount')">{{ __($log->amount) }} {{ $general->cur_text }}</td>
                                <td data-label="@lang('Title')">{{ __($log->title) }}</td>
                                <td data-label="@lang('Transaction')">{{ __($log->trx) }}</td>
                           </tr>
                           @empty
                           <tr>
                            <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                        </tr>
                        @endforelse

                    </tbody>
                </table><!-- table end -->
            </div>
        </div>
        <div class="card-footer py-4">
            {{ paginateLinks($commissions) }}
        </div>
    </div><!-- card end -->
</div>
</div>

@endsection


