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
                            <h1 class="h3 fw-bold mb-1 text-white">Répertoire des Agents Non Actifs</h1>
                            <p class="text-white text-opacity-75 mb-0 small">
                                <i class="bi bi-geo-alt-fill me-1"></i>DRI-Marrakech | Administration du personnel
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(session('opt') != 'empcrd')
            {{-- Panneau de Recherche Avancé --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <form method="GET" action="{{ route('employees.status') }}" class="row g-3 align-items-end">
                        <div class="col-xl-4 col-lg-6">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Recherche globale</label>
                            <div class="input-group bg-light rounded-3 overflow-hidden border">
                                <span class="input-group-text bg-transparent border-0"><i class="bi bi-search"></i></span>
                                <input type="text" name="flt" value="{{ $filter_val ?? '' }}" class="form-control bg-transparent border-0 shadow-none py-2" placeholder="Nom, PPR, Email...">
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Status</label>
                            <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted">
                                <i class="bi bi-briefcase"></i>
                            </span>
                                <select class="form-select border-start-0 ps-0" name="state" id="sl_agent_status">
                                    <option value="" selected disabled>Choisir une situation...</option>
                                    <option value="0" {{ $state == "0" ? 'selected' : '' }}>Mise à disposition</option>
                                    <option value="-1" {{ $state == "-1" ? 'selected' : '' }}>Mise à la retraite</option>
                                    <option value="-2" {{ $state == "-2" ? 'selected' : '' }}>Suspension immédiate</option>
                                    <option value="2" {{ $state == "2" ? 'selected' : '' }}>Réintégration en position d'activité</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6">

                        </div>
                        <div class="col-xl-2 col-lg-6 d-flex gap-2">
                            <button type="submit" class="btn btn-dark flex-fill rounded-3 py-2 fw-bold transition-base">
                                <i class="bi bi-funnel-fill me-2"></i>Filtrer
                            </button>
                            <a href="{{ route('employees.status') }}" class="btn btn-outline-secondary rounded-3 py-2">
                                <i class="bi bi-arrow-clockwise"></i>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        {{-- Table Card --}}
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden" style="min-height: 400px;">

            <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-list-stars text-primary me-2"></i>Effectif Non Actif <span class="badge bg-info">{{ $employees->total() }}</span></h5>
                <div class="d-flex gap-2">
                    <div class="btn-group rounded-pill overflow-hidden shadow-xs">
                        <button class="btn btn-light border-end" onclick="window.print()"><i class="bi bi-printer"></i></button>
                        <button class="btn btn-light"><i class="bi bi-file-earmark-excel"></i></button>
                    </div>
                    <div class="btn-group rounded-pill overflow-hidden shadow-xs ms-2">
                        <a href="{{ route('employees.status') }}?opt=list" class="btn btn-{{ session('opt') == 'list' || !session('opt') ? 'primary' : 'light' }}">
                            <i class="bi bi-list"></i>
                        </a>
                        <a href="{{ route('employees.status') }}?opt=cards" class="btn btn-{{ session('opt') == 'cards' ? 'primary' : 'light' }}">
                            <i class="bi bi-grid-fill"></i>
                        </a>
                        <a href="{{ route('employees.status') }}?opt=empcrd" class="btn btn-{{ session('opt') == 'empcrd' ? 'primary' : 'light' }}">
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
