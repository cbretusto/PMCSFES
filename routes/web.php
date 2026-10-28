<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('pmcsfes_equipment');
})->name('pmcsfes_equipment');

Route::get('/pmcsfes_equipment', function () {
    return view('pmcsfes_equipment');
})->name('pmcsfes_equipment');

Route::get('/PMCSFES_template', function () {
    return view('PMCSFES_template');
})->name('PMCSFES_template');

Route::get('/user_list', function () {
    return view('user_list');
})->name('user_list');

// ===============================================================================================================================
// ======================================================= USER CONTROLLER =======================================================
// ===============================================================================================================================
Route::get('/view_user_list', 'UserListController@view_user_list');
Route::get('/get_employee_name', 'UserListController@get_employee_name');
Route::post('/create_update_user', 'UserListController@create_update_user');
Route::get('/get_user_info_by_id', 'UserListController@get_user_info_by_id');
Route::post('/change_user_status', 'UserListController@change_user_status');
Route::get('/get_user_log', 'UserListController@get_user_log');
Route::get('/get_noted_by', 'UserListController@get_noted_by');

// ===============================================================================================================================
// ==================================================== EQUIPMENT CONTROLLER =====================================================
// ===============================================================================================================================
Route::get('/view_device_table', 'EquipmentController@view_device_table');
Route::get('/view_device_checklist_table', 'EquipmentController@view_device_checklist_table');
Route::post('/create_update_equipment', 'EquipmentController@create_update_equipment');
Route::get('/get_device_info_by_id', 'EquipmentController@get_device_info_by_id');
Route::get('/get_device', 'EquipmentController@get_device');

// ===============================================================================================================================
// ================================================= EQUIPMENT MODEL CONTROLLER ==================================================
// ===============================================================================================================================
Route::get('/view_equipment_model_table', 'EquipmentModelController@view_equipment_model_table');
Route::post('/create_equipment_model', 'EquipmentModelController@create_equipment_model');
Route::get('/get_equipment_model_info_by_id', 'EquipmentModelController@get_equipment_model_info_by_id');
Route::post('/update_equipment_model', 'EquipmentModelController@update_equipment_model');
Route::post('/change_equipment_model_status', 'EquipmentModelController@change_equipment_model_status');
Route::get('/get_equipment_model', 'EquipmentModelController@get_equipment_model');

// ===============================================================================================================================
// ==================================================== CHECKLIST CONTROLLER =====================================================
// ===============================================================================================================================
Route::get('/view_checklist_table', 'CheckListController@view_checklist_table');
Route::post('/create_update_checklist', 'CheckListController@create_update_checklist');
Route::get('/get_checklist_info_by_id', 'CheckListController@get_checklist_info_by_id');
Route::post('/change_checklist_status', 'CheckListController@change_checklist_status');
Route::get('/get_checklist', 'CheckListController@get_checklist');

// ===============================================================================================================================
// ================================================== GENERAL AREA CONTROLLER ====================================================
// ===============================================================================================================================
Route::get('/view_general_area_table', 'GeneralAreaController@view_general_area_table');
Route::post('/create_general_area', 'GeneralAreaController@create_general_area');
Route::get('/get_general_area_info_by_id', 'GeneralAreaController@get_general_area_info_by_id');
Route::post('/update_general_area', 'GeneralAreaController@update_general_area');
Route::post('/change_general_area_status', 'GeneralAreaController@change_general_area_status');
Route::get('/get_general_area', 'GeneralAreaController@get_general_area');

// ===============================================================================================================================
// =================================== GENERAL AREA CONTROLLER ( CONTROL NO AND LOCATION )   =====================================
// ===============================================================================================================================
Route::get('/view_control_no_location_table', 'ControlNoLocationController@view_control_no_location_table');
Route::post('/create_update_control_no_location', 'ControlNoLocationController@create_update_control_no_location');
Route::post('/auto_insert', 'ControlNoLocationController@auto_insert');
Route::get('/get_control_no_location_info_by_id', 'ControlNoLocationController@get_control_no_location_info_by_id');
Route::post('/change_control_no_location_status', 'ControlNoLocationController@change_control_no_location_status');
Route::get('/get_control_no_location', 'ControlNoLocationController@get_control_no_location');

