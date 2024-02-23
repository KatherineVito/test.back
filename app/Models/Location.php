<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $guarded = [];
    protected $fillable = ['dni_number_pet','date_enrollment_pet','lastname_pet', 'name_pet', 'lastname_owner', 'name_owner', 'cellphone_owner','email_owner','ip_extra_information','country_code_extra_information','country_name_extra_information', 'region_department_or_state_extra_information', 'province_extra_information', 'district_extra_information'];

}
