<x-layout>
    @section('title', 'Détails de l\'employé')

        <div class="container-fluid py-4">

            {{-- Page Header --}}
            <div class="bg-gradient-primary-to-secondary rounded-4 p-4 mb-4 text-white shadow-lg">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="position-relative">
                            @if($employee->photo)
                                <img src="{{ Storage::url($employee->photo) }}"
                                     alt="{{ $employee->firstname }}"
                                     class="rounded-circle border border-3 border-white shadow-lg object-fit-cover"
                                     width="80" height="80">
                            @else
                                <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold shadow-lg"
                                     style="width:80px;height:80px;background:linear-gradient(135deg,#072194 0%,#113bf1 100%);">
                                    {{ strtoupper(substr($employee->firstname,0,1)) }}{{ strtoupper(substr($employee->lastname,0,1)) }}
                                </div>
                            @endif

                            @if ($employee->status == 1)
                                <span class="position-absolute bottom-0 end-0 translate-middle p-2 bg-success border border-2 border-white rounded-circle"
                                      title="Actif"></span>
                            @else
                                <span class="position-absolute bottom-0 end-0 translate-middle p-2 bg-danger border border-2 border-white rounded-circle"
                                      title="Inactif"></span>
                            @endif
                        </div>

                        <div>
                            <h1 class="h4 mb-1 fw-bold">
                                {{ $employee->firstname }} {{ $employee->lastname }}
                            </h1>
                            <p class="mb-1 text-white-50">
                                <i class="bi bi-credit-card-2-front me-1"></i>PPR :
                                <span class="fw-semibold">{{ $employee->ppr }}</span>
                                @if($employee->cin)
                                    · <i class="bi bi-person-vcard me-1 ms-2"></i>CIN :
                                    <span class="fw-semibold">{{ $employee->cin }}</span>
                                @endif
                            </p>
                            <span class="badge rounded-pill bg-light text-primary fw-semibold px-3 py-2">
                        <i class="bi bi-briefcase-fill me-1"></i>
                        {{ $employee->status == 1 ? 'Employé actif' : 'Employé inactif' }}
                    </span>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('employees.index') }}" class="btn btn-outline-light">
                            <i class="bi bi-arrow-left me-1"></i>Retour à la liste
                        </a>
                        <a href="{{ route('employees.edit', $employee) }}" class="btn btn-light text-primary fw-semibold">
                            <i class="bi bi-pencil-square me-1"></i>Modifier
                        </a>
                    </div>
                </div>
            </div>

            <div class="row g-4">

                {{-- Left column: identity + contact --}}
                <div class="col-lg-4">

                    {{-- Identité --}}
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white border-0 d-flex align-items-center">
                    <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary me-2">
                        <i class="bi bi-person-badge-fill"></i>
                    </span>
                            <h5 class="mb-0 text-dark">Identité</h5>
                        </div>
                        <div class="card-body">
                            <dl class="row mb-0 small">
                                <dt class="col-5 text-muted">Nom</dt>
                                <dd class="col-7 fw-semibold text-dark">{{ $employee->lastname }}</dd>

                                <dt class="col-5 text-muted">Prénom</dt>
                                <dd class="col-7 fw-semibold text-dark">{{ $employee->firstname }}</dd>

                                @if($employee->firstname_arab || $employee->lastname_arab)
                                    <dt class="col-5 text-muted">Nom (Arabe)</dt>
                                    <dd class="col-7 fw-semibold text-dark">
                                        {{ $employee->firstname_arab }} {{ $employee->lastname_arab }}
                                    </dd>
                                @endif

                                <dt class="col-5 text-muted">Genre</dt>
                                <dd class="col-7">
                                    @if($employee->gender === 'F')
                                        <span class="badge rounded-pill bg-pink-soft text-pink">
                                    <i class="bi bi-gender-female me-1"></i>Féminin
                                </span>
                                    @elseif($employee->gender === 'M')
                                        <span class="badge rounded-pill bg-info-soft text-info">
                                    <i class="bi bi-gender-male me-1"></i>Masculin
                                </span>
                                    @else
                                        <span class="badge rounded-pill bg-secondary-subtle text-secondary">
                                    Non spécifié
                                </span>
                                    @endif
                                </dd>

                                <dt class="col-5 text-muted">Date de naissance</dt>
                                <dd class="col-7">
                                    {{ $employee->birth_date ? \Carbon\Carbon::parse($employee->birth_date)->format('d/m/Y') : '—' }}
                                </dd>

                                <dt class="col-5 text-muted">Lieu de naissance</dt>
                                <dd class="col-7">{{ $employee->birth_city ?? '—' }}</dd>

                                <dt class="col-5 text-muted">Situation familiale</dt>
                                <dd class="col-7">{{ $employee->sit ?? '—' }}</dd>
                            </dl>
                        </div>
                    </div>

                    {{-- Coordonnées --}}
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white border-0 d-flex align-items-center">
                    <span class="badge rounded-pill bg-success bg-opacity-10 text-success me-2">
                        <i class="bi bi-telephone-fill"></i>
                    </span>
                            <h5 class="mb-0 text-dark">Coordonnées</h5>
                        </div>
                        <div class="card-body small">
                            <div class="mb-3">
                                <div class="text-muted mb-1">Téléphone</div>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-telephone me-2 text-success"></i>
                                    <span class="fw-semibold text-dark">{{ $employee->tel ?? '—' }}</span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="text-muted mb-1">Email</div>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-envelope me-2 text-warning"></i>
                                    @if($employee->email)
                                        <a href="mailto:{{ $employee->email }}" class="fw-semibold text-decoration-none text-dark">
                                            {{ $employee->email }}
                                        </a>
                                    @else
                                        <span class="text-dark">—</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="text-muted mb-1">Adresse</div>
                                <p class="mb-0 text-dark fw-semibold">
                                    {{ $employee->address ?? '—' }}
                                    @if($employee->city)
                                        <br><span class="text-muted">{{ $employee->city }}</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Affectation actuelle --}}
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white border-0 d-flex align-items-center">
                    <span class="badge rounded-pill bg-warning bg-opacity-10 text-warning me-2">
                        <i class="bi bi-building"></i>
                    </span>
                            <h5 class="mb-0 text-dark">Affectation actuelle</h5>
                        </div>
                        <div class="card-body small">
                            <div class="mb-2">
                                <span class="text-muted d-block">Local</span>
                                <span class="fw-semibold text-dark">
                            {{ $employee->local->title ?? 'Non affecté' }}
                        </span>
                            </div>
                            <div class="mb-2">
                                <span class="text-muted d-block">Commission / carte</span>
                                <span class="fw-semibold text-dark">
                            {{ $employee->commission_card ?? '—' }}
                        </span>
                            </div>
                            <div class="mb-0">
                                <span class="text-muted d-block">Statut</span>
                                <span class="badge rounded-pill {{ $employee->status == 1 ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                            {{ $employee->status == 1 ? 'Actif' : 'Inactif' }}
                        </span>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Right column: professional & history --}}
                <div class="col-lg-8">

                    {{-- Informations professionnelles --}}
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white border-0 d-flex align-items-center">
                    <span class="badge rounded-pill bg-info bg-opacity-10 text-info me-2">
                        <i class="bi bi-briefcase-fill"></i>
                    </span>
                            <h5 class="mb-0 text-dark">Informations professionnelles</h5>
                        </div>
                        <div class="card-body small">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="text-muted mb-1">Date de recrutement</div>
                                    <div class="d-flex align-items-center text-dark">
                                        <i class="bi bi-calendar-check me-2 text-info"></i>
                                        <span>
                                    {{ $employee->hiring_date ? \Carbon\Carbon::parse($employee->hiring_date)->format('d/m/Y') : '—' }}
                                </span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="text-muted mb-1">Date de départ à la retraite</div>
                                    <div class="d-flex align-items-center text-dark">
                                        <i class="bi bi-hourglass-split me-2 text-secondary"></i>
                                        <span>
                                    {{ $employee->retiring_date ? \Carbon\Carbon::parse($employee->retiring_date)->format('d/m/Y') : '—' }}
                                </span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="text-muted mb-1">Date de disposition</div>
                                    <div class="d-flex align-items-center text-dark">
                                        <i class="bi bi-arrow-left-right me-2 text-warning"></i>
                                        <span>
                                    {{ $employee->disposition_date ? \Carbon\Carbon::parse($employee->disposition_date)->format('d/m/Y') : '—' }}
                                </span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="text-muted mb-1">Motif de disposition</div>
                                    <p class="mb-0 text-dark fw-semibold">
                                        {{ $employee->disposition_reason ?? '—' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Historique de réintégration / mouvements --}}
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white border-0 d-flex align-items-center">
                    <span class="badge rounded-pill bg-secondary bg-opacity-10 text-secondary me-2">
                        <i class="bi bi-clock-history"></i>
                    </span>
                            <h5 class="mb-0 text-dark">Historique administratif</h5>
                        </div>
                        <div class="card-body small">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item px-0 d-flex">
                                    <div class="me-3 text-secondary">
                                        <i class="bi bi-arrow-repeat"></i>
                                    </div>
                                    <div>
                                        <div class="text-muted small mb-1">Réintégration</div>
                                        <div class="fw-semibold text-dark">
                                            {{ $employee->reintegration_date ? \Carbon\Carbon::parse($employee->reintegration_date)->format('d/m/Y') : '—' }}
                                        </div>
                                        <div class="text-muted">
                                            {{ $employee->reintegration_reason ?? 'Aucun motif renseigné.' }}
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Notes / section libre (facultatif) --}}
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white border-0 d-flex align-items-center">
                    <span class="badge rounded-pill bg-light text-dark me-2">
                        <i class="bi bi-info-circle-fill"></i>
                    </span>
                            <h5 class="mb-0 text-dark">Informations complémentaires</h5>
                        </div>
                        <div class="card-body small text-muted">
                            <p class="mb-0">
                                Vous pouvez ajouter ici des notes internes, des remarques RH ou des liens vers des documents
                                (CV, décisions administratives, etc.).
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Styles spécifiques à la fiche employé --}}
        <style>

            .object-fit-cover {
                object-fit: cover;
            }

            .bg-pink-soft {
                background-color: rgba(255, 192, 203, 0.15);
            }

            .text-pink {
                color: #d63384;
            }

            .bg-success-subtle {
                background-color: rgba(25, 135, 84, 0.12);
            }

            .bg-secondary-subtle {
                background-color: rgba(108, 117, 125, 0.12);
            }

            .card {
                border-radius: 1rem;
            }

            .card-header {
                border-radius: 1rem 1rem 0 0 !important;
            }
        </style>

</x-layout>
