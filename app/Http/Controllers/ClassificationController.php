<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

use DataTables;

use App\Model\Classification;

class ClassificationController extends Controller
{
    public function view_classification_table(Request $request){
		$classifications = Classification::where('device_id', $request->deviceID)->where('logdel', 0)->get();

		return DataTables::of($classifications)
        ->addColumn('action',function($classification){
            $result = '<center>';
            if($classification->status == 1){
                $result .= '<button type="button" class="btn btn-sm btn-dark btn-update-classification mr-2" data-toggle="modal" data-target="#modalUpdateClassification" title="Update Classification" classification-id="'.$classification->id.'"><i class="fa fa-edit"></i></button>';       
                $result .= '<button type="button" class="btn btn-danger btn-sm text-center actionChangeClassificationStatus" classification-id="' . $classification->id . '" status="2" data-toggle="modal" data-target="#modalChangeClassificationStatus" title="Deactivate General Area"><i class="fa-solid fa-xl fa fa-ban"></i></button>';
            }else{
                $result .= '<button type="button" class="btn btn-warning btn-sm text-center actionChangeClassificationStatus" classification-id="' . $classification->id . '" status="1" data-toggle="modal" data-target="#modalChangeClassificationStatus" title="Activate General Area"><i class="fa-solid fa-xl fa fa-undo"></i></button>';
            }
            $result .= '</center>';
            return $result;
		})
        ->addColumn('control_no_location',function($classification){
            $result = '<center>';
            $result .= '<button type="button" class="btn btn-sm btn-dark btn-view-control_no_location" data-toggle="modal" data-target="#modalViewControlNoLocation" title="View Control No & Location" classification-id="'.$classification->id.'" get-classification="'.$classification->classification.'"><i class="fa fa-eye"></i> View Data</button>';       
            $result .= '</center>';
            return $result;
		})

        ->rawColumns(['action','control_no_location'])
        ->make(true);
	}

    public function create_classification(Request $request){
        date_default_timezone_set('Asia/Manila');
        $data = $request->all();
        $validator = Validator::make($data, [
            'classification'    => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['validationHasError' => 1, 'error' => $validator->messages()]);
        }else{
            DB::beginTransaction();
            try{
                if(Classification::where('device_id', $request->device_id)->where('classification', $request->classification)->where('logdel', 0)->where('status', 1)->doesntExist()){
                    Classification::insert([
                        'device_id'     => $request->device_id,
                        'classification'  => $request->classification,
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

    public function get_classification_info_by_id(Request $request){
        $classification_info = Classification::where('id', $request->generalAreaID)->where('status', 1)->where('logdel', 0)->get();
        return response()->json([
            'classificationInfo' => $classification_info, 
        ]);
    }

    public function update_classification(Request $request){
        date_default_timezone_set('Asia/Manila');
        $data = $request->all();
        $validator = Validator::make($data, [
            'classification'    => 'required',
        ]);
        if($validator->fails()) {
            return response()->json(['validationHasError' => 1, 'error' => $validator->messages()]);
        }else{
            DB::beginTransaction();
            try {
                if(Classification::where('classification', $request->classification)->where('logdel', 0)->where('status', 1)->doesntExist()){
                    Classification::where('id', $request->classification_id)->update([
                        'classification'  => $request->classification,
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

    public function change_classification_status(Request $request){        
        date_default_timezone_set('Asia/Manila');

        $data = $request->all();
        $validator = Validator::make($data, [
            'classification_status_id'    => 'required',
            'status'                    => 'required',
        ]);

        if($validator->passes()){
            Classification::where('id', $request->classification_status_id)
            ->update([
                'status'        => $request->status,
                'updated_at'    => date('Y-m-d H:i:s'),
            ]);
            return response()->json(['result' => "1"]);
        }else{
            return response()->json(['validation' => "hasError", 'error' => $validator->messages()]);
        }
    }

    public function get_classification(Request $request){
        $classification_info = Classification::where('device_id', $request->deviceID)->where('status',1)->where('logdel',0)->get();

        return response()->json([
                'classificationInfo' => $classification_info, 
        ]);
    }

}
