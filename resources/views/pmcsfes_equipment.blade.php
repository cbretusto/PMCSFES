@php
    session_start();
    $isLogin = false;
    $layout = 'layouts.no_access_layout';
    if(isset($_SESSION['rapidx_user_id'])){
        $isLogin = true;
        // if( $_SESSION['rapidx_department_id'] == 1 || $_SESSION["PMCSFES_module_id"] == '9' && isset($_SESSION['PMCSFES_access']) ){
        if( $_SESSION["PMCSFES_module_id"] == '9' && isset($_SESSION['PMCSFES_access']) ){
            $layout = 'layouts.user_layout';
        }
    }
@endphp
@if($isLogin)
    @extends($layout)
    @section('title', 'Blank')
    @section('content_page')
    <style type="text/css">
        .slct{
            pointer-events: none;
        }
    </style>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            {{-- <h1>Periodic Maintenance Check Sheet & Facility Equipment System</h1> --}}
                            <h1><strong id="setTitle"></strong></h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                <li class="breadcrumb-item active">PMCSFES</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Equipment List</h3>
                                </div>

                                <!-- Start Page Content -->
                                <div class="card-body">
                                    <!-- START CHAN 01-16-2025 -->
                                    <div class="">
                                        <div class="input-group col-2 d-none" id="selection">
                                            <div class="input-group-prepend w-20">
                                                <span class="input-group-text w-100"><strong>FACTORY:</strong>&nbsp;</span>
                                            </div>
                                            <select class="form-control" name="select_factory"
                                                id="factory">
                                                <option disabled selected value="">---------------------</option>
                                                <option value="1">1 & 2</option>
                                                <option value="3">3</option>
                                            </select>
                                        </div>

                                        {{-- <button type="button" class="btn btn btn-dark float-right" id="btnNewEquipment"
                                            data-toggle="modal" data-target="#modalNewEquipment"><i class="fa fa-plus"></i>
                                            Add New Equipment</button> --}}
                                    </div>
                                    <!-- END CHAN 01-16-2025 -->

                                    <div class="dt-responsive table-responsive">
                                        <br>
                                        <table id="tbl_equipments" class="table table-striped table-bordered"
                                            style="width: 100%; font-size: 90%;">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Equipment Name</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- !-- End Page Content -->

                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Add Equipment Modal -->
        {{-- <div class="modal fade" id="modalNewEquipment" data-backdrop="static">
            <div class="modal-dialog modal-m">
                <div class="modal-content">

                    <div class="modal-header">
                        <h4 class="modal-title" id="changeTitle"><i class="fa fa-plus"></i> New Equipment</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>

                    <form method="post" id="formCreateUpdateEquipment">
                        @csrf
                        <div class="modal-body">

                            <!-- Equipment Name -->
                            <div class="form-group">
                                <!-- START CHAN 01-16-2025 -->
                                <input type="hidden" id="factoryEquipmentList" name="factory_equipment_list" required>
                                <label for="pr_number" class="col-sm-10 control-label">Equipment Name</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" name="equipment_name" id="txtEquipmentName"
                                        placeholder="Equipment Name" value="" maxlength="50" required="">
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" id="btnSubmitEquipment" class="btn btn-sm btn-dark"><i
                                    id="ibtnSubmitEquipmentDefIcon" class="fa fa-plus"></i> Submit Equipment</button>
                        </div>

                    </form>
                </div>
            </div>
        </div> --}}

        <!-- Checksheets Modal -->
        <div class="modal fade" id="modalViewChecksheets" data-backdrop="static" style="overflow-y: scroll;">
            <div class="modal-dialog modal-xl-custom">
                <div class="modal-content">

                    <div class="modal-header">
                        <h4 class="modal-title" id="viewCheckSheetTitle"><i class="fa fa-pencil-square"></i> Periodic Maintenance Checksheets</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>

                    <form method="post" id="formViewChecksheets">
                        @csrf
                        <!-- START CHAN 01-16-2025 -->
                        <input type="hidden" id="factoryViewChecksheets" name="factory_view_checksheets" required>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <h3 class="card-title">
                                                        <i class="fa fa-info-circle"></i>
                                                        <strong>Equipment</strong>
                                                    </h3>
                                                </div>
                                                <div class="col-sm-4">
                                                    <button type="submit" id="btnSubmitCS" class="btn btn btn-dark"
                                                        style="float: right"><i id="ibtnSubmitCSIcon"
                                                            class="fa fa-plus"></i> Add Checksheet</button>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body shadow">
                                            <div class="row">
                                                <!-- Hidden Device ID -->
                                                <input type="hidden" class="form-control" name="device_id" id="txtDeviceId" readonly>

                                                <!-- Equipment -->
                                                <div class="input-group col-4">
                                                    <div class="input-group-prepend w-50">
                                                        <span class="input-group-text w-100 font-style"><strong>Equipment</strong></span>
                                                    </div>
                                                    <input type="text" class="form-control" name="device" id="txtDevice" readonly>
                                                </div>

                                                <!-- Equipment Model / General Area -->
                                                <div class="input-group col-4">
                                                    <div class="input-group-prepend w-50">
                                                        <span class="input-group-text w-100 font-style"><strong>Equipment Model</strong></span>
                                                    </div>
                                                    {{-- <input type="text" class="form-control reset-value" name="equipment_model" id="txtEquipmentModel" autocomplete="off"> --}}
                                                    <select class="form-control reset-value select2bs4 sel-equipment-model" name="equipment_model" id="slctEquipmentModel"></select>                                                
                                                </div>

                                                <!-- Date Inspected -->
                                                <div class="input-group col-4">
                                                    <div class="input-group-prepend w-50">
                                                        <span class="input-group-text w-100 font-style"><strong>Date Inspected</strong></span>
                                                    </div>
                                                    <input type="date" class="form-control reset-value" name="date_inspected" id="txtDateInspected" value="">
                                                </div>

                                                {{-- <!-- Equipment -->
                                                <div class="input-group col-4">
                                                    <div class="input-group-prepend w-100">
                                                        <span class="input-group-text"><strong>Equipment</strong></span>
                                                    </div>
                                                    <input type="text" class="form-control" name="device" id="txtDevice" readonly>
                                                </div>
                                            
                                                <!-- Equipment Model / General Area -->
                                                <div class="input-group col-4">
                                                    <div class="input-group-prepend w-100">
                                                        <span class="input-group-text"><strong>Equipment Model / General Area</strong></span>
                                                    </div>
                                                    <input type="text" class="form-control reset-value" name="equipment_model" id="slctEquipmentModel" autocomplete="off">
                                                </div>
                                            
                                                <!-- Date Inspected -->
                                                <div class="input-group col-4">
                                                    <div class="input-group-prepend w-100">
                                                        <span class="input-group-text"><strong>Date Inspected</strong></span>
                                                    </div>
                                                    <input type="date" class="form-control reset-value" name="date_inspected" id="txtDateInspected" value="">
                                                </div> --}}
                                            </div>
                                            
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                    <hr>
                                </div>
                                <div class="col-sm-12 shadow">
                                    <ul class="nav nav-tabs " role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active tab-checksheets onClick" data-toggle="tab" data-target="#pendingCheckSheets" type="button" role="tab"><strong>Pending Checksheets</strong>&emsp;</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link tab-checksheets onClick" data-toggle="tab" data-target="#forApprovalCheckSheets" type="button" role="tab"><strong>For Approval Checksheets</strong>&emsp;</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link tab-checksheets onClick" data-toggle="tab" data-target="#approvedChecksheet" type="button" role="tab"><strong>Approved Checksheets</strong>&emsp;</button>
                                        </li>
                                    </ul>

                                    <div class="card-body"><!-- Start Page Content -->
                                        <div class="tab-content" id="myTabContent"> <!-- tab-content -->
                                            <div class="tab-pane fade show active" id="pendingCheckSheets" role="tabpanel">
                                                <div class="table-responsive"><!-- Table responsive -->
                                                    <table id="tbl_checksheets" class="table table-striped table-bordered"
                                                        style="width: 100%; font-size: 90%;">
                                                        <thead>
                                                            <tr>
                                                                <th style="text-align: center;">Status</th>
                                                                <th style="text-align: center;">Checksheet Name</th>
                                                                <th style="text-align: center;">Date Inspected</th>
                                                                <th style="text-align: center;">Inspected By</th>
                                                                <th style="text-align: center;">Noted By Sr. Supervisor</th>
                                                                <th style="text-align: center;">Supervisor Remarks</th>
                                                                <th style="text-align: center;">Noted By Manager</th>
                                                                <th style="text-align: center;">Manager Remarks</th>
                                                                <th style="text-align: center;">&nbsp;Action&nbsp;</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div><!-- /.Table responsive -->
                                            </div>

                                            <div class="tab-pane fade" id="forApprovalCheckSheets" role="tabpanel">
                                                <div class="table-responsive mt-3">
                                                    <table id="tbl_approval_checksheets" class="table table-striped table-bordered"
                                                        style="width: 100%; font-size: 90%;">
                                                        <thead>
                                                            <tr>
                                                                <th style="text-align: center;">Status</th>
                                                                <th style="text-align: center;">Checksheet Name</th>
                                                                <th style="text-align: center;">Date Inspected</th>
                                                                <th style="text-align: center;">Inspected By</th>
                                                                <th style="text-align: center;">Noted By Sr. Supervisor</th>
                                                                <th style="text-align: center;">Supervisor Remarks</th>
                                                                <th style="text-align: center;">Noted By Manager</th>
                                                                <th style="text-align: center;">Manager Remarks</th>
                                                                <th style="text-align: center;">&nbsp;Action&nbsp;</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="approvedChecksheet" role="tabpanel">
                                                <div class="table-responsive mt-3">
                                                    <table id="tbl_approved_checksheets" class="table table-striped table-bordered"
                                                        style="width: 100%; font-size: 90%;">
                                                        <thead>
                                                            <tr>
                                                                <th style="text-align: center;">Status</th>
                                                                <th style="text-align: center;">Checksheet Name</th>
                                                                <th style="text-align: center;">Date Inspected</th>
                                                                <th style="text-align: center;">Inspected By</th>
                                                                <th style="text-align: center;">Noted By Sr. Supervisor</th>
                                                                <th style="text-align: center;">Supervisor Remarks</th>
                                                                <th style="text-align: center;">Noted By Manager</th>
                                                                <th style="text-align: center;">Manager Remarks</th>
                                                                <th style="text-align: center;">&nbsp;Action&nbsp;</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            {{-- <div class="dt-responsive table-responsive">
                                            <br>
                                            <table id="tbl_checksheets" class="table table-striped table-bordered"
                                                style="width: 100%; font-size: 90%;">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align: center;">Status</th>
                                                        <th style="text-align: center;">Checksheet Name</th>
                                                        <th style="text-align: center;">Date Inspected</th>
                                                        <th style="text-align: center;">Inspected By</th>
                                                        <th style="text-align: center;">Noted By Sr. Supervisor</th>
                                                        <th style="text-align: center;">Supervisor Remarks</th>
                                                        <th style="text-align: center;">Noted By Manager</th>
                                                        <th style="text-align: center;">Manager Remarks</th>
                                                        <th style="text-align: center;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div> --}}

                                        </div> <!-- /.tab-content -->
                                    </div><!-- /.End Page Content -->
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Criteria Modal -->
        <div class="modal fade" id="modalViewCriteria" data-backdrop="static">
            <div class="modal-dialog" style="width:100%;max-width:1750px;">
                <div class="modal-content">

                    <div class="modal-header">
                        <h4 class="modal-title" id="viewCriteriaTitle"><i class="fa fa-pencil-square"></i> Periodic Maintenance Checksheets</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>

                    <form method="post" id="formViewCriteria">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-5">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <h3 class="card-title">
                                                        <i class="fa fa-info-circle"></i>
                                                        Maintenance Checksheet
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            <input type="hidden" id="factoryViewCriteria" name="factory_view_criteria" required>
                                            <input type="hidden" id="equipmentGetGeneralArea" name="equipment_get_general_area" required>
                                            <input type="hidden" id="equipmentGetClassication" name="equipment_get_classification" required>

                                            <!-- Equipment -->
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Checksheet
                                                        Name</span>
                                                </div>

                                                <input type="hidden" class="form-control" name="checksheet_id"
                                                    id="txtChecksheetId" readonly>
                                                <input type="text" class="form-control" name="checksheet_name"
                                                    id="txtChecksheetName" readonly>

                                            </div>
                                            <!-- Equipment Model -->
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Date
                                                        Inspected</span>
                                                </div>

                                                <input type="text" class="form-control" name="date_inspected_checksheet"
                                                    id="txtDateInspectedCS" readonly>

                                            </div>

                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Checklist
                                                        Template</span>
                                                </div>
                                                <select class="form-control sel-device criteria-reset-value" name="equipment_template"   id="slctEquipmentTemplate">
                                                    {{-- id="slctEquipmentTemplate" onchange="checklistChange(this);">
                                                    <option disabled selected value="">Select a Checklist Template</option>
                                                    <option value="1">Air Compressor</option>
                                                    <option value="2">Air Conditioning Units</option>
                                                    <option value="3">Air Dryer</option>
                                                    <option value="4">Cooling Tower</option>
                                                    <option value="5">Fire Pump</option>
                                                    <option value="6">Freight Elevator</option>
                                                    <option value="7">Generator Set</option>--}}
                                                </select> 
                                            </div>

                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Checklist</span>
                                                </div>
                                                <select class="form-control sel-checklist criteria-reset-value" name="checklist"
                                                    id="slctChecklist">
                                                    {{-- <option selected disabled value="">Select a Template</option> --}}
                                                </select>
                                            </div>

                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Requirement</span>
                                                </div>
                                                <input type="text" class="form-control criteria-reset-value" name="requirement"
                                                    id="txtRequirement" autocomplete="off" readonly>
                                            </div>

                                            <div class="input-group input-group-sm mb-3 generalAreaChecking d-none">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">General Area</span>
                                                </div>
                                                <select class="form-control criteria-reset-value general_area-disabled-field sel-general-area" name="equipment_general_area"
                                                    id="slctEquipmentGeneralArea" autocomplete="off" disabled>
                                                </select>
                                            </div>
                                            <div class="input-group input-group-sm mb-3 generalAreaChecking d-none">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Control Number</span>
                                                </div>
                                                <select class="form-control criteria-reset-value general_area-disabled-field sel-control-no" name="equipment_general_area_control_no"
                                                    id="slctEquipmentGeneralAreaControlNumber" autocomplete="off" disabled>
                                                </select>
                                            </div>

                                            <div class="input-group input-group-sm mb-3 generalAreaChecking d-none">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Location</span>
                                                </div>
                                                <input type="text" class="form-control criteria-reset-value general_area-disabled-field getLocation" name="equipment_general_area_location"
                                                    id="slctEquipmentGeneralAreaLocation" autocomplete="off" readonly>
                                            </div>

                                            <div class="input-group input-group-sm mb-3 classificationChecking d-none">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Classification</span>
                                                </div>
                                                <select class="form-control criteria-reset-value classification-disabled-field sel-classification" name="equipment_classification"
                                                    id="slctEquipmentClassification" autocomplete="off" disabled>
                                                </select>
                                            </div>
                        
                                            <div class="input-group input-group-sm mb-4">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Status</span>
                                                </div>

                                                <div class="w-50"
                                                    style="border-style: solid; border-width: 1px; border-color: #d5deeb;">
                                                    <div class="custom-control custom-radio" style="margin-left: 15px;">
                                                        <input class="custom-control-input uncheck" type="radio" id="RdoStatusGood"
                                                            name="status" value="1">
                                                        <label for="RdoStatusGood" class="custom-control-label">Good</label>
                                                    </div>
                                                    <div class="custom-control custom-radio" style="margin-left: 15px;">
                                                        <input class="custom-control-input uncheck" type="radio" id="RdoStatusNoGood"
                                                            name="status" value="0">
                                                        <label for="RdoStatusNoGood" class="custom-control-label">No
                                                            Good</label>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Remarks</span>
                                                </div>
                                                <textarea class="form-control criteria-reset-value" rows="3" placeholder="Enter ..."
                                                    name="remarks" id="txtRemarks"></textarea>
                                            </div>
                                        </div> <!-- /.card-body -->
                                        <div class="modal-footer">
                                            <div class="">
                                                <button type="submit" id="btnSubmitCR" class="btn btn btn-dark"
                                                    style="float: right"><i id="ibtnSubmitCRIcon"
                                                        class="fa fa-plus"></i> Add Checksheet Findings</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-7">
                                    <h3 id="checkSheetFindingsTitle">Checksheet Findings</h3>
                                    <div class="dt-responsive table-responsive">
                                        <br>
                                        <table id="tbl_criteria" class="table table-striped table-bordered"
                                            style="width: 100%; font-size: 90%;">
                                            <thead>
                                                <tr>
                                                    <th>Checklist</th>
                                                    <th>Requirement</th>
                                                    <th>General Area</th>
                                                    <th>Control No.</th>
                                                    <th>Location</th>
                                                    <th>Classification</th>
                                                    <th>Good</th>
                                                    <th>No Good</th>
                                                    <th>Remarks</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Emergency Light Criteria Modal -->
        <div class="modal fade" id="modalViewELCriteria" data-backdrop="static">
            <div class="modal-dialog" style="width:100%;max-width:1750px;">
                <div class="modal-content">

                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fa fa-pencil-square"></i> Periodic Maintenance Checksheets</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>

                    <form method="post" id="formViewELCriteria">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-5">
                                    <input type="hidden" id="factoryViewElCriteria" name="factory_view_el_criteria">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <h3 class="card-title">
                                                        <i class="fa fa-info-circle"></i>
                                                        Maintenance Checksheet
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            <!-- Equipment -->
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Checksheet
                                                        Name</span>
                                                </div>

                                                <input type="hidden" class="form-control" name="checksheet_id_el"
                                                    id="txtChecksheetIdEL" readonly>
                                                <input type="text" class="form-control" name="checksheet_name_el"
                                                    id="txtChecksheetNameEL" readonly>

                                            </div>
                                            <!-- Equipment Model -->
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Date
                                                        Inspected</span>
                                                </div>

                                                <input type="text" class="form-control" name="date_inspected_checksheet_el"
                                                    id="txtDateInspectedCSEL" readonly>

                                            </div>

                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">General Area</span>
                                                </div>
                                                <select class="form-control sel-general-area-el reset-value" name="general_area_el" id="slctGeneralAreaEL">
                                                    {{-- id="slctGeneralAreaEL" onchange="checklistChangeEL(this);">
                                                    <option selected disabled value="">Select General Area</option>
                                                    <option value="1">Factory 1 Ground Floor</option>
                                                    <option value="2">Factory 1 Second Floor</option>
                                                    <option value="3">Factory 2 Ground Floor</option>
                                                    <option value="4">Factory 2 Second Floor</option>
                                                    <option value="5">PPS Production</option> --}}
                                                </select>
                                            </div>

                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Control
                                                        Number</span>
                                                </div>
                                                <select class="form-control sel-control-no-el reset-value" name="control_number_el"
                                                    id="slctControlNumberEL" disabled>
                                                    {{-- <option value="">Select a Control Number</option> --}}
                                                </select>
                                            </div>

                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Location</span>
                                                </div>

                                                <input type="text" class="form-control reset-value getLocation" name="location_el"
                                                    id="txtLocationEL" readonly>

                                            </div>

                                            <div class="input-group input-group-sm mb-4">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Lights - L</span>
                                                </div>

                                                <div class="w-50"
                                                    style="border-style: solid; border-width: 1px; border-color: #d5deeb;">
                                                    <div class="custom-control custom-radio" style="margin-left: 15px;">
                                                        <input class="custom-control-input uncheck" type="radio"
                                                            id="RdoLightsLStatusGood" name="lightslstatus" value="1">
                                                        <label for="RdoLightsLStatusGood"
                                                            class="custom-control-label">Good</label>
                                                    </div>
                                                    <div class="custom-control custom-radio" style="margin-left: 15px;">
                                                        <input class="custom-control-input uncheck" type="radio"
                                                            id="RdoLightsLStatusNoGood" name="lightslstatus" value="0">
                                                        <label for="RdoLightsLStatusNoGood" class="custom-control-label">No
                                                            Good</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="input-group input-group-sm mb-4">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Lights - R</span>
                                                </div>
                                                <div class="w-50"
                                                    style="border-style: solid; border-width: 1px; border-color: #d5deeb;">
                                                    <div class="custom-control custom-radio" style="margin-left: 15px;">
                                                        <input class="custom-control-input uncheck" type="radio"
                                                            id="RdoLightsRStatusGood" name="lightsrstatus" value="1">
                                                        <label for="RdoLightsRStatusGood"
                                                            class="custom-control-label">Good</label>
                                                    </div>
                                                    <div class="custom-control custom-radio" style="margin-left: 15px;">
                                                        <input class="custom-control-input uncheck" type="radio"
                                                            id="RdoLightsRStatusNoGood" name="lightsrstatus" value="0">
                                                        <label for="RdoLightsRStatusNoGood" class="custom-control-label">No
                                                            Good</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="input-group input-group-sm mb-4">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Battery</span>
                                                </div>
                                                <div class="w-50"
                                                    style="border-style: solid; border-width: 1px; border-color: #d5deeb;">
                                                    <div class="custom-control custom-radio" style="margin-left: 15px;">
                                                        <input class="custom-control-input uncheck" type="radio"
                                                            id="RdoBatteryStatusGood" name="batterystatus" value="1">
                                                        <label for="RdoBatteryStatusGood"
                                                            class="custom-control-label">Good</label>
                                                    </div>
                                                    <div class="custom-control custom-radio" style="margin-left: 15px;">
                                                        <input class="custom-control-input uncheck" type="radio"
                                                            id="RdoBatteryStatusNoGood" name="batterystatus" value="0">
                                                        <label for="RdoBatteryStatusNoGood" class="custom-control-label">No
                                                            Good</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="input-group input-group-sm mb-4">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Draining of
                                                        Rechargeable Battery</span>
                                                </div>
                                                <div class="w-50"
                                                    style="border-style: solid; border-width: 1px; border-color: #d5deeb;">
                                                    <div class="custom-control custom-radio" style="margin-left: 15px;">
                                                        <input class="custom-control-input uncheck" type="radio"
                                                            id="RdoDrainingofBatteryStatusDone" name="drainingbatterystatus"
                                                            value="1">
                                                        <label for="RdoDrainingofBatteryStatusDone"
                                                            class="custom-control-label">Done</label>
                                                    </div>
                                                    <div class="custom-control custom-radio" style="margin-left: 15px;">
                                                        <input class="custom-control-input uncheck" type="radio"
                                                            id="RdoDrainingofBatteryStatusNG" name="drainingbatterystatus"
                                                            value="0">
                                                        <label for="RdoDrainingofBatteryStatusNG" class="custom-control-label">
                                                            < 5 min No Good</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="input-group input-group-sm mb-4">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Inspection
                                                        Card</span>
                                                </div>
                                                <div class="w-50"
                                                    style="border-style: solid; border-width: 1px; border-color: #d5deeb;">
                                                    <div class="custom-control custom-radio" style="margin-left: 15px;">
                                                        <input class="custom-control-input uncheck" type="radio"
                                                            id="RdoInspCardStatusUpdated" name="inspcardstatus" value="1">
                                                        <label for="RdoInspCardStatusUpdated"
                                                            class="custom-control-label">Updated</label>
                                                    </div>
                                                    <div class="custom-control custom-radio" style="margin-left: 15px;">
                                                        <input class="custom-control-input uncheck" type="radio"
                                                            id="RdoInspCardStatusNotUpdated" name="inspcardstatus" value="0">
                                                        <label for="RdoInspCardStatusNotUpdated"
                                                            class="custom-control-label">Not Updated</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Remarks</span>
                                                </div>
                                                <textarea class="form-control reset-value" rows="3" placeholder="Enter ..."
                                                    name="remarks_el" id="txtRemarksEL"></textarea>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="modal-footer">
                                            <div class="col-sm">
                                                <button type="submit" id="btnSubmitCREL" class="btn btn-dark"
                                                    style="float: right"><i id="ibtnSubmitCRELIcon"
                                                        class="fa fa-plus"></i> Add Checksheet Findings</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-7">
                                    <h3>Checksheet Findings</h3>
                                    <div class="dt-responsive table-responsive">
                                        <br>
                                        <table id="tbl_criteria_el" class="table table-striped table-bordered"
                                            style="width: 100%; font-size: 90%;">
                                            <thead>
                                                <tr>
                                                    <th>Control Number</th>
                                                    <th>Location</th>
                                                    <th>Lights - L</th>
                                                    <th>Lights - R</th>
                                                    <th>Battery</th>
                                                    <th>Draining of Rechargeable Battery</th>
                                                    <th>Inspection Card</th>
                                                    <th>Remarks</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Exit Light Criteria Modal -->
        <div class="modal fade" id="modalViewEXLCriteria" data-backdrop="static">
            <div class="modal-dialog" style="width:100%;max-width:1750px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fa fa-pencil-square"></i> Periodic Maintenance Checksheets</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>

                    <form method="post" id="formViewEXLCriteria">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-5">
                                    <input type="hidden" id="factoryViewExlCriteria" name="factory_view_exl_criteria">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <h3 class="card-title">
                                                        <i class="fa fa-info-circle"></i>
                                                        Equipment
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            <!-- Equipment -->
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Checksheet
                                                        Name</span>
                                                </div>

                                                <input type="hidden" class="form-control" name="checksheet_id_exl"
                                                    id="txtChecksheetIdEXL" readonly>
                                                <input type="text" class="form-control" name="checksheet_name_exl"
                                                    id="txtChecksheetNameEXL" readonly>

                                            </div>
                                            <!-- Equipment Modal -->
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Date
                                                        Inspected</span>
                                                </div>

                                                <input type="text" class="form-control" name="date_inspected_checksheet_exl"
                                                    id="txtDateInspectedCSEXL" readonly>

                                            </div>

                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">General Area</span>
                                                </div>
                                                <select class="form-control sel-general-area-exl reset-value" name="general_area_exl" id="slctGeneralAreaEXL">
                                                    {{-- id="slctGeneralAreaEXL" onchange="checklistChangeEXL(this);">
                                                    <option selected disabled value="">Select General Area</option>
                                                    <option value="1">Factory 1 Ground Floor</option>
                                                    <option value="2">Factory 1 Second Floor</option>
                                                    <option value="3">Factory 2 Ground Floor</option>
                                                    <option value="4">Factory 2 Second Floor</option> --}}
                                                </select>
                                            </div>

                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Location</span>
                                                </div>
                                                <select class="form-control sel-location-exl reset-value" name="location_exl"
                                                    id="slctLocationEXL" disabled>
                                                    {{-- <option value="">Select a Location</option> --}}
                                                </select>
                                            </div>

                                            <div class="input-group input-group-sm mb-4">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Lights Status</span>
                                                </div>

                                                <div class="w-50"
                                                    style="border-style: solid; border-width: 1px; border-color: #d5deeb;">
                                                    <div class="custom-control custom-radio" style="margin-left: 15px;">
                                                        <input class="custom-control-input uncheck" type="radio"
                                                            id="RdoLightStatusGoodEXL" name="lightstatusexl" value="1">
                                                        <label for="RdoLightStatusGoodEXL"
                                                            class="custom-control-label">Good</label>
                                                    </div>
                                                    <div class="custom-control custom-radio" style="margin-left: 15px;">
                                                        <input class="custom-control-input uncheck" type="radio"
                                                            id="RdoLightStatusNoGoodEXL" name="lightstatusexl" value="0">
                                                        <label for="RdoLightStatusNoGoodEXL" class="custom-control-label">No
                                                            Good</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="input-group input-group-sm mb-4">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Battery
                                                        Status</span>
                                                </div>
                                                <div class="w-50"
                                                    style="border-style: solid; border-width: 1px; border-color: #d5deeb;">
                                                    <div class="custom-control custom-radio" style="margin-left: 15px;">
                                                        <input class="custom-control-input uncheck" type="radio"
                                                            id="RdoBatteryStatusGoodEXL" name="batterystatusexl" value="1">
                                                        <label for="RdoBatteryStatusGoodEXL"
                                                            class="custom-control-label">Good</label>
                                                    </div>
                                                    <div class="custom-control custom-radio" style="margin-left: 15px;">
                                                        <input class="custom-control-input uncheck" type="radio"
                                                            id="RdoBatteryStatusNoGoodEXL" name="batterystatusexl" value="0">
                                                        <label for="RdoBatteryStatusNoGoodEXL" class="custom-control-label">No
                                                            Good</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Remarks</span>
                                                </div>
                                                <textarea class="form-control reset-value" rows="3" placeholder="Enter ..."
                                                    name="remarks_exl" id="txtRemarksEXL"></textarea>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="modal-footer">
                                            <div class="col-sm">
                                                <button type="submit" id="btnSubmitCREXL" class="btn btn-dark"
                                                    style="float: right"><i id="ibtnSubmitCREXLIcon"
                                                        class="fa fa-plus"></i> Add Checksheet Findings</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-7">
                                    <h3>Checksheet Findings</h3>
                                    <div class="dt-responsive table-responsive">
                                        <br>
                                        <table id="tbl_criteria_exl" class="table table-striped table-bordered"
                                            style="width: 100%; font-size: 90%;">
                                            <thead>
                                                <tr>
                                                    <th>Location</th>
                                                    <th>Light Status</th>
                                                    <th>Battery</th>
                                                    <th>Remarks</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Fire Extinguisher Criteria Modal -->
        <div class="modal fade" id="modalViewFECriteria" data-backdrop="static">
            <div class="modal-dialog" style="width:100%;max-width:1750px;">
                <div class="modal-content">

                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fa fa-pencil-square"></i> Periodic Maintenance Checksheets</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>

                    <form method="post" id="formViewFECriteria">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-5">
                                    <input type="hidden" id="factoryViewFeCriteria" name="factory_view_fe_criteria">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <h3 class="card-title">
                                                        <i class="fa fa-info-circle"></i>
                                                        Maintenance Checksheet
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            <!-- Equipment -->
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Checksheet
                                                        Name</span>
                                                </div>

                                                <input type="hidden" class="form-control" name="checksheet_id_fe"
                                                    id="txtChecksheetIdFE" readonly>
                                                <input type="text" class="form-control" name="checksheet_name_fe"
                                                    id="txtChecksheetNameFE" readonly>

                                            </div>
                                            <!-- Equipment Model -->
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Date
                                                        Inspected</span>
                                                </div>

                                                <input type="text" class="form-control" name="date_inspected_checksheet_fe"
                                                    id="txtDateInspectedCSFE" readonly>

                                            </div>

                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">General Area</span>
                                                </div>
                                                <select class="form-control sel-general-area-fe reset-value" name="general_area_fe"id="slctGeneralAreaFE">
                                                    {{-- id="slctGeneralAreaFE" onchange="checklistChangeFE(this);">
                                                    <option selected disabled value="">Select a General Area</option>
                                                    <option value="1">Factory 1 Ground Floor</option>
                                                    <option value="2">Factory 1 PPS Production</option>
                                                    <option value="3">Factory 1 Second Floor</option>
                                                    <option value="4">Factory 2 Ground Floor</option>
                                                    <option value="5">Factory 2 Second Floor</option> --}}
                                                </select>
                                            </div>

                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Control
                                                        Number</span>
                                                </div>
                                                <select class="form-control sel-control-no-fe reset-value" name="control_number_fe"
                                                    id="slctControlNumberFE" disabled>
                                                    {{-- <option value="">Select a Control Number</option> --}}
                                                </select>
                                            </div>

                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100"
                                                        id="basic-addon1">Classification</span>
                                                </div>
                                                <select class="form-control sel-classification-fe reset-value" name="classification_fe"
                                                    id="slctClassificationFE" disabled>
                                                    {{-- <option selected disabled value="">Select Classification</option>
                                                    <option value="Dry Chemical">Dry Chemical</option>
                                                    <option value="Carbon Dioxide">Carbon Dioxide</option>
                                                    <option value="HCFC 123">HCFC 123</option>
                                                    <option value="Wet Chemical">Wet Chemical</option>
                                                    <option value="HALOTRON">HALOTRON</option> --}}
                                                </select>
                                            </div>

                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Location</span>
                                                </div>

                                                <input type="text" class="form-control getLocation reset-value" name="location_fe"
                                                    id="txtLocationFE" readonly>

                                            </div>

                                            <div class="input-group input-group-sm mb-4">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Lever</span>
                                                </div>

                                                <div class="w-50"
                                                    style="border-style: solid; border-width: 1px; border-color: #d5deeb;">
                                                    <div class="custom-control custom-radio" style="margin-left: 15px;">
                                                        <input class="custom-control-input uncheck" type="radio"
                                                            id="RdoLeverStatusGood" name="leverstatus" value="1">
                                                        <label for="RdoLeverStatusGood"
                                                            class="custom-control-label">Good</label>
                                                    </div>
                                                    <div class="custom-control custom-radio" style="margin-left: 15px;">
                                                        <input class="custom-control-input uncheck" type="radio"
                                                            id="RdoLeverStatusNoGood" name="leverstatus" value="0">
                                                        <label for="RdoLeverStatusNoGood" class="custom-control-label">No
                                                            Good</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="input-group input-group-sm mb-4">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Hose and
                                                        Nozzle</span>
                                                </div>
                                                <div class="w-50"
                                                    style="border-style: solid; border-width: 1px; border-color: #d5deeb;">
                                                    <div class="custom-control custom-radio" style="margin-left: 15px;">
                                                        <input class="custom-control-input uncheck" type="radio" id="RdoHoseStatusGood"
                                                            name="hosestatus" value="1">
                                                        <label for="RdoHoseStatusGood"
                                                            class="custom-control-label">Good</label>
                                                    </div>
                                                    <div class="custom-control custom-radio" style="margin-left: 15px;">
                                                        <input class="custom-control-input uncheck" type="radio"
                                                            id="RdoHoseStatusNoGood" name="hosestatus" value="0">
                                                        <label for="RdoHoseStatusNoGood" class="custom-control-label">No
                                                            Good</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="input-group input-group-sm mb-4">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">CYL. Tank</span>
                                                </div>
                                                <div class="w-50"
                                                    style="border-style: solid; border-width: 1px; border-color: #d5deeb;">
                                                    <div class="custom-control custom-radio" style="margin-left: 15px;">
                                                        <input class="custom-control-input uncheck" type="radio"
                                                            id="RdoCylTankStatusGood" name="cyltankstatus" value="1">
                                                        <label for="RdoCylTankStatusGood"
                                                            class="custom-control-label">Good</label>
                                                    </div>
                                                    <div class="custom-control custom-radio" style="margin-left: 15px;">
                                                        <input class="custom-control-input uncheck" type="radio"
                                                            id="RdoCylTankStatusNoGood" name="cyltankstatus" value="0">
                                                        <label for="RdoCylTankStatusNoGood" class="custom-control-label">No
                                                            Good</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="input-group input-group-sm mb-4">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Press Gauge</span>
                                                </div>
                                                <div class="w-50"
                                                    style="border-style: solid; border-width: 1px; border-color: #d5deeb;">
                                                    <div class="custom-control custom-radio" style="margin-left: 15px;">
                                                        <input class="custom-control-input uncheck" type="radio"
                                                            id="RdoPressGaugeStatusGood" name="pressgaugestatus" value="1">
                                                        <label for="RdoPressGaugeStatusGood" class="custom-control-label">195
                                                            PSI</label>
                                                    </div>
                                                    <div class="custom-control custom-radio" style="margin-left: 15px;">
                                                        <input class="custom-control-input uncheck" type="radio"
                                                            id="RdoPressGaugeStatusNoGood" name="pressgaugestatus" value="0">
                                                        <label for="RdoPressGaugeStatusNoGood"
                                                            class="custom-control-label">Below 195 PSI</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Capacity
                                                        (LBS)</span>
                                                </div>

                                                <input type="text" class="form-control reset-value" name="capacity_fe"
                                                    id="txtCapacityFE">

                                            </div>

                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Remarks</span>
                                                </div>
                                                <textarea class="form-control reset-value" rows="3" placeholder="Enter ..."
                                                    name="remarks_fe" id="txtRemarksFE"></textarea>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="modal-footer">
                                            <div class="col-sm">
                                                <button type="submit" id="btnSubmitCRFE" class="btn btn-dark"
                                                    style="float: right"><i id="ibtnSubmitCRFEIcon"
                                                        class="fa fa-plus"></i> Add Checksheet Findings</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-7">
                                    <h3>Checksheet Findings</h3>
                                    <div class="dt-responsive table-responsive">
                                        <br>
                                        <table id="tbl_criteria_fe" class="table table-striped table-bordered"
                                            style="width: 100%; font-size: 90%;">
                                            <thead>
                                                <tr>
                                                    <th>Control Number</th>
                                                    <th>Classification</th>
                                                    <th>Location</th>
                                                    <th>Lever</th>
                                                    <th>Hose and Nozzle</th>
                                                    <th>Cyl. Tank</th>
                                                    <th>Press Gauge</th>
                                                    <th>Capacity (LBS)</th>
                                                    <th>Remarks</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Fire Hose Cabinet Criteria Modal -->
        <div class="modal fade" id="modalViewFHCriteria" data-backdrop="static">
            <div class="modal-dialog" style="width:100%;max-width:1750px;">
                <div class="modal-content">

                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fa fa-pencil-square"></i> Periodic Maintenance Checksheets</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>

                    <form method="post" id="formViewFHCriteria">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-5">
                                    <input type="hidden" id="factoryViewFhCriteria" name="factory_view_fh_criteria">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <h3 class="card-title">
                                                        <i class="fa fa-info-circle"></i>
                                                        Maintenance Checksheet
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            <!-- Equipment -->
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Checksheet
                                                        Name</span>
                                                </div>

                                                <input type="hidden" class="form-control" name="checksheet_id_fh"
                                                    id="txtChecksheetIdFH" readonly>
                                                <input type="text" class="form-control" name="checksheet_name_fh"
                                                    id="txtChecksheetNameFH" readonly>

                                            </div>
                                            <!-- Equipment Model -->
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Date
                                                        Inspected</span>
                                                </div>

                                                <input type="text" class="form-control" name="date_inspected_checksheet_fh"
                                                    id="txtDateInspectedCSFH" readonly>

                                            </div>

                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">General Area</span>
                                                </div>
                                                <select class="form-control sel-general-area-fh reset-value" name="general_area_fh" id="slctGeneralAreaFH"></select>
                                                    {{-- id="slctGeneralAreaFH" onchange="checklistChangeFH(this);">
                                                    <option selected disabled value="">Select a General Area</option>
                                                    <option value="1">Factory 1</option>
                                                    <option value="2">Factory 2</option> --}}
                                                </select>
                                            </div>

                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Control
                                                        Number</span>
                                                </div>
                                                <select class="form-control sel-control-no-fh reset-value" name="control_number_fh"
                                                    id="slctControlNumberFH" disabled>
                                                    {{-- <option value="">Select a Control Number</option> --}}
                                                </select>
                                            </div>

                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Location</span>
                                                </div>

                                                <input type="text" class="form-control getLocation reset-value" name="location_fh"
                                                    id="txtLocationFH" readonly>
                                            </div>

                                            <div class="input-group input-group-sm mb-4">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Cabinet</span>
                                                </div>

                                                <div class="w-50"
                                                    style="border-style: solid; border-width: 1px; border-color: #d5deeb;">
                                                    <div class="custom-control custom-radio" style="margin-left: 15px;">
                                                        <input class="custom-control-input uncheck" type="radio"
                                                            id="RdoCabinetStatusGood" name="cabinetstatus" value="1">
                                                        <label for="RdoCabinetStatusGood"
                                                            class="custom-control-label">Good</label>
                                                    </div>
                                                    <div class="custom-control custom-radio" style="margin-left: 15px;">
                                                        <input class="custom-control-input uncheck" type="radio"
                                                            id="RdoCabinetStatusNoGood" name="cabinetstatus" value="0">
                                                        <label for="RdoCabinetStatusNoGood" class="custom-control-label">No
                                                            Good</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="input-group input-group-sm mb-4">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Hose</span>
                                                </div>
                                                <div class="w-50"
                                                    style="border-style: solid; border-width: 1px; border-color: #d5deeb;">
                                                    <div class="custom-control custom-radio" style="margin-left: 15px;">
                                                        <input class="custom-control-input uncheck" type="radio"
                                                            id="RdoHoseStatusGoodFH" name="hosestatusfh" value="1">
                                                        <label for="RdoHoseStatusGoodFH"
                                                            class="custom-control-label">Good</label>
                                                    </div>
                                                    <div class="custom-control custom-radio" style="margin-left: 15px;">
                                                        <input class="custom-control-input uncheck" type="radio"
                                                            id="RdoHoseStatusNoGoodFH" name="hosestatusfh" value="0">
                                                        <label for="RdoHoseStatusNoGoodFH" class="custom-control-label">No
                                                            Good</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="input-group input-group-sm mb-4">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Nozzle</span>
                                                </div>
                                                <div class="w-50"
                                                    style="border-style: solid; border-width: 1px; border-color: #d5deeb;">
                                                    <div class="custom-control custom-radio" style="margin-left: 15px;">
                                                        <input class="custom-control-input uncheck" type="radio"
                                                            id="RdoNozzleStatusGood" name="nozzlestatus" value="1">
                                                        <label for="RdoNozzleStatusGood"
                                                            class="custom-control-label">Good</label>
                                                    </div>
                                                    <div class="custom-control custom-radio" style="margin-left: 15px;">
                                                        <input class="custom-control-input uncheck" type="radio"
                                                            id="RdoNozzleStatusNoGood" name="nozzlestatus" value="0">
                                                        <label for="RdoNozzleStatusNoGood" class="custom-control-label">No
                                                            Good</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="input-group input-group-sm mb-4">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Pipeline</span>
                                                </div>
                                                <div class="w-50"
                                                    style="border-style: solid; border-width: 1px; border-color: #d5deeb;">
                                                    <div class="custom-control custom-radio" style="margin-left: 15px;">
                                                        <input class="custom-control-input uncheck" type="radio"
                                                            id="RdoPipelineStatusGood" name="pipelinestatus" value="1">
                                                        <label for="RdoPipelineStatusGood"
                                                            class="custom-control-label">Good</label>
                                                    </div>
                                                    <div class="custom-control custom-radio" style="margin-left: 15px;">
                                                        <input class="custom-control-input uncheck" type="radio"
                                                            id="RdoPipelineStatusNoGood" name="pipelinestatus" value="0">
                                                        <label for="RdoPipelineStatusNoGood" class="custom-control-label">No
                                                            Good</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="input-group input-group-sm mb-4">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Valve</span>
                                                </div>
                                                <div class="w-50"
                                                    style="border-style: solid; border-width: 1px; border-color: #d5deeb;">
                                                    <div class="custom-control custom-radio" style="margin-left: 15px;">
                                                        <input class="custom-control-input uncheck" type="radio"
                                                            id="RdoValveStatusGood" name="valvestatus" value="1">
                                                        <label for="RdoValveStatusGood"
                                                            class="custom-control-label">Good</label>
                                                    </div>
                                                    <div class="custom-control custom-radio" style="margin-left: 15px;">
                                                        <input class="custom-control-input uncheck" type="radio"
                                                            id="RdoValveStatusNoGood" name="valvestatus" value="0">
                                                        <label for="RdoValveStatusNoGood" class="custom-control-label">No
                                                            Good</label>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Remarks</span>
                                                </div>
                                                <textarea class="form-control reset-value" rows="3" placeholder="Enter ..."
                                                    name="remarks_fh" id="txtRemarksFH"></textarea>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="modal-footer">
                                            <div class="col-sm">
                                                <button type="submit" id="btnSubmitCRFH" class="btn btn-dark"
                                                    style="float: right"><i id="ibtnSubmitCRFHIcon"
                                                        class="fa fa-plus"></i> Add Checksheet Findings</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-7">
                                    <h3>Checksheet Findings</h3>
                                    <div class="dt-responsive table-responsive">
                                        <br>
                                        <table id="tbl_criteria_fh" class="table table-striped table-bordered"
                                            style="width: 100%; font-size: 90%;">
                                            <thead>
                                                <tr>
                                                    <th>Control Number</th>
                                                    <th>Location</th>
                                                    <th>Cabinet</th>
                                                    <th>Hose</th>
                                                    <th>Nozzle</th>
                                                    <th>Pipeline</th>
                                                    <th>Valve</th>
                                                    <th>Remarks</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!--Submit Checksheet-->
        <div class="modal fade" id="modalSubmitChecksheet" data-backdrop="static">
            <div class="modal-dialog modal-md">
                <div class="modal-content">

                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fa fa-check-circle"></i> Submit Checksheet</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <form method="post" id="formSubmitChecksheet">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" class="form-control" name="submit_checksheet_id"
                                id="txtSubmitChecksheetId" readonly>
                            <input type="hidden" class="form-control" name="checksheet_status"
                                id="txtChecksheetStatus" readonly>
                            <div class="card p-3">
                                <center>
                                    <!-- <label>Are you sure you want to submit this checksheet?</label> -->
                                    <strong>NOTED BY ( APPROVER )</strong>
                                </center>
                                <hr>
                                <!-- Noted By: Sr. Supervisor -->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend w-50">
                                        <span class="input-group-text w-100 font-style"><strong>Sr. Supervisor</strong></span>
                                    </div>
                                    <select class="form-control sel-noted-by-sr-supervisor" name="sr_supervisor" id="slctSrSupervisor" required></select>

                                </div>
                                <!-- Noted By: Manager -->
                                <div class="input-group">
                                    <div class="input-group-prepend w-50">
                                        <span class="input-group-text w-100 font-style"><strong>Manager</strong></span>
                                    </div>
                                    <select class="form-control sel-noted-by-manager" name="manager" id="slctManager" required></select>
                                </div>
                                <hr>
                                <button type="submit" class="btn btn btn-success" approval='1' id="btnSubmitChecksheet"><i
                                        id="iBtnSubmitChecksheet" class="fa fa-check-circle"></i> Submit Checksheet</button>
                            </div>
                            <!-- <button type="button" class="btn btn-sm btn-default mr-auto" data-dismiss="modal"
                            id="btnClose"> Close</button> -->
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!--Approve Checksheet (Supervisor)-->
        <div class="modal fade" id="modalSupervisorApproveChecksheet" data-backdrop="static">
            <div class="modal-dialog modal-md">
                <div class="modal-content">

                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fa fa-check-circle"></i> Approve Checksheet</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <form method="post" id="formSupervisorApproveChecksheet">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <input type="hidden" class="form-control" name="supervisor_approve_checksheet_id"
                                        id="txtSupervisorApproveChecksheetId" readonly>
                                    <input type="hidden" class="form-control" name="supervisor_approve_checksheet_status"
                                        id="txtSupervisorApproveChecksheetStatus" readonly>
                                    <center>
                                        <label>Are you sure you want to approve / disapprove this checksheet?</label>
                                        {{-- <label>Are you sure you want to approve this checksheet?</label> --}}
                                        <label>__________________________________________________________</label>
                                        <br>
                                        <label>Approval / Disapproval Remarks</label>
                                        {{-- <label>Approval Remarks</label> --}}
                                        <textarea class="form-control" rows="3" placeholder="Enter ..."
                                            name="supervisor_approve_checksheet_remarks"
                                            id="txtSupervisorApproveChecksheetRemarks"></textarea>
                                    </center>
                                </div>
                            </div>

                            <div class="row">
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-danger mr-auto" approval_s='4'
                                    id="btnSupervisorDisapproveChecksheet"><i id="iBtnSupervisorDisapproveChecksheet"
                                        class="fa fa-check-circle"></i> Disapprove Checksheet</button>

                                <button type="button" class="btn btn btn-success" approval_s='2'
                                    id="btnSupervisorApproveChecksheet"><i id="iBtnSupervisorApproveChecksheet"
                                        class="fa fa-check-circle"></i> Approve Checksheet</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--Submit Checksheet (Manager)-->
        <div class="modal fade" id="modalManagerApproveChecksheet" data-backdrop="static">
            <div class="modal-dialog modal-md">
                <div class="modal-content">

                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fa fa-check-circle"></i> Approve Checksheet</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <form method="post" id="formManagerApproveChecksheet">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <input type="hidden" class="form-control" name="manager_approve_checksheet_id"
                                        id="txtManagerApproveChecksheetId" readonly>
                                    <input type="hidden" class="form-control" name="manager_approve_checksheet_status"
                                        id="txtManagerApproveChecksheetStatus" readonly>
                                    <center>
                                        <label>Are you sure you want to approve / disapprove this checksheet?</label>
                                        {{-- <label>Are you sure you want to approve this checksheet?</label> --}}
                                        <label>__________________________________________________________</label>
                                        <br>
                                        <label>Approval / Disapproval Remarks</label>
                                        {{-- <label>Approval Remarks</label> --}}
                                        <textarea class="form-control" rows="3" placeholder="Enter ..."
                                            name="manager_approve_checksheet_remarks"
                                            id="txtManagerApproveChecksheetRemarks"></textarea>
                                    </center>
                                </div>
                            </div>

                            <div class="row">
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-danger mr-auto" approval_m='4'
                                    id="btnManagerDisapproveChecksheet"><i id="iBtnManagerDisapproveChecksheet"
                                        class="fa fa-check-circle"></i> Disapprove Checksheet</button>

                                <button type="button" class="btn btn btn-success" approval_m='3'
                                    id="btnManagerApproveChecksheet"><i id="iBtnManagerApproveChecksheet"
                                        class="fa fa-check-circle"></i> Approve Checksheet</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" tabindex="-1" role="dialog" id="exportmodalchecksheet">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Export Requests</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            >&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form id="daterangerequests" name="daterangerequests" method="post" enctype="multipart/form-data">
                            <meta name="csrf-token" content="{{ csrf_token() }}">
                            <h4>Enter a date range </h4>
                            <label>Start Date:</label>
                            <input class="form-control" type="date" id="txt_date_start" name="txt_date_start" required>
                            <label>End Date:</label>
                            <input class="form-control" type="date" id="txt_date_end" name="txt_date_end" required>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" id="export_report_summary_requests">Export</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


    @endsection

    @section('js_content')
        <script type="text/javascript">
            let factory; // CHAN 01-16-25 - new
            let dt_equipments;
            let dt_pending_checksheets;
            let dt_approval_checksheets;
            let dt_approved_checksheets;
            let checksheetFactory
            let deviceID
            let drawDataTable = 0;
            $(document).ready(function() {
                //Initialize Select2 Elements
                $('.select2').select2();

                //Initialize Select2 Elements
                $('.select2bs4').select2({
                    theme: 'bootstrap4'
                });
                bsCustomFileInput.init();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                // Datatable of Equipments
                dt_equipments = $('#tbl_equipments').DataTable({
                    "processing": false,
                    "serverSide": true,
                    "destroy"   : true,
                    "pageLength" : 100,
                    "ajax": {
                        url: "view_device_table",
                        data: function(param) {
                            param.factory = factory // CHAN 01-16-25 - new
                        }
                    },
                    "columns": [
                        {
                            "data": "id"
                        },
                        {
                            "data": "device_name"
                        },
                        {
                            "data": "action",
                            orderable: false,
                            searchable: false
                        },

                    ],
                });

                // START - CHAN 01-16-25
                $('#factory').change(function (e) { 
                    e.preventDefault();
                    factory = $(this).val()
                    // CHAN - 02-17-2025
                    dt_equipments.draw();
                });
                // $('#btnNewEquipment').click(function (e) { 
                //     e.preventDefault();
                //     if($('#factory').val() != null){
                //         $('#changeTitle').text('New Equipment for Factory ' + $('#factory').val())
                //         $('#modalNewEquipment').modal('show')
                //     }else{
                //         alert('Select Factory')
                        
                //     }
                // });
                 // END - CHAN 01-16-25


                //  Datatable of Checksheets
                dt_pending_checksheets = $('#tbl_checksheets').DataTable({

                    "processing": true,
                    "serverSide": true,
                    "destroy": true,
                    "order": [[ 2, "desc" ]],
                    "ajax": {
                        url: "view_checksheets_table",
                        data: function(param) {
                            param.device_id = $("#txtDeviceId").val();
                        }
                    },

                    "columns": [

                        {
                            "data": "status"
                        },
                        {
                            "data": "checksheet_name"
                        },
                        {
                            "data": "date_inspected"
                        },
                        {
                            "data": "checked_by"
                        },
                        {
                            "data": "noted_by_supervisor"
                        },
                        {
                            "data": "supervisor_remarks"
                        },
                        {
                            "data": "noted_by_manager"
                        },
                        {
                            "data": "manager_remarks"
                        },
                        {
                            "data": "checksheet_action",
                            orderable: false,
                            searchable: false
                        },

                    ],
                });

                //  Datatable of Checksheets
                dt_approval_checksheets = $('#tbl_approval_checksheets').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "order": [[ 0, "desc" ],[ 2, "desc" ]],
                    "ajax": {
                        url: "view_approval_checksheets_table",
                        data: function(param) {
                            param.device_id = $("#txtDeviceId").val();
                        }
                    },

                    "columns": [
                        {"data": "status"},
                        {"data": "checksheet_name"},
                        {"data": "date_inspected"},
                        {"data": "checked_by"},
                        {"data": "noted_by_supervisor"},
                        {"data": "supervisor_remarks"},
                        {"data": "noted_by_manager"},
                        {"data": "manager_remarks"},
                        {"data": "checksheet_action", orderable: false, searchable: false},
                    ],
                });

                //  Datatable of Checksheets
                dt_approved_checksheets = $('#tbl_approved_checksheets').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        url: "view_approved_checksheets_table",
                        data: function(param) {
                            param.device_id = $("#txtDeviceId").val();
                        }
                    },

                    "columns": [
                        {"data": "status"},
                        {"data": "checksheet_name"},
                        {"data": "date_inspected"},
                        {"data": "checked_by"},
                        {"data": "noted_by_supervisor"},
                        {"data": "supervisor_remarks"},
                        {"data": "noted_by_manager"},
                        {"data": "manager_remarks"},
                        {"data": "checksheet_action", orderable: false, searchable: false},
                    ],
                });

                // Datatable of Criterion / Maintenance Result
                dt_criteria = $('#tbl_criteria').DataTable({

                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        url: "view_criteria_table",
                        data: function(param) {
                            param.checksheet_id = $("#txtChecksheetId").val();
                        }
                    },

                    "columns": [

                        {
                            "data": "checklist"
                        },
                        {
                            "data": "requirement"
                        },
                        {
                            "data": "general_area"
                        },
                        {
                            "data": "control_no"
                        },
                        {
                            "data": "location"
                        },
                        {
                            "data": "classification"
                        },
                        {
                            "data": "status_good"
                        },
                        {
                            "data": "status_no_good"
                        },
                        {
                            "data": "remarks"
                        },

                    ],
                });

                // Datatable of Emergency Light Criterion / Maintenance Result
                dt_criteria_el = $('#tbl_criteria_el').DataTable({

                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        url: "view_criteria_table_el",
                        data: function(param) {
                            param.checksheet_id = $("#txtChecksheetId").val();
                        }
                    },

                    "columns": [

                        {
                            "data": "control_number"
                        },
                        {
                            "data": "location"
                        },
                        {
                            "data": "lights_l"
                        },
                        {
                            "data": "lights_r"
                        },
                        {
                            "data": "battery"
                        },
                        {
                            "data": "draining_of_rechargeable_battery"
                        },
                        {
                            "data": "inspection_card"
                        },
                        {
                            "data": "remarks"
                        },

                    ],
                });

                // Datatable of Exit Light Criterion / Maintenance Result
                dt_criteria_exl = $('#tbl_criteria_exl').DataTable({

                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        url: "view_criteria_table_exl",
                        data: function(param) {
                            param.checksheet_id = $("#txtChecksheetId").val();
                        }
                    },

                    "columns": [

                        {
                            "data": "location"
                        },
                        {
                            "data": "light_status"
                        },
                        {
                            "data": "battery_status"
                        },
                        {
                            "data": "remarks"
                        },

                    ],
                });

                // Datatable of Fire Extinguisher Criterion / Maintenance Result
                dt_criteria_fe = $('#tbl_criteria_fe').DataTable({

                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        url: "view_criteria_table_fe",
                        data: function(param) {
                            param.checksheet_id = $("#txtChecksheetId").val();
                        }
                    },

                    "columns": [

                        {
                            "data": "control_number"
                        },
                        {
                            "data": "classification"
                        },
                        {
                            "data": "location"
                        },
                        {
                            "data": "lever"
                        },
                        {
                            "data": "hose_and_nozzle"
                        },
                        {
                            "data": "cyl_tank"
                        },
                        {
                            "data": "press_gauge"
                        },
                        {
                            "data": "capacity"
                        },
                        {
                            "data": "remarks"
                        },

                    ],
                });

                // Datatable of Fire hose cabinet Criterion / Maintenance Result
                dt_criteria_fh = $('#tbl_criteria_fh').DataTable({

                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        url: "view_criteria_table_fh",
                        data: function(param) {
                            param.checksheet_id = $("#txtChecksheetId").val();
                        }
                    },

                    "columns": [

                        {
                            "data": "control_number"
                        },
                        {
                            "data": "location"
                        },
                        {
                            "data": "cabinet"
                        },
                        {
                            "data": "hose"
                        },
                        {
                            "data": "nozzle"
                        },
                        {
                            "data": "pipeline"
                        },
                        {
                            "data": "valve"
                        },
                        {
                            "data": "remarks"
                        },

                    ],
                });
                // Get Device details by ID
                $(document).on('click', '.btn-view-checksheets', function() {
                    let deviceId = $(this).attr('devices-id');
                    $("#txtDeviceId").val(deviceId);
                    GetDevicesById(deviceId);
                    $('#viewCheckSheetTitle').text('Periodic Maintenance Checksheets for Factory ' + $('#factory').val())
                    GetEquipmentModel($('.sel-equipment-model'),deviceId)
                });

                // CHAN - 08-05-2025
                function CommonFunction(getAttr, sectionClass, fieldClass) {
                    if (getAttr == '1') {
                        $(sectionClass).removeClass('d-none');
                        $(fieldClass).prop('disabled', false);
                    } else if (getAttr == '0') {
                        $(sectionClass).addClass('d-none');
                        $(fieldClass).prop('disabled', true);
                    }
                }

                // Get Checksheet details by ID
                $(document).on('click', '.btn-fill-criteria', function() {
                    let checksheetId                = $(this).attr('checksheet-id');
                    let deviceID                    = $(this).attr('checksheet-device_id');
                    let checksheetGeneralArea       = $(this).attr('checksheet-general_area');
                    let checksheetClassification    = $(this).attr('checksheet-classification');

                    checksheetFactory = $(this).attr('checksheet-factory');
                    $("#txtChecksheetId").val(checksheetId);
                    SelectDevice($('.sel-device'),checksheetFactory)
                    GetChecksheetsById(checksheetId);

                    // CHAN - 01-20-25
                    $('#slctChecklist').prop('disabled', true)
                    $('#viewCriteriaTitle').text('Periodic Maintenance Checksheets for Factory '+$('#factory').val())
                    $('#checkSheetFindingsTitle').text('Checksheet Findings for Factory '+$('#factory').val())

                    // CHAN - 08-05-2025
                    $('#equipmentGetGeneralArea').val(checksheetGeneralArea)
                    $('#equipmentGetClassication').val(checksheetClassification)

                    if(checksheetGeneralArea == '1'){
                        GetGeneralArea($('.sel-general-area'),deviceID);
                    }
                    if(checksheetClassification == '1'){
                        GetClassification($('.sel-classification'),deviceID)
                    }
                });

                $('#slctEquipmentGeneralArea').change(function (e) { 
                    GetControlNo($('.sel-control-no'),$(this).val())
                });

                $('#slctEquipmentGeneralAreaControlNumber').change(function (e) { 
                    GetGeneralAreaLocation($('#slctEquipmentGeneralArea').val(),$(this).val())
                });
                // CHAN - 01-20-25
                $('#slctEquipmentTemplate').change(function (e) { 
                    e.preventDefault();
                    if($('#slctEquipmentTemplate').val() == null){
                        $('#slctChecklist').prop('disabled', true)
                    }else{
                        GetChecklist($('.sel-checklist'),$(this).val())
                        $('#slctChecklist').prop('disabled', false)

                        // CHAN - 08-05-2025
                        CommonFunction($('#equipmentGetGeneralArea').val(), '.generalAreaChecking', '.general_area-disabled-field');
                        CommonFunction($('#equipmentGetClassication').val(), '.classificationChecking', '.classification-disabled-field');
                    }
                    $('#txtRequirement').val('')
                });
                
                $('#slctChecklist').change(function (e) {
                    GetChecklistRequirement($('#slctEquipmentTemplate').val(),$(this).val())
                });

                // Get Checksheet details by ID to View
                $(document).on('click', '.btn-view-criteria', function() {
                    let checksheetId = $(this).attr('checksheet-id');
                    $("#txtChecksheetId").val(checksheetId);
                    GetChecksheetsById(checksheetId);
                    AlterModalBasedOnStatus(checksheetId);
                });

                // Get Checksheet details by ID to Submit
                $(document).on('click', '.btn-submit-checksheet', function() {
                    let checksheetId = $(this).attr('checksheet-id');
                    $("#txtSubmitChecksheetId").val(checksheetId);
                    GetChecksheetsById(checksheetId);
                    GetNotedBy($('.sel-noted-by-sr-supervisor'),$('.sel-noted-by-manager'),$(this).attr('checksheet-factory'));
                });

                // Get Checksheet details by ID to Approve (Supervisor)
                // $(document).on('click', '.btn-approve-checksheet-supervisor', function() { // CHAN 01-20-25 - OLD
                $(document).on('click', '.btn-approve-checksheet-noted_by_supervisor', function() { // CHAN 01-20-25 - NEW
                    let checksheetId = $(this).attr('checksheet-id');
                    console.log('object: ', $(this).attr('checksheet-id'));
                    $("#txtSupervisorApproveChecksheetId").val(checksheetId);
                    GetChecksheetsById(checksheetId);
                });

                // Get Checksheet details by ID to Approve (Manager)
                $(document).on('click', '.btn-approve-checksheet-manager', function() {
                    let checksheetId = $(this).attr('checksheet-id');
                    $("#txtManagerApproveChecksheetId").val(checksheetId);
                    GetChecksheetsById(checksheetId);
                });

                // Get Emergency Light Checksheet details by ID
                $(document).on('click', '.btn-fill-criteria-el', function() {
                    let el_checksheetId = $(this).attr('checksheet-id');
                    deviceID = $(this).attr('checksheet-device_id');
                    $("#txtChecksheetId").val(el_checksheetId);
                    GetGeneralArea($('.sel-general-area-el'),deviceID);
                    GetELChecksheetById(el_checksheetId);
                });

                // Get Emergency Light Checksheet details by ID to View
                $(document).on('click', '.btn-view-criteria-el', function() {
                    let el_checksheetId = $(this).attr('checksheet-id');
                    $("#txtChecksheetId").val(el_checksheetId);
                    GetELChecksheetById(el_checksheetId);
                    AlterModalBasedOnStatusEL(el_checksheetId);
                });

                // Get Exit Light Checksheet details by ID
                $(document).on('click', '.btn-fill-criteria-exl', function() {
                    let exl_checksheetId = $(this).attr('checksheet-id');
                    deviceID = $(this).attr('checksheet-device_id');
                    $("#txtChecksheetId").val(exl_checksheetId);
                    GetGeneralArea($('.sel-general-area-exl'),deviceID);
                    GetEXLChecksheetById(exl_checksheetId);
                });

                // Get Exit Light Checksheet details by ID to View
                $(document).on('click', '.btn-view-criteria-exl', function() {
                    let exl_checksheetId = $(this).attr('checksheet-id');
                    console.log('exl_checksheetId',exl_checksheetId);
                    $("#txtChecksheetId").val(exl_checksheetId);
                    GetEXLChecksheetById(exl_checksheetId);
                    AlterModalBasedOnStatusEXL(exl_checksheetId);
                });

                // Get Fire Extinguisher Checksheet details by ID
                $(document).on('click', '.btn-fill-criteria-fe', function() {
                    let fe_checksheetId = $(this).attr('checksheet-id');
                    deviceID = $(this).attr('checksheet-device_id');
                    $("#txtChecksheetId").val(fe_checksheetId);
                    GetGeneralArea($('.sel-general-area-fe'),deviceID);
                    GetClassification($('.sel-classification-fe'),deviceID)
                    GetFEChecksheetById(fe_checksheetId);
                });

                // Get Fire Extinguisher Checksheet details by ID to View
                $(document).on('click', '.btn-view-criteria-fe', function() {
                    let fe_checksheetId = $(this).attr('checksheet-id');
                    $("#txtChecksheetId").val(fe_checksheetId);
                    GetFEChecksheetById(fe_checksheetId);
                    AlterModalBasedOnStatusFE(fe_checksheetId);
                });

                // Get Fire Hose Cabinet Checksheet details by ID
                $(document).on('click', '.btn-fill-criteria-fh', function() {
                    let fh_checksheetId = $(this).attr('checksheet-id');
                    deviceID = $(this).attr('checksheet-device_id');
                    $("#txtChecksheetId").val(fh_checksheetId);
                    GetFHChecksheetById(fh_checksheetId);
                    GetGeneralArea($('.sel-general-area-fh'),deviceID);
                });

                // Get Fire Hose Cabinet Checksheet details by ID to View
                $(document).on('click', '.btn-view-criteria-fh', function() {
                    let fh_checksheetId = $(this).attr('checksheet-id');
                    $("#txtChecksheetId").val(fh_checksheetId);
                    GetFHChecksheetById(fh_checksheetId);
                    AlterModalBasedOnStatusFH(fh_checksheetId);
                });

                //Add Equipment
                // START - CHAN 01-16-25
                // $('#modalNewEquipment').on('shown.bs.modal', function () {
                //     $('#factoryEquipmentList').val($('#factory').val())
                // });
                 // END - CHAN 01-16-25
                // $("#formCreateUpdateEquipment").submit(function(event) {
                //     event.preventDefault();
                //     AddEquipment();
                // });

                //Add Checksheet
                // START - CHAN 01-16-25
                $('#modalViewChecksheets').on('shown.bs.modal', function () {
                    $('#factoryViewChecksheets').val($('#factory').val())
                }); 
                $('#modalViewChecksheets').on('hidden.bs.modal', function () {
                    $('.reset-value').val('')
                }); 
                // END - CHAN 01-16-25
                $("#formViewChecksheets").submit(function(event) {
                    event.preventDefault();
                    AddCheckSheet();
                });

                //Add Criteria
                // START - CHAN 01-16-25
                $('#modalViewCriteria').on('shown.bs.modal', function () {
                    $('#factoryViewCriteria').val($('#factory').val())
                }); 
                $('#modalViewCriteria').on('hidden.bs.modal', function () {
                    $('.criteria-reset-value').val('')
                    $('.uncheck').each(function(count, value) {
                        let statusUncheck = $(this).attr('id');
                        $('#'+statusUncheck).prop('checked', false)
                    }); 
                
                    // CHAN - 08-05-2025
                    $('.general_area-disabled-field').prop('disbaled', true)
                    $('.generalAreaChecking').addClass('d-none')
                    $('.classification-disabled-field').prop('disbaled', true)
                    $('.classificationChecking').addClass('d-none')
                }); // END - CHAN 01-16-25
                $("#formViewCriteria").submit(function(event) {
                    event.preventDefault();
                    AddMaintenanceResult();
                });

                //Add Criteria Emergency Light
                // START - CHAN 01-20-25
                $('#modalViewELCriteria').on('shown.bs.modal', function () {
                    $('#factoryViewElCriteria').val($('#factory').val())
                }); 
                $("#formViewELCriteria").submit(function(event) {
                    event.preventDefault();
                    AddChecksheetFindings();
                });

                //Add Criteria Emergency Light
                // START - CHAN 01-20-25
                $('#modalViewEXLCriteria').on('shown.bs.modal', function () {
                    $('#factoryViewExlCriteria').val($('#factory').val())
                }); 
                $("#formViewEXLCriteria").submit(function(event) {
                    event.preventDefault();
                    AddChecksheetFindingsEXL();
                });

                //Add Criteria Fire Extinguisher
                // START - CHAN 01-20-25
                $('#modalViewFECriteria').on('shown.bs.modal', function () {
                    $('#factoryViewFeCriteria').val($('#factory').val())
                }); 
                $("#formViewFECriteria").submit(function(event) {
                    event.preventDefault();
                    AddChecksheetFindingsFE();
                });

                //Add Criteria Fire Extinguisher
                // START - CHAN 01-20-25
                $('#modalViewFHCriteria').on('shown.bs.modal', function () {
                    $('#factoryViewFhCriteria').val($('#factory').val())
                }); 
                $("#formViewFHCriteria").submit(function(event) {
                    event.preventDefault();
                    AddChecksheetFindingsFH();
                });

                $('#btnSubmitChecksheet').click(function() {
                    let approval = $(this).attr('approval');
                    $('#txtChecksheetStatus').val(approval);
                    // $('#formSubmitChecksheet').submit();
                });

                $("#formSubmitChecksheet").submit(function(event) {
                    event.preventDefault();
                    SubmitChecksheet();
                });

                $('#btnSupervisorApproveChecksheet').click(function() {
                    let approval_s = $(this).attr('approval_s');
                    $('#txtSupervisorApproveChecksheetStatus').val(approval_s);
                    $('#formSupervisorApproveChecksheet').submit();
                });

                $('#btnSupervisorDisapproveChecksheet').click(function() {
                    let approval_s = $(this).attr('approval_s');
                    $('#txtSupervisorApproveChecksheetStatus').val(approval_s);
                    $('#formSupervisorApproveChecksheet').submit();
                });

                $("#formSupervisorApproveChecksheet").submit(function(event) {
                    event.preventDefault();
                    SupervisorApproveChecksheet();
                });

                $('#btnManagerApproveChecksheet').click(function() {
                    let approval_m = $(this).attr('approval_m');
                    $('#txtManagerApproveChecksheetStatus').val(approval_m);
                    $('#formManagerApproveChecksheet').submit();
                });

                $('#btnManagerDisapproveChecksheet').click(function() {
                    let approval_m = $(this).attr('approval_m');
                    $('#txtManagerApproveChecksheetStatus').val(approval_m);
                    $('#formManagerApproveChecksheet').submit();
                });

                $("#formManagerApproveChecksheet").submit(function(event) {
                    event.preventDefault();
                    ManagerApproveChecksheet();
                });

                $('#modalViewELCriteria').on('hidden.bs.modal', function() {
                    $("#btnSubmitCREL").prop('hidden', false);
                    $("#slctGeneralAreaEL").prop('disabled', false);
                    // $("#slctControlNumberEL").prop('disabled', false); // CHAN 1-20-25 - old
                    // $("#txtLocationEL").prop('readonly', false);
                    $("#RdoLightsLStatusGood").prop('disabled', false);
                    $("#RdoLightsLStatusNoGood").prop('disabled', false);
                    $("#RdoLightsRStatusGood").prop('disabled', false);
                    $("#RdoLightsRStatusNoGood").prop('disabled', false);
                    $("#RdoBatteryStatusGood").prop('disabled', false);
                    $("#RdoBatteryStatusNoGood").prop('disabled', false);
                    $("#RdoDrainingofBatteryStatusDone").prop('disabled', false);
                    $("#RdoDrainingofBatteryStatusNG").prop('disabled', false);
                    $("#RdoInspCardStatusUpdated").prop('disabled', false);
                    $("#RdoInspCardStatusNotUpdated").prop('disabled', false);
                    $("#txtRemarksEL").prop('readonly', false);
                    
                    // CHAN 1-20-25
                    $("#slctControlNumberEL").prop('disabled', true);
                    $('.reset-value').val('')
                    $('.uncheck').each(function(count, value) {
                        let statusUncheck = $(this).attr('id');
                        $('#'+statusUncheck).prop('checked', false)
                    })
                })

                // CHAN 1-20-25
                $('#slctGeneralAreaEL').change(function (e) { 
                    e.preventDefault();
                    $("#slctControlNumberEL").prop('disabled', false);
                    $('#txtLocationEL').val('')
                    GetControlNo($('.sel-control-no-el'),$(this).val())
                });
                $('#slctControlNumberEL').change(function (e) {
                    GetGeneralAreaLocation($('#slctGeneralAreaEL').val(),$(this).val())
                });

                $('#modalViewEXLCriteria').on('hidden.bs.modal', function() {
                    $("#btnSubmitCREXL").prop('hidden', false);
                    $("#slctGeneralAreaEXL").prop('disabled', false);
                    // $("#slctLocationEXL").prop('readonly', false); // CHAN 1-20-25 - old
                    $("#RdoLightStatusGoodEXL").prop('disabled', false);
                    $("#RdoLightStatusNoGoodEXL").prop('disabled', false);
                    $("#RdoBatteryStatusGoodEXL").prop('disabled', false);
                    $("#RdoBatteryStatusNoGoodEXL").prop('disabled', false);
                    $("#txtRemarksEXL").prop('readonly', false);

                    // CHAN 1-20-25
                    $("#slctLocationEXL").prop('disabled', true);
                    $('.reset-value').val('')
                    $('.uncheck').each(function(count, value) {
                        let statusUncheck = $(this).attr('id');
                        $('#'+statusUncheck).prop('checked', false)
                    })
                })

                // CHAN 1-20-25
                $('#slctGeneralAreaEXL').change(function (e) { 
                    e.preventDefault();
                    $("#slctLocationEXL").prop('disabled', false);
                    SelectGeneralAreaLocation($('.sel-location-exl'),$(this).val())
                });

                $('#modalViewFECriteria').on('hidden.bs.modal', function() {
                    $("#btnSubmitCRFE").prop('hidden', false);
                    $("#slctGeneralAreaFE").prop('disabled', false);
                    // $("#slctControlNumberFE").prop('disabled', false);
                    $("#slctClassificationFE").prop('disabled', false);
                    // $("#txtLocationFE").prop('readonly', false);
                    $("#RdoLeverStatusGood").prop('disabled', false);
                    $("#RdoLeverStatusNoGood").prop('disabled', false);
                    $("#RdoHoseStatusGood").prop('disabled', false);
                    $("#RdoHoseStatusNoGood").prop('disabled', false);
                    $("#RdoCylTankStatusGood").prop('disabled', false);
                    $("#RdoCylTankStatusNoGood").prop('disabled', false);
                    $("#RdoPressGaugeStatusGood").prop('disabled', false);
                    $("#RdoPressGaugeStatusNoGood").prop('disabled', false);
                    $("#txtCapacityFE").prop('readonly', false);
                    $("#txtRemarksFE").prop('readonly', false);

                    // CHAN 1-20-25
                    $("#txtLocationFE").prop('disabled', true);
                    $("#slctControlNumberFE").prop('disabled', true);
                    $("#slctClassificationFE").prop('disabled', true);
                    $('.reset-value').val('')
                    $('.uncheck').each(function(count, value) {
                        let statusUncheck = $(this).attr('id');
                        $('#'+statusUncheck).prop('checked', false)
                    })
                })
                // CHAN 1-20-25
                $('#slctGeneralAreaFE').change(function (e) { 
                    e.preventDefault();
                    $("#txtLocationFE").prop('disabled', false);
                    $("#slctControlNumberFE").prop('disabled', false);
                    $("#slctClassificationFE").prop('disabled', false);
                    $('#txtLocationFE').val('')
                    GetControlNo($('.sel-control-no-fe'),$(this).val())
                });

                $('#slctControlNumberFE').change(function (e) { 
                    GetGeneralAreaLocation($('#slctGeneralAreaFE').val(),$(this).val())
                });
                
                $('#modalViewFHCriteria').on('hidden.bs.modal', function() {
                    $("#btnSubmitCRFH").prop('hidden', false);
                    $("#slctGeneralAreaFH").prop('disabled', false);
                    // $("#slctControlNumberFH").prop('disabled', false); // CHAN 1-20-25 - old
                    // $("#txtLocationFH").prop('readonly', false);
                    $("#RdoCabinetStatusGood").prop('disabled', false);
                    $("#RdoCabinetStatusNoGood").prop('disabled', false);
                    $("#RdoHoseStatusGoodFH").prop('disabled', false);
                    $("#RdoHoseStatusNoGoodFH").prop('disabled', false);
                    $("#RdoNozzleStatusGood").prop('disabled', false);
                    $("#RdoNozzleStatusNoGood").prop('disabled', false);
                    $("#RdoPipelineStatusGood").prop('disabled', false);
                    $("#RdoPipelineStatusNoGood").prop('disabled', false);
                    $("#RdoValveStatusGood").prop('disabled', false);
                    $("#RdoValveStatusNoGood").prop('disabled', false);
                    $("#txtRemarksFH").prop('readonly', false);

                    // CHAN 1-20-25
                    $("#slctControlNumberFH").prop('disabled', true);
                    $('.reset-value').val('')
                    $('.uncheck').each(function(count, value) {
                        let statusUncheck = $(this).attr('id');
                        $('#'+statusUncheck).prop('checked', false)
                    })
                })
                // CHAN 1-20-25
                $('#slctGeneralAreaFH').change(function (e) { 
                    e.preventDefault();
                    $('#txtLocationFH').val('')
                    $("#slctControlNumberFH").prop('disabled', false);
                    GetControlNo($('.sel-control-no-fh'),$(this).val())
                });
                $('#slctControlNumberFH').change(function (e) { 
                    GetGeneralAreaLocation($('#slctGeneralAreaFH').val(),$(this).val())
                });
                $('#modalViewCriteria').on('hidden.bs.modal', function() {
                    $("#btnSubmitCR").prop('hidden', false);
                    $("#slctEquipmentTemplate").prop('disabled', false);
                    $("#slctChecklist").prop('disabled', false);
                    // $("#txtRequirement").prop('readonly', false);
                    $("#RdoStatusGood").prop('disabled', false);
                    $("#RdoStatusNoGood").prop('disabled', false);
                    $("#txtRemarks").prop('readonly', false);
                })
                // Get Checksheet ID to Export
                $(document).on('click', '.btn-export-criteria', function() {
                    let checksheetId = $(this).attr('checksheet-id');
                    window.open("./export_checksheet?checksheet_id=" + checksheetId);
                });
                // Get Checksheet ID to Export Emergency Light
                $(document).on('click', '.btn-export-criteria-el', function() {
                    let checksheetId = $(this).attr('checksheet-id');
                    window.open("./export_checksheet_el?checksheet_id=" + checksheetId);
                });
                // Get Checksheet ID to Export Exit Light
                $(document).on('click', '.btn-export-criteria-exl', function() {
                    let checksheetId = $(this).attr('checksheet-id');
                    window.open("./export_checksheet_exl?checksheet_id=" + checksheetId);
                });
                // Get Checksheet ID to Export Fire Extinguisher
                $(document).on('click', '.btn-export-criteria-fe', function() {
                    let checksheetId = $(this).attr('checksheet-id');
                    window.open("./export_checksheet_fe?checksheet_id=" + checksheetId);
                });
                // Get Checksheet ID to Export Fire Hose Cabinet
                $(document).on('click', '.btn-export-criteria-fh', function() {
                    let checksheetId = $(this).attr('checksheet-id');
                    window.open("./export_checksheet_fh?checksheet_id=" + checksheetId);
                });
            });
        </script>
    @endsection
@else
    <script type="text/javascript">
        window.location = "../RapidX/";
    </script>
@endif
