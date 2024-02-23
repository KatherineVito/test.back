<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['dni_number_pet' => '78206913','date_enrollment_pet' => '2021-03-21','lastname_pet' => 'ss','name_pet' => 'ss','lastname_owner' => 'as','name_owner' => 'ds','cellphone_owner' => '959556632','email_owner' => 'lg@gmail.com','ip_extra_information' => '23.235.60.92','country_code_extra_information' => 'US','country_name_extra_information' => 'United States','region_department_or_state_extra_information' => 'California','province_extra_information' => 'none','district_extra_information' => 'none'],
            ['dni_number_pet' => '51685572','date_enrollment_pet' => '2021-03-21','lastname_pet' => 'ss','name_pet' => 'ss','lastname_owner' => 'as','name_owner' => 'ds','cellphone_owner' => '959556632','email_owner' => 'lg@gmail.com','ip_extra_information' => '23.235.60.92','country_code_extra_information' => 'US','country_name_extra_information' => 'United States','region_department_or_state_extra_information' => 'California','province_extra_information' => 'none','district_extra_information' => 'none'],
            ['dni_number_pet' => '71685572','date_enrollment_pet' => '2021-03-21','lastname_pet' => 'ss','name_pet' => 'ss','lastname_owner' => 'as','name_owner' => 'ds','cellphone_owner' => '959556632','email_owner' => 'lg@gmail.com','ip_extra_information' => '23.235.60.92','country_code_extra_information' => 'US','country_name_extra_information' => 'United States','region_department_or_state_extra_information' => 'California','province_extra_information' => 'none','district_extra_information' => 'none'],
            ['dni_number_pet' => '91685572','date_enrollment_pet' => '2021-03-21','lastname_pet' => 'ss','name_pet' => 'ss','lastname_owner' => 'as','name_owner' => 'ds','cellphone_owner' => '959556632','email_owner' => 'lg@gmail.com','ip_extra_information' => '23.235.60.92','country_code_extra_information' => 'US','country_name_extra_information' => 'United States','region_department_or_state_extra_information' => 'California','province_extra_information' => 'none','district_extra_information' => 'none'],
            ['dni_number_pet' => '11685572','date_enrollment_pet' => '2021-03-21','lastname_pet' => 'ss','name_pet' => 'ss','lastname_owner' => 'as','name_owner' => 'ds','cellphone_owner' => '959556632','email_owner' => 'lg@gmail.com','ip_extra_information' => '23.235.60.92','country_code_extra_information' => 'US','country_name_extra_information' => 'United States','region_department_or_state_extra_information' => 'California','province_extra_information' => 'none','district_extra_information' => 'none'],
            ['dni_number_pet' => '21685572','date_enrollment_pet' => '2021-03-21','lastname_pet' => 'ss','name_pet' => 'ss','lastname_owner' => 'as','name_owner' => 'ds','cellphone_owner' => '959556632','email_owner' => 'lg@gmail.com','ip_extra_information' => '23.235.60.92','country_code_extra_information' => 'US','country_name_extra_information' => 'United States','region_department_or_state_extra_information' => 'California','province_extra_information' => 'none','district_extra_information' => 'none'],
            ['dni_number_pet' => '31685572','date_enrollment_pet' => '2021-03-21','lastname_pet' => 'ss','name_pet' => 'ss','lastname_owner' => 'as','name_owner' => 'ds','cellphone_owner' => '959556632','email_owner' => 'lg@gmail.com','ip_extra_information' => '23.235.60.92','country_code_extra_information' => 'US','country_name_extra_information' => 'United States','region_department_or_state_extra_information' => 'California','province_extra_information' => 'none','district_extra_information' => 'none'],
            ['dni_number_pet' => '41685572','date_enrollment_pet' => '2021-03-21','lastname_pet' => 'ss','name_pet' => 'ss','lastname_owner' => 'as','name_owner' => 'ds','cellphone_owner' => '959556632','email_owner' => 'lg@gmail.com','ip_extra_information' => '23.235.60.92','country_code_extra_information' => 'US','country_name_extra_information' => 'United States','region_department_or_state_extra_information' => 'California','province_extra_information' => 'none','district_extra_information' => 'none'],
            ['dni_number_pet' => '61685572','date_enrollment_pet' => '2021-03-21','lastname_pet' => 'ss','name_pet' => 'ss','lastname_owner' => 'as','name_owner' => 'ds','cellphone_owner' => '959556632','email_owner' => 'lg@gmail.com','ip_extra_information' => '23.235.60.92','country_code_extra_information' => 'US','country_name_extra_information' => 'United States','region_department_or_state_extra_information' => 'California','province_extra_information' => 'none','district_extra_information' => 'none'],
            ['dni_number_pet' => '81685572','date_enrollment_pet' => '2021-03-21','lastname_pet' => 'ss','name_pet' => 'ss','lastname_owner' => 'as','name_owner' => 'ds','cellphone_owner' => '959556632','email_owner' => 'lg@gmail.com','ip_extra_information' => '23.235.60.92','country_code_extra_information' => 'US','country_name_extra_information' => 'United States','region_department_or_state_extra_information' => 'California','province_extra_information' => 'none','district_extra_information' => 'none'],
            ['dni_number_pet' => '52685572','date_enrollment_pet' => '2021-03-21','lastname_pet' => 'ss','name_pet' => 'ss','lastname_owner' => 'as','name_owner' => 'ds','cellphone_owner' => '959556632','email_owner' => 'lg@gmail.com','ip_extra_information' => '23.235.60.92','country_code_extra_information' => 'US','country_name_extra_information' => 'United States','region_department_or_state_extra_information' => 'California','province_extra_information' => 'none','district_extra_information' => 'none'],
            ['dni_number_pet' => '53685572','date_enrollment_pet' => '2021-03-21','lastname_pet' => 'ss','name_pet' => 'ss','lastname_owner' => 'as','name_owner' => 'ds','cellphone_owner' => '959556632','email_owner' => 'lg@gmail.com','ip_extra_information' => '23.235.60.92','country_code_extra_information' => 'US','country_name_extra_information' => 'United States','region_department_or_state_extra_information' => 'California','province_extra_information' => 'none','district_extra_information' => 'none'],
            ['dni_number_pet' => '54685572','date_enrollment_pet' => '2021-03-21','lastname_pet' => 'ss','name_pet' => 'ss','lastname_owner' => 'as','name_owner' => 'ds','cellphone_owner' => '959556632','email_owner' => 'lg@gmail.com','ip_extra_information' => '23.235.60.92','country_code_extra_information' => 'US','country_name_extra_information' => 'United States','region_department_or_state_extra_information' => 'California','province_extra_information' => 'none','district_extra_information' => 'none'],
            ['dni_number_pet' => '55685572','date_enrollment_pet' => '2021-03-21','lastname_pet' => 'ss','name_pet' => 'ss','lastname_owner' => 'as','name_owner' => 'ds','cellphone_owner' => '959556632','email_owner' => 'lg@gmail.com','ip_extra_information' => '23.235.60.92','country_code_extra_information' => 'US','country_name_extra_information' => 'United States','region_department_or_state_extra_information' => 'California','province_extra_information' => 'none','district_extra_information' => 'none'],
            ['dni_number_pet' => '56685572','date_enrollment_pet' => '2021-03-21','lastname_pet' => 'ss','name_pet' => 'ss','lastname_owner' => 'as','name_owner' => 'ds','cellphone_owner' => '959556632','email_owner' => 'lg@gmail.com','ip_extra_information' => '23.235.60.92','country_code_extra_information' => 'US','country_name_extra_information' => 'United States','region_department_or_state_extra_information' => 'California','province_extra_information' => 'none','district_extra_information' => 'none'],
            ['dni_number_pet' => '57685572','date_enrollment_pet' => '2021-03-21','lastname_pet' => 'ss','name_pet' => 'ss','lastname_owner' => 'as','name_owner' => 'ds','cellphone_owner' => '959556632','email_owner' => 'lg@gmail.com','ip_extra_information' => '23.235.60.92','country_code_extra_information' => 'US','country_name_extra_information' => 'United States','region_department_or_state_extra_information' => 'California','province_extra_information' => 'none','district_extra_information' => 'none'],
            ['dni_number_pet' => '58685572','date_enrollment_pet' => '2021-03-21','lastname_pet' => 'ss','name_pet' => 'ss','lastname_owner' => 'as','name_owner' => 'ds','cellphone_owner' => '959556632','email_owner' => 'lg@gmail.com','ip_extra_information' => '23.235.60.92','country_code_extra_information' => 'US','country_name_extra_information' => 'United States','region_department_or_state_extra_information' => 'California','province_extra_information' => 'none','district_extra_information' => 'none'],
        ];
        foreach ($data as $value) {
            DB::table('locations')->insert(
                [
                    'dni_number_pet' => $value['dni_number_pet'],
                    'date_enrollment_pet' => $value['date_enrollment_pet'],
                    'lastname_pet' => $value['lastname_pet'],
                    'name_pet' => $value['name_pet'],
                    'lastname_owner' => $value['lastname_owner'],
                    'name_owner' => $value['name_owner'],
                    'cellphone_owner' => $value['cellphone_owner'],
                    'email_owner' => $value['email_owner'],
                    'ip_extra_information' =>$value['ip_extra_information'],
                    'country_code_extra_information' => $value['country_code_extra_information'],
                    'country_name_extra_information' => $value['country_name_extra_information'],
                    'region_department_or_state_extra_information' => $value['region_department_or_state_extra_information'],
                    'province_extra_information' => $value['province_extra_information'],
                    'district_extra_information' => $value['district_extra_information'],
                ]
                );
        }
    }
}
