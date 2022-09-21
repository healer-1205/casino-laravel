@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="{{ route('admin.gateway.automatic.update', $gateway->code) }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="alias" value="{{ $gateway->alias }}">
                    <input type="hidden" name="description" value="{{ $gateway->description }}">


                    <div class="card-body">
                        <div class="payment-method-item">
                            <div class="payment-method-header">
                                <div class="thumb">
                                    <div class="avatar-preview">
                                        <div class="profilePicPreview" style="background-image: url('{{ getImage(imagePath()['gateway']['path'].'/'. $gateway->image,imagePath()['gateway']['size']) }}')"></div>
                                    </div>
                                    <div class="avatar-edit">
                                        <input type="file" name="image" class="profilePicUpload" id="image" accept=".png, .jpg, .jpeg"/>
                                        <label for="image" class="bg--primary"><i class="la la-pencil"></i></label>
                                    </div>
                                </div>

                                <div class="content">
                                    <div class="d-flex justify-content-between">
                                        <h3 class="title">{{ __($gateway->name) }}</h3>
                                        <div class="input-group d-flex flex-wrap justify-content-end has_append width-375">
                                            <select class="newCurrencyVal ">
                                                <option value="">@lang('Select currency')</option>
                                                @forelse($supportedCurrencies as $currency => $symbol)
                                                    <option value="{{$currency}}" data-symbol="{{ $symbol }}">{{ __($currency) }} </option>
                                                @empty
                                                    <option value="">@lang('No available currency support')</option>
                                                @endforelse

                                            </select>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn--primary newCurrencyBtn" data-crypto="{{ $gateway->crypto }}" data-name="{{ $gateway->name }}">@lang('Add new')
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <p>{{ __($gateway->description) }}</p>
                                </div>
                            </div>

                            @if($gateway->code < 1000 && $gateway->extra)
                                <div class="payment-method-body mt-2">
                                    <h4 class="mb-3">@lang('Configurations')</h4>
                                    <div class="row">
                                        @foreach($gateway->extra as $key => $param)
                                            <div class="form-group col-lg-6">
                                                <label>{{ __(@$param->title) }}</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" value="{{ route($param->value) }}" readonly/>
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <span class="copyInput" data-toggle="tooltip" title="@lang('Copy')"><i class="fa fa-copy"></i></span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            <div class="payment-method-body mt-2">
                                <h4 class="mb-3">@lang('Global Setting for') {{ __($gateway->name) }}</h4>
                                <div class="row">
                                    @foreach($parameters->where('global', true) as $key => $param)
                                        <div class="form-group col-lg-6">
                                            <label>{{ __(@$param->title) }} <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="global[{{ $key }}]" value="{{ @$param->value }}" required/>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <!-- payment-method-item start -->

                        @isset($gateway->currencies)
                            @foreach($gateway->currencies as $gatewayCurrency)
                                <input type="hidden" name="currency[{{ $currencyIdx }}][symbol]"
                                       value="{{ $gatewayCurrency->symbol }}">
                                <div class="payment-method-item child--item">
                                    <div class="payment-method-header">
                                        <div class="thumb">
                                            <div class="avatar-preview">
                                                <div class="profilePicPreview" style="background-image: url('{{getImage(imagePath()['gateway']['path'].'/'.$gatewayCurrency->image,imagePath()['gateway']['size'])}}')"></div>
                                            </div>
                                            <div class="avatar-edit">
                                                <input type="file" name="currency[{{ $currencyIdx }}][image]" id="image{{ $currencyIdx }}" class="profilePicUpload" accept=".png, .jpg, .jpeg"/>
                                                <label for="image{{ $currencyIdx }}" class="bg--primary"><i class="la la-pencil"></i
                                                    ></label>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <div class="d-flex justify-content-between">
                                                <div class="form-group">
                                                    <h4 class="mb-3">{{ __($gateway->name) }} - {{__($gatewayCurrency->currency)}}</h4>
                                                    <input type="text" class="form-control" placeholder="@lang('Name of the Gateway')" name="currency[{{ $currencyIdx }}][name]" value="{{ $gatewayCurrency->name }}" required/>
                                                </div>
                                                <div class="remove-btn">
                                                    <button type="button" class="btn btn--danger deleteBtn" data-id="{{ $gatewayCurrency->id }}" data-name="{{ $gatewayCurrency->currencyIdentifier() }}">
                                                        <i class="la la-trash-o mr-2"></i>@lang('Remove')
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="payment-method-body">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4">
                                                <div class="card border--primary mt-2">
                                                    <h5 class="card-header bg--primary">@lang('Range')</h5>
                                                    <div class="card-body">
                                                        <div class="input-group mb-3">
                                                            <label class="w-100">@lang('Minimum Amount') <span class="text-danger">*</span></label>
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">{{ __($general->cur_sym) }}</div>
                                                            </div>
                                                            <input type="text" class="form-control" name="currency[{{ $currencyIdx }}][min_amount]" value="{{ getAmount($gatewayCurrency->min_amount) }}" placeholder="0" required/>
                                                        </div>
                                                        <div class="input-group">
                                                            <label class="w-100">@lang('Maximum Amount') <span class="text-danger">*</span></label>
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">{{ __($general->cur_sym) }}</div>
                                                            </div>
                                                            <input type="text" class="form-control" placeholder="0" name="currency[{{ $currencyIdx }}][max_amount]" value="{{ getAmount($gatewayCurrency->max_amount) }}" required/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4">
                                                <div class="card border--primary mt-2">
                                                    <h5 class="card-header bg--primary">@lang('Charge')</h5>
                                                    <div class="card-body">
                                                        <div class="input-group mb-3">
                                                            <label class="w-100">@lang('Fixed Charge') <span class="text-danger">*</span></label>
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">{{ __($general->cur_sym) }}</div>
                                                            </div>
                                                            <input type="text" class="form-control" placeholder="0" name="currency[{{ $currencyIdx }}][fixed_charge]" value="{{ getAmount($gatewayCurrency->fixed_charge) }}" required/>
                                                        </div>
                                                        <div class="input-group">
                                                            <label class="w-100">@lang('Percent Charge') <span class="text-danger">*</span></label>
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">%</div>
                                                            </div>
                                                            <input type="text" class="form-control" placeholder="0" name="currency[{{ $currencyIdx }}][percent_charge]" value="{{ getAmount($gatewayCurrency->percent_charge) }}" required/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4">
                                                <div class="card border--primary mt-2">
                                                    <h5 class="card-header bg--primary">@lang('Currency')</h5>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="input-group mb-3">
                                                                    <label class="w-100">@lang('Currency')</label>
                                                                    <input type="text" name="currency[{{ $currencyIdx }}][currency]" class="form-control border-radius-5 " value="{{ $gatewayCurrency->currency }}" readonly/>
                                                                </div>

                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="input-group mb-3">
                                                                    <label class="w-100">@lang('Symbol')</label>
                                                                    <input type="text" name="currency[{{ $currencyIdx }}][symbol]" class="form-control border-radius-5 symbl" value="{{ $gatewayCurrency->symbol }}" data-crypto="{{ $gateway->crypto }}" required/>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="input-group">
                                                            <label class="w-100">@lang('Rate') <span class="text-danger">*</span></label>
                                                            <div class="input-group-prepend">

                                                                <div class="input-group-text">1 {{ __($general->cur_text) }}
                                                                    =
                                                                </div>
                                                            </div>
                                                            <input type="text" class="form-control" placeholder="0" name="currency[{{ $currencyIdx }}][rate]" value="{{ getAmount($gatewayCurrency->rate) }}" required/>
                                                            <div class="input-group-append">

                                                                <div class="input-group-text"><span class="currency_symbol">{{ __($gatewayCurrency->baseSymbol()) }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            @if($parameters->where('global', false)->count()  != 0 )
                                                @php
                                                    $gateway_parameter = json_decode($gatewayCurrency->gateway_parameter);
                                                @endphp
                                                <div class="col-lg-12">
                                                    <div class="card border--primary mt-4">
                                                        <h5 class="card-header bg--dark">@lang('Configuration')</h5>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                @foreach($parameters->where('global', false) as $key => $param)
                                                                    <div class="col-md-6">
                                                                        <div class="input-group mb-3">
                                                                            <label class="w-100">{{ __($param->title) }}
                                                                                <span class="text-danger">*</span></label>
                                                                            <input type="text" class="form-control" name="currency[{{ $currencyIdx }}][param][{{ $key }}]" value="{{ $gateway_parameter->$key }}" placeholder="---" required/>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @php $currencyIdx++ @endphp
                            @endforeach
                        @endisset

                    <!-- payment-method-item end -->


                        <!-- **new payment-method-item start -->
                        <div class="payment-method-item child--item newMethodCurrency d-none">
                            <input disabled type="hidden" name="currency[{{ $currencyIdx }}][symbol]"
                                   class="currencySymbol">
                            <div class="payment-method-header">
                                <div class="thumb">
                                    <div class="avatar-preview">
                                        <div class="profilePicPreview"
                                             style="background-image: url('{{getImage(imagePath()['gateway']['path'],imagePath()['gateway']['size'])}}')">

                                        </div>
                                    </div>
                                    <div class="avatar-edit">
                                        <input disabled type="file" accept=".png, .jpg, .jpeg" class="profilePicUpload" id="image{{ $currencyIdx }}" name="currency[{{ $currencyIdx }}][image]"/>
                                        <label for="image{{ $currencyIdx }}" class="bg--primary"><i class="la la-pencil"></i></label>
                                    </div>
                                </div>
                                <div class="content">
                                    <div class="d-flex justify-content-between">
                                        <div class="form-group">
                                            <h4 class="mb-3" id="payment_currency_name">@lang('Name')</h4>
                                            <input disabled type="text" class="form-control" placeholder="@lang('Name for Gateway')" name="currency[{{ $currencyIdx }}][name]" required/>
                                        </div>
                                        <div class="remove-btn">
                                            <button type="button" class="btn btn-danger newCurrencyRemove">
                                                <i class="la la-trash-o mr-2"></i>@lang('Remove')
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="payment-method-body">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4">
                                        <div class="card border--primary mt-2">
                                            <h5 class="card-header bg--primary">@lang('Range')</h5>
                                            <div class="card-body">
                                                <div class="input-group mb-3">
                                                    <label class="w-100">@lang('Minimum Amount') <span class="text-danger">*</span></label>
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">{{ __($general->cur_text) }}</div>
                                                    </div>
                                                    <input disabled type="text" class="form-control" name="currency[{{ $currencyIdx }}][min_amount]" placeholder="0" required/>
                                                </div>

                                                <div class="input-group">
                                                    <label class="w-100">@lang('Maximum Amount') <span class="text-danger">*</span></label>
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">{{ __($general->cur_text) }}</div>
                                                    </div>

                                                    <input disabled type="text" class="form-control" placeholder="0" name="currency[{{ $currencyIdx }}][max_amount]" required/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4">
                                        <div class="card border--primary mt-2">
                                            <h5 class="card-header bg--primary">@lang('Charge')</h5>
                                            <div class="card-body">
                                                <div class="input-group mb-3">
                                                    <label class="w-100">@lang('Fixed Charge') <span class="text-danger">*</span></label>
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">{{ __($general->cur_text) }}</div>
                                                    </div>
                                                    <input disabled type="text" class="form-control" placeholder="0" name="currency[{{ $currencyIdx }}][fixed_charge]" required/>
                                                </div>
                                                <div class="input-group">
                                                    <label class="w-100">@lang('Percent Charge') <span class="text-danger">*</span></label>
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">%</div>
                                                    </div>
                                                    <input disabled type="text" class="form-control" placeholder="0" name="currency[{{ $currencyIdx }}][percent_charge]" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4">
                                        <div class="card border--primary mt-2">
                                            <h5 class="card-header bg--primary">@lang('Currency')</h5>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="input-group mb-3">
                                                            <label class="w-100">@lang('Currency')</label>
                                                            <input disabled type="text" class="form-control currencyText border-radius-5" name="currency[{{ $currencyIdx }}][currency]" readonly/>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="input-group mb-3">
                                                            <label class="w-100">@lang('Symbol')</label>
                                                            <input type="text" name="currency[{{ $currencyIdx }}][symbol]" class="form-control border-radius-5 symbl" ata-crypto="{{ $gateway->crypto }}" disabled/>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="input-group">
                                                    <label class="w-100">@lang('Rate') <span class="text-danger">*</span></label>
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <b>1 </b>&nbsp; {{ __($general->cur_text) }}&nbsp; =
                                                        </div>
                                                    </div>
                                                    <input disabled type="text" class="form-control" placeholder="0" name="currency[{{ $currencyIdx }}][rate]" required/>
                                                    <div class="input-group-append">
                                                        <div class="input-group-text"><span class="currency_symbol"></span></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @if($parameters->where('global', false)->count()  != 0 )
                                        <div class="col-lg-12">
                                            <div class="card border--primary mt-4">
                                                <h5 class="card-header bg--dark">@lang('Configuration')</h5>
                                                <div class="card-body">
                                                    <div class="row">
                                                        @foreach($parameters->where('global', false) as $key => $param)
                                                            <div class="col-md-6">
                                                                <div class="input-group mb-3">
                                                                    <label class="w-100">{{ __($param->title) }} <span class="text-danger">*</span></label>
                                                                    <input disabled type="text" class="form-control" name="currency[{{ $currencyIdx }}][param][{{ $key }}]" placeholder="---" required/>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                        <!-- **new payment-method-item end -->
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn--primary btn-block py-2">
                            @lang('Update Setting')
                        </button>
                    </div>
                </form>
            </div>
        </div>


    </div>



    {{-- DELETE GATEWAY MODAL --}}
    <div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Gateway Currency Remove Confirmation')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.gateway.automatic.remove', $gateway->code) }}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <p>@lang('Are you sure to delete') <span class="font-weight-bold name"></span> @lang('gateway currency?')</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--danger">@lang('Delete')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection





