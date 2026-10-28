function CreateEquipmentModel() {
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
        url: "create_equipment_model",
        method: "post",
        data: $('#formNewEquipmentModel').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#btnViewEquipmentModel").prop('disabled', 'disabled');
        },
        success: function(response){
            if(response['validationHasError'] == 1){
                toastr.error('Saving failed!');

                if(response['error']['equipment_model'] === undefined){
                    $("#txtCreateEquipmentModel").removeClass('is-invalid');
                    $("#txtCreateEquipmentModel").attr('title', '');
                }
                else{
                    $("#txtCreateEquipmentModel").addClass('is-invalid');
                    $("#txtCreateEquipmentModel").attr('title', response['error']['equipment_model']);
                }

            }else if(response['hasError'] == 1){
                $("#txtCreateEquipmentModel").val('');
                toastr.success('Succesfully saved!');
                dataTableEquipmentModel.draw();
            }else{
                alert('Equipment Model: "'+$("#txtCreateEquipmentModel").val()+'" is already exist!')
            }

            $("#btnViewEquipmentModel").removeAttr('disabled');
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#btnViewEquipmentModel").removeAttr('disabled');
        }
    });
}

function GetEquipmentModelIdToEdit(equipmentModelID){
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
        url: "get_equipment_model_info_by_id",
        method: "get",
        data: {
            equipmentModelID: equipmentModelID
        },
        dataType: "json",
        beforeSend: function(){
        },
        success: function(response){
            let equipmentModelInfo = response['equipmentModelInfo'];

            if(equipmentModelInfo.length > 0){
                $("#txtUpdateEquipmentModel").val(equipmentModelInfo[0].equipment_model);
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

function UpdateEquipmentModel() {
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
        url: "update_equipment_model",
        method: "post",
        data: $('#formUpdateEquipmentModel').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#ibtnSubmitEquipmentModelIcon").addClass('spinner-border spinner-border-sm')
            $("#btnSubmitEquipmentModel").addClass('disabled')
            $("#ibtnSubmitEquipmentModelIcon").removeClass('fa fa-check')        
        },
        success: function(response){
            if(response['validationHasError'] == 1){
                toastr.error('Saving failed!');

                if(response['error']['equipment_model'] === undefined){
                    $("#txtUpdateEquipmentModel").removeClass('is-invalid');
                    $("#txtUpdateEquipmentModel").attr('title', '');
                }
                else{
                    $("#txtUpdateEquipmentModel").addClass('is-invalid');
                    $("#txtUpdateEquipmentModel").attr('title', response['error']['equipment_model']);
                }

            }else if(response['hasError'] == 1){
                $("#formUpdateEquipmentModel")[0].reset();
                $("#modalUpdateEquipmentModel").modal('hide')
                toastr.success('Succesfully saved!');
                dataTableEquipmentModel.draw();
            }else{
                alert('Equipment Model: "'+$("#txtUpdateEquipmentModel").val()+'" is already exist!')
            }

            $("#ibtnSubmitEquipmentModelIcon").removeClass('spinner-border spinner-border-sm')
            $("#btnSubmitEquipmentModel").removeClass('disabled')
            $("#ibtnSubmitEquipmentModelIcon").addClass('fa fa-check')
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#ibtnSubmitEquipmentModelIcon").removeClass('spinner-border spinner-border-sm')
            $("#btnSubmitEquipmentModel").removeClass('disabled')
            $("#ibtnSubmitEquipmentModelIcon").addClass('fa fa-check')
        }
    });
}

function ChangeEquipmentModelStatus(){
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
        url: "change_equipment_model_status",
        method: "post",
        data: $('#formChangeEquipmentModelStatus').serialize(),
        dataType: "json",
        beforeSend: function(){
            $("#iBtnChangeEquipmentModelStatusIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnChangeEquipmentModelStatus").prop('disabled', 'disabled');
        },
        success: function(response){

            if(response['validation'] == 'hasError'){
                toastr.error('Equipment Model activation failed!');
            }else{
                if(response['result'] == 1){
                    if($("#txtChangeEquipmentModelStatus").val() == 1){
                        toastr.success('Equipment Model activation success!');
                        $("#txtChangeEquipmentModelStatus").val() == 2;
                    }else{
                        toastr.success('Equipment Model deactivation success!');
                        $("#txtChangeEquipmentModelStatus").val() == 1;
                    }
                }
                $("#formChangeEquipmentModelStatus")[0].reset();
                $("#modalChangeEquipmentModelStatus").modal('hide');
                dataTableEquipmentModel.draw();
            }

            $("#iBtnChangeEquipmentModelStatusIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnChangeEquipmentModelStatus").removeAttr('disabled');
            $("#iBtnChangeEquipmentModelStatusIcon").addClass('fa fa-check');
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#iBtnChangeEquipmentModelStatusIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnChangeEquipmentModelStatus").removeAttr('disabled');
            $("#iBtnChangeEquipmentModelStatusIcon").addClass('fa fa-check');
        }
    });
}

function GetEquipmentModel(cboElement,deviceID){
    let result = '<option value="">N/A</option>';
    $.ajax({
        url: "get_equipment_model",
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

            let equipmentModelInfo = response['equipmentModelInfo']
            if(equipmentModelInfo.length > 0){
                result = '<option value="" selected disabled> --- Select Equipment Model --- </option>';
                for(let index = 0; index < equipmentModelInfo.length; index++){
                    result += '<option value="' + equipmentModelInfo[index].equipment_model+'">'+ equipmentModelInfo[index].equipment_model+'</option>';
                }
            }
            else{
                result = '<option value="0" selected disabled> No record found </option>';
            }
            cboElement.html(result);
        }
    });
}

