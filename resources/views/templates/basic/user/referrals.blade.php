@extends($activeTemplate.'layouts.master')

@section('content')
    <section class="pt-120 pb-120">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" name="key" value="{{ route('home', ['reference' => auth()->user()->username]) }}" class="form-control form-control-lg" id="referralURL" readonly>
                            <div class="input-group-append">
                                <span class="input-group-text copytext" id="copyBoard" onclick="myFunction()">@lang('Copy')</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="table--responsive">
                                <table class="table style--two">
                                    <thead>
                                    <tr>
                                        <th scope="col">@lang('Username')</th>
                                        <th scope="col">@lang('Email')</th>
                                    </tr>
                                    </thead>
                                    <tbody class="list">
                                    @forelse($refs as $log)
                                        <tr>
                                            <td data-label="@lang('Username')">{{ __($log->username) }}</td>
                                            <td data-label="@lang('Email')">{{ $log->email }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-muted text-center"
                                                colspan="100%">{{ __($empty_message) }}</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        {{ $refs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('style')
    <style type="text/css">
        .content-wrapper {
            margin-top: -90px;
            min-height: calc(100vh - 157px);
        }
        .copytext{
            cursor: pointer;
        }
    </style>
@endpush

@push('script')
    <script>
        "use strict";

        function myFunction() {
            var copyText = document.getElementById("referralURL");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            /*For mobile devices*/
            document.execCommand("copy");
            iziToast.success({message: "Copied: " + copyText.value, position: "topRight"});
        }
    </script>
@endpush
