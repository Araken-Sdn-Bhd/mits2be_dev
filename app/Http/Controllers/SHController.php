<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Exception\RequestException;

class SHController extends Controller
{
    function getDemographicData(Request $request){
        try{
            $citizenship = DB::table('setting_citizenship')
                        ->select('setting_id AS value','setting_name AS name')
                        ->get();

            $NRICType = DB::table('setting_nric_type')
                        ->select('setting_id AS value','setting_name AS name')
                        ->get();

            $issuing_country = DB::table('setting_country')
                                ->select('setting_id AS value','setting_name AS name')
                                ->get();

            $gender = DB::table('setting_gender')
                        ->select('setting_id AS value','setting_name AS name')
                        ->get();

            $employment_status = DB::table('setting_employment_status')
                                ->select('setting_id AS value', 'setting_name AS name')
                                ->get();

            $household_income = DB::table('setting_household_income')
                                ->select('setting_id AS value', 'setting_minimum AS min','setting_maximum AS max')
                                ->get();

            $ethnic = DB::table('setting_ethnicity')
                        ->select('setting_id AS value','setting_name AS name')
                        ->get();

            $religion = DB::table('setting_religion')
                        ->select('setting_id AS value','setting_name AS name')
                        ->get();

            $marital = DB::table('setting_marital')
                        ->select('setting_id AS value','setting_name AS name')
                        ->get();

            $education = DB::table('setting_education')
                            ->select('setting_id AS value','setting_name AS name')
                            ->get();

            http_response_code(200);
            return response([
                'message' => 'Data successfully Created.',
                'citizenship' => $citizenship,
                'NRICType' => $NRICType,
                'issuingCountry' => $issuing_country,
                'employmentStatus' => $employment_status,
                'householdIncome' => $household_income,
                'gender' => $gender,
                'race' => $ethnic,
                'religion' => $religion,
                'marital' => $marital,
                'education' => $education,
            ]);


        }catch (RequestException $r){
            http_response_code(400);
            return response([
                'message' => 'Failed to Create data.'
            ]);
        }
    }

    function getSHHARPDemographic(Request $request){
        try{
            $patient_id = $request->input('patientId');
            $query = DB::table('patient')
                        ->select('patient.hospital_mrn','patient.mentari_mrn','patient.name','patient.citizenship_fk','patient.nric_type_fk','patient.nric_no', 'patient.gender_fk', 'patient.birthdate','patient.ethnic_fk','patient.religion_fk','patient.marital_fk','patient.education_fk',

                        'setting_nric_type.setting_name AS nric_type',

                        'patient_passport.passport_no','patient_passport.date_expiry', 'patient_passport.issuing_country_fk',

                        'setting_country.setting_name AS issuing_country',

                        'shharp_demographic.employment_status_fk',
                        'shharp_demographic.household_income_fk',

                        'setting_employment_status.setting_name AS employment_status',
                        'setting_ethnicity.setting_name AS ethnic',
                        'setting_religion.setting_name AS religion',
                        'setting_marital.setting_name AS marital',
                        'setting_education.setting_name AS education',
                        )

                        ->leftjoin('patient_passport', 'patient.patient_id', '=', 'patient_passport.patient_fk')
                        ->leftjoin('setting_country', 'setting_country.setting_id', '=', 'patient_passport.issuing_country_fk')
                        ->leftjoin('shharp_demographic','patient.patient_id','=','shharp_demographic.patient_fk')

                        ->leftjoin('setting_nric_type', 'setting_nric_type.setting_id', '=', 'patient.nric_type_fk')
                        ->leftjoin('setting_employment_status', 'setting_employment_status.setting_id', '=', 'shharp_demographic.employment_status_fk')
                        ->leftjoin('setting_household_income', 'setting_household_income.setting_id', '=', 'shharp_demographic.household_income_fk')
                        ->leftjoin('setting_ethnicity', 'setting_ethnicity.setting_id', '=', 'patient.ethnic_fk')
                        ->leftjoin('setting_religion', 'setting_religion.setting_id', '=', 'patient.religion_fk')
                        ->leftjoin('setting_marital', 'setting_marital.setting_id', '=', 'patient.marital_fk')
                        ->leftjoin('setting_education', 'setting_education.setting_id', '=', 'patient.education_fk')

                        ->where('patient.patient_id', $patient_id)
                        ->orderBy('patient_passport.timestamp_create', 'DESC')
                        ->first();



            http_response_code(200);
            return response([
                'message' => 'Data successfully Created.',
                'data' => $query,
            ]);


        }catch (RequestException $r){
            http_response_code(400);
            return response([
                'message' => 'Failed to Create data.'
            ]);
        }
    }

    function getSHHARPProfile(Request $request){
        try{
            $patient_id = $request->input('patientId');
            $query = DB::table('patient')
                        ->select('patient.mits_mrn','patient.hospital_mrn','patient.mentari_mrn','patient.name','patient.citizenship_fk','setting_gender.setting_name AS gender','patient.birthdate','patient.phone_no_1','setting_marital.setting_name AS marital',

                        'patient_passport.issuing_country_fk', 'setting_country.setting_name AS issuing_country',

                        'setting_employment_status.setting_name AS employment_status',

                        'setting_household_income.setting_minimum AS min','setting_household_income.setting_maximum AS max',

                        'vital.height','vital.weight','vital.bmi','vital.temperature','vital.blood_pressure','vital.pulse_rate','vital.waist_circumference','vital.timestamp_create')

                        ->leftjoin('setting_gender', 'patient.gender_fk', '=', 'setting_gender.setting_id')
                        ->leftjoin('setting_marital', 'patient.marital_fk', '=', 'setting_marital.setting_id')
                        ->leftjoin('setting_country', 'patient.citizenship_fk', '=', 'setting_country.setting_id')

                        ->leftjoin('patient_passport','patient.patient_id','=','patient_passport.patient_fk')

                        ->leftjoin('shharp_demographic','patient.patient_id','=','shharp_demographic.patient_fk')

                        ->leftjoin('setting_employment_status','shharp_demographic.employment_status_fk','=','setting_employment_status.setting_id')
                        ->leftjoin('setting_household_income','shharp_demographic.household_income_fk','=','setting_household_income.setting_id')

                        ->leftjoin('vital','patient.patient_id','=','vital.patient_fk')

                        ->where('patient.patient_id', $patient_id)
                        ->orderBy('vital.timestamp_create', 'DESC')
                        ->first();

            http_response_code(200);
            return response([
                'message' => 'Data successfully Created.',
                'data' => $query,
            ]);


        }catch (RequestException $r){
            http_response_code(400);
            return response([
                'message' => 'Failed to Create data.'
            ]);
        }
    }

