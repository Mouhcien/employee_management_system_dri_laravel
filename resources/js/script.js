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
        window.location.href = '/sections/'+option+'/'+id+'?srv='+srv;
    });

    /*

    $("#sl_entity_id").on('change', function () {
        const srv = $("#sl_service_id").val();
        const ent = $("#sl_entity_id").val();
        window.location.href = '/distributions/create?srv='+srv+'&ent='+ent;
    });

    $("#sl_section_entity_id").on('change', function () {
        const srv = $("#sl_service_id").val();
        const ent = $("#sl_entity_id").val();
        const sect = $("#sl_section_entity_id").val();
        window.location.href = '/distributions/create?srv='+srv+'&ent='+ent+'&sect='+sect;
    });

    $("#sl_secter_entity_id").on('change', function () {
        const srv = $("#sl_service_id").val();
        const ent = $("#sl_entity_id").val();
        const sectr = $("#sl_secter_entity_id").val();
        window.location.href = '/distributions/create?srv='+srv+'&ent='+ent+'&sectr='+sectr;
    });

    $("#sl_product_id").on('change', function () {
        const emp = $("#txt_employee_id").val();
        const art = $("#sl_product_id").val();
        window.location.href = '/distributions/create2/'+emp+'/?art='+art;
    });



    $("#sl_edit_service_id").on('change', function () {
        const srv = $("#sl_edit_service_id").val();
        const distribution_id = $("#sl_distribution_id").val();
        window.location.href = '/distributions/edit/'+distribution_id+'?srv='+srv;
    });

    $("#sl_edit_entity_id").on('change', function () {
        const srv = $("#sl_edit_service_id").val();
        const ent = $("#sl_edit_entity_id").val();
        const distribution_id = $("#sl_distribution_id").val();
        window.location.href = '/distributions/edit/'+distribution_id+'?srv='+srv+'&ent='+ent;
    });

    $("#sl_edit_section_entity_id").on('change', function () {
        const srv = $("#sl_edit_service_id").val();
        const ent = $("#sl_edit_entity_id").val();
        const sect = $("#sl_edit_section_entity_id").val();
        const distribution_id = $("#sl_distribution_id").val();
        window.location.href = '/distributions/edit/'+distribution_id+'?srv='+srv+'&ent='+ent+'&sect='+sect;
    });

    $("#sl_edit_secter_entity_id").on('change', function () {
        const srv = $("#sl_edit_service_id").val();
        const ent = $("#sl_edit_entity_id").val();
        const sectr = $("#sl_edit_secter_entity_id").val();
        const distribution_id = $("#sl_distribution_id").val();
        window.location.href = '/distributions/edit/'+distribution_id+'?srv='+srv+'&ent='+ent+'&sectr='+sectr;
    });

    $(".sl_edit_distribution_employee").on('click', function () {

        const distribution_id = $("#sl_distribution_id").val();
        let url = '/distributions/edit/'+distribution_id;

        const employee = $(this).attr('val');
        if (employee != "undefined") {
            url += "?emp="+employee;
        }

        window.location.href = url;
    });

    $("#sl_edit_product_id").on('change', function () {
        const distribution_id = $("#sl_distribution_id").val();
        const art = $("#sl_edit_product_id").val();
        window.location.href = '/distributions/edit/'+distribution_id+'/?art='+art;
    });


    $("#sl_brand_id_2").on('change', function () {
        let url = "/products/?";

        const brand = $("#sl_brand_id_2").val();
        if (brand != -1) {
            url += 'brd='+brand;
        }

        const unity = $("#sl_unity_id_2").val();
        if (unity != -1) {
            url += '&unt='+unity;
        }

        window.location.href = url;
    });

    $("#sl_unity_id_2").on('change', function () {
        let url = "/products/?";

        const unity = $("#sl_unity_id_2").val();
        if (unity != -1) {
            url += 'unt='+unity;
        }

        const brand = $("#sl_brand_id_2").val();
        if (brand != -1) {
            url += '&brd='+brand;
        }
        window.location.href = url;
    });



    $("#sl_type_id_1").on('change', function () {
        let url = "/contracts/?";

        const type = $("#sl_type_id_1").val();
        if (type != -1) {
            url += 'typ='+type;
        }

        const year = $("#sl_year_id_1").val();
        if (year != -1) {
            url += '&yr='+year;
        }

        window.location.href = url;
    });


    $("#sl_company_id_1").on('change', function () {
        let url = "/deliveries/?";

        const company = $("#sl_company_id_1").val();
        if (company != -1) {
            url += 'cp='+company;
        }

        const type = $("#sl_type_id_11").val();
        if (type != -1) {
            url += '&typ='+type;
        }

        const contract = $("#sl_contract_id_1").val();
        if (contract != -1) {
            url += '&ctr='+contract;
        }

        const ctr_valid = $("#sl_delivery_valid_id_1").val();
        if (ctr_valid != -1) {
            url += '&vld='+ctr_valid;
        }

        window.location.href = url;
    });

    $("#sl_type_id_11").on('change', function () {
        let url = "/deliveries/?";

        const type = $("#sl_type_id_11").val();
        if (type != -1) {
            url += 'typ='+type;
        }

        const company = $("#sl_company_id_1").val();
        if (company != -1) {
            url += '&cp='+company;
        }

        const contract = $("#sl_contract_id_1").val();
        if (contract != -1) {
            url += '&ctr='+contract;
        }

        const ctr_valid = $("#sl_delivery_valid_id_1").val();
        if (ctr_valid != -1) {
            url += '&vld='+ctr_valid;
        }

        window.location.href = url;
    });

    $("#sl_contract_id_1").on('change', function () {
        let url = "/deliveries/?";

        const contract = $("#sl_contract_id_1").val();
        if (contract != -1) {
            url += 'ctr='+contract;
        }

        const type = $("#sl_type_id_11").val();
        if (type != -1) {
            url += '&typ='+type;
        }

        const company = $("#sl_company_id_1").val();
        if (company != -1) {
            url += '&cp='+company;
        }

        const ctr_valid = $("#sl_delivery_valid_id_1").val();
        if (ctr_valid != -1) {
            url += '&vld='+ctr_valid;
        }

        window.location.href = url;
    });

    $("#sl_delivery_valid_id_1").on('change', function () {
        let url = "/deliveries/?";

        const ctr_valid = $("#sl_delivery_valid_id_1").val();
        if (ctr_valid != -1) {
            url += 'vld='+ctr_valid;
        }

        const contract = $("#sl_contract_id_1").val();
        if (contract != -1) {
            url += '&ctr='+contract;
        }

        const type = $("#sl_type_id_11").val();
        if (type != -1) {
            url += '&typ='+type;
        }

        const company = $("#sl_company_id_1").val();
        if (company != -1) {
            url += '&cp='+company;
        }

        window.location.href = url;
    });

    $("#sl_category_id_22").on('change', function () {
        let url  = $("#txt_url_22").val();


        const prd = $("#sl_product_id_22").val();
        if (prd != -1) {
            url += '&prd='+prd;
        }

        window.location.href = url;
    });

    $("#sl_product_id_22").on('change', function () {
        let url  = $("#txt_url_22").val();

        const prd = $("#sl_product_id_22").val();
        if (prd != -1) {
            url += 'prd='+prd;
        }

        const cat = $("#sl_category_id_22").val();
        if (cat != -1) {
            url += '&cat='+cat;
        }

        const ctr = $("#sl_contract_id").val();
        if (ctr != -1) {
            url += '&ctr='+ctr;
        }

        window.location.href = url;
    });

    $("#sl_contract_id").on('change', function () {
        let url  = $("#txt_url_22").val();

        const ctr = $("#sl_contract_id").val();
        if (ctr != -1) {
            url += 'ctr='+ctr;
        }

        const prd = $("#sl_product_id_22").val();
        if (prd != -1) {
            url += '&prd='+prd;
        }

        const cat = $("#sl_category_id_22").val();
        if (cat != -1) {
            url += '&cat='+cat;
        }

        window.location.href = url;
    });

    $("#sl_product_id_33").on('change', function () {
        let url  = '/distributions/?';

        const prd = $("#sl_product_id_33").val();
        if (prd != -1) {
            url += 'prd='+prd;
        }

        const srv = $("#sl_service_id_11").val();
        if (srv != -1) {
            url += '&srv='+srv;
        }

        const ent = $("#sl_entity_id_11").val();
        if (ent != -1) {
            url += '&ent='+ent;
        }

        const sectr = $("#sl_secter_id_11").val();
        if (sectr != -1) {
            url += '&sectr='+sectr;
        }

        const sect = $("#sl_section_id_11").val();
        if (sect != -1) {
            url += '&sect='+sect;
        }

        const emp = $("#sl_employee_id_11").val();
        if (emp != -1) {
            url += '&emp='+emp;
        }

        window.location.href = url;
    });

    $("#sl_service_id_11").on('change', function () {
        let url  = '/distributions/?';

        const srv = $("#sl_service_id_11").val();
        if (srv != -1) {
            url += 'srv='+srv;
        }

        const prd = $("#sl_product_id_33").val();
        if (prd != -1) {
            url += '&prd='+prd;
        }

        const ent = $("#sl_entity_id_11").val();
        if (ent != -1) {
            url += '&ent='+ent;
        }

        const sectr = $("#sl_secter_id_11").val();
        if (sectr != -1) {
            url += '&sectr='+sectr;
        }

        const sect = $("#sl_section_id_11").val();
        if (sect != -1) {
            url += '&sect='+sect;
        }

        const emp = $("#sl_employee_id_11").val();
        if (emp != -1) {
            url += '&emp='+emp;
        }

        window.location.href = url;
    });

    $("#sl_entity_id_11").on('change', function () {
        let url  = '/distributions/?';

        const ent = $("#sl_entity_id_11").val();
        if (ent != -1) {
            url += 'ent='+ent;
        }

        const srv = $("#sl_service_id_11").val();
        if (srv != -1) {
            url += '&srv='+srv;
        }

        const prd = $("#sl_product_id_33").val();
        if (prd != -1) {
            url += '&prd='+prd;
        }

        const sectr = $("#sl_secter_id_11").val();
        if (sectr != -1) {
            url += '&sectr='+sectr;
        }

        const sect = $("#sl_section_id_11").val();
        if (sect != -1) {
            url += '&sect='+sect;
        }

        const emp = $("#sl_employee_id_11").val();
        if (emp != -1) {
            url += '&emp='+emp;
        }

        window.location.href = url;
    });

    $("#sl_secter_id_11").on('change', function () {
        let url  = '/distributions/?';

        const sectr = $("#sl_secter_id_11").val();
        if (sectr != -1) {
            url += 'sectr='+sectr;
        }

        const ent = $("#sl_entity_id_11").val();
        if (ent != -1) {
            url += '&ent='+ent;
        }

        const srv = $("#sl_service_id_11").val();
        if (srv != -1) {
            url += '&srv='+srv;
        }

        const prd = $("#sl_product_id_33").val();
        if (prd != -1) {
            url += '&prd='+prd;
        }

        const sect = $("#sl_section_id_11").val();
        if (sect != -1) {
            url += '&sect='+sect;
        }

        const emp = $("#sl_employee_id_11").val();
        if (emp != -1) {
            url += '&emp='+emp;
        }

        window.location.href = url;
    });

    $("#sl_section_id_11").on('change', function () {
        let url  = '/distributions/?';

        const sect = $("#sl_section_id_11").val();
        if (sect != -1) {
            url += 'sect='+sect;
        }

        const sectr = $("#sl_secter_id_11").val();
        if (sectr != -1) {
            url += '&sectr='+sectr;
        }

        const ent = $("#sl_entity_id_11").val();
        if (ent != -1) {
            url += '&ent='+ent;
        }

        const srv = $("#sl_service_id_11").val();
        if (srv != -1) {
            url += '&srv='+srv;
        }

        const prd = $("#sl_product_id_33").val();
        if (prd != -1) {
            url += '&prd='+prd;
        }

        const emp = $("#sl_employee_id_11").val();
        if (emp != -1) {
            url += '&emp='+emp;
        }

        window.location.href = url;
    });

    $("#sl_employee_id_11").on('change', function () {
        let url  = '/distributions/?';

        const emp = $("#sl_employee_id_11").val();
        if (emp != -1) {
            url += 'emp='+emp;
        }

        const sect = $("#sl_section_id_11").val();
        if (sect != -1) {
            url += '&sect='+sect;
        }

        const sectr = $("#sl_secter_id_11").val();
        if (sectr != -1) {
            url += '&sectr='+sectr;
        }

        const ent = $("#sl_entity_id_11").val();
        if (ent != -1) {
            url += '&ent='+ent;
        }

        const srv = $("#sl_service_id_11").val();
        if (srv != -1) {
            url += '&srv='+srv;
        }

        const prd = $("#sl_product_id_33").val();
        if (prd != -1) {
            url += '&prd='+prd;
        }

        window.location.href = url;
    });

    $("#select-all").on('change', function () {

        $('.child-checkbox').prop('checked', $(this).prop('checked'));

        $('.child-checkbox').prop('checked', function () {
            if (!$('#select-all').prop('checked')) {
                $('.child-checkbox').prop('checked', false);
            }else{
                const allChecked = $('.child-checkbox:checked').length === $('.child-checkbox').length;
                $('#select-all').prop('checked', allChecked);
            }
        });

    });
    */

});
