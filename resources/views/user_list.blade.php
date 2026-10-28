@php
    session_start();
    $isLogin = false;
    $layout = 'layouts.no_access_layout';
    if(isset($_SESSION['rapidx_user_id'])){
        $isLogin = true;
        // if($_SESSION['rapidx_department_id'] == 1 || $_SESSION["PMCSFES_module_id"] == '9' && $_SESSION['PMCSFES_access'] != '0'){
        if($_SESSION["PMCSFES_module_id"] == '9' && $_SESSION['PMCSFES_access'] != '0'){
            $layout = 'layouts.user_layout';
        }
    }
@endphp
@if($isLogin)
    @extends($layout)
    @section('title', 'User List')
    @section('content_page')
        <style>
            .hidden_text {
                position: absolute;
                opacity: 0;
            }
        </style>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>User Management</h1>
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
                                    <h3 class="card-title">User List</h3>
                                </div>

                                <!-- Start Page Content -->
                                <div class="card-body">
                                    <button type="button" class="btn btn btn-dark float-right" id="btnNewUser" data-toggle="modal" data-target="#modalCreateUpdateUser"><i class="fa fa-plus"></i>&nbsp;Add User</button>
                                    <div class="dt-responsive table-responsive">
                                        <br>
                                        <table id="tableUserList" class="table table-striped table-bordered"
                                            style="width: 100%; font-size: 90%;">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Action</th>
                                                    <th class="text-center">Status</th>
                                                    <th>Name</th>
                                                    <th>Classification</th>
                                                    <th>Category</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div><!-- End Page Content -->

                            </div><!-- /.card -->
                        </div>
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->

        <!-- User Modal Start -->
        <div class="modal fade" id="modalCreateUpdateUser" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                        <h4 class="modal-title"><i class="fa fa-user"></i> User Details</h4>
                        <button type="button" style="color: #fff" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <form method="post" id="formCreateUpdateUser">
                        @csrf
                        <div class="modal-body">
                            <input type="text" class="hidden_text" name="user_id" placeholder="User Id" id="txtUserId" readonly>

                            <div class="mb-3">
                                <label for="approver_employee_no" class="form-label">Employee Name:<span class="text-danger" title="Required">*</span></label>
                                <select class="form-control select2bs4 slctFullName selectReset" name="rapidx_employee_name" id="selectRapidxEmployeeName" required></select>
                            </div>

                            <div class="mb-3">
                                <label for="classification" class="form-label">Classification:<span class="text-danger" title="Required">*</span></label>
                                <select class="form-control selectReset" name="classification" id="selectClassification">
                                    <option selected value="" disabled>--- Select ---</option>
                                    <option value="0">N/A</option>
                                    <option value="1">Sr. Supervisor</option>
                                    <option value="2">Manager</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="classification" class="form-label">Category:<span class="text-danger" title="Required">*</span></label>
                                <select class="form-control selectReset" name="category" id="selectCategory">
                                    <option selected value="" disabled>--- Select ---</option>
                                    <option value="1">Factory 1 & 2</option>
                                    <option value="3">Factory 3</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">No</button>
                            <button type="submit" id="btnCreateUpdateUser" class="btn btn-dark"><i id="iBtnCreateUpdateUserIcon" class="fa fa-check"></i> Yes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- User Modal End -->

        <!-- User Status Modal Start -->
        <div class="modal fade" id="modalChangeUserStatus" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                        <h4 class="modal-title" id="h4ChangeUserTitle"><i class="fa fa-user"></i> Change Status</h4>
                        <button type="button" style="color: #fff" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <form method="post" id="formChangeUserStatus">
                        @csrf
                        <div class="modal-body">
                            <label id="lblChangeUserStatusLabel"></label>
                            <input type="hidden" name="user_id" placeholder="User Id" id="txtChangeUserStatusUserId">
                            <input type="hidden" name="status" placeholder="Status" id="txtChangeUserStatus">
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">No</button>
                            <button type="submit" id="btnChangeUserStat" class="btn btn-dark"><i id="iBtnChangeUserStatIcon" class="fa fa-check"></i> Yes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- User Status Modal End -->
    @endsection

    @section('js_content')
        <script type="text/javascript">
            let dataTableUserList;

            $(document).ready(function () {
                $('.select2').select2();

                $('.select2bs4').select2({
                    theme: 'bootstrap4'
                });            
                
                GetEmployeeName($(".slctFullName"));

                dataTableUserList = $("#tableUserList").DataTable({
                    "processing"    : false,
                    "serverSide"    : true,
                    "responsive"    : true,
                    "order"         : [[ 1, "ASC" ],[ 2, "ASC" ]],
                    "language": {
                            "info": "Showing _START_ to _END_ of _TOTAL_ User Record",
                            "lengthMenu": "Show _MENU_ User Record",
                        },
                        "ajax" : {
                            url: "view_user_list",
                        },
                        "columns":[
                            { "data" : "action", orderable:false, searchable:false},
                            { "data" : "status",
                                "defaultContent": 'N/A',
                                "name": 'status',
                                "orderable": true,
                                "searchable": true,
                                "render": function (data, type, row) {
                                    if(row.status == 1){
                                        return "<center><span class='badge bg-success'>Active</span></center>";
                                    }else{
                                        return "<center><span class='badge bg-danger'>Inactive</span></center>";
                                    }
                                },
                            },
                            { "data" : "rapidx_user_info.name"},
                            { "data" : "classification",
                                defaultContent: 'N/A',
                                name: 'classification',
                                orderable: true,
                                searchable: true,
                                render: {
                                    display: function (data, type, row) {
                                        if(row.classification == 1) {
                                            return "Sr. Supervisor";
                                        }else if(row.classification == 2) {
                                            return "Manager";
                                        }else{
                                            return "N/A";
                                        }
                                    },
                                },    
                            },    
                            { "data" : "category",
                                defaultContent: 'N/A',
                                name: 'category',
                                orderable: true,
                                searchable: true,
                                render: {
                                    display: function (data, type, row) {
                                        if(row.category == 1) {
                                            return "Factory 1 & 2";
                                        }else{
                                            return "Factory 3";
                                        }
                                    },
                                },    
                            },    
                        ],
                });

                $("#formCreateUpdateUser").submit(function(event){
                    event.preventDefault();
                    CreateUpdateUser();
                });

                $(document).on('click', '.actionEditUser', function(e){
                    e.preventDefault();

                    let UserId = $(this).attr('user-id'); 
                    $("#txtUserId").val(UserId);

                    GetUserInfoByIdToEdit(UserId); 
                });

                $('#modalCreateUpdateUser').on('hidden.bs.modal', function(event){
                    event.preventDefault();
                    $("#txtUserId").val('');
                    $(".selectReset").val('').trigger('change');
                });

                $(document).on('click', '.actionChangeUserStatus', function(){
                    let userStat = $(this).attr('status');
                    let userId = $(this).attr('user-id'); 
                    $("#txtChangeUserStatus").val(userStat); 
                    $("#txtChangeUserStatusUserId").val(userId); 

                    if(userStat == 1){
                        $("#lblChangeUserStatusLabel").text('Are you sure to activate?'); 
                        $("#h4ChangeUserTitle").html('<i class="fa fa-user"></i> Activate User');
                    }
                    else{
                        $("#lblChangeUserStatusLabel").text('Are you sure to deactivate?');
                        $("#h4ChangeUserTitle").html('<i class="fa fa-user"></i> Deactivate User');
                    }
                });

                $("#formChangeUserStatus").submit(function(event){
                    event.preventDefault();
                    ChangeUserStatus();
                });

            });
        </script>
    @endsection
@else
    <script type="text/javascript">
        window.location = "../RapidX/";
    </script>
@endif