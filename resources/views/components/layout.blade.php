<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'HR Management')</title>

    @vite(['resources/css/app.css', 'resources/css/toastr.min.css'])

    <style>
        :root {
            --sidebar-width: 280px;
            --sidebar-mini-width: 85px; /* Ajustez selon vos besoins */
        }

        #sidebar {
            width: var(--sidebar-width);
            position: fixed; /* Garde la barre à gauche */
            height: 100vh;
            transition: width 0.3s ease;
        }

        #main-wrapper {
            /* C'est ici que la magie opère */
            margin-left: var(--sidebar-width);
            transition: margin-left 0.3s ease;
            width: auto;
        }

        /* Quand la sidebar est réduite */
        .sidebar-compressed {
            width: var(--sidebar-mini-width) !important;
        }

        /* On réduit la marge du contenu en même temps */
        .sidebar-compressed + #main-wrapper,
        #sidebar.sidebar-compressed ~ #main-wrapper {
            margin-left: var(--sidebar-mini-width);
        }
    </style>
</head>
<body class="bg-light">

<div class="d-flex">
    {{-- Sidebar --}}
    <aside id="sidebar" class="flex-column shadow-sm bg-white border-end d-flex">
        <div class="d-flex align-items-center justify-content-between p-3 mb-2 border-bottom" style="height: 57px;">
            <span class="fs-5 fw-bold text-dark" id="sidebarBrandFull">
                RH-<span class="text-primary">DRI-Marrakech</span>
            </span>
            <span class="fs-4 fw-bold text-primary d-none" id="sidebarBrandMini">R</span>
        </div>

        <div class="flex-grow-1 overflow-y-auto overflow-x-hidden" >
            <x-nav />
        </div>
    </aside>

    {{-- Main area --}}
    <div id="main-wrapper" class="flex-grow-1">
        <header class="navbar navbar-expand bg-white border-bottom px-4 top-navbar sticky-top">

            {{--}}
            <button id="sidebarToggle" class="btn btn-light shadow-sm rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                <i class="bi bi-list fs-5"></i>
            </button>
            --}}

            <div class="ms-auto d-flex align-items-center gap-4">
                {{-- Notifications & User Dropdown remains the same --}}
                <div class="dropdown">
                    <button class="btn btn-link d-flex align-items-center text-decoration-none dropdown-toggle p-0"
                            type="button" id="userMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'Admin' }}&background=4F46E5&color=fff"
                             class="rounded-circle border border-2 border-primary-subtle" width="38" height="38">
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                        <li><a class="dropdown-item" href="#">Profil</a></li>
                        <li><a class="dropdown-item" href="{{ route('settings.importation') }}">Importation</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger fw-bold">Déconnexion</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <main class="flex-grow-1 p-4">
            {{ $slot }}
        </main>
    </div>
</div>

@vite(['resources/js/jquery-3.7.1.js', 'resources/js/app.js', 'resources/js/toastr.min.js'])

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('sidebar');
        const mainWrapper = document.getElementById('main-wrapper');
        const toggleBtn = document.getElementById('sidebarToggle');

        // Initial State Logic
        const isMiniStored = localStorage.getItem('sidebar-mini') === 'true';

        if (isMiniStored) {
            sidebar.classList.add('sidebar-compressed');
            mainWrapper.style.marginLeft = '85px';
        } else {
            sidebar.classList.remove('sidebar-compressed');
            mainWrapper.style.marginLeft = '280px';
        }

        // Toggle Action
        if(toggleBtn) {
            toggleBtn.addEventListener('click', function () {
                const isNowOpening = sidebar.classList.contains('sidebar-compressed');

                if (isNowOpening) {
                    sidebar.classList.remove('sidebar-compressed');
                    mainWrapper.style.marginLeft = '280px';
                    localStorage.setItem('sidebar-mini', 'false');
                } else {
                    sidebar.classList.add('sidebar-compressed');
                    mainWrapper.style.marginLeft = '85px';
                    localStorage.setItem('sidebar-mini', 'true');
                }
            });
        }

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


    });
</script>
</body>
</html>
