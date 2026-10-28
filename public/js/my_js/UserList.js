function GetEmployeeName(cboElement){
    let result = '<option value="">N/A</option>';

    $.ajax({
        url: "get_employee_name",
        method: "get",
        dataType: "json",

        beforeSend: function(){
            result = '<option value="" selected disabled> -- Loading -- </option>';
            cboElement.html(result);
        },
        success: function(response){
            result = '';

            if(response['get_employee_name'].length > 0){
                result = '<option selected value="" disabled> --- Select Employee Name --- </option>';
                for(let index = 0; index < response['get_employee_name'].length; index++){
                    result += '<option value="' + response['get_employee_name'][index].id+'">'+ response['get_employee_name'][index].name+'</option>';
                }
            }
            else{
                result = '<option value="0" selected disabled> No record found </option>';
            }
            cboElement.html(result);
        }
    });
}

function CreateUpdateUser(){
	$.ajax({
        url: "create_update_user",
        method: "post",
        data: $('#formCreateUpdateUser').serialize(),
        dataType: "json",
        beforeSend: function(){
            $("#iBtnCreateUpdateUserIcon").addClass('spinner-border spinner-border-sm');
            $("#btnCreateUpdateUser").addClass('disabled');
            $("#iBtnCreateUpdateUserIcon").removeClass('fa fa-check');
        },
        success: function(response){
            if(response['validationHasError'] == 1){
                toastr.error('Saving user failed!');

                if(response['error']['rapidx_employee_name'] === undefined){
                    $("#selectRapidxEmployeeName").removeClass('is-invalid');
                    $("#selectRapidxEmployeeName").attr('title', '');
                }
                else{
                    $("#selectRapidxEmployeeName").addClass('is-invalid');
                    $("#selectRapidxEmployeeName").attr('title', response['error']['rapidx_employee_name']);
                }

                if(response['error']['classification'] === undefined){
                    $("#selectClassification").removeClass('is-invalid');
                    $("#selectClassification").attr('title', '');
                }
                else{
                    $("#selectClassification").addClass('is-invalid');
                    $("#selectClassification").attr('title', response['error']['classification']);
                }

                if(response['error']['category'] === undefined){
                    $("#selectCategory").removeClass('is-invalid');
                    $("#selectCategory").attr('title', '');
                }
                else{
                    $("#selectCategory").addClass('is-invalid');
                    $("#selectCategory").attr('title', response['error']['category']);
                }
            }else if(response['hasError'] == 0){
                // $("#formCreateUpdateUser")[0].reset();
                $('#modalCreateUpdateUser').modal('hide');
                toastr.success('Succesfully saved!');
                dataTableUserList.draw();
            }else{
                alert('The User is already exist!')
            }

            $("#iBtnCreateUpdateUserIcon").removeClass('spinner-border spinner-border-sm');
            $("#btnCreateUpdateUser").removeClass('disabled');
            $("#iBtnCreateUpdateUserIcon").addClass('fa fa-check');
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}

function GetUserInfoByIdToEdit(UserId){
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "3000",
        "timeOut": "3000",
        "extendedTimeOut": "3000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
    };

    $.ajax({
        url: "get_user_info_by_id",
        method: "get",
        data: {
            UserId: UserId
        },
        dataType: "json",
        beforeSend: function(){
        },
        success: function(response){
            let userInfo = response['user_info'];

            if(userInfo.length > 0){
                $("#selectRapidxEmployeeName").val(userInfo[0].rapidx_user_info.id).trigger('change');
                $("#selectClassification").val(userInfo[0].classification).trigger('change');
                $("#selectCategory").val(userInfo[0].category).trigger('change');

            }
            else{
                toastr.warning('No Record Found!');
            }
        },

        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}

function ChangeUserStatus(){
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "3000",
        "timeOut": "3000",
        "extendedTimeOut": "3000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
    };

    $.ajax({
        url: "change_user_status",
        method: "post",
        data: $('#formChangeUserStatus').serialize(),
        dataType: "json",
        beforeSend: function(){
            $("#iBtnChangeUserStatusIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnChangeUserStatus").prop('disabled', 'disabled');
        },
        success: function(response){

            if(response['validation'] == 'hasError'){
                toastr.error('User activation failed!');
            }else{
                if(response['result'] == 1){
                    if($("#txtChangeUserStatus").val() == 1){
                        toastr.success('User activation success!');
                        $("#txtChangeUserStatus").val() == 2;
                    }else{
                        toastr.success('User deactivation success!');
                        $("#txtChangeUserStatus").val() == 1;
                    }
                }
                $("#modalChangeUserStatus").modal('hide');
                $("#formChangeUserStatus")[0].reset();
                dataTableUserList.draw();
            }


            $("#iBtnChangeUserStatusIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnChangeUserStatus").removeAttr('disabled');
            $("#iBtnChangeUserStatusIcon").addClass('fa fa-check');
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#iBtnChangeUserStatusIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnChangeUserStatus").removeAttr('disabled');
            $("#iBtnChangeUserStatusIcon").addClass('fa fa-check');
        }
    });
}

function GetNotedBy(srSupervisor, manager, factory) {
    let resultSrSupervisor;
    let resultManager;
    let resultLoading = '<option value="" selected disabled> -- Loading -- </option>';
    let resultApprover = '<option value="" selected disabled> --- Select Approver --- </option>';
    let resultNoRecordFound = '<option value="" selected disabled> No record found </option>';

    $.ajax({
        url: "get_noted_by",
        method: "get",
        data: {
            factory: factory,
        },
        dataType: "json",

        beforeSend: function () {
            resultSrSupervisor = resultLoading;
            srSupervisor.html(resultSrSupervisor);

            resultManager = resultLoading;
            manager.html(resultManager);
        },
        success: function (response) {
            let notedByInfo = response['notedByInfo'];
            let srSupervisorCount = 0;
            let managerCount = 0;

            if (notedByInfo.length > 0) {
                resultSrSupervisor = resultApprover;
                resultManager = resultApprover;

                for (let index = 0; index < notedByInfo.length; index++) {
                    let result = '<option value="' + notedByInfo[index].rapidx_user_id + '">' + notedByInfo[index]['rapidx_user_info'].name + '</option>';

                    if (notedByInfo[index].classification == '1') {
                        console.log('1: ', notedByInfo[index].classification);
                        resultSrSupervisor += result;
                        srSupervisorCount++;
                    }

                    if (notedByInfo[index].classification == '2') {
                        console.log('2: ', notedByInfo[index].classification);
                        resultManager += result;
                        managerCount++;
                    }
                }

                if (srSupervisorCount == 1) {
                    resultSrSupervisor =    
                        resultApprover + '<option selected value="' + 
                        notedByInfo.find(filteredSrSupervisorResult => filteredSrSupervisorResult.classification == '1').rapidx_user_id + '">' + 
                        notedByInfo.find(filteredSrSupervisorResult => filteredSrSupervisorResult.classification == '1')['rapidx_user_info'].name + '</option>';
                }
                if (managerCount == 1) {
                    resultManager = 
                        resultApprover + '<option selected value="' + 
                        notedByInfo.find(filteredManagerResult => filteredManagerResult.classification == '2').rapidx_user_id + '">' + 
                        notedByInfo.find(filteredManagerResult => filteredManagerResult.classification == '2')['rapidx_user_info'].name + '</option>';
                }
            } else {
                resultSrSupervisor = resultNoRecordFound;
                resultManager = resultNoRecordFound;
            }

            srSupervisor.html(resultSrSupervisor);
            manager.html(resultManager);
        }
    });
}
