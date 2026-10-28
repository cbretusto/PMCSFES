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

class EquipmentController extends Controller
{
        public function view_device_checklist_table(Request $request){
                session_start();
                $devices = Device::where('factory',$request->factory);
                return DataTables::of($devices)

                ->addColumn('action',function($devices){
                        $result = '<center>';
                        $result .= '<button type="button" class="btn btn-sm btn-info btn-edit-checksheet mr-2" data-toggle="modal" data-target="#modalNewEquipment" title="View Equipment" device-id="'.$devices->device_id.'" device-factory="'.$devices->factory.'"><i class="fa fa-edit"></i></button>';       
                        $result .= '<button type="button" class="btn btn-sm btn-dark btn-view-equipment_model_checklist" data-toggle="modal" data-target="#modalCreateEquipmentModelChecklist" title="View Equipment Model & Checklist" device-id="'.$devices->device_id.'" device="'.$devices->device_name.'"><i class="fa fa-cog"></i></button>';       
                        $result .= '</center>';
                        return $result;
                })
                ->addColumn('device_name',function($devices){
                        $result = $devices->device_name;  
                        return $result;
                })

                ->rawColumns(['action', 'device_name'])
                ->make(true);
        }

        public function create_update_equipment(Request $request){
                date_default_timezone_set('Asia/Manila');
                session_start();

                $rapidx_user_id = $_SESSION['rapidx_user_id'];
                $data = $request->all();
                $rules = [
                'equipment_name' => 'required|string|max:255',       
                ];
                $validator = Validator::make($data,$rules);
                $checking = Device::where('device_name', $request->equipment_name)
                        ->where('general_area', $request->general_area)
                        ->where('classification',$request->classification)
                        ->where('factory', $request->equipment_factory)
                        ->get();

                if ($validator->fails()) {
                        return response()->json(['result' => '0', 'error' => $validator->messages()]);
                }
                else{
                        DB::beginTransaction();
                        try{
                                if(count($checking) > 0){
                                        $result = 2;
                                }else{
                                        if($request->factory_equipment_list == ''){
                                                Device::insert([
                                                        'device_name'           => $request->equipment_name,
                                                        'created_by'            => $rapidx_user_id,
                                                        'general_area'          => $request->general_area,
                                                        'classification'        => $request->classification,
                                                        'factory'               => $request->equipment_factory,
                                                        'created_at'            => date('Y-m-d H:i:s')                   
                                                ]);
                                        }else{
                                                Device::where('device_id', $request->factory_equipment_list)->update([
                                                        'device_name'           => $request->equipment_name,
                                                        'general_area'          => $request->general_area,
                                                        'classification'        => $request->classification,
                                                        'updated_at'            => date('Y-m-d H:i:s'),
                                                ]);
                                        }
                                        $result = 1;
                                }
                                DB::commit();
                                
                                return response()->json(['result' => $result]);
                        }
                        catch(\Exception $e) {
                                // return 'CATCH';
                                DB::rollback();
                                // return $result;
                                throw $e;
                                return response()->json(['result' => "0"]);
                        }
                }
        } 

        public function get_device_info_by_id(Request $request){
                $device_info = Device::where('device_id', $request->deviceId)->get();
                return response()->json([
                        'deviceInfo' => $device_info, 
                ]);
        }

        public function view_device_table(Request $request){
                session_start();
                $rapidx_user_id = $_SESSION['rapidx_user_id'];
                $devices = Device::where('factory',$request->factory);
                return DataTables::of($devices)
                ->addColumn('action',function($devices){
                        $result = "<center>";
                        $result .= '<button type="button" class="btn btn-sm btn-info btn-view-checksheets" data-toggle="modal" data-target="#modalViewChecksheets" title="View checksheets" devices-id="'.$devices->device_id.'"><i class="fa fa-eye"></i></button>';       
                        $result .= "</center>";
                        return $result;
                })
                ->addColumn('id',function($devices){
                        $result = $devices->device_id;  
                        return $result;
                })

                ->addColumn('device_name',function($devices){
                        $result = $devices->device_name;  
                        return $result;
                })
                ->rawColumns(['action','id','device_name'])
                ->make(true);
	}

        public function get_device(Request $request){
                $device_info = Device::with('device_info')->where('factory', $request->factory)->get();

                return response()->json([
                        'deviceInfo' => $device_info, 
                ]);
        }
}
