<?php

use App\CompanySetting;
use Illuminate\Database\Seeder;

class CompanySettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!CompanySetting::exists()){
            $company_setting = new CompanySetting();
            $company_setting->company_name = 'YNWA Company';
            $company_setting->company_email = 'jojhani97@gmail.com';
            $company_setting->company_phone = '09798585669';
            $company_setting->company_address = 'No(123) , 4th Floor , Yangon';
            $company_setting->company_start_time = '09:00:00';
            $company_setting->company_end_time = '18:00:00';
            $company_setting->company_break_start = '12:00:00';
            $company_setting->company_break_end = '13:00:00';
            $company_setting->save();
        }
    }
}
