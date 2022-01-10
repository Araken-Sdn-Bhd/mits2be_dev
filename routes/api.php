<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//PATIENT MANAGEMENT MODULE
// Fetch Registration Form Data
Route::get('getRegistrationData', 'App\Http\Controllers\PMController@getRegistrationData');
Route::get('getState', 'App\Http\Controllers\PMController@getState');
Route::get('getCity','App\Http\Controllers\PMController@getCity');
Route::get('getPostcode','App\Http\Controllers\PMController@getPostcode');

//Patient List
Route::get('getPatientList','App\Http\Controllers\PMController@getPatientList');
Route::get('getPatientAllergy','App\Http\Controllers\PMController@getPatientAllergy');

// Register Patient
Route::post('registerPatient','App\Http\Controllers\PMController@registerPatient');

// Patient Profile
Route::get('getPatientProfile','App\Http\Controllers\PMController@getPatientProfile');

//Update Patient Profile
Route::get('getPatientData','App\Http\Controllers\PMController@getPatientData');
Route::post('updatePatientData','App\Http\Controllers\PMController@updatePatientData');

//Add Vital
Route::post('addVital','App\Http\Controllers\PMController@addVital');
Route::get('getVital','App\Http\Controllers\PMController@getVital');
Route::post('deleteVital','App\Http\Controllers\PMController@deleteVital');

//Add Triage
Route::get('getPsychometricTest','App\Http\Controllers\PMController@getPsychometricTest');
Route::post('addTriage','App\Http\Controllers\PMController@addTriage');

//Appointment History
Route::get('getAppointmentHistory','App\Http\Controllers\PMController@getAppointmentHistory');

// Route::get('getRelationship','App\Http\Controllers\PMController@getRelationship');
// Route::get('getDMState', 'App\Http\Controllers\PMController@getDMState');
// Route::get('getSalutation','App\Http\Controllers\PMController@getSalutation');
// Route::get('getCitizenship','App\Http\Controllers\PMController@getCitizenship');
// Route::get('getNRICType','App\Http\Controllers\PMController@getNRICType');
// Route::get('getIssuingCountry','App\Http\Controllers\PMController@getIssuingCountry');
// Route::get('getGender','App\Http\Controllers\PMController@getGender');
// Route::get('getServiceType','App\Http\Controllers\PMController@getServiceType');
// Route::get('getReferralType','App\Http\Controllers\PMController@getReferralType');
// Route::get('getRace','App\Http\Controllers\PMController@getRace');
// Route::get('getReligion','App\Http\Controllers\PMController@getReligion');
// Route::get('getMaritalStatus','App\Http\Controllers\PMController@getMaritalStatus');
// Route::get('getAccommodation','App\Http\Controllers\PMController@getAccommodation');
// Route::get('getEducationLevel','App\Http\Controllers\PMController@getEducationLevel');
// Route::get('getOccupationStatus','App\Http\Controllers\PMController@getOccupationStatus');
// Route::get('getFeeExemptionStatus','App\Http\Controllers\PMController@getFeeExemptionStatus');
// Route::get('getOccupationSector','App\Http\Controllers\PMController@getOccupationSector');
// Route::get('getBranch','App\Http\Controllers\PMController@getBranch');

// Verify Patient
Route::get('verifyPatient','App\Http\Controllers\PMController@verifyPatient');

// Appointment Booking
Route::get('getAssignedTeam','App\Http\Controllers\PMController@getAssignedTeam');
Route::get('getAppointmentMountedData','App\Http\Controllers\PMController@getAppointmentMountedData');
Route::post('bookAppointment','App\Http\Controllers\PMController@bookAppointment');

Route::get('getService','App\Http\Controllers\PMController@getService');
Route::get('getBranch','App\Http\Controllers\PMController@getBranch');
Route::get('getAppointmentList','App\Http\Controllers\PMController@getAppointmentList');
Route::post('tickAttendance','App\Http\Controllers\PMController@tickAttendance');
Route::post('noShowAttendance','App\Http\Controllers\PMController@noShowAttendance');

