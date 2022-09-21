@php
    $testimonialContent = getContent('testimonial.content',true);
    $testimonialElements = getContent('testimonial.element');
@endphp
<!-- testimonial section start -->
<section class="pt-120 pb-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section-header text-center">
                    <h2 class="section-title style--two">{{ __($testimonialContent->data_values->heading) }}</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="testimonial-slider">
                    @foreach($testimonialElements as $testimonialElement)
                        <div class="single-slide">
                            <div class="testimonial-card">
                                <div class="testimonial-card__content">
                                    <div class="testimonial-card__content-inner">
                                        <p>{{ __($testimonialElement->data_values->quote) }}</p>
                                    </div>
                                </div>
                                <div class="testimonial-card__thumb">
                                    <img
                                        src="{{ getImage('assets/images/frontend/testimonial/'.@$testimonialElement->data_values->person_image,'100x100') }}"
                                        alt="image">
                                </div>
                                <h6 class="name mt-2">{{ __($testimonialElement->data_values->name) }}</h6>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- testimonial-slider end -->
            </div>
        </div>
    </div>
</section>
<!-- testimonial section end -->
