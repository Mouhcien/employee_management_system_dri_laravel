$(function() {
    $("#service_id").on('change', function () {
        const srv = $(this).val();
        const option = $(this).attr('opt');
        const id = $(this).attr('ident');
        window.location.href = '/sectors/'+option+'/'+id+'?srv='+srv;
    });

    $("#sect_service_id").on('change', function () {
        const srv = $(this).val();
        const option = $(this).attr('opt');
        const id = $(this).attr('ident');
        if (option == 'edit') {
            window.location.href = '/sections/'+option+'/'+id+'?srv='+srv;
        }else{
            window.location.href = '/sections/'+option+'?srv='+srv;
        }

    });

    $("#sl_aff_service_id").on('change', function () {
        const srv = $(this).val();
        const option = $(this).attr('opt');
        const employee_id = $(this).attr('employee_id');

        if (option == 'edit'){
            const affectation_id = $(this).attr('affectation_id');
            window.location.href = '/affectations/'+option+'/'+employee_id+'/'+affectation_id+'/?srv='+srv;
        }else
            window.location.href = '/employees/unities/'+employee_id+'?srv='+srv;
    });

    $("#sl_aff_entity_id").on('change', function () {
        const srv = $("#sl_aff_service_id").val();
        const ent = $(this).val();
        const option = $(this).attr('opt');
        const employee_id = $(this).attr('employee_id');

        if (option == 'edit'){
            const affectation_id = $(this).attr('affectation_id');
            window.location.href = '/affectations/'+option+'/'+employee_id+'/'+affectation_id+'/?srv='+srv+'&ent='+ent;
        }else
            window.location.href = '/employees/unities/'+employee_id+'?srv='+srv+'&ent='+ent;
    });

    $("#sl_employee_local").on('change', function () {
        let href = '/employees/?';
        const local = $(this).val();
        if (local != '-1') {
            href += 'lc='+local;
        }

        const city =  $("#sl_employee_city").val();
        if (city != '-1') {
            href += '&ct='+city;
        }
        window.location.href = href;
    });

    $("#sl_employee_city").on('change', function () {
        let href = '/employees/?';
        const city = $(this).val();
        if (city != '-1') {
            href += 'ct='+city;
        }

        const local =  $("#sl_employee_local").val();
        if (local != '-1') {
            href += '&lc='+local;
        }
        window.location.href = href;
    });

    $("#sl_employee_male").on('click', function () {
        let href = '/employees/?';

        href += 'gr=ml';

        const city = $(this).val();
        if (city != '-1') {
            href += '&ct='+city;
        }

        const local =  $("#sl_employee_local").val();
        if (local != '-1') {
            href += '&lc='+local;
        }
        window.location.href = href;
    });

    $("#sl_employee_female").on('click', function () {
        let href = '/employees/?';

        href += 'gr=fml';

        const city = $("#sl_employee_city").val();
        if (city != '-1') {
            href += '&ct='+city;
        }

        const local =  $("#sl_employee_local").val();
        if (local != '-1') {
            href += '&lc='+local;
        }
        window.location.href = href;
    });

    // Chef part
    $("#sl_chef_service_id").on('change', function () {
        let href = '/chefs/?';
        const srv = $(this).val();
        if (srv != '-1') {
            href += 'srv='+srv;
        }

        const ent = $("#sl_chef_entity_id").val();
        if (ent != '-1') {
            href += '&ent='+ent;
        }

        const sectr = $("#sl_chef_sector_id").val();
        if (sectr != '-1') {
            href += '&sectr='+sectr;
        }

        const sect = $("#sl_chef_section_id").val();
        if (sect != '-1') {
            href += '&sect='+sect;
        }

        window.location.href = href;
    });

    $("#sl_chef_entity_id").on('change', function () {
        let href = '/chefs/?';
        const ent = $(this).val();
        if (ent != '-1') {
            href += 'ent='+ent;
        }

        const srv = $('#sl_chef_service_id').val();
        if (srv != '-1') {
            href += '&srv='+srv;
        }

        const sectr = $("#sl_chef_sector_id").val();
        if (sectr != '-1') {
            href += '&sectr='+sectr;
        }

        const sect = $("#sl_chef_section_id").val();
        if (sect != '-1') {
            href += '&sect='+sect;
        }

        window.location.href = href;
    });

    $("#sl_chef_section_id").on('change', function () {
        let href = '/chefs/?';
        const sect = $(this).val();
        if (sect != '-1') {
            href += 'sect='+sect;
        }

        const srv = $('#sl_chef_service_id').val();
        if (srv != '-1') {
            href += '&srv='+srv;
        }

        const ent = $("#sl_chef_entity_id").val();
        if (ent != '-1') {
            href += '&ent='+ent;
        }

        const sectr = $("#sl_chef_sector_id").val();
        if (sectr != '-1') {
            href += '&sectr='+sectr;
        }

        window.location.href = href;
    });

    $("#sl_chef_sector_id").on('change', function () {
        let href = '/chefs/?';
        const sectr = $(this).val();
        if (sectr != '-1') {
            href += 'sectr='+sectr;
        }

        const srv = $('#sl_chef_service_id').val();
        if (srv != '-1') {
            href += '&srv='+srv;
        }

        const ent = $("#sl_chef_entity_id").val();
        if (ent != '-1') {
            href += '&ent='+ent;
        }

        const sect = $("#sl_chef_section_id").val();
        if (sect != '-1') {
            href += '&sect='+sect;
        }

        window.location.href = href;
    });

    $("#sl_chef_sector_id").on('change', function () {
        let href = '/chefs/?';
        const sectr = $(this).val();
        if (sectr != '-1') {
            href += 'sectr='+sectr;
        }

        const srv = $('#sl_chef_service_id').val();
        if (srv != '-1') {
            href += '&srv='+srv;
        }

        const ent = $("#sl_chef_entity_id").val();
        if (ent != '-1') {
            href += '&ent='+ent;
        }

        const sect = $("#sl_chef_section_id").val();
        if (sect != '-1') {
            href += '&sect='+sect;
        }

        window.location.href = href;
    });

    $("#sl_entity_service_id").on('change', function () {
        let href = '/entities/?';
        const srv = $(this).val();
        if (srv != '-1') {
            href += 'srv='+srv;
        }

        const cat = $('#sl_entity_type_id').val();
        if (cat != '-1') {
            href += '&cat='+cat;
        }

        window.location.href = href;
    });

    $("#sl_entity_type_id").on('change', function () {
        let href = '/entities/?';
        const cat = $(this).val();
        if (cat != '-1') {
            href += 'cat='+cat;
        }

        const srv = $('#sl_entity_service_id').val();
        if (srv != '-1') {
            href += '&srv='+srv;
        }

        window.location.href = href;
    });


});
