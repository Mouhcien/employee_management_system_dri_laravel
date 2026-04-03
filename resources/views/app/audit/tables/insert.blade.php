<x-layout>
    @push('styles')
        <style>
            :root {
                --saas-primary: #6366f1;
                --saas-indigo: #4f46e5;
                --saas-slate: #0f172a;
                --glass-bg: rgba(255, 255, 255, 0.7);
            }

            body { background-color: #f1f5f9; font-family: 'Inter', sans-serif; }

            /* Futurist Header */
            .header-vibrant {
                background: radial-gradient(circle at top right, #6366f1, #0f172a);
                border-radius: 24px;
                position: relative;
                overflow: hidden;
                border: 1px solid rgba(255, 255, 255, 0.1);
            }

            .header-vibrant::after {
                content: ""; position: absolute; top: -20%; right: -10%; width: 300px; height: 300px;
                background: rgba(99, 102, 241, 0.2); filter: blur(80px); border-radius: 50%;
            }

            /* Technical Card Aesthetic */
            .card-futurist {
                background: white; border-radius: 20px; border: 1px solid #e2e8f0;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
            .card-futurist:hover { box-shadow: 0 15px 30px -5px rgba(0, 0, 0, 0.05); }

            /* Column Row - Layered Depth */
            .column-row {
                background: #ffffff;
                border: 1px solid #e2e8f0;
                border-left: 5px solid var(--saas-primary);
                border-radius: 12px;
                transition: all 0.2s ease;
                box-shadow: 0 2px 4px rgba(0,0,0,0.02);
            }
            .column-row:hover {
                transform: translateX(5px);
                border-color: var(--saas-primary);
                box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.1);
            }

            /* Typography */
            .ls-caps { letter-spacing: 0.05em; font-size: 0.7rem; text-transform: uppercase; font-weight: 700; color: #64748b; }

            /* Add Button - Futurist Dash */
            .btn-add-futurist {
                border: 2px dashed #cbd5e1;
                background: #f8fafc;
                color: #64748b;
                transition: all 0.3s;
                border-radius: 12px;
            }
            .btn-add-futurist:hover {
                border-color: var(--saas-primary);
                color: var(--saas-primary);
                background: #fff;
                box-shadow: 0 4px 12px rgba(99, 102, 241, 0.15);
            }

            .btn-primary-gradient {
                background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
                border: none; box-shadow: 0 10px 20px -5px rgba(79, 70, 229, 0.4);
            }
            .btn-primary-gradient:hover { transform: translateY(-2px); box-shadow: 0 15px 25px -5px rgba(79, 70, 229, 0.5); }

            /* Inputs */
            .form-control-futurist {
                border-radius: 10px; border: 1px solid #e2e8f0; padding: 0.75rem 1rem;
                transition: all 0.2s;
            }
            .form-control-futurist:focus {
                border-color: var(--saas-primary);
                box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
            }
        </style>
    @endpush

    {{-- Header --}}
    <div class="card header-vibrant border-0 shadow-lg mb-5 text-white">
        <div class="card-body p-5">
            <div class="d-flex align-items-center">
                <div class="bg-white bg-opacity-10 p-3 rounded-4 me-4 border border-white border-opacity-10">
                    <i class="bi {{ is_null($table) ? 'bi-database-add' : 'bi-database-fill-gear' }} fs-2 text-info"></i>
                </div>
                <div>
                    <span class="ls-caps text-info opacity-75">Architecture de Données</span>
                    <h2 class="fw-bold mb-0 display-6">{{ is_null($table) ? 'Nouveau Référentiel' : 'Configuration: ' . $table->title }}</h2>
                    <p class="mb-0 text-white-50 lead fs-6">Définissez les attributs techniques de votre structure d'audit</p>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ is_null($table) ? route('audit.tables.store') : route('audit.tables.update', $table->id) }}" method="POST">
        @csrf

        <div class="row g-4">
            {{-- Left Sidebar: Meta --}}
            <div class="col-lg-4">
                <div class="card card-futurist shadow-sm sticky-top" style="top: 20px;">
                    <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                        <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-info-circle-fill me-2 text-primary"></i>Métadonnées</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <label class="ls-caps mb-2">Identifiant du tableau</label>
                            <input type="text" name="title" class="form-control form-control-futurist fw-bold" value="{{ old('title', $table->title ?? '') }}" placeholder="Ex: Audit_Agents_2026" required>
                        </div>
                        <div class="mb-0">
                            <label class="ls-caps mb-2">Note descriptive</label>
                            <textarea name="description" class="form-control form-control-futurist" rows="5" placeholder="Expliquez la finalité de ce tableau...">{{ old('description', $table->description ?? '') }}</textarea>
                        </div>
                    </div>
                    <div class="card-footer bg-light border-0 p-4">
                        <button type="submit" class="btn btn-primary-gradient w-100 py-3 fw-bold rounded-3">
                            @if (!is_null($table))
                                <i class="bi bi-cloud-arrow-up-fill me-2"></i> Mettre à jour le schéma
                            @else
                                <i class="bi bi-plus-circle-fill me-2"></i> Initialiser la table
                            @endif
                        </button>
                        <a href="{{ route('audit.tables.index') }}" class="btn btn-link w-100 text-muted mt-2 text-decoration-none ls-caps">
                            <i class="bi bi-arrow-left me-1"></i> Annuler
                        </a>
                    </div>
                </div>
            </div>

            {{-- Right Section: Dynamic Columns --}}
            <div class="col-lg-8">
                <div class="card card-futurist shadow-sm">
                    <div class="card-header bg-white border-bottom py-4 px-4 d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0 fw-bold"><i class="bi bi-layout-three-columns me-2 text-primary"></i>Dictionnaire des Colonnes</h6>
                            <p class="text-muted small mb-0 mt-1">Définissez les champs requis pour l'audit</p>
                        </div>
                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-2 rounded-pill fw-bold" id="column-count">0 Colonne</span>
                    </div>
                    <div class="card-body p-4 bg-light bg-opacity-50">
                        <div id="columns-container">
                            @php $index = 0; @endphp

                            @if(!is_null($table) && $table->relations->count() > 0)
                                @foreach($table->relations as $relation)
                                    <div class="column-row p-4 mb-3 animate__animated animate__fadeIn">
                                        <div class="row g-3">
                                            <input type="hidden" name="columns[{{ $index }}][id]" value="{{ $relation->column->id }}">
                                            <div class="col-md-5">
                                                <label class="ls-caps mb-2">Titre de l'attribut</label>
                                                <input type="text" name="columns[{{ $index }}][title]" class="form-control form-control-futurist fw-bold" value="{{ $relation->column->title }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="ls-caps mb-2">Règle / Description</label>
                                                <input type="text" name="columns[{{ $index }}][description]" class="form-control form-control-futurist" value="{{ $relation->column->description }}">
                                            </div>
                                            <div class="col-md-1 d-flex align-items-end justify-content-center pb-1">
                                                <button type="button" class="btn btn-outline-danger border-0 rounded-circle remove-column p-2">
                                                    <i class="bi bi-trash3-fill fs-5"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @php $index++; @endphp
                                @endforeach
                            @endif

                            @if(is_null($table) || $table->relations->count() == 0)
                                <div class="column-row p-4 mb-3 animate__animated animate__fadeIn">
                                    <div class="row g-3">
                                        <div class="col-md-5">
                                            <label class="ls-caps mb-2">Titre de l'attribut</label>
                                            <input type="text" name="columns[{{ $index }}][title]" class="form-control form-control-futurist fw-bold" placeholder="Ex: Date de validation" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="ls-caps mb-2">Règle / Description</label>
                                            <input type="text" name="columns[{{ $index }}][description]" class="form-control form-control-futurist" placeholder="Format AAAA-MM-JJ..." >
                                        </div>
                                        <div class="col-md-1 d-flex align-items-end justify-content-center pb-1">
                                            <button type="button" class="btn btn-outline-danger border-0 rounded-circle remove-column p-2" {{ is_null($table) ? 'disabled' : '' }}>
                                                <i class="bi bi-trash3-fill fs-5"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @php $index++; @endphp
                            @endif
                        </div>

                        <button type="button" id="add-column-btn" class="btn btn-add-futurist w-100 py-3 mt-2 fw-bold">
                            <i class="bi bi-plus-circle-dotted me-2 fs-5"></i>Injecter une nouvelle colonne
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
            let columnIndex = {{ $index }};

            addBtn.addEventListener('click', function () {
                const row = document.createElement('div');
                row.className = 'column-row p-4 mb-3 animate__animated animate__fadeInRight';
                row.innerHTML = `
                    <div class="row g-3">
                        <div class="col-md-5">
                            <label class="ls-caps mb-2">Titre de l'attribut</label>
                            <input type="text" name="columns[${columnIndex}][title]" class="form-control form-control-futurist fw-bold" required>
                        </div>
                        <div class="col-md-6">
                            <label class="ls-caps mb-2">Règle / Description</label>
                            <input type="text" name="columns[${columnIndex}][description]" class="form-control form-control-futurist">
                        </div>
                        <div class="col-md-1 d-flex align-items-end justify-content-center pb-1">
                            <button type="button" class="btn btn-outline-danger border-0 rounded-circle remove-column p-2"><i class="bi bi-trash3-fill fs-5"></i></button>
                        </div>
                    </div>`;
                container.appendChild(row);
                columnIndex++;
                updateCount();
            });

            container.addEventListener('click', e => {
                if (e.target.closest('.remove-column')) {
                    const rows = container.querySelectorAll('.column-row');
                    if(rows.length > 1) {
                        e.target.closest('.column-row').remove();
                        updateCount();
                    } else {
                        alert('Une structure de table nécessite au moins une colonne.');
                    }
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
