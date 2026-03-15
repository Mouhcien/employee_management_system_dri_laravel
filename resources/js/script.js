$(function() {
    /**
     * Helper to update URL based on a set of selectors
     * @param {string} baseUrl - The base path (e.g., '/chefs/')
     * @param {object} filters - Key-value pair of { queryParam: selector }
     */
    const updateFilters = (baseUrl, filters) => {
        const params = new URLSearchParams();

        Object.keys(filters).forEach(key => {
            const val = $(filters[key]).val();
            // Only add to URL if value is valid and not the default -1
            if (val && val !== "-1") {
                params.append(key, val);
            }
        });

        const queryString = params.toString();
        window.location.href = baseUrl + (queryString ? '?' + queryString : '');
    };

    // --- CHEF FILTERS ---
    const chefFilters = {
        srv: '#sl_chef_service_id',
        ent: '#sl_chef_entity_id',
        sectr: '#sl_chef_sector_id',
        sect: '#sl_chef_section_id'
    };

    $(Object.values(chefFilters).join(',')).on('change', function() {
        updateFilters('/chefs/', chefFilters);
    });

    // --- EMPLOYEE FILTERS ---
    const empFilters = {
        lc: '#sl_employee_local',
        ct: '#sl_employee_city'
    };

    $('#sl_employee_local, #sl_employee_city').on('change', function() {
        updateFilters('/employees/', empFilters);
    });

    // Gender Clicks (Special Case)
    $('#sl_employee_male, #sl_employee_female').on('click', function() {
        const gender = $(this).attr('id') === 'sl_employee_male' ? 'ml' : 'fml';
        const params = new URLSearchParams();
        params.append('gr', gender);

        // Add existing city/local if present
        if ($('#sl_employee_city').val() !== "-1") params.append('ct', $('#sl_employee_city').val());
        if ($('#sl_employee_local').val() !== "-1") params.append('lc', $('#sl_employee_local').val());

        window.location.href = '/employees/?' + params.toString();
    });

    // --- ENTITY FILTERS ---
    $('#sl_entity_service_id, #sl_entity_type_id').on('change', function() {
        updateFilters('/entities/', {
            srv: '#sl_entity_service_id',
            cat: '#sl_entity_type_id'
        });
    });

    // --- DYNAMIC PATH ROUTES (Sectors/Sections) ---
    // Uses data attributes for cleaner HTML (e.g., data-opt, data-ident)
    $('#service_id, #sect_service_id').on('change', function() {
        const $el = $(this);
        const srv = $el.val();
        const opt = $el.attr('opt');
        const id = $el.attr('ident');
        const path = $el.attr('id') === 'service_id' ? 'sectors' : 'sections';

        let url = `/${path}/${opt}`;
        if (id) url += `/${id}`;

        window.location.href = `${url}?srv=${srv}`;
    });

    // --- AFFECTATIONS ---
    $('#sl_aff_service_id, #sl_aff_entity_id').on('change', function() {
        const srv = $('#sl_aff_service_id').val();
        const ent = $('#sl_aff_entity_id').val();
        const opt = $(this).attr('opt');
        const empId = $(this).attr('employee_id');

        let url = (opt === 'edit')
            ? `/affectations/edit/${empId}/${$(this).attr('affectation_id')}`
            : `/employees/unities/${empId}`;

        const params = new URLSearchParams({ srv });
        if (ent) params.append('ent', ent);

        window.location.href = `${url}?${params.toString()}`;
    });
});
