$(function() {
    /**
     * core Navigation Engine
     * Dynamically builds a URL based on a base path and a map of query params to selectors.
     */
    const navigateWithFilters = (baseUrl, filterMap, extraParams = {}) => {
        const params = new URLSearchParams();

        // 1. Process the standard filter map
        Object.entries(filterMap).forEach(([queryParam, selector]) => {
            const $el = $(selector);
            if ($el.length) {
                const val = $el.val();
                // Standardize exclusion: skip null, undefined, empty, or '-1'
                if (val && val !== "-1") {
                    params.append(queryParam, val);
                }
            }
        });

        // 2. Process extra manual parameters
        Object.entries(extraParams).forEach(([key, val]) => {
            if (val && val !== "-1") params.append(key, val);
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
     */
    const bindFilterGroup = (baseUrl, filterMap, eventType = 'change') => {
        const selectors = Object.values(filterMap).join(',');
        $(document).on(eventType, selectors, () => navigateWithFilters(baseUrl, filterMap));
    };

    // --- Route Configurations ---
    const routes = {
        'chefs':    { srv: '#sl_chef_service_id', ent: '#sl_chef_entity_id', sectr: '#sl_chef_sector_id', sect: '#sl_chef_section_id' },
        'employees': { lc: '#sl_employee_local', ct: '#sl_employee_city' },
        'entities':  { srv: '#sl_entity_service_id', cat: '#sl_entity_type_id' },
        'sectors':   { srv: '#sl_sector_service_id', ent: '#sl_sector_entity_id' },
        'sections':  { srv: '#sl_section_service_id', ent: '#sl_section_entity_id' },
        'cities':    { lc: '#sl_city_local_id' },
        'locals':    { cty: '#sl_local_city_id' },
        // Audit & Consult Sections (Merged logic)
        'audit/values': {
            tbl: '#sl_table_performance', srv: '#sl_audit_service', ent: '#sl_audit_entity',
            sectr: '#sl_audit_sector', sect: '#sl_audit_section'
        },
        'audit/values/consult': {
            tbl: '#sl_consult_table_performance', perd: '#sl_consult_period', emp: '#employee_list_consult',
            srv: '#sl_consult_audit_service', ent: '#sl_consult_audit_entity',
            sectr: '#sl_consult_audit_sector', sect: '#sl_consult_audit_section'
        }
    };

    // Initialize all standard routes
    Object.entries(routes).forEach(([path, map]) => {
        const event = path.includes('consult') ? 'change click' : 'change';
        bindFilterGroup(`/${path}`, map, event);
    });

    // --- Special Dynamic Cases ---

    // 1. Gender Selection (Employees)
    $('#sl_employee_male, #sl_employee_female').on('click', function() {
        const gender = $(this).attr('id') === 'sl_employee_male' ? 'ml' : 'fml';
        navigateWithFilters('/employees/', routes.employees, { gr: gender });
    });

    // 2. Path-Shifting Routes (Sectors/Sections via Service Change)
    $('#service_id, #sect_service_id').on('change', function() {
        const $el = $(this);
        const path = $el.attr('id') === 'service_id' ? 'sectors' : 'sections';
        const opt = $el.attr('opt') || '';
        const id = $el.attr('ident') ? `/${$el.attr('ident')}` : '';

        const baseUrl = `/${path}/${opt}${id}`;
        navigateWithFilters(baseUrl, {}, { srv: $el.val() });
    });

    // 3. Affectations (Complex Base URL logic)
    $('#sl_aff_service_id, #sl_aff_entity_id').on('change', function() {
        const $el = $(this);
        const empId = $el.attr('employee_id');
        const opt = $el.attr('opt');

        const baseUrl = (opt === 'edit')
            ? `/affectations/edit/${empId}/${$el.attr('affectation_id')}`
            : `/employees/unities/${empId}`;

        navigateWithFilters(baseUrl, { srv: '#sl_aff_service_id', ent: '#sl_aff_entity_id' });
    });

    /**********************************/
    $('#sl_audit_view_service').on('change', function() {

        let href = '/audit/values/select?';

        const srv = $(this).val();
        if (srv != '-1' && srv != undefined) {
            href += 'srv='+srv;
        }

        window.location.href = href;

    });

    $('#sl_audit_view_entity').on('change', function() {

        let href = '/audit/values/select?';

        const ent = $(this).val();

        if (ent != '-1' && ent != undefined) {
            href += 'ent='+ent;
        }

        const srv = $('#sl_audit_view_service').val();
        if (srv != '-1' && srv != undefined) {
            href += '&srv='+srv;
        }

        const sectr = $('#sl_audit_view_sector').val();
        if (sectr != '-1' && sectr != undefined) {
            href += '&sectr='+sectr;
        }

        const sect = $('#sl_audit_view_section').val();
        if (sect != '-1' && sect != undefined) {
            href += '&sect=' + sect;
        }

        window.location.href = href;

    });

    $('#sl_audit_view_sector').on('change', function() {

        let href = '/audit/values/select?';

        const sectr = $(this).val();
        if (sectr != '-1' && sectr != undefined) {
            href += 'sectr='+sectr;
        }

        const srv = $('#sl_audit_view_service').val();
        if (srv != '-1' && srv != undefined) {
            href += '&srv='+srv;
        }

        const ent = $('#sl_audit_view_entity').val();
        if (ent != '-1' && ent != undefined) {
            href += '&ent='+ent;
        }

        window.location.href = href;

    });

    $('#sl_audit_view_section').on('change', function() {

        let href = '/audit/values/select?';

        const sect = $(this).val();
        if (sect != '-1' && sect != undefined) {
            href += 'sect='+sect;
        }

        const srv = $('#sl_audit_view_service').val();
        if (srv != '-1' && srv != undefined) {
            href += '&srv='+srv;
        }

        const ent = $('#sl_audit_view_entity').val();
        if (ent != '-1' && ent != undefined) {
            href += '&ent='+ent;
        }

        window.location.href = href;

    });


});
