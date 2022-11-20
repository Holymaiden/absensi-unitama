<nav class="navbar navbar-expand-lg main-navbar" style="left:15px">
    <form class="form-inline mr-auto">
        <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="{{ url('public/public/uploads/karyawan') }}/{{auth()->user()->image}}" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block">Hi, {{ auth()->user()->nik }}</div>
        </a>
    </form>
    <ul class="navbar-nav navbar-right">
        <a href="{{ route('logout') }}" class="btn btn-danger text-white mr-2">
            <i class="fas fa-sign-out-alt" style="color:white"></i>
        </a>
    </ul>
</nav>