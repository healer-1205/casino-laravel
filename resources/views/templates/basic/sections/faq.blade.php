@php
    $faqContent = getContent('faq.content',true);
    $faqElements = getContent('faq.element');
@endphp
<!-- faq section start -->
<section class="pt-120 pb-120">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-6">
                <div class="section-header text-center">
                    <h2 class="section-title">{{ __($faqContent->data_values->heading) }}</h2>
                    <p class="mt-3">{{ __($faqContent->data_values->sub_heading) }}</p>
                </div>
            </div>
            <div class="col-lg-12 order-lg-1 order-2">
                <div class="faq-content">
                    <div class="accordion cmn-accordion" id="faqAccordion-two">
                        <div class="row mb-none-30">
                            <div class="col-lg-6 mb-30">
                                @foreach($faqElements as $faqElement)
                                    @if($loop->odd)
                                        <div class="card">
                                            <div class="card-header" id="h-{{ $loop->iteration }}">
                                                <button class="acc-btn collapsed" type="button" data-toggle="collapse"
                                                        data-target="#c-{{ $loop->iteration }}" aria-expanded="false"
                                                        aria-controls="c-{{ $loop->iteration }}">
                                                    <span
                                                        class="text">{{ __($faqElement->data_values->question) }}</span>
                                                    <span class="plus-icon"></span>
                                                </button>
                                            </div>
                                            <div id="c-{{ $loop->iteration }}" class="collapse"
                                                 aria-labelledby="h-{{ $loop->iteration }}"
                                                 data-parent="#faqAccordion-two">
                                                <div class="card-body">
                                                    <p>{{ __($faqElement->data_values->answer) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <div class="col-lg-6 mb-30">
                                @foreach($faqElements as $faqElement)
                                    @if($loop->even)
                                        <div class="card">
                                            <div class="card-header" id="h-{{ $loop->iteration }}">
                                                <button class="acc-btn collapsed" type="button" data-toggle="collapse"
                                                        data-target="#c-{{ $loop->iteration }}" aria-expanded="false"
                                                        aria-controls="c-{{ $loop->iteration }}">
                                                    <span
                                                        class="text">{{ __($faqElement->data_values->question) }}</span>
                                                    <span class="plus-icon"></span>
                                                </button>
                                            </div>
                                            <div id="c-{{ $loop->iteration }}" class="collapse"
                                                 aria-labelledby="h-{{ $loop->iteration }}"
                                                 data-parent="#faqAccordion-two">
                                                <div class="card-body">
                                                    <p>{{ __($faqElement->data_values->answer) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- faq section end -->
