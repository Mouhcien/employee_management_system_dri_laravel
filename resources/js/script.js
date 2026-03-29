$(function() {
    /**
     * core Navigation Engine
     * Dynamically builds a URL based on a base path and a map of query params to selectors.
     */
    const navigateWithFilters = (baseUrl, filterMap) => {
        const params = new URLSearchParams();

        Object.entries(filterMap).forEach(([queryParam, selector]) => {
            const val = $(selector).val();
            // Standardize exclusion: skip null, undefined, empty, or '-1'
            if (val && val !== "-1") {
                params.append(queryParam, val);
            }
        });

        const queryString = params.toString();
        const finalUrl = baseUrl + (queryString ? `?${queryString}` : '');

        // Prevent reloading if the URL hasn't changed
        if (window.location.search !== `?${queryString}`) {
            window.location.href = finalUrl;
        }
    };

    /**
     * Automatic Event Binder
     * Binds 'change' events to groups of filters.
     */
    const bindFilterGroup = (baseUrl, filterMap) => {
        const selectors = Object.values(filterMap).join(',');
        $(selectors).on('change', () => navigateWithFilters(baseUrl, filterMap));
    };

    // --- Configuration Maps ---

    const routes = {
        chefs: {
            srv: '#sl_chef_service_id',
            ent: '#sl_chef_entity_id',
            sectr: '#sl_chef_sector_id',
            sect: '#sl_chef_section_id'
        },
        employees: {
            lc: '#sl_employee_local',
            ct: '#sl_employee_city'
        },
        entities: {
            srv: '#sl_entity_service_id',
            cat: '#sl_entity_type_id'
        },
        sectors: {
            srv: '#sl_sector_service_id',
            ent: '#sl_sector_entity_id'
        },
        sections: {
            srv: '#sl_section_service_id',
            ent: '#sl_section_entity_id'
        },
        cities: {
            lc: '#sl_city_local_id'
        },
        locals: {
            cty: '#sl_local_city_id'
        }
    };

    // Initialize standard filters
    Object.entries(routes).forEach(([path, map]) => {
        bindFilterGroup(`/${path}/`, map);
    });

    // --- Special Cases & Dynamic Routes ---

    // Gender Clicks
    $('#sl_employee_male, #sl_employee_female').on('click', function() {
        const gender = $(this).attr('id') === 'sl_employee_male' ? 'ml' : 'fml';
        const filters = { ...routes.employees, gr: null }; // Base map + placeholder

        const params = new URLSearchParams();
        params.append('gr', gender);

        // Use logic from existing map to keep consistency
        if ($('#sl_employee_city').val() !== "-1") params.append('ct', $('#sl_employee_city').val());
        if ($('#sl_employee_local').val() !== "-1") params.append('lc', $('#sl_employee_local').val());

        window.location.href = `/employees/?${params.toString()}`;
    });

    // Dynamic Path Routes (Sectors/Sections via Service Change)
    $('#service_id, #sect_service_id').on('change', function() {
        const $el = $(this);
        const isSector = $el.attr('id') === 'service_id';
        const path = isSector ? 'sectors' : 'sections';
        const opt = $el.attr('opt');
        const id = $el.attr('ident');

        let url = `/${path}/${opt}`;
        if (id) url += `/${id}`;

        window.location.href = `${url}?srv=${$el.val()}`;
    });

    // Affectations
    $('#sl_aff_service_id, #sl_aff_entity_id').on('change', function() {
        const srv = $('#sl_aff_service_id').val();
        const ent = $('#sl_aff_entity_id').val();
        const empId = $(this).attr('employee_id');
        const opt = $(this).attr('opt');

        const baseUrl = (opt === 'edit')
            ? `/affectations/edit/${empId}/${$(this).attr('affectation_id')}`
            : `/employees/unities/${empId}`;

        const params = new URLSearchParams({ srv });
        if (ent && ent !== "-1") params.append('ent', ent);

        window.location.href = `${baseUrl}?${params.toString()}`;
    });

    $('#sl_table_performance').on('change', function() {

        const table_id = $(this).val();

        window.location.href = '/audit/values?tbl='+table_id;

    });

});
