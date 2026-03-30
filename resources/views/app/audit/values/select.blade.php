<x-layout>
    <div class="row col-12 p-4">
        <div class="col-6">
            <input type="text" class="form-control mb-3">
            @foreach($employees as $employee)
                <div class="border mb-3 shadow p-3">
                    <div class="row col-12">
                        <div class="col-8">
                            @if($employee->photo && Storage::disk('public')->exists($employee->photo))
                                <img src="{{ Storage::url($employee->photo) }}" class="rounded-circle border border-3 border-white shadow-sm object-fit-cover avatar-hover" width="65" height="65">
                            @else
                                <div class="rounded-circle border border-3 border-white shadow-sm d-flex align-items-center justify-content-center text-white fw-bold"
                                     style="width:65px; height:65px; background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);">
                                    {{ strtoupper(substr($employee->firstname, 0, 1)) }}{{ strtoupper(substr($employee->lastname, 0, 1)) }}
                                </div>
                            @endif
                            <p>{{ $employee->lastname }} {{ $employee->firstname }}</p>
                        </div>
                        <div class="col-4 text-center align-content-center">
                            <button class="btn btn-sm btn-info">Charger</button>
                        </div>
                    </div>
                </div>
            @endforeach

            <div>
                {{ $employees->appends(request()->query())->links() }}
            </div>
        </div>

        <div class="col-6">
            <div class="">
                <label class="form-label-sm">Untité Structurelle</label>
                <select class="form-control mb-2" id="sl_audit_view_service">
                    <option value="-1"> Séléctionnez le service</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" {{ $selected_service == $service->id ? 'selected' : '' }}>{{ $service->title }}</option>
                    @endforeach
                </select>

                @if (count($entities) != 0)
                    <select class="form-control mb-2" id="sl_audit_view_entity">
                        <option value="-1"> Séléctionnez l'entité</option>
                        @foreach($entities as $entity)
                            <option value="{{ $entity->id }}" {{ $selected_entity == $entity->id ? 'selected' : '' }}>{{ $entity->title }}</option>
                        @endforeach
                    </select>
                @endif

                @if (count($sectors) != 0)
                    <select class="form-control mb-2" id="sl_audit_view_sector">
                        <option value="-1"> Séléctionnez le secteur</option>
                        @foreach($sectors as $sector)
                            <option value="{{ $sector->id }}" {{ $selected_sector == $sector->id ? 'selected' : '' }}>{{ $sector->title }}</option>
                        @endforeach
                    </select>
                @endif

                @if (count($sections) != 0)
                    <select class="form-control mb-2" id="sl_audit_view_section">
                        <option value="-1"> Séléctionnez la section</option>
                        @foreach($sections as $section)
                            <option value="{{ $section->id }}" {{ $selected_section == $section->id ? 'selected' : '' }}>{{ $section->title }}</option>
                        @endforeach
                    </select>
                @endif
            </div>

            <div class="text-center align-content-center mt-5">
                @php
                    $entityName = "l'untité";
                    if (!is_null($selected_service)) {
                        $entityName = "Service";
                    }
                    if (!is_null($selected_entity)) {
                        $entityName = "Entité";
                    }
                    if (!is_null($selected_sector)) {
                        $entityName = "Secteur";
                    }
                    if (!is_null($selected_section)) {
                        $entityName = "Section";
                    }
                    @endphp
                <button class="btn btn-primary"> Charger pour {{ $entityName }}</button>
            </div>
        </div>
    </div>
</x-layout>
