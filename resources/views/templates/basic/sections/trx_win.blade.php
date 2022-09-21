@php
    $trx_winContent = getContent('trx_win.content',true);
    $latest_winners = \App\Models\GameLog::where('win_status', '!=', 0)->where('win_amo','>','0')->take(6)->with(['user', 'game'])->latest('id')->get();
    $latest_transactions = \App\Models\Transaction::take(7)->with('user')->latest('id')->get();
@endphp
<!-- winner & transaction start -->
<section class="pt-120 pb-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8">
                <div class="section-header text-center">
                    <h2 class="section-title">{{ __($trx_winContent->data_values->heading) }}</h2>
                    <p class="mt-3">{{ __($trx_winContent->data_values->sub_heading) }}</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-4 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.3s">
                <h4 class="mb-4">@lang('Latest Winners')</h4>
                <div class="winner-slider winner-list">
                    @forelse($latest_winners as $winner)
                        <div class="single-slide">
                            <div class="winner-item">
                                <div class="winner-thumb">
                                    <img src="{{ getImage('assets/images/user/profile/'. $winner->user->image,'350x300')}}" alt="image">
                                </div>
                                <div class="winner-content">
                                    <h6 class="name">{{ $winner->user->fullname }}</h6>
                                    <span>{{ __(@$winner->game->name) }}</span>
                                </div>
                                <div class="winner-amount">
                                    <span class="text--base">{{ $general->cur_sym }}{{ getAmount($winner->win_amo) }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                    @endforelse
                </div>
            </div>
            <div class="col-xl-8 mt-xl-0 mt-5 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.5s">
                <h4 class="mb-4">@lang('Latest Transactions')</h4>
                <div class="transaction-wrapper card">
                    <div class="card-body p-0">
                        <div class="table-responsive table-responsive--sm">
                            <table class="table style--two mb-0">
                                <thead>
                                <tr>
                                    <th>@lang('Transaction ID')</th>
                                    <th>@lang('User name')</th>
                                    <th>@lang('Date')</th>
                                    <th>@lang('Amount')</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @forelse($latest_transactions as $transaction)
                                        <tr>
                                            <td data-label="@lang('Transaction ID')"><span>#{{ $transaction->trx }}</span></td>
                                            <td data-label="@lang('User name')">{{ $transaction->user->username }}</td>
                                            <td data-label="@lang('Date')">{{ showDateTime($transaction->created_at) }}</td>
                                            <td data-label="@lang('Amount')"><span class="text--base">{{ $general->cur_sym }}{{ getAmount($transaction->amount) }}</span></td>
                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- winner & transaction end -->
