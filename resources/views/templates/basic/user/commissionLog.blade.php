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
                                            <th>@lang('Commission From')</th>
                                            <th>@lang('Commission Level')</th>
                                            <th>@lang('Amount')</th>
                                            <th>@lang('Title')</th>
                                            <th>@lang('Transaction')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($logs as $log)
                                        <tr>
                                            <td data-label="@lang('Commission From')">{{ __($log->userFrom->username) }}</td>
                                            <td data-label="@lang('Commission Level')">{{ __($log->level) }}</td>
                                            <td data-label="@lang('Amount')">{{ __($log->amount) }} {{ $general->cur_text }}</td>
                                            <td data-label="@lang('Title')">{{ __($log->title) }}</td>
                                            <td data-label="@lang('Transaction')">{{ __($log->trx) }}</td>
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
                    </div>
                    <div class="mt-4">
                        {{$logs->links()}}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