    function registerDemoSHHARP(Request $request){
        try{
            $ptData = json_decode($request->input("ptData"));

            //patient table
            $mits_mrn = !empty(str_replace('-', '', $ptData->NRIC_NO)) ? str_replace('-', '', $ptData->NRIC_NO): $ptData->PASSPORT_NO;
            $hospital_mrn = !empty($ptData->HOSPITAL_MRN) ? $ptData->HOSPITAL_MRN: NULL;
            $mentari_mrn = !empty($ptData->MENTARI_MRN) ? $ptData->MENTARI_MRN: NULL;
            $name = !empty($ptData->SH_NAME) ? $ptData->SH_NAME: NULL;
            $citizenship = !empty($ptData->CITIZENSHIP) ? $ptData->CITIZENSHIP: NULL;
            $nric_type = !empty($ptData->NRIC_TYPE->value) ? $ptData->NRIC_TYPE->value: NULL;
            $nric_no = !empty(str_replace('-', '', $ptData->NRIC_NO)) ? str_replace('-', '', $ptData->NRIC_NO): NULL;
            $gender = !empty($ptData->GENDER) ? $ptData->GENDER: NULL;
            $employment_status = !empty($ptData->EMPLOYMENT_STATUS->value) ? $ptData->EMPLOYMENT_STATUS->value: NULL;
            $household_income = !empty($ptData->INCOME_STATUS->value) ? $ptData->INCOME_STATUS->value: NULL;
            $birthdate = !empty($ptData->BIRTH_DATE) ? $ptData->BIRTH_DATE: NULL;
            $ethnic = !empty($ptData->RACE->value) ? $ptData->RACE->value: NULL;
            $religion = !empty($ptData->RELIGION->value) ? $ptData->RELIGION->value: NULL;
            $marital = !empty($ptData->MARITAL_STATUS->value) ? $ptData->MARITAL_STATUS->value: NULL;
            $accommodation = !empty($ptData->ACCOMMODATION->value) ? $ptData->ACCOMMODATION->value: NULL;
            $education =  !empty($ptData->EDUCATION_LEVEL->value) ? $ptData->EDUCATION_LEVEL->value: NULL;

            //patient
            $patientData = array('mits_mrn' =>$mits_mrn,'hospital_mrn' =>$hospital_mrn, 'mentari_mrn' =>$mentari_mrn, 'name' =>$name, 'citizenship_fk' => $citizenship, 'nric_type_fk' => $nric_type,'nric_no' => $nric_no, 'gender_fk' => $gender, 'birthdate' => $birthdate,'ethnic_fk' => $ethnic, 'religion_fk' => $religion, 'marital_fk' => $marital,'accommodation_fk' => $accommodation, 'education_fk' => $education);

            $patient_id = DB::table('patient')-> insertGetId($patientData);

            // patient_passport
            $passport_no = !empty($ptData->PASSPORT_NO) ? $ptData->PASSPORT_NO: NULL;
            $passport_expiry = !empty($ptData->PASSPORT_EXPIRY_DATE) ? $ptData->PASSPORT_EXPIRY_DATE: NULL;
            $issuing_country = !empty($ptData->ISSUING_COUNTRY->value) ? $ptData->ISSUING_COUNTRY->value: NULL;

            if($citizenship === 3){
                $passportData = array('patient_fk' => $patient_id,'passport_no' => $passport_no, 'date_expiry' => $passport_expiry,
                                    'issuing_country_fk' => $issuing_country);

                $patient_passport_id = DB::table('patient_passport')-> insertGetId($passportData);
            }
            else{
                $patient_passport_id = NULL;
            }

            //shharp_demographic
            $shharp_demographic_id = DB::table('shharp_demographic')
                                    -> insertGetId(
                                        array('patient_fk' => $patient_id,'employment_status_fk' =>$employment_status, 'household_income_fk' => $household_income));

            // shharp
            // $shharp_id = DB::table('shharp')
            //             -> insertGetId(array('patient_fk' =>$patient_id));

            http_response_code(200);
            return response([
                'message' => 'Data successfully Created.',
                'patientId' => $patient_id,
                'patientPassportId' => $patient_passport_id,
                //'shharpId' => $shharp_id
            ]);


        }catch (RequestException $r){
            http_response_code(400);
            return response([
                'message' => 'Failed to Create data.'
            ]);
        }
    }

    function updateSHHARPDemographic(Request $request){
        try{
            $ptData = json_decode($request->input("ptData"));
            $patient_id = $request->input('patientId');

            //patient table
            $hospital_mrn = !empty($ptData->HOSPITAL_MRN) ? $ptData->HOSPITAL_MRN: NULL;
            $mentari_mrn = !empty($ptData->MENTARI_MRN) ? $ptData->MENTARI_MRN: NULL;
            $name = !empty($ptData->SH_NAME) ? $ptData->SH_NAME: NULL;
            $citizenship = !empty($ptData->CITIZENSHIP) ? $ptData->CITIZENSHIP: NULL;
            $nric_type = !empty($ptData->NRIC_TYPE->value) ? $ptData->NRIC_TYPE->value: NULL;
            $nric_no = !empty(str_replace('-', '', $ptData->NRIC_NO)) ? str_replace('-', '', $ptData->NRIC_NO): NULL;
            $gender = !empty($ptData->GENDER) ? $ptData->GENDER: NULL;
            $employment_status = !empty($ptData->EMPLOYMENT_STATUS->value) ? $ptData->EMPLOYMENT_STATUS->value: NULL;
            $household_income = !empty($ptData->INCOME_STATUS->value) ? $ptData->INCOME_STATUS->value: NULL;
            $birthdate = !empty($ptData->BIRTH_DATE) ? $ptData->BIRTH_DATE: NULL;
            $ethnic = !empty($ptData->RACE->value) ? $ptData->RACE->value: NULL;
            $religion = !empty($ptData->RELIGION->value) ? $ptData->RELIGION->value: NULL;
            $marital = !empty($ptData->MARITAL_STATUS->value) ? $ptData->MARITAL_STATUS->value: NULL;
            $accommodation = !empty($ptData->ACCOMMODATION->value) ? $ptData->ACCOMMODATION->value: NULL;
            $education =  !empty($ptData->EDUCATION_LEVEL->value) ? $ptData->EDUCATION_LEVEL->value: NULL;

            //patient
            $patientData = array('hospital_mrn' =>$hospital_mrn, 'mentari_mrn' =>$mentari_mrn, 'name' =>$name, 'citizenship_fk' => $citizenship, 'nric_type_fk' => $nric_type,'nric_no' => $nric_no, 'gender_fk' => $gender, 'birthdate' => $birthdate,'ethnic_fk' => $ethnic, 'religion_fk' => $religion, 'marital_fk' => $marital,'accommodation_fk' => $accommodation, 'education_fk' => $education);

            DB::table('patient')
                -> where('patient_id',$patient_id)
                -> update($patientData);

            // patient_passport
            $patient_passport_id = NULL;

            if($citizenship === 3){
                $passport_no = !empty($ptData->PASSPORT_NO) ? $ptData->PASSPORT_NO: NULL;
                $passport_expiry = !empty($ptData->PASSPORT_EXPIRY_DATE) ? $ptData->PASSPORT_EXPIRY_DATE: NULL;
                $issuing_country = !empty($ptData->ISSUING_COUNTRY->value) ? $ptData->ISSUING_COUNTRY->value: NULL;

                if(DB::table('patient_passport')->where('passport_no', $passport_no)->exists()){
                }else{
                    $passportData = array('patient_fk' => $patient_id,'passport_no' => $passport_no, 'date_expiry' => $passport_expiry,'issuing_country_fk' => $issuing_country);
                    $patient_passport_id = DB::table('patient_passport')-> insertGetId($passportData);

                }
            }

            //shharp_demographic

            if(DB::table('shharp_demographic')->where('patient_fk', $patient_id)->exists()){
                $shharpDemoId = NULL;
                DB::table('shharp_demographic')
                -> where('patient_fk',$patient_id)
                -> update(array('employment_status_fk' =>$employment_status, 'household_income_fk' => $household_income));
            }
            else{
                $shharpDemoId = DB::table('shharp_demographic')
                                    -> insertGetId(array('patient_fk'=> $patient_id, 'employment_status_fk' => $employment_status, 'household_income_fk' => $household_income));
            }

            http_response_code(200);
            return response([
                'message' => 'Data successfully Updated.',
                'patientId' => $patient_id,
                'patientPassportId' => $patient_passport_id,
                'shharpDemoId' => $shharpDemoId
            ]);


        }catch (RequestException $r){
            http_response_code(400);
            return response([
                'message' => 'Failed to Create data.'
            ]);
        }
    }

