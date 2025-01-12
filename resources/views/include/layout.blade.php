@php
    $targetDate = env('TARGET');
    $currentDate = now()->format('Y-m-d');
@endphp
<!DOCTYPE html>
<html lang="en">

@include('include.meta')

<body>
    @if ($currentDate < $targetDate)
        <div class="wrapper">
            @include('include.sidebar')

            <div class="main-panel">
                @include('include.topnav')

                <div class="container">
                    <div class="page-inner">
                        @yield('content')
                    </div>
                </div>

                @include('include.footer')
            </div>

        </div>
    @else
        <section class="p-3 p-md-4 p-xl-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="rounded col-12 col-md-8 bsb-tpl-bg-lotion d-flex justify-content-center">
                        <div class="p-3 p-md-4 p-xl-5 w-100" style="max-width: 500px;">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-5">
                                        <h2 class="h3">Masuk</h2>
                                        <h3 class="m-0 fs-6 fw-normal text-secondary">Maaf, masa trial telah berakhir.
                                            Silakan
                                            hubungi admin untuk informasi lebih lanjut.</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    @include('include.script')
    <script src="{{ asset('assets/js/script.js') }}"></script>
    @stack('script')
</body>

</html>
