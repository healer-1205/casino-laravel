@php
    $gameContent = getContent('game.content',true);
    $games = \App\Models\Game::where('status',1)->get(['image','name','id','max_limit','min_limit','win','invest_back','alias']);
@endphp
<!-- game section start -->
<section class="pt-120 pb-120 section--bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section-header text-center">
                    <h2 class="section-title">{{ __($gameContent->data_values->heading) }}</h2>
                    <p class="mt-3">{{ __($gameContent->data_values->sub_heading) }}</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mb-none-30">
            @forelse($games as $game)
                <div class="col-xl-3 col-lg-4 col-sm-6 mb-30 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.3s">
                    <div class="game-card">
                        <div class="game-card__thumb">
                            <img src="{{ getImage(imagePath()['game']['path'].'/'.$game->image,imagePath()['game']['size']) }}" alt="image">
                        </div>
                        <div class="game-card__content">
                            <h4 class="game-name">{{ __($game->name) }}</h4>
                            <a href="{{ route('user.play.'.$game->alias) }}" class="cmn-btn d-block text-center btn-sm mt-3 btn--capsule">@lang('Play Now')</a>
                        </div>
                    </div>
                    <!-- game-card end -->
                </div>
            @empty
                @lang('No Data Found!')
            @endforelse
        </div>
    </div>
</section>
<!-- game section end -->
