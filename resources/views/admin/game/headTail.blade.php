@extends('admin.layouts.app')

@section('panel')
<div class="row">
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
											<div class="profilePicPreview" style="background-image: url({{ getImage(@imagePath()['game']['path'].'/'.$game->image,imagePath()['game']['size']) }})">
												<button type="button" class="remove-image"><i class="fa fa-times"></i></button>
											</div>
										</div>
										<div class="avatar-edit">
											<input type="file" class="profilePicUpload" name="image" id="profilePicUpload" accept=".png, .jpg, .jpeg" requierd>
											<label for="profilePicUpload" class="bg--primary">@lang('Select Image')</label>
											<small class="mt-2 text-facebook">@lang('Supported files:') <b>@lang('jpeg, jpg, png')</b>. @lang('Image will be resized into') <b>{{ imagePath()['game']['size'] }}@lang('px')</b></small>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-8">
							<div class="row">
								<div class="col-md-7">
									<div class="form-group">
										<label>@lang('Game Name')</label>
										<input type="text" name="name" class="form-control" placeholder="@lang('Game Name')" value="{{ $game->name }}" required>
									</div>
								</div>
								<div class="col-md-5">
									<div class="form-group">
										<label>@lang('Status')</label>
										<div class="input-group mb-3">
											<input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="Active" data-off="Inactive" name="status" @if($game->status == 1) checked @endif>
										</div>
									</div>
								</div>
							</div>


							<div class="row mt-5">
								<div class="col-md-5">
									<div class="card border--primary">
										<h5 class="card-header bg--primary">@lang('Play Amount')</h5>
										<div class="card-body">
											<div class="form-group">
												<label>@lang('Minimum Amount')</label>
												<div class="input-group mb-3">
													<input type="text" name="min" min="1" class="form-control" placeholder="@lang('Minimum Amount')" value="{{ getAmount($game->min_limit) }}" required>
													<div class="input-group-append">
														<span class="input-group-text" id="basic-addon2">{{ $general->cur_sym }}</span>
													</div>
												</div>
											</div>

											<div class="form-group">
												<label>@lang('Maximum Amount')</label>
												<div class="input-group mb-3">
													<input type="text" name="max" min="1" class="form-control" placeholder="@lang('Maximum Amount')" value="{{ getAmount($game->max_limit) }}" required>
													<div class="input-group-append">
														<span class="input-group-text" id="basic-addon2">{{ $general->cur_sym }}</span>
													</div>
												</div>
											</div>

										</div>
									</div>
								</div>
								<div class="col-md-7">
									<div class="card border--warning">
										<h5 class="card-header bg--warning">@lang('Win Setting') </h5>
										<div class="card-body">

											<div class="row">
												<div class="col-md-12">
													<div class="form-group">
														<label>@lang('Winning Chance')</label>
														<div class="input-group mb-3">
															<input type="text" class="form-control" name="probable" value="{{ getAmount($game->probable_win) }}"  placeholder="Winning Chance">
															<div class="input-group-append">
																<span class="input-group-text" id="basic-addon2">@lang('%')</span>
															</div>
														</div>
													</div>
												</div>


												<div class="col-md-6">
													<div class="form-group">
														<label>@lang('Win Amount')</label>
														<div class="input-group mb-3">
															<input type="text" class="form-control" placeholder="Win" value="{{ getAmount($game->win) }}" name="win">
															<div class="input-group-append">
																<span class="input-group-text" id="basic-addon2">@lang('%')</span>
															</div>
														</div>
													</div>
												</div>



												<div class="col-md-6">
													<div class="form-group">
														<label>@lang('Invest')</label>
														<div class="input-group mb-3">
															<input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="Give Back" data-off="No Back" name="invest_back" @if($game->invest_back == 1) checked @endif>
														</div>
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
@push('breadcrumb-plugins')
<a href="{{ route('admin.game.index') }}" class="icon-btn"><i class="fa fa-fw fa-backward"></i> @lang('Go Back') </a>
@endpush