Route::get('getAppointmentData','App\Http\Controllers\PMController@getAppointmentData');
Route::post('updateAppointment','App\Http\Controllers\PMController@updateAppointment');

// Delete Appointment
Route::post('deleteAppointment','App\Http\Controllers\PMController@deleteAppointment');

// Appointment Request List
Route::get('getRequestAppointmentList','App\Http\Controllers\PMController@getRequestAppointmentList');
Route::post('requestAppointmentPartialRegistration','App\Http\Controllers\PMController@requestAppointmentPartialRegistration');
Route::post('deleteRequestAppointment','App\Http\Controllers\PMController@deleteRequestAppointment');

// Psychiatry Clerking Note
Route::get('getPsychiatryClerkingNoteMountedData','App\Http\Controllers\PMController@getPsychiatryClerkingNoteMountedData');
Route::get('getServiceBasedOnCategory','App\Http\Controllers\PMController@getServiceBasedOnCategory');

// Counselling Progress Note
Route::get('getCounsellingProgressNoteMountedData','App\Http\Controllers\PMController@getCounsellingProgressNoteMountedData');

// Counselling Clerking Note
Route::get('getCounsellingClerkingNoteMountedData','App\Http\Controllers\PMController@getCounsellingClerkingNoteMountedData');

// Patient Care Plan
Route::get('getPatientCarePlanMountedData','App\Http\Controllers\PMController@getPatientCarePlanMountedData');

// Progress Note
Route::get('getProgressNoteMountedData','App\Http\Controllers\PMController@getProgressNoteMountedData');

// Progress Note
Route::get('getInternalReferralLetterMountedData','App\Http\Controllers\PMController@getInternalReferralLetterMountedData');


// Occupational Therapy Referral Form
Route::get('getOccupationalTherapyReferralFormMountedData','App\Http\Controllers\PMController@getOccupationalTherapyReferralFormMountedData');

// Consultation Discharge Note
Route::get('getConsultationDischargeNoteMountedData','App\Http\Controllers\PMController@getConsultationDischargeNoteMountedData');


//SHHARP MANAGEMENT MODULE

// Register SHHARP Demographic
Route::get('getDemographicData','App\Http\Controllers\SHController@getDemographicData');
Route::post('registerDemoSHHARP','App\Http\Controllers\SHController@registerDemoSHHARP');

// Update SHHARP Demographic
Route::get('getSHHARPDemographic','App\Http\Controllers\SHController@getSHHARPDemographic');
Route::post('updateSHHARPDemographic','App\Http\Controllers\SHController@updateSHHARPDemographic');

// Register SHHARP Form
Route::get('getSHHARPData','App\Http\Controllers\SHController@getSHHARPData');
Route::post('registerSHHARP','App\Http\Controllers\SHController@registerSHHARP');

// Update SHHARP Form
Route::get('getSHHARPFormData','App\Http\Controllers\SHController@getSHHARPFormData');
Route::post('updateSHHARP','App\Http\Controllers\SHController@updateSHHARP');

// View SHHARP Profile and History
Route::get('getSHHARPProfile','App\Http\Controllers\SHController@getSHHARPProfile');
Route::get('getSHHARPHistory','App\Http\Controllers\SHController@getSHHARPHistory');


Route::get('getSHHARPList','App\Http\Controllers\SHController@getSHHARPList');

// Route::get('getOccurance','App\Http\Controllers\SHController@getOccurance');
// Route::get('getReferral','App\Http\Controllers\SHController@getReferral');
// Route::get('getArrivalMode','App\Http\Controllers\SHController@getArrivalMode');
// Route::get('getPSYMX','App\Http\Controllers\SHController@getPSYMX');

Route::post('postTest','App\Http\Controllers\PMController@postTest');
Route::get('getTestRange','App\Http\Controllers\PMController@getTestRange');



