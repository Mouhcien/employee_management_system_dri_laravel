<x-layout>
    <style>
        :root { --saas-primary: #0061f2; --saas-bg-soft: #f8f9fa; }
        .page-header { background: linear-gradient(135deg, #0061f2 0%, #0a2351 100%); border-radius: 16px; }
        .card-saas { border: 1px solid rgba(0,0,0,.05); border-radius: 12px; background: #fff; }
        .form-label { font-weight: 600; font-size: 0.85rem; color: #4b5563; }
        .column-row { transition: all 0.2s ease; border: 1px solid #e5e7eb; background: #fff; }
        .btn-add-column { border: 2px dashed #d1d5db; color: #6b7280; transition: all 0.3s ease; }
        .btn-add-column:hover { border-color: var(--saas-primary); color: var(--saas-primary); background: rgba(0, 97, 242, 0.02); }
    </style>

    <div class="card page-header border-0 shadow-sm mb-4 text-white">
        <div class="card-body p-4">
            <div class="d-flex align-items-center">
                <div class="bg-primary bg-opacity-20 p-3 rounded-3 me-3">
                    <i class="bi {{ is_null($table) ? 'bi-plus-square-fill' : 'bi-pencil-square' }} fs-3"></i>
                </div>
                <div>
                    <h3 class="fw-bold mb-0">{{ is_null($table) ? 'Nouveau Tableau' : 'Modifier: ' . $table->title }}</h3>
                    <p class="mb-0 text-white-50 small">Configurez les métadonnées et la structure des colonnes</p>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ is_null($table) ? route('audit.tables.store') : route('audit.tables.update', $table->id) }}" method="POST">
        @csrf

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card card-saas shadow-sm">
                    <div class="card-header bg-transparent border-bottom py-3">
                        <h6 class="mb-0 fw-bold"><i class="bi bi-info-circle me-2 text-primary"></i>Infos Générales</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <label class="form-label">Nom du tableau</label>
                            <input type="text" name="title" class="form-control form-control-lg" value="{{ old('title', $table->title ?? '') }}" required>
                        </div>
                        <div class="mb-0">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="4">{{ old('description', $table->description ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-3 shadow">
                        @if (!is_null($table))
                            <i class="bi bi-pencil-square me-2"></i> Mettre à jour
                        @else
                            <i class="bi bi-save me-2"></i> Enregistrer
                        @endif
                    </button>
                    <a href="{{ route('audit.tables.index') }}" class="btn btn-link w-100 text-muted mt-2 text-decoration-none small">Annuler</a>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card card-saas shadow-sm">
                    <div class="card-header bg-transparent border-bottom py-3 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold"><i class="bi bi-columns-gap me-2 text-primary"></i>Colonnes du tableau</h6>
                        <span class="badge bg-light text-dark border fw-normal" id="column-count">0 Colonne</span>
                    </div>
                    <div class="card-body p-4">
                        <div id="columns-container">
                            @php $index = 0; @endphp

                            @if(!is_null($table) && $table->relations->count() > 0)
                                @foreach($table->relations as $relation)
                                    <div class="column-row p-3 rounded-3 mb-3 shadow-sm">
                                        <div class="row g-3">
                                            <input type="hidden" name="columns[{{ $index }}][id]" value="{{ $relation->column->id }}">
                                            <div class="col-md-5">
                                                <label class="form-label x-small text-uppercase">Titre</label>
                                                <input type="text" name="columns[{{ $index }}][title]" class="form-control" value="{{ $relation->column->title }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label x-small text-uppercase">Description</label>
                                                <input type="text" name="columns[{{ $index }}][description]" class="form-control" value="{{ $relation->column->description }}">
                                            </div>
                                            <div class="col-md-1 d-flex align-items-end justify-content-center">
                                                <button type="button" class="btn btn-outline-danger border-0 remove-column">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @php $index++; @endphp
                                @endforeach
                            @endif

                            @if(is_null($table) || $table->relations->count() == 0)
                                <div class="column-row p-3 rounded-3 mb-3 shadow-sm">
                                    <div class="row g-3">
                                        <div class="col-md-5">
                                            <label class="form-label x-small text-uppercase">Titre</label>
                                            <input type="text" name="columns[{{ $index }}][title]" class="form-control" placeholder="Ex: Statut" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label x-small text-uppercase">Description</label>
                                            <input type="text" name="columns[{{ $index }}][description]" class="form-control" placeholder="..." >
                                        </div>
                                        <div class="col-md-1 d-flex align-items-end justify-content-center">
                                            <button type="button" class="btn btn-outline-danger border-0 remove-column" {{ is_null($table) ? 'disabled' : '' }}>
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @php $index++; @endphp
                            @endif
                        </div>

                        <button type="button" id="add-column-btn" class="btn btn-add-column w-100 py-3 rounded-3 mt-2 fw-bold">
                            <i class="bi bi-plus-circle me-2"></i>Ajouter une colonne
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('columns-container');
            const addBtn = document.getElementById('add-column-btn');
            const countBadge = document.getElementById('column-count');
            let columnIndex = {{ $index }}; // Start index from where PHP left off

            addBtn.addEventListener('click', function () {
                const row = document.createElement('div');
                row.className = 'column-row p-3 rounded-3 mb-3 shadow-sm animate__animated animate__fadeInUp';
                row.innerHTML = `
                    <div class="row g-3">
                        <div class="col-md-5">
                            <label class="form-label x-small text-uppercase">Titre</label>
                            <input type="text" name="columns[${columnIndex}][title]" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label x-small text-uppercase">Description</label>
                            <input type="text" name="columns[${columnIndex}][description]" class="form-control">
                        </div>
                        <div class="col-md-1 d-flex align-items-end justify-content-center">
                            <button type="button" class="btn btn-outline-danger border-0 remove-column"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>`;
                container.appendChild(row);
                columnIndex++;
                updateCount();
            });

            container.addEventListener('click', e => {
                if (e.target.closest('.remove-column')) {
                    e.target.closest('.column-row').remove();
                    updateCount();
                }
            });

            function updateCount() {
                const count = container.querySelectorAll('.column-row').length;
                countBadge.innerText = `${count} ${count > 1 ? 'Colonnes' : 'Colonne'}`;
            }
            updateCount();
        });
    </script>
</x-layout>
