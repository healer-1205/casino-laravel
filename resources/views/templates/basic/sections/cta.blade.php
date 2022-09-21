@php
    $ctaContent = getContent('cta.content',true);
@endphp
<!-- cta section start -->
<section class="cta-section pt-120 pb-120 bg_img" style="background-image: url( {{ getImage('assets/images/frontend/cta/'.@$ctaContent->data_values->background_image,'1920x780') }} );">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <h2>{{ __($ctaContent->data_values->heading) }}</h2>
                <a href="{{ __($ctaContent->data_values->button_url) }}"
                   class="cmn-btn mt-4">{{ __($ctaContent->data_values->button) }}</a>
            </div>
        </div>
    </div>
</section>
<!-- cta section end -->