@php
    $chooseContent = getContent('choose_us.content',true);
    $chooseElements = getContent('choose_us.element');
@endphp
<!-- why choose section start -->
<section class="pt-120 pb-120 dark--overlay bg_img border-top border-bottom" style="background-image: url( {{ getImage('assets/images/frontend/choose_us/'.@$chooseContent->data_values->image,'1920x1080') }} );">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section-header text-center">
                    <h2 class="section-title">{{ __($chooseContent->data_values->heading) }}</h2>
                    <p class="mt-3">{{ __($chooseContent->data_values->sub_heading) }}</p>
                </div>
            </div>
        </div>
        <div class="row mb-none-30">
            @foreach($chooseElements as $chooseElement)
                <div class="col-lg-4 col-md-6 mb-30 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.3s">
                    <div class="choose-card">
                        <div class="choose-card__icon">
                            @php echo $chooseElement->data_values->icon @endphp
                        </div>
                        <div class="choose-card__content">
                            <h3 class="title mb-3">{{ __($chooseElement->data_values->title) }}</h3>
                            <p>{{ $chooseElement->data_values->description }}</p>
                        </div>
                    </div>
                    <!-- choose-card end -->
                </div>
            @endforeach
        </div>
    </div>
</section>
<!-- why choose section end -->
