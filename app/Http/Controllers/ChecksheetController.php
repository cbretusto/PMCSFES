<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Maatwebsite\Excel\Facades\Excel;

use Carbon\Carbon;
use DataTables;
use Auth;
use Mail;

use App\Model\RapidXUser;
use App\Model\Checksheet;
use App\Model\Device;

use App\Exports\ChecksheetExportEXL;
use App\Exports\ChecksheetExportEL;
use App\Exports\ChecksheetExportFE;
use App\Exports\ChecksheetExportFH;
use App\Exports\ChecksheetExport;

class ChecksheetController extends Controller
{
    // Datatables of Checksheets

    public function view_checksheets_table(Request $request){
        session_start();

        $rapidx_user_id = $_SESSION['rapidx_user_id'];
        $checksheet = Checksheet::with(['inspector_details', 'checksheet_device_info'])->where('device_id', $request->device_id)->where('status', 0)->where('log_del', 0)->orderBy('checksheet_id', 'DESC')->get();

        $noted_by_supervisor = Checksheet::with(['supervisor_details'])->where('device_id', $request->device_id)->get();

        $manager = Checksheet::with(['manager_details'])->where('device_id', $request->device_id)->get();

        return DataTables::of($checksheet)
            ->addColumn('checksheet_action', function ($checksheet) use ($rapidx_user_id) {
                $result = "<center>";

                // CHAN - 01-24-25 - START
                if($checksheet->device_id == 8 || $checksheet->device_id == 18){ // Emergency Light
                    $result .= ' <button type="button" class="btn btn-sm btn-info btn-fill-criteria-el" data-toggle="modal" data-target="#modalViewELCriteria" title="Fill-up Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '" checksheet-device_id="' . $checksheet->device_id . '"><i class="fa fa-edit"></i></button>';
                }else if($checksheet->device_id == 9 || $checksheet->device_id == 19){ // Exit Light
                    $result .= ' <button type="button" class="btn btn-sm btn-info btn-fill-criteria-exl" data-toggle="modal" data-target="#modalViewEXLCriteria" title="Fill-up Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '" checksheet-device_id="' . $checksheet->device_id . '"><i class="fa fa-edit"></i></button>';
                }else if($checksheet->device_id == 10 || $checksheet->device_id == 20){ // Fire Extinguisher
                    $result .= ' <button type="button" class="btn btn-sm btn-info btn-fill-criteria-fe" data-toggle="modal" data-target="#modalViewFECriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '" checksheet-device_id="' . $checksheet->device_id . '"><i class="fa fa-edit"></i></button>';
                }else if($checksheet->device_id == 11 || $checksheet->device_id == 21){ // Fire Hose Cabinet
                    $result .= ' <button type="button" class="btn btn-sm btn-info btn-fill-criteria-fh" data-toggle="modal" data-target="#modalViewFHCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '" checksheet-device_id="' . $checksheet->device_id . '"><i class="fa fa-edit"></i></button>';
                }else{
                    $result .= ' <button type="button" class="btn btn-sm btn-info btn-fill-criteria" data-toggle="modal" data-target="#modalViewCriteria" title="Fill-up Maintenance Checksheets" checksheet-id="' . $checksheet->checksheet_id . '" checksheet-device_id="' . $checksheet->device_id . '" checksheet-general_area="' . $checksheet->checksheet_device_info->general_area . '" checksheet-classification="' . $checksheet->checksheet_device_info->classification . '" checksheet-factory="' . $checksheet->factory . '"><i class="fa fa-edit"></i></button>';
                }

                if($checksheet->checking == 1){
                    $result .= ' <button type="button" class="btn btn-sm btn-dark btn-submit-checksheet" data-toggle="modal" data-target="#modalSubmitChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '" checksheet-device_id="' . $checksheet->device_id . '" checksheet-factory="' . $checksheet->factory . '"><i class="fa fa-upload"></i></button>';
                }

                $result .= "</center>";
                return $result;

                /*
                TODO: Another option - Magresign ka na!
                switch ($checksheet->device_id) {
                    case 8: {
                        //view Maintenance Checksheets
                        $result .= ' <button type="button" class="btn btn-sm btn-info btn-fill-criteria-el" data-toggle="modal" data-target="#modalViewELCriteria" title="Fill-up Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-edit"></i></button>';
                        break;
                    }

                    case 9: {
                        //view Maintenance Checksheets
                        $result .= ' <button type="button" class="btn btn-sm btn-info btn-fill-criteria-exl" data-toggle="modal" data-target="#modalViewEXLCriteria" title="Fill-up Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-edit"></i></button>';
                        break;
                    }

                    case 10: {
                        //view Maintenance Checksheets
                        $result .= ' <button type="button" class="btn btn-sm btn-info btn-fill-criteria-fe" data-toggle="modal" data-target="#modalViewFECriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-edit"></i></button>';
                        break;
                    }

                    case 11: {
                        //view Maintenance Checksheets
                        $result .= ' <button type="button" class="btn btn-sm btn-info btn-fill-criteria-fh" data-toggle="modal" data-target="#modalViewFHCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-edit"></i></button>';
                        break;
                    }

                    case 18: {
                        //view Maintenance Checksheets
                        $result .= ' <button type="button" class="btn btn-sm btn-info btn-fill-criteria-el" data-toggle="modal" data-target="#modalViewELCriteria" title="Fill-up Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-edit"></i></button>';
                        break;
                    }

                    case 19: {
                        //view Maintenance Checksheets
                        $result .= ' <button type="button" class="btn btn-sm btn-info btn-fill-criteria-exl" data-toggle="modal" data-target="#modalViewEXLCriteria" title="Fill-up Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-edit"></i></button>';
                        break;
                    }

                    case 20: {
                        //view Maintenance Checksheets
                        $result .= ' <button type="button" class="btn btn-sm btn-info btn-fill-criteria-fe" data-toggle="modal" data-target="#modalViewFECriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-edit"></i></button>';
                        break;
                    }

                    case 21: {
                        //view Maintenance Checksheets
                        $result .= ' <button type="button" class="btn btn-sm btn-info btn-fill-criteria-fh" data-toggle="modal" data-target="#modalViewFHCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-edit"></i></button>';
                        break;
                    }

                    default: {
                        //view Maintenance Checksheets
                        $result .= ' <button type="button" class="btn btn-sm btn-info btn-fill-criteria" data-toggle="modal" data-target="#modalViewCriteria" title="Fill-up Maintenance Checksheets" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-edit"></i></button>';
                    }
                }
                */
                // CHAN - 01-24-25 - END
            })

            // ! =================================================================================================================================================
            // ! ============================================= OLD CODE ==========================================================================================
            // ! =================================================================================================================================================
            // !switch ($checksheet->device_id) {
            // !    case 8: {
            // !        if ($checksheet->status == 0) {
            // !            //view Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-fill-criteria-el" data-toggle="modal" data-target="#modalViewELCriteria" title="Fill-up Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-edit"></i></button>';
            // !            //Submit Maintenance Checksheets
            // !            //$result .= ' <button type="button" class="btn btn-sm btn-info btn-submit-checksheet" data-toggle="modal" data-target="#modalSubmitChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-upload"></i></button>';
            // !            break;
            // !        } else if ($checksheet->status == 1) {
            // !            if ($rapidx_user_id != 704 ) { //Mannix -> Sr Supervisor
            // !                //view Maintenance Checksheets
            // !                $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-el" data-toggle="modal" data-target="#modalViewELCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !                break;
            // !            } else {
            // !                //view Maintenance Checksheets
            // !                $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-el" data-toggle="modal" data-target="#modalViewELCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !                //Approve Maintenance Checksheet
            // !                $result .= ' <button type="button" class="btn btn-sm btn-success btn-approve-checksheet-noted_by_supervisor" data-toggle="modal" data-target="#modalSupervisorApproveChecksheet" title="Approve Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-check-circle"></i></button>';
            // !                break;
            // !            }
            // !        } else if ($checksheet->status == 2) {
            // !            if ($rapidx_user_id != 141) { //Jeff -> Manager
            // !                //view Maintenance Checksheets
            // !                $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-el" data-toggle="modal" data-target="#modalViewELCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !                break;
            // !            } else {
            // !                //view Maintenance Checksheets
            // !                $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-el" data-toggle="modal" data-target="#modalViewELCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !                //Approve Maintenance Checksheets
            // !                $result .= ' <button type="button" class="btn btn-sm btn-success btn-approve-checksheet-manager" data-toggle="modal" data-target="#modalManagerApproveChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-check-circle"></i></button>';
            // !                break;
            // !            }
            // !        } else if ($checksheet->status == 3) {
            // !            //view Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-el" data-toggle="modal" data-target="#modalViewELCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !            //Export Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-export-criteria-el" data-toggle="modal" title="Export Maintenance Checksheets" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-file-excel"></i></button>';
            // !            break;
            // !        } else {
            // !            //view Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-fill-criteria-el" data-toggle="modal" data-target="#modalViewELCriteria" title="Fill-up Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-edit"></i></button>';
            // !            //Submit Maintenance Checksheets
            // !            //$result .= ' <button type="button" class="btn btn-sm btn-info btn-submit-checksheet" data-toggle="modal" data-target="#modalSubmitChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-upload"></i></button>';
            // !            break;
            // !        }
            // !    }
            // !    case 9: {
            // !        if ($checksheet->status == 0) {
            // !            //view Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-fill-criteria-exl" data-toggle="modal" data-target="#modalViewEXLCriteria" title="Fill-up Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-edit"></i></button>';
            // !            //Submit Maintenance Checksheets
            // !            //$result .= ' <button type="button" class="btn btn-sm btn-info btn-submit-checksheet" data-toggle="modal" data-target="#modalSubmitChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-upload"></i></button>';
            // !            break;
            // !        } else if ($checksheet->status == 1) {
            // !            if ($rapidx_user_id != 704 ) { //Mannix -> Sr Supervisor
            // !                    //view Maintenance Checksheets
            // !                $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-exl" data-toggle="modal" data-target="#modalViewEXLCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !                break;
            // !            } else {
            // !                //view Maintenance Checksheets
            // !                $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-exl" data-toggle="modal" data-target="#modalViewEXLCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !                //Approve Maintenance Checksheet
            // !                $result .= ' <button type="button" class="btn btn-sm btn-success btn-approve-checksheet-noted_by_supervisor" data-toggle="modal" data-target="#modalSupervisorApproveChecksheet" title="Approve Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-check-circle"></i></button>';
            // !                break;
            // !            }
            // !            break;
            // !        } else if ($checksheet->status == 2) {
            // !            if ($rapidx_user_id != 141) { //Jeff -> Manager
            // !                //view Maintenance Checksheets
            // !                $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-exl" data-toggle="modal" data-target="#modalViewEXLCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !                break;
            // !            } else {
            // !                //view Maintenance Checksheets
            // !                $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-exl" data-toggle="modal" data-target="#modalViewEXLCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !                //Approve Maintenance Checksheets
            // !                $result .= ' <button type="button" class="btn btn-sm btn-success btn-approve-checksheet-manager" data-toggle="modal" data-target="#modalManagerApproveChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-check-circle"></i></button>';
            // !                break;
            // !            }
            // !        } else if ($checksheet->status == 3) {
            // !            //view Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-exl" data-toggle="modal" data-target="#modalViewEXLCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !            //Export Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-export-criteria-exl" data-toggle="modal" title="Export Maintenance Checksheets" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-file-excel"></i></button>';
            // !            break;
            // !        } else {
            // !            //view Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-exl" data-toggle="modal" data-target="#modalViewEXLCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !            //Submit Maintenance Checksheets
            // !            //$result .= ' <button type="button" class="btn btn-sm btn-info btn-submit-checksheet" data-toggle="modal" data-target="#modalSubmitChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-upload"></i></button>';
            // !            break;
            // !        }
            // !    }
            // !    case 10: {
            // !        if ($checksheet->status == 0) {
            // !            //view Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-fill-criteria-fe" data-toggle="modal" data-target="#modalViewFECriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-edit"></i></button>';
            // !            //Submit Maintenance Checksheets
            // !            //$result .= ' <button type="button" class="btn btn-sm btn-info btn-submit-checksheet" data-toggle="modal" data-target="#modalSubmitChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-upload"></i></button>';
            // !            break;
            // !        } else if ($checksheet->status == 1) {
            // !            if ($rapidx_user_id != 704 ) { //Mannix -> Sr Supervisor
            // !                    //view Maintenance Checksheets
            // !                $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-fe" data-toggle="modal" data-target="#modalViewFECriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !                break;
            // !            } else {
            // !                //view Maintenance Checksheets
            // !                $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-fe" data-toggle="modal" data-target="#modalViewFECriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !                //Approve Maintenance Checksheet
            // !                $result .= ' <button type="button" class="btn btn-sm btn-success btn-approve-checksheet-noted_by_supervisor" data-toggle="modal" data-target="#modalSupervisorApproveChecksheet" title="Approve Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-check-circle"></i></button>';
            // !                break;
            // !            }
            // !        } else if ($checksheet->status == 2) {
            // !            if ($rapidx_user_id != 141) { //Jeff -> Manager
            // !                //view Maintenance Checksheets
            // !                $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-fe" data-toggle="modal" data-target="#modalViewFECriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !                break;
            // !            } else {
            // !                //view Maintenance Checksheets
            // !                $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-fe" data-toggle="modal" data-target="#modalViewFECriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !                //Approve Maintenance Checksheets
            // !                $result .= ' <button type="button" class="btn btn-sm btn-success btn-approve-checksheet-manager" data-toggle="modal" data-target="#modalManagerApproveChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-check-circle"></i></button>';
            // !                break;
            // !            }
            // !        } else if ($checksheet->status == 3) {
            // !            //view Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-fe" data-toggle="modal" data-target="#modalViewFECriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !            //Export Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-export-criteria-fe" data-toggle="modal" title="Export Maintenance Checksheets" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-file-excel"></i></button>';
            // !            break;
            // !        } else {
            // !            //view Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-fe" data-toggle="modal" data-target="#modalViewFECriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !            //Submit Maintenance Checksheets
            // !            //$result .= ' <button type="button" class="btn btn-sm btn-info btn-submit-checksheet" data-toggle="modal" data-target="#modalSubmitChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-upload"></i></button>';
            // !            break;
            // !        }
            // !    }
            // !    case 11: {
            // !        if ($checksheet->status == 0) {
            // !            //view Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-fill-criteria-fh" data-toggle="modal" data-target="#modalViewFHCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-edit"></i></button>';
            // !            //Submit Maintenance Checksheets
            // !            //$result .= ' <button type="button" class="btn btn-sm btn-info btn-submit-checksheet" data-toggle="modal" data-target="#modalSubmitChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-upload"></i></button>';
            // !            break;
            // !        } else if ($checksheet->status == 1) {
            // !            if ($rapidx_user_id != 704 ) { //Mannix -> Sr Supervisor
            // !                    //view Maintenance Checksheets
            // !                $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-fh" data-toggle="modal" data-target="#modalViewFHCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !                break;
            // !            } else {
            // !                //view Maintenance Checksheets
            // !                $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-fh" data-toggle="modal" data-target="#modalViewFHCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !                //Approve Maintenance Checksheet
            // !                $result .= ' <button type="button" class="btn btn-sm btn-success btn-approve-checksheet-noted_by_supervisor" data-toggle="modal" data-target="#modalSupervisorApproveChecksheet" title="Approve Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-check-circle"></i></button>';
            // !                break;
            // !            }
            // !        } else if ($checksheet->status == 2) {
            // !            if ($rapidx_user_id != 141) { //Jeff -> Manager
            // !                //view Maintenance Checksheets
            // !                $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-fh" data-toggle="modal" data-target="#modalViewFHCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !                break;
            // !            } else {
            // !                //view Maintenance Checksheets
            // !                $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-fh" data-toggle="modal" data-target="#modalViewFHCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !                //Approve Maintenance Checksheets
            // !                $result .= ' <button type="button" class="btn btn-sm btn-success btn-approve-checksheet-manager" data-toggle="modal" data-target="#modalManagerApproveChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-check-circle"></i></button>';
            // !                break;
            // !            }
            // !        } else if ($checksheet->status == 3) {
            // !            //view Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-fh" data-toggle="modal" data-target="#modalViewFHCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !            //Export Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-export-criteria-fh" data-toggle="modal" title="Export Maintenance Checksheets" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-file-excel"></i></button>';
            // !            break;
            // !        } else {
            // !            //view Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-fh" data-toggle="modal" data-target="#modalViewFHCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !            //Submit Maintenance Checksheets
            // !            //$result .= ' <button type="button" class="btn btn-sm btn-info btn-submit-checksheet" data-toggle="modal" data-target="#modalSubmitChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-upload"></i></button>';
            // !            break;
            // !        }
            // !    }
            // !    default: {
            // !            if ($checksheet->status == 0) {
            // !                //view Maintenance Checksheets
            // !                $result .= ' <button type="button" class="btn btn-sm btn-info btn-fill-criteria" data-toggle="modal" data-target="#modalViewCriteria" title="Fill-up Maintenance Checksheets" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-edit"></i></button>';
            // !                //Submit Maintenance Checksheets
            // !                //$result .= ' <button type="button" class="btn btn-sm btn-info btn-submit-checksheet" data-toggle="modal" data-target="#modalSubmitChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-upload"></i></button>';
            // !                break;
            // !            } else if ($checksheet->status == 1) {
            // !                if ($rapidx_user_id != 704 ) { //Mannix -> Sr Supervisor
            // !                    //view Maintenance Checksheets
            // !                    $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria" data-toggle="modal" data-target="#modalViewCriteria" title="View Maintenance Checksheets" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !                    break;
            // !                } else {
            // !                    //view Maintenance Checksheets
            // !                    $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria" data-toggle="modal" data-target="#modalViewCriteria" title="View Maintenance Checksheets" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !                    //Approve Maintenance Checksheet
            // !                    $result .= ' <button type="button" class="btn btn-sm btn-success btn-approve-checksheet-noted_by_supervisor" data-toggle="modal" data-target="#modalSupervisorApproveChecksheet" title="Approve Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-check-circle"></i></button>';
            // !                    break;
            // !                }
            // !            } else if ($checksheet->status == 2) {
            // !                if ($rapidx_user_id != 141) { //Jeff -> Manager
            // !                    //view Maintenance Checksheets
            // !                    $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria" data-toggle="modal" data-target="#modalViewCriteria" title="View Maintenance Checksheets" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !                    break;
            // !                } else {
            // !                    //view Maintenance Checksheets
            // !                    $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria" data-toggle="modal" data-target="#modalViewCriteria" title="View Maintenance Checksheets" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !                    //Approve Maintenance Checksheets
            // !                    $result .= ' <button type="button" class="btn btn-sm btn-success btn-approve-checksheet-manager" data-toggle="modal" data-target="#modalManagerApproveChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-check-circle"></i></button>';
            // !                    break;
            // !                }
            // !            } else if ($checksheet->status == 3) {
            // !                //view Maintenance Checksheets
            // !                $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria" data-toggle="modal" data-target="#modalViewCriteria" title="View Maintenance Checksheets" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !                //Export Maintenance Checksheets
            // !                $result .= ' &nbsp;<button type="button" class="btn btn-sm btn-info btn-export-criteria" data-toggle="modal" title="Export Maintenance Checksheets" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-file-excel"></i></button>';
            // !                break;
            // !            } else {
            // !                //view Maintenance Checksheets
            // !                $result .= ' <button type="button" class="btn btn-sm btn-info btn-fill-criteria" data-toggle="modal" data-target="#modalViewCriteria" title="Fill-up Maintenance Checksheets" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-edit"></i></button>';
            // !                //Submit Maintenance Checksheets
            // !                $result .= ' <button type="button" class="btn btn-sm btn-info btn-submit-checksheet" data-toggle="modal" data-target="#modalSubmitChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-upload"></i></button>';
            // !                break;
            // !            }
            // !        }
            // !    }
            // ! $result .= "</center>";
            // ! return $result;
            // !})
            ->addColumn('status', function ($checksheet) {

                $result = "";

                switch ($checksheet->status) {
                    case 0: {
                            //view Maintenance Checksheets
                            $result = '<center><span class="badge badge-pill badge-primary">To be Filled Up</span></center>';
                            break;
                        }

                    case 1: {
                            //view Maintenance Checksheets
                            $result = '<center><span class="badge badge-pill badge-warning">For Supervisor Approval</span></center>';
                            break;
                        }

                    case 2: {
                            //view Maintenance Checksheets
                            $result = '<center><span class="badge badge-pill badge-warning">For Manager Approval</span></center>';
                            break;
                        }

                    case 3: {
                            //view Maintenance Checksheets
                            $result = '<center><span class="badge badge-pill badge-success">Approved</span></center>';
                            break;
                        }
                    case 4: {
                            //view Maintenance Checksheets
                            $result = '<center><span class="badge badge-pill badge-danger">Disapproved, to be Edited</span></center>';
                            break;
                        }
                }
                return $result;
            })
            ->addColumn('checksheet_name', function ($checksheet) {

                $result = $checksheet->checksheet_name;

                return $result;
            })
            ->addColumn('date_inspected', function ($checksheet) {

                $result = $checksheet->date_inspected;

                return $result;
            })
            ->addColumn('checked_by', function ($checksheet) {

                $result = '';

                if ($checksheet->checked_by != null) {
                    $result = $checksheet->inspector_details->name;
                } else {
                    $result = '<center><span class="badge badge-pill badge-secondary">N/A</span><center>';
                }
                return $result;
            })
            ->addColumn('noted_by_supervisor', function ($noted_by_supervisor) {

                if ($noted_by_supervisor->noted_by_supervisor != null) {
                    $result = $noted_by_supervisor->supervisor_details->name;
                } else {
                    $result = '<center><span class="badge badge-pill badge-secondary">N/A</span><center>';
                }
                return $result;
            })
            ->addColumn('supervisor_remarks', function ($checksheet) {

                if ($checksheet->s_remarks != null) {
                    $result = $checksheet->s_remarks;
                } else {
                    $result = '<center><span class="badge badge-pill badge-secondary">N/A</span><center>';
                }
                return $result;
            })
            ->addColumn('noted_by_manager', function ($manager) {

                if ($manager->noted_by_manager != null) {
                    $result = $manager->manager_details->name;
                } else {
                    $result = '<center><span class="badge badge-pill badge-secondary">N/A</span><center>';
                }
                return $result;
            })
            ->addColumn('manager_remarks', function ($checksheet) {

                if ($checksheet->m_remarks != null) {
                    $result = $checksheet->m_remarks;
                } else {
                    $result = '<center><span class="badge badge-pill badge-secondary">N/A</span><center>';
                }
                return $result;
            })
            ->rawColumns(['checksheet_action', 'status', 'checksheet_name', 'date_inspected', 'checked_by', 'noted_by_supervisor', 'supervisor_remarks', 'noted_by_manager', 'manager_remarks'])
            ->make(true);
    }