@push('breadcrumb-plugins')
    <a href="{{ route('admin.gateway.automatic.index') }}" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="la la-fw fa-backward"></i>@lang('Go Back')</a>
@endpush

@push('script')
    <script>
        (function ($) {
            "use strict";

            $('.newCurrencyBtn').on('click', function () {
                var form = $('.newMethodCurrency');
                var getCurrencySelected = $('.newCurrencyVal').find(':selected').val();
                var currency = $(this).data('crypto') == 1 ? 'USD' : `${getCurrencySelected}`;
                if (!getCurrencySelected) return;
                form.find('input').removeAttr('disabled');
                var symbol = $('.newCurrencyVal').find(':selected').data('symbol');
                form.find('.currencyText').val(getCurrencySelected);
                form.find('.currency_symbol').text(currency);
                $('#payment_currency_name').text(`${$(this).data('name')} - ${getCurrencySelected}`);
                form.removeClass('d-none');
                $('html, body').animate({scrollTop: $('html, body').height()}, 'slow');

                $('.newCurrencyRemove').on('click', function () {
                    form.find('input').val('');
                    form.remove();
                });
            });

            $('.deleteBtn').on('click', function () {
                var modal = $('#deleteModal');
                modal.find('input[name=id]').val($(this).data('id'));
                modal.find('.name').text($(this).data('name'));
                modal.modal('show');
            });

            $('.symbl').on('input', function () {
                var curText = $(this).data('crypto') == 1 ? 'USD' : $(this).val();
                $(this).parents('.payment-method-body').find('.currency_symbol').text(curText);
            });

            $('.copyInput').on('click', function (e) {
                var copybtn = $(this);
                var input = copybtn.parent().parent().siblings('input');
                if (input && input.select) {
                    input.select();
                    try {
                        document.execCommand('SelectAll')
                        document.execCommand('Copy', false, null);
                        input.blur();
                        notify('success',`Copied: ${copybtn.closest('.input-group').find('input').val()}`);
                    } catch (err) {
                        alert('Please press Ctrl/Cmd + C to copy');
                    }
                }
            });

        })(jQuery);

    </script>
@endpush
