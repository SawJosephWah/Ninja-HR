<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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


Auth::routes();


Route::group(['middleware' => 'auth'], function() {
    Route::get('/','PageController@home')->name('home');

    //employee
    Route::resource('/employee', 'EmployeeController');

    Route::get('/employeeSSD','EmployeeController@allData')->name('employee.allData');

   //profile
   Route::get('/profile','profileController@index')->name('profile');

   //department
   Route::resource('/department', 'DepartmentController');

   Route::get('/departmentsSSD','DepartmentController@allData')->name('department.allData');

   //role
   Route::resource('/role', 'RoleController');

   Route::get('/roleSSD','RoleController@allData')->name('role.allData');

      //permission
      Route::resource('/permission', 'PermissionController');

      Route::get('/permissionSSD','PermissionController@allData')->name('permission.allData');

      //company setting
      Route::resource('/company_setting', 'CompanySettingController')->only([
        'edit', 'show' , 'update'
    ]);

    //cheeck-in check-out
    Route::get('/check-in-check-out','CheckincheckoutController@index');
    Route::post('/checkin','CheckincheckoutController@checkIn');

    //attendance
     Route::resource('/attendance', 'AttendanceController');

     Route::get('/attendanceSSD','AttendanceController@allData')->name('attendance.allData');

     Route::get('/attendanceOverview','AttendanceController@attendanceOverview')->name('attendance.overview');

     Route::get('/attendanceOverviewTable','AttendanceController@attendanceOverviewTable')->name(' attendance_overview_table');


    //attendance scan
     Route::get('/attendance-qr','AttendanceScanController@index')->name('attendanceScan');
     Route::post('/scan-attendance-qr','AttendanceScanController@scanAttendance')->name('ScanattendanceQr');

    //my attendance overview (attendance scan page)
     Route::get('/my-attendance','MyAttendanceController@AllData')->name('my-attendance.allData');
     Route::get('/my-attendanceOverviewTable','MyAttendanceController@MyAttendanceOverviewTable')->name(' attendance_overview_table');

     //salary
     Route::resource('/salary', 'SalaryController');
     Route::get('/salarySSD','SalaryController@allData')->name('salary.allData');

     //payroll
     Route::get('/payroll','PayrollController@index')->name('payroll.index');
     Route::get('/payrollTable','PayrollController@payrollTable');

     //my payroll (attendance scan page)
     Route::get('/my-payroll','PayrollController@myPayroll')->name('myPayroll.allData');

     //project
    Route::resource('/projects', 'ProjectsController');

    Route::get('/projectsSSD','ProjectsController@allData')->name('projects.allData');

    //My project
    Route::get('/my_project','MyProjectController@index')->name('myproject');
    Route::get('/my_projectsSSD','MyProjectController@allData')->name('my_projects.allData');
    Route::get('/my_project/{id}','MyProjectController@details');

    //task
    Route::resource('/tasks', 'TaskController');
    Route::get('/tasks_draggable','TaskController@tasksDraggable');



});
