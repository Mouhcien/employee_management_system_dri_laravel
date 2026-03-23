<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'HR Management')</title>

    @vite(['resources/css/app.css', 'resources/css/toastr.min.css'])

</head>
<body class="bg-light">

@if (session()->has('configs'))
    @php
        $configs = session()->get('configs');
    @endphp
@endif

@if ($configs[0]->value == 'Horizontal')
    <x-horz-nav />
@endif

{{-- Sidebar --}}
@if ($configs[0]->value == 'Vertical')
    <aside id="sidebar0" class="flex-column shadow-sm bg-white border-end container-fluid">
        <div class="container-fluid align-items-center justify-content-between p-3 mb-2 border-bottom" style="height: 57px;">
            <span class="fs-5 fw-bold text-dark" id="sidebarBrandFull">
               RH APP
            </span>
        </div>

        <div class="flex-grow-1 overflow-y-auto overflow-x-hidden" >
            <x-nav />
        </div>

    </aside>
@endif

{{-- Main area --}}

{{-- The outer container-fluid needs to be a flex column --}}
<div @if ($configs[0]->value == 'Vertical') id="main-wrapper" @endif class="container-fluid">

    @if ($configs[0]->value == 'Vertical')
        <header class="navbar navbar-expand bg-white border-bottom px-4 top-navbar sticky-top">
            <x-search />
            <x-profil />
        </header>
    @endif

    <div class="p-4">
        {{ $slot }}
    </div>

    <div id="global-loader" style="display: none; position: fixed; inset: 0; background: rgba(255,255,255,0.7); z-index: 9999; justify-content: center; align-items: center;">
        <div class="spinner"></div>
    </div>

</div>

@vite(['resources/js/jquery-3.7.1.js', 'resources/js/app.js', 'resources/js/toastr.min.js', 'resources/js/script.js', 'resources/js/chart.js'])

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
