@php
    $blogContent = getContent('blog.content',true);
    if (request()->route()->getName() == 'home'){
        $blogElements = getContent('blog.element',false,3);
    } else {
        $blogElements = \App\Models\Frontend::where('data_keys', 'blog.element')->latest('id')->paginate(getPaginate());
    }
@endphp
<!-- blog section start -->
<section class="pb-120 {{ request()->route()->getName() != 'home' ? 'pt-120':'' }}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section-header text-center">
                    <h2 class="section-title">{{ __($blogContent->data_values->heading) }}</h2>
                    <p class="mt-3">{{ __($blogContent->data_values->sub_heading) }}</p>
                </div>
            </div>
        </div>
        <div class="row mb-none-30 justify-content-center">
            @foreach($blogElements as $blogElement)
                <div class="col-lg-4 col-md-6 mb-30 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.3s">
                    <div class="post-card">
                        <div class="post-card__thumb">
                            <img
                                src="{{ getImage('assets/images/frontend/blog/'.@$blogElement->data_values->blog_image,'670x375') }}"
                                alt="image">
                                <span class="post-card__date">{{ $blogElement->created_at->format('d M, Y') }}</span>
                        </div>
                        <div class="post-card__content">
                            <h3 class="post-card__title mt-2 mb-3"><a
                                    href="{{ route('blog.details',[$blogElement->id,slug($blogElement->data_values->title)]) }}">{{ __($blogElement->data_values->title) }}</a>
                            </h3>
                            <!-- <p>{{ __($blogElement->data_values->preview_text) }}</p> -->
                            <a href="{{ route('blog.details',[$blogElement->id,slug($blogElement->data_values->title)]) }}"
                               class="cmn-btn btn-sm mt-3">@lang('Read More')</a>
                        </div>
                    </div>
                    <!-- post-card end -->
                </div>
            @endforeach
        </div>

        @if(request()->route()->getName() != 'home')
            {{ $blogElements->links() }}
        @endif
    </div>
</section>
<!-- blog section end -->
