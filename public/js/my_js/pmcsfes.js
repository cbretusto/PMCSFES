// // Add Equipment
// function AddEquipment() {
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

//     let form_data = new FormData($('#formCreateUpdateEquipment')[0]);

//     $.ajax({
//         url: "create_update_equipment",
//         method: "post",
//         processData: false,
//         contentType: false,
//         data: form_data,
//         dataType: "json",
//         beforeSend: function () {
//             $("#ibtnSubmitEquipmentDefIcon").removeClass('fa fa-upload')
//             $("#ibtnSubmitEquipmentDefIcon").addClass('fa fa-spinner fa-pulse');
//             $("#btnSubmitEquipment").prop('disabled', 'disabled');
//         },
//         success: function (JsonObject) {

//             $("#ibtnSubmitEquipmentDefIcon").removeClass('fa fa-spinner fa-pulse');
//             $("#btnSubmitEquipment").removeAttr('disabled');
//             $("#ibtnSubmitEquipmentDefIcon").addClass('fa fa-upload');

//             if (JsonObject['result'] == 1) {
//                 $("#modalNewEquipment").modal('hide');
//                 $("#formCreateUpdateEquipment")[0].reset();

//                 $("#txtEquipmentName").removeClass('is-invalid');

//                 dt_equipments.draw();
//                 toastr.success('Request succesfully saved!');
//             }else if(JsonObject['result'] == 2){
//                 alert('Equipment "'+$("#txtEquipmentName").val()+'" is already exist!')
//             }
//             else {
//                 toastr.error(' Saving Request Failed!');

//                 if (JsonObject['error']['equipment_name'] === undefined) {
//                     $("#txtEquipmentName").removeClass('is-invalid');
//                     $("#txtEquipmentName").attr('title', '');
//                 }
//                 else {
//                     $("#txtEquipmentName").addClass('is-invalid');
//                     $("#txtEquipmentName").attr('title', JsonObject['error']['equipment_name']);
//                 }
//             }
//         },
//         error: function (data, xhr, status) {
//             toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
//             $("#ibtnSubmitEquipmentDefIcon").removeClass('fa fa-spinner fa-pulse');
//             $("#btnSubmitEquipment").removeAttr('disabled');
//             $("#ibtnSubmitEquipmentDefIcon").addClass('fa fa-upload');
//         }
//     });
// }

