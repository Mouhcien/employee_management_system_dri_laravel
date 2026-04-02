<x-layout>
    {{-- Styles optimisés --}}
    @push('styles')
        <style>
            .hover-row-highlight:hover {
                background-color: rgba(79, 70, 229, 0.04) !important;
                border-left: 4px solid #4f46e5 !important;
                transition: all 0.2s ease;
            }

            .avatar-hover {
                transition: transform 0.2s;
                cursor: zoom-in;
            }

            .avatar-hover:hover {
                transform: scale(1.1);
            }

            #employee-photo-preview {
                position: fixed;
                display: none;
                pointer-events: none;
                z-index: 9999;
                padding: 8px;
                background: #fff;
                border-radius: 1rem;
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
                border: 1px solid #e2e8f0;
            }

            #employee-photo-preview img {
                display: block;
                max-width: 320px;
                max-height: 320px;
                border-radius: 0.75rem;
                object-fit: cover;
            }

            .ls-1 { letter-spacing: 0.5px; }
        </style>
    @endpush

    @section('title', 'Gestion des Agents - HR Management')

    <div class="container-fluid py-4">
        {{-- Header Premium --}}
        <div class="card border-0 shadow-lg rounded-4 mb-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="bg-primary bg-gradient p-4 text-white position-relative">
                    <div class="position-absolute top-0 end-0 p-4 opacity-10">
                        <i class="bi bi-people-fill" style="font-size: 8rem;"></i>
                    </div>
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3 position-relative">
                        <div>
                            <h1 class="h3 fw-bold mb-1 text-white">Répertoire des Agents</h1>
                            <p class="text-white text-opacity-75 mb-0 small">
                                <i class="bi bi-geo-alt-fill me-1"></i>DRI-Marrakech | Administration du personnel
                            </p>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('employees.advance') }}" class="btn btn-info btn-rounded shadow-sm fw-bold px-4 transition-base">
                                <i class="bi bi-search me-2"></i>Recherche Avancée
                            </a>
                            <a href="{{ route('employees.create') }}" class="btn btn-white btn-rounded shadow-sm fw-bold px-4 transition-base">
                                <i class="bi bi-plus-circle-fill me-2"></i>Nouvel Employé
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Grid de Statistiques --}}
        <div class="row g-4 mb-4">
            @php
                $metrics = [
                    ['label' => 'Total Agents', 'count' => $total_employee, 'color' => 'primary', 'icon' => 'bi-people-fill'],
                    ['label' => 'Femmes', 'count' => $femaleCount, 'color' => 'danger', 'icon' => 'bi-gender-female'],
                    ['label' => 'Hommes', 'count' => $maleCount, 'color' => 'info', 'icon' => 'bi-gender-male'],
                    ['label' => 'Sites / Locaux', 'count' => $locals->count(), 'color' => 'warning', 'icon' => 'bi-building-fill']
                ];
            @endphp
            @foreach($metrics as $metric)
                <div class="col-xl-3 col-sm-6">
                    <div class="card border-0 shadow-sm rounded-4 hover-lift h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-{{ $metric['color'] }} bg-opacity-10 rounded-4 p-3 text-{{ $metric['color'] }}">
                                    <i class="bi {{ $metric['icon'] }} fs-3"></i>
                                </div>
                                <div class="ms-3">
                                    <h4 class="fw-bold mb-0 text-dark">{{ $metric['count'] ?? 0 }}</h4>
                                    <p class="text-muted small mb-0 fw-bold text-uppercase ls-1">{{ $metric['label'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if(session('opt') != 'empcrd')
        {{-- Panneau de Recherche Avancé --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
                <form method="GET" action="{{ route('employees.search') }}" class="row g-3 align-items-end">
                    <div class="col-xl-4 col-lg-6">
                        <label class="form-label small fw-bold text-muted text-uppercase ls-1">Recherche globale</label>
                        <div class="input-group bg-light rounded-3 overflow-hidden border">
                            <span class="input-group-text bg-transparent border-0"><i class="bi bi-search"></i></span>
                            <input type="text" name="employee_search" value="{{ $filter_val }}" class="form-control bg-transparent border-0 shadow-none py-2" placeholder="Nom, PPR, Email...">
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6">
                        <label class="form-label small fw-bold text-muted text-uppercase ls-1">Localisation</label>
                        <select name="local_id" id="sl_employee_local" class="form-select border-0 bg-light rounded-3 shadow-none">
                            <option value="-1">Tous les locaux</option>
                            @foreach($locals as $local)
                                <option value="{{ $local->id }}" {{ $local_id == $local->id ? 'selected' : '' }}>{{ $local->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xl-3 col-lg-6">
                        <label class="form-label small fw-bold text-muted text-uppercase ls-1">Ville</label>
                        <select name="city_id" id="sl_employee_city" class="form-select border-0 bg-light rounded-3 shadow-none">
                            <option value="-1">Toutes les villes</option>
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}" {{ $city_id == $city->id ? 'selected' : '' }}>{{ $city->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xl-2 col-lg-6 d-flex gap-2">
                        <button type="submit" class="btn btn-dark flex-fill rounded-3 py-2 fw-bold transition-base">
                            <i class="bi bi-funnel-fill me-2"></i>Filtrer
                        </button>
                        <button type="button" class="btn btn-info flex-fill rounded-3 py-2 fw-bold transition-base"
                                title="Option de triage"
                                data-bs-toggle="modal"
                                data-bs-target="#sortEmployeeOptionsModal" >
                            <i class="bi bi-sort-up-alt"></i>
                        </button>
                        <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary rounded-3 py-2">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
        @endif

        {{-- sort option --}}
        <x-sort-employee-options />

        {{-- Table Card --}}
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden" style="min-height: 400px;">

            <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-list-stars text-primary me-2"></i>Effectif Actif</h5>
                @if(request()->hasAny(['sort_ppr', 'sort_lastname', 'sort_firstname', 'sort_age']))
                    <div class="mb-3 d-flex align-items-center gap-2">
                        <span class="small text-muted">Tri actif :</span>
                        <a href="{{ route('employees.index') }}" class="btn btn-xs btn-outline-danger rounded-pill px-2 py-0 small">
                            Effacer tous les tris <i class="bi bi-x-circle ms-1"></i>
                        </a>
                    </div>
                @endif
                <div class="d-flex gap-2">
                    <div class="btn-group rounded-pill overflow-hidden shadow-xs">
                        <button class="btn btn-light border-end" onclick="window.print()"><i class="bi bi-printer"></i></button>
                        <a class="btn btn-light" href="{{ route('employees.download') }}"><i class="bi bi-file-earmark-excel"></i></a>
                    </div>
                    <div class="btn-group rounded-pill overflow-hidden shadow-xs ms-2">
                        <a href="{{ route('employees.index') }}?opt=list" class="btn btn-{{ session('opt') == 'list' || !session('opt') ? 'primary' : 'light' }}">
                            <i class="bi bi-list"></i>
                        </a>
                        <a href="{{ route('employees.index') }}?opt=cards" class="btn btn-{{ session('opt') == 'cards' ? 'primary' : 'light' }}">
                            <i class="bi bi-grid-fill"></i>
                        </a>
                        <a href="{{ route('employees.index') }}?opt=empcrd" class="btn btn-{{ session('opt') == 'empcrd' ? 'primary' : 'light' }}">
                            <i class="bi bi-person-badge"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                @if (session('opt') == 'cards')
                    @include('app.employees._cards')
                @elseif(session('opt') == 'empcrd')
                    @include('app.employees._employee_card')
                @else
                    @include('app.employees._list')
                @endif
            </div>

            {{-- Footer Pagination --}}
            @if($employees instanceof \Illuminate\Pagination\AbstractPaginator)
                @if(isset($employees) && $employees->hasPages())
                    <div class="card-footer bg-white border-top-0 py-4 px-4">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                            <div class="text-muted small">
                                Agents <span class="fw-bold text-dark">{{ $employees->firstItem() }}</span> - <span class="fw-bold text-dark">{{ $employees->lastItem() }}</span> sur <span class="fw-bold text-dark">{{ $employees->total() }}</span>
                            </div>
                            <div>
                                {{ $employees->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </div>

        {{-- Modals de suppression --}}
        @foreach($employees as $employee)
            <x-delete-model
                href="{{ route('employees.delete', $employee->id) }}"
                message="Attention : La suppression de l'agent #{{ $employee->ppr }} est irréversible."
                title="Confirmation de Suppression"
                target="deleteEmployeeModal" />
        @endforeach
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Gestion du preview photo
                const previewBox = document.getElementById('employee-photo-preview');
                const previewImg = previewBox.querySelector('img');
                const offsetX = 25;
                const offsetY = 25;

                document.querySelectorAll('.employee-photo-thumb').forEach(function (img) {
                    img.addEventListener('mouseenter', function (e) {
                        const src = img.dataset.full || img.src;
                        previewImg.src = src;
                        previewBox.style.display = 'block';
                        movePreview(e);
                    });

                    img.addEventListener('mousemove', movePreview);
                    img.addEventListener('mouseleave', () => previewBox.style.display = 'none');
                });

                function movePreview(e) {
                    previewBox.style.left = (e.clientX + offsetX) + 'px';
                    previewBox.style.top  = (e.clientY + offsetY) + 'px';
                }

                // Gestion des lignes extensibles (Détails)
                document.querySelectorAll('.employee-row').forEach(row => {
                    row.classList.add('hover-row-highlight');
                    row.addEventListener('click', function (e) {
                        if (e.target.closest('.dropdown') || e.target.closest('a') || e.target.closest('button')) return;

                        const targetId = this.getAttribute('data-bs-target');
                        const detailsRow = document.querySelector(targetId);
                        if (detailsRow) {
                            new bootstrap.Collapse(detailsRow, { toggle: true });
                            const icon = this.querySelector('.toggle-details i');
                            if (icon) {
                                icon.classList.toggle('bi-chevron-down');
                                icon.classList.toggle('bi-chevron-up');
                            }
                        }
                    });
                });
            });
        </script>
    @endpush

    <style>
        .hover-lift:hover { transform: translateY(-3px); transition: transform 0.2s; }
        .btn-white { background: #fff; color: #4f46e5; border: none; }
        .btn-white:hover { background: #f8f9fa; color: #4338ca; }
        .btn-rounded { border-radius: 50px; }
        .shadow-xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
    </style>
</x-layout>
