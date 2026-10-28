function CreateUpdateControlNoLocation() {
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
        url: "create_update_control_no_location",
        method: "post",
        data: $('#formCreateUpdateControlNoLocation').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#iBtnViewControlNoLocationIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnViewControlNoLocation").prop('disabled', 'disabled');
        },
        success: function(response){
            if(response['validationHasError'] == 1){
                toastr.error('Saving failed!');

                if(response['error']['control_no'] === undefined){
                    $("#txtControlNumber").removeClass('is-invalid');
                    $("#txtControlNumber").attr('title', '');
                }else{
                    $("#txtControlNumber").addClass('is-invalid');
                    $("#txtControlNumber").attr('title', response['error']['control_no']);
                }

                if(response['error']['location'] === undefined){
                    $("#txtLocation").removeClass('is-invalid');
                    $("#txtLocation").attr('title', '');
                }else{
                    $("#txtLocation").addClass('is-invalid');
                    $("#txtLocation").attr('title', response['error']['location']);
                }

            }else if(response['hasError'] == 1){
                $(".reset-value").val('');
                toastr.success('Succesfully saved!');
                dataTableControlNoLocation.draw();
            }

            $("#iBtnViewControlNoLocationIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnViewControlNoLocation").removeAttr('disabled');
            $("#iBtnViewControlNoLocationIcon").addClass('fa fa-check');
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#iBtnViewControlNoLocationIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnViewControlNoLocation").removeAttr('disabled');
            $("#iBtnViewControlNoLocationIcon").addClass('fa fa-check');
        }
    });
}

function GetControlNoLocationIdToEdit(controlNoLocationID){
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
        url: "get_control_no_location_info_by_id",
        method: "get",
        data: {
            controlNoLocationID: controlNoLocationID
        },
        dataType: "json",
        beforeSend: function(){
        },
        success: function(response){
            let controlNoLocationInfo = response['controlNoLocationInfo'];
            if(controlNoLocationInfo.length > 0){
                $("#txtControlNumber").val(controlNoLocationInfo[0].control_no);
                $("#txtLocation").val(controlNoLocationInfo[0].location);
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

function ChangeControlNoLocationStatus(){
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
        url: "change_control_no_location_status",
        method: "post",
        data: $('#formChangeControlNoLocationStatus').serialize(),
        dataType: "json",
        beforeSend: function(){
            $("#iBtnChangeControlNoLocationStatusIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnChangeControlNoLocationStatus").prop('disabled', 'disabled');
        },
        success: function(response){

            if(response['validation'] == 'hasError'){
                toastr.error('Control No. and Location activation failed!');
            }else{
                if(response['result'] == 1){
                    if($("#txtChangeControlNoLocationStatus").val() == 1){
                        toastr.success('Control No. and Location activation success!');
                        $("#txtChangeControlNoLocationStatus").val() == 2;
                    }else{
                        toastr.success('Control No. and Location deactivation success!');
                        $("#txtChangeControlNoLocationStatus").val() == 1;
                    }
                }
                $("#formChangeControlNoLocationStatus")[0].reset();
                $("#modalChangeControlNoLocationStatus").modal('hide');
                dataTableControlNoLocation.draw();
            }

            $("#iBtnChangeControlNoLocationStatusIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnChangeControlNoLocationStatus").removeAttr('disabled');
            $("#iBtnChangeControlNoLocationStatusIcon").addClass('fa fa-check');
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#iBtnChangeControlNoLocationStatusIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnChangeControlNoLocationStatus").removeAttr('disabled');
            $("#iBtnChangeControlNoLocationStatusIcon").addClass('fa fa-check');
        }
    });
}

function autoInsert() {
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
        url: "auto_insert",
        method: "post",
        data: $('#formCreateUpdateControlNoLocation').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#iBtnViewControlNoLocationIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnViewControlNoLocation").prop('disabled', 'disabled');
        },
        success: function(response){
            if(response['validationHasError'] == 1){
                toastr.error('Saving failed!');

                if(response['error']['control_no'] === undefined){
                    $("#txtControlNumber").removeClass('is-invalid');
                    $("#txtControlNumber").attr('title', '');
                }else{
                    $("#txtControlNumber").addClass('is-invalid');
                    $("#txtControlNumber").attr('title', response['error']['control_no']);
                }

                if(response['error']['location'] === undefined){
                    $("#txtLocation").removeClass('is-invalid');
                    $("#txtLocation").attr('title', '');
                }else{
                    $("#txtLocation").addClass('is-invalid');
                    $("#txtLocation").attr('title', response['error']['location']);
                }

            }else if(response['hasError'] == 1){
                $(".reset-value").val('');
                toastr.success('Succesfully saved!');
                dataTableControlNoLocation.draw();
            }

            $("#iBtnViewControlNoLocationIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnViewControlNoLocation").removeAttr('disabled');
            $("#iBtnViewControlNoLocationIcon").addClass('fa fa-check');
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#iBtnViewControlNoLocationIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnViewControlNoLocation").removeAttr('disabled');
            $("#iBtnViewControlNoLocationIcon").addClass('fa fa-check');
        }
    });
}

