<?php

namespace Database\Seeders;

use App\Models\SystemSetting;
use Illuminate\Database\Seeder;

class SystemSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            'app_name' => 'MangoFresh Indramayu',
            'app_logo' => '/storage/logo/logo.png',
            'timezone' => 'Asia/Jakarta',
            'locale' => 'id',
            'mail_host' => 'smtp.mailtrap.io',
            'mail_port' => '2525',
            'notify_email' => '1',
            'notify_sms' => '0',
            'notify_push' => '1',
            'max_upload_size' => '2048',
            'allowed_files' => 'jpg,jpeg,png,pdf,xlsx',
        ];

        foreach ($settings as $key => $value) {
            SystemSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'group' => 'general', 'type' => 'string']
            );
        }
    }
}
