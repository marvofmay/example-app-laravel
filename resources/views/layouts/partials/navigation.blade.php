<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('home_index') }}">home</a>        
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('category_list') }}">lista kategorii ({{count(\App\Models\Category::all())}})</a>        
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('product_list') }}">lista produktów ({{count(\App\Models\Product::all())}})</a>        
        </li>
        @guest
        <li class="nav-item">
            <a class="nav-link" href="{{ route('display_contact_form') }}">kontakt</a>        
        </li>        
        @endguest                
        @auth
            @role('admin')
            <li class="nav-item"><a href="{{ route('users.index') }}" class="nav-link">użytkownicy</a></li>
            <li class="nav-item"><a href="{{ route('roles.index') }}" class="nav-link">role</a></li>
            <li class="nav-item"><a href="{{ route('contact_list') }}" class="nav-link">wiadomości</a></li>
            @endrole
          <li><a href="{{ route('posts.index') }}" class="nav-link px-2 text-white">Posts</a></li>
        @endauth        
        <!--
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>
        -->
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>

      @auth        
        <div class="text-end">
          <span class="info-box-text">{{auth()->user()->username}}</span>
          <a href="{{ route('logout.perform') }}" class="btn btn-danger">Logout</a>
        </div>
      @endauth
      @guest
        <div class="text-end">
          <a href="{{ route('login.perform') }}" class="btn btn-warning">Login</a>
          <a href="{{ route('register.perform') }}" class="btn btn-warning">Sign-up</a>
        </div>
      @endguest
        
    </div>
  </div>
</nav>