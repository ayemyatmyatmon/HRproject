<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\WebAuthnRegisterController;
use App\Http\Controllers\Auth\WebAuthnLoginController;
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



Auth::routes(['register' => false]);


Route::post('webauthn/register/options', [WebAuthnRegisterController::class, 'options'])
     ->name('webauthn.register.options');
Route::post('webauthn/register', [WebAuthnRegisterController::class, 'register'])
     ->name('webauthn.register');

Route::post('webauthn/login/options', [WebAuthnLoginController::class, 'options'])
     ->name('webauthn.login.options');
Route::post('webauthn/login', [WebAuthnLoginController::class, 'login'])
     ->name('webauthn.login');

Route::get('checkin_checkout','CheckInCheckOutController@CheckInCheckOut');
Route::post('checkin-checkout-data','CheckInCheckOutController@CheckInCheckOutStore');

Route::middleware('auth')->group(function(){
    Route::get('/','PageController@home')->name('home');

    Route::resource('employee','EmployeeController');
    Route::get('employee/datatable/ssd','EmployeeController@ssd');

    Route::get('profile','ProfileController@profile')->name('profile.profile');

    Route::resource('department','DepartmentController');
    Route::get('department/datatable/ssd','DepartmentController@ssd');

    Route::resource('attendance','AttendanceController');
    Route::get('attendance/datatable/ssd','AttendanceController@ssd');
    Route::get('attendance-overview','AttendanceController@attendanceOverview')->name('attendance-overview');
    Route::get('attendance-overview-table','AttendanceController@attendanceOverviewTable')->name('attendance-overview-table');

    Route::resource('role','RoleController');
    Route::get('role/datatable/ssd','RoleController@ssd');

    Route::resource('permission','PermissionController');
    Route::get('permission/datatable/ssd','PermissionController@ssd');

    Route::get('attendance-scan','AttendanceScanController@scan')->name('attendance-scan');
    Route::post('attendance-scan-store','AttendanceScanController@scanStore')->name('attendance-scan-store');
    Route::resource('company-setting','CompanySettingController')->only('show','edit','update');
    Route::get('my-attendance/datatable/ssd','MyAttendanceController@ssd');

    Route::resource('salary','SalaryController');
    Route::get('salary/datatable/ssd','SalaryController@ssd');

    Route::get('payroll','PayrollController@payRoll')->name('payroll');
    Route::get('payroll-table','PayrollController@payRollTable')->name('payroll-table');

    Route::get('my-payroll','MyPayrollController@ssd');
    Route::get('my-payroll-table','MyPayrollController@payRollTable')->name('payroll-table');

    Route::resource('project','ProjectController');
    Route::get('project/datatable/ssd','ProjectController@ssd');

    Route::resource('my-project','MyProjectController')->only(['index','show']);
    Route::get('my-project/datatable/ssd','MyProjectController@ssd');

    Route::resource('task', 'TaskController');
    Route::get('tasks-datas','TaskController@taskDatas');
});
