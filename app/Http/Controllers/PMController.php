<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Exception\RequestException;

class PMController extends Controller
{

    function getRegistrationData(Request $request){
        try{
            // DEMOGRAPHIC
            $salutation = DB::table('setting_salutation')
                        ->select('setting_id AS value','setting_name AS name')
                        ->get();

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

            $service_type = DB::table('setting_service')
                            ->select('setting_id AS value','setting_name AS name')
                            ->whereNull('service_category_fk')
                            ->get();

            $referral_type = DB::table('setting_referral')
                            ->select('setting_id AS value','setting_name AS name')
                            ->get();

            $country_id = $request->input('country_id');
            $state = DB::table('setting_state')
                        ->select('setting_id AS value','setting_name AS name')
                        ->where('setting_country_fk',$country_id)
                        ->get();

            $branch = DB::table('setting_branch')
                        ->select('setting_id AS value','branch_name AS name')
                        ->get();

            // SOSIO DEMOGRAPHIC
            $ethnic = DB::table('setting_ethnicity')
                        ->select('setting_id AS value','setting_name AS name')
                        ->get();

            $religion = DB::table('setting_religion')
                        ->select('setting_id AS value','setting_name AS name')
                        ->get();

            $marital = DB::table('setting_marital')
                        ->select('setting_id AS value','setting_name AS name')
                        ->get();

            $accommodation = DB::table('setting_accommodation')
                            ->select('setting_id AS value','setting_name AS name')
                            ->get();

            $education = DB::table('setting_education')
                            ->select('setting_id AS value','setting_name AS name')
                            ->get();

            $occ_status = DB::table('setting_occupation_status')
                            ->select('setting_id AS value','setting_name AS name')
                            ->get();

            $fee_exemption = DB::table('setting_fee_exemption')
                            ->select('setting_id AS value','setting_name AS name')
                            ->get();

            $occ_sector = DB::table('setting_occupation_sector')
                            ->select('setting_id AS value','setting_name AS name')
                            ->get();

            // NEXT OF KIN
            $relationship = DB::table('setting_relationship')
                            ->select('setting_id AS value','setting_name AS name')
                            ->get();

            http_response_code(200);
            return response([
                'message' => 'Data successfully Created.',
                'salutation' => $salutation,
                'citizenship' => $citizenship,
                'NRICType' => $NRICType,
                'issuingCountry' => $issuing_country,
                'gender' => $gender,
                'serviceType' => $service_type,
                'referralType' => $referral_type ,
                'state' => $state,
                'branch' => $branch,
                'race' => $ethnic,
                'religion' => $religion,
                'marital' => $marital,
                'accommodation' => $accommodation,
                'education' => $education,
                'occStatus' => $occ_status,
                'feeExemption' => $fee_exemption,
                'occSector' => $occ_sector,
                'relationship' => $relationship,
            ]);

        }catch (RequestException $r){
            http_response_code(400);
            return response([
                'message' => 'Failed to Create data.'
            ]);
        }
    }

