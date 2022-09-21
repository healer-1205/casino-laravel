@extends(activeTemplate().'user.layouts.app')
@section('panel')
    <div class="col-lg-12">
        <div class="card">
            <div class="table-responsive table-responsive-xl">
                <table class="table align-items-center table-dark">
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
                            <td>{{ __($log->userFrom->username) }}</td>
                            <td>{{ __($log->level) }}</td>
                            <td>{{ __($log->amount) }}</td>
                            <td>{{ __($log->title) }}</td>
                            <td>{{ __($log->trx) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100%" class="text-center">@lang('Log Not found')</td>
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
