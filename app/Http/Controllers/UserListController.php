<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use DataTables;

use App\Model\UserList;
use App\Model\RapidXUser;

class UserListController extends Controller
{
    public function view_user_list(){
        $userDetails = UserList::with(['rapidx_user_info'])->where('classification', '!=', 3)->where('logdel', 0)->get();

        return DataTables::of($userDetails)
        ->addColumn('action', function($userDetail){
            $result =   '<center>';
            
            if($userDetail->status == 1){
                $result .= '<button type="button" class="btn btn-dark btn-sm text-center actionEditUser mr-1" user-id="' . $userDetail->id . '" data-toggle="modal" data-target="#modalCreateUpdateUser" title="Edit User Details"><i class="fa fa-xl fa-edit"></i></button>';
                $result .= '<button type="button" class="btn btn-danger btn-sm text-center actionChangeUserStatus mr-1" user-id="' . $userDetail->id . '" status="2" data-toggle="modal" data-target="#modalChangeUserStatus" title="Deactivate User"><i class="fa-solid fa-xl fa fa-ban"></i></button>';
            }else{
                $result .= '<button type="button" class="btn btn-warning btn-sm text-center actionChangeUserStatus mr-1" user-id="' . $userDetail->id . '" status="1" data-toggle="modal" data-target="#modalChangeUserStatus" title="Activate User"><i class="fa-solid fa-xl fa fa-undo"></i></button>';
            }
            
            $result .= '</center>';
            return $result;
        })

        ->rawColumns(['action'])
        ->make(true);
    }

    public function get_employee_name(){
        $get_employee_name = RapidXUser::where('user_stat', 1)->where('department_id', '30')->orderBy('name', 'ASC')->whereNotNull('employee_number')->get();
        return response()->json(['get_employee_name' => $get_employee_name]);
    }

    public function create_update_user(Request $request){
        date_default_timezone_set('Asia/Manila');

        $data = $request->all();
        $validator = Validator::make($data, [
            'rapidx_employee_name'  => 'required',
            'classification'        => 'required',
            'category'              => 'required'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['validationHasError' => 1, 'error' => $validator->messages()]);
        } else {
            DB::beginTransaction();
            try {
                $check_existing_record = 
                    UserList::where('rapidx_user_id', $request->rapidx_employee_name)
                        ->where('classification', $request->classification)
                        ->where('category',  $request->category)
                        ->get();

                    if($request->user_id != ''){
                        if(count($check_existing_record) < 1){
                            UserList::where('id', $request->user_id)->update([
                                'rapidx_user_id'    => $request->rapidx_employee_name,
                                'classification'    => $request->classification,
                                'category'          => $request->category,
                                'updated_at'        => date('Y-m-d H:i:s'),
                            ]);
                        }else{
                            return response()->json(['result' => 1]);
                        }
                    }else{
                        if(count($check_existing_record) < 1){
                            UserList::insert([
                                'rapidx_user_id'    => $request->rapidx_employee_name,
                                'classification'    => $request->classification,
                                'category'          => $request->category,
                                'created_at'        => date('Y-m-d H:i:s'),
                            ]);    
                        }else{
                            return response()->json(['result' => 1]);
                        }
                    }
                
                DB::commit();
                return response()->json(['hasError' => 0]);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['hasError' => 1, 'exceptionError' => $e]);
            }
        }
    }
    public function get_user_info_by_id(Request $request){
        $user_info = UserList::with(['rapidx_user_info'])->where('id', $request->UserId)->get();
        return response()->json([
            'user_info' => $user_info, 
        ]);
    }

    public function change_user_status(Request $request){        
        date_default_timezone_set('Asia/Manila');

        $data = $request->all();

        $validator = Validator::make($data, [
            'user_id' => 'required',
            'status' => 'required',
        ]);

        if($validator->passes()){
            UserList::where('id', $request->user_id)
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
    
    public function get_user_log(Request $request){
        session_start();
        $rapidx_user_id = $_SESSION['rapidx_user_id'];

        $user_log = UserList::with(['rapidx_user_info'])
            ->where('rapidx_user_id', $request->loginEmployeeId)
            ->where('status', 1)
            ->where('logdel', 0)
            ->get();
        return response()->json(['result' => $user_log]);
    }

    public function get_noted_by(Request $request){
        $noted_by_info = UserList::with(['rapidx_user_info'])->where('category', $request->factory)->where('status', 1)->where('logdel', 0)->get();

        return response()->json([
            'notedByInfo' => $noted_by_info, 
        ]);
    }

}
