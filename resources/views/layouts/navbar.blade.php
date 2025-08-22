
<nav class="navbar navbar-expand-lg navbar-blak bg-primary shadow-sm fixed-top" >
<div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">
            <i class="fa fa-pen-nib text-primary"></i> منصة تدوين
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="القائمة">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                @guest
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">تسجيل الدخول</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">تسجيل جديد</a></li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('articles.mine') }}">مقالاتي</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('articles.create') }}">كتابة مقالة جديدة</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item" type="submit">تسجيل الخروج</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    
                @endguest
            </ul>
        </div>
    </div>
</nav>