    function getSHHARPData(Request $request){
        try{
            $place_occurance = DB::table('setting_place_occurance')
                        ->select('setting_id AS value','setting_name AS name')
                        ->get();

            $method = DB::table('setting_self_harm_method')
                        ->select('setting_id AS value','setting_name AS name')
                        ->get();

            $overdoseType = DB::table('setting_overdose')
                        ->select('setting_id AS value','setting_name AS name')
                        ->get();

            $idea = DB::table('setting_self_harm_idea')
                        ->select('setting_id AS value','setting_name AS name')
                        ->get();

            $intent = DB::table('setting_self_harm_intent')
                        ->select('setting_id AS value','setting_name AS name')
                        ->get();

            $referral = DB::table('setting_shharp_referral')
                        ->select('setting_id AS value','setting_name AS name')
                        ->get();

            $mode_arrival = DB::table('setting_mode_arrival')
                        ->select('setting_id AS value','setting_name AS name')
                        ->get();

            $psy_mx= DB::table('setting_psy_mx')
                        ->select('setting_id AS value','setting_name AS name')
                        ->get();

            http_response_code(200);
            return response([
                'message' => 'Data successfully Created.',
                'occurance' => $place_occurance,
                'method' => $method,
                'overdoseType' => $overdoseType,
                'idea' => $idea,
                'intent' => $intent,
                'referral' => $referral,
                'modeArrival' => $mode_arrival,
                'psyMX' => $psy_mx,
            ]);


        }catch (RequestException $r){
            http_response_code(400);
            return response([
                'message' => 'Failed to Create data.'
            ]);
        }

    }

