<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'HR Management')</title>

    @vite(['resources/css/app.css', 'resources/css/toastr.min.css'])

    <style>
        :root { --sidebar-width: 280px; --sidebar-collapsed-width: 80px; }

        .transition-base { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }

        #sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            z-index: 1000;
        }

        /* État Réduit (Collapsed) */
        .sidebar-collapsed { width: var(--sidebar-collapsed-width) !important; }

        .sidebar-collapsed .sidebar-text,
        .sidebar-collapsed .sidebar-section-title,
        .sidebar-collapsed .bi-chevron-down {
            display: none !important;
        }

        .sidebar-collapsed .sidebar-link,
        .sidebar-collapsed .sidebar-toggle {
            justify-content: center !important;
            padding: 10px 0 !important;
        }

        .sidebar-collapsed .nav-item i,
        .sidebar-collapsed .sidebar-link i {
            margin-right: 0 !important;
            font-size: 1.4rem;
        }

        /* Styles standards */
        .sidebar-section-title { font-size: 0.65rem; font-weight: 800; letter-spacing: 0.1em; text-transform: uppercase; color: #adb5bd; }
        .sidebar-link, .sidebar-toggle { color: #4b5563; text-decoration: none; font-size: 0.9rem; white-space: nowrap; border: none; background: none; }
        .sidebar-link:hover, .sidebar-toggle:hover { background-color: #f8fafc; color: #4f46e5; }
        .sidebar-link.active { background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); color: #ffffff !important; }
        .bg-primary-subtle { background-color: #eef2ff !important; }
    </style>

</head>
<body class="bg-light">

@if (session()->has('configs'))
    @php
        $configs = session()->get('configs');
        $navigation = "Vertical";
        if (count($configs) != 0)
            $navigation = $configs[0]->value;
    @endphp
@endif

@if ($navigation == 'Horizontal')
    <x-horz-nav />
@endif

<div @if ($navigation == 'Vertical') id="main-wrapper" @endif class="d-flex min-vh-100 w-100 p-0 m-0 overflow-hidden">

    {{-- Sidebar --}}
    @if ($navigation == 'Vertical')
        <x-nav />
    @endif

    {{-- 2. Bloc de droite (Header + Contenu) --}}
    <div class="flex-grow-1 d-flex flex-column transition-base shadow-sm" style="min-width: 0;">

        {{-- Navbar du haut --}}
        @if ($navigation == 'Vertical')
            <header class="navbar navbar-expand bg-white border-bottom px-4 top-navbar sticky-top">
                <div class="row col-12">
                    <div class="col-8">
                        <x-search />
                    </div>
                    <div class="col-2">
                        <div class="d-flex align-items-center ms-3 border-start ps-3 py-1">
                            {{-- On empile le texte verticalement --}}
                            <div class="d-flex flex-column text-start">
                                <span class="fw-bold text-dark lh-1 mb-1" style="font-size: 0.9rem;">
                                    {{ session('employee_name') }}
                                </span>
                                <span class="text-muted fw-medium extra-small text-uppercase ls-1" style="font-size: 0.7rem;">
                                    {{ auth()->user()->profile->title }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <x-profil />
                    </div>
                </div>
            </header>
        @endif

        {{-- Zone de contenu dynamique --}}
        <main id="main-container" class="p-4 bg-light flex-grow-1">
            {{ $slot }}
        </main>

    </div>

    {{-- Loader Global --}}
    <div id="global-loader" style="display: none; position: fixed; inset: 0; background: rgba(255,255,255,0.7); z-index: 9999; justify-content: center; align-items: center;">
        <div class="spinner"></div>
    </div>

</div>

@vite(['resources/js/jquery-3.7.1.js', 'resources/js/app.js', 'resources/js/toastr.min.js', 'resources/js/script.js', 'resources/js/chart.js', 'resources/js/tom-select.complete.min.js'])

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const loader = document.getElementById('global-loader');

        const showLoader = () => {
            loader.style.display = 'flex';
        };

        // 1. All Form Submissions
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', showLoader);
        });

        // 2. All Links (except external or hash links)
        document.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', function(e) {
                // Only show loader if it's a normal internal navigation
                if (
                    link.href &&
                    link.getAttribute('target') !== '_blank' &&
                    !link.href.includes('#') &&
                    link.origin === window.location.origin
                ) {
                    showLoader();
                }
            });
        });

        // 3. Custom Buttons (like "Refresh" or specific actions)
        document.querySelectorAll('.trigger-loader').forEach(btn => {
            btn.addEventListener('click', showLoader);
        });

        // 4. Hide loader if the user hits the "Back" button
        window.onpageshow = function(event) {
            if (event.persisted) {
                document.getElementById('global-loader').style.display = 'none';
            }
        };

        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('sidebarToggle');
        const toggleIcon = document.getElementById('toggleIcon');

        // Optionnel : Gérer le contenu principal pour qu'il s'adapte
        const mainContent = document.querySelector('main');

        toggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('sidebar-collapsed');

            // Changement d'icône
            if (sidebar.classList.contains('sidebar-collapsed')) {
                toggleIcon.classList.replace('bi-chevron-left', 'bi-chevron-right');
            } else {
                toggleIcon.classList.replace('bi-chevron-right', 'bi-chevron-left');
            }
        });

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

        //Global Search

        const searchInput = document.getElementById('mainSearch');
        const resultBox = document.getElementById('box_result_search');
        const resultContent = document.getElementById('searchContent');

        function debounce(func, timeout = 300) {
            let timer;
            return (...args) => {
                clearTimeout(timer);
                timer = setTimeout(() => { func.apply(this, args); }, timeout);
            };
        }

        async function performSearch(query) {
            // Trim whitespace to prevent empty searches
            const cleanQuery = query.trim();

            if (cleanQuery.length < 2) {
                resultBox.classList.add('d-none');
                return;
            }

            try {
                const response = await fetch(`/search/?q=${encodeURIComponent(cleanQuery)}`);
                if (!response.ok) throw new Error('Network response error');

                const data = await response.json();

                // Reveal the box before rendering
                resultBox.classList.remove('d-none');
                renderCategorizedResults(data);
            } catch (error) {
                console.error("Erreur:", error);
                resultContent.innerHTML = '<div class="p-3 text-danger small">Erreur de connexion.</div>';
                resultBox.classList.remove('d-none');
            }
        }

        const processChange = debounce((e) => performSearch(e.target.value));
        searchInput.addEventListener('input', processChange);

        function renderCategorizedResults(matches) {
            if (matches.length === 0) {
                resultContent.innerHTML = '<div class="p-3 text-muted text-center">Aucun résultat trouvé.</div>';
                return;
            }

            const grouped = matches.reduce((acc, obj) => {
                const key = obj.display_category || 'Autres';
                if (!acc[key]) acc[key] = [];
                acc[key].push(obj);
                return acc;
            }, {});

            let html = '';

            for (const category in grouped) {
                const categoryItems = grouped[category];
                html += `
            <div class="row w-100 py-2 m-0 align-items-start">
                <div class="col-4 fw-bold text-secondary text-uppercase" style="font-size: 0.75rem;">
                    ${category} <span class="badge bg-info ms-1">${categoryItems.length}</span>
                </div>
                <div class="col-8">
                    ${categoryItems.map(item => {
                    // Secure the JSON string for the onclick attribute
                    const safeData = JSON.stringify(item).replace(/"/g, '&quot;');
                    return `
                            <div class="search-result-item mb-2 p-2 rounded"
                                 style="cursor:pointer;"
                                 onclick="handleSelect(${safeData})">
                                <div class="fw-bold text-dark" style="font-size: 0.9rem;">
                                <a href="${item.url}" >${item.display_name}</a>
                                </div>
                                <div class="text-muted" style="font-size: 0.8rem;">${item.display_info}</div>
                            </div>`;
                }).join('')}
                </div>
            </div>
            <hr class="my-1 text-secondary opacity-25">
        `;
            }

            resultContent.innerHTML = html;
        }

        // NEW: Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!resultBox.contains(e.target) && e.target !== searchInput) {
                resultBox.classList.add('d-none');
            }
        });

        function handleSelect(fullData) {
            console.log("Full Object:", fullData);
            // Logic: e.g., window.location.href = `/profile/${fullData.id}`;
        }

    });
</script>
</body>
</html>
