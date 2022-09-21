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
                                        <th scope="col">@lang('Transaction ID')</th>
                                        <th scope="col">@lang('Gateway')</th>
                                        <th scope="col">@lang('Amount')</th>
                                        <th scope="col">@lang('Status')</th>
                                        <th scope="col">@lang('Time')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($logs) >0)
                                        @foreach($logs as $k=>$data)
                                            <tr>
                                                <td data-label="#@lang('Trx')">
                                                    <span class="text--base">{{$data->trx}}</span>
                                                </td>
                                                <td data-label="@lang('Gateway')">{{ $data->gateway->name   }}</td>
                                                <td data-label="@lang('Amount')">
                                                    <strong>{{getAmount($data->amount)}} {{$general->cur_text}}</strong>
                                                </td>
                                                <td>
                                                    @if($data->status == 1)
                                                        <span class="badge badge--success">@lang('Complete')</span>
                                                    @elseif($data->status == 2)
                                                        <span class="badge badge--warning">@lang('Pending')</span>
                                                    @elseif($data->status == 3)
                                                        <span class="badge badge--danger">@lang('Cancel')</span>
                                                    @endif

                                                    @if($data->admin_feedback != null)
                                                        <button class="btn-info btn-rounded  badge detailBtn" data-admin_feedback="{{$data->admin_feedback}}"><i class="fa fa-info"></i></button>
                                                    @endif


                                                </td>
                                                <td data-label="@lang('Time')">
                                                    <i class="las la-calendar"></i> {{showDateTime($data->created_at)}}
                                                </td>


                                                @php
                                                    $details = ($data->detail != null) ? json_encode($data->detail) : null;
                                                @endphp


                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="100%"> @lang('No results found')!</td>
                                        </tr>
                                    @endif
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


    {{-- APPROVE MODAL --}}
    <div id="approveModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content section--bg">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Details')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="list-group">
                        <li class="list-group-item section--bg">@lang('Amount') : <span class="withdraw-amount "></span></li>
                        <li class="list-group-item section--bg">@lang('Charge') : <span class="withdraw-charge "></span></li>
                        <li class="list-group-item section--bg">@lang('After Charge') : <span class="withdraw-after_charge"></span></li>
                        <li class="list-group-item section--bg">@lang('Conversion Rate') : <span class="withdraw-rate"></span></li>
                        <li class="list-group-item section--bg">@lang('Payable Amount') : <span class="withdraw-payable"></span></li>
                    </ul>
                    <ul class="list-group withdraw-detail mt-1">
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Detail MODAL --}}
    <div id="detailModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Details')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="withdraw-detail"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>
        (function ($) {
            "use strict";

            $('.approveBtn').on('click', function() {
                var modal = $('#approveModal');
                modal.find('.withdraw-amount').text($(this).data('amount'));
                modal.find('.withdraw-charge').text($(this).data('charge'));
                modal.find('.withdraw-after_charge').text($(this).data('after_charge'));
                modal.find('.withdraw-rate').text($(this).data('rate'));
                modal.find('.withdraw-payable').text($(this).data('payable'));
                var list = [];
                var details =  Object.entries($(this).data('info'));

                var ImgPath = "{{asset(imagePath()['verify']['deposit']['path'])}}/";
                var singleInfo = '';
                for (var i = 0; i < details.length; i++) {
                    if (details[i][1].type == 'file') {
                        singleInfo += `<li class="list-group-item">
                                        <span class="font-weight-bold "> ${details[i][0].replaceAll('_', " ")} </span> : <img src="${ImgPath}/${details[i][1].field_name}" alt="..." class="w-100">
                                    </li>`;
                    }else{
                        singleInfo += `<li class="list-group-item">
                                        <span class="font-weight-bold "> ${details[i][0].replaceAll('_', " ")} </span> : <span class="font-weight-bold ml-3">${details[i][1].field_name}</span>
                                    </li>`;
                    }
                }

                modal.find('.withdraw-detail').html(`<br><strong class="my-3">Payment Information</strong>  ${singleInfo}`);
                modal.modal('show');
            });

            $('.detailBtn').on('click', function() {
                var modal = $('#detailModal');
                var feedback = $(this).data('admin_feedback');
                modal.find('.withdraw-detail').html(`<p> ${feedback} </p>`);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush

