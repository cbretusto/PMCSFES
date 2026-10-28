function CreateClassification() {
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
        url: "create_classification",
        method: "post",
        data: $('#formNewClassification').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#btnViewClassification").prop('disabled', 'disabled');
        },
        success: function(response){
            if(response['validationHasError'] == 1){
                toastr.error('Saving failed!');

                if(response['error']['classification'] === undefined){
                    $("#txtCreateClassification").removeClass('is-invalid');
                    $("#txtCreateClassification").attr('title', '');
                }else{
                    $("#txtCreateClassification").addClass('is-invalid');
                    $("#txtCreateClassification").attr('title', response['error']['classification']);
                }

            }else if(response['hasError'] == 1){
                $("#txtCreateClassification").val('');
                toastr.success('Succesfully saved!');
                dataTableClassification.draw();
            }else{
                alert('Classification: "'+$("#txtCreateClassification").val()+'" is already exist!')
            }

            $("#btnViewClassification").removeAttr('disabled');
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#btnViewClassification").removeAttr('disabled');
        }
    });
}

function GetClassificationIdToEdit(generalAreaID){
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
        url: "get_classification_info_by_id",
        method: "get",
        data: {
            generalAreaID: generalAreaID
        },
        dataType: "json",
        beforeSend: function(){
        },
        success: function(response){
            let classificationInfo = response['classificationInfo'];
            if(classificationInfo.length > 0){
                $("#txtUpdateClassification").val(classificationInfo[0].classification);
            }else{
                toastr.warning('No Record Found!');
            }
        },

        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}

function UpdateClassification() {
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
        url: "update_classification",
        method: "post",
        data: $('#formUpdateClassification').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#ibtnSubmitClassificationIcon").addClass('spinner-border spinner-border-sm')
            $("#btnSubmitClassification").addClass('disabled')
            $("#ibtnSubmitClassificationIcon").removeClass('fa fa-check')        
        },
        success: function(response){
            if(response['validationHasError'] == 1){
                toastr.error('Saving failed!');

                if(response['error']['classification'] === undefined){
                    $("#txtUpdateClassification").removeClass('is-invalid');
                    $("#txtUpdateClassification").attr('title', '');
                }else{
                    $("#txtUpdateClassification").addClass('is-invalid');
                    $("#txtUpdateClassification").attr('title', response['error']['classification']);
                }

            }else if(response['hasError'] == 1){
                $("#formUpdateClassification")[0].reset();
                $("#modalUpdateClassification").modal('hide')
                toastr.success('Succesfully saved!');
                dataTableClassification.draw();
            }else{
                alert('Classification: "'+$("#txtUpdateClassification").val()+'" is already exist!')
            }

            $("#ibtnSubmitClassificationIcon").removeClass('spinner-border spinner-border-sm')
            $("#btnSubmitClassification").removeClass('disabled')
            $("#ibtnSubmitClassificationIcon").addClass('fa fa-check')
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#ibtnSubmitClassificationIcon").removeClass('spinner-border spinner-border-sm')
            $("#btnSubmitClassification").removeClass('disabled')
            $("#ibtnSubmitClassificationIcon").addClass('fa fa-check')
        }
    });
}

function ChangeClassificationStatus(){
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
        url: "change_classification_status",
        method: "post",
        data: $('#formChangeClassificationStatus').serialize(),
        dataType: "json",
        beforeSend: function(){
            $("#iBtnChangeClassificationStatusIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnChangeClassificationStatus").prop('disabled', 'disabled');
        },
        success: function(response){

            if(response['validation'] == 'hasError'){
                toastr.error('Classification activation failed!');
            }else{
                if(response['result'] == 1){
                    if($("#txtChangeClassificationStatus").val() == 1){
                        toastr.success('Classification activation success!');
                        $("#txtChangeClassificationStatus").val() == 2;
                    }else{
                        toastr.success('Classification deactivation success!');
                        $("#txtChangeClassificationStatus").val() == 1;
                    }
                }
                $("#formChangeClassificationStatus")[0].reset();
                $("#modalChangeClassificationStatus").modal('hide');
                dataTableClassification.draw();
            }

            $("#iBtnChangeClassificationStatusIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnChangeClassificationStatus").removeAttr('disabled');
            $("#iBtnChangeClassificationStatusIcon").addClass('fa fa-check');
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#iBtnChangeClassificationStatusIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnChangeClassificationStatus").removeAttr('disabled');
            $("#iBtnChangeClassificationStatusIcon").addClass('fa fa-check');
        }
    });
}

function GetClassification(cboElement,deviceID){
    let result = '<option value="">N/A</option>';
    $.ajax({
        url: "get_classification",
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

            let classificationInfo = response['classificationInfo']
            if(classificationInfo.length > 0){
                result = '<option value="" selected disabled> Select Classification </option>';
                for(let index = 0; index < classificationInfo.length; index++){
                    result += '<option value="' + classificationInfo[index].classification+'">'+ classificationInfo[index].classification+'</option>';
                }
            }
            else{
                result = '<option value="0" selected disabled> No record found </option>';
            }
            cboElement.html(result);
        }
    });
}