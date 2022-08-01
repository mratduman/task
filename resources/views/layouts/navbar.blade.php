<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Murat Duman</a>
        </div>
        <ul class="nav navbar-nav">
            <li class="active"><a href="{{route('home')}}">Anasayfa</a></li>
            @if(\App\Models\User::query()->scopes('CurrentUser')->admin)
            <li><a href="{{route('admin')}}">Admin Paneli</a></li>
            @endif
            <li><a href="{{route('logout')}}">Çıkış</a></li>
        </ul>
    </div>
</nav>
