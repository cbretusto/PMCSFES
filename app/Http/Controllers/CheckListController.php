<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

use DataTables;

use App\Model\CheckList;

class CheckListController extends Controller
{
    public function view_checklist_table(Request $request){
		$checklists = CheckList::where('device_id', $request->deviceID)->where('logdel', 0)->get();

		return DataTables::of($checklists)
        ->addColumn('action',function($checklist){
            $result = '<center>';
            if($checklist->status == 1){
                $result .= ' <button type="button" class="btn btn-sm btn-dark btn-update-checklist_id" data-toggle="modal" data-target="#modalCheckList" title="Update Checklist" checklist-id="'.$checklist->id.'"><i class="fa fa-edit"></i></button>';       
                $result .= '<button type="button" class="btn btn-danger btn-sm text-center actionChangeChecklistStatus ml-2" checklist-id="' . $checklist->id . '" status="2" data-toggle="modal" data-target="#modalChangeChecklistStatus" title="Deactivate Model"><i class="fa-solid fa-xl fa fa-ban"></i></button>';
            }else{
                $result .= '<button type="button" class="btn btn-warning btn-sm text-center actionChangeChecklistStatus ml-2" checklist-id="' . $checklist->id . '" status="1" data-toggle="modal" data-target="#modalChangeChecklistStatus" title="Activate Model"><i class="fa-solid fa-xl fa fa-undo"></i></button>';
            }
            $result .= '</center>';
            return $result;
		})

        ->rawColumns(['action'])
        ->make(true);
	}

    public function create_update_checklist(Request $request){
        date_default_timezone_set('Asia/Manila');
        $data = $request->all();
        $validator = Validator::make($data, [
            'device_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['validationHasError' => 1, 'error' => $validator->messages()]);
        } else {
            DB::beginTransaction();
            try {
                if($request->checklist_id == ''){
                    CheckList::insert([
                        'device_id'         => $request->device_id,
                        'checklist'         => $request->checklist,
                        'requirement'       => $request->requirement,
                        'created_at'        => date('Y-m-d H:i:s')                   
                    ]);
                }else{
                    CheckList::where('id', $request->checklist_id)->update([
                        'checklist'         => $request->checklist,
                        'requirement'       => $request->requirement,
                        'updated_at'        => date('Y-m-d H:i:s'),
                    ]);
                }
                DB::commit();
                return response()->json(['hasError' => 1]);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['hasError' => 0, 'exceptionError' => $e]);
            }
        }
    }

    public function get_checklist_info_by_id(Request $request){
        $checklist_info = CheckList::where('id', $request->checklistID)->where('status', 1)->where('logdel', 0)->get();
        return response()->json([
                'checklistInfo' => $checklist_info, 
        ]);
    }

    public function change_checklist_status(Request $request){        
        date_default_timezone_set('Asia/Manila');

        $data = $request->all();

        $validator = Validator::make($data, [
            'checklist_status_id' => 'required',
            'status' => 'required',
        ]);

        if($validator->passes()){
            CheckList::where('id', $request->checklist_status_id)
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

    public function get_checklist(Request $request){
        $checklist_info = CheckList::where('device_id', $request->deviceID)->get();

        return response()->json([
                'checklistInfo' => $checklist_info, 
        ]);
    }

    public function get_requirement(Request $request){
        $checklist_info = CheckList::where('device_id', $request->deviceID)->get();

        return response()->json([
                'checklistInfo' => $checklist_info, 
        ]);
    }

}
