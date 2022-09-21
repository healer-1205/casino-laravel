@extends('admin.layouts.app')

@section('panel')
    <div class="row">
    	<div class="col-lg-6">
    		<div class="card">
                    <div class="card-header">
                        <h4 class="card-title">@lang('CURRENT SETTING')</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">

                                <thead>
                                <tr>
                                    <th>@lang('Chance')</th>
                                    <th>@lang('Commision')</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($bon as $key => $p)
                                    <tr>
                                        <td>@lang('CHANCE#') {{ $p->chance }}</td>
                                        <td>{{ getAmount($p->percent) }} %</td>
                                    </tr>

                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
    	</div>
    	<div class="col-lg-6">
    		<div class="card">
    			<div class="card-header">
    				<h4 class="card-title">@lang('CHANCE SETTING')</h4>
    			</div>

    			<div class="card-body">
    				<div class="row">
    					<div class="col-md-6">
    						<input type="number" name="level" id="levelGenerate" placeholder="@lang('HOW MANY CHANCES')" class="form-control input-lg">
    					</div>
    					<div class="col-md-6">
    						<button type="button" id="generate" class="btn btn--success btn-block btn-md">@lang('GENERATE')</button>
    					</div>
    				</div>

    				<br>

    				<form action="{{route('admin.game.chance.create')}}" method="post">
    					{{csrf_field()}}
    					<div class="form-group">
    						<label class="text-success"> @lang('Chance & Bonus') : <small>(@lang('Old Data will Remove After Generate'))</small> </label>
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
    <div class="row mt-5">
        <div class="col-lg-12">
        	<div class="card">
        		<form action="{{ route('admin.game.update',$game->id) }}" method="post" enctype="multipart/form-data">
        			@csrf
        			<div class="card-body">
        				<div class="row">
        					<div class="col-md-4">
        						<div class="form-group">
        							<div class="image-upload">
        								<div class="thumb">
        									<div class="avatar-preview">
        										<div class="profilePicPreview" style="background-image: url({{ getImage(imagePath()['game']['path'].'/'.$game->image,imagePath()['game']['size']) }})">
        											<button type="button" class="remove-image"><i class="fa fa-times"></i></button>
        										</div>
        									</div>
        									<div class="avatar-edit">
        										<input type="file" class="profilePicUpload" name="image" id="profilePicUpload" accept=".png, .jpg, .jpeg" requierd>
        										<label for="profilePicUpload" class="bg--primary">@lang('Post image')</label>
        										<small class="mt-2 text-facebook">@lang('Supported files:') <b>@lang('jpeg, jpg')</b>. @lang('Image will be resized into') <b>{{ imagePath()['game']['size'] }}@lang('px')</b></small>
        									</div>
        								</div>
        							</div>
        						</div>
        					</div>
        					<div class="col-md-8">
        						<div class="row">
        							<div class="col-md-8">
        								<div class="form-group">
        									<label>@lang('Game Name')</label>
        									<input type="text" name="name" class="form-control" placeholder="@lang('Game Name')" value="{{ $game->name }}" required>
        								</div>
        							</div>
        							<div class="col-md-4">
        								<div class="form-group">
        									<label>@lang('Status')</label>
        									<div class="input-group mb-3">
        										<input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="Active" data-off="Inactive" name="status" @if($game->status == 1) checked @endif>
        									</div>
        								</div>
        							</div>
        						</div>
                                <div class="row mt-5 justify-content-center">
                                    <div class="col-md-12">
                                        <div class="card border--primary">
                                            <h5 class="card-header bg--primary">@lang('Play Amount')</h5>
                                            <div class="card-body">
                								<div class="form-group">
                									<label>@lang('Minimum Invest Amount')</label>
                									<div class="input-group mb-3">
                										<input type="text" name="min" min="1" class="form-control" placeholder="@lang('Minimum Invest Amount')" value="{{ getAmount($game->min_limit) }}" required>
                										<div class="input-group-append">
                											<span class="input-group-text" id="basic-addon2">{{ $general->cur_sym }}</span>
                										</div>
                									</div>
                								</div>
                								<div class="form-group">
                									<label>@lang('Maximum Invest Amount')</label>
                									<div class="input-group mb-3">
                										<input type="text" name="max" min="1" class="form-control" placeholder="@lang('Maximum Invest Amount')" value="{{ getAmount($game->max_limit) }}" required>
                										<div class="input-group-append">
                											<span class="input-group-text" id="basic-addon2">{{ $general->cur_sym }}</span>
                										</div>
                									</div>
                								</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
        					</div>
        				</div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>@lang('Game Instruction')</label>
                                    <textarea rows="5" class="form-control nicEdit" name="instruction">@php echo $game->instruction @endphp</textarea>
                                </div>
                            </div>
                        </div>
        			</div>
        			<div class="card-footer">
        				<button type="submit" class="btn btn--success btn-lg btn-block">@lang('Update')</button>
        			</div>
        		</form>
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
                                '<input name="chance[]" class="form-control margin-top-10" type="number" readonly value="'+val+++'" required placeholder="Level">\n' +
                                '<input name="percent[]" class="form-control margin-top-10" type="text" required placeholder="Commission Percentage %">\n' +
                                '<span class="input-group-btn">\n' +
                                '<button class="btn btn-danger margin-top-10 delete_desc" type="button"><i class=\'fa fa-times\'></i></button></span>\n' +
                                '</div>'
                        }
                        $()
                        $('#planDescriptionContainer').html(data);

                    }else {
                        alert('Chance Field Is Required')
                    }

                });

                $(document).on('click', '.delete_desc', function () {
                    $(this).closest('.input-group').remove();
                });
            });
        })(jQuery)

    </script>
@endpush
@push('breadcrumb-plugins')
<a href="{{ route('admin.game.index') }}" class="icon-btn"><i class="fa fa-fw fa-backward"></i> @lang('Go Back') </a>
@endpush
