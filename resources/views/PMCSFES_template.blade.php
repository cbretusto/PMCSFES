@php
    session_start();
    $isLogin = false;
    $layout = 'layouts.no_access_layout';
    if(isset($_SESSION['rapidx_user_id'])){
        $isLogin = true;
        // if( $_SESSION['rapidx_department_id'] == 1 || $_SESSION["PMCSFES_module_id"] == '9' && isset($_SESSION['PMCSFES_access']) ){
        // if( $_SESSION["PMCSFES_module_id"] == '9' && isset($_SESSION['PMCSFES_access']) ){
            if($_SESSION["PMCSFES_module_id"] == '9' && $_SESSION['PMCSFES_access'] != '0'){
            $layout = 'layouts.user_layout';
        }
    }
@endphp
@if($isLogin)
    @extends($layout)
    @section('title', 'Blank')

    @section('content_page')
    <style>
        .hidden_text {
            position: absolute;
            opacity: 0;
        }
        table.table tbody td{
            margin: 2px 2px;
            font-size: 14px;
            text-align: center;
            vertical-align: middle;
        }

        table.table thead th{
            padding: 7px 7px;
            margin: 2px 2px;
            font-size: 16px;
            text-align: center;
            vertical-align: middle;
        }

        .pointer-event{
            pointer-events: none;
        }

        .crossed-out{
            text-decoration: line-through;
            color: grey;
        }
    </style>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
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
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Equipment Checklist</h3>
                                </div>

                                <!-- Start Page Content -->
                                <div class="card-body">
                                    <div class="">
                                        <div class="input-group col-2 position-absolute d-none" id="selection">
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
                                        <button type="button" class="btn btn btn-dark float-right" id="btnNewEquipment" data-toggle="modal"><i class="fa fa-plus"></i>Add New Equipment</button>
                                    </div>                                    
                                    <div class="table-responsive">
                                        <br>
                                        <table id="tableEquipmentList" class="table table-striped table-bordered" style="width: 100%; font-size: 90%;">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" style="width: 25%;">Action</th>
                                                    <th>Equipment List</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div> <!-- End Page Content -->
                            </div> <!-- card -->
                        </div> <!-- col -->
                    </div> <!-- row -->
                </div> <!-- container-fluid -->
            </section> <!-- content -->
        </div> <!-- content-wrapper -->

        <!--======================================================================================================================================================================================= -->
        <!--====================================================================================== EQUIPMENT ====================================================================================== -->
        <!--======================================================================================================================================================================================= -->
        <!-- START - Create/Update Equipment Modal -->
        {{-- <div class="modal fade" id="modalNewEquipment" data-backdrop="static">
            <div class="modal-dialog modal-m">
                <div class="modal-content">

                    <div class="modal-header">
                        <h4 class="modal-title" id="changeEquipmentTitle"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>

                    <form method="post" id="formCreateUpdateEquipment">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text"  class="hidden_text" name="factory_equipment_list" id="factoryEquipmentList">
                                <input type="text" class="hidden_text" name="equipment_factory" id="textEquipmentFactory">
                                <label class="col-sm-10 control-label">Equipment Name</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" name="equipment_name" id="txtEquipmentName" placeholder="Equipment Name" maxlength="50" required>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" id="btnSubmitEquipment" class="btn btn-sm btn-dark"><i id="ibtnSubmitEquipmentDefIcon" class="fa fa-plus"></i> Submit Equipment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>  --}}
        <div class="modal fade" id="modalNewEquipment" data-backdrop="static">
            <div class="modal-dialog modal-m">
                <div class="modal-content">
        
                    <div class="modal-header">
                        <h4 class="modal-title" id="changeEquipmentTitle"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>
        
                    <form method="post" id="formCreateUpdateEquipment">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text"  class="hidden_text" name="factory_equipment_list" id="factoryEquipmentList">
                                <input type="text" class="hidden_text" name="equipment_factory" id="textEquipmentFactory">
                                <label class="col-sm-10 control-label">Equipment Name</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" name="equipment_name" id="txtEquipmentName" placeholder="Equipment Name" maxlength="50" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-4">
                                    <label>
                                        <input type="checkbox" class="chckbx" name="na" id="chkNa" value="0" required>
                                        N/A
                                    </label>
                                </div>
                                <div class="col-sm-4">
                                    <input type="checkbox" class="chckbx" name="general_area" id="chkGeneralArea" value="0" required>
                                    <label class="chckBxLabel">
                                        General Area
                                    </label>
                                </div>
                                <div class="col-sm-4">
                                    <input type="checkbox" class="chckbx" name="classification" id="chkClassification" value="0" required>
                                    <label class="chckBxLabel">
                                        Classification
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="btnSubmitEquipment" class="btn btn-sm btn-dark"><i id="ibtnSubmitEquipmentDefIcon" class="fa fa-plus"></i> Submit Equipment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>        
        <!-- END - Create/Update Equipment Modal -->

        <!-- ======================================================================================================================================================================================== -->
        <!-- ====================================================================================== DATATABLES ====================================================================================== -->
        <!-- ======================================================================================================================================================================================== -->
        <!-- START - Equipment Model / Checklist Modal DataTable-->
        <div class="modal fade" id="modalCreateEquipmentModelChecklist" data-backdrop="static" style="overflow-y: scroll;">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fa fa-plus"></i>&nbsp;<strong id="changeEquipmentModelChecklistTitle"></strong></strong></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title" style="margin-top: 8px;">View Records</h3>
                                    </div>
                                    <div class="card-body">
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" data-toggle="tab" data-target="#tblEquipmentModel" type="button" role="tab">Equipment Model</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" data-toggle="tab" data-target="#tblChecklist" type="button" role="tab">Checklist</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" data-toggle="tab" data-target="#tblGeneralArea" type="button" role="tab">General Area</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" data-toggle="tab" data-target="#tblClassification" type="button" role="tab">Classification</button>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade show active" id="tblEquipmentModel" role="tabpanel">
                                                <div class="card-body">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend w-25">
                                                            <span class="input-group-text w-100"><strong>Equipment Name</strong></span>
                                                        </div>
                                                        <input type="text" class="form-control view-equipment" id="viewEquipment" readonly>
                                                    </div>
                                                    <form method="post" id="formNewEquipmentModel" autocomplete="off">
                                                        @csrf
                                                        <div class="input-group">
                                                            <input type="text" class="hidden_text get-device_id" name="device_id" id="textEquipmentModelEquipmentId" placeholder="Equipment ID">
                                                            <div class="input-group-prepend w-25">
                                                                <span class="input-group-text w-100"><strong>Equipment Model</strong></span>
                                                            </div>
                                                            <input type="text" class="form-control reset-value" id="txtCreateEquipmentModel" name="equipment_model" required>
                                                            <button type="submit" class="btn btn-dark" id="btnViewEquipmentModel">&emsp;<i class="fa fa-save" id="iBtnViewEquipmentModelIcon"></i> &nbsp;Save New Model&emsp;</button>
                                                        </div>
                                                    </form>
                                                </div>

                                                <div class="table-responsive">
                                                    <table id="tableEquipmentModel" class="table table-bordered table-hover nowrap" style="width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th>Action</th>
                                                                <th>Status</th>
                                                                <th>Equipment Model</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="tblChecklist" role="tabpanel">
                                                <div class="input-group mt-3">
                                                    <div class="input-group-prepend w-25">
                                                        <span class="input-group-text w-100"><strong>Equipment Name</strong></span>
                                                    </div>
                                                    <input type="text" class="form-control view-equipment" readonly>
                                                    <button type="button" class="btn btn-dark" id="btnViewChecklist" data-toggle="modal" data-target="#modalCheckList">&emsp;<i class="fa fa-save" id="iBtnViewChecklistlIcon"></i> &nbsp;Add New Checklist&emsp;</button>
                                                </div>
                                                <div class="table-responsive mt-3">
                                                    <table id="tableChecklist" class="table table-bordered table-hover nowrap" style="width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th>Action</th>
                                                                <th>Status</th>
                                                                <th>Checklist</th>
                                                                <th>Requirement</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="tblGeneralArea" role="tabpanel">
                                                <div class="card-body">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend w-25">
                                                            <span class="input-group-text w-100"><strong>Equipment Name</strong></span>
                                                        </div>
                                                        <input type="text" class="form-control view-equipment" id="viewEquipment" readonly>
                                                    </div>
                                                    <form method="post" id="formNewGeneralArea" autocomplete="off">
                                                        @csrf
                                                        <div class="input-group">
                                                            <input type="text" class="hidden_text get-device_id" name="device_id" id="txtGeneraAreaEquipmentId" placeholder="Equipment ID">
                                                            <div class="input-group-prepend w-25">
                                                                <span class="input-group-text w-100"><strong>General Area</strong></span>
                                                            </div>
                                                            <input type="text" class="form-control reset-value" id="txtCreateGeneralArea" name="general_area" required>
                                                            <button type="submit" class="btn btn-dark" id="btnViewGeneraArea">&emsp;<i class="fa fa-save" id="iBtnViewGeneralAreaIcon"></i> &nbsp;Save New General Area&emsp;</button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="table-responsive mt-3">
                                                    <table id="tableGeneralArea" class="table table-bordered table-hover nowrap" style="width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th>Action</th>
                                                                <th>Status</th>
                                                                <th>General Area</th>
                                                                <th>Control No. /<br> Location</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="tblClassification" role="tabpanel">
                                                <div class="card-body">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend w-25">
                                                            <span class="input-group-text w-100"><strong>Equipment Name</strong></span>
                                                        </div>
                                                        <input type="text" class="form-control view-equipment" id="viewEquipment" readonly>
                                                    </div>
                                                    <form method="post" id="formNewClassification" autocomplete="off">
                                                        @csrf
                                                        <div class="input-group">
                                                            <input type="text" class="hidden_text get-device_id" name="device_id" id="txtClassificationEquipmentId" placeholder="Equipment ID">
                                                            <div class="input-group-prepend w-25">
                                                                <span class="input-group-text w-100"><strong>Classification</strong></span>
                                                            </div>
                                                            <input type="text" class="form-control reset-value" id="txtCreateClassification" name="classification" required>
                                                            <button type="submit" class="btn btn-dark" id="btnViewClassification">&emsp;<i class="fa fa-save" id="iBtnViewClassificationIcon"></i> &nbsp;Save New Classification&emsp;</button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="table-responsive mt-3">
                                                    <table id="tableClassification" class="table table-bordered table-hover nowrap" style="width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th>Action</th>
                                                                <th>Status</th>
                                                                <th>Classification</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>  <!-- END - Equipment Model / Checklist Modal DataTable-->

        <!-- ======================================================================================================================================================================================= -->
        <!-- =================================================================================== EQUIPMENT MODEL =================================================================================== -->
        <!-- ======================================================================================================================================================================================= -->
        <!-- START - Update Equipment Model Modal -->
        <div class="modal fade" id="modalUpdateEquipmentModel" data-backdrop="static" style="overflow-y: scroll;">
            <div class="modal-dialog modal-m">
                <div class="modal-content">

                    <div class="modal-header">
                        <h4 class="modal-title" id="changeEquipmentModelTitle"><i class="fa fa-plus"></i> Update Equipment Model</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>

                    <form method="post" id="formUpdateEquipmentModel">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" class="hidden_text" name="equipment_model_id" id="textEquipmentModelId">
                                <label class="col-sm-10 control-label">Equipment Model</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" name="equipment_model" id="txtUpdateEquipmentModel" autocomplete="off" placeholder="Equipment Model" maxlength="50" required>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" id="btnSubmitEquipmentModel" class="btn btn-sm btn-dark"><i id="ibtnSubmitEquipmentModelIcon" class="fa fa-plus"></i> Submit Equipment Model</button>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- END - Update Equipment Model Modal -->
        
        <!-- START - Equipment Model Status Modal -->
        <div class="modal fade" id="modalChangeEquipmentModelStatus" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                        <h4 class="modal-title" id="h4ChangeEquipmentModelTitle"><i class="fa fa-wrench"></i> Change Status</h4>
                        <button type="button" style="color: #fff" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <form method="post" id="formChangeEquipmentModelStatus">
                        @csrf
                        <div class="modal-body">
                            <label id="lblChangeEquipmentModelStatusLabel"></label>
                            <input type="hidden" name="equipment_status_id" placeholder="Equipment Model Id" id="txtChangeEquipmentModelStatusId">
                            <input type="hidden" name="status" placeholder="Status" id="txtChangeEquipmentModelStatus">
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">No</button>
                            <button type="submit" id="btnChangeEquipmentModelStatus" class="btn btn-dark"><i id="iBtnChangeEquipmentModelStatusIcon" class="fa fa-check"></i> Yes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- END - Equipment Model Status Modal -->

        <!-- ================================================================================================================================================================================== -->
        <!-- =================================================================================== CHGECKLIST =================================================================================== -->
        <!-- ================================================================================================================================================================================== -->
        <!-- START - Checklist Modal -->
        <div class="modal fade" id="modalCheckList" data-keyboard="false" data-backdrop="static" style="overflow-y: scroll;">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fas fa-info-circle"></i>&nbsp;<strong id="changeChecklistTitle"></strong></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <form method="post" id="formChecklist" autocomplete="off">
                        @csrf
                        <div class="modal-body">
                            <input type="text" class="hidden_text get-device_id" name="device_id" id="txtChecklistEquipmentId" placeholder="Equipment ID">
                            <input type="text" class="hidden_text reset-value" id="txtChecklistId" name="checklist_id" placeholder="Checklist ID">     
                            <div class="input-group mb-3">
                                <div class="input-group-prepend w-25">
                                    <span class="input-group-text w-100"><strong>Equipment Name</strong></span>
                                </div>
                                <input type="text" class="form-control" id="checklistEquipmentName" readonly>
                            </div>
                            <div class="card p-3">
                                <div class="row">
                                    <div class="input-group mb-3 col-6">
                                        <div class="input-group-prepend w-100">
                                            <span class="input-group-text w-100">
                                                <strong>
                                                    <span class="text-danger" title="Required">*</span>
                                                    Checklist
                                                </strong>
                                            </span>
                                        </div>
                                        <textarea type="text" class="form-control reset-value" id="txtChecklist" name="checklist" required></textarea>
                                    </div>

                                    <div class="input-group mb-3 col-6">
                                        <div class="input-group-prepend w-100">
                                            <span class="input-group-text w-100">
                                                <strong>
                                                    <span class="text-danger" title="Required">*</span>
                                                    Requirement
                                                </strong>
                                            </span>
                                        </div>
                                        <textarea type="text" class="form-control reset-value" id="txtRequirement" name="requirement" required></textarea>
                                    </div>
                                </div>
                            </div>                       
                        </div>

                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="btnChecklist" class="btn btn-dark"><i id="iBtnChecklistIcon" class="fa fa-check"></i> Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- END - Checklist Modal -->

        <!-- START - Checklist Status Modal -->
        <div class="modal fade" id="modalChangeChecklistStatus" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                        <h4 class="modal-title" id="h4ChangeChecklistTitle"><i class="fa fa-wrench"></i> Change Status</h4>
                        <button type="button" style="color: #fff" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <form method="post" id="formChangeChecklistStatus">
                        @csrf
                        <div class="modal-body">
                            <label id="lblChangeChecklistStatusLabel"></label>
                            <input type="hidden" name="checklist_status_id" placeholder="Checklist Id" id="txtChangeChecklistStatusId">
                            <input type="hidden" name="status" placeholder="Status" id="txtChangeChecklistStatus">
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">No</button>
                            <button type="submit" id="btnChangeChecklistStatus" class="btn btn-dark"><i id="iBtnChangeChecklistStatusIcon" class="fa fa-check"></i> Yes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- END - Checklist Status Modal -->

        <!-- ====================================================================================================================================================================================== -->
        <!-- ==================================================================================== GENERAL AREA ==================================================================================== -->
        <!-- ====================================================================================================================================================================================== -->
        <!-- START - Update General Area Modal -->
        <div class="modal fade" id="modalUpdateGeneralArea" data-backdrop="static">
            <div class="modal-dialog modal-m">
                <div class="modal-content">

                    <div class="modal-header">
                        <h4 class="modal-title" id="changeGeneralAreaTitle"><i class="fa fa-plus"></i> Update General Area</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>

                    <form method="post" id="formUpdateGeneralArea">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" class="hidden_text" name="general_area_id" id="textGeneralAreaId">
                                <label class="col-sm-10 control-label">General Area</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" name="general_area" id="txtUpdateGeneralArea" autocomplete="off" placeholder="General Area" maxlength="50" required>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" id="btnSubmitGeneralArea" class="btn btn-sm btn-dark"><i id="ibtnSubmitGeneralAreaIcon" class="fa fa-plus"></i> Submit General Area</button>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- END - Update General Area Modal -->
        
        <!-- START - General Area Status Modal -->
        <div class="modal fade" id="modalChangeGeneralAreaStatus" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                        <h4 class="modal-title" id="h4ChangeGeneralAreaTitle"><i class="fa fa-wrench"></i> Change Status</h4>
                        <button type="button" style="color: #fff" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <form method="post" id="formChangeGeneralAreaStatus">
                        @csrf
                        <div class="modal-body">
                            <label id="lblChangeGeneralAreaStatusLabel"></label>
                            <input type="hidden" name="general_area_status_id" placeholder="General Area Id" id="txtChangeGeneralAreaStatusId">
                            <input type="hidden" name="status" placeholder="Status" id="txtChangeGeneralAreaStatus">
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">No</button>
                            <button type="submit" id="btnChangeGeneralAreaStatus" class="btn btn-dark"><i id="iBtnChangeGeneralAreaStatusIcon" class="fa fa-check"></i> Yes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- END - General Area Status Modal -->
        
        <!-- START - Control No & Location Modal -->
        <div class="modal fade" id="modalViewControlNoLocation" data-keyboard="false" data-backdrop="static" style="overflow-y: scroll;">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fas fa-info-circle"></i>&nbsp;<strong id="changeViewControlNoLocationTitle"></strong></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <form method="post" id="formCreateUpdateControlNoLocation" autocomplete="off">
                        @csrf
                        <div class="modal-body">
                            <input type="text" class="hidden_text" name="general_area_id" id="txtViewGeneralAreaId" placeholder="General Area ID">
                            <input type="text" class="hidden_text reset-value" id="txtViewControlNoLocationId" name="control_no_location_id" placeholder="View Control No & Location ID">     
                            <div class="input-group mb-3">
                                <div class="input-group-prepend w-25">
                                    <span class="input-group-text w-100"><strong>General Area</strong></span>
                                </div>
                                <input type="text" class="form-control" id="txtgeneralArea" readonly>
                            </div>
                            <div class="card shadow border border-secondary">
                                <div class="card-header">
                                    <strong>Create / Update - Control No. and Location</strong>
                                </div>
                                <div class="row px-3 p-3">
                                    <div class="input-group col-6">
                                        <div class="input-group-prepend w-100">
                                            <span class="input-group-text w-100">
                                                <strong>
                                                    <span class="text-danger" title="Required">*</span>
                                                    Control Number
                                                </strong>
                                            </span>
                                        </div>
                                        <textarea type="text" class="form-control reset-value" id="txtControlNumber" name="control_number" required></textarea>
                                    </div>

                                    <div class="input-group col-6">
                                        <div class="input-group-prepend w-100">
                                            <span class="input-group-text w-100">
                                                <strong>
                                                    <span class="text-danger" title="Required">*</span>
                                                    Location
                                                </strong>
                                            </span>
                                        </div>
                                        <textarea type="text" class="form-control reset-value" id="txtLocation" name="location" required></textarea>
                                    </div>
                                </div><hr>
                                <div class="justify-content-between p-2">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-dark float-right" id="btnViewControlNoLocation" ><i id="iBtnViewControlNoLocationIcon" class="fa fa-check"></i> Save</button>
                                </div>
                            </div>                       
                        </form>
                        <div class="card shadow border border-secondary">
                            <div class="card-header">
                                <strong>Control No. & Location History</strong>
                            </div>
                            <div class="table-responsive p-3">
                                <table id="tableControlNoLocation" class="table table-bordered table-hover nowrap" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Action</th>
                                            <th>Status</th>
                                            <th>Control No</th>
                                            <th>Location</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- END - Control No & Location Modal -->

        <!-- START - Control No & Location Status Modal -->
        <div class="modal fade" id="modalChangeControlNoLocationStatus" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                        <h4 class="modal-title" id="h4ChangeControlNoLocationTitle"><i class="fa fa-wrench"></i> Change Status</h4>
                        <button type="button" style="color: #fff" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <form method="post" id="formChangeControlNoLocationStatus">
                        @csrf
                        <div class="modal-body">
                            <label id="lblChangeControlNoLocationStatusLabel"></label>
                            <input type="hidden" name="control_no_location_status_id" placeholder="ControlNoLocation Id" id="txtChangeControlNoLocationStatusId">
                            <input type="hidden" name="status" placeholder="Status" id="txtChangeControlNoLocationStatus">
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">No</button>
                            <button type="submit" id="btnChangeControlNoLocationStatus" class="btn btn-dark"><i id="iBtnChangeControlNoLocationStatusIcon" class="fa fa-check"></i> Yes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- END - Control No & Location Status Modal -->

        <!-- ====================================================================================================================================================================================== -->
        <!-- =================================================================================== CLASSIFICATION =================================================================================== -->
        <!-- ====================================================================================================================================================================================== -->
        <!-- START - Update Classification Modal -->
        <div class="modal fade" id="modalUpdateClassification" data-backdrop="static">
            <div class="modal-dialog modal-m">
                <div class="modal-content">

                    <div class="modal-header">
                        <h4 class="modal-title" id="changeClassificationTitle"><i class="fa fa-plus"></i> Update Classification</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>

                    <form method="post" id="formUpdateClassification">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" class="hidden_text" name="classification_id" id="textClassificationId">
                                <label class="col-sm-10 control-label">Classification</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" name="classification" id="txtUpdateClassification" autocomplete="off" placeholder="Classification" maxlength="50" required>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" id="btnSubmitClassification" class="btn btn-sm btn-dark"><i id="ibtnSubmitClassificationIcon" class="fa fa-plus"></i> Submit Classification</button>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- END - Update Classification Modal -->

        <!-- START - Classification Status Modal -->
        <div class="modal fade" id="modalChangeClassificationStatus" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                        <h4 class="modal-title" id="h4ChangeClassificationTitle"><i class="fa fa-wrench"></i> Change Status</h4>
                        <button type="button" style="color: #fff" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <form method="post" id="formChangeClassificationStatus">
                        @csrf
                        <div class="modal-body">
                            <label id="lblChangeClassificationStatusLabel"></label>
                            <input type="hidden" name="classification_status_id" placeholder="Classification Id" id="txtChangeClassificationStatusId">
                            <input type="hidden" name="status" placeholder="Status" id="txtChangeClassificationStatus">
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">No</button>
                            <button type="submit" id="btnChangeClassificationStatus" class="btn btn-dark"><i id="iBtnChangeClassificationStatusIcon" class="fa fa-check"></i> Yes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- END - Classification Status Modal -->
    @endsection

    @section('js_content')
        <script type="text/javascript">
            let dataTableControlNoLocation
            let dataTableEquipmentModel
            let dataTableClassification
            let dataTableEquipmentList
            let dataTableGeneralArea
            let dataTableChecklist
            let equipmentModelID
            let generalAreaID
            let deviceID
            let factory
            let device

            $(document).ready(function () {
                //*=======================================================================================================================================================================================
                //*====================================================================================== EQUIPMENT ======================================================================================
                //*=======================================================================================================================================================================================
                dataTableEquipmentList = $('#tableEquipmentList').DataTable({
                    "processing"    : false,
                    "serverSide"    : true,
                    "destroy"       : true,
                    "pageLength" : 100,
                    "ajax"          : {
                        url: "view_device_checklist_table",
                        data: function(param) {
                            param.factory = factory
                        }
                    },
                    "columns": [
                        {"data" : "action", orderable: false, searchable: false},
                        {"data" : "device_name"},
                    ],
                });

                $('#factory').change(function (e) { 
                    e.preventDefault();
                    factory = $('#factory').val()
                    dataTableEquipmentList.draw();
                });

                $('#btnNewEquipment').click(function (e) { 
                    e.preventDefault();
                    if($('#factory').val() != null){
                        $('#modalNewEquipment').modal('show')
                    }else{
                        alert('Select Factory')
                    }
                });

                $('#modalNewEquipment').on('shown.bs.modal', function () {
                    $('#textEquipmentFactory').val($('#factory').val())
                    $('#changeEquipmentTitle').html('<i class="fa fa-plus"></i> Equipment for Factory ' + $('#factory').val())
                });

                $('#modalNewEquipment').on('hidden.bs.modal', function () {
                    $('#textEquipmentFactory').val($('#factory').val())
                    $('#txtEquipmentName').val('')
                    $('.chckbx').prop('checked', false).removeClass('d-none')
                    $('.chckBxLabel').removeClass('crossed-out')
                });

                $('.chckbx').change(function (e) {
                    e.preventDefault()
                    
                    const chckBox = $('#chckbx')
                    const chkNa = $('#chkNa')
                    const chkGeneralArea = $('#chkGeneralArea')
                    const chkClassification = $('#chkClassification')

                    const resetCheckboxes = function() {
                        chckBox.removeClass('pointer-event')
                        chkNa.prop({'checked': false, 'required': true})
                        chkGeneralArea.prop({'checked': false, 'required': true}).val('0').removeClass('d-none')
                        chkClassification.prop({'checked': false, 'required': true}).val('0').removeClass('d-none')
                        $('.chckBxLabel').removeClass('crossed-out')
                    }

                    if ($('.chckbx').is(":checked")) {
                        if($(chkNa).is(":checked")) {
                            console.log('N/A: ', $(this).val());
                            
                            chckBox.removeClass('pointer-event')
                            chkNa.prop({'required': true})
                            chkGeneralArea.prop({'checked': false, 'required': false}).val('0').addClass('d-none')
                            chkClassification.prop({'checked': false, 'required': false}).val('0').addClass('d-none')
                            $('.chckBxLabel').addClass('crossed-out')
                        }

                        if($(chkGeneralArea).is(":checked")) {
                            console.log('General Area: ', $(this).val());

                            chkNa.prop({'checked': false, 'required': false}).addClass('pointer-event')
                            chkGeneralArea.prop({'required': true}).val('1').removeClass('pointer-event')
                            chkClassification.prop({'required': false}).removeClass('pointer-event')
                        }else {
                            chkGeneralArea.val('0')
                        }

                        if($(chkClassification).is(":checked")){
                            console.log('Classification: ', $(this).val());

                            chkNa.prop({'checked': false, 'required': false}).addClass('pointer-event')
                            chkGeneralArea.prop({'required': false}).removeClass('pointer-event')
                            chkClassification.prop({'required': true}).val('1').removeClass('pointer-event')
                        }else{
                            chkClassification.val('0')
                        }
                    }else{
                        console.log('object: ', $(this).val());
                        resetCheckboxes()
                    }
                })


                $(document).on('click', '.btn-edit-checksheet', function(e){
                    e.preventDefault();

                    deviceID = $(this).attr('device-id');
                    deviceFactory = $(this).attr('device-factory');
                    $("#factoryEquipmentList").val(deviceID);
                    $("#textEquipmentFactory").val(deviceFactory);

                    GetDeviceIdToEdit(deviceID,deviceFactory);  
                });

                $("#formCreateUpdateEquipment").submit(function(event) {
                    event.preventDefault();
                    CreateUpdateEquipment();
                });

                //*========================================================================================================================================================================================
                //*====================================================================================== DATATABLES ======================================================================================
                //*========================================================================================================================================================================================
                $(document).on('click','.btn-view-equipment_model_checklist', function(e) {
                    e.preventDefault();
                    deviceID = $(this).attr('device-id');
                    device = $(this).attr('device');
                    $(".get-device_id").val(deviceID);
                    $(".view-equipment").val(device);

                    // EQUIPMENT MODEL DATATABLE
                    dataTableEquipmentModel = $('#tableEquipmentModel').DataTable({
                        "processing"    : false,
                        "serverSide"    : true,
                        "destroy"       : true,
                        "order"         : [[ 1, "ASC" ],[ 2, "ASC" ]],
                        "ajax"          : {
                            url: "view_equipment_model_table",
                            data: function(param) {
                                param.deviceID = deviceID
                            }
                        },
                        "columns": [
                            {"data" : "action", orderable: false, searchable: false},
                            {"data" : "status",
                                "defaultContent": 'N/A',
                                "name"          : 'status',
                                "orderable"     : true,
                                "searchable"    : true,
                                "render"        : function (data, type, row) {
                                    if(row.status == 1){
                                        return "<center><span class='badge bg-success'>Active</span></center>";
                                    }else{
                                        return "<center><span class='badge bg-danger bg-danger'>Inactive</span></center>";
                                    }
                                },
                            },
                            {"data" : "equipment_model"},
                        ],
                    });

                    // CHECKLIST DATATABLE
                    dataTableChecklist = $('#tableChecklist').DataTable({
                        "processing"    : false,
                        "serverSide"    : true,
                        "destroy"       : true,
                        "order"         : [[ 1, "ASC" ],[ 2, "ASC" ]],
                        "ajax"          : {
                            url: "view_checklist_table",
                            data: function(param) {
                                param.deviceID = deviceID
                            }
                        },
                        "columns": [
                            {"data" : "action", orderable: false, searchable: false},
                            {"data" : "status",
                                "defaultContent": 'N/A',
                                "name"          : 'status',
                                "orderable"     : true,
                                "searchable"    : true,
                                "render"        : function (data, type, row) {
                                    if(row.status == 1){
                                        return "<center><span class='badge bg-success'>Active</span></center>";
                                    }else{
                                        return "<center><span class='badge bg-danger bg-danger'>Inactive</span></center>";
                                    }
                                },
                            },
                            {"data" : "checklist"},
                            {"data" : "requirement"},
                        ],
                    });

                    // GENERAL AREA DATATABLE
                    dataTableGeneralArea = $('#tableGeneralArea').DataTable({
                        "processing"    : false,
                        "serverSide"    : true,
                        "destroy"       : true,
                        "order"         : [[ 1, "ASC" ],[ 2, "ASC" ]],
                        "ajax"          : {
                            url: "view_general_area_table",
                            data: function(param) {
                                param.deviceID = deviceID
                            }
                        },
                        "columns": [
                            {"data" : "action", orderable: false, searchable: false},
                            {"data" : "status",
                                "defaultContent": 'N/A',
                                "name"          : 'status',
                                "orderable"     : true,
                                "searchable"    : true,
                                "render"        : function (data, type, row) {
                                    if(row.status == 1){
                                        return "<center><span class='badge bg-success'>Active</span></center>";
                                    }else{
                                        return "<center><span class='badge bg-danger bg-danger'>Inactive</span></center>";
                                    }
                                },
                            },
                            {"data" : "general_area"},
                            {"data" : "control_no_location"},
                        ],
                    });

                    // CLASSIFICATION DATATABLE
                    dataTableClassification = $('#tableClassification').DataTable({
                        "processing"    : false,
                        "serverSide"    : true,
                        "destroy"       : true,
                        "order"         : [[ 1, "ASC" ],[ 2, "ASC" ]],
                        "ajax"          : {
                            url: "view_classification_table",
                            data: function(param) {
                                param.deviceID = deviceID
                            }
                        },
                        "columns": [
                            {"data" : "action", orderable: false, searchable: false},
                            {"data" : "status",
                                "defaultContent": 'N/A',
                                "name"          : 'status',
                                "orderable"     : true,
                                "searchable"    : true,
                                "render"        : function (data, type, row) {
                                    if(row.status == 1){
                                        return "<center><span class='badge bg-success'>Active</span></center>";
                                    }else{
                                        return "<center><span class='badge bg-danger bg-danger'>Inactive</span></center>";
                                    }
                                },
                            },
                            {"data" : "classification"},
                        ],
                    });
                });

                //*=======================================================================================================================================================================================
                //*=================================================================================== EQUIPMENT MODEL ===================================================================================
                //*=======================================================================================================================================================================================
                $("#formNewEquipmentModel").submit(function(event) {
                    event.preventDefault();
                    CreateEquipmentModel();
                });

                $(document).on('click', '.btn-update-equipment_model_id', function(e){
                    e.preventDefault();
                    equipmentModelID = $(this).attr('equipment_model-id');
                    $("#textEquipmentModelId").val(equipmentModelID);

                    GetEquipmentModelIdToEdit(equipmentModelID);  
                });

                $("#formUpdateEquipmentModel").submit(function(event) {
                    event.preventDefault();
                    UpdateEquipmentModel();
                });

                $('#modalUpdateEquipmentModel').on('shown.bs.modal', function () {
                    $('#changeEquipmentModelTitle').html('<i class="fa fa-plus"></i> Update Equipment Model for Factory ' + $('#factory').val())
                });

                $(document).on('click', '.actionChangeEquipmentModelStatus', function(){
                    let equipmentStatus = $(this).attr('status');
                    equipmentModelId = $(this).attr('equipment_model-id'); 
                    $("#txtChangeEquipmentModelStatus").val(equipmentStatus); 
                    $("#txtChangeEquipmentModelStatusId").val(equipmentModelId); 

                    if(equipmentStatus == 1){
                        $("#lblChangeEquipmentModelStatusLabel").text('Are you sure to activate?'); 
                        $("#h4ChangeEquipmentModelTitle").html('<i class="fa fa-wrench"></i> Activate Equipment Model');
                    }else{
                        $("#lblChangeEquipmentModelStatusLabel").text('Are you sure to deactivate?');
                        $("#h4ChangeEquipmentModelTitle").html('<i class="fa fa-wrench"></i> Deactivate Equipment Model');
                    }
                });

                $("#formChangeEquipmentModelStatus").submit(function(event){
                    event.preventDefault();
                    ChangeEquipmentModelStatus();
                });

                //*==================================================================================================================================================================================
                //*=================================================================================== CHGECKLIST ===================================================================================
                //*==================================================================================================================================================================================
                $('#modalCheckList').on('shown.bs.modal', function () {
                    $('#changeChecklistTitle').text('Checklist for Factory ' + $('#factory').val())
                    $("#checklistEquipmentName").val($('.view-equipment').val());
                    $("#txtChecklistEquipmentId").val($('.get-device_id').val());
                });

                $(document).on('click', '.btn-update-checklist_id', function(e){
                    e.preventDefault();
                    let checklistID = $(this).attr('checklist-id');
                    $("#txtChecklistId").val(checklistID);
                    $(".view-equipment").val($("#viewEquipment").val());

                    GetChecklistIdToEdit(checklistID);  
                });

                $("#formChecklist").submit(function(event){
                    event.preventDefault();
                    CreateUpdateChecklist();
                });

                $(document).on('click', '.actionChangeChecklistStatus', function(){
                    let checklistStatus = $(this).attr('status');
                    let checklistlId = $(this).attr('checklist-id'); 
                    $("#txtChangeChecklistStatus").val(checklistStatus); 
                    $("#txtChangeChecklistStatusId").val(checklistlId); 

                    if(checklistStatus == 1){
                        $("#lblChangeChecklistStatusLabel").text('Are you sure to activate?'); 
                        $("#h4ChangeChecklistTitle").html('<i class="fa fa-wrench"></i> Activate Checklist');
                    }else{
                        $("#lblChangeChecklistStatusLabel").text('Are you sure to deactivate?');
                        $("#h4ChangeChecklistTitle").html('<i class="fa fa-wrench"></i> Deactivate Checklist');
                    }
                });

                $("#formChangeChecklistStatus").submit(function(event){
                    event.preventDefault();
                    ChangeChecklistStatus();
                });

                $('#modalCreateEquipmentModelChecklist').on('hidden.bs.modal', function () {
                    $(".reset-value").val('');
                });

                $('#modalCheckList').on('hidden.bs.modal', function () {
                    $(".reset-value").val('');
                });

                //*======================================================================================================================================================================================
                //*==================================================================================== GENERAL AREA ====================================================================================
                //*======================================================================================================================================================================================
                $("#formNewGeneralArea").submit(function(event) {
                    event.preventDefault();
                    CreateGeneralArea();
                });

                $(document).on('click', '.btn-update-general_area', function(e){
                    e.preventDefault();
                    generalAreaID = $(this).attr('general_area-id');
                    $("#textGeneralAreaId").val(generalAreaID);

                    GetGeneralAreaIdToEdit(generalAreaID);  
                });

                $("#formUpdateGeneralArea").submit(function(event) {
                    event.preventDefault();
                    UpdateGeneralArea();
                });

                $(document).on('click', '.actionChangeGeneralAreaStatus', function(){
                    let generalAreaStatus = $(this).attr('status');
                    let generalAreaId = $(this).attr('general_area-id'); 
                    $("#txtChangeGeneralAreaStatus").val(generalAreaStatus); 
                    $("#txtChangeGeneralAreaStatusId").val(generalAreaId); 
                    
                    if(generalAreaStatus == 1){
                        $("#lblChangeGeneralAreaStatusLabel").text('Are you sure to activate?'); 
                        $("#h4ChangeGeneralAreaTitle").html('<i class="fa fa-wrench"></i> Activate General Area');
                    }else{
                        $("#lblChangeGeneralAreaStatusLabel").text('Are you sure to deactivate?');
                        $("#h4ChangeGeneralAreaTitle").html('<i class="fa fa-wrench"></i> Deactivate General Area');
                    }
                });

                $("#formChangeGeneralAreaStatus").submit(function(event){
                    event.preventDefault();
                    ChangeGeneralAreaStatus();
                });

                //*=======================================================================================================================================================================================
                //*==================================================================================== GENERAL AREA =====================================================================================
                //*================================================================================ CONTROL NO / LOCATION ================================================================================
                //*=======================================================================================================================================================================================
                $(document).on('click', '.btn-view-control_no_location', function(e){
                    e.preventDefault();
                    generalAreaID = $(this).attr('general_area-id');
                    getGeneralArea = $(this).attr('get-general_area');
                    $('#changeViewControlNoLocationTitle').text('Control No. and Location for Factory ' + $('#factory').val())
                    $("#txtViewGeneralAreaId").val(generalAreaID);
                    $("#txtgeneralArea").val(getGeneralArea);

                    
                    // GENERAL AREA ( CONTROL NO. & LOCATION ) DATATABLE
                    dataTableControlNoLocation = $('#tableControlNoLocation').DataTable({
                        "processing"    : false,
                        "serverSide"    : true,
                        "destroy"       : true,
                        "order"         : [[ 1, "ASC" ],[ 2, "ASC" ]],
                        "ajax"          : {
                            url: "view_control_no_location_table",
                            data: function(param) {
                                param.generalAreaID = generalAreaID
                            }
                        },
                        "columns": [
                            {"data" : "action", orderable: false, searchable: false},
                            {"data" : "status",
                                "defaultContent": 'N/A',
                                "name"          : 'status',
                                "orderable"     : true,
                                "searchable"    : true,
                                "render"        : function (data, type, row) {
                                    if(row.status == 1){
                                        return "<center><span class='badge bg-success'>Active</span></center>";
                                    }else{
                                        return "<center><span class='badge bg-danger bg-danger'>Inactive</span></center>";
                                    }
                                },
                            },
                            {"data" : "control_no"},
                            {"data" : "location"},
                        ],
                    });
                });
                
                $(document).on('click', '.btn-update-control_no_location', function(e){
                    e.preventDefault();
                    controlNoLocationID = $(this).attr('control_no_location-id');
                    $("#txtViewControlNoLocationId").val(controlNoLocationID);

                    GetControlNoLocationIdToEdit(controlNoLocationID);
                    $('#modalViewControlNoLocation').animate({
                        scrollTop: 0
                    }, 1000);  
                });

                $("#formCreateUpdateControlNoLocation").submit(function(event){
                    event.preventDefault();
                    CreateUpdateControlNoLocation();
                    // autoInsert();
                });

                $("#formChangeControlNoLocationStatus").submit(function(event){
                    event.preventDefault();
                    ChangeControlNoLocationStatus();
                });

                $(document).on('click', '.actionChangeControlNoLocationStatus', function(){
                    let controlNoLocationStatus = $(this).attr('status');
                    let controlNoLocationId = $(this).attr('control_no_location-id'); 
                    $("#txtChangeControlNoLocationStatus").val(controlNoLocationStatus); 
                    $("#txtChangeControlNoLocationStatusId").val(controlNoLocationId); 
                    
                    if(controlNoLocationStatus == 1){
                        $("#lblChangeControlNoLocationStatusLabel").text('Are you sure to activate?'); 
                        $("#h4ChangeControlNoLocationTitle").html('<i class="fa fa-wrench"></i> Activate Control No. and Location');
                    }else{
                        $("#lblChangeControlNoLocationStatusLabel").text('Are you sure to deactivate?');
                        $("#h4ChangeControlNoLocationTitle").html('<i class="fa fa-wrench"></i> Deactivate Control No. and Location');
                    }
                });

                $("#formControlNoLocationStatus").submit(function(event){
                    event.preventDefault();
                    ControlNoLocationStatus();
                });

                $('#modalViewControlNoLocation').on('hidden.bs.modal', function () {
                    $(".reset-value").val('');
                });

                //*======================================================================================================================================================================================
                //*=================================================================================== CLASSIFICATION ===================================================================================
                //*======================================================================================================================================================================================
                $("#formNewClassification").submit(function(event) {
                    event.preventDefault();
                    CreateClassification();
                });

                $(document).on('click', '.btn-update-classification', function(e){
                    e.preventDefault();
                    classificationID = $(this).attr('classification-id');
                    $("#textClassificationId").val(classificationID);

                    GetClassificationIdToEdit(classificationID);  
                });

                $("#formUpdateClassification").submit(function(event) {
                    event.preventDefault();
                    UpdateClassification();
                });

                $(document).on('click', '.actionChangeClassificationStatus', function(){
                    let classificationStatus = $(this).attr('status');
                    let classificationId = $(this).attr('classification-id'); 
                    $("#txtChangeClassificationStatus").val(classificationStatus); 
                    $("#txtChangeClassificationStatusId").val(classificationId); 
                    
                    if(classificationStatus == 1){
                        $("#lblChangeClassificationStatusLabel").text('Are you sure to activate?'); 
                        $("#h4ChangeClassificationTitle").html('<i class="fa fa-wrench"></i> Activate Classification');
                    }else{
                        $("#lblChangeClassificationStatusLabel").text('Are you sure to deactivate?');
                        $("#h4ChangeClassificationTitle").html('<i class="fa fa-wrench"></i> Deactivate Classification');
                    }
                });

                $("#formChangeClassificationStatus").submit(function(event){
                    event.preventDefault();
                    ChangeClassificationStatus();
                });
            });
        </script>
    @endsection
@else
    <script type="text/javascript">
        window.location = "../RapidX/";
    </script>
@endif