<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

use DataTables;

use App\Model\ControlNoLocation;

class ControlNoLocationController extends Controller
{
    public function view_control_no_location_table(Request $request){
		$control_no_locations = ControlNoLocation::where('general_area_id', $request->generalAreaID)->where('logdel', 0)->get();

        return DataTables::of($control_no_locations)
        ->addColumn('action',function($control_no_location){
            $result = '<center>';
            if($control_no_location->status == 1){
                $result .= ' <button type="button" class="btn btn-sm btn-dark btn-update-control_no_location" control_no_location-id="'.$control_no_location->id.'" title="Update Control No. and Location"><i class="fa fa-edit"></i></button>';       
                $result .= '<button type="button" class="btn btn-danger btn-sm text-center actionChangeControlNoLocationStatus ml-2" control_no_location-id="' . $control_no_location->id . '" status="2" data-toggle="modal" data-target="#modalChangeControlNoLocationStatus" title="Deactivate Control No. and Location"><i class="fa-solid fa-xl fa fa-ban"></i></button>';
            }else{
                $result .= '<button type="button" class="btn btn-warning btn-sm text-center actionChangeControlNoLocationStatus ml-2" control_no_location-id="' . $control_no_location->id . '" status="1" data-toggle="modal" data-target="#modalChangeControlNoLocationStatus" title="Activate Control No. and Location"><i class="fa-solid fa-xl fa fa-undo"></i></button>';
            }
            $result .= '</center>';
            return $result;
		})
        ->addColumn('control_no_location',function($control_no_location){
            $result = '<center>';
            $result .= ' <button type="button" class="btn btn-sm btn-dark btn-view-control_no_location" data-toggle="modal" data-target="#modalViewControlNoLocation" title="View Control No & Location" control_no_location-id="'.$control_no_location->id.'" get-control_no_location="'.$control_no_location->control_no_location.'"><i class="fa fa-eye"></i> View Data</button>';       
            $result .= '</center>';
            return $result;
		})

        ->rawColumns(['action','control_no_location'])
        ->make(true);
	}

    public function create_update_control_no_location(Request $request){
        date_default_timezone_set('Asia/Manila');
        $data = $request->all();
        $validator = Validator::make($data, [
            'general_area_id' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['validationHasError' => 1, 'error' => $validator->messages()]);
        }else{
            DB::beginTransaction();
            try {
                if($request->control_no_location_id == ''){
                    ControlNoLocation::insert([
                        'general_area_id'   => $request->general_area_id,
                        'control_no'        => $request->control_number,
                        'location'          => $request->location,
                        'created_at'        => date('Y-m-d H:i:s')                   
                    ]);
                }else{
                    ControlNoLocation::where('id', $request->control_no_location_id)->update([
                        'control_no'        => $request->control_number,
                        'location'          => $request->location,
                        'updated_at'        => date('Y-m-d H:i:s'),
                    ]);
                }
                DB::commit();
                return response()->json(['hasError' => 1]);
            }catch(\Exception $e){
                DB::rollback();
                return response()->json(['hasError' => 0, 'exceptionError' => $e]);
            }
        }
    }

    public function get_control_no_location_info_by_id(Request $request){
        $control_no_location_info = ControlNoLocation::where('id', $request->controlNoLocationID)->where('status', 1)->where('logdel', 0)->get();
        return response()->json([
                'controlNoLocationInfo' => $control_no_location_info, 
        ]);
    }

    public function change_control_no_location_status(Request $request){        
        date_default_timezone_set('Asia/Manila');

        $data = $request->all(); // collect all input fields
        $validator = Validator::make($data, [
            'control_no_location_status_id' => 'required',
            'status'                        => 'required',
        ]);

        if($validator->passes()){
            ControlNoLocation::where('id', $request->control_no_location_status_id)
            ->update([
                'status'        => $request->status,
                'updated_at'    => date('Y-m-d H:i:s'),
            ]);
            return response()->json(['result' => "1"]);
        }else{
            return response()->json(['validation' => "hasError", 'error' => $validator->messages()]);
        }
    }