    public function view_approval_checksheets_table(Request $request){
        session_start();

        $rapidx_user_id = $_SESSION['rapidx_user_id'];
        $checksheet = Checksheet::with(['inspector_details','supervisor_details','manager_details'])->where('device_id', $request->device_id)->whereIn('status', [1,2])->where('log_del', 0)->get();
        // return  $checksheet;
        $noted_by_supervisor = Checksheet::with(['supervisor_details'])->where('device_id', $request->device_id)->get();

        $manager = Checksheet::with(['manager_details'])->where('device_id', $request->device_id)->get();

        return DataTables::of($checksheet)
            ->addColumn('checksheet_action', function ($checksheet) use ($rapidx_user_id) {
                $result = "<center>";
                // CHAN - 01-24-25 - START
                if($checksheet->device_id == 8 || $checksheet->device_id == 18){
                    $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-el" data-toggle="modal" data-target="#modalViewELCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '" checksheet-device_id="' . $checksheet->device_id . '"><i class="fa fa-eye"></i></button>';
                }else if($checksheet->device_id == 9 || $checksheet->device_id == 19){
                    $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-exl" data-toggle="modal" data-target="#modalViewEXLCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '" checksheet-device_id="' . $checksheet->device_id . '"><i class="fa fa-eye"></i></button>';
                }else if($checksheet->device_id == 10 || $checksheet->device_id == 20){
                    $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-fe" data-toggle="modal" data-target="#modalViewFECriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '" checksheet-device_id="' . $checksheet->device_id . '"><i class="fa fa-eye"></i></button>';
                }else if($checksheet->device_id == 11 || $checksheet->device_id == 21){
                    $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-fh" data-toggle="modal" data-target="#modalViewFHCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '" checksheet-device_id="' . $checksheet->device_id . '"><i class="fa fa-eye"></i></button>';
                }else{
                    $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria" data-toggle="modal" data-target="#modalViewCriteria" title="View Maintenance Checksheets" checksheet-id="' . $checksheet->checksheet_id . '" checksheet-device_id="' . $checksheet->device_id . '"><i class="fa fa-eye"></i></button>';
                }
                if ($checksheet->status == 1) {
                    if($checksheet->supervisor_details != ''){
                        if ($checksheet->supervisor_details->id == $rapidx_user_id) { // 704 = Mannix / 163 = Earl -> Sr Supervisor
                            //Approve Maintenance Checksheet
                            $result .= ' <button type="button" class="btn btn-sm btn-success btn-approve-checksheet-noted_by_supervisor" data-toggle="modal" data-target="#modalSupervisorApproveChecksheet" title="Approve Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '" checksheet-device_id="' . $checksheet->device_id . '"><i class="fa fa-check-circle"></i></button>';
                        }
                    }
                }
                if ($checksheet->status == 2) {
                    // $result .= $checksheet->manager_details;
                    if($checksheet->manager_details != ''){
                        if ($checksheet->manager_details->id == $rapidx_user_id) { // 141 = Jeff -> Manager
                            //Approve Maintenance Checksheets
                            $result .= ' <button type="button" class="btn btn-sm btn-success btn-approve-checksheet-manager" data-toggle="modal" data-target="#modalManagerApproveChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '" checksheet-device_id="' . $checksheet->device_id . '" checksheet-noted-by-manager="'.$checksheet->manager_details->name.'"><i class="fa fa-check-circle"></i></button>';
                        }
                    }else{
                        $result .= "\n<span class='badge bg-warning'>Approval button not found!</span>";
                    }
                }
                $result .= "</center>";
                return $result;
            })// CHAN - 01-24-25 - END

            // ! =================================================================================================================================================
            // ! ============================================= OLD CODE ==========================================================================================
            // ! =================================================================================================================================================
            // !switch ($checksheet->device_id) {
            // !    case 8: {
            // !        if ($checksheet->status == 0) {
            // !            //view Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-fill-criteria-el" data-toggle="modal" data-target="#modalViewELCriteria" title="Fill-up Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-edit"></i></button>';

            // !            //Submit Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-submit-checksheet" data-toggle="modal" data-target="#modalSubmitChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-upload"></i></button>';
            // !            break;
            // !        } else if ($checksheet->status == 1) {
            // !            //if ($rapidx_user_id != 704 ) { //Mannix -> Sr Supervisor // CHAN 01-16-25 - old
            // !            //CHAN 01-20-25
            // !            if($checksheet->supervisor_details != ''){
            // !                if ($checksheet->supervisor_details->id == $rapidx_user_id) { // 704 = Mannix, 163 = Earl -> Sr Supervisor// CHAN 01-16-25 - new
            // !                    //A!pprove Maintenance Checksheet
            // !                    $result .= ' <button type="button" class="btn btn-sm btn-success btn-approve-checksheet-noted_by_supervisor" data-toggle="modal" data-target="#modalSupervisorApproveChecksheet" title="Approve Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-check-circle"></i></button>';
            // !                }
            // !            }
            // !            //view Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-el" data-toggle="modal" data-target="#modalViewELCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !            break;

            // !        } else if ($checksheet->status == 2) {
            // !            if ($rapidx_user_id != 141) { //Jeff -> Manager
            // !                //view Maintenance Checksheets
            // !                $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-el" data-toggle="modal" data-target="#modalViewELCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !                break;
            // !            } else {
            // !                //view Maintenance Checksheets
            // !                $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-el" data-toggle="modal" data-target="#modalViewELCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';

            // !                //A!pprove Maintenance Checksheets
            // !                $result .= ' <button type="button" class="btn btn-sm btn-success btn-approve-checksheet-manager" data-toggle="modal" data-target="#modalManagerApproveChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-check-circle"></i></button>';
            // !                break;
            // !            }
            // !        } else if ($checksheet->status == 3) {
            // !            //view Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-el" data-toggle="modal" data-target="#modalViewELCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !            //Export Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-export-criteria-el" data-toggle="modal" title="Export Maintenance Checksheets" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-file-excel"></i></button>';
            // !            break;
            // !        } else {
            // !            //view Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-fill-criteria-el" data-toggle="modal" data-target="#modalViewELCriteria" title="Fill-up Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-edit"></i></button>';

            // !            //Submit Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-submit-checksheet" data-toggle="modal" data-target="#modalSubmitChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-upload"></i></button>';
            // !            break;
            // !        }
            // !    }

            // !    case 9: {
            // !        if ($checksheet->status == 0) {
            // !            //view Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-fill-criteria-exl" data-toggle="modal" data-target="#modalViewEXLCriteria" title="Fill-up Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-edit"></i></button>';

            // !            //Submit Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-submit-checksheet" data-toggle="modal" data-target="#modalSubmitChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-upload"></i></button>';
            // !            break;
            // !        } else if ($checksheet->status == 1) {
            // !            // if ($rapidx_user_id != 704 ) { //Mannix -> Sr Supervisor // CHAN 01-16-25 - old
            // !            //CHAN 01-20-25
            // !            if($checksheet->supervisor_details != ''){
            // !                if ($checksheet->supervisor_details->id == $rapidx_user_id) { // 704 = Mannix, 163 = Earl -> Sr Supervisor// CHAN 01-16-25 - new
            // !                    //A!pprove Maintenance Checksheet
            // !                    $result .= ' <button type="button" class="btn btn-sm btn-success btn-approve-checksheet-noted_by_supervisor" data-toggle="modal" data-target="#modalSupervisorApproveChecksheet" title="Approve Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-check-circle"></i></button>';
            // !                }
            // !            }
            // !            //view Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-exl" data-toggle="modal" data-target="#modalViewEXLCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !            break;
            // !        } else if ($checksheet->status == 2) {
            // !            if ($rapidx_user_id != 141) { //Jeff -> Manager
            // !                //view Maintenance Checksheets
            // !                $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-exl" data-toggle="modal" data-target="#modalViewEXLCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !                break;
            // !            } else {
            // !                //view Maintenance Checksheets
            // !                $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-exl" data-toggle="modal" data-target="#modalViewEXLCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';

            // !                //A!pprove Maintenance Checksheets
            // !                $result .= ' <button type="button" class="btn btn-sm btn-success btn-approve-checksheet-manager" data-toggle="modal" data-target="#modalManagerApproveChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-check-circle"></i></button>';
            // !                break;
            // !            }
            // !        } else if ($checksheet->status == 3) {
            // !            //view Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-exl" data-toggle="modal" data-target="#modalViewEXLCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';

            // !            //Export Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-export-criteria-exl" data-toggle="modal" title="Export Maintenance Checksheets" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-file-excel"></i></button>';
            // !            break;
            // !        } else {
            // !            //view Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-exl" data-toggle="modal" data-target="#modalViewEXLCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';

            // !            //Submit Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-submit-checksheet" data-toggle="modal" data-target="#modalSubmitChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-upload"></i></button>';
            // !            break;
            // !        }
            // !    }

            // !    case 10: {
            // !        if ($checksheet->status == 0) {
            // !            //view Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-fill-criteria-fe" data-toggle="modal" data-target="#modalViewFECriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-edit"></i></button>';

            // !            //Submit Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-submit-checksheet" data-toggle="modal" data-target="#modalSubmitChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-upload"></i></button>';
            // !            break;
            // !        } else if ($checksheet->status == 1) {
            // !            // if ($rapidx_user_id != 704 ) { //Mannix -> Sr Supervisor // CHAN 01-16-25 - old
            // !            //CHAN 01-20-25
            // !            if($checksheet->supervisor_details != ''){
            // !                if ($checksheet->supervisor_details->id == $rapidx_user_id) { // 704 = Mannix, 163 = Earl -> Sr Supervisor// CHAN 01-16-25 - new
            // !                    //A!pprove Maintenance Checksheet
            // !                    $result .= ' <button type="button" class="btn btn-sm btn-success btn-approve-checksheet-noted_by_supervisor" data-toggle="modal" data-target="#modalSupervisorApproveChecksheet" title="Approve Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-check-circle"></i></button>';
            // !                }
            // !            }
            // !            //view Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-fe" data-toggle="modal" data-target="#modalViewFECriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !            break;

            // !        } else if ($checksheet->status == 2) {
            // !            if ($rapidx_user_id != 141) { //Jeff -> Manager
            // !                //view Maintenance Checksheets
            // !                $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-fe" data-toggle="modal" data-target="#modalViewFECriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !                break;
            // !            } else {
            // !                //view Maintenance Checksheets
            // !                $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-fe" data-toggle="modal" data-target="#modalViewFECriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';

            // !                //A!pprove Maintenance Checksheets
            // !                $result .= ' <button type="button" class="btn btn-sm btn-success btn-approve-checksheet-manager" data-toggle="modal" data-target="#modalManagerApproveChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-check-circle"></i></button>';
            // !                break;
            // !            }
            // !        } else if ($checksheet->status == 3) {
            // !            //view Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-fe" data-toggle="modal" data-target="#modalViewFECriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';

            // !            //Export Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-export-criteria-fe" data-toggle="modal" title="Export Maintenance Checksheets" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-file-excel"></i></button>';
            // !            break;
            // !        } else {
            // !            //view Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-fe" data-toggle="modal" data-target="#modalViewFECriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';

            // !            //Submit Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-submit-checksheet" data-toggle="modal" data-target="#modalSubmitChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-upload"></i></button>';

            // !            break;
            // !        }
            // !    }

            // !    case 11: {
            // !        if ($checksheet->status == 0) {
            // !            //view Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-fill-criteria-fh" data-toggle="modal" data-target="#modalViewFHCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-edit"></i></button>';

            // !            //Submit Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-submit-checksheet" data-toggle="modal" data-target="#modalSubmitChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-upload"></i></button>';
            // !            break;
            // !        } else if ($checksheet->status == 1) {
            // !            // if ($rapidx_user_id != 704 ) { //Mannix -> Sr Supervisor // CHAN 01-16-25 - old
            // !            //CHAN 01-20-25
            // !            if($checksheet->supervisor_details != ''){
            // !                if ($checksheet->supervisor_details->id == $rapidx_user_id) { // 704 = Mannix, 163 = Earl -> Sr Supervisor// CHAN 01-16-25 - new
            // !                    //A!pprove Maintenance Checksheet
            // !                    $result .= ' <button type="button" class="btn btn-sm btn-success btn-approve-checksheet-noted_by_supervisor" data-toggle="modal" data-target="#modalSupervisorApproveChecksheet" title="Approve Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-check-circle"></i></button>';
            // !                }
            // !            }
            // !            //view Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-fh" data-toggle="modal" data-target="#modalViewFHCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !            break;

            // !        } else if ($checksheet->status == 2) {
            // !            if ($rapidx_user_id != 141) { //Jeff -> Manager
            // !                //view Maintenance Checksheets
            // !                $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-fh" data-toggle="modal" data-target="#modalViewFHCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !                break;
            // !            } else {
            // !                //view Maintenance Checksheets
            // !                $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-fh" data-toggle="modal" data-target="#modalViewFHCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';

            // !                //A!pprove Maintenance Checksheets
            // !                $result .= ' <button type="button" class="btn btn-sm btn-success btn-approve-checksheet-manager" data-toggle="modal" data-target="#modalManagerApproveChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-check-circle"></i></button>';
            // !                break;
            // !            }
            // !        } else if ($checksheet->status == 3) {
            // !            //view Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-fh" data-toggle="modal" data-target="#modalViewFHCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';

            // !            //Export Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-export-criteria-fh" data-toggle="modal" title="Export Maintenance Checksheets" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-file-excel"></i></button>';
            // !            break;
            // !        } else {
            // !            //view Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-fh" data-toggle="modal" data-target="#modalViewFHCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';

            // !            //Submit Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-submit-checksheet" data-toggle="modal" data-target="#modalSubmitChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-upload"></i></button>';
            // !            break;
            // !        }
            // !    }
            // !    case 19: {
            // !        if ($checksheet->status == 0) {
            // !            //view Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-fill-criteria-el" data-toggle="modal" data-target="#modalViewELCriteria" title="Fill-up Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-edit"></i></button>';

            // !            //Submit Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-submit-checksheet" data-toggle="modal" data-target="#modalSubmitChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-upload"></i></button>';
            // !            break;
            // !        } else if ($checksheet->status == 1) {
            // !            // if ($rapidx_user_id != 704 ) { //Mannix -> Sr Supervisor // CHAN 01-16-25 - old
            // !            //CHAN 01-20-25
            // !            if($checksheet->supervisor_details != ''){
            // !                if ($checksheet->supervisor_details->id == $rapidx_user_id) { // 704 = Mannix, 163 = Earl -> Sr Supervisor// CHAN 01-16-25 - new
            // !                    //A!pprove Maintenance Checksheet
            // !                    $result .= ' <button type="button" class="btn btn-sm btn-success btn-approve-checksheet-noted_by_supervisor" data-toggle="modal" data-target="#modalSupervisorApproveChecksheet" title="Approve Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-check-circle"></i></button>';
            // !                }
            // !            }
            // !            //view Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-el" data-toggle="modal" data-target="#modalViewELCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !            break;

            // !        } else if ($checksheet->status == 2) {
            // !            if ($rapidx_user_id != 141) { //Jeff -> Manager
            // !                //view Maintenance Checksheets
            // !                $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-el" data-toggle="modal" data-target="#modalViewELCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !                break;
            // !            } else {
            // !                //view Maintenance Checksheets
            // !                $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-el" data-toggle="modal" data-target="#modalViewELCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';

            // !                //A!pprove Maintenance Checksheets
            // !                $result .= ' <button type="button" class="btn btn-sm btn-success btn-approve-checksheet-manager" data-toggle="modal" data-target="#modalManagerApproveChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-check-circle"></i></button>';
            // !                break;
            // !            }
            // !        } else if ($checksheet->status == 3) {
            // !            //view Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-el" data-toggle="modal" data-target="#modalViewELCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !            //Export Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-export-criteria-el" data-toggle="modal" title="Export Maintenance Checksheets" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-file-excel"></i></button>';
            // !            break;
            // !        } else {
            // !            //view Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-fill-criteria-el" data-toggle="modal" data-target="#modalViewELCriteria" title="Fill-up Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-edit"></i></button>';

            // !            //Submit Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-submit-checksheet" data-toggle="modal" data-target="#modalSubmitChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-upload"></i></button>';
            // !            break;
            // !        }
            // !    }

            // !    case 20: {
            // !        if ($checksheet->status == 0) {
            // !            //view Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-fill-criteria-exl" data-toggle="modal" data-target="#modalViewEXLCriteria" title="Fill-up Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-edit"></i></button>';

            // !            //Submit Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-submit-checksheet" data-toggle="modal" data-target="#modalSubmitChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-upload"></i></button>';
            // !            break;
            // !        } else if ($checksheet->status == 1) {
            // !            // if ($rapidx_user_id != 704 ) { //Mannix -> Sr Supervisor // CHAN 01-16-25 - old
            // !            //CHAN 01-20-25
            // !            if($checksheet->supervisor_details != ''){
            // !                if ($checksheet->supervisor_details->id == $rapidx_user_id) { // 704 = Mannix, 163 = Earl -> Sr Supervisor// CHAN 01-16-25 - new
            // !                    //A!pprove Maintenance Checksheet
            // !                    $result .= ' <button type="button" class="btn btn-sm btn-success btn-approve-checksheet-noted_by_supervisor" data-toggle="modal" data-target="#modalSupervisorApproveChecksheet" title="Approve Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-check-circle"></i></button>';
            // !                }
            // !            }
            // !            //view Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-exl" data-toggle="modal" data-target="#modalViewEXLCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !            break;
            // !        } else if ($checksheet->status == 2) {
            // !            if ($rapidx_user_id != 141) { //Jeff -> Manager
            // !                //view Maintenance Checksheets
            // !                $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-exl" data-toggle="modal" data-target="#modalViewEXLCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !                break;
            // !            } else {
            // !                //view Maintenance Checksheets
            // !                $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-exl" data-toggle="modal" data-target="#modalViewEXLCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';

            // !                //A!pprove Maintenance Checksheets
            // !                $result .= ' <button type="button" class="btn btn-sm btn-success btn-approve-checksheet-manager" data-toggle="modal" data-target="#modalManagerApproveChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-check-circle"></i></button>';
            // !                break;
            // !            }
            // !        } else if ($checksheet->status == 3) {
            // !            //view Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-exl" data-toggle="modal" data-target="#modalViewEXLCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';

            // !            //Export Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-export-criteria-exl" data-toggle="modal" title="Export Maintenance Checksheets" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-file-excel"></i></button>';
            // !            break;
            // !        } else {
            // !            //view Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-exl" data-toggle="modal" data-target="#modalViewEXLCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';

            // !            //Submit Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-submit-checksheet" data-toggle="modal" data-target="#modalSubmitChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-upload"></i></button>';
            // !            break;
            // !        }
            // !    }

            // !    case 21: {
            // !        if ($checksheet->status == 0) {
            // !            //view Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-fill-criteria-fe" data-toggle="modal" data-target="#modalViewFECriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-edit"></i></button>';

            // !            //Submit Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-submit-checksheet" data-toggle="modal" data-target="#modalSubmitChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-upload"></i></button>';
            // !            break;
            // !        } else if ($checksheet->status == 1) {
            // !            // if ($rapidx_user_id != 704 ) { //Mannix -> Sr Supervisor // CHAN 01-16-25 - old
            // !            //CHAN 01-20-25
            // !            if($checksheet->supervisor_details != ''){
            // !                if ($checksheet->supervisor_details->id == $rapidx_user_id) { // 704 = Mannix, 163 = Earl -> Sr Supervisor// CHAN 01-16-25 - new
            // !                    //A!pprove Maintenance Checksheet
            // !                    $result .= ' <button type="button" class="btn btn-sm btn-success btn-approve-checksheet-noted_by_supervisor" data-toggle="modal" data-target="#modalSupervisorApproveChecksheet" title="Approve Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-check-circle"></i></button>';
            // !                }
            // !            }
            // !            //view Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-fe" data-toggle="modal" data-target="#modalViewFECriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !            break;
            // !        } else if ($checksheet->status == 2) {
            // !            if ($rapidx_user_id != 141) { //Jeff -> Manager
            // !                //view Maintenance Checksheets
            // !                $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-fe" data-toggle="modal" data-target="#modalViewFECriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !                break;
            // !            } else {
            // !                //view Maintenance Checksheets
            // !                $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-fe" data-toggle="modal" data-target="#modalViewFECriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';

            // !                //A!pprove Maintenance Checksheets
            // !                $result .= ' <button type="button" class="btn btn-sm btn-success btn-approve-checksheet-manager" data-toggle="modal" data-target="#modalManagerApproveChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-check-circle"></i></button>';
            // !                break;
            // !            }
            // !        } else if ($checksheet->status == 3) {
            // !            //view Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-fe" data-toggle="modal" data-target="#modalViewFECriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';

            // !            //Export Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-export-criteria-fe" data-toggle="modal" title="Export Maintenance Checksheets" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-file-excel"></i></button>';
            // !            break;
            // !        } else {
            // !            //view Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-fe" data-toggle="modal" data-target="#modalViewFECriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';

            // !            //Submit Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-submit-checksheet" data-toggle="modal" data-target="#modalSubmitChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-upload"></i></button>';

            // !            break;
            // !        }
            // !    }

            // !    case 22: {
            // !        if ($checksheet->status == 0) {
            // !            //view Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-fill-criteria-fh" data-toggle="modal" data-target="#modalViewFHCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-edit"></i></button>';

            // !            //Submit Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-submit-checksheet" data-toggle="modal" data-target="#modalSubmitChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-upload"></i></button>';
            // !            break;
            // !        } else if ($checksheet->status == 1) {
            // !            // if ($rapidx_user_id != 704 ) { //Mannix -> Sr Supervisor // CHAN 01-16-25 - old
            // !            //CHAN 01-20-25
            // !            if($checksheet->supervisor_details != ''){
            // !                if ($checksheet->supervisor_details->id == $rapidx_user_id) { // 704 = Mannix, 163 = Earl -> Sr Supervisor// CHAN 01-16-25 - new
            // !                    //A!pprove Maintenance Checksheet
            // !                    $result .= ' <button type="button" class="btn btn-sm btn-success btn-approve-checksheet-noted_by_supervisor" data-toggle="modal" data-target="#modalSupervisorApproveChecksheet" title="Approve Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-check-circle"></i></button>';
            // !                }
            // !            }
            // !            //view Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-fh" data-toggle="modal" data-target="#modalViewFHCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !            break;
            // !        } else if ($checksheet->status == 2) {
            // !            if ($rapidx_user_id != 141) { //Jeff -> Manager
            // !                //view Maintenance Checksheets
            // !                $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-fh" data-toggle="modal" data-target="#modalViewFHCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !                break;
            // !            } else {
            // !                //view Maintenance Checksheets
            // !                $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-fh" data-toggle="modal" data-target="#modalViewFHCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';

            // !                //A!pprove Maintenance Checksheets
            // !                $result .= ' <button type="button" class="btn btn-sm btn-success btn-approve-checksheet-manager" data-toggle="modal" data-target="#modalManagerApproveChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-check-circle"></i></button>';
            // !                break;
            // !            }
            // !        } else if ($checksheet->status == 3) {
            // !            //view Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-fh" data-toggle="modal" data-target="#modalViewFHCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';

            // !            //Export Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-export-criteria-fh" data-toggle="modal" title="Export Maintenance Checksheets" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-file-excel"></i></button>';
            // !            break;
            // !        } else {
            // !            //view Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-fh" data-toggle="modal" data-target="#modalViewFHCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';

            // !            //Submit Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-submit-checksheet" data-toggle="modal" data-target="#modalSubmitChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-upload"></i></button>';
            // !            break;
            // !        }
            // !    }

            // !    default: {
            // !        if ($checksheet->status == 0) {
            // !            //view Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-fill-criteria" data-toggle="modal" data-target="#modalViewCriteria" title="Fill-up Maintenance Checksheets" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-edit"></i></button>';

            // !            //Submit Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-submit-checksheet" data-toggle="modal" data-target="#modalSubmitChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-upload"></i></button>';
            // !            break;
            // !        } else if ($checksheet->status == 1) {
            // !            // if ($rapidx_user_id != 704 ) { //Mannix -> Sr Supervisor // CHAN 01-16-25 - old
            // !            //CHAN 01-20-25
            // !            if($checksheet->supervisor_details != ''){
            // !                if ($checksheet->supervisor_details->id == $rapidx_user_id) { // 704 = Mannix, 163 = Earl -> Sr Supervisor// CHAN 01-16-25 - new
            // !                    //view Maintenance Checksheets // OLD
            // !                    // !$result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria" data-toggle="modal" data-target="#modalViewCriteria" title="View Maintenance Checksheets" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !                    // !break; // OLD
            // !                    $result .= ' <button type="button" class="btn btn-sm btn-success btn-approve-checksheet-noted_by_supervisor" data-toggle="modal" data-target="#modalSupervisorApproveChecksheet" title="Approve Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-check-circle"></i></button>';
            // !                }
            // !            }
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria" data-toggle="modal" data-target="#modalViewCriteria" title="View Maintenance Checksheets" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !            break;

            // !        } else if ($checksheet->status == 2) {
            // !            if ($rapidx_user_id != 141) { //Jeff -> Manager
            // !                //view Maintenance Checksheets
            // !                $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria" data-toggle="modal" data-target="#modalViewCriteria" title="View Maintenance Checksheets" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !                break;
            // !            } else {

            // !                //view Maintenance Checksheets
            // !                $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria" data-toggle="modal" data-target="#modalViewCriteria" title="View Maintenance Checksheets" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';

            // !                //A!pprove Maintenance Checksheets
            // !                $result .= ' <button type="button" class="btn btn-sm btn-success btn-approve-checksheet-manager" data-toggle="modal" data-target="#modalManagerApproveChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-check-circle"></i></button>';
            // !                break;
            // !            }
            // !        } else if ($checksheet->status == 3) {
            // !            //view Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria" data-toggle="modal" data-target="#modalViewCriteria" title="View Maintenance Checksheets" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';


            // !            //Export Maintenance Checksheets
            // !            $result .= ' &nbsp;<button type="button" class="btn btn-sm btn-info btn-export-criteria" data-toggle="modal" title="Export Maintenance Checksheets" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-file-excel"></i></button>';
            // !            break;
            // !        } else {
            // !            //view Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-fill-criteria" data-toggle="modal" data-target="#modalViewCriteria" title="Fill-up Maintenance Checksheets" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-edit"></i></button>';

            // !            //Submit Maintenance Checksheets
            // !            $result .= ' <button type="button" class="btn btn-sm btn-info btn-submit-checksheet" data-toggle="modal" data-target="#modalSubmitChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-upload"></i></button>';
            // !            break;
            // !        }
            // !    }
            // !}
            // !$result .= "</center>";
            // !return $result;
            // !})
            ->addColumn('status', function ($checksheet) {

                $result = "";

                switch ($checksheet->status) {
                    case 0: {
                            //view Maintenance Checksheets
                            $result = '<center><span class="badge badge-pill badge-primary">To be Filled Up</span></center>';
                            break;
                        }

                    case 1: {
                            //view Maintenance Checksheets
                            $result = '<center><span class="badge badge-pill badge-warning">For Supervisor Approval</span></center>';
                            break;
                        }

                    case 2: {
                            //view Maintenance Checksheets
                            $result = '<center><span class="badge badge-pill badge-warning">For Manager Approval</span></center>';
                            break;
                        }

                    case 3: {
                            //view Maintenance Checksheets
                            $result = '<center><span class="badge badge-pill badge-success">Approved</span></center>';
                            break;
                        }
                    case 4: {
                            //view Maintenance Checksheets
                            $result = '<center><span class="badge badge-pill badge-danger">Disapproved, to be Edited</span></center>';
                            break;
                        }
                }
                return $result;
            })
            ->addColumn('checksheet_name', function ($checksheet) {

                $result = $checksheet->checksheet_name;

                return $result;
            })
            ->addColumn('date_inspected', function ($checksheet) {

                $result = $checksheet->date_inspected;

                return $result;
            })
            ->addColumn('checked_by', function ($checksheet) {

                $result = '';

                if ($checksheet->checked_by != null) {
                    $result = $checksheet->inspector_details->name;
                } else {
                    $result = '<center><span class="badge badge-pill badge-secondary">N/A</span><center>';
                }
                return $result;
            })
            ->addColumn('noted_by_supervisor', function ($noted_by_supervisor) {
                $result = '';
                if ($noted_by_supervisor->noted_by_supervisor != null) {
                    if ($noted_by_supervisor->supervisor_details != null) {
                        $result .= $noted_by_supervisor->supervisor_details->name;
                        $result .= "<br>". $noted_by_supervisor->s_date;
                    }
                } else {
                    $result .= '<center><span class="badge badge-pill badge-secondary">N/A</span><center>';
                }
                return $result;
            })
            ->addColumn('supervisor_remarks', function ($checksheet) {

                if ($checksheet->s_remarks != null) {
                    $result = $checksheet->s_remarks;
                } else {
                    $result = '<center><span class="badge badge-pill badge-secondary">N/A</span><center>';
                }
                return $result;
            })
            ->addColumn('noted_by_manager', function ($manager) {
                $result = '';
                if ($manager->noted_by_manager != null) {
                    if($manager->manager_details != ''){
                        $result .= $manager->manager_details->name;
                    }
                } else {
                    $result .= '<center><span class="badge badge-pill badge-secondary">N/A</span><center>';
                }
                return $result;
            })
            ->addColumn('manager_remarks', function ($checksheet) {

                if ($checksheet->m_remarks != null) {
                    $result = $checksheet->m_remarks;
                } else {
                    $result = '<center><span class="badge badge-pill badge-secondary">N/A</span><center>';
                }
                return $result;
            })
            ->rawColumns(['checksheet_action', 'status', 'checksheet_name', 'date_inspected', 'checked_by', 'noted_by_supervisor', 'supervisor_remarks', 'noted_by_manager', 'manager_remarks'])
            ->make(true);
    }

