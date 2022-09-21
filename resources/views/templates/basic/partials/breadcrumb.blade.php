<!-- inner-hero section start -->
    <section class="inner-hero bg_img" style="background-image: url( {{ getImage('assets/images/frontend/breadcrumb/'.@getContent('breadcrumb.content',true)->data_values->breadcrumb_image,'1920x1080') }} );">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 text-center">
            <h2 class="page-title">{{ __($pageTitle) }}</h2>
            <ul class="page-list justify-content-center">
              <li><a href="{{ route('home') }}">@lang('Home')</a></li>
              <li>{{ __($pageTitle) }}</li>
            </ul>
          </div>
        </div>
      </div>
    </section>
    <!-- inner-hero section end -->
