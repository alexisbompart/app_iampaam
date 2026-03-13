<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #f1f8e9 0%, #e8f5e8 100%);
            color: #2e7d32;
            border-right: 2px solid #c8e6c9;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
        }
        .sidebar .navbar-brand {
            color: #2e7d32 !important;
            font-weight: 600;
            border-bottom: 1px solid #c8e6c9;
            padding-bottom: 1rem;
            margin-bottom: 1rem;
        }
        .sidebar .nav-link {
            color: #558b2f !important;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin: 0.25rem 0.5rem;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        .sidebar .nav-link:hover {
            color: #2e7d32 !important;
            background-color: rgba(76, 175, 80, 0.1) !important;
            transform: translateX(5px);
        }
        .sidebar .nav-link.active {
            color: white !important;
            background: linear-gradient(135deg, #4caf50, #66bb6a) !important;
            box-shadow: 0 2px 8px rgba(76, 175, 80, 0.3);
        }
        .sidebar .nav-link i {
            width: 20px;
            margin-right: 10px;
            text-align: center;
        }
        .sidebar .menu-section h6 {
            color: #4caf50 !important;
            text-transform: uppercase;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 0.5rem 1rem 0.25rem;
            margin-bottom: 0.5rem;
            letter-spacing: 0.5px;
        }
        .sidebar .border-top {
            border-color: #c8e6c9 !important;
        }
        .sidebar .btn-outline-danger {
            border-color: #f44336;
            color: #f44336;
            background-color: transparent;
            transition: all 0.3s ease;
        }
        .sidebar .btn-outline-danger:hover {
            background-color: #f44336;
            border-color: #f44336;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(244, 67, 54, 0.3);
        }
        .sidebar .user-info {
            background: rgba(76, 175, 80, 0.05);
            border-radius: 8px;
            padding: 1rem;
            margin: 1rem;
        }
        .sidebar .user-info .user-name {
            font-weight: 600;
            color: #2e7d32;
        }
        .sidebar .user-info .user-role {
            color: #558b2f;
            font-size: 0.85rem;
        }
    .authenticated .main-content {
            margin-left: 250px;
        }
        .menu-section {
            border-bottom: 1px solid #c8e6c9;
            padding: 0.5rem 0;
        }
    </style>
</head>
<body class="antialiased @auth authenticated @endauth">
    @auth
    <!-- Sidebar -->
    <nav class="sidebar position-fixed d-flex flex-column" style="width: 250px;">
        <div class="navbar-brand d-flex align-items-center px-3 py-3">
            <img src="{{ asset('image/logo.png') }}" alt="Logo IAMPAM" width="36" height="36" class="me-2" style="filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));">
            <span style="font-size: 1.1rem; font-weight: 700;">IAMPAM</span>
        </div>

        <div class="flex-grow-1">
            <!-- Dashboard - Todos los roles -->
            <div class="menu-section">
                <h6>Principal</h6>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Gestión de Beneficiarios - Admin, Operador, Consultor -->
            @if(in_array(Auth::user()->role, ['admin', 'operador', 'consultor']))
            <div class="menu-section">
                <h6>Beneficiarios</h6>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('beneficiarios.index') ? 'active' : '' }}" href="{{ route('beneficiarios.index') }}">
                            <i class="fas fa-users me-2"></i>Ver Beneficiarios
                        </a>
                    </li>
                    @if(in_array(Auth::user()->role, ['admin', 'operador']))
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('beneficiarios.create') ? 'active' : '' }}" href="{{ route('beneficiarios.create') }}">
                            <i class="fas fa-user-plus me-2"></i>Crear Beneficiario
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
            @endif

            <!-- Gestión de Productos - Admin, Operador -->
            @if(in_array(Auth::user()->role, ['admin', 'operador']))
            <div class="menu-section">
                <h6>Productos</h6>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('productos.index') ? 'active' : '' }}" href="{{ route('productos.index') }}">
                            <i class="fas fa-boxes me-2"></i>Ver Productos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('productos.create') ? 'active' : '' }}" href="{{ route('productos.create') }}">
                            <i class="fas fa-box-open me-2"></i>Crear Producto
                        </a>
                    </li>
                </ul>
            </div>
            @endif

            <!-- Gestión de Órdenes - Admin, Operador -->
            @if(in_array(Auth::user()->role, ['admin', 'operador']))
            <div class="menu-section">
                <h6>Órdenes</h6>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('ordenes.index') ? 'active' : '' }}" href="{{ route('ordenes.index') }}">
                            <i class="fas fa-clipboard-list me-2"></i>Ver Órdenes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('ordenes.create', 'entrada') }}">
                            <i class="fas fa-arrow-down me-2"></i>Orden de Entrada
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('ordenes.create', 'entrega') }}">
                            <i class="fas fa-arrow-up me-2"></i>Orden de Entrega
                        </a>
                    </li>
                </ul>
            </div>
            @endif

            <!-- Gestión de Usuarios - Solo Admin -->
            @if(Auth::user()->role == 'admin')
            <div class="menu-section">
                <h6>Administración</h6>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}" href="{{ route('users.index') }}">
                            <i class="fas fa-user-shield me-2"></i>Gestionar Usuarios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('users.create') ? 'active' : '' }}" href="{{ route('users.create') }}">
                            <i class="fas fa-user-plus me-2"></i>Crear Usuario
                        </a>
                    </li>
                </ul>
            </div>
            @endif
        </div>

        <!-- Usuario y Logout -->
        <div class="mt-auto border-top pt-3">
            <div class="user-info">
                <div class="d-flex align-items-center mb-3">
                    <i class="fas fa-user-circle me-2" style="color: #4caf50; font-size: 1.2rem;"></i>
                    <div>
                        <div class="user-name">{{ Auth::user()->name }}</div>
                        <div class="user-role">{{ ucfirst(Auth::user()->role) }}</div>
                    </div>
                </div>
                <a class="btn btn-outline-danger btn-sm w-100" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
                </a>
            </div>
        </div>
    </nav>
    @endauth

    <!-- Top Navbar (solo para móviles) -->
    @auth
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark d-md-none">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <img src="{{ asset('image/logo.png') }}" alt="Logo" width="32" height="32" class="me-2">
                IAMPAM
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    @if(in_array(Auth::user()->role, ['admin', 'operador', 'consultor']))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('beneficiarios.index') }}">Beneficiarios</a>
                        </li>
                    @endif
                    @if(in_array(Auth::user()->role, ['admin', 'operador']))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('productos.index') }}">Productos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('ordenes.index') }}">Órdenes</a>
                        </li>
                    @endif
                    @if(Auth::user()->role == 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('users.index') }}">Usuarios</a>
                        </li>
                    @endif
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    @endauth

    <main class="main-content py-4">
        @yield('content')
    </main>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</body>
</html>
