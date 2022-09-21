@php
    $referralContent = getContent('referral.content',true);
@endphp
<!-- referral section start -->
<section class="pt-120">
    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-lg-5 wow fadeInLeft" data-wow-duration="0.5s" data-wow-delay="0.3s">
                <div class="referral-thumb">
                    <img
                        src="{{ asset(getImage('assets/images/frontend/referral/'.@$referralContent->data_values->image,'487x388')) }}"
                        alt="image">
                </div>
            </div>
            <div class="col-lg-6 mt-lg-0 mt-5 wow fadeInRight" data-wow-duration="0.5s" data-wow-delay="0.5s">
                <div class="referral-content">
                    <h2 class="mb-3">{{ __($referralContent->data_values->heading) }}</h2>
                    <p>@php echo $referralContent->data_values->description @endphp</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- referral section end -->
