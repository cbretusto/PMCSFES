<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

use DataTables;

use App\Model\EquipmentModel;

class EquipmentModelController extends Controller
{
    public function view_equipment_model_table(Request $request){
		$equipment_models = EquipmentModel::where('device_id', $request->deviceID)->where('logdel', 0)->get();

		return DataTables::of($equipment_models)
        ->addColumn('action',function($equipment_model){
            $result = '<center>';
            if($equipment_model->status == 1){
                $result .= ' <button type="button" class="btn btn-sm btn-dark btn-update-equipment_model_id" data-toggle="modal" data-target="#modalUpdateEquipmentModel" title="View Equipment Model & Checklist" equipment_model-id="'.$equipment_model->id.'"><i class="fa fa-edit"></i></button>';       
                $result .= '<button type="button" class="btn btn-danger btn-sm text-center actionChangeEquipmentModelStatus ml-2" equipment_model-id="' . $equipment_model->id . '" status="2" data-toggle="modal" data-target="#modalChangeEquipmentModelStatus" title="Deactivate Model"><i class="fa-solid fa-xl fa fa-ban"></i></button>';
            }else{
                $result .= '<button type="button" class="btn btn-warning btn-sm text-center actionChangeEquipmentModelStatus ml-2" equipment_model-id="' . $equipment_model->id . '" status="1" data-toggle="modal" data-target="#modalChangeEquipmentModelStatus" title="Activate Model"><i class="fa-solid fa-xl fa fa-undo"></i></button>';
            }
            $result .= '</center>';
            return $result;
		})

        ->rawColumns(['action'])
        ->make(true);
	}

    public function create_equipment_model(Request $request){
        date_default_timezone_set('Asia/Manila');
        $data = $request->all();
        $validator = Validator::make($data, [
            'equipment_model'    => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['validationHasError' => 1, 'error' => $validator->messages()]);
        } else {
            DB::beginTransaction();
            try {
                if(EquipmentModel::where('equipment_model', $request->equipment_model)->where('logdel', 0)->where('status', 1)->doesntExist()){
                    EquipmentModel::insert([
                        'device_id'    => $request->device_id,
                        'equipment_model'   => $request->equipment_model,
                        'created_at'    => date('Y-m-d H:i:s')                   
                    ]);
                    $result = 1;
                }else{
                    $result = 2;
                }
                DB::commit();
                return response()->json(['hasError' => $result]);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['hasError' => 0, 'exceptionError' => $e]);
            }
        }
    }

    public function get_equipment_model_info_by_id(Request $request){
        $equipment_model_info = EquipmentModel::where('id', $request->equipmentModelID)->where('status', 1)->where('logdel', 0)->get();
        return response()->json([
                'equipmentModelInfo' => $equipment_model_info, 
        ]);
    }

    public function update_equipment_model(Request $request){
        date_default_timezone_set('Asia/Manila');
        $data = $request->all();
        $validator = Validator::make($data, [
            'equipment_model'    => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['validationHasError' => 1, 'error' => $validator->messages()]);
        } else {
            DB::beginTransaction();
            try {
                if(EquipmentModel::where('equipment_model', $request->equipment_model)->where('logdel', 0)->where('status', 1)->doesntExist()){
                    EquipmentModel::where('id', $request->equipment_model_id)->update([
                        'equipment_model'   => $request->equipment_model,
                        'updated_at'        => date('Y-m-d H:i:s'),
                    ]);
                    $result = 1;
                }else{
                    $result = 2;
                }
                DB::commit();
                return response()->json(['hasError' => $result]);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['hasError' => 0, 'exceptionError' => $e]);
            }
        }
    }

    public function change_equipment_model_status(Request $request){        
        date_default_timezone_set('Asia/Manila');

        $data = $request->all(); 
        $validator = Validator::make($data, [
            'equipment_status_id' => 'required',
            'status' => 'required',
        ]);

        if($validator->passes()){
            EquipmentModel::where('id', $request->equipment_status_id)
            ->update([
                'status' => $request->status,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            return response()->json(['result' => "1"]);
        }
        else{
            return response()->json(['validation' => "hasError", 'error' => $validator->messages()]);
        }
    }

    public function get_equipment_model(Request $request){
        $equipment_model_info = EquipmentModel::where('device_id', $request->deviceID)->where('status', 1)->where('logdel', 0)->get();

        return response()->json([
            'equipmentModelInfo' => $equipment_model_info,
        ]);
    }

}
