<x-layout>
    @push('styles')
        <style>
            :root {
                --accent-indigo: #6366f1;
                --sidebar-bg: #ffffff;
                --input-focus-shadow: rgba(99, 102, 241, 0.1);
            }

            body { background-color: #f8fafc; }

            /* Professional Typography */
            .text-display { letter-spacing: -0.01em; font-weight: 700; color: #1e293b; }
            .ls-caps { letter-spacing: 0.05em; font-size: 0.75rem; text-transform: uppercase; font-weight: 700; }

            /* Modern Sidebar Layout */
            .filter-sidebar {
                position: sticky;
                top: 20px;
                height: calc(100vh - 40px);
                overflow-y: auto;
                border-radius: 1.25rem;
                background: white;
                border: 1px solid #e2e8f0;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            }

            /* Accordion Customization */
            .accordion-filter .accordion-item { border: none; }
            .accordion-filter .accordion-button {
                font-size: 0.875rem;
                font-weight: 600;
                padding: 1.25rem;
                background-color: transparent !important;
                box-shadow: none !important;
                color: #475569;
            }
            .accordion-filter .accordion-button:not(.collapsed) { color: var(--accent-indigo); }

            /* Select2 & Input Styling */
            .form-label-futurist { margin-bottom: 0.5rem; color: #64748b; }
            .form-select-modern {
                border: 1px solid #e2e8f0;
                border-radius: 0.75rem;
                padding: 0.6rem;
                font-size: 0.9rem;
                transition: all 0.2s;
            }
            .form-select-modern:focus {
                border-color: var(--accent-indigo);
                box-shadow: 0 0 0 4px var(--input-focus-shadow);
            }

            /* Search Bar Glassmorphism */
            .search-header-container {
                background: rgba(255, 255, 255, 0.8);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(226, 232, 240, 0.8);
                border-radius: 1rem;
            }

            /* Animated Results Transition */
            #results-container {
                transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
            }

            /* Custom Scrollbar for Sidebar */
            .filter-sidebar::-webkit-scrollbar { width: 4px; }
            .filter-sidebar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        </style>
    @endpush

    <div class="container-fluid py-4 px-lg-5">
        <form action="{{ route('employees.advance.result') }}" method="GET" id="filterForm">
            <div class="row g-4">
                {{-- Refined Sidebar --}}
                <aside class="col-lg-3">
                    <div class="filter-sidebar d-flex flex-column">
                        <div class="p-4 border-bottom d-flex justify-content-between align-items-center bg-white sticky-top rounded-top-4">
                            <h6 class="mb-0 text-display"><i class="bi bi-sliders2-vertical me-2 text-primary"></i>Filtres</h6>
                            <a href="{{ route('employees.advance') }}" class="ls-caps text-decoration-none text-muted hover-primary">
                                <i class="bi bi-arrow-counterclockwise"></i> Reset
                            </a>
                        </div>

                        <div class="accordion accordion-flush accordion-filter flex-grow-1" id="filterAccordion">
                            {{-- Unités Structurelles --}}
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUnits">
                                        Unités Structurelles
                                    </button>
                                </h2>
                                <div id="collapseUnits" class="accordion-collapse collapse show">
                                    <div class="accordion-body pt-0">
                                        @php
                                            $unitFields = [
                                                'services' => ['label' => 'Service', 'data' => $services],
                                                'entities' => ['label' => 'Entité', 'data' => $entities],
                                                'sectors'  => ['label' => 'Secteur', 'data' => $sectors],
                                                'sections' => ['label' => 'Section', 'data' => $sections],
                                            ];
                                        @endphp
                                        @foreach($unitFields as $name => $field)
                                            <div class="mb-4">
                                                <label class="form-label-futurist ls-caps">{{ $field['label'] }}</label>
                                                <select name="{{ $name }}[]" class="form-select form-select-modern select2-filter" multiple data-placeholder="Tous les {{ $field['label'] }}s">
                                                    @foreach($field['data'] as $item)
                                                        <option value="{{ $item->id }}">{{ $item->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            {{-- Localisation --}}
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseLocation">
                                        Localisation Géo.
                                    </button>
                                </h2>
                                <div id="collapseLocation" class="accordion-collapse collapse">
                                    <div class="accordion-body pt-0">
                                        <div class="mb-4">
                                            <label class="form-label-futurist ls-caps">Villes</label>
                                            <select name="cities[]" class="form-select form-select-modern select2-filter" multiple>
                                                @foreach($cities as $city)
                                                    <option value="{{ $city->id }}">{{ $city->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-0">
                                            <label class="form-label-futurist ls-caps">Locaux</label>
                                            <select name="locals[]" class="form-select form-select-modern select2-filter" multiple>
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
                </aside>

                {{-- Results Area --}}
                <main class="col-lg-9">
                    <div class="search-header-container p-3 mb-4 shadow-sm">
                        <div class="row g-3 align-items-center">
                            <div class="col">
                                <div class="input-group bg-white rounded-pill px-3 py-1 border shadow-xs">
                                    <span class="input-group-text bg-transparent border-0"><i class="bi bi-search text-primary"></i></span>
                                    <input type="text" name="keyword"
                                           class="form-control border-0 shadow-none py-2"
                                           placeholder="Rechercher par nom, email, matricule (PPR)...">
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="btn-group rounded-3 overflow-hidden shadow-sm">
                                    <a href="{{ route('employees.index') }}" class="btn btn-white border px-3" title="Retour au répertoire">
                                        <i class="bi bi-arrow-left"></i>
                                    </a>
                                    <button type="submit" class="btn btn-primary px-4 fw-bold">
                                        <i class="bi bi-lightning-charge-fill me-2"></i>Analyser
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Loader --}}
                    <div id="loader" class="text-center d-none my-5 py-5">
                        <div class="spinner-grow text-primary" role="status" style="width: 3rem; height: 3rem;">
                            <span class="visually-hidden">Syncing...</span>
                        </div>
                        <p class="text-muted mt-3 fw-bold ls-caps">Synchronisation des données...</p>
                    </div>

                    {{-- Dynamic Container --}}
                    <div id="results-container">
                        @include('app.employees.search-result')
                    </div>
                </main>
            </div>
        </form>
    </div>

    {{-- Restored Scripts (Preserving all your original logic) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterForm = document.getElementById('filterForm');
            const resultsContainer = document.getElementById('results-container');
            const loader = document.getElementById('loader');
            const searchInput = document.querySelector('input[name="keyword"]');

            let abortController = null;
            let typingTimer;

            const updateResults = async () => {
                if (abortController) abortController.abort();
                abortController = new AbortController();

                resultsContainer.style.opacity = '0.3';
                resultsContainer.style.transform = 'translateY(10px)';
                loader.classList.remove('d-none');

                const formData = new FormData(filterForm);
                const params = new URLSearchParams(formData);

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
                    if (error.name !== 'AbortError') console.error('Fetch error:', error);
                } finally {
                    resultsContainer.style.opacity = '1';
                    resultsContainer.style.transform = 'translateY(0)';
                    loader.classList.add('d-none');
                }
            };

            // Event Listeners (Structural Sync)
            filterForm.querySelectorAll('select').forEach(select => {
                select.addEventListener('change', updateResults);
            });

            // Instant Filter Logic (Preserved)
            const applyInstantFilter = () => {
                const query = searchInput.value.toLowerCase().trim();
                const cards = resultsContainer.querySelectorAll('.card_items');
                cards.forEach(card => {
                    const content = card.innerText.toLowerCase();
                    const isMatch = content.includes(query);
                    card.style.setProperty('display', isMatch ? '' : 'none', 'important');
                });
            };

            searchInput.addEventListener('input', () => {
                applyInstantFilter();
                clearTimeout(typingTimer);
                typingTimer = setTimeout(updateResults, 400);
            });

            filterForm.addEventListener('submit', (e) => {
                e.preventDefault();
                updateResults();
            });
        });
    </script>
</x-layout>
