<x-layout>
    <form action="{{ route('employees.advance.result') }}" method="GET" id="filterForm">
        <div class="row g-4">
            <aside class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 fw-bold"><i class="bi bi-funnel me-2"></i>Filtrer par</h6>
                            <a href="{{ route('employees.advance') }}" class="text-decoration-none small text-muted">Réinitialiser</a>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="accordion accordion-flush" id="filterAccordion">

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUnits">
                                        Unités Structurelles
                                    </button>
                                </h2>
                                <div id="collapseUnits" class="accordion-collapse collapse show">
                                    <div class="accordion-body">
                                        @php
                                            $unitFields = [
                                                'services' => ['label' => 'Service', 'data' => $services],
                                                'entities' => ['label' => 'Entité', 'data' => $entities],
                                                'sectors'  => ['label' => 'Secteur', 'data' => $sectors],
                                                'sections' => ['label' => 'Section', 'data' => $sections],
                                            ];
                                        @endphp

                                        @foreach($unitFields as $name => $field)
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold text-uppercase text-muted">{{ $field['label'] }}</label>
                                                <select name="{{ $name }}[]" class="form-select select2-filter" multiple data-placeholder="Tous les {{ $field['label'] }}s">
                                                    @foreach($field['data'] as $item)
                                                        <option value="{{ $item->id }}">{{ $item->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseLocation">
                                        Localisation
                                    </button>
                                </h2>
                                <div id="collapseLocation" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        <div class="mb-3">
                                            <label class="form-label small fw-bold text-uppercase text-muted">Villes</label>
                                            <select name="cities[]" class="form-select select2-filter" multiple>
                                                @foreach($cities as $city)
                                                    <option value="{{ $city->id }}">{{ $city->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-0">
                                            <label class="form-label small fw-bold text-uppercase text-muted">Locaux</label>
                                            <select name="locals[]" class="form-select select2-filter" multiple>
                                                @foreach($locals as $local)
                                                    <option value="{{ $local->id }}">{{ $local->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </aside>

            <main class="col-md-9">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-3">
                        <div class="row g-2 align-items-center">
                            <div class="col">
                                <div class="input-group input-group-lg border rounded-pill px-3">
                                    <span class="input-group-text bg-transparent border-0"><i class="bi bi-search text-muted"></i></span>
                                    <input type="text" name="keyword" class="form-control border-0 shadow-none" placeholder="Rechercher par nom, email, matricule...">
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="btn-group shadow-sm" role="group">
                                    <a href="{{ route('employees.index') }}" class="btn btn-white border px-3" title="Retour">
                                        <i class="bi bi-arrow-left"></i>
                                    </a>
                                    <a href="{{ route('employees.advance') }}" class="btn btn-white border px-3" title="Actualiser">
                                        <i class="bi bi-arrow-clockwise"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="loader" class="text-center d-none my-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

                <div id="results-container">
                    @include('app.employees.search-result')
                </div>
            </main>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterForm = document.getElementById('filterForm');
            const resultsContainer = document.getElementById('results-container');
            const loader = document.getElementById('loader');

            let abortController = null;
            let typingTimer;

            const updateResults = async () => {
                // Cancel any ongoing fetch request
                if (abortController) abortController.abort();
                abortController = new AbortController();

                // UI States
                resultsContainer.style.opacity = '0.5';
                loader.classList.remove('d-none');

                const formData = new FormData(filterForm);
                const params = new URLSearchParams(formData);

                // Remove empty values from URL to keep it clean
                for (const [key, value] of [...params.entries()]) {
                    if (!value) params.delete(key);
                }

                const url = `${filterForm.action}?${params.toString()}`;
                window.history.pushState({}, '', url);

                try {
                    const response = await fetch(url, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' },
                        signal: abortController.signal
                    });

                    if (!response.ok) throw new Error('Network error');

                    const html = await response.text();
                    resultsContainer.innerHTML = html;
                } catch (error) {
                    if (error.name !== 'AbortError') {
                        console.error('Fetch error:', error);
                    }
                } finally {
                    resultsContainer.style.opacity = '1';
                    loader.classList.add('d-none');
                }
            };

            // Event Listeners
            filterForm.querySelectorAll('select').forEach(select => {
                select.addEventListener('change', updateResults);
            });

            filterForm.querySelector('input[name="keyword"]')?.addEventListener('input', (e) => {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(updateResults, 400); // 400ms is the sweet spot for search
            });

            // Prevent full page reload on submit button click
            filterForm.addEventListener('submit', (e) => {
                e.preventDefault();
                updateResults();
            });

            /* Search in the input  **/

            const searchInput = document.querySelector('input[name="keyword"]');

            /**
             * 1. THE INSTANT FILTER
             * This hides/shows what is ALREADY in the browser.
             */
            const applyInstantFilter = () => {
                const query = searchInput.value.toLowerCase().trim();
                const cards = resultsContainer.querySelectorAll('.card_items');

                cards.forEach(card => {
                    const content = card.innerText.toLowerCase();
                    const isMatch = content.includes(query);
                    card.style.setProperty('display', isMatch ? '' : 'none', 'important');
                });
            };

            /**
             * 2. THE SERVER SYNC (AJAX)
             * This gets fresh data from Laravel but RE-APPLIES the filter after loading.
             */
            let typingTimer1;
            const syncWithServer = () => {
                clearTimeout(typingTimer1);

                // Wait 500ms after user stops typing to hit the database
                typingTimer1 = setTimeout(() => {
                    const formData = new FormData(filterForm);
                    const params = new URLSearchParams(formData).toString();
                    const url = `${filterForm.action}?${params}`;

                    fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                        .then(response => response.text())
                        .then(html => {
                            // Update the HTML
                            resultsContainer.innerHTML = html;

                            // CRITICAL: Re-run the instant filter so the "all cards"
                            // flash doesn't happen if the user is still typing.
                            applyInstantFilter();
                        })
                        .catch(error => console.error('Error:', error));
                }, 500);
            };

            // --- EVENT LISTENERS ---

            searchInput.addEventListener('input', () => {
                // First, hide items instantly for a fast UI feel
                applyInstantFilter();

                // Second, tell the server to update the results in the background
                syncWithServer();
            });

            // Handle structural dropdowns (Services, Entities, etc.)
            filterForm.querySelectorAll('select').forEach(select => {
                select.addEventListener('change', syncWithServer);
            });

        });
    </script>
</x-layout>
