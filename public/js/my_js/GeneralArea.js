function CreateGeneralArea() {
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
        url: "create_general_area",
        method: "post",
        data: $('#formNewGeneralArea').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#btnViewGeneralArea").prop('disabled', 'disabled');
        },
        success: function(response){
            if(response['validationHasError'] == 1){
                toastr.error('Saving failed!');

                if(response['error']['general_area'] === undefined){
                    $("#txtCreateGeneralArea").removeClass('is-invalid');
                    $("#txtCreateGeneralArea").attr('title', '');
                }
                else{
                    $("#txtCreateGeneralArea").addClass('is-invalid');
                    $("#txtCreateGeneralArea").attr('title', response['error']['general_area']);
                }

            }else if(response['hasError'] == 1){
                $("#txtCreateGeneralArea").val('');
                toastr.success('Succesfully saved!');
                dataTableGeneralArea.draw();
            }else{
                alert('General Area: "'+$("#txtCreateGeneralArea").val()+'" is already exist!')
            }

            $("#btnViewGeneralArea").removeAttr('disabled');
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#btnViewGeneralArea").removeAttr('disabled');
        }
    });
}

function GetGeneralAreaIdToEdit(generalAreaID){
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
        url: "get_general_area_info_by_id",
        method: "get",
        data: {
            generalAreaID: generalAreaID
        },
        dataType: "json",
        beforeSend: function(){
        },
        success: function(response){
            let generalAreaInfo = response['generalAreaInfo'];
            if(generalAreaInfo.length > 0){
                $("#txtUpdateGeneralArea").val(generalAreaInfo[0].general_area);
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

function UpdateGeneralArea() {
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
        url: "update_general_area",
        method: "post",
        data: $('#formUpdateGeneralArea').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#ibtnSubmitGeneralAreaIcon").addClass('spinner-border spinner-border-sm')
            $("#btnSubmitGeneralArea").addClass('disabled')
            $("#ibtnSubmitGeneralAreaIcon").removeClass('fa fa-check')        
        },
        success: function(response){
            if(response['validationHasError'] == 1){
                toastr.error('Saving failed!');

                if(response['error']['general_area'] === undefined){
                    $("#txtUpdateGeneralArea").removeClass('is-invalid');
                    $("#txtUpdateGeneralArea").attr('title', '');
                }
                else{
                    $("#txtUpdateGeneralArea").addClass('is-invalid');
                    $("#txtUpdateGeneralArea").attr('title', response['error']['general_area']);
                }

            }else if(response['hasError'] == 1){
                $("#formUpdateGeneralArea")[0].reset();
                $("#modalUpdateGeneralArea").modal('hide')
                toastr.success('Succesfully saved!');
                dataTableGeneralArea.draw();
            }else{
                alert('General Area: "'+$("#txtUpdateGeneralArea").val()+'" is already exist!')
            }

            $("#ibtnSubmitGeneralAreaIcon").removeClass('spinner-border spinner-border-sm')
            $("#btnSubmitGeneralArea").removeClass('disabled')
            $("#ibtnSubmitGeneralAreaIcon").addClass('fa fa-check')
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#ibtnSubmitGeneralAreaIcon").removeClass('spinner-border spinner-border-sm')
            $("#btnSubmitGeneralArea").removeClass('disabled')
            $("#ibtnSubmitGeneralAreaIcon").addClass('fa fa-check')
        }
    });
}

function ChangeGeneralAreaStatus(){
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
        url: "change_general_area_status",
        method: "post",
        data: $('#formChangeGeneralAreaStatus').serialize(),
        dataType: "json",
        beforeSend: function(){
            $("#iBtnChangeGeneralAreaStatusIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnChangeGeneralAreaStatus").prop('disabled', 'disabled');
        },
        success: function(response){

            if(response['validation'] == 'hasError'){
                toastr.error('General Area activation failed!');
            }else{
                if(response['result'] == 1){
                    if($("#txtChangeGeneralAreaStatus").val() == 1){
                        toastr.success('General Area activation success!');
                        $("#txtChangeGeneralAreaStatus").val() == 2;
                    }else{
                        toastr.success('General Area deactivation success!');
                        $("#txtChangeGeneralAreaStatus").val() == 1;
                    }
                }
                $("#formChangeGeneralAreaStatus")[0].reset();
                $("#modalChangeGeneralAreaStatus").modal('hide');
                dataTableGeneralArea.draw();
            }

            $("#iBtnChangeGeneralAreaStatusIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnChangeGeneralAreaStatus").removeAttr('disabled');
            $("#iBtnChangeGeneralAreaStatusIcon").addClass('fa fa-check');
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#iBtnChangeGeneralAreaStatusIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnChangeGeneralAreaStatus").removeAttr('disabled');
            $("#iBtnChangeGeneralAreaStatusIcon").addClass('fa fa-check');
        }
    });
}

