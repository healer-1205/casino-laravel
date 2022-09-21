@extends($activeTemplate.'layouts.frontend')
@section('content')
<section class="blog-details-section pt-150 pb-150">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="blog-details-wrapper">
                    <div class="post-details-header">
                        <span class="post-card__date text--base">{{ $blog->created_at->format('d M, Y') }}</span>
                        <h3 class="post-title">{{ __(@$blog->data_values->title) }}</h3>
                    </div>
                    <div class="post-details-thumb"><img class="w-100" src="{{ getImage('assets/images/frontend/blog/' . @$blog->data_values->blog_image, '670x375') }}" alt="image"></div>
                    <div class="blog-details-content">
                        @php echo $blog->data_values->description_nic @endphp
                    </div>
                </div>
                @if(\App\Models\Extension::where('act', 'fb-comment')->where('status',1)->first())
                    <div class="comment-form-area">
                        <h3 class="title">@lang('Write a Comment')</h3>

                        <div class="fb-comments" data-href="{{ route('blog.details',[$blog->id,slug($blog->data_values->title)]) }}" data-numposts="5"></div>

                    </div>
                @endif
            </div>
            <div class="col-lg-4">
                <aside class="sidebar">
                    <div class="widget">
                        <h5 class="widget-title">@lang('Latest Blog')</h5>
                        <ul class="small-post-list">
                            @forelse($latestBlogs as $item)
                                <li class="small-post">
                                    <div class="small-post__thumb"><img
                                            src="{{ getImage('assets/images/frontend/blog/thumb_' . @$item->data_values->blog_image, '75x42') }}"
                                            alt="image">
                                    </div>
                                    <div class="small-post__content">
                                        <h6>
                                            <a href="{{ route('blog.details', [$item->id, @slug($item->data_values->title)]) }}">{{ __(@$item->data_values->title) }}</a>
                                        </h6>
                                        <a href="{{ route('blog.details', [$item->id, @slug($item->data_values->title)]) }}"
                                           class="date">{{ @showDateTime($item->created_at) }}</a>
                                    </div>
                                </li>
                                <!-- small-post end -->
                            @empty
                            @endforelse
                        </ul>
                    </div>
                    <div class="widget">
                        <h5 class="widget-title">@lang('Most Views')</h5>
                        <ul class="small-post-list">
                            @forelse($mostViews as $item)
                                <li class="small-post">
                                    <div class="small-post__thumb"><img
                                            src="{{ getImage('assets/images/frontend/blog/thumb_' . @$item->data_values->blog_image, '75x42') }}"
                                            alt="image">
                                    </div>
                                    <div class="small-post__content">
                                        <h6>
                                            <a href="{{ route('blog.details', [$item->id, @slug($item->data_values->title)]) }}">{{ __(@$item->data_values->title) }}</a>
                                        </h6>
                                        <a href="{{ route('blog.details', [$item->id, @slug($item->data_values->title)]) }}"
                                           class="date">{{ @showDateTime($item->created_at) }}</a>
                                    </div>
                                </li>
                                <!-- small-post end -->
                            @empty
                            @endforelse
                        </ul>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</section>
@endsection

@push('fbComment')
	@php echo loadFbComment() @endphp
@endpush
