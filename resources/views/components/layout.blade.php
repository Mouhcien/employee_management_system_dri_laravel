{{-- resources/views/layouts/app.blade.php --}}

    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'HR Management')</title>

    {{-- Vite CSS (must include bootstrap + bootstrap-icons in resources/css/app.css) --}}
    @vite(['resources/css/app.css', 'resources/css/toastr.min.css'])
</head>
<body class="bg-light">

<div class="d-flex min-vh-100">
    {{-- Sidebar --}}
    <aside id="sidebar"
           class="text-white d-flex flex-column flex-shrink-0 p-3 shadow-lg"
           style="width: 250px;
              transition: width .3s, transform .2s ease;
              background: linear-gradient(145deg, #5313e8 0%, #782ef8 25%, #844eff 50%, #a74bff 75%, #c084fc 100%);
              border-right: 1px solid rgba(255,255,255,0.1);
              backdrop-filter: blur(10px);">

        <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom border-white/20">
        <span class="fs-3 fw-bold lh-1 shadow-sm" id="sidebarBrandFull">
            RH-<span class="text-purple-200 drop-shadow-sm">DRI-Marrakech</span>
        </span>
            <span class="fs-3 fw-bold lh-1 d-none drop-shadow-sm" id="sidebarBrandMini">H</span>
        </div>

        {{-- Vertical Nav --}}
        <x-nav />
    </aside>


    {{-- Main area --}}
    <div class="flex-grow-1 d-flex flex-column">
        {{-- Top Header --}}
        <header class="navbar navbar-expand bg-white border-bottom px-3">
            <button id="sidebarToggle" type="button" class="btn btn-outline-secondary me-3">
                <i class="bi bi-list"></i>
            </button>

            <div class="ms-auto d-flex align-items-center gap-3">
                {{-- Notifications --}}
                <button type="button" class="btn btn-link position-relative text-muted p-0">
                    <i class="bi bi-bell fs-5"></i>
                    <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
                </button>

                {{-- User dropdown --}}
                <div class="dropdown">
                    <button class="btn btn-link d-flex align-items-center text-decoration-none dropdown-toggle"
                            type="button" id="userMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'Admin' }}&background=4F46E5&color=fff"
                             class="rounded-circle me-2" width="32" height="32" alt="Avatar">
                        <span class="fw-medium text-dark">{{ Auth::user()->name ?? 'Admin' }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenuButton">
                        <li><a class="dropdown-item" href="#">Profil</a></li>
                        <li><a class="dropdown-item" href="{{ route('settings') }}">Paramètres</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">Déconnexion</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        {{-- Main Content --}}
        <main class="flex-grow-1 overflow-auto p-4 bg-light">
            {{ $slot }}
        </main>
    </div>
</div>

{{-- Vite JS (must import bootstrap JS in resources/js/app.js) --}}
@vite(['resources/js/app.js', 'resources/js/jquery-3.7.1.js', 'resources/js/toastr.min.js'])

{{-- Small script to toggle sidebar width (no Alpine) --}}
<script>

    // Toastr Configuration
    window.addEventListener('load', function() {
        // Configure Toastr
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-bottom-right",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut",
            "preventDuplicates": true,
            "newestOnTop": true
        };

        // Display Session Messages
        @if(Session::has('success'))
        toastr.success("{{ session('success') }}", "Succès");
        @endif

        @if(Session::has('error'))
        toastr.error("{{ session('error') }}", "Erreur");
        @endif

        @if(Session::has('info'))
        toastr.info("{{ session('info') }}", "Information");
        @endif

        @if(Session::has('warning'))
        toastr.warning("{{ session('warning') }}", "Attention");
        @endif
    });


</script>

</body>
</html>