function GetGeneralArea(cboElement,deviceID){
    let result = '<option value="">N/A</option>';
    $.ajax({
        url: "get_general_area",
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

            let generalAreaInfo = response['generalAreaInfo']
            if(generalAreaInfo.length > 0){
                result = '<option value="" selected disabled> Select General Area </option>';
                for(let index = 0; index < generalAreaInfo.length; index++){
                    result += '<option value="' + generalAreaInfo[index].id+'">'+ generalAreaInfo[index].general_area+'</option>';
                }
            }
            else{
                result = '<option value="0" selected disabled> No record found </option>';
            }
            cboElement.html(result);
        }
    });
}

// function CreateUpdateGeneralArea() {
//     toastr.options = {
//         "closeButton": false,
//         "debug": false,
//         "newestOnTop": true,
//         "progressBar": true,
//         "positionClass": "toast-top-right",
//         "preventDuplicates": false,
//         "onclick": null,
//         "showDuration": "300",
//         "hideDuration": "3000",
//         "timeOut": "3000",
//         "extendedTimeOut": "3000",
//         "showEasing": "swing",
//         "hideEasing": "linear",
//         "showMethod": "fadeIn",
//         "hideMethod": "fadeOut",
//     };

//     $.ajax({
//         url: "create_update_general_area",
//         method: "post",
//         data: $('#formGeneralArea').serialize(),
//         dataType: "json",
//         beforeSend: function () {
//             $("#iBtnGeneralAreaIcon").addClass('fa fa-spinner fa-pulse');
//             $("#btnGeneralArea").prop('disabled', 'disabled');
//         },
//         success: function(response){
//             if(response['validationHasError'] == 1){
//                 toastr.error('Saving failed!');

//                 if(response['error']['general_area'] === undefined){
//                     $("#txtGeneralArea").removeClass('is-invalid');
//                     $("#txtGeneralArea").attr('title', '');
//                 }else{
//                     $("#txtGeneralArea").addClass('is-invalid');
//                     $("#txtGeneralArea").attr('title', response['error']['general_area']);
//                 }

//                 if(response['error']['control_number'] === undefined){
//                     $("#txtControlNumber").removeClass('is-invalid');
//                     $("#txtControlNumber").attr('title', '');
//                 }else{
//                     $("#txtControlNumber").addClass('is-invalid');
//                     $("#txtControlNumber").attr('title', response['error']['control_number']);
//                 }

//                 if(response['error']['location'] === undefined){
//                     $("#txtLocation").removeClass('is-invalid');
//                     $("#txtLocation").attr('title', '');
//                 }else{
//                     $("#txtLocation").addClass('is-invalid');
//                     $("#txtLocation").attr('title', response['error']['location']);
//                 }

//             }else if(response['hasError'] == 1){
//                 $("#formGeneralArea")[0].reset();
//                 $("#modalCheckList").modal('hide');
//                 toastr.success('Succesfully saved!');
//                 dataTableGeneralArea.draw();
//             }

//             $("#iBtnGeneralAreaIcon").removeClass('fa fa-spinner fa-pulse');
//             $("#btnGeneralArea").removeAttr('disabled');
//             $("#iBtnGeneralAreaIcon").addClass('fa fa-check');
//         },
//         error: function (data, xhr, status) {
//             toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
//             $("#iBtnGeneralAreaIcon").removeClass('fa fa-spinner fa-pulse');
//             $("#btnGeneralArea").removeAttr('disabled');
//             $("#iBtnGeneralAreaIcon").addClass('fa fa-check');
//         }
//     });
// }

// function GetGeneralAreaIdToEdit1(generalAreaID){
//     toastr.options = {
//         "closeButton": false,
//         "debug": false,
//         "newestOnTop": true,
//         "progressBar": true,
//         "positionClass": "toast-top-right",
//         "preventDuplicates": false,
//         "onclick": null,
//         "showDuration": "300",
//         "hideDuration": "3000",
//         "timeOut": "3000",
//         "extendedTimeOut": "3000",
//         "showEasing": "swing",
//         "hideEasing": "linear",
//         "showMethod": "fadeIn",
//         "hideMethod": "fadeOut",
//     };

//     $.ajax({
//         url: "get_general_area_info_by_id1",
//         method: "get",
//         data: {
//             generalAreaID: generalAreaID
//         },
//         dataType: "json",
//         beforeSend: function(){
//         },
//         success: function(response){
//             let generalAreaInfo = response['generalAreaInfo'];

//             if(generalAreaInfo.length > 0){
//                 $("#txtRequirement").val(generalAreaInfo[0].requirement);
//                 $("#txtGeneralArea").val(generalAreaInfo[0].general_area);
//                 $("#txtControlNumber").val(generalAreaInfo[0].control_no);
//                 $("#txtLocation").val(generalAreaInfo[0].location);

//                 $('.general_area-footer').removeClass('d-none')
//             }
//             else{
//                 $('.general_area-footer').addClass('d-none')
//                 toastr.warning('No Record Found!');
//             }
//         },

//         error: function(data, xhr, status){
//             toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
//         }
//     });
// }


