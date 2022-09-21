@extends($activeTemplate.'layouts.frontend')
@section('content')
    <section class="terms-section pt-150 pb-150">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="terms-wrapper">
                        @php echo @$extra->data_values->content @endphp
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
