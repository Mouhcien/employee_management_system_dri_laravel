{{-- Notifications & User Dropdown remains the same --}}
<div class="dropdown float-end">
    <button class="btn btn-link d-flex align-items-center text-decoration-none dropdown-toggle p-0"
            type="button" id="userMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
        @if(session('employee_photo') && Storage::disk('public')->exists(session('employee_photo')))
            <img src="{{ Storage::url(session('employee_photo')) }}"
                 class="rounded-circle border border-2 border-primary-subtle" width="38" height="38">
        @else
            <div class="img-hover-preview rounded-circle border border-2 border-white shadow-sm d-flex align-items-center justify-content-center text-white fw-bold"
                 data-initials="{{ strtoupper(substr(session('employee_name'), 0, 1)) }}"
                 style="width:45px; height:45px; background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); font-size: 0.85rem;">
                {{ strtoupper(substr(session('employee_name'), 0, 1)) }}
            </div>
        @endif

    </button>
    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
        <li><a class="dropdown-item" href="{{ route('profiles.show', auth()->user()->id) }}"><i class="bi bi-person-badge me-2"></i>Profil de {{auth()->user()->name}}</a></li>
        <li><a class="dropdown-item" href="{{ route('configs.index') }}"><i class="bi bi-tools me-2"></i>Paramètres</a></li>
        @if (auth()->user()->profile->id == 1 || auth()->user()->profile->title == 'Administrateur')
            <li><a class="dropdown-item" href="{{ route('profiles.index') }}"><i class="bi bi-person-badge-fill me-2"></i>Gestion des utilisateurs</a></li>
        @endif
        <li><a class="dropdown-item" href="{{ route('settings.importation') }}"><i class="bi bi-database-add me-2"></i>Importation</a></li>
        <li><hr class="dropdown-divider"></li>
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dropdown-item text-danger fw-bold"><i class="bi bi-door-closed me-2"></i>Déconnexion</button>
            </form>
        </li>
    </ul>
</div>
