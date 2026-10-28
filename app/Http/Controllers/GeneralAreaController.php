<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

use DataTables;

use App\Model\GeneralArea;

class GeneralAreaController extends Controller
{
    public function view_general_area_table(Request $request){
		$general_areas = GeneralArea::where('device_id', $request->deviceID)->where('logdel', 0)->get();

		return DataTables::of($general_areas)
        ->addColumn('action',function($general_area){
            $result = '<center>';
            if($general_area->status == 1){
                $result .= ' <button type="button" class="btn btn-sm btn-dark btn-update-general_area" data-toggle="modal" data-target="#modalUpdateGeneralArea" title="Update General Area" general_area-id="'.$general_area->id.'"><i class="fa fa-edit"></i></button>';       
                $result .= '<button type="button" class="btn btn-danger btn-sm text-center actionChangeGeneralAreaStatus ml-2" general_area-id="' . $general_area->id . '" status="2" data-toggle="modal" data-target="#modalChangeGeneralAreaStatus" title="Deactivate General Area"><i class="fa-solid fa-xl fa fa-ban"></i></button>';
            }else{
                $result .= '<button type="button" class="btn btn-warning btn-sm text-center actionChangeGeneralAreaStatus ml-2" general_area-id="' . $general_area->id . '" status="1" data-toggle="modal" data-target="#modalChangeGeneralAreaStatus" title="Activate General Area"><i class="fa-solid fa-xl fa fa-undo"></i></button>';
            }
            $result .= '</center>';
            return $result;
		})
        ->addColumn('control_no_location',function($general_area){
            $result = '<center>';
            $result .= ' <button type="button" class="btn btn-sm btn-dark btn-view-control_no_location" data-toggle="modal" data-target="#modalViewControlNoLocation" title="View Control No & Location" general_area-id="'.$general_area->id.'" get-general_area="'.$general_area->general_area.'"><i class="fa fa-eye"></i> View Data</button>';       
            $result .= '</center>';
            return $result;
		})

        ->rawColumns(['action','control_no_location'])
        ->make(true);
	}

    public function create_general_area(Request $request){
        date_default_timezone_set('Asia/Manila');
        $data = $request->all();
        $validator = Validator::make($data, [
            'general_area'    => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['validationHasError' => 1, 'error' => $validator->messages()]);
        }else{
            DB::beginTransaction();
            try{
                if(GeneralArea::where('device_id', $request->device_id)->where('general_area', $request->general_area)->where('logdel', 0)->where('status', 1)->doesntExist()){
                    GeneralArea::insert([
                        'device_id'     => $request->device_id,
                        'general_area'  => $request->general_area,
                        'created_at'    => date('Y-m-d H:i:s')                   
                    ]);
                    $result = 1;
                }else{
                    $result = 2;
                }
                DB::commit();
                return response()->json(['hasError' => $result]);
            }catch (\Exception $e){
                DB::rollback();
                return response()->json(['hasError' => 0, 'exceptionError' => $e]);
            }
        }
    }

    public function get_general_area_info_by_id(Request $request){
        $general_area_info = GeneralArea::where('id', $request->generalAreaID)->where('status', 1)->where('logdel', 0)->get();
        return response()->json([
                'generalAreaInfo' => $general_area_info, 
        ]);
    }

    public function update_general_area(Request $request){
        date_default_timezone_set('Asia/Manila');
        $data = $request->all();
        $validator = Validator::make($data, [
            'general_area'    => 'required',
        ]);
        if($validator->fails()) {
            return response()->json(['validationHasError' => 1, 'error' => $validator->messages()]);
        }else{
            DB::beginTransaction();
            try {
                if(GeneralArea::where('general_area', $request->general_area)->where('logdel', 0)->where('status', 1)->doesntExist()){
                    GeneralArea::where('id', $request->general_area_id)->update([
                        'general_area'  => $request->general_area,
                        'updated_at'    => date('Y-m-d H:i:s'),
                    ]);
                    $result = 1;
                }else{
                    $result = 2;
                }
                DB::commit();
                return response()->json(['hasError' => $result]);
            }catch(\Exception $e){
                DB::rollback();
                return response()->json(['hasError' => 0, 'exceptionError' => $e]);
            }
        }
    }

    public function change_general_area_status(Request $request){        
        date_default_timezone_set('Asia/Manila');

        $data = $request->all(); // collect all input fields
        $validator = Validator::make($data, [
            'general_area_status_id'    => 'required',
            'status'                    => 'required',
        ]);

        if($validator->passes()){
            GeneralArea::where('id', $request->general_area_status_id)
            ->update([
                'status'        => $request->status,
                'updated_at'    => date('Y-m-d H:i:s'),
            ]);
            return response()->json(['result' => "1"]);
        }else{
            return response()->json(['validation' => "hasError", 'error' => $validator->messages()]);
        }
    }


    public function get_general_area(Request $request){
        $general_area_info = GeneralArea::where('device_id', $request->deviceID)->where('status', 1)->where('logdel', 0)->get();

        return response()->json([
            'generalAreaInfo' => $general_area_info, 
        ]);
    }

}