    function registerSHHARP(Request $request){
        try{

            $shData = json_decode($request->input("shData"));
            $form_status = $request->input('formStatus');

            //shharp table
            $patient_id = $request->input('patientId');

            //risk factors
            $rf_1 = !empty($shData->Q1) ? $shData->Q1: NULL;
            $rf_1_desc = !empty($shData->Q1_SPECIFY) ? implode(",", $shData->Q1_SPECIFY): NULL;
            $rf_2 = !empty($shData->Q2) ? $shData->Q2: NULL;
            $rf_3 = !empty($shData->Q3) ? $shData->Q3: NULL;
            $rf_3_desc = !empty($shData->Q3_SPECIFY) ? $shData->Q3_SPECIFY: NULL;
            $rf_4 = !empty($shData->Q4) ? $shData->Q4: NULL;
            $rf_4_desc = !empty($shData->Q4_SPECIFY->value) ? $shData->Q4_SPECIFY->value: NULL;
            $rf_5 = !empty($shData->Q5) ? $shData->Q5: NULL;
            $rf_6 = !empty($shData->Q6) ? $shData->Q6: NULL;
            $rf_6_desc = !empty($shData->Q6_SPECIFY) ? implode(",", $shData->Q6_SPECIFY): NULL;
            $rf_7 = !empty($shData->Q7) ? $shData->Q7: NULL;
            $rf_7_desc = !empty($shData->Q7_SPECIFY->value) ? $shData->Q7_SPECIFY->value: NULL;
            $rf_8 = !empty($shData->Q8) ? $shData->Q8: NULL;
            $rf_8_desc = !empty($shData->Q8_SPECIFY->value) ? $shData->Q8_SPECIFY->value: NULL;
            $rf_9 = !empty($shData->Q9) ? $shData->Q9: NULL;
            $rf_10 = !empty($shData->Q10) ? $shData->Q10: NULL;
            $rf_10_desc = !empty($shData->Q10_SPECIFY) ? implode(",", $shData->Q10_SPECIFY): NULL;
            $rf_11 = !empty($shData->Q11) ? $shData->Q11: NULL;
            $rf_12 = !empty($shData->Q12) ? $shData->Q12: NULL;

            //protective factors
            $pf_1 = !empty($shData->PQ1) ? $shData->PQ1: NULL;
            $pf_2 = !empty($shData->PQ2) ? $shData->PQ2: NULL;
            $pf_3 = !empty($shData->PQ3) ? $shData->PQ3: NULL;
            $pf_4 = !empty($shData->PQ4) ? $shData->PQ4: NULL;
            $pf_5 = !empty($shData->PQ5) ? $shData->PQ5: NULL;
            $pf_6 = !empty($shData->PQ6) ? $shData->PQ6: NULL;

            //THE SELF-HARM AND SUICIDAL INTENT
            //section A
            $sh_act_date = !empty($shData->SH_DATE) ? $shData->SH_DATE: NULL;
            $sh_act_time = !empty($shData->SH_TIME) ? $shData->SH_TIME: NULL;
            $sh_place_occurance = !empty($shData->OCCUR->value) ? $shData->OCCUR->value: NULL;
            $sh_place_occurance_desc = !empty($shData->OCCUR_OTHER_SPECIFY) ? $shData->OCCUR_OTHER_SPECIFY: NULL;

            //section B
            $sh_method = $shData->METHOD;

            //section C
            $sh_idea = $shData->IDEA;

            //section D
            $sh_intent_exist = !empty($shData->INTENT) ? $shData->INTENT: NULL;
            $sh_intent_yes = $shData->INTENT_YES;

            //section E
            $sh_level_1 = !empty($shData->SH1) || ($shData->SH1==0) ? $shData->SH1: NULL;
            $sh_level_2 = !empty($shData->SH2) || ($shData->SH2==0) ? $shData->SH1: NULL;
            $sh_level_3 = !empty($shData->SH3) || ($shData->SH3==0) ? $shData->SH1: NULL;
            $sh_level_4 =  !empty($shData->SH4) || ($shData->SH4==0) ? $shData->SH1: NULL;
            $sh_level_5 = !empty($shData->SH5) || ($shData->SH5==0) ? $shData->SH1: NULL;
            $sh_level_6 = !empty($shData->SH6) || ($shData->SH6==0) ? $shData->SH1: NULL;
            $sh_level_7 = !empty($shData->SH7) || ($shData->SH7==0) ? $shData->SH1: NULL;
            $sh_level_8 = !empty($shData->SH8) || ($shData->SH8==0) ? $shData->SH1: NULL;
            $sh_level_9 = !empty($shData->SH9) || ($shData->SH9==0) ? $shData->SH1: NULL;
            $sh_level_10 = !empty($shData->SH10) || ($shData->SH10==0) ? $shData->SH1: NULL;
            $sh_level_11 = !empty($shData->SH11) || ($shData->SH11==0) ? $shData->SH1: NULL;
            $sh_level_12 = !empty($shData->SH12) || ($shData->SH12==0) ? $shData->SH1: NULL;
            $sh_level_13 = !empty($shData->SH13) || ($shData->SH13==0) ? $shData->SH1: NULL;
            $sh_level_14 = !empty($shData->SH14) || ($shData->SH14==0) ? $shData->SH1: NULL;
            $sh_level_15 = !empty($shData->SH15) || ($shData->SH15==0) ? $shData->SH1: NULL;

            $sh_level_score = !empty($shData->INTENT_SCORE) ? $shData->INTENT_SCORE: NULL;

            //suicide risk
            $suicide_risk = $shData->SR_LEVEL;

            //hospital management
            $referral = !empty($shData->REFERRAL->value) ? $shData->REFERRAL->value: NULL;
            $referral_specify = !empty($shData->REFERRAL_SPECIFY) ? $shData->REFERRAL_SPECIFY: NULL;
            $arrival_mode = !empty($shData->ARRIVAL_MODE->value) ? $shData->ARRIVAL_MODE->value: NULL;
            $arrival_specify = !empty($shData->ARRIVAL_SPECIFY) ? $shData->ARRIVAL_SPECIFY: NULL;
            $first_assessment_date = !empty($shData->FIRST_ASSESSMENT_DATE) ? $shData->FIRST_ASSESSMENT_DATE: NULL;
            $first_assessment_time = !empty($shData->FIRST_ASSESSMENT_TIME) ? $shData->FIRST_ASSESSMENT_TIME: NULL;
            $physical_conseq = $shData->PHYSICAL_CONSEQ;
            $physical_conseq_specify = !empty($shData->PHYSICAL_CONSEQ_SPECIFY) ? $shData->PHYSICAL_CONSEQ_SPECIFY: NULL;
            $admission = $shData->ADMISSION;
            $admission_specify = !empty($shData->ADMISSION_SPECIFY) ? $shData->ADMISSION_SPECIFY: NULL;
            $discharge_status = $shData->DISCHARGE_STATUS;
            $discharge_date = !empty($shData->DISCHARGE_DATE) ? $shData->DISCHARGE_DATE: NULL;
            $no_of_days = $shData->NO_OF_DAYS;
            $main_diagnosis = !empty($shData->MAIN_DIAGNOSIS) ? $shData->MAIN_DIAGNOSIS: NULL;
            $external_diagnosis = !empty($shData->EXTERNAL_DIAGNOSIS) ? $shData->EXTERNAL_DIAGNOSIS: NULL;

            $psymx = $shData->PSYMX;

            //source data producer
            $officer_name = !empty($shData->REG_OFF_NAME) ? $shData->REG_OFF_NAME: NULL;
            $designation = !empty($shData->DESIGNATION) ? $shData->DESIGNATION: NULL;
            $date_reporting = !empty($shData->REPORT_DATE) ? $shData->REPORT_DATE: NULL;
            $hospital_name = !empty($shData->HOSPITAL_NAME) ? $shData->HOSPITAL_NAME: NULL;
            $date_verification = !empty($shData->VERIFICATION_DATE) ? $shData->VERIFICATION_DATE: NULL;
            $psychiatrist_name = !empty($shData->PSYCHIATRIST_NAME) ? $shData->PSYCHIATRIST_NAME: NULL;

            $shharpData = array('patient_fk' => $patient_id, 'rf1' => $rf_1, 'rf1_desc' => $rf_1_desc, 'rf2' => $rf_2,
                                'rf3' => $rf_3, 'rf3_desc' => $rf_3_desc, 'rf4' => $rf_4, 'rf4_desc' => $rf_4_desc,
                                'rf5' => $rf_5, 'rf6' => $rf_6, 'rf6_desc' => $rf_6_desc, 'rf7' => $rf_7, 'rf7_desc' => $rf_7_desc,
                                'rf8' => $rf_8, 'rf8_desc' => $rf_8_desc, 'rf9' => $rf_9, 'rf10' => $rf_10, 'rf10_desc' => $rf_10_desc,
                                'rf11' => $rf_11, 'rf12' => $rf_12,

                                'pf1' => $pf_1, 'pf2' => $pf_2, 'pf3' => $pf_3, 'pf4' => $pf_4, 'pf5' => $pf_5, 'pf6' => $pf_6,

                                'sh_act_date' => $sh_act_date, 'sh_act_time' => $sh_act_time, 'place_occurance_fk' => $sh_place_occurance,
                                'place_occurance_desc' => $sh_place_occurance_desc,

                                'sh_intent_exist' => $sh_intent_exist,

                                'sh_level_1' => $sh_level_1, 'sh_level_2' => $sh_level_2, 'sh_level_3' => $sh_level_3,
                                'sh_level_4' => $sh_level_4, 'sh_level_5' => $sh_level_5, 'sh_level_6' => $sh_level_6,
                                'sh_level_7' => $sh_level_7, 'sh_level_8' => $sh_level_8, 'sh_level_9' => $sh_level_9,
                                'sh_level_10' => $sh_level_10, 'sh_level_11' => $sh_level_11,'sh_level_12' => $sh_level_12,
                                'sh_level_13' => $sh_level_13, 'sh_level_14' => $sh_level_14, 'sh_level_15' => $sh_level_15,
                                'sh_level_score' => $sh_level_score,

                                'sr_level' => $suicide_risk,

                                'referral_fk' => $referral, 'referral_desc' => $referral_specify,
                                'mode_arrival_fk' => $arrival_mode, 'mode_arrival_desc' => $arrival_specify,
                                'hm_date_first_psychiatry' => $first_assessment_date, 'hm_time_first_psychiatry' => $first_assessment_time,
                                'hm_physical_consequence' => $physical_conseq, 'hm_physical_consequence_desc' => $physical_conseq_specify,
                                'hm_admitted' => $admission, 'hm_admitted_desc' => $admission_specify, 'hm_discharge_status' => $discharge_status,
                                'hm_discharge_date' => $discharge_date, 'hm_days_warded' => $no_of_days,
                                'hm_discharge_diagnosis_main' => $main_diagnosis, 'hm_discharge_diagnosis_external' => $external_diagnosis,

                                'sd_officer_name' => $officer_name, 'sd_officer_designation' => $designation,
                                'sd_hospital_name' => $hospital_name, 'sd_psychiatrist_name' => $psychiatrist_name,
                                'sd_date_reporting' => $date_reporting,'sd_date_verification' => $date_verification,

                                'shharp_form_status' => $form_status);

            $shharp_id = DB::table('shharp')-> insertGetId($shharpData);

            // shharp_self_harm_method
            foreach ($sh_method as $method) {
                if($method === 1){
                    $sh_overdose_type = $shData->OVERDOSE_TYPE->value;
                    $sh_overdose_type_specify = $shData->OVERDOSE_TYPE_SPECIFY;

                    $methods =  DB::table('shharp_self_harm_method')
                        ->insert(
                            array('shharp_fk' => $shharp_id, 'self_harm_method_fk' => $method, 'overdose_type_fk' => $sh_overdose_type, 'self_harm_method_desc' => $sh_overdose_type_specify)
                            );

                }
                else if ($method === 99){
                    $sh_method_desc = $shData->METHOD_OTHER_SPECIFY;

                    $methods =  DB::table('shharp_self_harm_method')
                        ->insert(
                            array('shharp_fk' => $shharp_id, 'self_harm_method_fk' => $method, 'self_harm_method_desc' => $sh_method_desc)
                            );
                }
                else{
                    $methods =  DB::table('shharp_self_harm_method')
                        ->insert(
                            array('shharp_fk' => $shharp_id, 'self_harm_method_fk' => $method)
                            );
                }
            }

            // shharp_self_harm_idea
            foreach ($sh_idea as $idea) {
                if ($idea === 99){
                    $sh_idea_patient_actual_words_desc = $shData->IDEA_SPECIFY;

                    $ideas =  DB::table('shharp_self_harm_idea')
                        ->insert(
                            array('shharp_fk' => $shharp_id, 'self_harm_idea_fk' => $idea, 'self_harm_idea_desc' => $sh_idea_patient_actual_words_desc)
                            );
                }
                else{
                    $ideas =  DB::table('shharp_self_harm_idea')
                        ->insert(
                            array('shharp_fk' => $shharp_id, 'self_harm_idea_fk' => $idea)
                            );
                }
            }

            // shharp_self_harm_intent
            if($sh_intent_exist === 2){
                foreach ($sh_intent_yes as $intent) {
                    if ($intent === 99){
                        $sh_intent_other_specify = $shData->INTENT_OTHER_SPECIFY;

                        $intents =  DB::table('shharp_self_harm_intent')
                            ->insert(
                                array('shharp_fk' => $shharp_id, 'self_harm_intent_fk' => $intent, 'self_harm_intent_desc' =>  $sh_intent_other_specify)
                                );
                    }
                    else{
                        $intents =  DB::table('shharp_self_harm_intent')
                            ->insert(
                                array('shharp_fk' => $shharp_id, 'self_harm_intent_fk' => $intent)
                                );
                    }
                }
            }

            // shharp_hm_psy_mx
            foreach ($psymx as $psy) {
                if($psy === 6){
                    $psymx_specify = $shData->PSYMX_SPECIFY;

                    DB::table('shharp_hm_psy_mx')
                        ->insert(
                            array('shharp_fk' => $shharp_id, 'hm_psy_mx_fk' => $psy, 'hm_psy_mx_desc' => $psymx_specify)
                            );
                }
                else{
                    DB::table('shharp_hm_psy_mx')
                    ->insert(
                        array('shharp_fk' => $shharp_id, 'hm_psy_mx_fk' => $psy)
                        );
                }
            }

            http_response_code(200);
            return response([
                'message' => 'Data successfully Created.',
                'shharpId' => $shharp_id,
            ]);


        }catch (RequestException $r){
            http_response_code(400);
            return response([
                'message' => 'Failed to Create data.'
            ]);
        }
    }

