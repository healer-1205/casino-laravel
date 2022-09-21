@extends('admin.layouts.app')
@section('panel')

    <div id="app">
        <div class="row">

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                        <div class="row justify-content-between">
                            <div class="col-md-7">
                                <ul>
                                    <li>
                                        <h5>@lang('Language Keywords of') {{ __($lang->name) }}</h5>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-5 mt-md-0 mt-3">
                                <button type="button" data-toggle="modal" data-target="#addModal" class="btn btn-sm btn--primary box--shadow1 text--small float-right"><i class="fa fa-plus"></i> @lang('Add New Key') </button>
                            </div>
                        </div>
                        <hr>
                        <div class="table-responsive--sm table-responsive">
                            <table class="table table--light tabstyle--two custom-data-table white-space-wrap" id="myTable">
                                <thead>
                                <tr>
                                    <th>@lang('Key')
                                    </th>
                                    <th class="text-left">
                                        {{__($lang->name)}}
                                    </th>

                                    <th class="w-85">@lang('Action')</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($json as $k => $language)
                                    <tr>
                                        <td data-label="@lang('key')" class="white-space-wrap">{{$k}}</td>
                                        <td data-label="@lang('Value')" class="text-left white-space-wrap">{{$language}}</td>


                                        <td data-label="@lang('Action')">
                                            <a href="javascript:void(0)"
                                               data-target="#editModal"
                                               data-toggle="modal"
                                               data-title="{{$k}}"
                                               data-key="{{$k}}"
                                               data-value="{{$language}}"
                                               class="editModal icon-btn ml-1"
                                               data-original-title="@lang('Edit')">
                                                <i class="la la-pencil"></i>
                                            </a>

                                            <a href="javascript:void(0)"
                                               data-key="{{$k}}"
                                               data-value="{{$language}}"
                                               data-toggle="modal" data-target="#DelModal"
                                               class="icon-btn btn--danger ml-1 deleteKey"
                                               data-original-title="@lang('Remove')">
                                                <i class="la la-trash"></i>
                                            </a>
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


        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="addModalLabel"> @lang('Add New')</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>

                    <form action="{{route('admin.language.store.key',$lang->id)}}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="key" class="font-weight-bold">@lang('Key')</label>
                                <input type="text" class="form-control form-control-lg " id="key" name="key" placeholder="@lang('Key')" value="{{old('key')}}">

                            </div>
                            <div class="form-group">
                                <label for="value" class="font-weight-bold">@lang('Value')</label>
                                <input type="text" class="form-control form-control-lg" id="value" name="value" placeholder="@lang('Value')" value="{{old('value')}}">

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                            <button type="submit" class="btn btn--primary"> @lang('Save')</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>


        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="editModalLabel">@lang('Edit')</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>

                    <form action="{{route('admin.language.update.key',$lang->id)}}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group ">
                                <label for="inputName" class="font-weight-bold form-title"></label>
                                <input type="text" class="form-control form-control-lg" name="value" placeholder="@lang('Value')">
                            </div>
                            <input type="hidden" name="key">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                            <button type="submit" class="btn btn--primary">@lang('Update')</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>


        <!-- Modal for DELETE -->
        <div class="modal fade" id="DelModal" tabindex="-1" role="dialog" aria-labelledby="DelModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="DelModalLabel"><i class='fa fa-trash'></i> @lang('Delete')!</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <strong>@lang('Are you sure to delete?')</strong>
                    </div>
                    <form action="{{route('admin.language.delete.key',$lang->id)}}" method="post">
                        @csrf
                        <input type="hidden" name="key">
                        <input type="hidden" name="value">
                        <div class="modal-footer">
                            <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                            <button type="submit" class="btn btn--danger ">@lang('Delete')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    {{-- Import Modal --}}
    <div class="modal fade" id="importModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Import Language')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-center text--danger">@lang('If you import keywords, Your current keywords will be removed and replaced by imported keyword')</p>
                        <div class="form-group">
                        <label for="key" class="font-weight-bold">@lang('Key')</label>
                        <select class="form-control select_lang"  required>
                            <option value="">@lang('Import Keywords')</option>
                            @foreach($list_lang as $data)
                            <option value="{{$data->id}}" @if($data->id == $lang->id) class="d-none" @endif >{{__($data->name)}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                    <button type="button" class="btn btn--primary import_lang"> @lang('Import Now')</button>
                </div>
            </div>
        </div>
    </div>
@stop


@push('breadcrumb-plugins')
<button type="button" class="btn btn-sm btn--primary box--shadow1 importBtn"><i class="la la-download"></i>@lang('Import Language')</button>
@endpush

@push('script')
    <script>
        (function($){
            "use strict";
            $(document).on('click','.deleteKey',function () {
                var modal = $('#DelModal');
                modal.find('input[name=key]').val($(this).data('key'));
                modal.find('input[name=value]').val($(this).data('value'));
            });
            $(document).on('click','.editModal',function () {
                var modal = $('#editModal');
                modal.find('.form-title').text($(this).data('title'));
                modal.find('input[name=key]').val($(this).data('key'));
                modal.find('input[name=value]').val($(this).data('value'));
            });


            $(document).on('click','.importBtn',function () {
                $('#importModal').modal('show');
            });
            $(document).on('click','.import_lang',function(e){
                var id = $('.select_lang').val();

                if(id ==''){
                    notify('error','Import Data Successfully');

                    return 0;
                }else{
                    $.ajax({
                        type:"post",
                        url:"{{route('admin.language.importLang')}}",
                        data:{
                            id : id,
                            toLangid : "{{$lang->id}}",
                            _token: "{{csrf_token()}}"
                        },
                        success:function(data){
                            if (data == 'success'){
                                notify('success','Import Data Successfully');
                                window.location.href = "{{url()->current()}}"
                            }
                        }
                    });
                }

            });
        })(jQuery);
    </script>
@endpush
