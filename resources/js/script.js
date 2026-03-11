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



});