    function getSHHARPHistory(Request $request){
        try{
            $patient_id = $request->input('patientId');

            $query = DB::table('shharp')
                ->select('shharp_id','timestamp_create','timestamp_update','shharp_form_status','sd_hospital_name','sd_officer_name')
                ->where('patient_fk', $patient_id)
                ->orderBy('timestamp_create', 'DESC')
                ->orderBy('timestamp_update', 'DESC')
                ->get();

            http_response_code(200);
            return response([
                'message' => 'Data successfully Created.',
                'data' => $query
            ]);


        }catch (RequestException $r){
            http_response_code(400);
            return response([
                'message' => 'Failed to Create data.'
            ]);
        }
    }

    function getSHHARPFormData(Request $request){
        try{
            $shharp_id = $request->input('shharpId');

            $query = DB::table('shharp')
                ->select('shharp.*','setting_place_occurance.setting_name AS occurance',
                'setting_shharp_referral.setting_name AS referral',
                'setting_mode_arrival.setting_name AS arrival',)

                ->leftJoin('setting_place_occurance', 'shharp.place_occurance_fk', '=', 'setting_place_occurance.setting_id')
                ->leftJoin('setting_shharp_referral', 'shharp.referral_fk', '=', 'setting_shharp_referral.setting_id')
                ->leftJoin('setting_mode_arrival', 'shharp.mode_arrival_fk', '=', 'setting_mode_arrival.setting_id')
                ->where('shharp_id', $shharp_id)
                ->get();

            $method = DB::table('shharp_self_harm_method')
                        ->select('shharp_self_harm_method.self_harm_method_fk','shharp_self_harm_method.overdose_type_fk','shharp_self_harm_method.self_harm_method_desc',

                        'setting_overdose.setting_name AS overdose'
                        )
                        ->leftJoin('setting_overdose', 'shharp_self_harm_method.overdose_type_fk', '=', 'setting_overdose.setting_id')

                        ->where('shharp_fk',$shharp_id)
                        ->get();

            $idea = DB::table('shharp_self_harm_idea')
                        ->select('self_harm_idea_fk','self_harm_idea_desc')
                        ->where('shharp_fk',$shharp_id)
                        ->get();

            $intent = DB::table('shharp_self_harm_intent')
                        ->select('self_harm_intent_fk','self_harm_intent_desc')
                        ->where('shharp_fk',$shharp_id)
                        ->get();

            $psy_mx = DB::table('shharp_hm_psy_mx')
                        ->select('hm_psy_mx_fk','hm_psy_mx_desc')
                        ->where('shharp_fk',$shharp_id)
                        ->get();

            http_response_code(200);
            return response([
                'message' => 'Data successfully Created.',
                'data' => $query,
                'method' => $method,
                'idea' => $idea,
                'intent' => $intent,
                'psy_mx' => $psy_mx,
            ]);


        }catch (RequestException $r){
            http_response_code(400);
            return response([
                'message' => 'Failed to Create data.'
            ]);
        }
    }