    public function view_approved_checksheets_table(Request $request){
        session_start();
        $rapidx_user_id = $_SESSION['rapidx_user_id'];
        $checksheet = Checksheet::with(['inspector_details'])->where('device_id', $request->device_id)->where('status', 3)->where('log_del', 0)->orderBy('checksheet_id', 'DESC')->get();
        // return  $checksheet;
        $noted_by_supervisor = Checksheet::with(['supervisor_details'])->where('device_id', $request->device_id)->get();

        $manager = Checksheet::with(['manager_details'])->where('device_id', $request->device_id)->get();

        return DataTables::of($checksheet)
            ->addColumn('checksheet_action', function ($checksheet) use ($rapidx_user_id) {
                $result = "<center>";
                // CHAN - 01-24-25 - START
                if($checksheet->device_id == 8 || $checksheet->device_id == 18){ // Emergency Light
                    //view Maintenance Checksheets
                    $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-el" data-toggle="modal" data-target="#modalViewELCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';

                    //Export Maintenance Checksheets
                    $result .= ' <button type="button" class="btn btn-sm btn-info btn-export-criteria-el" data-toggle="modal" title="Export Maintenance Checksheets" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-file-excel"></i></button>';
                }else if($checksheet->device_id == 9 || $checksheet->device_id == 19){ // Exit Light
                    //view Maintenance Checksheets
                    $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-exl" data-toggle="modal" data-target="#modalViewEXLCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';

                    //Export Maintenance Checksheets
                    $result .= ' <button type="button" class="btn btn-sm btn-info btn-export-criteria-exl" data-toggle="modal" title="Export Maintenance Checksheets" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-file-excel"></i></button>';
                }else if($checksheet->device_id == 10 || $checksheet->device_id == 20){ // Fire Extinguisher
                    //view Maintenance Checksheets
                    $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-fe" data-toggle="modal" data-target="#modalViewFECriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';

                    //Export Maintenance Checksheets
                    $result .= ' <button type="button" class="btn btn-sm btn-info btn-export-criteria-fe" data-toggle="modal" title="Export Maintenance Checksheets" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-file-excel"></i></button>';
                }else if($checksheet->device_id == 11 || $checksheet->device_id == 21){ // Fire Hose Cabinet
                    //view Maintenance Checksheets
                    $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-fh" data-toggle="modal" data-target="#modalViewFHCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';

                    //Export Maintenance Checksheets
                    $result .= ' <button type="button" class="btn btn-sm btn-info btn-export-criteria-fh" data-toggle="modal" title="Export Maintenance Checksheets" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-file-excel"></i></button>';
                }else{
                    //view Maintenance Checksheets
                    $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria" data-toggle="modal" data-target="#modalViewCriteria" title="View Maintenance Checksheets" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';

                    //Export Maintenance Checksheets
                    $result .= ' &nbsp;<button type="button" class="btn btn-sm btn-info btn-export-criteria" data-toggle="modal" title="Export Maintenance Checksheets" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-file-excel"></i></button>';
                }
                return $result;
                // CHAN - 01-24-25 - END
            })

            // ! =================================================================================================================================================
            // ! ============================================= OLD CODE ==========================================================================================
            // ! =================================================================================================================================================
            // ! switch ($checksheet->device_id) {
            // !     case 8: {
            // !             if ($checksheet->status == 0) {
            // !                 //view Maintenance Checksheets
            // !                 $result .= ' <button type="button" class="btn btn-sm btn-info btn-fill-criteria-el" data-toggle="modal" data-target="#modalViewELCriteria" title="Fill-up Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-edit"></i></button>';

            // !                 //Submit Maintenance Checksheets
            // !                 //$result .= ' <button type="button" class="btn btn-sm btn-info btn-submit-checksheet" data-toggle="modal" data-target="#modalSubmitChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-upload"></i></button>';
            // !                 break;
            // !             } else if ($checksheet->status == 1) {
            // !                 if ($rapidx_user_id != 704 ) { //Mannix -> Sr Supervisor
            // !                         //view Maintenance Checksheets
            // !                     $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-el" data-toggle="modal" data-target="#modalViewELCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !                     break;
            // !                 } else {
            // !                     //view Maintenance Checksheets
            // !                     $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-el" data-toggle="modal" data-target="#modalViewELCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';

            // !                     //Approve Maintenance Checksheet
            // !                     //$result .= ' <button type="button" class="btn btn-sm btn-success btn-approve-checksheet-noted_by_supervisor" data-toggle="modal" data-target="#modalSupervisorApproveChecksheet" title="Approve Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-check-circle"></i></button>';
            // !                     break;
            // !                 }
            // !             } else if ($checksheet->status == 2) {
            // !                 if ($rapidx_user_id != 141) { //Jeff -> Manager
            // !                     //view Maintenance Checksheets
            // !                     $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-el" data-toggle="modal" data-target="#modalViewELCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !                     break;
            // !                 } else {
            // !                     //view Maintenance Checksheets
            // !                     $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-el" data-toggle="modal" data-target="#modalViewELCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';

            // !                     //Approve Maintenance Checksheets
            // !                     //$result .= ' <button type="button" class="btn btn-sm btn-success btn-approve-checksheet-manager" data-toggle="modal" data-target="#modalManagerApproveChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-check-circle"></i></button>';
            // !                     break;
            // !                 }
            // !             } else if ($checksheet->status == 3) {
            // !                 //view Maintenance Checksheets
            // !                 $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-el" data-toggle="modal" data-target="#modalViewELCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !                 //Export Maintenance Checksheets
            // !                 $result .= ' <button type="button" class="btn btn-sm btn-info btn-export-criteria-el" data-toggle="modal" title="Export Maintenance Checksheets" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-file-excel"></i></button>';
            // !                 break;
            // !             } else {
            // !                 //view Maintenance Checksheets
            // !                 $result .= ' <button type="button" class="btn btn-sm btn-info btn-fill-criteria-el" data-toggle="modal" data-target="#modalViewELCriteria" title="Fill-up Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-edit"></i></button>';

            // !                 //Submit Maintenance Checksheets
            // !                 //$result .= ' <button type="button" class="btn btn-sm btn-info btn-submit-checksheet" data-toggle="modal" data-target="#modalSubmitChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-upload"></i></button>';
            // !                 break;
            // !             }
            // !         }

            // !     case 9: {
            // !             if ($checksheet->status == 0) {
            // !                 //view Maintenance Checksheets
            // !                 $result .= ' <button type="button" class="btn btn-sm btn-info btn-fill-criteria-exl" data-toggle="modal" data-target="#modalViewEXLCriteria" title="Fill-up Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-edit"></i></button>';

            // !                 //Submit Maintenance Checksheets
            // !                 //$result .= ' <button type="button" class="btn btn-sm btn-info btn-submit-checksheet" data-toggle="modal" data-target="#modalSubmitChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-upload"></i></button>';
            // !                 break;
            // !             } else if ($checksheet->status == 1) {
            // !                 if ($rapidx_user_id != 704 ) { //Mannix -> Sr Supervisor
            // !                         //view Maintenance Checksheets
            // !                     $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-exl" data-toggle="modal" data-target="#modalViewEXLCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !                     break;
            // !                 } else {
            // !                     //view Maintenance Checksheets
            // !                     $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-exl" data-toggle="modal" data-target="#modalViewEXLCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';

            // !                     //Approve Maintenance Checksheet
            // !                     //$result .= ' <button type="button" class="btn btn-sm btn-success btn-approve-checksheet-noted_by_supervisor" data-toggle="modal" data-target="#modalSupervisorApproveChecksheet" title="Approve Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-check-circle"></i></button>';
            // !                     break;
            // !                 }
            // !                 break;
            // !             } else if ($checksheet->status == 2) {
            // !                 if ($rapidx_user_id != 141) { //Jeff -> Manager
            // !                     //view Maintenance Checksheets
            // !                     $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-exl" data-toggle="modal" data-target="#modalViewEXLCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !                     break;
            // !                 } else {
            // !                     //view Maintenance Checksheets
            // !                     $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-exl" data-toggle="modal" data-target="#modalViewEXLCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';

            // !                     //Approve Maintenance Checksheets
            // !                     //$result .= ' <button type="button" class="btn btn-sm btn-success btn-approve-checksheet-manager" data-toggle="modal" data-target="#modalManagerApproveChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-check-circle"></i></button>';
            // !                     break;
            // !                 }
            // !             } else if ($checksheet->status == 3) {
            // !                 //view Maintenance Checksheets
            // !                 $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-exl" data-toggle="modal" data-target="#modalViewEXLCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';

            // !                 //Export Maintenance Checksheets
            // !                 $result .= ' <button type="button" class="btn btn-sm btn-info btn-export-criteria-exl" data-toggle="modal" title="Export Maintenance Checksheets" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-file-excel"></i></button>';
            // !                 break;
            // !             } else {
            // !                 //view Maintenance Checksheets
            // !                 $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-exl" data-toggle="modal" data-target="#modalViewEXLCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';

            // !                 //Submit Maintenance Checksheets
            // !                 //$result .= ' <button type="button" class="btn btn-sm btn-info btn-submit-checksheet" data-toggle="modal" data-target="#modalSubmitChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-upload"></i></button>';
            // !                 break;
            // !             }
            // !         }

            // !     case 10: {
            // !             if ($checksheet->status == 0) {
            // !                 //view Maintenance Checksheets
            // !                 $result .= ' <button type="button" class="btn btn-sm btn-info btn-fill-criteria-fe" data-toggle="modal" data-target="#modalViewFECriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-edit"></i></button>';

            // !                 //Submit Maintenance Checksheets
            // !                 //$result .= ' <button type="button" class="btn btn-sm btn-info btn-submit-checksheet" data-toggle="modal" data-target="#modalSubmitChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-upload"></i></button>';
            // !                 break;
            // !             } else if ($checksheet->status == 1) {
            // !                 if ($rapidx_user_id != 704 ) { //Mannix -> Sr Supervisor
            // !                         //view Maintenance Checksheets
            // !                     $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-fe" data-toggle="modal" data-target="#modalViewFECriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !                     break;
            // !                 } else {
            // !                     //view Maintenance Checksheets
            // !                     $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-fe" data-toggle="modal" data-target="#modalViewFECriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';

            // !                     //Approve Maintenance Checksheet
            // !                     //$result .= ' <button type="button" class="btn btn-sm btn-success btn-approve-checksheet-noted_by_supervisor" data-toggle="modal" data-target="#modalSupervisorApproveChecksheet" title="Approve Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-check-circle"></i></button>';
            // !                     break;
            // !                 }
            // !             } else if ($checksheet->status == 2) {
            // !                 if ($rapidx_user_id != 141) { //Jeff -> Manager
            // !                     //view Maintenance Checksheets
            // !                     $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-fe" data-toggle="modal" data-target="#modalViewFECriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !                     break;
            // !                 } else {
            // !                     //view Maintenance Checksheets
            // !                     $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-fe" data-toggle="modal" data-target="#modalViewFECriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';

            // !                     //Approve Maintenance Checksheets
            // !                     //$result .= ' <button type="button" class="btn btn-sm btn-success btn-approve-checksheet-manager" data-toggle="modal" data-target="#modalManagerApproveChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-check-circle"></i></button>';
            // !                     break;
            // !                 }
            // !             } else if ($checksheet->status == 3) {
            // !                 //view Maintenance Checksheets
            // !                 $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-fe" data-toggle="modal" data-target="#modalViewFECriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';

            // !                 //Export Maintenance Checksheets
            // !                 $result .= ' <button type="button" class="btn btn-sm btn-info btn-export-criteria-fe" data-toggle="modal" title="Export Maintenance Checksheets" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-file-excel"></i></button>';
            // !                 break;
            // !             } else {
            // !                 //view Maintenance Checksheets
            // !                 $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-fe" data-toggle="modal" data-target="#modalViewFECriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';

            // !                 //Submit Maintenance Checksheets
            // !                 //$result .= ' <button type="button" class="btn btn-sm btn-info btn-submit-checksheet" data-toggle="modal" data-target="#modalSubmitChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-upload"></i></button>';

            // !                 break;
            // !             }
            // !         }

            // !     case 11: {
            // !             if ($checksheet->status == 0) {
            // !                 //view Maintenance Checksheets
            // !                 $result .= ' <button type="button" class="btn btn-sm btn-info btn-fill-criteria-fh" data-toggle="modal" data-target="#modalViewFHCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-edit"></i></button>';

            // !                 //Submit Maintenance Checksheets
            // !                 //$result .= ' <button type="button" class="btn btn-sm btn-info btn-submit-checksheet" data-toggle="modal" data-target="#modalSubmitChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-upload"></i></button>';
            // !                 break;
            // !             } else if ($checksheet->status == 1) {
            // !                 if ($rapidx_user_id != 704 ) { //Mannix -> Sr Supervisor
            // !                         //view Maintenance Checksheets
            // !                     $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-fh" data-toggle="modal" data-target="#modalViewFHCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !                     break;
            // !                 } else {
            // !                     //view Maintenance Checksheets
            // !                     $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-fh" data-toggle="modal" data-target="#modalViewFHCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';

            // !                     //Approve Maintenance Checksheet
            // !                     //$result .= ' <button type="button" class="btn btn-sm btn-success btn-approve-checksheet-noted_by_supervisor" data-toggle="modal" data-target="#modalSupervisorApproveChecksheet" title="Approve Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-check-circle"></i></button>';
            // !                     break;
            // !                 }
            // !             } else if ($checksheet->status == 2) {
            // !                 if ($rapidx_user_id != 141) { //Jeff -> Manager
            // !                     //view Maintenance Checksheets
            // !                     $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-fh" data-toggle="modal" data-target="#modalViewFHCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !                     break;
            // !                 } else {
            // !                     //view Maintenance Checksheets
            // !                     $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-fh" data-toggle="modal" data-target="#modalViewFHCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';

            // !                     //Approve Maintenance Checksheets
            // !                     //$result .= ' <button type="button" class="btn btn-sm btn-success btn-approve-checksheet-manager" data-toggle="modal" data-target="#modalManagerApproveChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-check-circle"></i></button>';
            // !                     break;
            // !                 }
            // !             } else if ($checksheet->status == 3) {
            // !                 //view Maintenance Checksheets
            // !                 $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-fh" data-toggle="modal" data-target="#modalViewFHCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';

            // !                 //Export Maintenance Checksheets
            // !                 $result .= ' <button type="button" class="btn btn-sm btn-info btn-export-criteria-fh" data-toggle="modal" title="Export Maintenance Checksheets" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-file-excel"></i></button>';
            // !                 break;
            // !             } else {
            // !                 //view Maintenance Checksheets
            // !                 $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria-fh" data-toggle="modal" data-target="#modalViewFHCriteria" title="View Facility Equipment" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';

            // !                 //Submit Maintenance Checksheets
            // !                 //$result .= ' <button type="button" class="btn btn-sm btn-info btn-submit-checksheet" data-toggle="modal" data-target="#modalSubmitChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-upload"></i></button>';
            // !                 break;
            // !             }
            // !         }
            // !     default: {
            // !             if ($checksheet->status == 0) {
            // !                 //view Maintenance Checksheets
            // !                 $result .= ' <button type="button" class="btn btn-sm btn-info btn-fill-criteria" data-toggle="modal" data-target="#modalViewCriteria" title="Fill-up Maintenance Checksheets" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-edit"></i></button>';

            // !                 //Submit Maintenance Checksheets
            // !                 //$result .= ' <button type="button" class="btn btn-sm btn-info btn-submit-checksheet" data-toggle="modal" data-target="#modalSubmitChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-upload"></i></button>';
            // !                 break;
            // !             } else if ($checksheet->status == 1) {
            // !                 if ($rapidx_user_id != 704 ) { //Mannix -> Sr Supervisor
            // !                         //view Maintenance Checksheets
            // !                     $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria" data-toggle="modal" data-target="#modalViewCriteria" title="View Maintenance Checksheets" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !                     break;
            // !                 } else {
            // !                     //view Maintenance Checksheets
            // !                     $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria" data-toggle="modal" data-target="#modalViewCriteria" title="View Maintenance Checksheets" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';

            // !                     //Approve Maintenance Checksheet
            // !                     //$result .= ' <button type="button" class="btn btn-sm btn-success btn-approve-checksheet-noted_by_supervisor" data-toggle="modal" data-target="#modalSupervisorApproveChecksheet" title="Approve Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-check-circle"></i></button>';
            // !                     break;
            // !                 }
            // !             } else if ($checksheet->status == 2) {
            // !                 if ($rapidx_user_id != 141) { //Jeff -> Manager
            // !                     //view Maintenance Checksheets
            // !                     $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria" data-toggle="modal" data-target="#modalViewCriteria" title="View Maintenance Checksheets" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';
            // !                     break;
            // !                 } else {

            // !                     //view Maintenance Checksheets
            // !                     $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria" data-toggle="modal" data-target="#modalViewCriteria" title="View Maintenance Checksheets" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';

            // !                     //Approve Maintenance Checksheets
            // !                     //$result .= ' <button type="button" class="btn btn-sm btn-success btn-approve-checksheet-manager" data-toggle="modal" data-target="#modalManagerApproveChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-check-circle"></i></button>';
            // !                     break;
            // !                 }
            // !             } else if ($checksheet->status == 3) {
            // !                 //view Maintenance Checksheets
            // !                 $result .= ' <button type="button" class="btn btn-sm btn-info btn-view-criteria" data-toggle="modal" data-target="#modalViewCriteria" title="View Maintenance Checksheets" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-eye"></i></button>';


            // !                 //Export Maintenance Checksheets
            // !                 $result .= ' &nbsp;<button type="button" class="btn btn-sm btn-info btn-export-criteria" data-toggle="modal" title="Export Maintenance Checksheets" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-file-excel"></i></button>';
            // !                 break;
            // !             } else {
            // !                 //view Maintenance Checksheets
            // !                 $result .= ' <button type="button" class="btn btn-sm btn-info btn-fill-criteria" data-toggle="modal" data-target="#modalViewCriteria" title="Fill-up Maintenance Checksheets" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-edit"></i></button>';

            // !                 //Submit Maintenance Checksheets
            // !                 //$result .= ' <button type="button" class="btn btn-sm btn-info btn-submit-checksheet" data-toggle="modal" data-target="#modalSubmitChecksheet" title="Submit Maintenance Checksheet" checksheet-id="' . $checksheet->checksheet_id . '"><i class="fa fa-upload"></i></button>';
            // !                 break;
            // !             }
            // !         }
            // ! }
            // ! return $result;
            // !})
            ->addColumn('status', function ($checksheet) {

                $result = "";

                switch ($checksheet->status) {
                    // case 0: {
                    //         //view Maintenance Checksheets
                    //         $result = '<center><span class="badge badge-pill badge-primary">To be Filled Up</span></center>';
                    //         break;
                    //     }

                    // case 1: {
                    //         //view Maintenance Checksheets
                    //         $result = '<center><span class="badge badge-pill badge-warning">For Supervisor Approval</span></center>';
                    //         break;
                    //     }

                    // case 2: {
                    //         //view Maintenance Checksheets
                    //         $result = '<center><span class="badge badge-pill badge-warning">For Manager Approval</span></center>';
                    //         break;
                    //     }

                    case 3: {
                            //view Maintenance Checksheets
                            $result = '<center><span class="badge badge-pill badge-success">Approved</span></center>';
                            break;
                        }
                    // case 4: {
                    //         //view Maintenance Checksheets
                    //         $result = '<center><span class="badge badge-pill badge-danger">Disapproved, to be Edited</span></center>';
                    //         break;
                    //     }
                }
                return $result;
            })
            ->addColumn('checksheet_name', function ($checksheet) {

                $result = $checksheet->checksheet_name;

                return $result;
            })
            ->addColumn('date_inspected', function ($checksheet) {

                $result = $checksheet->date_inspected;

                return $result;
            })
            ->addColumn('checked_by', function ($checksheet) {

                $result = '';

                if ($checksheet->checked_by != null) {
                    $result = $checksheet->inspector_details->name;
                } else {
                    $result = '<center><span class="badge badge-pill badge-secondary">N/A</span><center>';
                }
                return $result;
            })
            ->addColumn('noted_by_supervisor', function ($noted_by_supervisor) {
                if ($noted_by_supervisor->noted_by_supervisor != null) {
                    $result = $noted_by_supervisor->supervisor_details->name;
                    $result .= "<br>" . $noted_by_supervisor->s_date;
                } else {
                    $result = '<center><span class="badge badge-pill badge-secondary">N/A</span><center>';
                }
                return $result;
            })
            ->addColumn('supervisor_remarks', function ($checksheet) {

                if ($checksheet->s_remarks != null) {
                    $result = $checksheet->s_remarks;
                } else {
                    $result = '<center><span class="badge badge-pill badge-secondary">N/A</span><center>';
                }
                return $result;
            })
            ->addColumn('noted_by_manager', function ($manager) {

                if ($manager->noted_by_manager != null) {
                    $result = $manager->manager_details->name;
                    $result .= "<br>" . $manager->m_date;
                } else {
                    $result = '<center><span class="badge badge-pill badge-secondary">N/A</span><center>';
                }
                return $result;
            })
            ->addColumn('manager_remarks', function ($checksheet) {

                if ($checksheet->m_remarks != null) {
                    $result = $checksheet->m_remarks;
                } else {
                    $result = '<center><span class="badge badge-pill badge-secondary">N/A</span><center>';
                }
                return $result;
            })
            ->rawColumns(['checksheet_action', 'status', 'checksheet_name', 'date_inspected', 'checked_by', 'noted_by_supervisor', 'supervisor_remarks', 'noted_by_manager', 'manager_remarks'])
            ->make(true);
    }

