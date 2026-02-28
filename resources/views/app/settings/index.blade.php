<x-layout>
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 pb-0 pt-3">
            <ul class="nav nav-tabs" id="settingsTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a
                        class="nav-link active text-primary fw-semibold"
                        id="types-tab"
                        data-bs-toggle="tab"
                        href="#types"
                        role="tab"
                        aria-controls="types"
                        aria-selected="true"
                    >
                        <i class="bi bi-list me-2"></i>
                        Type d’entité
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a
                        class="nav-link text-secondary fw-semibold"
                        id="grades-tab"
                        data-bs-toggle="tab"
                        href="#grades"
                        role="tab"
                        aria-controls="grades"
                        aria-selected="false"
                    >
                        <i class="bi bi-award me-2"></i>
                        Gestion des Grades
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a
                        class="nav-link text-secondary fw-semibold"
                        id="echelons-tab"
                        data-bs-toggle="tab"
                        href="#echelons"
                        role="tab"
                        aria-controls="echelons"
                        aria-selected="false"
                    >
                        <i class="bi bi-arrow-up-right-square me-2"></i>
                        Gestion des échelons
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a
                        class="nav-link text-secondary fw-semibold"
                        id="diplomes-tab"
                        data-bs-toggle="tab"
                        href="#diplomes"
                        role="tab"
                        aria-controls="diplomes"
                        aria-selected="false"
                    >
                        <i class="bi bi-mortarboard me-2"></i>
                        Diplômes
                    </a>
                </li>
            </ul>
        </div>

        <!-- Tab panes inside card body -->
        <div class="card-body pt-4">
            <div class="tab-content" id="settingsTabsContent">
                <!-- Tab 1: Type d'entité -->
                <div
                    class="tab-pane fade show active"
                    id="types"
                    role="tabpanel"
                    aria-labelledby="types-tab"
                >
                    @include('app.settings.types.index')
                </div>

                <!-- Tab 2: Gestion des Grades -->
                <div
                    class="tab-pane fade"
                    id="grades"
                    role="tabpanel"
                    aria-labelledby="grades-tab"
                >
                    <div class="text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        Contenu de la gestion des grades.
                    </div>
                </div>

                <!-- Tab 3: Gestion des échelons -->
                <div
                    class="tab-pane fade"
                    id="echelons"
                    role="tabpanel"
                    aria-labelledby="echelons-tab"
                >
                    <div class="text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        Contenu de la gestion des échelons.
                    </div>
                </div>

                <!-- Tab 4: Diplômes -->
                <div
                    class="tab-pane fade"
                    id="diplomes"
                    role="tabpanel"
                    aria-labelledby="diplomes-tab"
                >
                    <div class="text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        Contenu de la gestion des diplômes.
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
