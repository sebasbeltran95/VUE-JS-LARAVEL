<!DOCTYPE html>
<html lang="es">
@include('layouts.comun.header')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

<body>
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="{{ route('home') }}"> <img class="img-fluid img-roundered" width="50%" src="{{ asset('img/logo.webp') }}" alt="logo"></a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </header>
    <div id="app" class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-body-tertiary sidebar collapse">
                <div class="position-sticky pt-3 sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if (Request::is('vistaCliente')) active @endif"
                                href="{{ route('vistaCliente') }}">
                                <i class="fas fa-user-tie"></i>
                                Clientes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if (Request::is('vistaProducto')) active @endif"
                                href="{{ route('vistaProducto') }}">
                                <i class="fas fa-box"></i>
                                Productos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if (Request::is('vistaVenta')) active @endif"
                                href="{{ route('vistaVenta') }}">
                                <i class="fas fa-truck-loading"></i>
                                Ventas
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user"></i> usuarios
                            </a>
                            <ul class="dropdown-menu w-100">
                                @if (Auth()->user()->rol == 'Admon')
                                    <li><a class="dropdown-item" href="{{ route('vistaUser') }}"><i class="fas fa-users"></i>Crear Usuarios</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                @endif
                                <li class="text-center">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="btn btn-danger w-100" type="submit">Salir</button>
                                </form>
                              </li> 
                            </ul>
                          </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                @yield('content')
            </main>
        </div>
    </div>

    @include('layouts.comun.footer')
    {{--  @stack('js')  --}}
</body>

</html>
