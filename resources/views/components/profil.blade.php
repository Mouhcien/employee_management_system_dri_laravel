<div class="ms-auto d-flex align-items-center gap-4">
    {{-- Notifications & User Dropdown remains the same --}}
    <div class="dropdown">
        <button class="btn btn-link d-flex align-items-center text-decoration-none dropdown-toggle p-0"
                type="button" id="userMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'Admin' }}&background=4F46E5&color=fff"
                 class="rounded-circle border border-2 border-primary-subtle" width="38" height="38">
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
            <li><a class="dropdown-item" href="#">Profil</a></li>
            <li><a class="dropdown-item" href="{{ route('configs.index') }}"><i class="bi bi-tools me-2"></i>Paramètres</a></li>
            <li><a class="dropdown-item" href="{{ route('settings.importation') }}">Importation</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger fw-bold">Déconnexion</button>
                </form>
            </li>
        </ul>
    </div>
</div>
