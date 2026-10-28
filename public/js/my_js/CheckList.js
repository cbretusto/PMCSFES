function CreateUpdateChecklist() {
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
        url: "create_update_checklist",
        method: "post",
        data: $('#formChecklist').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#iBtnChecklistIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnChecklist").prop('disabled', 'disabled');
        },
        success: function(response){
            if(response['validationHasError'] == 1){
                toastr.error('Saving failed!');

                if(response['error']['checklist'] === undefined){
                    $("#txtChecklist").removeClass('is-invalid');
                    $("#txtChecklist").attr('title', '');
                }else{
                    $("#txtChecklist").addClass('is-invalid');
                    $("#txtChecklist").attr('title', response['error']['checklist']);
                }

                if(response['error']['requirement'] === undefined){
                    $("#txtRequirement").removeClass('is-invalid');
                    $("#txtRequirement").attr('title', '');
                }else{
                    $("#txtRequirement").addClass('is-invalid');
                    $("#txtRequirement").attr('title', response['error']['requirement']);
                }

            }else if(response['hasError'] == 1){
                $("#formChecklist")[0].reset();
                $("#modalCheckList").modal('hide');
                toastr.success('Succesfully saved!');
                dataTableChecklist.draw();
            }

            $("#iBtnChecklistIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnChecklist").removeAttr('disabled');
            $("#iBtnChecklistIcon").addClass('fa fa-check');
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#iBtnChecklistIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnChecklist").removeAttr('disabled');
            $("#iBtnChecklistIcon").addClass('fa fa-check');
        }
    });
}

function GetChecklistIdToEdit(checklistID){
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
        url: "get_checklist_info_by_id",
        method: "get",
        data: {
            checklistID: checklistID
        },
        dataType: "json",
        beforeSend: function(){
        },
        success: function(response){
            let checklistInfo = response['checklistInfo'];

            if(checklistInfo.length > 0){
                $("#txtChecklist").val(checklistInfo[0].checklist);
                $("#txtRequirement").val(checklistInfo[0].requirement);
                $("#txtGeneralArea").val(checklistInfo[0].general_area);
                $("#txtControlNumber").val(checklistInfo[0].control_no);
                $("#txtClassification").val(checklistInfo[0].classification);
                $("#txtLocation").val(checklistInfo[0].location);
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

function ChangeChecklistStatus(){
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
        url: "change_checklist_status",
        method: "post",
        data: $('#formChangeChecklistStatus').serialize(),
        dataType: "json",
        beforeSend: function(){
            $("#iBtnChangeChecklistStatusIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnChangeChecklistStatus").prop('disabled', 'disabled');
        },
        success: function(response){

            if(response['validation'] == 'hasError'){
                toastr.error('Equipment Model activation failed!');
            }else{
                if(response['result'] == 1){
                    if($("#txtChangeChecklistStatus").val() == 1){
                        toastr.success('Equipment Model activation success!');
                        $("#txtChangeChecklistStatus").val() == 2;
                    }else{
                        toastr.success('Equipment Model deactivation success!');
                        $("#txtChangeChecklistStatus").val() == 1;
                    }
                }
                $("#formChangeChecklistStatus")[0].reset();
                $("#modalChangeChecklistStatus").modal('hide');
                dataTableChecklist.draw();
            }

            $("#iBtnChangeChecklistStatusIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnChangeChecklistStatus").removeAttr('disabled');
            $("#iBtnChangeChecklistStatusIcon").addClass('fa fa-check');
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#iBtnChangeChecklistStatusIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnChangeChecklistStatus").removeAttr('disabled');
            $("#iBtnChangeChecklistStatusIcon").addClass('fa fa-check');
        }
    });
}

function GetChecklist(cboElement,deviceID){
    let result = '<option value="">N/A</option>';
    $.ajax({
        url: "get_checklist",
        method: "get",
        data: {
            deviceID: deviceID,
        },
        dataType: "json",

        beforeSend: function(){
            result = '<option value="" selected disabled> -- Loading -- </option>';
            cboElement.html(result);
        },
        success: function(response){
            result = '';

            let checklistInfo = response['checklistInfo']
            if(checklistInfo.length > 0){
                result = '<option value="" selected disabled> Select Checklist </option>';
                for(let index = 0; index < checklistInfo.length; index++){
                    result += '<option value="' + checklistInfo[index].checklist+'">'+ checklistInfo[index].checklist+'</option>';
                }
            }
            else{
                result = '<option value="0" selected disabled> No record found </option>';
            }
            cboElement.html(result);
        }
    });
}

function GetChecklistRequirement(deviceID, checklistName){
    $.ajax({
        url: "get_checklist",
        method: "get",
        data: {
            deviceID: deviceID,
            checklistName: checklistName
        },
        dataType: "json",

        beforeSend: function(){
        },
        success: function(response){
            let checklistInfo = response['checklistInfo']
            if(checklistInfo.length > 0){
                for(let index = 0; index < checklistInfo.length; index++){
                    if(checklistInfo[index].checklist == checklistName){
                        $('#txtRequirement').val(checklistInfo[index].requirement)
                    }
                }
            }
        }
    });
}

