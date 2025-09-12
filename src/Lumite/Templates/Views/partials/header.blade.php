<nav class="navbar navbar-expand-md navbar-dark navbar-custom">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{url('/')}}">
            {{config('app.name', 'Larite')}}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">
                <li class="nav-item active">
                    <a class="nav-link" href="{{url('/home')}}">Home</a>
                </li>
            </ul>
            @if (!auth()->check())
            <ul class="navbar-nav ms-auto mb-2 mb-md-0">
                <li class="nav-item"><a href="{{url('/register')}}" class="btn btn-signup nav-btn-mobile"><i class="fa fa-user-plus"></i> Sign Up</a></li>
                <li class="nav-item"><a href="{{url('/login')}}" class="btn btn-signin nav-btn-mobile"><i class="fa fa-sign-in"></i> Sign In</a></li>
            </ul>
            @else
            <ul class="navbar-nav ms-auto mb-2 mb-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center"
                       href="#"
                       id="userDropdown"
                       role="button"
                       data-bs-toggle="dropdown"
                       aria-expanded="false"
                       tabindex="0">
                        <i class="fa fa-user-circle-o me-2" style="font-size: 1.3rem;"></i>
                       {!! auth()->user()->name ?? 'Admin' !!}
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{url('/logout')}}">Logout</a></li>
                    </ul>
                </li>
            </ul>
            @endif
        </div>
    </div>
</nav>

<script>
    $(function () {
        $('#userDropdown').on('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ' || e.key === 'Spacebar') {
                e.preventDefault();
                $(this).click();
            }
        });
    });
</script>