    function updateSHHARP(Request $request){
        try{

            $shData = json_decode($request->input("shData"));
            $form_status = $request->input('formStatus');

            //shharp table
            $shharp_id = $request->input('shharpId');

            //risk factors
            $rf_1 = !empty($shData->Q1) ? $shData->Q1: NULL;
            $rf_1_desc = !empty($shData->Q1_SPECIFY) ? implode(",", $shData->Q1_SPECIFY): NULL;
            $rf_2 = !empty($shData->Q2) ? $shData->Q2: NULL;
            $rf_3 = !empty($shData->Q3) ? $shData->Q3: NULL;
            $rf_3_desc = !empty($shData->Q3_SPECIFY) ? $shData->Q3_SPECIFY: NULL;
            $rf_4 = !empty($shData->Q4) ? $shData->Q4: NULL;
            $rf_4_desc = !empty($shData->Q4_SPECIFY->value) ? $shData->Q4_SPECIFY->value: NULL;
            $rf_5 = !empty($shData->Q5) ? $shData->Q5: NULL;
            $rf_6 = !empty($shData->Q6) ? $shData->Q6: NULL;
            $rf_6_desc = !empty($shData->Q6_SPECIFY) ? implode(",", $shData->Q6_SPECIFY): NULL;
            $rf_7 = !empty($shData->Q7) ? $shData->Q7: NULL;
            $rf_7_desc = !empty($shData->Q7_SPECIFY->value) ? $shData->Q7_SPECIFY->value: NULL;
            $rf_8 = !empty($shData->Q8) ? $shData->Q8: NULL;
            $rf_8_desc = !empty($shData->Q8_SPECIFY->value) ? $shData->Q8_SPECIFY->value: NULL;
            $rf_9 = !empty($shData->Q9) ? $shData->Q9: NULL;
            $rf_10 = !empty($shData->Q10) ? $shData->Q10: NULL;
            $rf_10_desc = !empty($shData->Q10_SPECIFY) ? implode(",", $shData->Q10_SPECIFY): NULL;
            $rf_11 = !empty($shData->Q11) ? $shData->Q11: NULL;
            $rf_12 = !empty($shData->Q12) ? $shData->Q12: NULL;

            //protective factors
            $pf_1 = !empty($shData->PQ1) ? $shData->PQ1: NULL;
            $pf_2 = !empty($shData->PQ2) ? $shData->PQ2: NULL;
            $pf_3 = !empty($shData->PQ3) ? $shData->PQ3: NULL;
            $pf_4 = !empty($shData->PQ4) ? $shData->PQ4: NULL;
            $pf_5 = !empty($shData->PQ5) ? $shData->PQ5: NULL;
            $pf_6 = !empty($shData->PQ6) ? $shData->PQ6: NULL;

            //THE SELF-HARM AND SUICIDAL INTENT
            //section A
            $sh_act_date = !empty($shData->SH_DATE) ? $shData->SH_DATE: NULL;
            $sh_act_time = !empty($shData->SH_TIME) ? $shData->SH_TIME: NULL;
            $sh_place_occurance = !empty($shData->OCCUR->value) ? $shData->OCCUR->value: NULL;
            $sh_place_occurance_desc = !empty($shData->OCCUR_OTHER_SPECIFY) ? $shData->OCCUR_OTHER_SPECIFY: NULL;

            //section B
            $sh_method = $shData->METHOD;

            //section C
            $sh_idea = $shData->IDEA;

            //section D
            $sh_intent_exist = !empty($shData->INTENT) ? $shData->INTENT: NULL;
            $sh_intent_yes = $shData->INTENT_YES;

            //section E
            $sh_level_1 = !empty($shData->SH1) || ($shData->SH1==0) ? $shData->SH1: NULL;
            $sh_level_2 = !empty($shData->SH2) || ($shData->SH2==0) ? $shData->SH1: NULL;
            $sh_level_3 = !empty($shData->SH3) || ($shData->SH3==0) ? $shData->SH1: NULL;
            $sh_level_4 =  !empty($shData->SH4) || ($shData->SH4==0) ? $shData->SH1: NULL;
            $sh_level_5 = !empty($shData->SH5) || ($shData->SH5==0) ? $shData->SH1: NULL;
            $sh_level_6 = !empty($shData->SH6) || ($shData->SH6==0) ? $shData->SH1: NULL;
            $sh_level_7 = !empty($shData->SH7) || ($shData->SH7==0) ? $shData->SH1: NULL;
            $sh_level_8 = !empty($shData->SH8) || ($shData->SH8==0) ? $shData->SH1: NULL;
            $sh_level_9 = !empty($shData->SH9) || ($shData->SH9==0) ? $shData->SH1: NULL;
            $sh_level_10 = !empty($shData->SH10) || ($shData->SH10==0) ? $shData->SH1: NULL;
            $sh_level_11 = !empty($shData->SH11) || ($shData->SH11==0) ? $shData->SH1: NULL;
            $sh_level_12 = !empty($shData->SH12) || ($shData->SH12==0) ? $shData->SH1: NULL;
            $sh_level_13 = !empty($shData->SH13) || ($shData->SH13==0) ? $shData->SH1: NULL;
            $sh_level_14 = !empty($shData->SH14) || ($shData->SH14==0) ? $shData->SH1: NULL;
            $sh_level_15 = !empty($shData->SH15) || ($shData->SH15==0) ? $shData->SH1: NULL;

            $sh_level_score = !empty($shData->INTENT_SCORE) ? $shData->INTENT_SCORE: NULL;

            //suicide risk
            $suicide_risk = $shData->SR_LEVEL;

            //hospital management
            $referral = !empty($shData->REFERRAL->value) ? $shData->REFERRAL->value: NULL;
            $referral_specify = !empty($shData->REFERRAL_SPECIFY) ? $shData->REFERRAL_SPECIFY: NULL;
            $arrival_mode = !empty($shData->ARRIVAL_MODE->value) ? $shData->ARRIVAL_MODE->value: NULL;
            $arrival_specify = !empty($shData->ARRIVAL_SPECIFY) ? $shData->ARRIVAL_SPECIFY: NULL;
            $first_assessment_date = !empty($shData->FIRST_ASSESSMENT_DATE) ? $shData->FIRST_ASSESSMENT_DATE: NULL;
            $first_assessment_time = !empty($shData->FIRST_ASSESSMENT_TIME) ? $shData->FIRST_ASSESSMENT_TIME: NULL;
            $physical_conseq = $shData->PHYSICAL_CONSEQ;
            $physical_conseq_specify = !empty($shData->PHYSICAL_CONSEQ_SPECIFY) ? $shData->PHYSICAL_CONSEQ_SPECIFY: NULL;
            $admission = $shData->ADMISSION;
            $admission_specify = !empty($shData->ADMISSION_SPECIFY) ? $shData->ADMISSION_SPECIFY: NULL;
            $discharge_status = $shData->DISCHARGE_STATUS;
            $discharge_date = !empty($shData->DISCHARGE_DATE) ? $shData->DISCHARGE_DATE: NULL;
            $no_of_days = $shData->NO_OF_DAYS;
            $main_diagnosis = !empty($shData->MAIN_DIAGNOSIS) ? $shData->MAIN_DIAGNOSIS: NULL;
            $external_diagnosis = !empty($shData->EXTERNAL_DIAGNOSIS) ? $shData->EXTERNAL_DIAGNOSIS: NULL;

            $psymx = $shData->PSYMX;

            //source data producer
            $officer_name = !empty($shData->REG_OFF_NAME) ? $shData->REG_OFF_NAME: NULL;
            $designation = !empty($shData->DESIGNATION) ? $shData->DESIGNATION: NULL;
            $date_reporting = !empty($shData->REPORT_DATE) ? $shData->REPORT_DATE: NULL;
            $hospital_name = !empty($shData->HOSPITAL_NAME) ? $shData->HOSPITAL_NAME: NULL;
            $date_verification = !empty($shData->VERIFICATION_DATE) ? $shData->VERIFICATION_DATE: NULL;
            $psychiatrist_name = !empty($shData->PSYCHIATRIST_NAME) ? $shData->PSYCHIATRIST_NAME: NULL;

            $shharpData = array('rf1' => $rf_1, 'rf1_desc' => $rf_1_desc, 'rf2' => $rf_2,
                                'rf3' => $rf_3, 'rf3_desc' => $rf_3_desc, 'rf4' => $rf_4, 'rf4_desc' => $rf_4_desc,
                                'rf5' => $rf_5, 'rf6' => $rf_6, 'rf6_desc' => $rf_6_desc, 'rf7' => $rf_7, 'rf7_desc' => $rf_7_desc,
                                'rf8' => $rf_8, 'rf8_desc' => $rf_8_desc, 'rf9' => $rf_9, 'rf10' => $rf_10, 'rf10_desc' => $rf_10_desc,
                                'rf11' => $rf_11, 'rf12' => $rf_12,

                                'pf1' => $pf_1, 'pf2' => $pf_2, 'pf3' => $pf_3, 'pf4' => $pf_4, 'pf5' => $pf_5, 'pf6' => $pf_6,

                                'sh_act_date' => $sh_act_date, 'sh_act_time' => $sh_act_time, 'place_occurance_fk' => $sh_place_occurance,
                                'place_occurance_desc' => $sh_place_occurance_desc,

                                'sh_intent_exist' => $sh_intent_exist,

                                'sh_level_1' => $sh_level_1, 'sh_level_2' => $sh_level_2, 'sh_level_3' => $sh_level_3,
                                'sh_level_4' => $sh_level_4, 'sh_level_5' => $sh_level_5, 'sh_level_6' => $sh_level_6,
                                'sh_level_7' => $sh_level_7, 'sh_level_8' => $sh_level_8, 'sh_level_9' => $sh_level_9,
                                'sh_level_10' => $sh_level_10, 'sh_level_11' => $sh_level_11,'sh_level_12' => $sh_level_12,
                                'sh_level_13' => $sh_level_13, 'sh_level_14' => $sh_level_14, 'sh_level_15' => $sh_level_15,
                                'sh_level_score' => $sh_level_score,

                                'sr_level' => $suicide_risk,

                                'referral_fk' => $referral, 'referral_desc' => $referral_specify,
                                'mode_arrival_fk' => $arrival_mode, 'mode_arrival_desc' => $arrival_specify,
                                'hm_date_first_psychiatry' => $first_assessment_date, 'hm_time_first_psychiatry' => $first_assessment_time,
                                'hm_physical_consequence' => $physical_conseq, 'hm_physical_consequence_desc' => $physical_conseq_specify,
                                'hm_admitted' => $admission, 'hm_admitted_desc' => $admission_specify, 'hm_discharge_status' => $discharge_status,
                                'hm_discharge_date' => $discharge_date, 'hm_days_warded' => $no_of_days,
                                'hm_discharge_diagnosis_main' => $main_diagnosis, 'hm_discharge_diagnosis_external' => $external_diagnosis,

                                'sd_officer_name' => $officer_name, 'sd_officer_designation' => $designation,
                                'sd_hospital_name' => $hospital_name, 'sd_psychiatrist_name' => $psychiatrist_name,
                                'sd_date_reporting' => $date_reporting,'sd_date_verification' => $date_verification,

                                'shharp_form_status' => $form_status);

            DB::table('shharp')
                -> where('shharp_id', $shharp_id)
                -> update($shharpData);

            // shharp_self_harm_method
            DB::table('shharp_self_harm_method')
                -> where('shharp_fk', $shharp_id)
                -> delete();

            foreach ($sh_method as $method) {
                if($method === 1){
                    $sh_overdose_type = $shData->OVERDOSE_TYPE->value;
                    $sh_overdose_type_specify = $shData->OVERDOSE_TYPE_SPECIFY;

                    $methods =  DB::table('shharp_self_harm_method')
                        ->insert(
                            array('shharp_fk' => $shharp_id, 'self_harm_method_fk' => $method, 'overdose_type_fk' => $sh_overdose_type, 'self_harm_method_desc' => $sh_overdose_type_specify)
                            );

                }
                else if ($method === 99){
                    $sh_method_desc = $shData->METHOD_OTHER_SPECIFY;

                    $methods =  DB::table('shharp_self_harm_method')
                        ->insert(
                            array('shharp_fk' => $shharp_id, 'self_harm_method_fk' => $method, 'self_harm_method_desc' => $sh_method_desc)
                            );
                }
                else{
                    $methods =  DB::table('shharp_self_harm_method')
                        ->insert(
                            array('shharp_fk' => $shharp_id, 'self_harm_method_fk' => $method)
                            );
                }
            }

            // shharp_self_harm_idea
            DB::table('shharp_self_harm_idea')
                -> where('shharp_fk', $shharp_id)
                -> delete();

            foreach ($sh_idea as $idea) {
                if ($idea === 99){
                    $sh_idea_patient_actual_words_desc = $shData->IDEA_SPECIFY;

                    $ideas =  DB::table('shharp_self_harm_idea')
                        ->insert(
                            array('shharp_fk' => $shharp_id, 'self_harm_idea_fk' => $idea, 'self_harm_idea_desc' => $sh_idea_patient_actual_words_desc)
                            );
                }
                else{
                    $ideas =  DB::table('shharp_self_harm_idea')
                        ->insert(
                            array('shharp_fk' => $shharp_id, 'self_harm_idea_fk' => $idea)
                            );
                }
            }

            // shharp_self_harm_intent
            DB::table('shharp_self_harm_intent')
                -> where('shharp_fk', $shharp_id)
                -> delete();

            if($sh_intent_exist === 2){
                foreach ($sh_intent_yes as $intent) {
                    if ($intent === 99){
                        $sh_intent_other_specify = $shData->INTENT_OTHER_SPECIFY;

                        $intents =  DB::table('shharp_self_harm_intent')
                            ->insert(
                                array('shharp_fk' => $shharp_id, 'self_harm_intent_fk' => $intent, 'self_harm_intent_desc' =>  $sh_intent_other_specify)
                                );
                    }
                    else{
                        $intents =  DB::table('shharp_self_harm_intent')
                            ->insert(
                                array('shharp_fk' => $shharp_id, 'self_harm_intent_fk' => $intent)
                                );
                    }
                }
            }

            // shharp_hm_psy_mx
            DB::table('shharp_hm_psy_mx')
                -> where('shharp_fk', $shharp_id)
                -> delete();

            foreach ($psymx as $psy) {
                if($psy === 6){
                    $psymx_specify = $shData->PSYMX_SPECIFY;

                    DB::table('shharp_hm_psy_mx')
                        ->insert(
                            array('shharp_fk' => $shharp_id, 'hm_psy_mx_fk' => $psy, 'hm_psy_mx_desc' => $psymx_specify)
                            );
                }
                else{
                    DB::table('shharp_hm_psy_mx')
                    ->insert(
                        array('shharp_fk' => $shharp_id, 'hm_psy_mx_fk' => $psy)
                        );
                }
            }

            http_response_code(200);
            return response([
                'message' => 'Data successfully Created.',
                'shharpId' => $shharp_id,
            ]);


        }catch (RequestException $r){
            http_response_code(400);
            return response([
                'message' => 'Failed to Create data.'
            ]);
        }
    }

