<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;
use Carbon\Carbon;
use DataTables;
use Auth;
use Mail;

use App\Model\RapidXUser;
use App\Model\Device;
use App\Model\Checksheet;
use App\Model\Criteria;
use App\Model\EmergencyLightCriteria;
use App\Model\ExitLightCriteria;
use App\Model\FireExtinguisherCriteria;
use App\Model\FireHoseCriteria;

class CriteriaController extends Controller
{

    // Criteria Datatable

    public function view_criteria_table(Request $request)
    {
        session_start();
        $rapidx_user_id = $_SESSION['rapidx_user_id'];
        $criteria = Criteria::with(['checksheet_general_area_info'])->where('checksheet_id', $request->checksheet_id)->where('log_del', 0)->orderBy('created_at', 'ASC');
        // return $criteria;
        return DataTables::of($criteria)
            ->addColumn('checklist', function ($criteria) {
                $result = $criteria->checklist;
                return $result;
            })

            ->addColumn('requirement', function ($criteria) {
                $result = $criteria->requirement;
                return $result;
            })

            ->addColumn('general_area', function ($criteria) {
                if($criteria->checksheet_general_area_info != null){
                    $result = $criteria->checksheet_general_area_info->general_area;
                }else{
                    $result = '';
                }
                return $result;
            })

            ->addColumn('status_good', function ($criteria) {
                $result = '';
                if ($criteria->status != 1) {
                    $result = " ";
                } else {
                    $result = "<i class='fa fa-check'></i>";
                }
                return $result;
            })

            ->addColumn('status_no_good', function ($criteria) {
                $result = '';
                if ($criteria->status != 0) {
                    $result = " ";
                } else {
                    $result = "<i class='fa fa-times'></i>";
                }
                return $result;
            })

            ->addColumn('remarks', function ($criteria) {
                $result = $criteria->remarks;
                return $result;
            })

            ->rawColumns(['checklist', 'requirement', 'general_area', 'status_good', 'status_no_good', 'remarks'])
            ->make(true);
    }

