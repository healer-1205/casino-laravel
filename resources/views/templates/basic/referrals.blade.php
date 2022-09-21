@extends(activeTemplate().'user.layouts.app')
@section('panel')
<div class="row">

    <div class="col-lg-12">
        <div class="card">
            <div class="table-responsive table-responsive-xl">
                <table class="table align-items-center table-dark">
                    <thead>
                        <tr>
                            <th scope="col">@lang('Username')</th>
                            <th scope="col">@lang('Email')</th>
                            <th scope="col">@lang('Balance')</th>
                        </tr>
                    </thead>
                    <tbody class="list">
                        @forelse($refs as $log)
                        <tr>
                            <td>{{ __($log->username) }}</td>
                            <td>{{ $log->email }}</td>
                            <td>{{ $log->balance + 0 }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-muted text-center" colspan="100%">{{ __($empty_message) }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer py-4">
                <nav aria-label="...">
                    {{ $refs->links() }}
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection