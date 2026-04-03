<x-layout>
    @push('styles')
        <style>
            :root {
                --glass-bg: rgba(255, 255, 255, 0.7);
                --glass-border: rgba(226, 232, 240, 0.8);
                --accent-indigo: #6366f1;
            }

            body { background-color: #f8fafc; }

            /* Professional Typography */
            .text-display { letter-spacing: -0.02em; font-weight: 700; color: #1e293b; }

            /* Glassmorphism Header */
            .glass-header {
                background: var(--glass-bg);
                backdrop-filter: blur(12px);
                border: 1px solid var(--glass-border);
                border-radius: 1.25rem;
            }

            /* Stats Highlight */
            .stat-pill {
                background: #ffffff;
                border: 1px solid #e2e8f0;
                padding: 0.5rem 1rem;
                border-radius: 50px;
                display: flex;
                align-items: center;
                gap: 10px;
                box-shadow: 0 1px 2px rgba(0,0,0,0.05);
            }

            /* Modern Table Hover */
            .hover-row-highlight {
                transition: all 0.2s ease;
                border-left: 4px solid transparent;
            }
            .hover-row-highlight:hover {
                background-color: #f1f5f9 !important;
                border-left: 4px solid var(--accent-indigo) !important;
                cursor: pointer;
            }

            /* Action Buttons Group */
            .action-hub {
                background: rgba(241, 245, 249, 0.8);
                padding: 4px;
                border-radius: 12px;
                display: inline-flex;
            }

            .action-hub .btn {
                border: none;
                padding: 6px 12px;
                border-radius: 8px;
                transition: all 0.2s;
            }

            .action-hub .btn-active {
                background: white;
                box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
                color: var(--accent-indigo);
            }
        </style>
    @endpush

    @section('title', "Détails Catégorie - {$category->title}")

        <div class="container-fluid py-4 px-lg-5">

            {{-- Futurist Breadcrumb & Header --}}
            <div class="glass-header p-4 mb-5 shadow-sm border-0">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary text-white rounded-4 p-3 me-4 shadow-primary">
                            <i class="bi bi-layers-fill fs-3"></i>
                        </div>
                        <div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-1 small fw-bold text-uppercase ls-1">
                                    <li class="breadcrumb-item"><a href="{{ route('categories.index') }}" class="text-decoration-none text-muted">Référentiel</a></li>
                                    <li class="breadcrumb-item active text-primary">Détails</li>
                                </ol>
                            </nav>
                            <h1 class="text-display h2 mb-0">{{ $category->title }}</h1>
                        </div>
                    </div>

                    <div class="d-flex gap-3 align-items-center">
                        <div class="stat-pill">
                            <i class="bi bi-people text-primary"></i>
                            <span class="fw-bold">
                            {{ $employees instanceof \Illuminate\Pagination\AbstractPaginator ? $employees->total() : $employees->count() }}
                        </span>
                            <span class="text-muted small text-uppercase fw-bold">Agents</span>
                        </div>
                        <a href="{{ route('categories.index') }}" class="btn btn-dark rounded-3 px-4 fw-bold">
                            <i class="bi bi-arrow-left me-2"></i>Retour
                        </a>
                    </div>
                </div>
            </div>

            {{-- Main Content Card --}}
            <div class="card border-0 shadow-soft rounded-4 overflow-hidden">
                <div class="card-header bg-white py-4 px-4 border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-person-check text-primary me-2"></i>Effectif de la catégorie</h5>

                    <div class="d-flex gap-3">
                        {{-- Export Hub --}}
                        <div class="btn-group shadow-sm rounded-3 overflow-hidden">
                            <button class="btn btn-white border-end" title="Excel"><i class="bi bi-file-earmark-excel text-success"></i></button>
                            <button class="btn btn-white" onclick="window.print()" title="PDF"><i class="bi bi-file-earmark-pdf text-danger"></i></button>
                        </div>

                        {{-- View Switcher --}}
                        <div class="action-hub shadow-sm">
                            <a href="?opt=list" class="btn {{ (session('opt') == 'list' || !session('opt')) ? 'btn-active' : '' }}">
                                <i class="bi bi-list-ul"></i>
                            </a>
                            <a href="?opt=cards" class="btn {{ session('opt') == 'cards' ? 'btn-active' : '' }}">
                                <i class="bi bi-grid"></i>
                            </a>
                            <a href="?opt=empcrd" class="btn {{ session('opt') == 'empcrd' ? 'btn-active' : '' }}">
                                <i class="bi bi-person-badge"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    @if (session('opt') == 'cards')
                        <div class="p-4">@include('app.employees._cards')</div>
                    @elseif(session('opt') == 'empcrd')
                        @include('app.employees._employee_card')
                    @else
                        <table class="table align-middle mb-0">
                            <thead class="bg-light">
                            <tr>
                                <th class="ps-4 border-0 py-3 text-uppercase small fw-bold text-muted">Agent</th>
                                <th class="border-0 py-3 text-uppercase small fw-bold text-muted">Statut</th>
                                <th class="border-0 py-3 text-uppercase small fw-bold text-muted text-end pe-4">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @include('app.employees._list')
                            </tbody>
                        </table>
                    @endif
                </div>

                {{-- Footer Pagination --}}
                @if($employees instanceof \Illuminate\Pagination\AbstractPaginator && $employees->hasPages())
                    <div class="card-footer bg-white border-top py-4 px-4">
                        <div class="d-flex justify-content-between align-items-center">
                        <span class="small text-muted">
                            Affichage <span class="fw-bold text-dark">{{ $employees->firstItem() }}</span> à <span class="fw-bold text-dark">{{ $employees->lastItem() }}</span> sur <span class="fw-bold text-dark">{{ $employees->total() }}</span>
                        </span>
                            <div>{{ $employees->appends(request()->query())->links() }}</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Clean Tooltip Initialization --}}
        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const tooltips = [].slice.call(document.querySelectorAll('[title]'))
                    tooltips.map(t => new bootstrap.Tooltip(t));
                });
            </script>
        @endpush
</x-layout>