    // Adding of Maintenance Result or Findings
    public function add_maintenance_result(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();
        $rapidx_user_id = $_SESSION['rapidx_user_id'];
        $data = $request->all();
        $checklist_criteria =
            Criteria::where('checksheet_id', $request->checksheet_id)
                        ->where('checklist', $request->checklist)
                        ->where('requirement', $request->requirement)
                        ->where('general_area', $request->equipment_general_area)
                        ->where('control_no', $request->equipment_general_area_control_no)
                        ->where('location', $request->equipment_general_area_location)
                        ->where('classification', $request->equipment_get_classification)
                        ->get();

        $validator = Validator::make($data, [
            'equipment_template'    => ['required', 'string', 'max:255'],
            'checklist'             => ['required', 'string', 'max:255'],
            'requirement'           => ['required', 'string', 'max:255'],
            'remarks'               => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json(['result' => '0', 'error' => $validator->messages()]);
        } else {
            DB::beginTransaction();
            try {
                if (count($checklist_criteria) == 0) {
                    Criteria::insert([
                        'checklist'         => $request->checklist,
                        'requirement'       => $request->requirement,
                        'status'            => $request->status,
                        'remarks'           => $request->remarks,
                        'checksheet_id'     => $request->checksheet_id,
                        'general_area'      => $request->equipment_general_area,
                        'control_no'        => $request->equipment_general_area_control_no,
                        'location'          => $request->equipment_general_area_location,
                        'classification'    => $request->equipment_classification,
                        'factory'           => $request->factory_view_criteria,
                        'created_by'        => $rapidx_user_id,
                        'last_updated_by'   => $rapidx_user_id,
                        'updated_at'        => date('Y-m-d H:i:s'),
                        'created_at'        => date('Y-m-d H:i:s')
                    ]);

                    // CHAN 01-23-2025
                    Checksheet::where('checksheet_id',  $request->checksheet_id)->update([
                        'checking' => '1',
                    ]);

                    // // additional 12-13-2021
                    // Checksheet::where('checksheet_id',  $request->checksheet_id)->update([
                    //     'noted_by_manager' => 31,
                    //     'noted_by_supervisor' => $rapidx_user_id, // inspected by
                    //     'last_updated_by' => $rapidx_user_id,
                    //     'updated_at' => date('Y-m-d H:i:s'),
                    // ]);
                    // // additional end
                } else {
                    Criteria::where('criteria_id', $checklist_criteria[0]->criteria_id)->update([
                        'checklist'         => $request->checklist,
                        'requirement'       => $request->requirement,
                        'status'            => $request->status,
                        'remarks'           => $request->remarks,
                        'checksheet_id'     => $request->checksheet_id,
                        'created_by'        => $rapidx_user_id,
                        'last_updated_by'   => $rapidx_user_id,
                        'updated_at'        => date('Y-m-d H:i:s'),
                        'created_at'        => date('Y-m-d H:i:s')
                    ]);

                    // // additional 12-13-2021
                    // Checksheet::where('checksheet_id',  $request->checksheet_id)->update([
                    //     'noted_by_manager' => 31,
                    //     'noted_by_supervisor' => $rapidx_user_id, // inspected by
                    //     'last_updated_by' => $rapidx_user_id,
                    //     'updated_at' => date('Y-m-d H:i:s'),
                    // ]);
                    // // additional end
                }
                DB::commit();

                return response()->json(['result' => "1"]);
            } catch (\Exception $e) {
                DB::rollback();
                // throw $e;
                return response()->json(['result' => "0"]);
            }
        }
    }

    // Get Checksheet By Id
    public function get_checksheet_by_id(Request $request)
    {
        $checksheet = Checksheet::where('checksheet_id', $request->checksheet_id)->get();
        if (count($checksheet) > 0) {
            return response()->json(['result' => 1, 'checksheet' => $checksheet]);
        } else {
            return response()->json(['result' => 2]);
        }
    }

    // Datatable for the findings of Emergency Light

    public function view_criteria_table_el(Request $request)
    {
        session_start();
        $rapidx_user_id = $_SESSION['rapidx_user_id'];
        $criteria_el = EmergencyLightCriteria::where('checksheet_id', $request->checksheet_id)->orderBy('created_at', 'ASC');

        return DataTables::of($criteria_el)
            ->addColumn('control_number', function ($criteria_el) {
                $result = $criteria_el->control_number;
                return $result;
            })

            ->addColumn('location', function ($criteria_el) {
                $result = $criteria_el->location;
                return $result;
            })

            ->addColumn('lights_l', function ($criteria_el) {
                $result = '';
                if ($criteria_el->lights_l != 0) {
                    $result = "<i class='fa fa-check'></i>";
                } else {
                    $result = "<i class='fa fa-times'></i>";
                }
                return $result;
            })

            ->addColumn('lights_r', function ($criteria_el) {
                $result = '';
                if ($criteria_el->lights_r != 0) {
                    $result = "<i class='fa fa-check'></i>";
                } else {
                    $result = "<i class='fa fa-times'></i>";
                }
                return $result;
            })

            ->addColumn('battery', function ($criteria_el) {
                $result = '';
                if ($criteria_el->battery != 0) {
                    $result = "<i class='fa fa-check'></i>";
                } else {
                    $result = "<i class='fa fa-times'></i>";
                }
                return $result;
            })

            ->addColumn('draining_of_rechargeable_battery', function ($criteria_el) {
                $result = '';
                if ($criteria_el->draining_of_rechargeable_battery != 0) {
                    $result = "<span class='badge badge-pill badge-success'>Done</span>";
                } else {
                    $result = "<span class='badge badge-pill badge-danger'>< 5 No Good</span>";
                }
                return $result;
            })

            ->addColumn('inspection_card', function ($criteria_el) {
                $result = '';
                if ($criteria_el->inspection_card != 0) {
                    $result = "<span class='badge badge-pill badge-success'>Updated</span>";
                } else {
                    $result = "<span class='badge badge-pill badge-danger'>Not Updated</span>";
                }
                return $result;
            })

            ->addColumn('remarks', function ($criteria_el) {
                $result = $criteria_el->remarks;
                return $result;
            })

            ->rawColumns(['control_number', 'location', 'lights_l', 'lights_r', 'battery', 'draining_of_rechargeable_battery', 'inspection_card', 'remarks'])
            ->make(true);
    }

    // Adding of findings for Emergency Light Checklist
    public function add_checksheet_findings_el(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();
        $rapidx_user_id = $_SESSION['rapidx_user_id'];
        $data = $request->all();
        $validator = Validator::make($data, [
            'general_area_el'   => ['required', 'string', 'max:255'],
            'control_number_el' => ['required', 'string', 'max:255'],
            'location_el'       => ['required', 'string', 'max:255'],
            'remarks_el'        => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json(['result' => '0', 'error' => $validator->messages()]);
        } else {
            DB::beginTransaction();
            try {
                EmergencyLightCriteria::insert([
                    'control_number'                    => $request->control_number_el,
                    'location'                          => $request->location_el,
                    'lights_l'                          => $request->lightslstatus,
                    'lights_r'                          => $request->lightsrstatus,
                    'battery'                           => $request->batterystatus,
                    'draining_of_rechargeable_battery'  => $request->drainingbatterystatus,
                    'inspection_card'                   => $request->inspcardstatus,
                    'remarks'                           => $request->remarks_el,
                    'checksheet_id'                     => $request->checksheet_id_el,
                    'factory'                           => $request->factory_view_el_criteria,
                    'created_by'                        => $rapidx_user_id,
                    'last_updated_by'                   => $rapidx_user_id,
                    'updated_at'                        => date('Y-m-d H:i:s'),
                    'created_at'                        => date('Y-m-d H:i:s')
                ]);

                // CHAN 01-23-2025
                Checksheet::where('checksheet_id',  $request->checksheet_id_el)->update([
                    'checking' => '1',
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

    // Datatable of Findings for Exit Light

    public function view_criteria_table_exl(Request $request)
    {
        session_start();
        $rapidx_user_id = $_SESSION['rapidx_user_id'];
        $criteria_exl = ExitLightCriteria::where('checksheet_id', $request->checksheet_id)->orderBy('created_at', 'ASC');

        return DataTables::of($criteria_exl)
            ->addColumn('location', function ($criteria_exl) {
                $result = $criteria_exl->location;
                return $result;
            })

            ->addColumn('light_status', function ($criteria_exl) {
                $result = '';
                if ($criteria_exl->light_status != 0) {
                    $result = "<i class='fa fa-check'></i>";
                } else {
                    $result = "<i class='fa fa-times'></i>";
                }
                return $result;
            })

            ->addColumn('battery_status', function ($criteria_exl) {
                $result = '';
                if ($criteria_exl->battery_status != 0) {
                    $result = "<i class='fa fa-check'></i>";
                } else {
                    $result = "<i class='fa fa-times'></i>";
                }
                return $result;
            })

            ->addColumn('remarks', function ($criteria_exl) {
                $result = $criteria_exl->remarks;
                return $result;
            })

            ->rawColumns(['location', 'light_status', 'battery_status', 'remarks'])
            ->make(true);
    }

    // Adding of Maintenance Result
    public function add_checksheet_findings_exl(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();
        $rapidx_user_id = $_SESSION['rapidx_user_id'];
        $data = $request->all();
        $validator = Validator::make($data, [
            'general_area_exl'  => ['required', 'string', 'max:255'],
            'location_exl'      => ['required', 'string', 'max:255'],
            'remarks_exl'       => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json(['result' => '0', 'error' => $validator->messages()]);
        } else {
            DB::beginTransaction();

            try {
                ExitLightCriteria::insert([
                    'location'          => $request->location_exl,
                    'light_status'      => $request->lightstatusexl,
                    'battery_status'    => $request->batterystatusexl,
                    'remarks'           => $request->remarks_exl,
                    'checksheet_id'     => $request->checksheet_id_exl,
                    'factory'           => $request->factory_view_exl_criteria,
                    'created_by'        => $rapidx_user_id,
                    'last_updated_by'   => $rapidx_user_id,
                    'updated_at'        => date('Y-m-d H:i:s'),
                    'created_at'        => date('Y-m-d H:i:s')
                ]);

                // CHAN 01-23-2025
                Checksheet::where('checksheet_id',  $request->checksheet_id_exl)->update([
                    'checking' => '1',
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

    // Datatables of Findings Fire Extinguisher
    public function view_criteria_table_fe(Request $request)
    {
        session_start();
        $rapidx_user_id = $_SESSION['rapidx_user_id'];
        $criteria_fe = FireExtinguisherCriteria::where('checksheet_id', $request->checksheet_id)->where('log_del', 0)->orderBy('created_at', 'ASC');

        return DataTables::of($criteria_fe)
            ->addColumn('control_number', function ($criteria_fe) {
                $result = $criteria_fe->control_number;
                return $result;
            })

            ->addColumn('classification', function ($criteria_fe) {
                $result = $criteria_fe->classification;
                return $result;
            })

            ->addColumn('location', function ($criteria_fe) {
                $result = $criteria_fe->location;
                return $result;
            })

            ->addColumn('lever', function ($criteria_fe) {
                $result = '';
                if ($criteria_fe->lever != 0) {
                    $result = "<i class='fa fa-check'></i>";
                } else {
                    $result = "<i class='fa fa-times'></i>";
                }
                return $result;
            })

            ->addColumn('hose_and_nozzle', function ($criteria_fe) {
                $result = '';
                if ($criteria_fe->hose_and_nozzle != 0) {
                    $result = "<i class='fa fa-check'></i>";
                } else {
                    $result = "<i class='fa fa-times'></i>";
                }
                return $result;
            })

            ->addColumn('cyl_tank', function ($criteria_fe) {
                $result = '';
                if ($criteria_fe->cyl_tank != 0) {
                    $result = "<i class='fa fa-check'></i>";
                } else {
                    $result = "<i class='fa fa-times'></i>";
                }
                return $result;
            })

            ->addColumn('press_gauge', function ($criteria_fe) {
                $result = '';
                if ($criteria_fe->press_gauge != 0) {
                    $result = "<span class='badge badge-pill badge-success'>195 PSI</span>";
                } else {
                    $result = "<span class='badge badge-pill badge-danger'>Below 195 PSI</span>";
                }
                return $result;
            })

            ->addColumn('capacity', function ($criteria_fe) {
                $result = $criteria_fe->capacity;
                return $result;
            })

            ->addColumn('remarks', function ($criteria_fe) {
                $result = $criteria_fe->remarks;
                return $result;
            })

            ->rawColumns(['control_number', 'classification', 'location', 'lever', 'hose_and_nozzle', 'cyl_tank', 'press_gauge', 'capacity', 'remarks'])
            ->make(true);
    }

    // Adding of Findings for Fire Extinguisher
    public function add_checksheet_findings_fe(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();
        $rapidx_user_id = $_SESSION['rapidx_user_id'];
        $data = $request->all();
        $validator = Validator::make($data, [
            'general_area_fe'   => ['required', 'string', 'max:255'],
            'control_number_fe' => ['required', 'string', 'max:255'],
            'classification_fe' => ['required', 'string', 'max:255'],
            'location_fe'       => ['required', 'string', 'max:255'],
            'capacity_fe'       => ['required', 'string', 'max:255'],
            'remarks_fe'        => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json(['result' => '0', 'error' => $validator->messages()]);
        } else {
            DB::beginTransaction();

            try {
                FireExtinguisherCriteria::insert([
                    'control_number'    => $request->control_number_fe,
                    'classification'    => $request->classification_fe,
                    'location'          => $request->location_fe,
                    'lever'             => $request->leverstatus,
                    'hose_and_nozzle'   => $request->hosestatus,
                    'cyl_tank'          => $request->cyltankstatus,
                    'press_gauge'       => $request->pressgaugestatus,
                    'capacity'          => $request->capacity_fe,
                    'remarks'           => $request->remarks_fe,
                    'checksheet_id'     => $request->checksheet_id_fe,
                    'factory'           => $request->factory_view_fe_criteria,
                    'created_by'        => $rapidx_user_id,
                    'last_updated_by'   => $rapidx_user_id,
                    'updated_at'        => date('Y-m-d H:i:s'),
                    'created_at'        => date('Y-m-d H:i:s')
                ]);

                // CHAN 01-23-2025
                Checksheet::where('checksheet_id',  $request->checksheet_id_fe)->update([
                    'checking' => '1',
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

    // Datatables of Findings for Fire Hose
    public function view_criteria_table_fh(Request $request)
    {
        session_start();
        $rapidx_user_id = $_SESSION['rapidx_user_id'];
        $criteria_fh = FireHoseCriteria::where('checksheet_id', $request->checksheet_id)->orderBy('created_at', 'ASC');

        return DataTables::of($criteria_fh)
            ->addColumn('control_number', function ($criteria_fh) {

                $result = $criteria_fh->control_number;

                return $result;
            })
            ->addColumn('location', function ($criteria_fh) {

                $result = $criteria_fh->location;

                return $result;
            })
            ->addColumn('cabinet', function ($criteria_fh) {

                $result = '';

                if ($criteria_fh->cabinet != 0) {
                    $result = "<i class='fa fa-check'></i>";
                } else {
                    $result = "<i class='fa fa-times'></i>";
                }

                return $result;
            })
            ->addColumn('hose', function ($criteria_fh) {

                $result = '';

                if ($criteria_fh->hose != 0) {
                    $result = "<i class='fa fa-check'></i>";
                } else {
                    $result = "<i class='fa fa-times'></i>";
                }

                return $result;
            })
            ->addColumn('nozzle', function ($criteria_fh) {

                $result = '';

                if ($criteria_fh->nozzle != 0) {
                    $result = "<i class='fa fa-check'></i>";
                } else {
                    $result = "<i class='fa fa-times'></i>";
                }

                return $result;
            })
            ->addColumn('pipeline', function ($criteria_fh) {

                $result = '';

                if ($criteria_fh->pipeline != 0) {
                    $result = "<i class='fa fa-check'></i>";
                } else {
                    $result = "<i class='fa fa-times'></i>";
                }

                return $result;
            })
            ->addColumn('valve', function ($criteria_fh) {

                $result = '';

                if ($criteria_fh->valve != 0) {
                    $result = "<i class='fa fa-check'></i>";
                } else {
                    $result = "<i class='fa fa-times'></i>";
                }

                return $result;
            })
            ->addColumn('remarks', function ($criteria_fh) {

                $result = $criteria_fh->remarks;

                return $result;
            })
            ->rawColumns(['control_number', 'location', 'cabinet', 'hose', 'nozzle', 'pipeline', 'valve', 'remarks'])
            ->make(true);
    }

    // Adding of Findings for Fire Hose
    public function add_checksheet_findings_fh(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();
        $rapidx_user_id = $_SESSION['rapidx_user_id'];
        $data = $request->all();
        $validator = Validator::make($data, [
            'general_area_fh'   => ['required', 'string', 'max:255'],
            'control_number_fh' => ['required', 'string', 'max:255'],
            'location_fh'       => ['required', 'string', 'max:255'],
            'remarks_fh'        => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json(['result' => '0', 'error' => $validator->messages()]);
        } else {
            DB::beginTransaction();

            try {
                FireHoseCriteria::insert([
                    'control_number'    => $request->control_number_fh,
                    'location'          => $request->location_fh,
                    'cabinet'           => $request->cabinetstatus,
                    'hose'              => $request->hosestatusfh,
                    'nozzle'            => $request->nozzlestatus,
                    'pipeline'          => $request->pipelinestatus,
                    'valve'             => $request->valvestatus,
                    'remarks'           => $request->remarks_fh,
                    'checksheet_id'     => $request->checksheet_id_fh,
                    'factory'           => $request->factory_view_fh_criteria,
                    'created_by'        => $rapidx_user_id,
                    'last_updated_by'   => $rapidx_user_id,
                    'updated_at'        => date('Y-m-d H:i:s'),
                    'created_at'        => date('Y-m-d H:i:s')
                ]);

                // CHAN 01-23-2025
                Checksheet::where('checksheet_id',  $request->checksheet_id_fh)->update([
                    'checking' => '1',
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

    // Submit Checksheet
    public function submit_checksheet(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();
        $rapidx_user_id = $_SESSION['rapidx_user_id'];
        $data = $request->all();
        $validator = Validator::make($data, [
            'submit_checksheet_id' => ['string', 'max:255'],
            'checksheet_status' => ['string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json(['result' => '0', 'error' => $validator->messages()]);
        } else {
            DB::beginTransaction();
            try {

                Checksheet::where('checksheet_id', $request->submit_checksheet_id)
                    ->update([
                        'noted_by_supervisor'   => $request->sr_supervisor,
                        'noted_by_manager'      => $request->manager,
                        'status'                => $request->checksheet_status,
                        'last_updated_by'       => $rapidx_user_id,
                        'checked_by'            => $rapidx_user_id,
                        'updated_at'            => date('Y-m-d H:i:s')
                    ]);

                // Send email notification to Supervisor
                $forapproval = Checksheet::with(['inspector_details'])->where('checksheet_id', $request->submit_checksheet_id)->get();
                $email = RapidXUser::where('id', $request->sr_supervisor)->where('user_stat', 1)->get();
                $forapprovalcount = count($forapproval);
                $data = ['forapproval' => $forapproval, 'email' => $email];

                if ($forapprovalcount != 0) {
                    if($email->isNotEmpty()){
                        if($email[0]->email != null){
                            $recipients = $email[0]->email;
                            // // START CHAN 01-16-2025 - COMMENT KA MUNA
                            Mail::send('mail.send_for_approval', $data, function ($message) use ($recipients) {
                                $message->to($recipients)->bcc('cbretusto@pricon.ph')->subject('PMCSFES Approval Notification');
                            }); // END CHAN 01-16-2025 - COMMENT KA MUNA
                            $result = 1;
                        }else{
                            $result = 2;
                        }
                    }else{
                        $result = 2;
                    }
                }
                DB::commit();
                return response()->json(['result' => $result]);
            } catch (\Exception $e) {
                DB::rollback();
                // throw $e;
                return response()->json(['result' => "0"]);
            }
        }
    }

    // Supervisor Approve Checksheet
    public function supervisor_approve_checksheet(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();
        $rapidx_user_id = $_SESSION['rapidx_user_id'];
        $data = $request->all();
        $rules = [
            'supervisor_approve_checksheet_id'      =>   'required|string|max:255',
            'supervisor_approve_checksheet_status'  =>   'required|string|max:255',
        ];
        $validator = Validator::make($data,$rules);
        // return $validator;
        if ($validator->fails()) {
            DB::rollback();
            return response()->json(['result' => '0', 'error' => $validator->messages()]);
        } else {
            DB::beginTransaction();
            try {
                if ($request->supervisor_approve_checksheet_status == 2) {
                    Checksheet::where('checksheet_id', $request->supervisor_approve_checksheet_id)
                        ->update([
                            'status'            => $request->supervisor_approve_checksheet_status,
                            'last_updated_by'   => $rapidx_user_id,
                            's_remarks'         => $request->supervisor_approve_checksheet_remarks,
                            's_date'            => date('Y-m-d H:i:s'),
                            'updated_at'        => date('Y-m-d H:i:s')
                        ]);
                        $result = 1;
                } else {
                    Checksheet::where('checksheet_id', $request->supervisor_approve_checksheet_id)
                        ->update([
                            'status'            => $request->supervisor_approve_checksheet_status,
                            'last_updated_by'   => $rapidx_user_id,
                            'm_remarks'         => $request->supervisor_approve_checksheet_remarks,
                            'm_date'            => date('Y-m-d H:i:s'),
                            'updated_at'        => date('Y-m-d H:i:s')
                        ]);
                        $result = 1;
                }

                // Send email notification to Manager
                $forapproval = Checksheet::with(['inspector_details'])->where('checksheet_id', $request->supervisor_approve_checksheet_id)->get();
                $forapprovalcount = count($forapproval);

                // if ($forapprovalcount != 0) {
                //     $email = RapidXUser::where('id', $forapproval[0]->noted_by_manager)->where('user_stat', 1)->get();
                //     $data = ['forapproval' => $forapproval, 'email' => $email];
                //     if($email->isNotEmpty()){
                //         if($email[0]->email != null){
                //             $recipients = $email[0]->email;
                //             // // START CHAN 01-16-2025 - COMMENT KA MUNA
                //             Mail::send('mail.send_for_approval', $data, function ($message) use ($recipients) {
                //                 $message->to($recipients)->bcc('cbretusto@pricon.ph')->subject('PMCSFES Approval Notification');
                //             }); // END CHAN 01-16-2025 - COMMENT KA MUNA
                //             $result = 1;
                //         }else{
                //             $result = 2;
                //         }
                //     }else{
                //         $result = 2;
                //     }
                // }
                DB::commit();
                return response()->json(['result' => $result]);
            } catch (\Exception $e) {
                DB::rollback();
                // throw $e;
                return response()->json(['result' => "0",'error_message' => $e]);
            }
        }
    }

    // Manager Approve Checksheet
    public function manager_approve_checksheet(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();
        $rapidx_user_id = $_SESSION['rapidx_user_id'];
        $data = $request->all();
        $validator = Validator::make($data, [
            'manager_approve_checksheet_id' => ['string', 'max:255'],
            'manager_approve_checksheet_status' => ['string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json(['result' => '0', 'error' => $validator->messages()]);
        } else {
            DB::beginTransaction();

            try {
                if ($request->manager_approve_checksheet_status == 3) {
                    Checksheet::where('checksheet_id', $request->manager_approve_checksheet_id)
                        ->update([
                            'status'            => $request->manager_approve_checksheet_status,
                            'last_updated_by'   => $rapidx_user_id,
                            'noted_by_manager'  => $rapidx_user_id,
                            'm_remarks'         => $request->manager_approve_checksheet_remarks,
                            'updated_at'        => date('Y-m-d H:i:s')
                        ]);
                } else {
                    Checksheet::where('checksheet_id', $request->manager_approve_checksheet_id)
                        ->update([
                            'status'                => $request->manager_approve_checksheet_status,
                            'last_updated_by'       => $rapidx_user_id,
                            'noted_by_supervisor'   => NULL,
                            's_remarks'             => NULL,
                            'm_remarks'             => $request->manager_approve_checksheet_remarks,
                            'updated_at'            => date('Y-m-d H:i:s')
                        ]);
                }

                DB::commit();

                return response()->json(['result' => "1"]);
            } catch (\Exception $e) {
                DB::rollback();
                // throw $e;
                return response()->json(['result' => "0"]);
            }
        }
    }

    // Altering of Modal Based on Status
    public function alter_criteria_modal_based_on_status(Request $request)
    {
        $checksheet = Checksheet::where('checksheet_id', $request->checksheet_id)->get();
        if ($checksheet[0]->status == 1 || $checksheet[0]->status == 2 || $checksheet[0]->status == 3) {
            return response()->json(['result' => "1"]);
        } else {
            return response()->json(['result' => "2"]);
        }
    }
}
