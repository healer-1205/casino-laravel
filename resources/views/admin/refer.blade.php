@extends('admin.layouts.app')

@section('panel')
<div class="row">
    <div class="col-md-12">
        @if (count($errors) > 0)
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong class="col-md-12"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> @lang('Alert!')</strong>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif


        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">@lang('CURRENT SETTING')</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">

                                <thead>
                                <tr>

                                    <th>@lang('Level')</th>
                                    <th>@lang('Commision')</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($trans as $key => $p)
                                    <tr>
                                        <td>@lang('LEVEL#') {{ $p->level }}</td>
                                        <td>{{ $p->percent }} @lang('%')</td>
                                    </tr>

                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer">
                        <form action="{{ route('admin.setting.update.refer') }}" method="POST">
                            @csrf
                                <div class="form-row">

                                    <div class="form-group col">
                                        <p class="text-muted">@lang('Deposit Commission')</p>
                                        <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="Enable" data-off="Disable" name="dc" @if($general->dc) checked @endif>
                                    </div>

                                </div>
                            <div class="form-group row">
                                <div class="form-group col">
                                    <button type="submit" class="btn btn-block btn--primary mr-2">@lang('Submit')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">@lang('CHANGE SETTING')</h4>
                    </div>

                   <div class="card-body">
                       <div class="row">
                           <div class="col-md-6">
                               <input type="number" name="level" id="levelGenerate" placeholder="@lang('HOW MANY LEVEL')" class="form-control input-lg" required>
                           </div>
                           <div class="col-md-6">

                               <button type="button" id="generate" class="btn btn-success btn-block btn-md">@lang('GENERATE')</button>
                           </div>
                       </div>
                       <br>
                       <form action="{{route('admin.store.refer')}}" method="post">
                           @csrf

                           <div class="form-group">
                               <label class="text-success"> @lang('Level & Commission :') <small>(@lang('Old Levels will Remove After Generate'))</small> </label>
                               <div class="row">
                                   <div class="col-md-12">
                                       <div class="description d-none">
                                           <div class="row">
                                               <div class="col-md-12" id="planDescriptionContainer">
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
                           <hr>
                           <button type="submit" class="btn btn--primary btn-block">@lang('Submit')</button>
                       </form>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('style')
<style type="text/css">
  .description{
    width: 100%;
    border: 1px solid #ddd;
    padding: 10px;
    border-radius: 5px
  }
</style>
@endpush
@push('script')
    <script>
      (function($){
          "use strict";
          var max = 1;
          $(document).ready(function () {
              $("#generate").on('click', function () {

                  var da = $('#levelGenerate').val();
                  var a = 0;
                  var val = 1;
                  var data = '';
                  if (da !== '' && da >0)
                  {
                      $('.description').removeClass('d-none')

                      for (a; a < parseInt(da);a++){


                          data += '<div class="input-group" style="margin-top: 5px">\n' +
                              '<input name="level[]" class="form-control margin-top-10" type="number" readonly value="'+val+++'" required placeholder="Level">\n' +
                              '<input name="percent[]" class="form-control margin-top-10" type="text" required placeholder="Commission Percentage %">\n' +
                              '<span class="input-group-btn">\n' +
                              '<button class="btn btn-danger margin-top-10 delete_desc" type="button"><i class=\'fa fa-times\'></i></button></span>\n' +
                              '</div>'
                      }
                      $('#planDescriptionContainer').html(data);

                  }else {
                      alert('Level Field Is Required')
                  }

              });

              $(document).on('click', '.delete_desc', function () {
                  $(this).closest('.input-group').remove();
              });
          });
      })(jQuery);

    </script>
@endpush
