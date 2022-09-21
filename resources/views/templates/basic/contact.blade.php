@extends($activeTemplate.'layouts.frontend')
@section('content')

    @php
        $contact_content = getContent('contact_us.content', true);
        $address_content = getContent('address.content', true);
    @endphp

<section class="pt-120 pb-120">
    <div class="container pb-120">
        <div class="row justify-content-center">
            <div class="col-lg-12 mb-50">
                <h2 class="font-weight-bold">@lang('Quick Support')</h2>
                <span>@lang('You can get all information')</span>
            </div>
            <div class="col-lg-12">
                <div class="row mb-none-30">
                    <div class="col-md-4 col-sm-6 mb-30">
                        <div class="contact-item">
                            <i class="fas fa-phone-alt"></i>
                            <h5 class="mt-2">@lang('Call Us')</h5>
                            <div class="mt-4">
                                <p><a href="tel:{{ @$address_content->data_values->phone }}">{{ __(@$address_content->data_values->phone) }}</a></p>
                            </div>
                        </div><!-- contact-item end -->
                    </div>
                    <div class="col-md-4 col-sm-6 mb-30">
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <h5 class="mt-2">@lang('Mail Us')</h5>
                            <div class="mt-4">
                                <p><a href="mailto:{{ @$address_content->data_values->email }}">{{ __(@$address_content->data_values->email) }}</a></p>
                            </div>
                        </div><!-- contact-item end -->
                    </div>
                    <div class="col-md-4 col-sm-6 mb-30">
                        <div class="contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <h5 class="mt-2">@lang('Visit Us')</h5>
                            <div class="mt-4">
                                <p>{{ __(@$address_content->data_values->address) }}</p>
                            </div>
                        </div><!-- contact-item end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="contact-wrapper">
            <div class="row">
                <div class="col-lg-6 contact-thumb bg_img" style="background-image: url('{{ getImage('assets/images/frontend/contact_us/' . @$contact_content->data_values->image, '1280x848') }}');"></div>
                <div class="col-lg-6 contact-form-wrapper">
                    <h2 class="font-weight-bold">{{ __(@$contact_content->data_values->title) }}</h2>
                    <form class="contact-form mt-4" method="post" action="">
                        @csrf

                        <div class="form-row">
                            <div class="form-group col-lg-6">
                                <input name="name" type="text" placeholder="@lang('Your Name')" class="form-control"
                                       value="{{ auth()->check() ? auth()->user()->fullname : old('name') }}" @if(auth()->user()) readonly @endif required>
                            </div>
                            <div class="form-group col-lg-6">
                                <input name="email" type="text" placeholder="@lang('Enter E-Mail Address')" class="form-control"
                                       value="{{ auth()->check() ? auth()->user()->email : old('email') }}" @if(auth()->user()) readonly @endif required>
                            </div>
                            <div class="form-group col-lg-12">
                                <input name="subject" type="text" placeholder="@lang('Write your subject')" class="form-control"
                                       value="{{old('subject')}}" required>
                            </div>
                            <div class="form-group col-lg-12">
                                <textarea name="message" wrap="off" placeholder="@lang('Write your message')"
                                          class="form-control">{{old('message')}}</textarea>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="cmn-btn">@lang('Send Message')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- contact-wrapper end -->
    </div>
</section>
@endsection
