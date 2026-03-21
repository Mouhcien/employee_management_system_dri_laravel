<x-layout>
    <form action="/employees/advance/result" method="GET" id="filterForm">
        <div class="row">
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-filter"></i> Filters</h5>
                    </div>
                    <div class="card-body">
                        <div class="accordion accordion-flush" id="searchAccordion">

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEntities">
                                        Unités Structurelles
                                    </button>
                                </h2>
                                <div id="collapseEntities" class="accordion-collapse collapse show">
                                    <div class="accordion-body px-0">
                                        <label class="form-label fw-bold">service</label>
                                        <select name="services[]" class="form-select mb-3" multiple>
                                            @foreach($services as $service)
                                                <option value="{{ $service->id }}">{{ $service->title }}</option>
                                            @endforeach
                                        </select>

                                        <label class="form-label fw-bold">entités</label>
                                        <select name="entities[]" class="form-select mb-3" multiple>
                                            @foreach($entities as $entity)
                                                <option value="{{ $entity->id }}">{{ $entity->title }}</option>
                                            @endforeach
                                        </select>

                                        <label class="form-label fw-bold">Secteurs</label>
                                        <select name="sectors[]" class="form-select mb-3" multiple>
                                            @foreach($sectors as $sector)
                                                <option value="{{ $sector->id }}">{{ $sector->title }}</option>
                                            @endforeach
                                        </select>

                                        <label class="form-label fw-bold">Sections</label>
                                        <select name="sections[]" class="form-select mb-3" multiple>
                                            @foreach($sections as $section)
                                                <option value="{{ $section->id }}">{{ $section->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseLocation">
                                        Location
                                    </button>
                                </h2>
                                <div id="collapseLocation" class="accordion-collapse collapse">
                                    <div class="accordion-body px-0">
                                        <label class="form-label fw-bold">Villes</label>
                                        <select name="cities[]" class="form-select mb-3" multiple>
                                            @foreach($cities as $city)
                                                <option value="{{ $city->id }}">{{ $city->title }}</option>
                                            @endforeach
                                        </select>

                                        <label class="form-label fw-bold">Locaux</label>
                                        <select name="locals[]" class="form-select mb-3" multiple>
                                            @foreach($locals as $local)
                                                <option value="{{ $local->id }}">{{ $local->title }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary">Apply Filters</button>
                            <a href="{{ route('employees.search') }}" class="btn btn-link btn-sm text-secondary">Clear All</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <input type="text" name="keyword" class="form-control form-control-lg" placeholder="Search by employee name or email...">
                        <a href="{{ route('employees.index') }}" class="btn btn-white btn-rounded px-4 fw-bold">
                            <i class="bi bi-arrow-left me-2"></i>Retour
                        </a>
                        <a href="{{ route('employees.advance') }}" class="btn btn-white btn-rounded px-4 fw-bold">
                            <i class="bi bi-circle me-2"></i>Actulaiser
                        </a>
                    </div>
                </div>

                <div id="results-container">
                </div>
            </div>
        </div>
    </form>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterForm = document.getElementById('filterForm');
            const resultsContainer = document.getElementById('results-container');

            const updateResults = () => {
                const formData = new FormData(filterForm);
                const params = new URLSearchParams(formData).toString();
                const url = `${filterForm.action}?${params}`;

                // Update the browser URL without refreshing
                window.history.pushState({}, '', url);

                // Fetch data from Laravel
                fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                    .then(response => response.text())
                    .then(html => {
                        resultsContainer.innerHTML = html;
                    })
                    .catch(error => console.error('Error fetching results:', error));
            };

            // Trigger update whenever a choice changes
            filterForm.querySelectorAll('select, input').forEach(input => {
                input.addEventListener('change', updateResults);
            });

            // Also handle text typing with a small delay (debounce)
            let typingTimer;
            filterForm.querySelector('input[name="keyword"]')?.addEventListener('keyup', () => {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(updateResults, 500);
            });
        });
    </script>
</x-layout>