    // Adding of Checksheet
    public function add_checksheet(Request $request)
    {

        date_default_timezone_set('Asia/Manila');
        session_start();

        $rapidx_user_id = $_SESSION['rapidx_user_id'];

        $data = $request->all();

        $validator = Validator::make($data, [
            'device' => ['required', 'string', 'max:255'],
            'equipment_model' => ['required', 'string', 'max:255'],
            'date_inspected' => ['required', 'string', 'max:255'],
        ]);

        // CHAN 01-16-25
        // if($request->factory_view_checksheets == 1){
        //     $noted_by_supervisor = '704'; // Mannix
        // }else{
        //     $noted_by_supervisor = '163'; // Earl
        // }

        if ($validator->fails()) {
            return response()->json(['result' => '0', 'error' => $validator->messages()]);
        } else {
            DB::beginTransaction();

            try {
                Checksheet::insert([
                    'checksheet_name' => $request->device . " " . "-" . " " . $request->equipment_model,
                    'date_inspected' => $request->date_inspected,
                    'device_id' => $request->device_id,
                    'status' => 0,
                    'created_by' => $rapidx_user_id,
                    'checked_by' => $rapidx_user_id, // inspected by
                    // 'noted_by_supervisor' => 704, // Mannix // CHAN 01-16-25 - old
                    // 'noted_by_supervisor' => $noted_by_supervisor, // CHAN 01-16-25 - new
                    // 'noted_by_manager' => 141, // Jeff
                    'factory' => $request->factory_view_checksheets, // CHAN 01-16-25
                    'last_updated_by' => $rapidx_user_id,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                DB::commit();

                return response()->json(['result' => "1"]);
            } catch (\Exception $e) {
                DB::rollback();
                // throw $e;
                return response()->json(['result' => "0"]);
            }
        }
    }

    // Get Device By Id
    public function get_device_by_id(Request $request)
    {
        $device = Device::where('device_id', $request->device_id)->get();

        if (count($device) > 0) {
            return response()->json(['result' => 1, 'device' => $device]);
        } else {
            return response()->json(['result' => 2]);
        }
    }

    public function export_checksheet(Request $request)
    {
        $checksheetid = $request->checksheet_id;

        $checksheet = Checksheet::with(['criteria_details'])->where('checksheet_id', $checksheetid)->get();

        $checksheet_inspector = Checksheet::with(['inspector_details'])->where('checksheet_id', $checksheetid)->get();

        $checksheet_supervisor = Checksheet::with(['supervisor_details'])->where('checksheet_id', $checksheetid)->get();

        $checksheet_manager = Checksheet::with(['manager_details'])->where('checksheet_id', $checksheetid)->get();

        // return $checksheet;
        $filename = str_replace(['/', '\\'], '-', $checksheet[0]->checksheet_name);
        return Excel::download(new ChecksheetExport($checksheet, $checksheet_inspector, $checksheet_supervisor, $checksheet_manager), 'PMCSFES (' . $filename . ').xlsx');
    }

    public function export_checksheet_el(Request $request)
    {
        $checksheetid = $request->checksheet_id;

        $checksheet = Checksheet::with(['criteria_details_el'])->where('checksheet_id', $checksheetid)->get();

        $checksheet_inspector = Checksheet::with(['inspector_details'])->where('checksheet_id', $checksheetid)->get();

        $checksheet_supervisor = Checksheet::with(['supervisor_details'])->where('checksheet_id', $checksheetid)->get();

        $checksheet_manager = Checksheet::with(['manager_details'])->where('checksheet_id', $checksheetid)->get();

        // return $checksheet;
        $filename = str_replace(['/', '\\'], '-', $checksheet[0]->checksheet_name);
        return Excel::download(new ChecksheetExportEL($checksheet, $checksheet_inspector, $checksheet_supervisor, $checksheet_manager), 'PMCSFES (' . $filename . ').xlsx');
    }

    public function export_checksheet_exl(Request $request)
    {
        $checksheetid = $request->checksheet_id;

        $checksheet = Checksheet::with(['criteria_details_exl'])->where('checksheet_id', $checksheetid)->get();

        $checksheet_inspector = Checksheet::with(['inspector_details'])->where('checksheet_id', $checksheetid)->get();

        $checksheet_supervisor = Checksheet::with(['supervisor_details'])->where('checksheet_id', $checksheetid)->get();

        $checksheet_manager = Checksheet::with(['manager_details'])->where('checksheet_id', $checksheetid)->get();

        // return $checksheet;
        $filename = str_replace(['/', '\\'], '-', $checksheet[0]->checksheet_name);
        return Excel::download(new ChecksheetExportEXL($checksheet, $checksheet_inspector, $checksheet_supervisor, $checksheet_manager), 'PMCSFES (' . $filename . ').xlsx');
    }

    public function export_checksheet_fe(Request $request)
    {
        $checksheetid = $request->checksheet_id;

        $checksheet = Checksheet::with(['criteria_details_fe'])->where('checksheet_id', $checksheetid)->get();

        $checksheet_inspector = Checksheet::with(['inspector_details'])->where('checksheet_id', $checksheetid)->get();

        $checksheet_supervisor = Checksheet::with(['supervisor_details'])->where('checksheet_id', $checksheetid)->get();

        $checksheet_manager = Checksheet::with(['manager_details'])->where('checksheet_id', $checksheetid)->get();

        // return $checksheet;
        $filename = str_replace(['/', '\\'], '-', $checksheet[0]->checksheet_name);
        return Excel::download(new ChecksheetExportFE($checksheet, $checksheet_inspector, $checksheet_supervisor, $checksheet_manager), 'PMCSFES (' . $filename . ').xlsx');
    }

    public function export_checksheet_fh(Request $request)
    {
        $checksheetid = $request->checksheet_id;

        $checksheet = Checksheet::with(['criteria_details_fh'])->where('checksheet_id', $checksheetid)->get();

        $checksheet_inspector = Checksheet::with(['inspector_details'])->where('checksheet_id', $checksheetid)->get();

        $checksheet_supervisor = Checksheet::with(['supervisor_details'])->where('checksheet_id', $checksheetid)->get();

        $checksheet_manager = Checksheet::with(['manager_details'])->where('checksheet_id', $checksheetid)->get();

        // return $checksheet;
        $filename = str_replace(['/', '\\'], '-', $checksheet[0]->checksheet_name);
        return Excel::download(new ChecksheetExportFH($checksheet, $checksheet_inspector, $checksheet_supervisor, $checksheet_manager), 'PMCSFES (' . $filename . ').xlsx');
    }
}