function GetControlNo(cboElement,generalAreaID){
    let result = '<option value="">N/A</option>';
    $.ajax({
        url: "get_control_no_location",
        method: "get",
        data: {
            generalAreaID: generalAreaID,
        },
        dataType: "json",

        beforeSend: function(){
            result = '<option value="" selected disabled> -- Loading -- </option>';
            cboElement.html(result);
        },
        success: function(response){
            result = '';

            let controlNoLocationInfo = response['controlNoLocationInfo']
            if(controlNoLocationInfo.length > 0){
                result = '<option value="" selected disabled> Select Control No. </option>';
                for(let index = 0; index < controlNoLocationInfo.length; index++){
                    result += '<option value="' + controlNoLocationInfo[index].control_no+'">'+ controlNoLocationInfo[index].control_no+'</option>';
                }
            }
            else{
                result = '<option value="0" selected disabled> No record found </option>';
            }
            cboElement.html(result);
        }
    });
}
function GetGeneralAreaLocation(generalAreaID, controlNoLocation){
    $.ajax({
        url: "get_control_no_location",
        method: "get",
        data: {
            generalAreaID: generalAreaID,
            controlNoLocation: controlNoLocation
        },
        dataType: "json",

        beforeSend: function(){
        },
        success: function(response){
            let controlNoLocationInfo = response['controlNoLocationInfo']
            console.log('object: ', controlNoLocationInfo);
            if(controlNoLocationInfo.length > 0){
                for(let index = 0; index < controlNoLocationInfo.length; index++){
                    if(controlNoLocationInfo[index].control_no == controlNoLocation){
                        $('.getLocation').val(controlNoLocationInfo[index].location)
                    }
                }
            }
        }
    });
}

function SelectGeneralAreaLocation(cboElement,generalAreaID){
    let result = '<option value="">N/A</option>';
    $.ajax({
        url: "get_control_no_location",
        method: "get",
        data: {
            generalAreaID: generalAreaID,
        },
        dataType: "json",

        beforeSend: function(){
            result = '<option value="" selected disabled> -- Loading -- </option>';
            cboElement.html(result);
        },
        success: function(response){
            result = '';

            let controlNoLocationInfo = response['controlNoLocationInfo']
            if(controlNoLocationInfo.length > 0){
                result = '<option value="" selected disabled> Select Control No. </option>';
                for(let index = 0; index < controlNoLocationInfo.length; index++){
                    if(controlNoLocationInfo[index].general_area_id == generalAreaID){
                        result += '<option value="' + controlNoLocationInfo[index].location+'">'+ controlNoLocationInfo[index].location+'</option>';
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
