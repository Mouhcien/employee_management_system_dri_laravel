<x-layout>

    {{-- Custom Styles --}}
    <style>

        .details-row td {
            border-top: none;
        }

        .employee-row:hover {
            background-color: rgba(0,0,0,0.02);
        }


        .hover-primary:hover {
            color: #667eea !important;
        }

        .fw-mono {
            font-family: 'SF Mono', Monaco, monospace;
            font-size: 0.85em;
        }

        .object-fit-cover {
            object-fit: cover;
        }

        .dropdown-menu {
            border-radius: 0.75rem;
        }

        .dropdown-item {
            border-radius: 0.5rem;
            margin: 0.125rem 0.5rem;
            padding: 0.5rem 1rem;
        }

        .dropdown-item:hover {
            background-color: rgba(102, 126, 234, 0.1);
        }

        .btn-light {
            background-color: #f8f9fa;
            border-color: #e9ecef;
        }

        .btn-light:hover {
            background-color: #e9ecef;
            border-color: #dee2e6;
        }

        .badge {
            font-weight: 500;
            padding: 0.5em 0.75em;
        }

        .table th {
            letter-spacing: 0.5px;
        }

        .card {
            border-radius: 1rem;
        }

        .card-header {
            border-radius: 1rem 1rem 0 0 !important;
        }

        .rounded-4 {
            border-radius: 1rem !important;
        }

        .table tbody tr {
            border-left: 3px solid transparent;
        }

        .table tbody tr:hover {
            border-left-color: #667eea;
        }


        /* Status indicator pulse animation */
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(25, 135, 84, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(25, 135, 84, 0); }
            100% { box-shadow: 0 0 0 0 rgba(25, 135, 84, 0); }
        }

        .position-absolute.bg-success {
            animation: pulse 2s infinite;
        }

        .table-responsive {
            overflow-x: visible;  /* or hidden, instead of auto */
        }

        #employee-photo-preview {
            position: fixed;
            display: none;
            pointer-events: none;           /* mouse passes through */
            z-index: 2000;                  /* above table & dropdowns */
            padding: 6px;
            background: #fff;
            border-radius: 0.75rem;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.25);
            border: 1px solid rgba(148, 163, 184, 0.5);
        }

        #employee-photo-preview img {
            display: block;
            max-width: 360px;
            max-height: 360px;
            border-radius: 0.75rem;
            object-fit: cover;
        }

    </style>

    @section('title', 'Employees - HR Management')

    <div class="container-fluid py-4">
        <form action="{{ route('employees.importation') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="bg-gradient-primary-to-secondary rounded-4 p-4 mb-4 text-white shadow-lg">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3">
                    <div class="row col-12">
                        <div class="col-4">
                            <h1 class="h3 mb-1 fw-bold"><i class="bi bi-file-earmark-excel-fill me-2"></i>Importer les agents</h1>
                            <p class="text-white-50 small mb-0"><i class="bi bi-geo-alt-fill me-1"></i>DRI-Marrakech | Administration du personnel</p>
                        </div>
                        <div class="col-4">
                            <select name="local_id" class="form-control">
                                <option value="-1">Séléctionnez le local</option>
                                @foreach($locals as $local)
                                    <option value="{{ $local->id }}">{{ $local->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4">
                            <input type="file" name="file" class="form-control d-inline-flex align-items-center shadow-sm fw-semibold" />
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-success mb-2">
                <i class="bi bi-save"> Importer </i>
            </button>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                    <tr>
                        <th scope="col" class="text-muted small fw-semibold px-4 py-3 border-0"></th>
                        <th scope="col" class="text-muted small fw-semibold px-4 py-3 border-0">PPR</th>
                        <th scope="col" class="text-muted small fw-semibold px-4 py-3 border-0">NOM</th>
                        <th scope="col" class="text-muted small fw-semibold px-4 py-3 border-0">PRÉNOM</th>
                        <th scope="col" class="text-muted small fw-semibold px-4 py-3 border-0">CIN</th>
                        <th scope="col" class="text-muted small fw-semibold px-4 py-3 border-0">DATE RECRUTEMENT</th>
                        <th scope="col" class="text-muted small fw-semibold px-4 py-3 border-0">TEL CONTACT</th>
                        <th scope="col" class="text-muted small fw-semibold px-4 py-3 border-0">EMAIL</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white">

                    </tbody>
                </table>
            </div>
        </form>
    </div>



</x-layout>
