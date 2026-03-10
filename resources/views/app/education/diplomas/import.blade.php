
<div class="container-fluid py-4">
    <form action="{{ route('qualifications.importation') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="bg-gradient-primary-to-secondary rounded-4 p-4 mb-4 text-white shadow-lg">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3">
                <div class="row col-12">
                    <div class="col-4">
                        <h1 class="h3 mb-1 fw-bold"><i class="bi bi-file-earmark-excel-fill me-2"></i>Importer les agents par diplôme</h1>
                        <p class="text-white-50 small mb-0"><i class="bi bi-geo-alt-fill me-1"></i>DRI-Marrakech | Administration du personnel</p>
                    </div>
                    <div class="col-3">
                        <select name="occupation_id" class="form-control">
                            <option value="null">Séléctionnez le diplôme</option>
                            @foreach($diplomas as $diploma)
                                <option value="{{ $diploma->id }}">{{ $diploma->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-3">
                        <select name="option_id" class="form-control">
                            <option value="null">Séléctionnez la filière</option>
                            @foreach($options as $option)
                                <option value="{{ $option->id }}">{{ $option->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-2">
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
                    <th scope="col" class="text-muted small fw-semibold px-4 py-3 border-0">PPR</th>
                    <th scope="col" class="text-muted small fw-semibold px-4 py-3 border-0">Anneé d'obtnetion</th>
                </tr>
                </thead>
                <tbody class="bg-white">
                @for($i=0;$i<3;$i++)
                    <tr>
                        <td> XXX </td><td> XXX </td>
                    </tr>
                @endfor
                </tbody>
            </table>
        </div>
    </form>
</div>
