<x-layout>

    @section('title', 'Gestion des Catégories - HR Management')

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

    <div class="container-fluid py-4">
        {{-- Header Premium avec effet de profondeur --}}
        <div class="card border-0 shadow-lg rounded-4 mb-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="bg-primary bg-gradient p-4 text-white position-relative">
                    {{-- Icône décorative en filigrane --}}
                    <div class="position-absolute top-0 end-0 p-4 opacity-10">
                        <i class="bi bi-tags-fill" style="font-size: 8rem;"></i>
                    </div>
                    <div class="row align-items-center position-relative">
                        <div class="col-md-8">
                            <h2 class="fw-bold mb-1 text-white">Catégorie {{ $category->title }}</h2>
                            <p class="text-white text-opacity-75 mb-0 fw-medium">
                                <i class="bi bi-shield-check me-2"></i>Administration des employés
                            </p>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('categories.index') }}" class="btn btn-white btn-rounded shadow-sm fw-bold px-4 float-end">
                                <i class="bi bi-arrow-left me-2"></i>Retour
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Table Card --}}
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

            <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-list-stars text-primary me-2"></i>Effectif Actif <span class="badge bg-info"> {{ $employees->total() }}</span></h5>
                <div class="d-flex gap-2">
                    <div class="btn-group rounded-pill overflow-hidden shadow-xs">
                        <button class="btn btn-light border-end" onclick="window.print()"><i class="bi bi-printer"></i></button>
                        <button class="btn btn-light"><i class="bi bi-file-earmark-excel"></i></button>
                    </div>
                    <div class="btn-group rounded-pill overflow-hidden shadow-xs ms-2">
                        <a href="{{ route('categories.show', $category) }}?opt=list" class="btn btn-{{ session('opt') == 'list' || !session('opt') ? 'primary' : 'light' }}">
                            <i class="bi bi-list"></i>
                        </a>
                        <a href="{{ route('categories.show', $category) }}?opt=cards" class="btn btn-{{ session('opt') == 'cards' ? 'primary' : 'light' }}">
                            <i class="bi bi-grid-fill"></i>
                        </a>
                        <a href="{{ route('categories.show', $category) }}?opt=empcrd" class="btn btn-{{ session('opt') == 'empcrd' ? 'primary' : 'light' }}">
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