    public function get_control_no_location(Request $request){
        $control_no_location_info = ControlNoLocation::where('general_area_id', $request->generalAreaID)->where('status', 1)->where('logdel', 0)->get();
        return response()->json([
            'controlNoLocationInfo' => $control_no_location_info, 
        ]);
    }

    public function auto_insert(Request $request){
        date_default_timezone_set('Asia/Manila');
        $data = $request->all();
        $validator = Validator::make($data, [
            'general_area_id' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['validationHasError' => 1, 'error' => $validator->messages()]);
        }else{
            // DB::beginTransaction();
            // try {
                $test = [
                    'ELGF1'=> "Visitor's Area",
                    'ELGF2'=> "Hallway - Subcon",
                    'ELGF3'=> "Men's CR SW",
                    'ELGF4'=> "Ladies' CR SW ",
                    'ELGF5'=> "HALLWAY Activity Room",
                    'ELGF6'=> "ACTIVITY ROOM",
                    'ELGF7'=> "CLINIC",
                    'ELGF8'=> "Hallway - Purchasing",
                    'ELGF9'=> "HALLWAY HRD",
                    'ELGF10'=> "LOBBY",
                    'ELGF11'=> "LOBBY",
                    'ELGF12'=> "LOBBY",
                    'ELGF13'=> "LOBBY",
                    'ELGF14'=> "Locker Extension",
                    'ELGF15'=> "MEN'S CR  NW",
                    'ELGF16'=> "LADIES' CR LOBBY",
                    'ELGF17'=> "Hallway - YF",
                    'ELGF18'=> "Hallway - YF",
                    'ELGF19'=> "ATKS - PMI",
                    'ELGF20'=> "ATKS - AEROPLUS",
                    'ELGF21'=> "FIRE ALARM PANEL",
                    'ELGF22'=> "LOCKER",
                    'ELGF23'=> "LOCKER",
                    'ELGF24'=> "AHU",
                    'ELGF25'=> "AHU",
                    'ELGF26'=> "HALLWAY YF",
                    'ELGF27'=> "HALLWAY YF",
                    'ELGF28'=> "Hallway ENGINEERING",
                    'ELGF29'=> "Hallway - FABRICATION",
                    'ELGF30'=> "Hallway WASHING SEALING",
                    'ELGF31'=> "Hallway -CN Production",
                    'ELGF32'=> "Hallway -CN Production",
                    'ELGF33'=> "Hallway -CN Production",
                    'ELGF34'=> "MEN'S CR - YF",
                    'ELGF35'=> "LADIES' CR - YF",
                    'ELGF36'=> "YF DRESSING ROOM ",
                    'ELGF37'=> "YF OFFICE",
                    'ELGF38'=> "YF Production",
                    'ELGF39'=> "YF Production",
                    'ELGF40'=> "YF Production",
                    'ELGF41'=> "YF Production",
                    'ELGF42'=> "AIDA",
                    'ELGF43'=> "AIDA",
                    'ELGF44'=> "YF SILK PRINTING ",
                    'ELGF45'=> "TS Warehouse Extension",
                    'ELGF46'=> "NEC",
                    'ELGF47'=> "NEC",
                    'ELGF48'=> "CN Production",
                    'ELGF49'=> "CN Production",
                    'ELGF50'=> "CN Production",
                    'ELGF51'=> "CN Production",
                    'ELGF52'=> "New FGS",
                    'ELGF53'=> "GENSET ROOM",
                    'ELGF54'=> "GENSET ROOM",
                    'ELGF55'=> "POWER ROOM 1",
                    'ELGF56'=> "POWER ROOM 2",
                    'ELGF57'=> "EE ROOM A",
                    'ELGF58'=> "Air Compressor Room",
                    'ELGF59'=> "Facility Area",
                    'ELGF60'=> "MEN'S CR - CN1",
                    'ELGF61'=> "LADIES' CR - CN1",
                    'ELSF1'=> "Stair - NW",
                    'ELSF2'=> "Stairway NW 2nd FLR",
                    'ELSF3'=> "Vendo- Admin",
                    'ELSF4'=> "Hallway - FINANCE",
                    'ELSF5'=> "Hallway Guest room",
                    'ELSF6'=> "Hallway - QAD",
                    'ELSF7'=> "Hallway - AVP",
                    'ELSF8'=> "Hallway - DESIGN",
                    'ELSF9'=> "Hallway - CASHIER",
                    'ELSF10'=> "Hallway - SW 2ND FLR",
                    'ELSF11'=> "Hallway - SW",
                    'ELSF12'=> "MEN'S CR NW",
                    'ELSF13'=> "LADIES CR NW",
                    'ELSF14'=> "MEN'S CR SW",
                    'ELSF15'=> "LADIES CR SW",
                    'ELSF16'=> "TS PRODUCTION",
                    'ELSF17'=> "TS PRODUCTION",
                    'ELSF18'=> "TS PRODUCTION",
                    'ELSF19'=> "TS Ante room",
                    'ELSF20'=> "TS Ante room",
                    'ELSF21'=> "TS PRODUCTION",
                    'ELSF22'=> "TS PRODUCTION",
                    'ELSF23'=> "TS WHSE CUTTING",
                    'ELSF24'=> "TS WHSE IQC",
                    'ELSF25'=> "CONTACT AREA",
                    'ELSF26'=> "TS WHSE",
                    'ELSF27'=> "Hallway STAIR SW Back",
                    'ELSF28'=> "STAIRWAY SW - Back",
                    'ELSF29'=> "TS HALLWAY",
                    'ELSF30'=> "TS HALLWAY",
                    'ELSF31'=> "TS HALLWAY",
                    'ELSF32'=> "WOMENS' CR SW Back",
                    'ELSF33'=> "TS WHSE HALLWAY",
                    'ELSF34'=> "TS WHSE HALLWAY",
                    'ELSF35'=> "Mens' CR",
                    'ELSF36'=> "KITCHEN",
                    'ELSF37'=> "KITCHEN",
                    'ELSF38'=> "CANTEEN",
                    'ELSF39'=> "CANTEEN",
                    'ELSF40'=> "TS HALLWAY",
                    'ELSF41'=> "FACILITY STORAGE",
                    'ELSF42'=> "TS EXT WHSE",
                    'ELSF43'=> "TS EXT WHSE",
                    'ELSF44'=> "PROBE PIN 1",
                    'ELSF45'=> "PROBE PIN 2",
                    'ELSF46'=> "TS PACKING/SEALING",
                    'ELSF47'=> "ISS SERVER ROOM",
                    'F2ELS1'=> "Hallway - Canteen",
                    'F2ELS2'=> "Hallway - Canteen",
                    'F2ELS3'=> "Gym Hallway",
                    'F2ELS4'=> "FGS/Multi Purpose",
                    'F2ELS5'=> "FGS/Multi Purpose",
                    'F2ELS6'=> "Canteen",
                    'F2ELS7'=> "Canteen",
                    'F2ELS8'=> "Canteen",
                    'F2ELS9'=> "CN2 Hallway",
                    'F2ELS10'=> "Canteen Office",
                    'F2ELS11'=> "Canteen Stockroom",
                    'F2ELS12'=> "Canteen Receiving",
                    'F2ELS13'=> "Freight Elevator",
                    'F2ELS14'=> "IQA Area",
                    'F2ELS15'=> "Electrical & CDA Room",
                    'F2ELS16'=> "Power Room",
                    'F2ELS17'=> "Evaluation Room",
                    'F2ELS18'=> "CN Meeting Room",
                    'F2ELS19'=> "Stair",
                    'F2ELS20'=> "Loading Area",
                    'F2ELS21'=> "CN Warehouse",
                    'F2ELS22'=> "CN Warehouse",
                    'F2ELS23'=> "CN Warehouse",
                    'F2ELS24'=> "Hallway - CN",
                    'F2ELS25'=> "Hallway - CN",
                    'F2ELS26'=> "Hallway - CN",
                    'F2ELS27'=> "Hallway - Emboss Prod'n",
                    'F2ELS28'=> "Office",
                    'F2ELS29'=> "Emboss Prod'n",
                    'F2ELS30'=> "Emboss Reel Staging room",
                    'F2ELS31'=> "Crasher",
                    'F2ELS32'=> "CN Warehouse",
                    'F2ELS33'=> "PPS-CN Production",
                    'F2ELS34'=> "PPS-CN Production",
                    'F2ELS35'=> "PPS-CN Production",
                    'F2ELS36'=> "PPS-CN Production",
                    'F2ELS37'=> "Production Stock & Crusher Area",
                    'F2ELS38'=> "Die set Maintenance Storage area",
                    'F2ELSF1'=> "CN Staff",
                    'F2ELSF2'=> "NG Table",
                    'F2ELSF3'=> "NG Table",
                    'F2ELSF4'=> "Panel Control",
                    'F2ELSF5'=> "Production 1",
                    'F2ELSF6'=> "Maintenance Room",
                    'F2ELSF7'=> "Maintenance Room",
                    'F2ELSF8'=> "Dressing Room",
                    'F2ELSF9'=> "Stair",
                    'F2ELSF10'=> "Stair",
                    'F2ELSF11'=> "Packing / FGS",
                    'F2ELSF12'=> "CN Meeting room",
                    'F2ELSF13'=> "CN Prod'n",
                    'F2ELSF14'=> "Production 2",
                    'F2ELSF15'=> "CN Hallway",
                    'F2ELSF16'=> "CN Hallway",
                    'F2ELSF17'=> "Production",
                    'F2ELSF18'=> "Production",
                    'F2ELSF19'=> "Production 2",
                    'F2ELSF20'=> "Hallway",
                    'F2ELSF21'=> "Hallway",
                    'F2ELSF22'=> "CN Office",
                    'F2ELSF23'=> "Hallway",
                    'F2ELSF24'=> "Material Area",
                    'F2ELSF25'=> "Material Area",
                    'F2ELSF26'=> "Link Bridge",
                    'F2ELSF27'=> "Link Bridge",
                    'ELPPS1'=> "Molding Office ",
                    'ELPPS2'=> "Die Set Room 1",
                    'ELPPS3'=> "Die Set Room 2",
                    'ELPPS4'=> "CNC / Grinding 1",
                    'ELPPS5'=> "CNC / Grinding 2",
                    'ELPPS6'=> "Material Warehouse",
                    'ELPPS7'=> "Crasher 1",
                    'ELPPS8'=> "Crasher 2",
                    'ELPPS9'=> "Eqpt Stock room ",
                    'ELPPS10'=> "Chemical Room",
                    'ELPPS11'=> "Production 1",
                    'ELPPS12'=> "Production 2",
                    'ELPPS13'=> "Production 3",
                    'ELPPS14'=> "Production 4",
                    'ELPPS15'=> "Production 5",
                    'ELPPS16'=> "Production 6",
                    'ELPPS17'=> "Production 7",
                    'ELPPS18'=> "Hallway 1",
                    'ELPPS19'=> "Hallway 2",
                    'FXGF1'=> "Activity Room",
                    'FXGF2'=> "Clinic",
                    'FXGF3'=> "Visitor's Area",
                    'FXGF4'=> "Visitor's Area",
                    'FXGF5'=> "Hallway - Activity Room",
                    'FXGF6'=> "Hallway - HRD",
                    'FXGF7'=> "Hallway- Lobby",
                    'FXGF8'=> "Hallway- LOCKER",
                    'FXGF9'=> "ATKS",
                    'FXGF10'=> "Locker",
                    'FXGF11'=> "CN washing / Soldering",
                    'FXGF12'=> "AHU - 40 TR",
                    'FXGF13'=> "Baggage Room",
                    'FXGF14'=> "Hallway - YF",
                    'FXGF15'=> "ISS Storage Room",
                    'FXGF16'=> "Hallway - YF",
                    'FXGF17'=> "Receiving",
                    'FXGF18'=> "Hallway CN-Whse",
                    'FXGF19'=> "Locker",
                    'FXGF20'=> "CN Production",
                    'FXGF21'=> "CN ProductionL",
                    'FXGF22'=> "CN Production",
                    'FXGF23'=> "CN Production",
                    'FXGF24'=> "CN FGS",
                    'FXGF25'=> "NEC Warehouse",
                    'FXGF26'=> "NEC Warehouse",
                    'FXGF27'=> "NEC Warehouse",
                    'FXGF28'=> "NEC Warehouse",
                    'FXGF29'=> "DRIVER'S QTR",
                    'FXGF30'=> "NEC Warehouse",
                    'FXGF31'=> "Facility Storage area (SW)",
                    'FXGF32'=> "YF DRESSING ROOM",
                    'FXGF33'=> "YF Warehouse",
                    'FXGF34'=> "YF Production",
                    'FXGF35'=> "YF MAINTENANCE",
                    'FXGF36'=> "CN Prod'n Meallanox / EXT'N",
                    'FXGF37'=> "TS Production",
                    'FXGF38'=> "YF Sealing",
                    'FXGF39'=> "AIDA Machine",
                    'FXGF40'=> "FABRICATION  Area",
                    'FXGF41'=> "E-M Staff area",
                    'FXGF42'=> "Air Compressor Room",
                    'FXGF43'=> "Genset Room",
                    'FXGF44'=> "Genset Room",
                    'FXGF45'=> "Genset Room",
                    'FXGF46'=> "LPG TANK AREA",
                    'FXGF47'=> "Hallway NEC Warehouse",
                    'FXGF48'=> "Guard Gate 1",
                    'FXGF49'=> "Guard Gate 2",
                    'FXGF50'=> "Power RM. 1",
                    'FXGF51'=> "Power RM. 2",
                    'FXGF52'=> "Electrical Room  A",
                    'FXGF53'=> "Part Fabrication Area ",
                    'FXGF54'=> "Chemical Room 1",
                    'FXGF55'=> "Chemical Room 2",
                    'FXGF56'=> "FORK LIFT",
                    'FXGF57'=> "PPS Archive",
                    'FXGF58'=> "YF PRINTING",
                    'FXGF59'=> "YEC",
                    'FXGF60'=> "YEC",
                    'FXGF61'=> "Air Compressor Room (100hp)",
                    'FXGF62'=> "Chemical room",
                    'FXGF63'=> "Hallway Activity Room",
                    'FXGF64'=> "Hallway Logistics",
                    'FXGF65'=> "Hallway Locker",
                    'FXGF66'=> "Hallway YF",
                    'FXGF67'=> "YF warehouse",
                    'FXGF68'=> "Hallway CN Production",
                    'FXGF69'=> "YEC / ISS",
                    'FXPPS1'=> "PPS Office",
                    'FXPPS2'=> "Production Area",
                    'FXPPS3'=> "CNC / Grinding Room",
                    'FXPPS4'=> "CNC / Grinding Room",
                    'FXPPS5'=> "Material Warehouse",
                    'FXPPS6'=> "Equipment Room",
                    'FXPPS7'=> "Warehouse",
                    'FXPPS8'=> "Warehouse",
                    'FXPPS9'=> "Chemical Room ",
                    'FXPPS10'=> "Production Area  Surface Grinder",
                    'FXPPS11'=> "Stamping Area 1",
                    'FXPPS12'=> "Stamping Area 2",
                    'FXPPS13'=> "Production Area 1",
                    'FXPPS14'=> "Production Area 2",
                    'FXPPS15'=> "Production Area 3",
                    'FXPPS16'=> "Production Area 4",
                    'FXPPS17'=> "Warehouse",
                    'FXPPS18'=> "New Fabrication",
                    'FXSF1'=> "Vendo",
                    'FXSF2'=> "Hallway - Finance",
                    'FXSF3'=> "Canteen - FHC",
                    'FXSF4'=> "Conf. Room 3",
                    'FXSF5'=> "Conf. Room 2",
                    'FXSF6'=> "Guest Room",
                    'FXSF7'=> "Hallway - ISS",
                    'FXSF8'=> "Server",
                    'FXSF9'=> "BOD/Conf. Room 1",
                    'FXSF10'=> "DESIGN",
                    'FXSF11'=> "Hallway - DESIGN",
                    'FXSF12'=> "Hallway - Cashier",
                    'FXSF13'=> "Stair - S.W.",
                    'FXSF14'=> "Canteen - Entrance",
                    'FXSF15'=> "Kitchen",
                    'FXSF16'=> "Vendo N.W. ( Back )",
                    'FXSF17'=> "Hallway TS",
                    'FXSF18'=> "Hallway TS",
                    'FXSF19'=> "Hallway - S.W. ( back )",
                    'FXSF20'=> "TS Prod / PACKING",
                    'FXSF21'=> "TS PRODUCTION",
                    'FXSF22'=> "TS PRODUCTION",
                    'FXSF23'=> "TS PRODUCTION",
                    'FXSF24'=> "TS Office",
                    'FXSF25'=> "TS PRODUCTION",
                    'FXSF26'=> "TS PRODUCTION",
                    'FXSF27'=> "TS Training Unit",
                    'FXSF28'=> "TS WHSE / MOLD PART",
                    'FXSF29'=> "TS WHSE / Incoming Materials",
                    'FXSF30'=> "2nd Elevator",
                    'FXSF31'=> "Probe Pin Line",
                    'FXSF32'=> "TS WHSE / Contact Area",
                    'FXSF33'=> "TS WHSE / Contact Area",
                    'FXSF34'=> "Probe pin Extension",
                    'FXSF35'=> "TS WHSE",
                    'FXSF36'=> "Finance Record room",
                    'FXSF37'=> "SMOKING AREA",
                    'FXSF38'=> "Facility Storage - Hallway",
                    'FXSF39'=> "Finance Area",
                    'FXSF40'=> "TS Material Whse - EXT'N",
                    'FXSF42'=> "DCC",
                    'FXSF43'=> "TS Meeting room",
                    'FXSF44'=> "TS Engneering ",
                    'FXSF45'=> "TS FGS",
                    'FXSF46'=> "Executive Room",
                    'F2FXGF1'=> "Hallway - Canteen",
                    'F2FXGF2'=> "Hallway - Canteen",
                    'F2FXGF3'=> "CN Meeting room",
                    'F2FXGF4'=> "Function room",
                    'F2FXGF5'=> "Function room",
                    'F2FXGF6'=> "Canteen",
                    'F2FXGF7'=> "Canteen",
                    'F2FXGF8'=> "Canteen",
                    'F2FXGF9'=> "Canteen",
                    'F2FXGF10'=> "Canteen Kitchen",
                    'F2FXGF11'=> "Canteen Kitchen",
                    'F2FXGF12'=> "Canteen Kitchen",
                    'F2FXGF13'=> "Freight Elevator",
                    'F2FXGF14'=> "Kitchen",
                    'F2FXGF15'=> "QC Area",
                    'F2FXGF16'=> "Power Room",
                    'F2FXGF17'=> "Evaluation Room",
                    'F2FXGF18'=> "Meeting Room",
                    'F2FXGF19'=> "Hallway / Stair",
                    'F2FXGF20'=> "Receiving",
                    'F2FXGF21'=> "CN Warehouse",
                    'F2FXGF22'=> "CN Warehouse",
                    'F2FXGF23'=> "Warehouse",
                    'F2FXGF24'=> "Hallway",
                    'F2FXGF25'=> "Hallway",
                    'F2FXGF26'=> "Hallway",
                    'F2FXGF27'=> "Emboss",
                    'F2FXGF28'=> "PPS-CN Office",
                    'F2FXGF29'=> "Warehouse",
                    'F2FXGF30'=> "Warehouse",
                    'F2FXGF31'=> "Crusher",
                    'F2FXGF32'=> "Warehouse",
                    'F2FXGF33'=> "PPS-CN Production",
                    'F2FXGF34'=> "PPS-CN Production",
                    'F2FXGF35'=> "PPS-CN Production",
                    'F2FXGF36'=> "PPS-CN Production",
                    'F2FXGF37'=> "PPS-CN Production",
                    'F2FXGF38'=> "PPS-CN Production",
                    'F2FXGF39'=> "Hallway",
                    'F2FXSF1'=> "Hallway",
                    'F2FXSF2'=> "CN Staff",
                    'F2FXSF3'=> "Training room area",
                    'F2FXSF4'=> "Warehouse CN2",
                    'F2FXSF5'=> "Stair",
                    'F2FXSF6'=> "Parts prep",
                    'F2FXSF7'=> "Maintenance Area",
                    'F2FXSF8'=> "CN Production -A",
                    'F2FXSF9'=> "CN 2 A Production",
                    'F2FXSF10'=> "CN 2 A Production",
                    'F2FXSF11'=> "CN 2 A Production",
                    'F2FXSF12'=> "CN 2 A Production",
                    'F2FXSF13'=> "CN 2 B Production",
                    'F2FXSF14'=> "CN 2 B Production",
                    'F2FXSF15'=> "CN 2 B Production",
                    'F2FXSF16'=> "CN 2 B Production",
                    'F2FXSF17'=> "2B - Production",
                    'F2FXSF18'=> "FGS",
                    'F2FXSF19'=> "FGS",
                    'F2FXSF20'=> "2B - Production",
                    'F2FXSF21'=> "2B - Production",
                    'F2FXSF22'=> "2B - Production",
                    'F2FXSF23'=> "2B - Production",
                    'F2FXSF24'=> "2B - Production",
                    'F2FXSF25'=> "2B - Production",
                    'F2FXSF26'=> "CN 2 B Production",
                    'F2FXSF27'=> "Dressing Room",
                    'F2FXSF28'=> "Hallway",
                    'F2FXSF29'=> "Hallway",
                    'F2FXSF30'=> "Link bridge",
                    'F2FXSF31'=> "Link bridge",
                    'F2FXSF32'=> "Hallway",
                    'F2FXSF33'=> "FGS",
                    'F2FXSF34'=> "CN 2B Production",
                    'F2FXSF35'=> "CN 2B Production",
                    'F2FXSF36'=> "CN 2A Production",
                    'F2FXSF37'=> "CN 2A Production",
                    'F2FXSF38'=> "WHSE CN 2",
                    'F2FXSF39'=> "Hallway",
                    'F2FXSF40'=> "CN 2AProduction"
                ];
                
                if($request->control_no_location_id == ''){
                    $control = 'F2FXSF'; 
                    for ($i = 1; $i <= 40; $i++) {
                        $controlNumber = $control . $i;
                        
                        if (isset($test[$controlNumber])) {
                            $location = $test[$controlNumber];
                            
                            ControlNoLocation::insert([
                                'general_area_id'   => $request->general_area_id,
                                'control_no'        => $controlNumber,
                                'location'          => $location,
                                'created_at'        => now()
                            ]);
                        }        
                    }           
                }else{
                    ControlNoLocation::where('id', $request->control_no_location_id)->update([
                        'control_no'        => $request->control_number,
                        'location'          => $request->location,
                        'updated_at'        => date('Y-m-d H:i:s'),
                    ]);
                }
                // DB::commit();
                return response()->json(['hasError' => 1]);
            // }catch(\Exception $e){
                // DB::rollback();
                // return response()->json(['hasError' => 0, 'exceptionError' => $e]);
            // }
        }
    }
}
