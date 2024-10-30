<header class="page">
    <div class="page_main container-fluid">
        <div class="container">
            <h1 class="page_header">@yield('title')</h1>
            <p class="page_text">@yield('sub')</p>
        </div>
    </div>
    <div class="container">
        <ul class="page_breadcrumbs d-flex flex-wrap">
            <li class="page_breadcrumbs-item">
                <a class="link" href="{{ route('home') }}">Home</a>
            </li>

            <li class="page_breadcrumbs-item current">
                <span>@yield('title')</span>
            </li>

            <li class="page_breadcrumbs-item current">
                <span>@yield('child-title')</span>
            </li>
        </ul>
    </div>
</header>
