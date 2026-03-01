<x-layout>
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 pb-0 pt-3">
            <ul class="nav nav-tabs" id="settingsTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a
                        class="nav-link @if (request()->routeIs('settings.edit.type')) active  @endif text-primary fw-semibold"
                        id="types-tab"
                        data-bs-toggle="tab"
                        href="#types"
                        role="tab"
                        aria-controls="types"
                        aria-selected="true"
                    >
                        <i class="bi bi-list me-2"></i>
                        Gestion des types d’entité
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a
                        class="nav-link @if (request()->routeIs('settings.edit.diploma')) active  @endif text-secondary fw-semibold"
                        id="grades-tab"
                        data-bs-toggle="tab"
                        href="#grades"
                        role="tab"
                        aria-controls="grades"
                        aria-selected="false"
                    >
                        <i class="bi bi-award me-2"></i>
                        Gestion des Diplômes
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a
                        class="nav-link @if (request()->routeIs('settings.edit.level')) active  @endif text-secondary fw-semibold"
                        id="levels-tab"
                        data-bs-toggle="tab"
                        href="#levels"
                        role="tab"
                        aria-controls="levels"
                        aria-selected="false"
                    >
                        <i class="bi bi-award me-2"></i>
                        Gestion des Niveaux d'éducation
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
                        @include('app.settings.diplomas.index')
                    </div>
                </div>

                <!-- Tab 3: Gestion des Niveaux -->
                <div
                    class="tab-pane fade"
                    id="levels"
                    role="tabpanel"
                    aria-labelledby="levels-tab"
                >
                    <div class="text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        @include('app.settings.levels.index')
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-layout>