    function getState(Request $request){
        try{
            $country_id = $request->input('country_id');
            $query = DB::table('setting_state')
                        ->select('setting_id AS value','setting_name AS name')
                        ->where('setting_country_fk',$country_id)
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

    function getCity(Request $request){
        try{
            $state_id = $request->input('state_id');
            $query = DB::table('setting_city')
                        ->select('setting_id AS value','setting_name AS name')
                        ->where('setting_state_fk',$state_id)
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

    function getPostcode(Request $request){
        try{
            $city_id = $request->input('city_id');
            $query = DB::table('setting_postcode')
                        ->select('setting_id AS value','setting_name AS name')
                        ->where('city_fk',$city_id)
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

    function getRelationship(Request $request){
        try{
            $query = DB::table('setting_relationship')
                        ->select('setting_id AS value','setting_name AS name')
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

    function getSalutation(Request $request){
        try{
            $query = DB::table('setting_salutation')
                        ->select('setting_id AS value','setting_name AS name')
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

    function getCitizenship(Request $request){
        try{
            $query = DB::table('setting_citizenship')
                        ->select('setting_id AS value','setting_name AS name')
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

    function getNRICType(Request $request){
        try{
            $query = DB::table('setting_nric_type')
                        ->select('setting_id AS value','setting_name AS name')
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

    function getIssuingCountry(Request $request){
        try{
            $query = DB::table('setting_country')
                        ->select('setting_id AS value','setting_name AS name')
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

    function getGender(Request $request){
        try{
            $query = DB::table('setting_gender')
                        ->select('setting_id AS value','setting_name AS name')
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

    function getServiceType(Request $request){
        try{
            $query = DB::table('setting_service')
                        ->select('setting_id AS value','setting_name AS name')
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

    function getReferralType(Request $request){
        try{
            $query = DB::table('setting_referral')
                        ->select('setting_id AS value','setting_name AS name')
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

    function getRace(Request $request){
        try{
            $query = DB::table('setting_ethnicity')
                        ->select('setting_id AS value','setting_name AS name')
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

    function getReligion(Request $request){
        try{
            $query = DB::table('setting_religion')
                        ->select('setting_id AS value','setting_name AS name')
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

    function getMaritalStatus(Request $request){
        try{
            $query = DB::table('setting_marital')
                        ->select('setting_id AS value','setting_name AS name')
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

    function getAccommodation(Request $request){
        try{
            $query = DB::table('setting_accommodation')
                        ->select('setting_id AS value','setting_name AS name')
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

    function getEducationLevel(Request $request){
        try{
            $query = DB::table('setting_education')
                        ->select('setting_id AS value','setting_name AS name')
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

    function getOccupationStatus(Request $request){
        try{
            $query = DB::table('setting_occupation_status')
                        ->select('setting_id AS value','setting_name AS name')
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

    function getFeeExemptionStatus(Request $request){
        try{
            $query = DB::table('setting_fee_exemption')
                        ->select('setting_id AS value','setting_name AS name')
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

    function getOccupationSector(Request $request){
        try{
            $query = DB::table('setting_occupation_sector')
                        ->select('setting_id AS value','setting_name AS name')
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

    function getBranch(Request $request){
        try{
            $query = DB::table('setting_branch')
                        ->select('setting_id AS value','branch_name AS name')
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

    function registerPatient(Request $request){
        try{

            $ptData = json_decode($request->input("ptData"));

            //patient table
            $mits_mrn = !empty(str_replace('-', '', $ptData->NRIC_NO)) ? str_replace('-', '', $ptData->NRIC_NO): $ptData->PASSPORT_NO;
            $hospital_mrn = !empty($ptData->HOSPITAL_MRN) ? $ptData->HOSPITAL_MRN: NULL;
            $mentari_mrn = !empty($ptData->MENTARI_MRN) ? $ptData->MENTARI_MRN: NULL;
            $salutation = !empty($ptData->SALUTATION->value) ? $ptData->SALUTATION->value: NULL;
            $name = !empty($ptData->DM_NAME) ? $ptData->DM_NAME: NULL;
            $citizenship = !empty($ptData->CITIZENSHIP) ? $ptData->CITIZENSHIP: NULL;
            $nric_type = !empty($ptData->NRIC_TYPE->value) ? $ptData->NRIC_TYPE->value: NULL;
            $nric_no = !empty(str_replace('-', '', $ptData->NRIC_NO)) ? str_replace('-', '', $ptData->NRIC_NO): NULL;
            $gender = !empty($ptData->GENDER) ? $ptData->GENDER: NULL;
            $birthdate = !empty($ptData->BIRTH_DATE) ? $ptData->BIRTH_DATE: NULL;
            $phone_no = !empty(str_replace(' ', '', $ptData->DM_MOBILE_NO)) ? str_replace(' ', '', $ptData->DM_MOBILE_NO): NULL;
            $house_no = !empty(str_replace(' ', '', $ptData->DM_HOUSE_NO)) ? str_replace(' ', '', $ptData->DM_HOUSE_NO): NULL;
            $referral = !empty($ptData->REFERRAL_TYPE->value) ? $ptData->REFERRAL_TYPE->value: NULL;
            $referral_desc = !empty($ptData->SPECIFY_REFERRAL) ? $ptData->SPECIFY_REFERRAL: NULL;
            $ethnic = !empty($ptData->RACE->value) ? $ptData->RACE->value: NULL;
            $religion = !empty($ptData->RELIGION->value) ? $ptData->RELIGION->value: NULL;
            $marital = !empty($ptData->MARITAL_STATUS->value) ? $ptData->MARITAL_STATUS->value: NULL;
            $accommodation = !empty($ptData->ACCOMMODATION->value) ? $ptData->ACCOMMODATION->value: NULL;
            $education =  !empty($ptData->EDUCATION_LEVEL->value) ? $ptData->EDUCATION_LEVEL->value: NULL;
            $fee_exemption = !empty($ptData->FEE_EXEMPTION_STATUS->value) ? $ptData->FEE_EXEMPTION_STATUS->value: NULL;
            $occ_status = !empty($ptData->OCCUPATION_STATUS->value) ? $ptData->OCCUPATION_STATUS->value: NULL;
            $occ_sector = !empty($ptData->OCCUPATION_SECTOR->value) ? $ptData->OCCUPATION_SECTOR->value: NULL;
            $status = !empty($ptData->EXISTING_PATIENT) ? $ptData->EXISTING_PATIENT: NULL;

            $patientData = array('mits_mrn' =>$mits_mrn, 'hospital_mrn' =>$hospital_mrn, 'mentari_mrn' =>$mentari_mrn,
                            'salutation_fk' => $salutation,'name' =>$name, 'citizenship_fk' => $citizenship, 'nric_type_fk' => $nric_type,
                            'nric_no' => $nric_no, 'gender_fk' => $gender, 'birthdate' => $birthdate, 'phone_no_1' => $phone_no,
                            'phone_no_2' => $house_no, 'referral_fk' => $referral, 'referral_desc' => $referral_desc,
                            'ethnic_fk' => $ethnic, 'religion_fk' => $religion, 'marital_fk' => $marital,
                            'accommodation_fk' => $accommodation, 'education_fk' => $education, 'fee_exemption_fk' => $fee_exemption,
                            'occupation_status_fk' => $occ_status, 'occupation_sector_fk' => $occ_sector, 'status_fk' => $status);

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

            //patient_services
            $services = !empty($ptData->SERVICE_TYPE->value) ? $ptData->SERVICE_TYPE->value: NULL;

            $servicesData = array('patient_fk' => $patient_id,'service_fk' => $services);

            $patient_services_id = DB::table('patient_services')-> insertGetId($servicesData);

            //patient_address
            $current_address = 1;
            $address_1 = !empty($ptData->DM_ADDRESS_LINE_1) ? $ptData->DM_ADDRESS_LINE_1: NULL;
            $address_2 = !empty($ptData->DM_ADDRESS_LINE_2) ? $ptData->DM_ADDRESS_LINE_2: NULL;
            $address_3 = !empty($ptData->DM_ADDRESS_LINE_3) ? $ptData->DM_ADDRESS_LINE_3: NULL;
            $state = !empty($ptData->DM_STATE->value) ? $ptData->DM_STATE->value: NULL;
            $city = !empty($ptData->DM_CITY->value) ? $ptData->DM_CITY->value: NULL;
            $postcode = !empty($ptData->DM_POSTCODE->value) ? $ptData->DM_POSTCODE->value: NULL;

            $addressData = array('patient_fk' => $patient_id, 'current_address' => $current_address, 'address1' => $address_1,
                                    'address2' => $address_2, 'address3' => $address_3, 'state_fk' => $state, 'city_fk' => $city,
                                    'postcode_fk' => $postcode);

            $patient_address_id = DB::table('patient_address')-> insertGetId($addressData);

            //patient_document


            //patient_branch
            $branch = !empty($ptData->BRANCH->value) ? $ptData->BRANCH->value: NULL;
            $current_branch = 1;
            $date_register = date("Y-m-d");

            $branchData = array('patient_fk' => $patient_id, 'current_branch' => $current_branch, 'branch_fk' => $branch,
            'date_register' => $date_register);

            $patient_branch_id = DB::table('patient_branch')-> insertGetId($branchData);

            //patient_allergy
            $allergy = !empty($ptData->ALLERGY) ? $ptData->ALLERGY: NULL;

            $patient_allergy_1_id = NULL;
            $patient_allergy_2_id = NULL;
            $patient_allergy_3_id = NULL;

            if(!empty($allergy)){
                if($allergy[0] == 1){
                    $allergy_type_1 = 1;
                    $allergy_desc_1 = !empty($ptData->DRUG_ALL_SPECIFY) ? $ptData->DRUG_ALL_SPECIFY: NULL;
                    $drugAllergyData = array('patient_fk' => $patient_id, 'allergy_type_fk' => $allergy_type_1, 'allergy_desc' => $allergy_desc_1);
                    $patient_allergy_1_id = DB::table('patient_allergy')-> insertGetId($drugAllergyData);
                }
                if($allergy[1] == 1){
                    $allergy_type_2 = 2;
                    $allergy_desc_2 = !empty($ptData->SUPP_ALL_SPECIFY) ? $ptData->SUPP_ALL_SPECIFY: NULL;
                    $suppAllergyData = array('patient_fk' => $patient_id, 'allergy_type_fk' => $allergy_type_2, 'allergy_desc' => $allergy_desc_2);
                    $patient_allergy_2_id = DB::table('patient_allergy')-> insertGetId($suppAllergyData);
                }
                if($allergy[2] == 1){
                    $allergy_type_3 = 3;
                    $allergy_desc_3 = !empty($ptData->OTHERS_SPECIFY) ? $ptData->OTHERS_SPECIFY: NULL;
                    $othAllergyData = array('patient_fk' => $patient_id, 'allergy_type_fk' => $allergy_type_3, 'allergy_desc' => $allergy_desc_3);
                    $patient_allergy_3_id = DB::table('patient_allergy')-> insertGetId($othAllergyData);
                }
            }

            //patient_relationship
            $nok_relation = !empty($ptData->NOK_RELATIONSHIP->value) ? $ptData->NOK_RELATIONSHIP->value: NULL;
            $nok_name =  !empty($ptData->NOK_NAME) ? $ptData->NOK_NAME: NULL;
            $nok_phone_no = !empty(str_replace(' ', '', $ptData->NOK_MOBILE_NO)) ? str_replace(' ', '', $ptData->NOK_MOBILE_NO): NULL;
            $nok_house_no = !empty(str_replace(' ', '', $ptData->NOK_HOUSE_NO)) ? str_replace(' ', '', $ptData->NOK_HOUSE_NO): NULL;
            $nok_address1 = !empty($ptData->NOK_ADDRESS_L1) ? $ptData->NOK_ADDRESS_L1: NULL;
            $nok_address2 = !empty($ptData->NOK_ADDRESS_L2) ? $ptData->NOK_ADDRESS_L2: NULL;
            $nok_address3 = !empty($ptData->NOK_ADDRESS_L3) ? $ptData->NOK_ADDRESS_L3: NULL;
            $nok_state = !empty($ptData->NOK_STATE->value) ? $ptData->NOK_STATE->value: NULL;
            $nok_city = !empty($ptData->NOK_CITY->value) ? $ptData->NOK_CITY->value: NULL;
            $nok_postcode = !empty($ptData->NOK_POSTCODE->value) ? $ptData->NOK_POSTCODE->value: NULL;

            $nokAddressData = array('patient_fk' => $patient_id, 'relation_fk' => $nok_relation, 'name' => $nok_name,
                                    'phone_no_1' => $nok_phone_no, 'phone_no_2' => $nok_house_no, 'address1' => $nok_address1,
                                    'address2' => $nok_address2, 'address3' => $nok_address3, 'state_fk' => $nok_state,
                                    'city_fk' => $nok_city, 'postcode_fk' => $nok_postcode);

            $nok_address_id = DB::table('patient_relationship')-> insertGetId($nokAddressData);

            http_response_code(200);
            return response([
                'message' => 'Data successfully Created.',
                'patientId' => $patient_id,
                'patientPassportId' => $patient_passport_id,
                'patientServicesId' => $patient_services_id,
                'patientAddressId' => $patient_address_id,
                'patientRelationshipId' => $nok_address_id,
                'patientBranch' => $patient_branch_id,
                'patientAllergy1' => $patient_allergy_1_id,
                'patientAllergy2' => $patient_allergy_2_id,
                'patientAllergy3' => $patient_allergy_3_id
            ]);


        }catch (RequestException $r){
            http_response_code(400);
            return response([
                'message' => 'Failed to Create data.'
            ]);
        }
    }

    function getAppointmentMountedData(Request $request){
        try{
            $visit_type = DB::table('setting_visit_type')
                        ->select('setting_id AS value','setting_name AS name')
                        ->get();

            $patient_category = DB::table('setting_patient_category')
                        ->select('setting_id AS value','setting_name AS name')
                        ->get();

            $appointment_type = DB::table('setting_appointment_type')
                        ->select('setting_id AS value','setting_name AS name')
                        ->get();

            $appointment_duration = DB::table('setting_appointment_duration')
                        ->select('setting_id AS value','setting_name AS name')
                        ->get();


            http_response_code(200);
            return response([
                'message' => 'Data successfully Created.',
                'visitType' => $visit_type,
                'patientCategory' => $patient_category,
                'appointmentType' => $appointment_type,
                'appointmentDuration' => $appointment_duration,
            ]);


        }catch (RequestException $r){
            http_response_code(400);
            return response([
                'message' => 'Failed to Create data.'
            ]);
        }
    }

    function getAssignedTeam(Request $request){
        try{
            $patient_category_id = $request->input('id');

            $query = DB::table('setting_team')
                        ->select('setting_id AS value','team_name AS name')
                        ->where('patient_category_fk', $patient_category_id)
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

    function verifyPatient(Request $request){
        try{
            $nric_passport_no = $request->input('id');
            $patient_nric_fk = DB::table('patient')
                        ->select('patient_id AS value')
                        ->where('nric_no', $nric_passport_no)
                        ->get();

            $patient_passport_fk = DB::table('patient_passport')
                        ->select('patient_fk AS value')
                        ->where('passport_no', $nric_passport_no)
                        ->get();

            $patient_fk = "";
            if(count($patient_nric_fk)){
                $patient_fk = $patient_nric_fk;
            }
            if(count($patient_passport_fk)){
                $patient_fk = $patient_passport_fk;
            }

            http_response_code(200);
            return response([
                'message' => 'Data successfully Created.',
                'data' => $patient_fk
            ]);


        }catch (RequestException $r){
            http_response_code(400);
            return response([
                'message' => 'Failed to Create data.',

            ]);
        }
    }

    function bookAppointment(Request $request){
        try{

            $appt_data = json_decode($request->input("apptData"));

            $date = !empty($appt_data->DATE) ? $appt_data->DATE: NULL;
            $time = !empty($appt_data->TIME) ? $appt_data->TIME: NULL;
            $duration = !empty($appt_data->DURATION->value) ? $appt_data->DURATION->value: NULL;
            $appointment_type = !empty($appt_data->APPOINTMENT_TYPE->value) ? $appt_data->APPOINTMENT_TYPE->value: NULL;
            $visit_type = !empty($appt_data->VISIT_TYPE->value) ? $appt_data->VISIT_TYPE->value: NULL;
            $patient_category = !empty($appt_data->PATIENT_CATEGORY->value) ? $appt_data->PATIENT_CATEGORY->value: NULL;
            $assigned_team = !empty($appt_data->ASSIGNED_TEAM->value) ? $appt_data->ASSIGNED_TEAM->value: NULL;
            $patient_id = !empty($appt_data->PATIENT_FK) ? $appt_data->PATIENT_FK: NULL;

            $appointment_data = array('patient_fk' => $patient_id, 'date' => $date, 'time' => $time,
                                    'duration_fk' => $duration, 'patient_category_fk' => $patient_category, 'team_fk' => $assigned_team,
                                    'visit_type_fk' => $visit_type, 'appointment_type_fk' => $appointment_type);

            $appointment_id = DB::table('patient_appointment')-> insertGetId($appointment_data);

            http_response_code(200);
            return response([
                'message' => 'Data successfully Created.',
                'appointmentId' => $appointment_id
            ]);


        }catch (RequestException $r){
            http_response_code(400);
            return response([
                'message' => 'Failed to Create data.'
            ]);
        }
    }

    function getPatientProfile(Request $request){
        try{
            $patient_id = $request->input('patient_id');
            $query = DB::table('patient')
                        ->select('patient.mits_mrn','patient.hospital_mrn','patient.mentari_mrn','patient.name','patient.citizenship_fk','setting_gender.setting_name AS gender','patient.birthdate','patient.phone_no_1','setting_marital.setting_name AS marital',

                        'patient_appointment.date','patient_appointment.time',

                        'patient_passport.issuing_country_fk', 'setting_country.setting_name AS issuing_country',

                        'vital.height','vital.weight','vital.bmi','vital.temperature','vital.blood_pressure','vital.pulse_rate','vital.waist_circumference','vital.timestamp_create')

                        ->leftjoin('setting_gender', 'patient.gender_fk', '=', 'setting_gender.setting_id')
                        ->leftjoin('setting_marital', 'patient.marital_fk', '=', 'setting_marital.setting_id')
                        ->leftjoin('setting_country', 'patient.citizenship_fk', '=', 'setting_country.setting_id')

                        ->leftjoin('patient_appointment','patient.patient_id','=','patient_appointment.patient_fk')
                        ->leftjoin('patient_passport','patient.patient_id','=','patient_passport.patient_fk')

                        ->leftjoin('vital','patient.patient_id','=','vital.patient_fk')

                        ->where('patient.patient_id', $patient_id)
                        ->orderBy('vital.timestamp_create', 'DESC')

                        //->where('patient_appointment.date', '>',date('Y/m/d'))
                        ->orderBy('patient_appointment.date', 'ASC')
                        ->first();

            $allergy = DB::table('patient_allergy')
                            ->select('allergy_desc')
                            ->where('patient_fk',  $patient_id)
                            ->orderBy('allergy_type_fk', 'ASC')
                            ->get();

            http_response_code(200);
            return response([
                'message' => 'Data successfully Created.',
                'data' => $query,
                'allergy' => $allergy
            ]);


        }catch (RequestException $r){
            http_response_code(400);
            return response([
                'message' => 'Failed to Create data.'
            ]);
        }
    }

    function getPatientData(Request $request){
        try{
            $patient_id = $request->input('patient_id');

            $query = DB::table('patient')
                        ->select('patient.hospital_mrn','patient.mentari_mrn','patient.salutation_fk','patient.name','patient.citizenship_fk','patient.nric_type_fk','patient.nric_no', 'patient.gender_fk', 'patient.birthdate', 'patient.phone_no_1', 'patient.phone_no_2','patient.referral_fk','patient.referral_desc', 'patient.ethnic_fk','patient.religion_fk','patient.marital_fk','patient.accommodation_fk','patient.education_fk','patient.fee_exemption_fk','patient.occupation_status_fk','patient.occupation_sector_fk','patient.status_fk',

                        'setting_salutation.setting_name AS salutation',

                        'setting_nric_type.setting_name AS nric_type',

                        'patient_passport.passport_no','patient_passport.date_expiry', 'patient_passport.issuing_country_fk',

                        'setting_country.setting_name AS issuing_country',

                        'patient_services.service_fk',

                        'setting_service.setting_name AS service',

                        'setting_referral.setting_name AS referral',

                        'patient_address.address1','patient_address.address2','patient_address.address3','patient_address.state_fk AS dm_state_fk', 'patient_address.city_fk AS dm_city_fk', 'patient_address.postcode_fk AS dm_postcode_fk',

                        'setting_state.setting_name AS dm_state',
                        'setting_city.setting_name AS dm_city',
                        'setting_postcode.setting_name AS dm_postcode',

                        'patient_branch.branch_fk',

                        'setting_branch.branch_name AS branch',

                        'setting_ethnicity.setting_name AS ethnic',
                        'setting_religion.setting_name AS religion',
                        'setting_marital.setting_name AS marital',
                        'setting_accommodation.setting_name AS accommodation',
                        'setting_education.setting_name AS education',
                        'setting_fee_exemption.setting_name AS fee_exemption',
                        'setting_occupation_status.setting_name AS occupation_status',
                        'setting_occupation_sector.setting_name AS occupation_sector',

                        'patient_relationship.name AS nok_name','patient_relationship.relation_fk','patient_relationship.phone_no_1 AS nok_phone_no_1','patient_relationship.phone_no_2 AS nok_phone_no_2','patient_relationship.address1 AS nok_address1','patient_relationship.address2 AS nok_address2','patient_relationship.address3 AS nok_address3','patient_relationship.state_fk AS nok_state_fk', 'patient_relationship.city_fk AS nok_city_fk', 'patient_relationship.postcode_fk AS nok_postcode_fk',

                        'setting_relationship.setting_name AS relation',
                        )

                        ->leftjoin('patient_address', 'patient.patient_id', '=', 'patient_address.patient_fk')
                        ->leftjoin('patient_services', 'patient.patient_id', '=', 'patient_services.patient_fk')
                        ->leftjoin('patient_passport', 'patient.patient_id', '=', 'patient_passport.patient_fk')
                        ->leftjoin('patient_branch', 'patient.patient_id', '=', 'patient_branch.patient_fk')
                        ->leftjoin('patient_relationship', 'patient.patient_id', '=', 'patient_relationship.patient_fk')

                        ->leftjoin('setting_salutation', 'setting_salutation.setting_id', '=', 'patient.salutation_fk')
                        ->leftjoin('setting_nric_type', 'setting_nric_type.setting_id', '=', 'patient.nric_type_fk')
                        ->leftjoin('setting_country', 'setting_country.setting_id', '=', 'patient_passport.issuing_country_fk')
                        ->leftjoin('setting_service', 'setting_service.setting_id', '=', 'patient_services.service_fk')
                        ->leftjoin('setting_referral', 'setting_referral.setting_id', '=', 'patient.referral_fk')
                        ->leftjoin('setting_state', 'setting_state.setting_id','=', 'patient_address.state_fk')
                        ->leftjoin('setting_city', 'setting_city.setting_id','=', 'patient_address.city_fk')
                        ->leftjoin('setting_postcode', 'setting_postcode.setting_id','=', 'patient_address.postcode_fk')
                        ->leftjoin('setting_branch', 'setting_branch.setting_id','=', 'patient_branch.branch_fk')

                        ->leftjoin('setting_ethnicity', 'setting_ethnicity.setting_id', '=', 'patient.ethnic_fk')
                        ->leftjoin('setting_religion', 'setting_religion.setting_id', '=', 'patient.religion_fk')
                        ->leftjoin('setting_marital', 'setting_marital.setting_id', '=', 'patient.marital_fk')
                        ->leftjoin('setting_accommodation', 'setting_accommodation.setting_id', '=', 'patient.accommodation_fk')
                        ->leftjoin('setting_education', 'setting_education.setting_id', '=', 'patient.education_fk')
                        ->leftjoin('setting_fee_exemption', 'setting_fee_exemption.setting_id', '=', 'patient.fee_exemption_fk')
                        ->leftjoin('setting_occupation_status', 'setting_occupation_status.setting_id', '=', 'patient.occupation_status_fk')
                        ->leftjoin('setting_occupation_sector', 'setting_occupation_sector.setting_id', '=', 'patient.occupation_sector_fk')

                        ->leftjoin('setting_relationship', 'setting_relationship.setting_id','=', 'patient_relationship.relation_fk')
                        ->where('patient.patient_id', $patient_id)
                        ->orderBy('patient_passport.timestamp_create', 'DESC')
                        ->first();

            //$referral_type

            $nok_address = DB::table('patient_relationship')
                        ->select('setting_state.setting_name AS nok_state','setting_city.setting_name AS nok_city','setting_postcode.setting_name AS nok_postcode'
                        )
                        ->leftjoin('setting_state', 'setting_state.setting_id','=', 'patient_relationship.state_fk')
                        ->leftjoin('setting_city', 'setting_city.setting_id','=', 'patient_relationship.city_fk')
                        ->leftjoin('setting_postcode', 'setting_postcode.setting_id','=', 'patient_relationship.postcode_fk')
                        ->where('patient_relationship.patient_fk', $patient_id)
                        ->get();

            $allergy = DB::table('patient_allergy')
                        ->select('patient_allergy_id','allergy_type_fk','allergy_desc')
                        ->where('patient_fk', '=', $patient_id)
                        ->get();

            http_response_code(200);
            return response([
                'message' => 'Data successfully Created.',
                'data' => $query,
                'nokAddress' => $nok_address,
                'allergy' => $allergy
            ]);


        }catch (RequestException $r){
            http_response_code(400);
            return response([
                'message' => 'Failed to Create data.'
            ]);
        }
    }

    function updatePatientData(Request $request){
        try{
            $patient_id = $request->input('patientId');
            $updateData = json_decode($request->input("updateData"));

            //patient table
            // $mits_mrn = $updateData->;
            $hospital_mrn = !empty($updateData->HOSPITAL_MRN) ? $updateData->HOSPITAL_MRN: NULL;
            $mentari_mrn = !empty($updateData->MENTARI_MRN) ? $updateData->MENTARI_MRN: NULL;
            $salutation = !empty($updateData->SALUTATION->value) ? $updateData->SALUTATION->value: NULL;
            $name = !empty($updateData->DM_NAME) ? $updateData->DM_NAME: NULL;
            $citizenship = !empty($updateData->CITIZENSHIP) ? $updateData->CITIZENSHIP: NULL;
            $nric_type = !empty($updateData->NRIC_TYPE->value) ? $updateData->NRIC_TYPE->value: NULL;
            $nric_no = !empty(str_replace('-', '', $updateData->NRIC_NO)) ? str_replace('-', '', $updateData->NRIC_NO): NULL;
            $gender = !empty($updateData->GENDER) ? $updateData->GENDER: NULL;
            $birthdate = !empty($updateData->BIRTH_DATE) ? $updateData->BIRTH_DATE: NULL;
            $phone_no = !empty(str_replace(' ', '', $updateData->DM_MOBILE_NO)) ? str_replace(' ', '', $updateData->DM_MOBILE_NO): NULL;
            $house_no = !empty(str_replace(' ', '', $updateData->DM_HOUSE_NO)) ? str_replace(' ', '', $updateData->DM_HOUSE_NO): NULL;
            $referral = !empty($updateData->REFERRAL_TYPE->value) ? $updateData->REFERRAL_TYPE->value: NULL;
            $referral_desc = !empty($updateData->SPECIFY_REFERRAL) ? $updateData->SPECIFY_REFERRAL: NULL;
            $ethnic = !empty($updateData->RACE->value) ? $updateData->RACE->value: NULL;
            $religion = !empty($updateData->RELIGION->value) ? $updateData->RELIGION->value: NULL;
            $marital = !empty($updateData->MARITAL_STATUS->value) ? $updateData->MARITAL_STATUS->value: NULL;
            $accommodation = !empty($updateData->ACCOMMODATION->value) ? $updateData->ACCOMMODATION->value: NULL;
            $education =  !empty($updateData->EDUCATION_LEVEL->value) ? $updateData->EDUCATION_LEVEL->value: NULL;
            $fee_exemption = !empty($updateData->FEE_EXEMPTION_STATUS->value) ? $updateData->FEE_EXEMPTION_STATUS->value: NULL;
            $occ_status = !empty($updateData->OCCUPATION_STATUS->value) ? $updateData->OCCUPATION_STATUS->value: NULL;
            $occ_sector = !empty($updateData->OCCUPATION_SECTOR->value) ? $updateData->OCCUPATION_SECTOR->value: NULL;
            $status = !empty($updateData->EXISTING_PATIENT) ? $updateData->EXISTING_PATIENT: NULL;

            $patientData = array('hospital_mrn' =>$hospital_mrn, 'mentari_mrn' =>$mentari_mrn,'salutation_fk' => $salutation,'name' =>$name, 'citizenship_fk' => $citizenship, 'nric_type_fk' => $nric_type,'nric_no' => $nric_no, 'gender_fk' => $gender, 'birthdate' => $birthdate, 'phone_no_1' => $phone_no,'phone_no_2' => $house_no,'referral_fk' => $referral, 'referral_desc' => $referral_desc, 'ethnic_fk' => $ethnic, 'religion_fk' => $religion, 'marital_fk' => $marital,'accommodation_fk' => $accommodation, 'education_fk' => $education, 'fee_exemption_fk' => $fee_exemption,'occupation_status_fk' => $occ_status, 'occupation_sector_fk' => $occ_sector, 'status_fk' => $status);

             DB::table('patient')
                -> where('patient_id', $patient_id)
                -> update($patientData);

            //patient_passport
            $patient_passport_id = NULL;

            // if patient is registered as foreigner,
            if($citizenship === 3){
                $passport_no = !empty($updateData->PASSPORT_NO) ? $updateData->PASSPORT_NO: NULL;
                $passport_expiry = !empty($updateData->PASSPORT_EXPIRY_DATE) ? $updateData->PASSPORT_EXPIRY_DATE: NULL;
                $issuing_country = !empty($updateData->ISSUING_COUNTRY->value) ? $updateData->ISSUING_COUNTRY->value: NULL;

                if(DB::table('patient_passport')->where('passport_no', $passport_no)->exists()){
                }else{
                    $passportData = array('patient_fk' => $patient_id,'passport_no' => $passport_no, 'date_expiry' => $passport_expiry,'issuing_country_fk' => $issuing_country);
                    $patient_passport_id = DB::table('patient_passport')-> insertGetId($passportData);

                }
            }

            //patient_services
            $services = !empty($updateData->SERVICE_TYPE->value) ? $updateData->SERVICE_TYPE->value: NULL;

            if(DB::table('patient_services')->where('patient_fk', $patient_id)->exists()){
                $service_id = NULL;
                DB::table('patient_services')
                    -> where('patient_fk', $patient_id)
                    -> update(array('service_fk' => $services));
            }
            else{
                $service_id = DB::table('patient_services')-> insertGetId(array('patient_fk' =>$patient_id,'service_fk' => $services));
            }

            //patient_address
            $current_address = 1;
            $address_1 = !empty($updateData->DM_ADDRESS_LINE_1) ? $updateData->DM_ADDRESS_LINE_1: NULL;
            $address_2 = !empty($updateData->DM_ADDRESS_LINE_2) ? $updateData->DM_ADDRESS_LINE_2: NULL;
            $address_3 = !empty($updateData->DM_ADDRESS_LINE_3) ? $updateData->DM_ADDRESS_LINE_3: NULL;
            $state = !empty($updateData->DM_STATE->value) ? $updateData->DM_STATE->value: NULL;
            $city = !empty($updateData->DM_CITY->value) ? $updateData->DM_CITY->value: NULL;
            $postcode = !empty($updateData->DM_POSTCODE->value) ? $updateData->DM_POSTCODE->value: NULL;

            $addressData = array('current_address' => $current_address, 'address1' => $address_1, 'address2' => $address_2, 'address3' => $address_3, 'state_fk' => $state, 'city_fk' => $city,'postcode_fk' => $postcode);

            DB::table('patient_address')
                -> where('patient_fk', $patient_id)
                -> update($addressData);

             //patient_referral

            //patient_document

            //patient_branch
            $branch = !empty($updateData->BRANCH->value) ? $updateData->BRANCH->value: NULL;
            $current_branch = 1;
            $date_register = date("Y-m-d");

            $branchData = array('current_branch' => $current_branch, 'branch_fk' => $branch,
            'date_register' => $date_register);

            DB::table('patient_branch')
                -> where('patient_fk', $patient_id)
                -> update($branchData);

            //patient_relationship
            $nok_relation = !empty($updateData->NOK_RELATIONSHIP->value) ? $updateData->NOK_RELATIONSHIP->value: NULL;
            $nok_name =  !empty($updateData->NOK_NAME) ? $updateData->NOK_NAME: NULL;
            $nok_phone_no = !empty(str_replace(' ', '', $updateData->NOK_MOBILE_NO)) ? str_replace(' ', '', $updateData->NOK_MOBILE_NO): NULL;
            $nok_house_no = !empty(str_replace(' ', '', $updateData->NOK_HOUSE_NO)) ? str_replace(' ', '', $updateData->NOK_HOUSE_NO): NULL;
            $nok_address1 = !empty($updateData->NOK_ADDRESS_L1) ? $updateData->NOK_ADDRESS_L1: NULL;
            $nok_address2 = !empty($updateData->NOK_ADDRESS_L2) ? $updateData->NOK_ADDRESS_L2: NULL;
            $nok_address3 = !empty($updateData->NOK_ADDRESS_L3) ? $updateData->NOK_ADDRESS_L3: NULL;
            $nok_state = !empty($updateData->NOK_STATE->value) ? $updateData->NOK_STATE->value: NULL;
            $nok_city = !empty($updateData->NOK_CITY->value) ? $updateData->NOK_CITY->value: NULL;
            $nok_postcode = !empty($updateData->NOK_POSTCODE->value) ? $updateData->NOK_POSTCODE->value: NULL;

            $nokAddressData = array('relation_fk' => $nok_relation,'name' => $nok_name,'phone_no_1' => $nok_phone_no,'phone_no_2' => $nok_house_no,'address1' => $nok_address1,'address2' => $nok_address2,'address3' => $nok_address3,'state_fk' => $nok_state,'city_fk' => $nok_city,'postcode_fk' => $nok_postcode);

            if(DB::table('patient_relationship')->where('patient_fk', $patient_id)->exists()){
                $nok_address_id = NULL;
                DB::table('patient_relationship')
                    -> where('patient_fk', $patient_id)
                    -> update($nokAddressData);
            }
            else{
                $nok_address_id = DB::table('patient_relationship')-> insertGetId(array('patient_fk' =>$patient_id,'relation_fk' => $nok_relation,'name' => $nok_name,'phone_no_1' => $nok_phone_no,'phone_no_2' => $nok_house_no,'address1' => $nok_address1,'address2' => $nok_address2,'address3' => $nok_address3,'state_fk' => $nok_state,'city_fk' => $nok_city,'postcode_fk' => $nok_postcode));
            }

            //patient_allergy
            $allergy = !empty($updateData->ALLERGY) ? $updateData->ALLERGY: NULL;
            $patient_allergy_1_id = $request->input('allergy1');
            $patient_allergy_2_id = $request->input('allergy2');
            $patient_allergy_3_id = $request->input('allergy3');

            if(!empty($allergy)){
                //If no allergy 1 data exists before, insert new
                if($patient_allergy_1_id == "null" && $allergy[0] == 1){
                    $allergy_type_1 = 1;
                    $allergy_desc_1 = !empty($updateData->DRUG_ALL_SPECIFY) ? $updateData->DRUG_ALL_SPECIFY: NULL;
                    $drugAllergyData = array('patient_fk' => $patient_id, 'allergy_type_fk' => $allergy_type_1, 'allergy_desc' => $allergy_desc_1);
                    $patient_allergy_1_id = DB::table('patient_allergy')
                                                -> insertGetId($drugAllergyData);
                }
                //Else, allergy data 1 exists before
                else if($patient_allergy_1_id){
                    //Update the data
                    if($allergy[0] == 1){
                        $allergy_type_1 = 1;
                        $allergy_desc_1 = !empty($updateData->DRUG_ALL_SPECIFY) ? $updateData->DRUG_ALL_SPECIFY: NULL;
                        $drugAllergyData = array('allergy_type_fk' => $allergy_type_1, 'allergy_desc' => $allergy_desc_1);
                        DB::table('patient_allergy')
                            -> where('patient_allergy_id', $patient_allergy_1_id)
                            -> update($drugAllergyData);
                    }
                    //Delete the data
                    else if($allergy[0] == 0){
                        DB::table('patient_allergy')
                            -> where('patient_allergy_id', $patient_allergy_1_id)
                            -> delete();
                        $patient_allergy_1_id = null;
                    }
                }
                //If no allergy 2 data exists before, insert new
                if($patient_allergy_2_id == "null" && $allergy[1] == 1){
                    $allergy_type_2 = 2;
                    $allergy_desc_2 = !empty($updateData->SUPP_ALL_SPECIFY) ? $updateData->SUPP_ALL_SPECIFY: NULL;
                    $suppAllergyData = array('patient_fk' => $patient_id, 'allergy_type_fk' => $allergy_type_2, 'allergy_desc' => $allergy_desc_2);
                    $patient_allergy_2_id = DB::table('patient_allergy')
                                                -> insertGetId($suppAllergyData);
                }
                //Else, allergy data 2 exists before
                else if($patient_allergy_2_id){
                    //Update the data
                    if($allergy[1] == 1){
                        $allergy_type_2 = 2;
                        $allergy_desc_2 = !empty($updateData->SUPP_ALL_SPECIFY) ? $updateData->SUPP_ALL_SPECIFY: NULL;
                        $suppAllergyData = array('allergy_type_fk' => $allergy_type_2, 'allergy_desc' => $allergy_desc_2);
                        DB::table('patient_allergy')
                            -> where('patient_allergy_id', $patient_allergy_2_id)
                            -> update($suppAllergyData);
                    }
                    //Delete the data
                    else if($allergy[1] == 0){
                        DB::table('patient_allergy')
                            -> where('patient_allergy_id', $patient_allergy_2_id)
                            -> delete();
                        $patient_allergy_2_id = null;
                    }
                }
                //If no allergy 3 data exists before, insert new
                if($patient_allergy_3_id == "null" && $allergy[2] == 1){
                    $allergy_type_3 = 3;
                    $allergy_desc_3 = !empty($updateData->OTHERS_SPECIFY) ? $updateData->OTHERS_SPECIFY: NULL;
                    $othAllergyData = array('patient_fk' => $patient_id, 'allergy_type_fk' => $allergy_type_3, 'allergy_desc' => $allergy_desc_3);
                    $patient_allergy_3_id = DB::table('patient_allergy')
                                                -> insertGetId($othAllergyData);
                }
                //Else, allergy data 3 exists before
                else if($patient_allergy_3_id){
                    //Update the data
                    if($allergy[2] == 1){
                        $allergy_type_3 = 3;
                        $allergy_desc_3 = !empty($updateData->OTHERS_SPECIFY) ? $updateData->OTHERS_SPECIFY: NULL;
                        $othAllergyData = array('allergy_type_fk' => $allergy_type_3, 'allergy_desc' => $allergy_desc_3);
                        DB::table('patient_allergy')
                            -> where('patient_allergy_id', $patient_allergy_3_id)
                            -> update($othAllergyData);
                    }
                    //Delete the data
                    else if($allergy[2] == 0){
                        DB::table('patient_allergy')
                            -> where('patient_allergy_id', $patient_allergy_3_id)
                            -> delete();
                        $patient_allergy_3_id = null;
                    }
                }
            }

            http_response_code(200);
            return response([
                'message' => 'Data successfully Updated.',
                'patientId' => $patient_id,
                'patientServiecID' => $service_id,
                'patientNokId' => $nok_address_id,
                'patientPassportId' => $patient_passport_id,
                'patientAllergy1' => $patient_allergy_1_id,
                'patientAllergy2' => $patient_allergy_2_id,
                'patientAllergy3' => $patient_allergy_3_id,
            ]);


        }catch (RequestException $r){
            http_response_code(400);
            return response([
                'message' => 'Failed to Create data.'
            ]);
        }
    }

    function getService(Request $request){
        try{
            $query = DB::table('setting_service')
                        ->select('setting_name AS name')
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

    function getAppointmentList(Request $request){
        try{
            $query = DB::table('patient_appointment')
                        ->select('patient_appointment.patient_fk AS patient_id', 'patient_appointment.patient_appointment_id AS appointment_id',
                                    (DB::RAW('COALESCE(patient.mentari_mrn, "") AS mrn')), 'setting_salutation.setting_name AS salutation',
                                    (DB::RAW('COALESCE(patient.name, "") AS name')),
                                    (DB::raw('CONCAT(COALESCE(patient.nric_no, ""), COALESCE(patient_passport.passport_no, "")) AS nricPassport')),
                                    (DB::RAW('COALESCE(patient_appointment.date, "") AS date')), 'patient_appointment.time AS time', 'staff.name AS doctor',
                                    'setting_appointment_status.setting_name AS status',
                                    (DB::RAW('COALESCE(setting_service.setting_name, "") AS services')))

                        ->leftJoin('patient', function ($join) {
                            $join->on('patient_appointment.patient_fk', '=', 'patient.patient_id')
                                 ->leftJoin('patient_passport', 'patient.patient_id', '=', 'patient_passport.patient_fk')
                                 ->leftJoin('setting_salutation', 'patient.salutation_fk', '=', 'setting_salutation.setting_id')
                                 ->leftJoin('patient_services', function ($join) {
                                    $join->on('patient.patient_id', '=', 'patient_services.patient_fk')
                                         ->leftJoin('setting_service', 'patient_services.service_fk', '=', 'setting_service.setting_id');
                                });
                        })
                        ->leftJoin('setting_appointment_status', 'patient_appointment.appointment_status_fk', '=', 'setting_appointment_status.setting_id')
                        ->leftJoin('staff', 'patient_appointment.staff_fk', '=', 'staff.staff_id')
                        ->get();

            $service = DB::table('setting_service')
                        ->select('setting_name AS name')
                        ->whereNull('service_category_fk')
                        ->get();

            $service_list = collect($service)->map(function($x){ return $x->name; })->toArray();


            http_response_code(200);
            return response([
                'message' => 'Data successfully Created.',
                'data' => $query,
                'service' => $service_list
            ]);


        }catch (RequestException $r){
            http_response_code(400);
            return response([
                'message' => 'Failed to Create data.'
            ]);
        }
    }

    function tickAttendance(Request $request){
        try{

            $appointment_id = $request->input('appointmentId');
            $service_type = $request->input('serviceType');

            if($service_type === 'Consultation'){
                $appt_status = DB::table('setting_appointment_status')
                        ->select('setting_id AS id')
                        -> where('setting_name', 'Processing')
                        ->get();

            }else if($service_type === 'Rehabilitation' || $service_type === 'Rehabilitation - SE' || $service_type === 'Rehabilitation - ETP'
                        || $service_type === 'Rehabilitation - Job Club'){
                $appt_status = DB::table('setting_appointment_status')
                        ->select('setting_id AS id')
                        -> where('setting_name', 'Ready')
                        ->get();
            }

            $appt_status_id = $appt_status[0]->id;

            $apptData = array('appointment_status_fk' => $appt_status_id);

            $appointment_id = DB::table('patient_appointment')
                                -> where('patient_appointment_id', $appointment_id)
                                -> update($apptData);

            http_response_code(200);
            return response([
                'message' => 'Data successfully Created.',
                'data' => $appointment_id
            ]);


        }catch (RequestException $r){
            http_response_code(400);
            return response([
                'message' => 'Failed to Create data.'
            ]);
        }
    }

    function noShowAttendance(Request $request){
        try{

            $appointment_id = $request->input('appointmentId');

            $appt_status = DB::table('setting_appointment_status')
                        ->select('setting_id AS id')
                        -> where('setting_name', 'No Show')
                        ->get();

            $appt_status_id = $appt_status[0]->id;

            $apptData = array('appointment_status_fk' => $appt_status_id);

            $appointment_id = DB::table('patient_appointment')
                                -> where('patient_appointment_id', $appointment_id)
                                -> update($apptData);

            http_response_code(200);
            return response([
                'message' => 'Data successfully Created.',
                'data' => $appointment_id
            ]);


        }catch (RequestException $r){
            http_response_code(400);
            return response([
                'message' => 'Failed to Create data.'
            ]);
        }
    }

    function getAppointmentData(Request $request){
        try{
            $appointment_id = $request->input('appointmentId');

            $query = DB::table('patient_appointment')
                        ->select('patient_appointment.patient_fk AS patient_id', 'patient_appointment.patient_appointment_id AS appointment_id',
                                    (DB::raw('CONCAT(COALESCE(patient.nric_no, ""), COALESCE(patient_passport.passport_no, "")) AS nricPassport')),
                                    'patient_appointment.date AS date', 'patient_appointment.time AS time',
                                    'setting_appointment_duration.setting_name AS durationName', 'setting_appointment_duration.setting_id AS durationValue',
                                    'patient_appointment.appointment_type_fk AS appointmentTypeValue', 'setting_appointment_type.setting_name AS appointmentTypeName',
                                    'patient_appointment.patient_category_fk AS patientCategoryValue', 'setting_patient_category.setting_name AS patientCategoryName',
                                    'patient_appointment.team_fk AS assignedTeamValue', 'setting_team.team_name AS assignedTeamName',
                                    'patient_appointment.visit_type_fk AS visitTypeValue', 'setting_visit_type.setting_name AS visitTypeName')

                            ->leftJoin('patient', function ($join) {
                                $join->on('patient_appointment.patient_fk', '=', 'patient.patient_id');
                            })
                            ->leftJoin('patient_passport', 'patient.patient_id', '=', 'patient_passport.patient_fk')
                            ->leftJoin('setting_appointment_type', 'patient_appointment.appointment_type_fk', '=', 'setting_appointment_type.setting_id')
                            ->leftJoin('setting_patient_category', 'patient_appointment.patient_category_fk', '=', 'setting_patient_category.setting_id')
                            ->leftJoin('setting_team', 'patient_appointment.team_fk', '=', 'setting_team.setting_id')
                            ->leftJoin('setting_visit_type', 'patient_appointment.visit_type_fk', '=', 'setting_visit_type.setting_id')
                            ->leftJoin('setting_appointment_duration', 'patient_appointment.duration_fk', '=', 'setting_appointment_duration.setting_id')

                        ->where('patient_appointment_id', $appointment_id)
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

    function updateAppointment(Request $request){
        try{

            $appt_data = json_decode($request->input("apptData"));

            $date = !empty($appt_data->DATE) ? $appt_data->DATE: NULL;
            $time = !empty($appt_data->TIME) ? $appt_data->TIME: NULL;
            $duration = !empty($appt_data->DURATION->value) ? $appt_data->DURATION->value: NULL;
            $appointment_type = !empty($appt_data->APPOINTMENT_TYPE->value) ? $appt_data->APPOINTMENT_TYPE->value: NULL;
            $visit_type = !empty($appt_data->VISIT_TYPE->value) ? $appt_data->VISIT_TYPE->value: NULL;
            $patient_category = !empty($appt_data->PATIENT_CATEGORY->value) ? $appt_data->PATIENT_CATEGORY->value: NULL;
            $assigned_team = !empty($appt_data->ASSIGNED_TEAM->value) ? $appt_data->ASSIGNED_TEAM->value: NULL;
            $patient_id = !empty($appt_data->PATIENT_FK) ? $appt_data->PATIENT_FK: NULL;
            $appointment_id = !empty($appt_data->APPOINTMENT_ID) ? $appt_data->APPOINTMENT_ID: NULL;

            $appointment_data = array('patient_fk' => $patient_id, 'date' => $date, 'time' => $time,
                                    'duration_fk' => $duration, 'patient_category_fk' => $patient_category, 'team_fk' => $assigned_team,
                                    'visit_type_fk' => $visit_type, 'appointment_type_fk' => $appointment_type);

            DB::table('patient_appointment')
                -> where('patient_appointment_id', $appointment_id)
                -> update($appointment_data);

            http_response_code(200);
            return response([
                'message' => 'Data successfully updated.',
                'appointmentId' => $appointment_id
            ]);


        }catch (RequestException $r){
            http_response_code(400);
            return response([
                'message' => 'Failed to update data.'
            ]);
        }
    }

    function getPatientList(Request $request){
        try{
            $list = DB::select('SELECT t1.patient_appointment_id AS patient_appointment_id
                                FROM patient_appointment t1
                                WHERE t1.date = (SELECT MAX(t2.date)
                                                FROM patient_appointment t2
                                                WHERE t2.patient_fk = t1.patient_fk)');
            $list = collect($list)->map(function($x){ return $x->patient_appointment_id; })->toArray();

            $query = DB::table('patient')
                        ->select( 'patient.patient_id AS patient_id', (DB::RAW('COALESCE(patient.mentari_mrn, "") AS mrn')),
                                    'setting_salutation.setting_name AS salutation',
                                    (DB::RAW('COALESCE(patient.name, "") AS name')), 'patient.birthdate AS age',
                                    (DB::raw('CONCAT(COALESCE(patient.nric_no, ""), COALESCE(patient_passport.passport_no, "")) AS nricPassport')),
                                    // (DB::RAW('COALESCE(patient_passport.timestamp_create, 0) AS passportDate')),
                                    'patient_appointment.date AS visit', 'staff.name AS doctor', (DB::RAW('COALESCE(setting_service.setting_name, "") AS services')),
                                    (DB::RAW('COALESCE(setting_branch.branch_name, "") AS branch')) )

                            ->whereIn('patient_appointment.patient_appointment_id', $list)
                            ->leftJoin('setting_salutation', 'patient.salutation_fk', '=', 'setting_salutation.setting_id')
                            ->leftJoin('patient_passport', 'patient.patient_id', '=', 'patient_passport.patient_fk')
                            // ->leftJoin('patient_passport', function ($join) {
                            //     $join->on('patient.patient_id', '=', 'patient_passport.patient_fk')
                            //             ->on('patient_passpor.timestamp_create', '>=', DB::raw("'2021-12-30 10:08:57'"));
                            //     })
                            ->leftJoin('patient_services', function ($join) {
                                $join->on('patient.patient_id', '=', 'patient_services.patient_fk')
                                    ->leftJoin('setting_service', 'patient_services.service_fk', '=', 'setting_service.setting_id');
                                })
                            ->leftJoin('patient_appointment', function ($join) {
                                $join->on('patient.patient_id', '=', 'patient_appointment.patient_fk')
                                    ->leftJoin('staff', 'patient_appointment.staff_fk', '=', 'staff.staff_id');
                                })
                            ->leftJoin('patient_branch', function ($join) {
                                $join->on('patient.patient_id', '=', 'patient_branch.patient_fk')
                                    ->leftJoin('setting_branch', 'patient_branch.branch_fk', '=', 'setting_branch.setting_id');
                                });
                            // ->orderBy('passportDate', 'DESC');
                            // ->groupBy('patient_id');

            $list2 = DB::select('SELECT patient_fk
                                 FROM patient_appointment');

            $list2 = collect($list2)->map(function($x){ return $x->patient_fk; })->toArray();

            $query2 = DB::table('patient')
                                ->select( 'patient.patient_id AS patient_id', (DB::RAW('COALESCE(patient.mentari_mrn, "") AS mrn')),
                                            'setting_salutation.setting_name AS salutation',
                                            (DB::RAW('COALESCE(patient.name, "") AS name')), 'patient.birthdate AS age',
                                            (DB::raw('CONCAT(COALESCE(patient.nric_no, ""), COALESCE(patient_passport.passport_no, "")) AS nricPassport')),
                                            // (DB::RAW('COALESCE(patient_passport.timestamp_create, 0) AS passportDate')),
                                            'patient_appointment.date AS visit', 'staff.name AS doctor', (DB::RAW('COALESCE(setting_service.setting_name, "") AS services')),
                                            (DB::RAW('COALESCE(setting_branch.branch_name, "") AS branch')) )

                                    ->whereNotIn('patient.patient_id', $list2)
                                    ->leftJoin('setting_salutation', 'patient.salutation_fk', '=', 'setting_salutation.setting_id')
                                    ->leftJoin('patient_passport', 'patient.patient_id', '=', 'patient_passport.patient_fk')
                                    // ->leftJoin('patient_passport', function ($join) {
                                    //     $join->on('patient.patient_id', '=', 'patient_passport.patient_fk')
                                    //             ->on('patient_passport.timestamp_create', '>=', DB::raw("'2021-12-30 10:08:57'"));
                                    //     })
                                    ->leftJoin('patient_services', function ($join) {
                                        $join->on('patient.patient_id', '=', 'patient_services.patient_fk')
                                            ->leftJoin('setting_service', 'patient_services.service_fk', '=', 'setting_service.setting_id');
                                        })
                                    ->leftJoin('patient_appointment', function ($join) {
                                        $join->on('patient.patient_id', '=', 'patient_appointment.patient_fk')
                                            ->leftJoin('staff', 'patient_appointment.staff_fk', '=', 'staff.staff_id');
                                        })
                                    ->leftJoin('patient_branch', function ($join) {
                                        $join->on('patient.patient_id', '=', 'patient_branch.patient_fk')
                                            ->leftJoin('setting_branch', 'patient_branch.branch_fk', '=', 'setting_branch.setting_id');
                                        });
                                    // ->orderBy('passportDate', 'DESC');
                                    // ->groupBy('patient_id');

            $final_query = $query->union($query2)->orderBy('name')->get();

            $service = DB::table('setting_service')
                        ->select('setting_name AS name')
                        ->whereNull('service_category_fk')
                        ->get();

            $service_list = collect($service)->map(function($x){ return $x->name; })->toArray();

            $branch = DB::table('setting_branch')
                        ->select('branch_name AS name')
                        ->get();

            $branch_list = collect($branch)->map(function($x){ return $x->name; })->toArray();

            http_response_code(200);
            return response([
                'message' => 'Data successfully Created.',
                'data' => $final_query,
                'service' => $service_list,
                'branch' => $branch_list
            ]);


        }catch (RequestException $r){
            http_response_code(400);
            return response([
                'message' => 'Failed to Create data.'
            ]);
        }
    }

    function getPatientAllergy(Request $request){
        try{
            $patient_id = $request->input('id');

            $query = DB::table('patient_allergy')
                        ->select('patient_allergy_id')
                        ->where('patient_fk', $patient_id)
                        ->get();

            $query = collect($query)->map(function($x){ return $x->patient_allergy_id; })->toArray();

            $allergy1 = !empty($query[0]) ? $query[0]: NULL;
            $allergy2= !empty($query[1]) ? $query[1]: NULL;
            $allergy3= !empty($query[2]) ? $query[2]: NULL;

            http_response_code(200);
            return response([
                'message' => 'Data successfully fetched.',
                'allergy1' => $allergy1,
                'allergy2' => $allergy2,
                'allergy3' => $allergy3
            ]);

        }catch (RequestException $r){
            http_response_code(400);
            return response([
                'message' => 'Failed to get data.'
            ]);
        }
    }

    function addVital(Request $request){
        try{
            $patient_id = $request->input('patientId');
            $vitalData = json_decode($request->input("vitalData"));

            $height = !empty($vitalData->HEIGHT) ? $vitalData->HEIGHT: NULL;
            $weight  = !empty($vitalData->WEIGHT) ? $vitalData->WEIGHT: NULL;
            $bmi = !empty($vitalData->BMI) ? $vitalData->BMI: NULL;
            $temperature = !empty($vitalData->TEMPERATURE) ? $vitalData->TEMPERATURE: NULL;
            $blood_pressure = !empty($vitalData->BLOOD_PRESSURE) ? $vitalData->BLOOD_PRESSURE: NULL;
            $pulse_rate = !empty($vitalData->PULSE_RATE) ? $vitalData->PULSE_RATE: NULL;
            $waist_circumference = !empty($vitalData->WAIST) ? $vitalData->WAIST: NULL;


            $vital = array('patient_fk' => $patient_id, 'height' => $height, 'weight' => $weight, 'bmi' => $bmi, 'temperature' => $temperature, 'blood_pressure' => $blood_pressure, 'pulse_rate' => $pulse_rate, 'waist_circumference' => $waist_circumference);

            $vital_id = DB::table('vital')
                        ->insertGetId($vital);

            DB::table('patient_appointment')
                    ->where('patient_fk', $patient_id)
                    ->update(array('appointment_status_fk' => 3));


            http_response_code(200);
            return response([
                'message' => 'Data successfully Created.',
                'patientId' => $patient_id,
                'patientVitalId' => $vital_id
            ]);

        }catch (RequestException $r){
            http_response_code(400);
            return response([
                'message' => 'Failed to Create data.'
            ]);
        }
    }

    function getVital(Request $request){
        try{
            $patient_id = $request->input('patientId');

            $query = DB::table('vital')
                        ->select('vital_id', 'height','weight','bmi','temperature','blood_pressure','pulse_rate','waist_circumference','creator_fk','timestamp_create')
                        ->where('patient_fk', $patient_id)
                        ->orderBy('timestamp_create', 'DESC')
                        ->get();


            http_response_code(200);
            return response([
                'message' => 'Data successfully Created.',
                'vitals' => $query,
            ]);

        }catch (RequestException $r){
            http_response_code(400);
            return response([
                'message' => 'Failed to Create data.'
            ]);
        }
    }

    function deleteVital(Request $request){
        try{
            $vital_id = $request->input('vitalId');

            $query = DB::table('vital')->where('vital_id', '=', $vital_id)->delete();


            http_response_code(200);
            return response([
                'message' => 'Data successfully deleted.',
                'vitals' => $query,
            ]);

        }catch (RequestException $r){
            http_response_code(400);
            return response([
                'message' => 'Failed to Create data.'
            ]);
        }
    }

    function getPsychometricTest(Request $request){
        try{
            $query = DB::table('setting_psychometric_test')
                        ->select('setting_id AS id','setting_name AS name')
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

    function addTriage(Request $request){
        try{
            $patient_id = $request->input('patientId');
            $triageData = json_decode($request->input("triageData"));

            $history_aggressive_impulse_behaviour = $triageData->HISTORY;
            $history_criminal_case = $triageData->CRIMINAL;
            $detereoration_clinical_condition = $triageData->CLINICAL;
            $neglect_self_care = $triageData->SELFCARE;

            $idea_suicidal_behaviour = $triageData->IDEA_SUICIDAL;
            $attempt_suicidal_behaviour = $triageData->ATTEMPT_SUICIDAL;
            $idea_homicidal = $triageData->IDEA_HOMICIDAL;
            $attempt_homicidal = $triageData->ATTEMPT_HOMICIDAL;
            $idea_aggressive = $triageData->IDEA_AGGRESIVE;
            $attempt_aggressive = $triageData->ATTEMPT_AGGRESIVE;

            $social_support_family = $triageData->NO_FAMILY;
            $social_support_homeless = $triageData->HOMELESS;

            $capacity_work_together = $triageData->TOGETHER;
            $capacity_interest = $triageData->INTEREST;

            $outcome_treatement = $triageData->TREATMENT;
            $outcome_placement = $triageData->PLACEMENT;

            //Triage
            $triage_data = array('patient_fk' => $patient_id, 'history_aggressive_impulse_behaviour' => $history_aggressive_impulse_behaviour, 'history_criminal_case' => $history_criminal_case, 'detereoration_clinical_condition' => $detereoration_clinical_condition, 'neglect_self_care' => $neglect_self_care, 'idea_suicidal_behaviour' => $idea_suicidal_behaviour, 'attempt_suicidal_behaviour' => $attempt_suicidal_behaviour, 'idea_homicidal' => $idea_homicidal, 'attempt_homicidal' => $attempt_homicidal, 'idea_aggressive' => $idea_aggressive, 'attempt_aggressive' => $attempt_aggressive, 'social_support_family' => $social_support_family, 'social_support_homeless' => $social_support_homeless, 'capacity_work_together' => $capacity_work_together, 'capacity_interest' => $capacity_interest, 'outcome_treatement' => $outcome_treatement, 'outcome_placement' => $outcome_placement);

            $triage_id = DB::table('triage')
                        ->insertGetId($triage_data);

            //Screening
            $test = !empty($triageData->TEST) ? $triageData->TEST: NULL;
            $score = !empty($triageData->SCORE) ? $triageData->SCORE: NULL;

            $screening_data = array('patient_fk' => $patient_id, 'psychometric_fk' => $test, 'psychometric_score' => $score);

            $screening_id = DB::table('screening')
                        ->insertGetId($screening_data);

            //Appointment
            $date = !empty($triageData->DATE) ? $triageData->DATE: NULL;
            $time = !empty($triageData->TIME) ? $triageData->TIME: NULL;
            $duration = !empty($triageData->DURATION->value) ? $triageData->DURATION->value: NULL;
            $appointment_type = !empty($triageData->APPOINTMENT_TYPE->value) ? $triageData->APPOINTMENT_TYPE->value: NULL;
            $visit_type = !empty($triageData->VISIT_TYPE->value) ? $triageData->VISIT_TYPE->value: NULL;
            $patient_category = !empty($triageData->PATIENT_CATEGORY->value) ? $triageData->PATIENT_CATEGORY->value: NULL;
            $assigned_team = !empty($triageData->ASSIGNED_TEAM->value) ? $triageData->ASSIGNED_TEAM->value: NULL;

            $appointment_data = array('patient_fk' => $patient_id, 'date' => $date, 'time' => $time,
                                    'duration_fk' => $duration, 'patient_category_fk' => $patient_category, 'team_fk' => $assigned_team,
                                    'visit_type_fk' => $visit_type, 'appointment_type_fk' => $appointment_type);

            $appointment_id = DB::table('patient_appointment')-> insertGetId($appointment_data);

            http_response_code(200);
            return response([
                'message' => 'Data successfully Created.',
                'patientId' => $patient_id,
                'patientTriageId' => $triage_id,
                'appointmentId' => $appointment_id,
                'screeningId' => $screening_id
            ]);

        }catch (RequestException $r){
            http_response_code(400);
            return response([
                'message' => 'Failed to Create data.'
            ]);
        }
    }

    function getRequestAppointmentList(Request $request){
        try{
            $query = DB::table('request_appointment')
                        ->select('request_appointment.request_appointment_id AS request_appointment_id', 'request_appointment.name AS name',
                                    'request_appointment.nric_passport AS nricPassport',
                                    'request_appointment.phone_no AS contact', 'request_appointment.email AS email',
                                    'request_appointment.timestamp_create AS date')

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

    function getAppointmentHistory(Request $request){
        try{
            $patient_id = $request->input('patient_id');
            $query = DB::table('patient_appointment')
                        ->select('patient_appointment.patient_fk AS patient_id', 'patient_appointment.patient_appointment_id AS appointment_id',
                                    'patient_appointment.date', 'patient_appointment.time', 'setting_appointment_status.setting_name AS status')
                        ->where('patient_fk', $patient_id)
                        ->leftJoin('setting_appointment_status', 'patient_appointment.appointment_status_fk', '=', 'setting_appointment_status.setting_id')
                        ->orderBy('date', 'DESC')
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

    function deleteAppointment(Request $request){
        try{
            $apppointment_id = $request->input('appointmentId');

            $query = DB::table('patient_appointment')->where('patient_appointment_id', '=', $apppointment_id)->delete();


            http_response_code(200);
            return response([
                'message' => 'Data successfully deleted.',
                'data' => $query,
            ]);

        }catch (RequestException $r){
            http_response_code(400);
            return response([
                'message' => 'Failed to Create data.'
            ]);
        }
    }

    function getServiceBasedOnCategory(Request $request){
        try{
            $service_category_id = $request->input('id');
            $query = DB::table('setting_service')
                        ->select('setting_name AS name', 'setting_id AS value')
                        ->where('service_category_fk', '=', $service_category_id)
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

    function getCounsellingProgressNoteMountedData(Request $request){
        try{
            $patient_id = $request->input('patient_id');

            $service_location = DB::table('setting_service_location')
                                ->select('setting_id AS value','setting_name AS name')
                                ->get();

            $service_complexity = DB::table('setting_service_complexity')
                                ->select('setting_id AS value','setting_name AS name')
                                ->get();

            $service_outcome = DB::table('setting_service_outcome')
                                ->select('setting_id AS value','setting_name AS name')
                                ->get();

            $service_category = DB::table('setting_service_category')
                                ->select('setting_id AS value','setting_name AS name')
                                ->get();

            $patient_data = DB::table('patient')
                            ->select('patient.mentari_mrn AS mrn','patient.name', 'patient.birthdate',
                                        (DB::raw('CONCAT(COALESCE(patient.nric_no, ""), COALESCE(patient_passport.passport_no, "")) AS nricPassport')),
                                        'patient.phone_no_1 AS contact', 'setting_gender.setting_name AS gender')
                            ->where('patient_id', $patient_id)
                            ->leftJoin('patient_passport', 'patient.patient_id', '=', 'patient_passport.patient_fk')
                            ->leftJoin('setting_gender', 'patient.gender_fk', '=', 'setting_gender.setting_id')
                            ->get();

            http_response_code(200);
            return response([
                'serviceLocation' => $service_location,
                'serviceComplexity' => $service_complexity,
                'serviceOutcome' => $service_outcome,
                'serviceCategory' => $service_category,
                'patientData' => $patient_data,
            ]);


        }catch (RequestException $r){
            http_response_code(400);
            return response([
                'message' => 'Failed to Create data.'
            ]);
        }
    }

    function getCounsellingClerkingNoteMountedData(Request $request){
        try{
            $patient_id = $request->input('patient_id');

            $service_location = DB::table('setting_service_location')
                                ->select('setting_id AS value','setting_name AS name')
                                ->get();

            $service_complexity = DB::table('setting_service_complexity')
                                ->select('setting_id AS value','setting_name AS name')
                                ->get();

            $service_outcome = DB::table('setting_service_outcome')
                                ->select('setting_id AS value','setting_name AS name')
                                ->get();

            $service_category = DB::table('setting_service_category')
                                ->select('setting_id AS value','setting_name AS name')
                                ->get();

            $patient_data = DB::table('patient')
                            ->select('patient.mentari_mrn AS mrn','patient.name', 'patient.birthdate',
                                        (DB::raw('CONCAT(COALESCE(patient.nric_no, ""), COALESCE(patient_passport.passport_no, "")) AS nricPassport')),
                                        'patient.phone_no_1 AS contact', 'setting_gender.setting_name AS gender')
                            ->where('patient_id', $patient_id)
                            ->leftJoin('patient_passport', 'patient.patient_id', '=', 'patient_passport.patient_fk')
                            ->leftJoin('setting_gender', 'patient.gender_fk', '=', 'setting_gender.setting_id')
                            ->get();

            http_response_code(200);
            return response([
                'serviceLocation' => $service_location,
                'serviceComplexity' => $service_complexity,
                'serviceOutcome' => $service_outcome,
                'serviceCategory' => $service_category,
                'patientData' => $patient_data,
            ]);


        }catch (RequestException $r){
            http_response_code(400);
            return response([
                'message' => 'Failed to Create data.'
            ]);
        }
    }

    function getPatientCarePlanMountedData(Request $request){
        try{
            $patient_id = $request->input('patient_id');

            $service_location = DB::table('setting_service_location')
                                ->select('setting_id AS value','setting_name AS name')
                                ->get();

            $service_complexity = DB::table('setting_service_complexity')
                                ->select('setting_id AS value','setting_name AS name')
                                ->get();

            $service_outcome = DB::table('setting_service_outcome')
                                ->select('setting_id AS value','setting_name AS name')
                                ->get();

            $service_category = DB::table('setting_service_category')
                                ->select('setting_id AS value','setting_name AS name')
                                ->get();

            $patient_data = DB::table('patient')
                            ->select('patient.mentari_mrn AS mrn','patient.name', 'patient.birthdate',
                                        (DB::raw('CONCAT(COALESCE(patient.nric_no, ""), COALESCE(patient_passport.passport_no, "")) AS nricPassport')),
                                        'patient.phone_no_1 AS contact', 'setting_gender.setting_name AS gender')
                            ->where('patient_id', $patient_id)
                            ->leftJoin('patient_passport', 'patient.patient_id', '=', 'patient_passport.patient_fk')
                            ->leftJoin('setting_gender', 'patient.gender_fk', '=', 'setting_gender.setting_id')
                            ->get();

            http_response_code(200);
            return response([
                'serviceLocation' => $service_location,
                'serviceComplexity' => $service_complexity,
                'serviceOutcome' => $service_outcome,
                'serviceCategory' => $service_category,
                'patientData' => $patient_data,
            ]);


        }catch (RequestException $r){
            http_response_code(400);
            return response([
                'message' => 'Failed to Create data.'
            ]);
        }
    }

    function getProgressNoteMountedData(Request $request){
        try{
            $patient_id = $request->input('patient_id');

            $service_location = DB::table('setting_service_location')
                                ->select('setting_id AS value','setting_name AS name')
                                ->get();

            $service_complexity = DB::table('setting_service_complexity')
                                ->select('setting_id AS value','setting_name AS name')
                                ->get();

            $service_outcome = DB::table('setting_service_outcome')
                                ->select('setting_id AS value','setting_name AS name')
                                ->get();

            $service_category = DB::table('setting_service_category')
                                ->select('setting_id AS value','setting_name AS name')
                                ->get();

            $patient_data = DB::table('patient')
                            ->select('patient.mentari_mrn AS mrn','patient.name', 'patient.birthdate',
                                        (DB::raw('CONCAT(COALESCE(patient.nric_no, ""), COALESCE(patient_passport.passport_no, "")) AS nricPassport')),
                                        'patient.phone_no_1 AS contact', 'setting_gender.setting_name AS gender')
                            ->where('patient_id', $patient_id)
                            ->leftJoin('patient_passport', 'patient.patient_id', '=', 'patient_passport.patient_fk')
                            ->leftJoin('setting_gender', 'patient.gender_fk', '=', 'setting_gender.setting_id')
                            ->get();

            http_response_code(200);
            return response([
                'serviceLocation' => $service_location,
                'serviceComplexity' => $service_complexity,
                'serviceOutcome' => $service_outcome,
                'serviceCategory' => $service_category,
                'patientData' => $patient_data,
            ]);


        }catch (RequestException $r){
            http_response_code(400);
            return response([
                'message' => 'Failed to Create data.'
            ]);
        }
    }

    function getPsychiatryClerkingNoteMountedData(Request $request){
        try{
            $patient_id = $request->input('patient_id');

            $service_location = DB::table('setting_service_location')
                                ->select('setting_id AS value','setting_name AS name')
                                ->get();

            $service_complexity = DB::table('setting_service_complexity')
                                ->select('setting_id AS value','setting_name AS name')
                                ->get();

            $service_outcome = DB::table('setting_service_outcome')
                                ->select('setting_id AS value','setting_name AS name')
                                ->get();

            $service_category = DB::table('setting_service_category')
                                ->select('setting_id AS value','setting_name AS name')
                                ->get();

            $patient_data = DB::table('patient')
                                ->select('patient.mentari_mrn AS mrn','patient.name', 'patient.birthdate',
                                            (DB::raw('CONCAT(COALESCE(patient.nric_no, ""), COALESCE(patient_passport.passport_no, "")) AS nricPassport')),
                                            'patient.phone_no_1 AS contact', 'setting_gender.setting_name AS gender')
                                ->where('patient_id', $patient_id)
                                ->leftJoin('patient_passport', 'patient.patient_id', '=', 'patient_passport.patient_fk')
                                ->leftJoin('setting_gender', 'patient.gender_fk', '=', 'setting_gender.setting_id')
                                ->get();

            http_response_code(200);
            return response([
                'serviceLocation' => $service_location,
                'serviceComplexity' => $service_complexity,
                'serviceOutcome' => $service_outcome,
                'serviceCategory' => $service_category,
                'patientData' => $patient_data
            ]);


        }catch (RequestException $r){
            http_response_code(400);
            return response([
                'message' => 'Failed to Create data.'
            ]);
        }
    }

    function getInternalReferralLetterMountedData(Request $request){
        try{
            $patient_id = $request->input('patient_id');

            $patient_data = DB::table('patient')
                                ->select('patient.name', 'patient.birthdate', 'patient.phone_no_1 AS contact',
                                        (DB::raw('CONCAT(COALESCE(patient.nric_no, ""), COALESCE(patient_passport.passport_no, "")) AS nricPassport')),
                                        (DB::raw('CONCAT_WS(" ", COALESCE(patient_address.address1, ""), COALESCE(patient_address.address2, ""),
                                        COALESCE(patient_address.address3, ""), COALESCE(setting_postcode.setting_name, ""),
                                        COALESCE(setting_city.setting_name, ""), COALESCE(setting_state.setting_name, "")) AS address')))
                                ->where('patient_id', $patient_id)
                                ->leftJoin('patient_passport', 'patient.patient_id', '=', 'patient_passport.patient_fk')
                                ->leftJoin('patient_address', function ($join) {
                                    $join->on('patient.patient_id', '=', 'patient_address.patient_fk')
                                        ->leftJoin('setting_state', 'patient_address.state_fk', '=', 'setting_state.setting_id')
                                        ->leftJoin('setting_city', 'patient_address.city_fk', '=', 'setting_city.setting_id')
                                        ->leftJoin('setting_postcode', 'patient_address.postcode_fk', '=', 'setting_postcode.setting_id');
                                    })
                                ->get();

            http_response_code(200);
            return response([
                'patientData' => $patient_data
            ]);


        }catch (RequestException $r){
            http_response_code(400);
            return response([
                'message' => 'Failed to Create data.'
            ]);
        }
    }

    function getOccupationalTherapyReferralFormMountedData(Request $request){
        try{
            $patient_id = $request->input('patient_id');

            $patient_data = DB::table('patient')
                                ->select('patient.mentari_mrn AS mrn','patient.name', 'patient.birthdate',
                                            (DB::raw('CONCAT(COALESCE(patient.nric_no, ""), COALESCE(patient_passport.passport_no, "")) AS nricPassport')),
                                            'patient.phone_no_1 AS contact', 'setting_gender.setting_name AS gender')
                                ->where('patient_id', $patient_id)
                                ->leftJoin('patient_passport', 'patient.patient_id', '=', 'patient_passport.patient_fk')
                                ->leftJoin('setting_gender', 'patient.gender_fk', '=', 'setting_gender.setting_id')
                                ->get();

            http_response_code(200);
            return response([
                'patientData' => $patient_data
            ]);


        }catch (RequestException $r){
            http_response_code(400);
            return response([
                'message' => 'Failed to Create data.'
            ]);
        }
    }

    function getConsultationDischargeNoteMountedData(Request $request){
        try{
            $patient_id = $request->input('patient_id');

            $discharge_category = DB::table('setting_discharge_category')
                                ->select('setting_id AS value', 'setting_name AS name')
                                ->get();

            $patient_data = DB::table('patient')
                                ->select('patient.mentari_mrn AS mrn','patient.name', 'patient.birthdate',
                                            (DB::raw('CONCAT(COALESCE(patient.nric_no, ""), COALESCE(patient_passport.passport_no, "")) AS nricPassport')),
                                            'patient.phone_no_1 AS contact', 'setting_gender.setting_name AS gender')
                                ->where('patient_id', $patient_id)
                                ->leftJoin('patient_passport', 'patient.patient_id', '=', 'patient_passport.patient_fk')
                                ->leftJoin('setting_gender', 'patient.gender_fk', '=', 'setting_gender.setting_id')
                                ->get();

            http_response_code(200);
            return response([
                'patientData' => $patient_data,
                'dischargeCategory' => $discharge_category
            ]);


        }catch (RequestException $r){
            http_response_code(400);
            return response([
                'message' => 'Failed to Create data.'
            ]);
        }
    }

    function requestAppointmentPartialRegistration(Request $request){
        try{

            $req_appt = json_decode($request->input("requestAppointmentData"));
            $nric_passport = !empty($req_appt->nricPassport) ? $req_appt->nricPassport: NULL;
            $name = !empty($req_appt->name) ? $req_appt->name: NULL;
            $contact = !empty($req_appt->contact) ? $req_appt->contact: NULL;
            $email = !empty($req_appt->email) ? $req_appt->email: NULL;

            $patient_nric_fk = DB::table('patient')
                                ->where('nric_no', '=', $nric_passport)
                                ->value('patient_id');

            $patient_passport_fk = DB::table('patient_passport')
                                    ->where('passport_no', $nric_passport)
                                    ->value('patient_fk');

            $patient_fk = "";
            if(!empty($patient_nric_fk)){
                $patient_fk = $patient_nric_fk;
            }
            if(!empty($patient_passport_fk)){
                $patient_fk = $patient_passport_fk;
            }

            $message = 'Patient Already Existed!';
            if(empty($patient_fk)){
                $patientData = array('name' =>$name, 'phone_no_1' => $contact, 'email' => $email);
                $patient_fk = DB::table('patient')-> insertGetId($patientData);
                $message = 'Patient Registered Partially';
            }

            http_response_code(200);
            return response([
                'message' => $message,
                'patientId' => $patient_fk
            ]);


        }catch (RequestException $r){
            http_response_code(400);
            return response([
                'message' => 'Failed to Create data.'
            ]);
        }
    }

    function deleteRequestAppointment(Request $request){
        try{
            $request_appointment_id = $request->input('requestAppointmentId');

            $query = DB::table('request_appointment')->where('request_appointment_id', '=', $request_appointment_id)->delete();


            http_response_code(200);
            return response([
                'message' => 'Data successfully deleted.',
                'reqAppt' => $query,
            ]);

        }catch (RequestException $r){
            http_response_code(400);
            return response([
                'message' => 'Failed to Delete data.'
            ]);
        }
    }

    function postTest(Request $request){
        try{
            $type = $request->input('type');
            $score = $request->input('score');

            $data = array('psychometric_id' => $type,'psychometric_score' =>$score);
            $query = DB::table('psychometric_result')-> insertGetId($data);

            http_response_code(200);
            return response([
                'message' => 'Data successfully Created.',
                'id' => $query
            ]);

        }catch (RequestException $r){
            http_response_code(400);
            return response([
                'message' => 'Failed to Create data.'
            ]);
        }
    }

    function getTestRange(Request $request){
        try{
            $type = $request->input('type');
            $query = DB::table('psychometric_range')
                        ->select('range_min_value', 'range_max_value','range_label', 'range_label_bm', 'range_description', 'range_description_bm')
                        ->where('psychometric_id', $type)
                        ->get();

            http_response_code(200);
            return response([
                'message' => 'Data inserted successfully.',
                'data' => $query
            ]);


        }catch (RequestException $r){
            http_response_code(400);
            return response([
                'message' => 'Failed to Create data.'
            ]);
        }
    }

}

