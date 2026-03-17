<x-layout>
    @section('title', 'Gestion des villes - HR Management')

    <div class="container-fluid py-4">
        {{-- Glassmorphic Page Header --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="bg-primary bg-gradient p-4 text-white">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="fw-bold mb-1">Déploiement Géographique</h2>
                            <p class="opacity-75 mb-0">Gérez les villes et les implantations locales de votre structure</p>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <button class="btn btn-white btn-rounded shadow-sm fw-bold px-4 me-2" data-bs-toggle="modal" data-bs-target="#createCityModal">
                                <i class="bi bi-plus-lg me-2"></i>Nouvelle Ville
                            </button>
                            <button class="btn btn-primary-light btn-rounded shadow-sm" data-bs-toggle="modal" data-bs-target="#bulkActions">
                                <i class="bi bi-download"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Dynamic Stats Grid --}}
        <div class="row g-3 mb-4">
            @php
                $stats = [
                    ['label' => 'Villes Totales', 'count' => $cities->total(), 'color' => 'primary', 'icon' => 'bi-geo-alt-fill'],
                    ['label' => 'Locaux Actifs', 'count' => $total_locals, 'color' => 'success', 'icon' => 'bi-house-door-fill'],
                    ['label' => 'Ville avec max local', 'count' => 0, 'color' => 'info', 'icon' => 'bi-people-fill'],
                    ['label' => 'Villes Actives', 'count' => 0, 'color' => 'warning', 'icon' => 'bi-pin-map-fill']
                ];
            @endphp
            @foreach($stats as $stat)
                <div class="col-xl-3 col-sm-6">
                    <div class="card border-0 shadow-sm rounded-4 hover-lift h-100">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-{{ $stat['color'] }}-subtle text-{{ $stat['color'] }} rounded-4 p-3 me-3">
                                    <i class="bi {{ $stat['icon'] }} fs-4"></i>
                                </div>
                                <div>
                                    <h4 class="fw-bold mb-0 text-dark">{{ $stat['count'] ?? 0 }}</h4>
                                    <p class="text-muted small mb-0 fw-medium text-uppercase ls-1">{{ $stat['label'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Advanced Filter Bar --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
                <form method="GET" action="{{ route('cities.index') }}" class="row g-3 align-items-end">
                    <div class="col-lg-5">
                        <label class="form-label fw-bold small text-uppercase text-muted">Recherche géographique</label>
                        <div class="input-group bg-light border-0 rounded-3">
                            <span class="input-group-text bg-transparent border-0"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" name="search" value="{{ $filter }}" class="form-control bg-transparent border-0 shadow-none py-2" placeholder="Nom de ville ou local spécifique...">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <label class="form-label fw-bold small text-uppercase text-muted">Filtrer par localité</label>
                        <select name="lc" id="sl_city_local_id" class="form-select border-0 bg-light rounded-3 shadow-none">
                            <option value="-1">Tous les locaux</option>
                            @foreach($locals as $local)
                                <option value="{{ $local->id }}" {{ $local_id == $local->id ? 'selected' : '' }}>{{ $local->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3 d-flex gap-2">
                        <button type="submit" class="btn btn-dark w-100 rounded-3 shadow-sm"><i class="bi bi-funnel me-1"></i>Filtrer</button>
                        <a href="{{ route('cities.index') }}" class="btn btn-outline-secondary rounded-3 border-light-subtle bg-white shadow-sm"><i class="bi bi-arrow-clockwise"></i></a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Cities Table Card --}}
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="card-header bg-white py-3 px-4 border-bottom-0 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-geo-fill text-primary me-2"></i>Répertoire Géographique</h5>
                <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 fw-bold">Total: {{ $cities->total() }}</span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light-subtle">
                    <tr>
                        <th class="ps-4 py-3 text-muted small text-uppercase ls-1 fw-bold border-0">Nom de la Ville</th>
                        <th class="py-3 text-muted small text-uppercase ls-1 fw-bold border-0">Locaux Rattachés</th>
                        <th class="py-3 text-muted small text-uppercase ls-1 fw-bold border-0 text-center">Population RH</th>
                        <th class="pe-4 py-3 text-muted small text-uppercase ls-1 fw-bold border-0 text-end">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($cities as $city)
                        <tr class="hover-row transition-base">
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary-subtle text-primary rounded-circle p-2 me-3 d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
                                        <i class="bi bi-geo-alt"></i>
                                    </div>
                                    <div class="fw-bold text-dark fs-6">{{ $city->title }}</div>
                                </div>
                            </td>
                            <td class="py-3">
                                @if($city->locals->count() > 0)
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach($city->locals as $local)
                                            <span class="badge bg-info-subtle text-info border border-info-subtle rounded-pill px-2 py-1 extra-small">
                                                <i class="bi bi-house-door me-1"></i>{{ $local->title }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-muted italic small opacity-75">Aucun local défini</span>
                                @endif
                            </td>
                            <td class="py-3 text-center">
                                @php
                                    $empCount = $city->locals->sum(fn($l) => $l->employees->count());
                                @endphp
                                <div class="badge bg-{{ $empCount > 0 ? 'success' : 'secondary' }}-subtle text-{{ $empCount > 0 ? 'success' : 'secondary' }} rounded-pill px-3 py-2 fw-bold">
                                    <i class="bi bi-people-fill me-1"></i>
                                    {{ $empCount }}
                                </div>
                            </td>
                            <td class="pe-4 py-3 text-end">
                                <div class="d-flex justify-content-end gap-1">
                                    <a href="{{ route('cities.show', $city) }}" class="btn btn-sm btn-outline-primary border-0 rounded-circle p-2" title="Voir détails">
                                        <i class="bi bi-eye-fill fs-5"></i>
                                    </a>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light border-0 shadow-xs rounded-circle p-2" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical fs-5"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4 overflow-hidden">
                                            <li><a class="dropdown-item py-2 small" href="#"><i class="bi bi-envelope me-2 text-info"></i>Notifier les locaux</a></li>
                                            <li><a class="dropdown-item py-2 small" href="#"><i class="bi bi-file-earmark-pdf me-2 text-danger"></i>Export Ville (PDF)</a></li>
                                            <li><hr class="dropdown-divider opacity-50"></li>
                                            <li>
                                                <button class="dropdown-item py-2 small text-danger fw-bold" data-bs-toggle="modal" data-bs-target="#deleteCityModal-{{ $city->id }}">
                                                    <i class="bi bi-trash3 me-2"></i>Supprimer
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="py-4">
                                    <i class="bi bi-geo-alt fs-1 text-muted opacity-25"></i>
                                    <h5 class="mt-3 text-muted">Aucune ville n'est encore enregistrée</h5>
                                    <button class="btn btn-primary rounded-pill px-4 mt-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#createCityModal">Ajouter la première ville</button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if(isset($cities) && $cities->hasPages())
                <div class="card-footer bg-white border-top-0 py-4 px-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                        <div class="text-muted small order-2 order-md-1">
                            Affichage <span class="fw-bold">{{ $cities->firstItem() }}</span> - <span class="fw-bold">{{ $cities->lastItem() }}</span> sur <span class="fw-bold">{{ $cities->total() }}</span> résultats
                        </div>
                        <div class="order-1 order-md-2">
                            {{ $cities->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Individual Delete Modals --}}
    @foreach($cities as $city)
        <x-delete-model
            href="{{ route('cities.delete', $city->id) }}"
            message="Attention : La suppression de la ville '{{ $city->title }}' entraînera la dissociation de tous les locaux liés."
            title="Confirmation de Suppression"
            target="deleteCityModal-{{ $city->id }}" />
    @endforeach

    {{-- Create City Modal --}}
    <div class="modal fade" id="createCityModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <form action="{{ route('cities.store') }}" method="POST">
                    @csrf
                    <div class="modal-header border-0 bg-primary bg-gradient p-4 text-white">
                        <div class="d-flex align-items-center">
                            <div class="bg-white bg-opacity-20 p-2 rounded-circle me-3 shadow-sm">
                                <i class="bi bi-geo-alt-fill fs-3 text-white"></i>
                            </div>
                            <div>
                                <h5 class="modal-title fw-bold mb-0">Nouvelle Ville</h5>
                                <small class="text-white text-opacity-75">Définition géographique</small>
                            </div>
                        </div>
                        <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body p-4 bg-white">
                        <div class="mb-4">
                            <label for="cityTitle" class="form-label small fw-bold text-muted text-uppercase ls-1">Nom de la ville officielle <span class="text-danger">*</span></label>
                            <div class="input-group input-group-lg border rounded-3 overflow-hidden shadow-sm transition-base">
                                <span class="input-group-text bg-white border-0 text-primary"><i class="bi bi-geo-alt"></i></span>
                                <input type="text" class="form-control border-0 bg-white shadow-none @error('title') is-invalid @enderror" id="cityTitle" name="title" placeholder="Ex: Tanger, Agadir..." required>
                            </div>
                        </div>

                        <div class="bg-light-subtle border border-light-subtle rounded-4 p-3 d-none" id="previewSection">
                            <div class="d-flex align-items-center text-primary fw-bold">
                                <i class="bi bi-check2-circle me-2"></i>
                                <span id="previewTitle"></span>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-0 bg-light px-4 py-3">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4 fw-semibold" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm"><i class="bi bi-check-lg me-2"></i>Créer la ville</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Export Modal --}}
    <div class="modal fade" id="bulkActions" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header bg-dark text-white p-4">
                    <h5 class="modal-title fw-bold">Exporter les données géographiques</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="list-group list-group-flush">
                        <a href="{{ route('cities.download') }}" class="list-group-item list-group-item-action d-flex align-items-center p-4 border-0 border-bottom">
                            <i class="bi bi-file-earmark-excel-fill text-success fs-2 me-4"></i>
                            <div>
                                <div class="fw-bold">Données Excel</div>
                                <small class="text-muted">Tableau complet avec statistiques par ville</small>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const titleInput = document.getElementById('cityTitle');
                const previewSection = document.getElementById('previewSection');
                const previewTitle = document.getElementById('previewTitle');

                titleInput.addEventListener('input', function() {
                    const value = this.value.trim();
                    previewTitle.textContent = value;
                    previewSection.classList.toggle('d-none', !value);
                });
            });
        </script>
    @endpush

    @push('styles')
        <style>
            .hover-row:hover { background-color: #f8faff !important; }
            .transition-base { transition: all 0.2s ease-in-out; }
            .hover-lift:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important; }
            .btn-white { background: #fff; color: #0d6efd; border: none; }
            .btn-white:hover { background: #f0f4ff; color: #0a58ca; }
            .btn-primary-light { background: rgba(255,255,255,0.15); border: none; color: #fff; }
            .btn-primary-light:hover { background: rgba(255,255,255,0.25); }
            .btn-rounded { border-radius: 50px; }
            .ls-1 { letter-spacing: 0.5px; }
            .w-fit { width: fit-content; }
            .extra-small { font-size: 0.7rem; }
            .shadow-xs { box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
            .bg-light-subtle { background-color: #f8f9fa !important; }
        </style>
    @endpush
</x-layout>