    function getSHHARPList(Request $request){
        try{

            $list = DB::select('SELECT t1.shharp_id AS shharp_id
                                FROM shharp t1
                                WHERE t1.timestamp_create = (SELECT MAX(t2.timestamp_create)
                                                FROM shharp t2
                                                WHERE t2.patient_fk = t1.patient_fk)');
            $list = collect($list)->map(function($x){ return $x->shharp_id; })->toArray();

            $query = DB::table('patient')
                        ->select('patient.patient_id AS patient_id', 'shharp.shharp_id AS shharp_id',
                                    (DB::RAW('COALESCE(patient.name, "") AS name')), 'patient.birthdate AS age',
                                    (DB::raw('CONCAT(COALESCE(patient.nric_no, ""), COALESCE(patient_passport.passport_no, "")) AS nricPassport')),
                                    'shharp.timestamp_create as date', 'shharp.shharp_form_status AS status',
                                    'setting_branch.branch_name AS mentari', (DB::RAW('COALESCE(shharp.sh_act_date, "") AS selfHarmDate')) )

                            ->whereIn('shharp.shharp_id', $list)
                            ->leftJoin('patient_passport', 'patient.patient_id', '=', 'patient_passport.patient_fk')
                            ->leftJoin('patient_branch', function ($join) {
                                $join->on('patient.patient_id', '=', 'patient_branch.patient_fk')
                                    ->leftJoin('setting_branch', 'patient_branch.branch_fk', '=', 'setting_branch.setting_id');
                            })
                            ->leftJoin('shharp', 'patient.patient_id', '=', 'shharp.patient_fk');


            $list2 = DB::select('SELECT patient_fk
                        FROM shharp');

            $list2 = collect($list2)->map(function($x){ return $x->patient_fk; })->toArray();

            $query2 = DB::table('patient')
                        ->select('patient.patient_id AS patient_id', 'shharp.shharp_id AS shharp_id',
                                    (DB::RAW('COALESCE(patient.name, "") AS name')), 'patient.birthdate AS age',
                                    (DB::raw('CONCAT(COALESCE(patient.nric_no, ""), COALESCE(patient_passport.passport_no, "")) AS nricPassport')),
                                    'shharp.timestamp_create as date', 'shharp.shharp_form_status AS status',
                                    'setting_branch.branch_name AS mentari', (DB::RAW('COALESCE(shharp.sh_act_date, "") AS selfHarmDate')) )

                            ->whereNotIn('patient.patient_id', $list2)
                            ->leftJoin('patient_passport', 'patient.patient_id', '=', 'patient_passport.patient_fk')
                            ->leftJoin('patient_branch', function ($join) {
                                $join->on('patient.patient_id', '=', 'patient_branch.patient_fk')
                                    ->leftJoin('setting_branch', 'patient_branch.branch_fk', '=', 'setting_branch.setting_id');
                            })
                            ->leftJoin('shharp', 'patient.patient_id', '=', 'shharp.patient_fk');

            $final_query = $query->union($query2)->orderBy('name')->get();

            http_response_code(200);
            return response([
                'message' => 'Data successfully Created.',
                'list' => $final_query
            ]);


        }catch (RequestException $r){
            http_response_code(400);
            return response([
                'message' => 'Failed to Create data.'
            ]);
        }
    }

    // function getOccurance(Request $request){
    //     try{
    //         $query = DB::table('setting_place_occurance')
    //                     ->select('setting_id AS value','setting_name AS name')
    //                     ->get();

    //         http_response_code(200);
    //         return response([
    //             'message' => 'Data successfully Created.',
    //             'data' => $query
    //         ]);


    //     }catch (RequestException $r){
    //         http_response_code(400);
    //         return response([
    //             'message' => 'Failed to Create data.'
    //         ]);
    //     }
    // }

    // function getReferral(Request $request){
    //     try{
    //         $query = DB::table('setting_shharp_referral')
    //                     ->select('setting_id AS value','setting_name AS name')
    //                     ->get();

    //         http_response_code(200);
    //         return response([
    //             'message' => 'Data successfully Created.',
    //             'data' => $query
    //         ]);


    //     }catch (RequestException $r){
    //         http_response_code(400);
    //         return response([
    //             'message' => 'Failed to Create data.'
    //         ]);
    //     }
    // }

    // function getArrivalMode(Request $request){
    //     try{
    //         $query = DB::table('setting_mode_arrival')
    //                     ->select('setting_id AS value','setting_name AS name')
    //                     ->get();

    //         http_response_code(200);
    //         return response([
    //             'message' => 'Data successfully Created.',
    //             'data' => $query
    //         ]);


    //     }catch (RequestException $r){
    //         http_response_code(400);
    //         return response([
    //             'message' => 'Failed to Create data.'
    //         ]);
    //     }
    // }

    // function getPSYMX(Request $request){
    //     try{
    //         $query = DB::table('setting_psy_mx')
    //                     ->select('setting_id AS value','setting_name AS name')
    //                     ->get();

    //         http_response_code(200);
    //         return response([
    //             'message' => 'Data successfully Created.',
    //             'data' => $query
    //         ]);


    //     }catch (RequestException $r){
    //         http_response_code(400);
    //         return response([
    //             'message' => 'Failed to Create data.'
    //         ]);
    //     }
    // }
}
