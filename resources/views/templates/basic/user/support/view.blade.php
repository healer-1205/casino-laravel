@extends($activeTemplate.'layouts.frontend')

@section('content')
    <section class="pt-120 pb-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-bg d-flex flex-wrap justify-content-between align-items-center">
                            <h5 class="card-title mt-0">
                                @if($my_ticket->status == 0)
                                    <span class="badge badge--success">@lang('Open')</span>
                                @elseif($my_ticket->status == 1)
                                    <span class="badge badge--primary">@lang('Answered')</span>
                                @elseif($my_ticket->status == 2)
                                    <span class="badge badge--warning">@lang('Replied')</span>
                                @elseif($my_ticket->status == 3)
                                    <span class="badge badge--dark">@lang('Closed')</span>
                                @endif
                                [@lang('Ticket')#{{ $my_ticket->ticket }}] {{ $my_ticket->subject }}
                            </h5>
                            <button class="btn btn-danger close-button" type="button" title="@lang('Close Ticket')"
                                    data-toggle="modal" data-target="#DelModal"><i class="las la-times-circle"></i>
                            </button>
                        </div>
                        <div class="card-body">
                            @if($my_ticket->status != 4)
                                <form method="post" action="{{ route('ticket.reply', $my_ticket->id) }}"
                                        enctype="multipart/form-data" class="mb-4">
                                    @csrf
                                    <div class="row justify-content-between">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <textarea name="message"
                                                            class="form-control"
                                                            id="inputMessage"
                                                            placeholder="@lang('Your Reply')" rows="4"
                                                            cols="10"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-between">
                                        <div class="col-md-8">
                                            <div class="row justify-content-between">
                                                <div class="col-md-11">

                                                    <div class="form-group">
                                                        <div class="position-relative">
                                                            <input type="file" name="attachments[]"
                                                                    id="inputAttachments"
                                                                    class="form-control custom--file-upload my-1"/>
                                                            <label
                                                                for="inputAttachments">@lang('Attachments')</label>
                                                        </div>
                                                        <p class="my-2 ticket-attachments-message text-muted">
                                                            @lang("Allowed File Extensions: .jpg, .jpeg, .png, .pdf")
                                                        </p>
                                                        <div id="fileUploadsContainer"></div>
                                                    </div>

                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group">
                                                        <a href="javascript:void(0)"
                                                            class="base--bg add-btn addFile">
                                                            <i class="las la-plus"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <button type="submit"
                                                    class="cmn-btn custom-success"
                                                    name="replayTicket" value="1">
                                                <i class="fa fa-reply"></i> @lang('Reply')
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            @endif

                            @foreach($messages as $message)
                                @if($message->admin_id == 0)
                                    <div
                                        class="single-reply">
                                        <div class="left">
                                            <h5>{{ $message->ticket->name }}</h5>
                                        </div>
                                        <div class="right">
                                            <p class="mb-2 text--base f-size--14">
                                                @lang('Posted on') {{ $message->created_at->format('l, dS F Y @ H:i') }}</p>
                                            <p>{{$message->message}}</p>
                                            @if($message->attachments()->count() > 0)
                                                <div class="mt-2">
                                                    @foreach($message->attachments as $k=> $image)
                                                        <a href="{{route('ticket.download',encrypt($image->id))}}"
                                                            class="mr-3"><i
                                                                class="fa fa-file"></i> @lang('Attachment') {{++$k}}
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <div
                                        class="single-reply"
                                        style="background-color: #ffd96729">
                                        <div class="left">
                                            <h5>{{ $message->admin->name }}</h5>
                                            <p>(@lang('Staff'))</p>
                                        </div>
                                        <div class="right">
                                            <p class="mb-2 text--base f-size--14">
                                                @lang('Posted on') {{ $message->created_at->format('l, dS F Y @ H:i') }}</p>
                                            <p>{{$message->message}}</p>
                                            @if($message->attachments()->count() > 0)
                                                <div class="mt-2">
                                                    @foreach($message->attachments as $k=> $image)
                                                        <a href="{{route('ticket.download',encrypt($image->id))}}"
                                                            class="mr-3"><i
                                                                class="fa fa-file"></i> @lang('Attachment') {{++$k}}
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="modal fade" id="DelModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content section--bg">

                <form method="post" action="{{ route('ticket.reply', $my_ticket->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="modal-header">
                        <h5 class="modal-title"> @lang('Confirmation')!</h5>

                        <button type="button" class="close close-button" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        @lang('Are you sure you want to Close This Support Ticket')?
                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i
                                class="fa fa-times"></i>
                            @lang('Close')
                        </button>

                        <button type="submit" class="btn base--bg btn-sm" name="replayTicket"
                                value="2"><i class="fa fa-check"></i> @lang("Confirm")
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function ($) {
            "use strict";
            $('.delete-message').on('click', function (e) {
                $('.message_id').val($(this).data('id'));
            });
            $('.addFile').on('click', function () {
                $("#fileUploadsContainer").append(`<div class="position-relative mb-2">
                                                        <input type="file" name="attachments[]" id="inputAttachments" class="form-control custom--file-upload my-1"/>
                                                        <label for="inputAttachments">@lang('Attachments')</label>
                                                    </div>`)
            });
        })(jQuery);

    </script>
@endpush
