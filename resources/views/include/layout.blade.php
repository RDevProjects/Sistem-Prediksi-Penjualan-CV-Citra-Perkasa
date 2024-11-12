<!DOCTYPE html>
<html lang="en">

@include('include.meta')

<body>
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
    @include('include.script')
    <script src="{{ asset('assets/js/script.js') }}"></script>
    @yield('script')
</body>

</html>
