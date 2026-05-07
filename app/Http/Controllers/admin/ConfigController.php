<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConfigController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'general');

        $settings = [
            'app_name' => SystemSetting::get('app_name', 'MangoFresh Indramayu'),
            'app_logo' => SystemSetting::get('app_logo'),
            'timezone' => SystemSetting::get('timezone', 'Asia/Jakarta'),
            'locale' => SystemSetting::get('locale', 'id'),
            'mail_host' => SystemSetting::get('mail_host', 'smtp.mailtrap.io'),
            'mail_port' => SystemSetting::get('mail_port', '2525'),
            'notify_email' => SystemSetting::get('notify_email', '1'),
            'notify_sms' => SystemSetting::get('notify_sms', '0'),
            'notify_push' => SystemSetting::get('notify_push', '1'),
            'max_upload_size' => SystemSetting::get('max_upload_size', '2048'),
            'allowed_files' => SystemSetting::get('allowed_files', 'jpg,jpeg,png,pdf,xlsx'),
        ];

        if ($tab === 'logs') {
            $logs = DB::table('log_aktivitas')
                ->join('pengguna', 'log_aktivitas.pengguna_id', '=', 'pengguna.id')
                ->select('log_aktivitas.*', 'pengguna.nama as user_name')
                ->orderBy('log_aktivitas.created_at', 'desc')
                ->paginate(15);
            
            return view('admin.config', compact('tab', 'settings', 'logs'));
        }

        return view('admin.config', compact('tab', 'settings'));
    }

    public function update(Request $request)
    {
        foreach ($request->except('_token') as $key => $value) {
            SystemSetting::set($key, $value);
        }

        return back()->with('success', 'Pengaturan sistem berhasil diperbarui.');
    }
}
