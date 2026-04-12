<x-layout>
    @section('title', 'Gestion des Demandes - HR Management')

    <style>
        body { font-family: 'Inter', 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        .fw-extrabold { font-weight: 800; }

        /* Table Aesthetics */
        .table thead th {
            background-color: #f8fafc;
            text-transform: uppercase;
            font-size: 0.65rem;
            letter-spacing: 0.05rem;
            color: #64748b;
            padding: 16px;
            border-top: 1px solid #e2e8f0;
        }
        .table tbody tr { transition: all 0.2s; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
        .table tbody tr:hover { background-color: #ffffff; box-shadow: 0 4px 12px rgba(0,0,0,0.03); }

        /* Badge Styling */
        .badge-type { font-size: 0.7rem; padding: 0.4rem 0.6rem; border-radius: 6px; font-weight: 700; }
        .bg-mutation { background-color: #e0f2fe; color: #0369a1; } /* Blue */
        .bg-conge { background-color: #fef3c7; color: #92400e; }    /* Amber */

        .avatar-sq { width: 38px; height: 38px; object-fit: cover; border-radius: 8px; }
        .filter-bar { background: white; border-radius: 12px 12px 0 0; border-bottom: 1px solid #e2e8f0; padding: 1.25rem; }
    </style>

    <div class="container-fluid py-4 px-md-5">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 fw-extrabold text-dark mb-1">
                    <i class="bi bi-file-earmark-text me-1 text-primary"></i>Suivi des <span class="text-primary text-opacity-75">Demandes</span>
                </h1>
                <p class="text-muted small mb-0">Visualisez et traitez les demandes de mutation et de congé.</p>
            </div>
            <a class="btn btn-primary rounded-3 px-4 fw-bold shadow-sm" href="{{ route('demands.create') }}">
                <i class="bi bi-plus-lg me-2"></i>Nouvelle Demande
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            {{-- Filter Bar --}}
            <div class="filter-bar">
                <form method="GET" action="{{ route('demands.index') }}" class="row g-3">
                    <div class="col-md-4">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                            <input type="text" name="fltr" value="{{ $fltr }}" class="form-control bg-light border-0" placeholder="Agent, titre ou objet...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="type" class="form-select form-select-sm bg-light border-0">
                            <option value="">Tous les types</option>
                            <option value="M">Mutations</option>
                            <option value="C">Congés</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="state" class="form-select form-select-sm bg-light border-0">
                            <option value="1">Les demandes en cours</option>
                            <option value="*">Tous les demandes</option>
                            <option value="0">Les demandes satisfaites</option>
                        </select>
                    </div>
                    <div class="col-md-2 text-md-end">
                        <button type="submit" class="btn btn-dark btn-sm px-4 rounded-3 fw-bold">Filtrer</button>
                        <a href="{{ route('demands.index') }}" class="btn btn-link btn-sm text-muted">Effacer</a>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                    <tr>
                        <th class="ps-4">Agent</th>
                        <th>Type & Titre</th>
                        <th>Objet</th>
                        <th>Date Demande</th>
                        <th class="text-center">Fichier</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($demands as $demand)
                        <tr>
                            {{-- Agent Info --}}
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    @if($demand->employee->photo)
                                        <img src="{{ Storage::url($demand->employee->photo) }}" class="avatar-sq me-3 border">
                                    @else
                                        <div class="avatar-sq me-3 bg-light text-primary d-flex align-items-center justify-content-center fw-bold">
                                            {{ strtoupper(substr($demand->employee->firstname, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="fw-bold text-dark small">{{ strtoupper($demand->employee->lastname) }} {{ $demand->employee->firstname }}</div>
                                        <div class="text-muted tiny" style="font-size: 0.7rem;">PPR: #{{ $demand->employee->ppr }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- Type & Title --}}
                            <td>
                                    <span class="badge-type {{ $demand->type == 'M' ? 'bg-mutation' : 'bg-conge' }} mb-1 d-inline-block">
                                        {{ $demand->type == 'M' ? 'MUTATION' : 'CONGÉ' }}
                                    </span>
                                <div class="fw-semibold text-dark small">{{ $demand->title ?? 'N/A' }}</div>
                            </td>

                            {{-- Object --}}
                            <td>
                                <div class="text-muted small text-truncate" style="max-width: 200px;" title="{{ $demand->object }}">
                                    {{ $demand->object }}
                                </div>
                            </td>

                            {{-- Date --}}
                            <td>
                                <div class="small fw-medium">
                                    <i class="bi bi-calendar3 me-1 text-primary"></i>
                                    {{ \Carbon\Carbon::parse($demand->demand_date)->format('d/m/Y') }}
                                </div>
                            </td>

                            {{-- File --}}
                            <td class="text-center">
                                @if($demand->file)
                                    <a href="{{ Storage::url($demand->file) }}" target="_blank" class="btn btn-sm btn-light border-0 text-primary">
                                        <i class="bi bi-filetype-doc fs-6"></i>
                                    </a>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td class="pe-4 text-end">
                                <div class="btn-group shadow-sm">
                                    <a href="{{ route('demands.show', $demand) }}" class="btn btn-white btn-sm border" title="Voir">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('demands.edit', $demand) }}" class="btn btn-white btn-sm border" title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button class="btn btn-white btn-sm border text-danger" title="Supprimer"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteDemandModal-{{ $demand->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <img src="https://illustrations.popsy.co/flat/empty-state.svg" style="width: 150px;" class="mb-3 opacity-50">
                                <p class="text-muted small">Aucune demande enregistrée pour le moment.</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modals de suppression --}}
    @foreach($demands as $demand)

        <x-delete-model
            href="{{ route('demands.delete', $demand->id) }}"
            message="Attention : La suppression - #{{ $demand->title }} est irréversible."
            title="Confirmation de Suppression"
            target="deleteDemandModal-{{ $demand->id }}" />

    @endforeach
</x-layout>