// View Request
function GetDevicesById(deviceId) {
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
        url: "get_device_by_id",
        method: "get",
        data: {
            device_id: deviceId
        },
        dataType: "json",
        beforeSend: function () {
            $("#txtDeviceId").val("");
            $("#txtDevice").val("");


            $("#txtDeviceId").removeClass('is-invalid');
            $("#txtDevice").removeClass('is-invalid');

        },
        success: function (JsonObject) {

            let result = JsonObject['device'];

            if (JsonObject['result'] == 1) {
                $("#txtDeviceId").val(result[0].device_id);
                $("#txtDevice").val(result[0].device_name);
                dt_pending_checksheets.draw();
                dt_approval_checksheets.draw();
                dt_approved_checksheets.draw();
            }
            else {
                toastr.error('Error Loading Data!');
            }
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}

// Add Checksheet
function AddCheckSheet() {
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

    let form_data = new FormData($('#formViewChecksheets')[0]);

    $.ajax({
        url: "add_checksheet",
        method: "post",
        processData: false,
        contentType: false,
        data: form_data,
        dataType: "json",
        beforeSend: function () {
            $("#ibtnSubmitCSIcon").removeClass('fa fa-upload')
            $("#ibtnSubmitCSIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnSubmitCS").prop('disabled', 'disabled');
        },
        success: function (JsonObject) {

            $("#ibtnSubmitCSIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnSubmitCS").removeAttr('disabled');
            $("#ibtnSubmitCSIcon").addClass('fa fa-upload');

            if (JsonObject['result'] == 1) {

                $("#txtDateInspected").removeClass('is-invalid');

                dt_pending_checksheets.draw();
                toastr.success('Checksheet succesfully saved!');
            }
            else {
                toastr.error(' Saving Checksheet Failed!');

                if (JsonObject['error']['equipment_model'] === undefined) {
                    $("#slctEquipmentModel").removeClass('is-invalid');
                    $("#slctEquipmentModel").attr('title', '');
                }
                else {
                    $("#slctEquipmentModel").addClass('is-invalid');
                    $("#slctEquipmentModel").attr('title', JsonObject['error']['equipment_model']);
                }

                if (JsonObject['error']['date_inspected'] === undefined) {
                    $("#txtDateInspected").removeClass('is-invalid');
                    $("#txtDateInspected").attr('title', '');
                }
                else {
                    $("#txtDateInspected").addClass('is-invalid');
                    $("#txtDateInspected").attr('title', JsonObject['error']['date_inspected']);
                }
            }
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#ibtnSubmitCSIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnSubmitCS").removeAttr('disabled');
            $("#ibtnSubmitCSIcon").addClass('fa fa-upload');
        }
    });
}

function GetChecksheetsById(checksheetId) {
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
        url: "get_checksheet_by_id",
        method: "get",
        data: {
            checksheet_id: checksheetId
        },
        dataType: "json",
        beforeSend: function () {
            $("#txtChecksheetId").val("");
            $("#txtChecksheetName").val("");
            $("#txtDateInspectedCS").val("");


            $("#txtChecksheetId").removeClass('is-invalid');
            $("#txtChecksheetName").removeClass('is-invalid');
            $("#txtDateInspectedCS").removeClass('is-invalid');

        },
        success: function (JsonObject) {

            let result = JsonObject['checksheet'];

            if (JsonObject['result'] == 1) {
                $("#txtChecksheetId").val(result[0].checksheet_id);
                $("#txtChecksheetName").val(result[0].checksheet_name);
                $("#txtDateInspectedCS").val(result[0].date_inspected);
                dt_criteria.draw();
            }
            else {
                toastr.error('Error Loading Data!');
            }
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}

function GetELChecksheetById(el_checksheetId) {
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
        url: "get_checksheet_by_id",
        method: "get",
        data: {
            checksheet_id: el_checksheetId
        },
        dataType: "json",
        beforeSend: function () {
            $("#txtChecksheetIdEL").val("");
            $("#txtChecksheetNameEL").val("");
            $("#txtDateInspectedCSEL").val("");


            $("#txtChecksheetIdEL").removeClass('is-invalid');
            $("#txtChecksheetNameEL").removeClass('is-invalid');
            $("#txtDateInspectedCSEL").removeClass('is-invalid');

        },
        success: function (JsonObject) {

            let result = JsonObject['checksheet'];

            if (JsonObject['result'] == 1) {
                $("#txtChecksheetIdEL").val(result[0].checksheet_id);
                $("#txtChecksheetNameEL").val(result[0].checksheet_name);
                $("#txtDateInspectedCSEL").val(result[0].date_inspected);
                dt_criteria_el.draw();
            }
            else {
                toastr.error('Error Loading Data!');
            }
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}

function GetEXLChecksheetById(exl_checksheetId) {
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
        url: "get_checksheet_by_id",
        method: "get",
        data: {
            checksheet_id: exl_checksheetId
        },
        dataType: "json",
        beforeSend: function () {
            $("#txtChecksheetIdEXL").val("");
            $("#txtChecksheetNameEXL").val("");
            $("#txtDateInspectedCSEXL").val("");


            $("#txtChecksheetIdEXL").removeClass('is-invalid');
            $("#txtChecksheetNameEXL").removeClass('is-invalid');
            $("#txtDateInspectedCSEXL").removeClass('is-invalid');

        },
        success: function (JsonObject) {

            let result = JsonObject['checksheet'];

            if (JsonObject['result'] == 1) {
                $("#txtChecksheetIdEXL").val(result[0].checksheet_id);
                $("#txtChecksheetNameEXL").val(result[0].checksheet_name);
                $("#txtDateInspectedCSEXL").val(result[0].date_inspected);
                dt_criteria_exl.draw();
            }
            else {
                toastr.error('Error Loading Data!');
            }
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}

function GetFEChecksheetById(fe_checksheetId) {
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
        url: "get_checksheet_by_id",
        method: "get",
        data: {
            checksheet_id: fe_checksheetId
        },
        dataType: "json",
        beforeSend: function () {
            $("#txtChecksheetIdFE").val("");
            $("#txtChecksheetNameFE").val("");
            $("#txtDateInspectedCSFE").val("");


            $("#txtChecksheetIdFE").removeClass('is-invalid');
            $("#txtChecksheetNameFE").removeClass('is-invalid');
            $("#txtDateInspectedCSFE").removeClass('is-invalid');

        },
        success: function (JsonObject) {

            let result = JsonObject['checksheet'];

            if (JsonObject['result'] == 1) {
                $("#txtChecksheetIdFE").val(result[0].checksheet_id);
                $("#txtChecksheetNameFE").val(result[0].checksheet_name);
                $("#txtDateInspectedCSFE").val(result[0].date_inspected);
                dt_criteria_fe.draw();
            }
            else {
                toastr.error('Error Loading Data!');
            }
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}

function GetFHChecksheetById(fh_checksheetId) {
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
        url: "get_checksheet_by_id",
        method: "get",
        data: {
            checksheet_id: fh_checksheetId
        },
        dataType: "json",
        beforeSend: function () {
            $("#txtChecksheetIdFH").val("");
            $("#txtChecksheetNameFH").val("");
            $("#txtDateInspectedCSFH").val("");


            $("#txtChecksheetIdFH").removeClass('is-invalid');
            $("#txtChecksheetNameFH").removeClass('is-invalid');
            $("#txtDateInspectedCSFH").removeClass('is-invalid');

        },
        success: function (JsonObject) {

            let result = JsonObject['checksheet'];

            if (JsonObject['result'] == 1) {
                $("#txtChecksheetIdFH").val(result[0].checksheet_id);
                $("#txtChecksheetNameFH").val(result[0].checksheet_name);
                $("#txtDateInspectedCSFH").val(result[0].date_inspected);
                dt_criteria_fh.draw();
            }
            else {
                toastr.error('Error Loading Data!');
            }
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}
// Add Maintenance Result
function AddMaintenanceResult() {
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

    let form_data = new FormData($('#formViewCriteria')[0]);

    $.ajax({
        url: "add_maintenance_result",
        method: "post",
        processData: false,
        contentType: false,
        data: form_data,
        dataType: "json",
        beforeSend: function () {
            $("#ibtnSubmitCRIcon").removeClass('fa fa-upload')
            $("#ibtnSubmitCRIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnSubmitCR").prop('disabled', 'disabled');
        },
        success: function (JsonObject) {

            $("#ibtnSubmitCRIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnSubmitCR").removeAttr('disabled');
            $("#ibtnSubmitCRIcon").addClass('fa fa-upload');

            if (JsonObject['result'] == 1) {
                $("#slctEquipmentTemplate").removeClass('is-invalid');
                $("#slctChecklist").removeClass('is-invalid');
                $("#txtRequirement").removeClass('is-invalid');
                $("#txtRemarks").removeClass('is-invalid');

                dt_criteria.draw();
                dt_pending_checksheets.draw();
                toastr.success('Maintenance Result Succesfully Saved!');

                $('.criteria-reset-value').val('')
                $('.uncheck').prop('checked', false)
            }
            else {
                toastr.error('Saving Maintenance Result Failed!');
                if (JsonObject['error']['equipment_template'] === undefined) {
                    $("#slctEquipmentTemplate").removeClass('is-invalid');
                    $("#slctEquipmentTemplate").attr('title', '');
                }
                else {
                    $("#slctEquipmentTemplate").addClass('is-invalid');
                    $("#slctEquipmentTemplate").attr('title', JsonObject['error']['equipment_template']);
                }

                if (JsonObject['error']['checklist'] === undefined) {
                    $("#slctChecklist").removeClass('is-invalid');
                    $("#slctChecklist").attr('title', '');
                }
                else {
                    $("#slctChecklist").addClass('is-invalid');
                    $("#slctChecklist").attr('title', JsonObject['error']['checklist']);
                }

                if (JsonObject['error']['requirement'] === undefined) {
                    $("#txtRequirement").removeClass('is-invalid');
                    $("#txtRequirement").attr('title', '');
                }
                else {
                    $("#txtRequirement").addClass('is-invalid');
                    $("#txtRequirement").attr('title', JsonObject['error']['requirement']);
                }
                if (JsonObject['error']['remarks'] === undefined) {
                    $("#txtRemarks").removeClass('is-invalid');
                    $("#txtRemarks").attr('title', '');
                }
                else {
                    $("#txtRemarks").addClass('is-invalid');
                    $("#txtRemarks").attr('title', JsonObject['error']['remarks']);
                }
            }
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#ibtnSubmitCRIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnSubmitCR").removeAttr('disabled');
            $("#ibtnSubmitCRIcon").addClass('fa fa-upload');
        }
    });
}


// var form = document.getElementById('formViewCriteria');
// if(form != null){
//     form.elements.checklist.onchange = function () {
//         var form = this.form;
    
//         if(chklistTempValues[this.value] != undefined){ // CHAN - 01-20-25 - NEW
//             form.elements.requirement.value = chklistTempValues[this.value];
//         }else{
//             form.elements.requirement.value = ''
//         }
//         // form.elements.requirement.value = chklistTempValues[this.value]; // CHAN - 01-20-25 - OLD
//     };
// }


// Add Maintenance Result Emergency Light
function AddChecksheetFindings() {
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

    let form_data = new FormData($('#formViewELCriteria')[0]);

    $.ajax({
        url: "add_checksheet_findings_el",
        method: "post",
        processData: false,
        contentType: false,
        data: form_data,
        dataType: "json",
        beforeSend: function () {
            $("#ibtnSubmitCRELIcon").removeClass('fa fa-upload')
            $("#ibtnSubmitCRELIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnSubmitCREL").prop('disabled', 'disabled');
        },
        success: function (JsonObject) {

            $("#ibtnSubmitCRELIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnSubmitCREL").removeAttr('disabled');
            $("#ibtnSubmitCRELIcon").addClass('fa fa-upload');

            if (JsonObject['result'] == 1) {
                $("#slctEquipmentModel").removeClass('is-invalid');
                $("#slctEquipmentModel").val('');

                $("#slctGeneralAreaEL").removeClass('is-invalid');
                $("#slctControlNumberEL").removeClass('is-invalid');
                $("#txtLocationEL").removeClass('is-invalid');
                $("#txtRemarksEL").removeClass('is-invalid');

                dt_criteria_el.draw();
                dt_pending_checksheets.draw();
                toastr.success('Findings Succesfully Saved!');
            }
            else {
                toastr.error('Saving findings Failed!');
                if (JsonObject['error']['general_area_el'] === undefined) {
                    $("#slctGeneralAreaEL").removeClass('is-invalid');
                    $("#slctGeneralAreaEL").attr('title', '');
                }
                else {
                    $("#slctGeneralAreaEL").addClass('is-invalid');
                    $("#slctGeneralAreaEL").attr('title', JsonObject['error']['general_area_el']);
                }

                if (JsonObject['error']['control_number_el'] === undefined) {
                    $("#slctControlNumberEL").removeClass('is-invalid');
                    $("#slctControlNumberEL").attr('title', '');
                }
                else {
                    $("#slctControlNumberEL").addClass('is-invalid');
                    $("#slctControlNumberEL").attr('title', JsonObject['error']['control_number_el']);
                }

                if (JsonObject['error']['location_el'] === undefined) {
                    $("#txtLocationEL").removeClass('is-invalid');
                    $("#txtLocationEL").attr('title', '');
                }
                else {
                    $("#txtLocationEL").addClass('is-invalid');
                    $("#txtLocationEL").attr('title', JsonObject['error']['location_el']);
                }
                if (JsonObject['error']['remarks_el'] === undefined) {
                    $("#txtRemarksEL").removeClass('is-invalid');
                    $("#txtRemarksEL").attr('title', '');
                }
                else {
                    $("#txtRemarksEL").addClass('is-invalid');
                    $("#txtRemarksEL").attr('title', JsonObject['error']['remarks_el']);
                }
            }
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#ibtnSubmitCRELIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnSubmitCR").removeAttr('disabled');
            $("#ibtnSubmitCRELIcon").addClass('fa fa-upload');
        }
    });
}

// var form = document.getElementById('formViewELCriteria');
// if(form != null){
//     form.elements.control_number_el.onchange = function () {
//         var form = this.form;
//         if(chklistTempValuesFacEqpt[this.value] != undefined){ // CHAN - 01-20-25 - NEW
//             form.elements.location_el.value = chklistTempValuesFacEqpt[this.value];
//         }else{
//             form.elements.location_el.value = ''
//         }
    
//         // form.elements.location_el.value = chklistTempValuesFacEqpt[this.value]; // CHAN - 01-20-25 - OLD
//     };
// }


// Add Maintenance Result Exit Light
function AddChecksheetFindingsEXL() {
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

    let form_data = new FormData($('#formViewEXLCriteria')[0]);

    $.ajax({
        url: "add_checksheet_findings_exl",
        method: "post",
        processData: false,
        contentType: false,
        data: form_data,
        dataType: "json",
        beforeSend: function () {
            $("#ibtnSubmitCREXLIcon").removeClass('fa fa-upload')
            $("#ibtnSubmitCREXLIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnSubmitCREXL").prop('disabled', 'disabled');
        },
        success: function (JsonObject) {

            $("#ibtnSubmitCREXLIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnSubmitCREXL").removeAttr('disabled');
            $("#ibtnSubmitCREXLIcon").addClass('fa fa-upload');

            if (JsonObject['result'] == 1) {

                $("#slctLocationEXL").removeClass('is-invalid');
                $("#txtRemarksEXL").removeClass('is-invalid');

                dt_criteria_exl.draw();
                dt_pending_checksheets.draw();
                toastr.success('Findings Succesfully Saved!');
            }
            else {
                toastr.error('Saving findings Failed!');


                if (JsonObject['error']['location_exl'] === undefined) {
                    $("#slctLocationEXL").removeClass('is-invalid');
                    $("#slctLocationEXL").attr('title', '');
                }
                else {
                    $("#slctLocationEXL").addClass('is-invalid');
                    $("#slctLocationEXL").attr('title', JsonObject['error']['location_exl']);
                }
                if (JsonObject['error']['remarks_exl'] === undefined) {
                    $("#txtRemarksEXL").removeClass('is-invalid');
                    $("#txtRemarksEXL").attr('title', '');
                }
                else {
                    $("#txtRemarksEXL").addClass('is-invalid');
                    $("#txtRemarksEXL").attr('title', JsonObject['error']['remarks_exl']);
                }
            }
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#ibtnSubmitCREXLIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnSubmitCR").removeAttr('disabled');
            $("#ibtnSubmitCREXLIcon").addClass('fa fa-upload');
        }
    });
}

// Add Maintenance Result Fire Extinguisher
function AddChecksheetFindingsFE() {
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

    let form_data = new FormData($('#formViewFECriteria')[0]);

    $.ajax({
        url: "add_checksheet_findings_fe",
        method: "post",
        processData: false,
        contentType: false,
        data: form_data,
        dataType: "json",
        beforeSend: function () {
            $("#ibtnSubmitCRFEIcon").removeClass('fa fa-upload')
            $("#ibtnSubmitCRFEIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnSubmitCRFE").prop('disabled', 'disabled');
        },
        success: function (JsonObject) {

            $("#ibtnSubmitCRFEIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnSubmitCRFE").removeAttr('disabled');
            $("#ibtnSubmitCRFEIcon").addClass('fa fa-upload');

            if (JsonObject['result'] == 1) {

                $("#slctGeneralAreaFE").removeClass('is-invalid');
                $("#slctControlNumberFE").removeClass('is-invalid');
                $("#slctClassificationFE").removeClass('is-invalid');
                $("#txtLocationFE").removeClass('is-invalid');
                $("#txtRemarksFE").removeClass('is-invalid');
                $("#txtCapacityFE").removeClass('is-invalid');

                dt_criteria_fe.draw();
                dt_pending_checksheets.draw();
                toastr.success('Findings Succesfully Saved!');
            }
            else {
                toastr.error('Saving findings Failed!');
                if (JsonObject['error']['general_area_fe'] === undefined) {
                    $("#slctGeneralAreaFE").removeClass('is-invalid');
                    $("#slctGeneralAreaFE").attr('title', '');
                }
                else {
                    $("#slctGeneralAreaFE").addClass('is-invalid');
                    $("#slctGeneralAreaFE").attr('title', JsonObject['error']['general_area_fe']);
                }

                if (JsonObject['error']['control_number_fe'] === undefined) {
                    $("#slctControlNumberFE").removeClass('is-invalid');
                    $("#slctControlNumberFE").attr('title', '');
                }
                else {
                    $("#slctControlNumberFE").addClass('is-invalid');
                    $("#slctControlNumberFE").attr('title', JsonObject['error']['control_number_fe']);
                }

                if (JsonObject['error']['classification_fe'] === undefined) {
                    $("#slctClassificationFE").removeClass('is-invalid');
                    $("#slctClassificationFE").attr('title', '');
                }
                else {
                    $("#slctClassificationFE").addClass('is-invalid');
                    $("#slctClassificationFE").attr('title', JsonObject['error']['classification_fe']);
                }

                if (JsonObject['error']['location_fe'] === undefined) {
                    $("#txtLocationFE").removeClass('is-invalid');
                    $("#txtLocationFE").attr('title', '');
                }
                else {
                    $("#txtLocationFE").addClass('is-invalid');
                    $("#txtLocationFE").attr('title', JsonObject['error']['location_fe']);
                }
                if (JsonObject['error']['remarks_fe'] === undefined) {
                    $("#txtRemarksFE").removeClass('is-invalid');
                    $("#txtRemarksFE").attr('title', '');
                }
                else {
                    $("#txtRemarksFE").addClass('is-invalid');
                    $("#txtRemarksFE").attr('title', JsonObject['error']['remarks_fe']);
                }
                if (JsonObject['error']['capacity_fe'] === undefined) {
                    $("#txtCapacityFE").removeClass('is-invalid');
                    $("#txtCapacityFE").attr('title', '');
                }
                else {
                    $("#txtCapacityFE").addClass('is-invalid');
                    $("#txtCapacityFE").attr('title', JsonObject['error']['capacity_fe']);
                }
            }
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#ibtnSubmitCRFEIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnSubmitCR").removeAttr('disabled');
            $("#ibtnSubmitCRFEIcon").addClass('fa fa-upload');
        }
    });
}


// var form = document.getElementById('formViewFECriteria');
// if(form != null){
//     form.elements.control_number_fe.onchange = function () {
//         var form = this.form;
//         form.elements.location_fe.value = chklistTempValuesFacEqptFE[this.value];
//     };
// }

// var form = document.getElementById('formViewFHCriteria');
// if(form != null){
//     form.elements.control_number_fh.onchange = function () {
//         var form = this.form;
//         form.elements.location_fh.value = chklistTempValuesFacEqptFH[this.value];
//     };
// }

// Add Maintenance Result Fire Hose Cabinet
function AddChecksheetFindingsFH() {
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

    let form_data = new FormData($('#formViewFHCriteria')[0]);

    $.ajax({
        url: "add_checksheet_findings_fh",
        method: "post",
        processData: false,
        contentType: false,
        data: form_data,
        dataType: "json",
        beforeSend: function () {
            $("#ibtnSubmitCRFHIcon").removeClass('fa fa-upload')
            $("#ibtnSubmitCRFHIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnSubmitCRFH").prop('disabled', 'disabled');
        },
        success: function (JsonObject) {

            $("#ibtnSubmitCRFHIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnSubmitCRFH").removeAttr('disabled');
            $("#ibtnSubmitCRFHIcon").addClass('fa fa-upload');

            if (JsonObject['result'] == 1) {

                $("#slctGeneralAreaFH").removeClass('is-invalid');
                $("#slctControlNumberFH").removeClass('is-invalid');
                $("#txtLocationFH").removeClass('is-invalid');
                $("#txtRemarksFH").removeClass('is-invalid');

                dt_criteria_fh.draw();
                dt_pending_checksheets.draw();
                toastr.success('Findings Succesfully Saved!');
            }
            else {
                toastr.error('Saving findings Failed!');
                if (JsonObject['error']['general_area_fh'] === undefined) {
                    $("#slctGeneralAreaFH").removeClass('is-invalid');
                    $("#slctGeneralAreaFH").attr('title', '');
                }
                else {
                    $("#slctGeneralAreaFH").addClass('is-invalid');
                    $("#slctGeneralAreaFH").attr('title', JsonObject['error']['general_area_fh']);
                }

                if (JsonObject['error']['control_number_fh'] === undefined) {
                    $("#slctControlNumberFH").removeClass('is-invalid');
                    $("#slctControlNumberFH").attr('title', '');
                }
                else {
                    $("#slctControlNumberFH").addClass('is-invalid');
                    $("#slctControlNumberFH").attr('title', JsonObject['error']['control_number_fh']);
                }

                if (JsonObject['error']['location_fh'] === undefined) {
                    $("#txtLocationFH").removeClass('is-invalid');
                    $("#txtLocationFH").attr('title', '');
                }
                else {
                    $("#txtLocationFH").addClass('is-invalid');
                    $("#txtLocationFH").attr('title', JsonObject['error']['location_fh']);
                }

                if (JsonObject['error']['remarks_fh'] === undefined) {
                    $("#txtRemarksFH").removeClass('is-invalid');
                    $("#txtRemarksFH").attr('title', '');
                }
                else {
                    $("#txtRemarksFH").addClass('is-invalid');
                    $("#txtRemarksFH").attr('title', JsonObject['error']['remarks_fh']);
                }
            }
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#ibtnSubmitCRFHIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnSubmitCR").removeAttr('disabled');
            $("#ibtnSubmitCRFHIcon").addClass('fa fa-upload');
        }
    });
}

function SubmitChecksheet() {
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

    let form_data = new FormData($('#formSubmitChecksheet')[0]);

    $.ajax({
        url: "submit_checksheet",
        method: "post",
        processData: false,
        contentType: false,
        data: form_data,
        dataType: "json",
        beforeSend: function () {
            $("#iBtnSubmitChecksheet").addClass('fa fa-spinner fa-pulse');
            $("#btnSubmitChecksheet").prop('disabled', 'disabled');
            $("#btnClose").prop('disabled', 'disabled');
        },
        success: function (JsonObject) {
            console.log(JsonObject);
            if (JsonObject['result'] == 1) {

                $("#modalSubmitChecksheet").modal('hide');
                $("#formSubmitChecksheet")[0].reset();

                $("#iBtnSubmitChecksheet").removeClass('fa fa-spinner fa-pulse');
                $("#iBtnSubmitChecksheet").addClass('fa fa-check-circle');
                $("#btnSubmitChecksheet").prop('disabled', false);
                $("#btnClose").prop('disabled', false);

                dt_pending_checksheets.draw();
                dt_approval_checksheets.draw();
                toastr.success('Checksheet Successfully Saved!');
            } else if (JsonObject['result'] == 2) {
                alert('Email of Mr./Ms. '+ $('#slctSrSupervisor option:selected').text() +' is not found, Please contact ISS.')
            }
            else {
                
                $("#iBtnSubmitChecksheet").removeClass('fa fa-spinner fa-pulse');
                $("#iBtnSubmitChecksheet").addClass('fa fa-check-circle');
                $("#btnSubmitChecksheet").prop('disabled', false);
                $("#btnClose").prop('disabled', false);

                toastr.error('Saving of Checksheet Failed!');
            }
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}

function SupervisorApproveChecksheet() {
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

    let form_data = new FormData($('#formSupervisorApproveChecksheet')[0]);

    $.ajax({
        url: "supervisor_approve_checksheet",
        method: "post",
        processData: false,
        contentType: false,
        data: form_data,
        dataType: "json",
        beforeSend: function () {
            $("#iBtnSupervisorApproveChecksheet").addClass('fa fa-spinner fa-pulse');
            $("#iBtnSupervisorDisapproveChecksheet").addClass('fa fa-spinner fa-pulse');
            $("#btnSupervisorApproveChecksheet").prop('disabled', 'disabled');
            $("#btnSupervisorDisapproveChecksheet").prop('disabled', 'disabled');
        },
        success: function (JsonObject) {
            if (JsonObject['result'] == 1) {

                $("#modalSupervisorApproveChecksheet").modal('hide');
                $("#formSupervisorApproveChecksheet")[0].reset();

                $("#iBtnSupervisorApproveChecksheet").removeClass('fa fa-spinner fa-pulse');
                $("#iBtnSupervisorApproveChecksheet").addClass('fa fa-check-circle');
                $("#iBtnSupervisorDisapproveChecksheet").removeClass('fa fa-spinner fa-pulse');
                $("#iBtnSupervisorDisapproveChecksheet").addClass('fa fa-check-circle');
                $("#btnSupervisorApproveChecksheet").prop('disabled', false);
                $("#btnSupervisorDisapproveChecksheet").prop('disabled', false);

                dt_approval_checksheets.draw();
                toastr.success('Checksheet Successfully Approved!');
            } 
            else {

                $("#iBtnSupervisorApproveChecksheet").removeClass('fa fa-spinner fa-pulse');
                $("#iBtnSupervisorApproveChecksheet").addClass('fa fa-check-circle');
                $("#iBtnSupervisorDisapproveChecksheet").removeClass('fa fa-spinner fa-pulse');
                $("#iBtnSupervisorDisapproveChecksheet").addClass('fa fa-check-circle');
                $("#btnSupervisorApproveChecksheet").prop('disabled', false);
                $("#btnSupervisorDisapproveChecksheet").prop('disabled', false);

                toastr.error('Approval of Checksheet Failed!');
            }
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}

function ManagerApproveChecksheet() {
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

    let form_data = new FormData($('#formManagerApproveChecksheet')[0]);

    $.ajax({
        url: "manager_approve_checksheet",
        method: "post",
        processData: false,
        contentType: false,
        data: form_data,
        dataType: "json",
        beforeSend: function () {
            $("#iBtnManagerApproveChecksheet").addClass('fa fa-spinner fa-pulse');
            $("#btnManagerApproveChecksheet").prop('disabled', 'disabled');
            $("#iBtnManagerDisapproveChecksheet").addClass('fa fa-spinner fa-pulse');
            $("#btnManagerDisapproveChecksheet").prop('disabled', 'disabled');
        },
        success: function (JsonObject) {
            if (JsonObject['result'] == 1) {

                $("#modalManagerApproveChecksheet").modal('hide');
                $("#formManagerApproveChecksheet")[0].reset();

                $("#iBtnManagerApproveChecksheet").removeClass('fa fa-spinner fa-pulse');
                $("#iBtnManagerApproveChecksheet").addClass('fa fa-check-circle');
                $("#iBtnManagerDisapproveChecksheet").removeClass('fa fa-spinner fa-pulse');
                $("#iBtnManagerDisapproveChecksheet").addClass('fa fa-check-circle');
                $("#btnManagerApproveChecksheet").prop('disabled', false);
                $("#btnManagerDisapproveChecksheet").prop('disabled', false);

                dt_approval_checksheets.draw();
                dt_approved_checksheets.draw();
                toastr.success('Checksheet Successfully Approved!');
            }
            else {

                $("#iBtnManagerApproveChecksheet").removeClass('fa fa-spinner fa-pulse');
                $("#iBtnManagerApproveChecksheet").addClass('fa fa-check-circle');
                $("#iBtnManagerDisapproveChecksheet").removeClass('fa fa-spinner fa-pulse');
                $("#iBtnManagerDisapproveChecksheet").addClass('fa fa-check-circle');
                $("#btnManagerApproveChecksheet").prop('disabled', false);
                $("#btnManagerDisapproveChecksheet").prop('disabled', false);

                toastr.error('Approval of Checksheet Failed!');
            }
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}


function AlterModalBasedOnStatusEL(el_checksheetId) {
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
        url: "alter_criteria_modal_based_on_status",
        method: "get",
        data: {
            checksheet_id: el_checksheetId
        },
        dataType: "json",
        success: function (JsonObject) {
            if (JsonObject['result'] == 1) {
                $("#btnSubmitCREL").prop('hidden', true);
                $("#slctGeneralAreaEL").prop('disabled', true);
                $("#slctControlNumberEL").prop('disabled', true);
                $("#txtLocationEL").prop('readonly', true);
                $("#RdoLightsLStatusGood").prop('disabled', true);
                $("#RdoLightsLStatusNoGood").prop('disabled', true);
                $("#RdoLightsRStatusGood").prop('disabled', true);
                $("#RdoLightsRStatusNoGood").prop('disabled', true);
                $("#RdoBatteryStatusGood").prop('disabled', true);
                $("#RdoBatteryStatusNoGood").prop('disabled', true);
                $("#RdoDrainingofBatteryStatusDone").prop('disabled', true);
                $("#RdoDrainingofBatteryStatusNG").prop('disabled', true);
                $("#RdoInspCardStatusUpdated").prop('disabled', true);
                $("#RdoInspCardStatusNotUpdated").prop('disabled', true);
                $("#txtRemarksEL").prop('readonly', true);
            }
            else {

            }
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}

function AlterModalBasedOnStatusEXL(exl_checksheetId) {
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
        url: "alter_criteria_modal_based_on_status",
        method: "get",
        data: {
            checksheet_id: exl_checksheetId
        },
        dataType: "json",
        success: function (JsonObject) {
            if (JsonObject['result'] == 1) {
                $("#btnSubmitCREXL").prop('hidden', true);
                $("#slctGeneralAreaEXL").prop('disabled', true);
                $("#slctLocationEXL").prop('readonly', true);
                $("#RdoLightStatusGoodEXL").prop('disabled', true);
                $("#RdoLightStatusNoGoodEXL").prop('disabled', true);
                $("#RdoBatteryStatusGoodEXL").prop('disabled', true);
                $("#RdoBatteryStatusNoGoodEXL").prop('disabled', true);
                $("#txtRemarksEXL").prop('readonly', true);
            }
            else {

            }
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}

function AlterModalBasedOnStatusFE(fe_checksheetId) {
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
        url: "alter_criteria_modal_based_on_status",
        method: "get",
        data: {
            checksheet_id: fe_checksheetId
        },
        dataType: "json",
        success: function (JsonObject) {
            if (JsonObject['result'] == 1) {
                $("#btnSubmitCRFE").prop('hidden', true);
                $("#slctGeneralAreaFE").prop('disabled', true);
                $("#slctControlNumberFE").prop('disabled', true);
                $("#slctClassificationFE").prop('disabled', true);
                $("#txtLocationFE").prop('readonly', true);
                $("#RdoLeverStatusGood").prop('disabled', true);
                $("#RdoLeverStatusNoGood").prop('disabled', true);
                $("#RdoHoseStatusGood").prop('disabled', true);
                $("#RdoHoseStatusNoGood").prop('disabled', true);
                $("#RdoCylTankStatusGood").prop('disabled', true);
                $("#RdoCylTankStatusNoGood").prop('disabled', true);
                $("#RdoPressGaugeStatusGood").prop('disabled', true);
                $("#RdoPressGaugeStatusNoGood").prop('disabled', true);
                $("#txtCapacityFE").prop('readonly', true);
                $("#txtRemarksFE").prop('readonly', true);
            }
            else {

            }
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}

function AlterModalBasedOnStatusFH(fh_checksheetId) {
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
        url: "alter_criteria_modal_based_on_status",
        method: "get",
        data: {
            checksheet_id: fh_checksheetId
        },
        dataType: "json",
        success: function (JsonObject) {
            if (JsonObject['result'] == 1) {
                $("#btnSubmitCRFH").prop('hidden', true);
                $("#slctGeneralAreaFH").prop('disabled', true);
                $("#slctControlNumberFH").prop('disabled', true);
                $("#txtLocationFH").prop('readonly', true);
                $("#RdoCabinetStatusGood").prop('disabled', true);
                $("#RdoCabinetStatusNoGood").prop('disabled', true);
                $("#RdoHoseStatusGoodFH").prop('disabled', true);
                $("#RdoHoseStatusNoGoodFH").prop('disabled', true);
                $("#RdoNozzleStatusGood").prop('disabled', true);
                $("#RdoNozzleStatusNoGood").prop('disabled', true);
                $("#RdoPipelineStatusGood").prop('disabled', true);
                $("#RdoPipelineStatusNoGood").prop('disabled', true);
                $("#RdoValveStatusGood").prop('disabled', true);
                $("#RdoValveStatusNoGood").prop('disabled', true);
                $("#txtRemarksFH").prop('readonly', true);
            }
            else {

            }
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}

function AlterModalBasedOnStatus(checksheetId) {
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
        url: "alter_criteria_modal_based_on_status",
        method: "get",
        data: {
            checksheet_id: checksheetId
        },
        dataType: "json",
        success: function (JsonObject) {
            if (JsonObject['result'] == 1) {
                $("#btnSubmitCR").prop('hidden', true);
                $("#slctEquipmentTemplate").prop('disabled', true);
                $("#slctChecklist").prop('disabled', true);
                $("#txtRequirement").prop('readonly', true);
                $("#RdoStatusGood").prop('disabled', true);
                $("#RdoStatusNoGood").prop('disabled', true);
                $("#txtRemarks").prop('readonly', true);
            }
            else {

            }
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}
