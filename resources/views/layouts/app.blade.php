<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">


@include('layouts.head')
<body class="app">
<div id='loader'>
    <div class="spinner"></div>
</div>

<script>
    window.addEventListener('load', function load() {
        const loader = document.getElementById('loader');
        setTimeout(function () {
            loader.classList.add('fadeOut');
        }, 300);
    });
</script>

<div id="app">

    @include('layouts.sidebar')

    <div class="page-container">
        @include('layouts.navbar')

        <main class='main-content bgc-grey-100'>
            <div id='mainContent'>
                <router-view></router-view>
            </div>
        </main>

        <footer class="bdT ta-c p-30 lh-0 fsz-sm c-grey-600">
            <span>Copyright © {{ now()->year }} Designed by. All rights reserved.</span>
        </footer>
    </div>
</div>

<script>window.baseUrl = '{{env('APP_URL')}}'</script>


<script src="{{ asset('js/app.js') }}" defer></script>
<script src="{{ asset('js/adminator.js') }}" defer></script>
</body>
</html>