// ===============================================================================================================================
// ================================================= CLASSIFICATION CONTROLLER ===================================================
// ===============================================================================================================================
Route::get('/view_classification_table', 'ClassificationController@view_classification_table');
Route::post('/create_classification', 'ClassificationController@create_classification');
Route::get('/get_classification_info_by_id', 'ClassificationController@get_classification_info_by_id');
Route::post('/update_classification', 'ClassificationController@update_classification');
Route::post('/change_classification_status', 'ClassificationController@change_classification_status');
Route::get('/get_classification', 'ClassificationController@get_classification');

// ===============================================================================================================================
// =================================================== CHECKSHEET CONTROLLER =====================================================
// ===============================================================================================================================
Route::get('/view_checksheets_table', 'ChecksheetController@view_checksheets_table');
Route::get('/view_approval_checksheets_table', 'ChecksheetController@view_approval_checksheets_table');
Route::get('/view_approved_checksheets_table', 'ChecksheetController@view_approved_checksheets_table');
Route::get('/get_device_by_id', 'ChecksheetController@get_device_by_id');
Route::post('/add_checksheet', 'ChecksheetController@add_checksheet');
Route::get('/add_checksheet_testing', 'ChecksheetController@add_checksheet_testing');
Route::get('/export_checksheet', 'ChecksheetController@export_checksheet');
Route::get('/export_checksheet_el', 'ChecksheetController@export_checksheet_el');
Route::get('/export_checksheet_exl', 'ChecksheetController@export_checksheet_exl');
Route::get('/export_checksheet_fe', 'ChecksheetController@export_checksheet_fe');
Route::get('/export_checksheet_fh', 'ChecksheetController@export_checksheet_fh');

// ===============================================================================================================================
// ==================================================== CRITERIA CONTROLLER ======================================================
// ===============================================================================================================================
Route::get('/view_criteria_table', 'CriteriaController@view_criteria_table');
Route::get('/alter_criteria_modal_based_on_status', 'CriteriaController@alter_criteria_modal_based_on_status');
Route::get('/get_checksheet_by_id', 'CriteriaController@get_checksheet_by_id');
Route::post('/add_maintenance_result', 'CriteriaController@add_maintenance_result');
Route::post('/submit_checksheet', 'CriteriaController@submit_checksheet');
Route::post('/supervisor_approve_checksheet', 'CriteriaController@supervisor_approve_checksheet');
Route::post('/manager_approve_checksheet', 'CriteriaController@manager_approve_checksheet');

// ===============================================================================================================================
// ============================================ EMERGENCY LIGHT CRITERIA CONTROLLER ==============================================
// ===============================================================================================================================
Route::get('/view_criteria_table_el', 'CriteriaController@view_criteria_table_el');
Route::post('/add_checksheet_findings_el', 'CriteriaController@add_checksheet_findings_el');

// ===============================================================================================================================
// =============================================== EXIT LIGHT CRITERIA CONTROLLER ================================================
// ===============================================================================================================================
Route::get('/view_criteria_table_exl', 'CriteriaController@view_criteria_table_exl');
Route::post('/add_checksheet_findings_exl', 'CriteriaController@add_checksheet_findings_exl');

// ===============================================================================================================================
// =========================================== FIRE EXTINGUISHER CRITERIA CONTROLLER =============================================
// ===============================================================================================================================
Route::get('/view_criteria_table_fe', 'CriteriaController@view_criteria_table_fe');
Route::post('/add_checksheet_findings_fe', 'CriteriaController@add_checksheet_findings_fe');

// ===============================================================================================================================
// =========================================== FIRE HOSE CABINET CRITERIA CONTROLLER =============================================
// ===============================================================================================================================
Route::get('/view_criteria_table_fh', 'CriteriaController@view_criteria_table_fh');
Route::post('/add_checksheet_findings_fh', 'CriteriaController@add_checksheet_findings_fh');
