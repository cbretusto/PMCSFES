function CreateUpdateEquipment() {
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

    let equipmentFormData = new FormData($('#formCreateUpdateEquipment')[0]);

    $.ajax({
        url: "create_update_equipment",
        method: "post",
        processData: false,
        contentType: false,
        data: equipmentFormData,
        dataType: "json",
        beforeSend: function () {
            $("#ibtnSubmitEquipmentDefIcon").removeClass('fa fa-upload')
            $("#ibtnSubmitEquipmentDefIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnSubmitEquipment").prop('disabled', 'disabled');
        },
        success: function (JsonObject) {

            $("#ibtnSubmitEquipmentDefIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnSubmitEquipment").removeAttr('disabled');
            $("#ibtnSubmitEquipmentDefIcon").addClass('fa fa-upload');

            if (JsonObject['result'] == 1) {
                $("#modalNewEquipment").modal('hide');
                $("#formCreateUpdateEquipment")[0].reset();

                $("#txtEquipmentName").removeClass('is-invalid');

                dataTableEquipmentList.draw();
                toastr.success('Request succesfully saved!');
            }else if(JsonObject['result'] == 2){
                alert('Equipment "'+$("#txtEquipmentName").val()+'" is already exist!')
            }
            else {
                toastr.error(' Saving Request Failed!');

                if (JsonObject['error']['equipment_name'] === undefined) {
                    $("#txtEquipmentName").removeClass('is-invalid');
                    $("#txtEquipmentName").attr('title', '');
                }
                else {
                    $("#txtEquipmentName").addClass('is-invalid');
                    $("#txtEquipmentName").attr('title', JsonObject['error']['equipment_name']);
                }
            }
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#ibtnSubmitEquipmentDefIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnSubmitEquipment").removeAttr('disabled');
            $("#ibtnSubmitEquipmentDefIcon").addClass('fa fa-upload');
        }
    });
}

function GetDeviceIdToEdit(deviceId,deviceFactory){
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
        url: "get_device_info_by_id",
        method: "get",
        data: {
            deviceId: deviceId,
            deviceFactory: deviceFactory
        },
        dataType: "json",
        beforeSend: function(){
        },
        success: function(response){
            let deviceInfo = response['deviceInfo'];
            let checkBox = $('.chckbx');
            if(deviceInfo.length > 0){
                $("#txtEquipmentName").val(deviceInfo[0].device_name);

                checkBox.prop('required', true)
                if(deviceInfo[0].general_area == 0 && deviceInfo[0].classification == 0){
                    checkBox.prop('required', false)
                    $("#chkNa").prop('checked', true);
                    $("#chkGeneralArea").prop('checked', false).addClass('d-none');
                    $("#chkClassification").prop('checked', false).addClass('d-none');
                    $('.chckBxLabel').addClass('crossed-out')
                }
                
                if(deviceInfo[0].general_area == 1){
                    checkBox.prop('required', false)
                    $("#chkGeneralArea").prop('checked', true);
                }
                
                if(deviceInfo[0].classification == 1){
                    checkBox.prop('required', false)
                    $("#chkClassification").prop('checked', true);
                }
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

function SelectDevice(cboElement,factory){
    let result = '<option value="">N/A</option>';
    $.ajax({
        url: "get_device",
        method: "get",
        data: {
            factory: factory,
        },
        dataType: "json",

        beforeSend: function(){
            result = '<option value="" selected disabled> -- Loading -- </option>';
            cboElement.html(result);
        },
        success: function(response){
            result = '';

            let deviceInfo = response['deviceInfo']
            if(deviceInfo.length > 0){
                result = '<option value="" selected disabled> Select Equipment </option>';
                for(let index = 0; index < deviceInfo.length; index++){
                    if(deviceInfo[index].device_info != ''){
                        result += '<option value="' + deviceInfo[index].device_id+'">'+ deviceInfo[index].device_name+'</option>';
                    }
                }
            }
            else{
                result = '<option value="0" selected disabled> No record found </option>';
            }
            cboElement.html(result);
        }
    });
}