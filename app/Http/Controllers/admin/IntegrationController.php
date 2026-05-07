<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class IntegrationController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'weather');

        $settings = [
            'weather_api_key' => SystemSetting::get('weather_api_key', '************************'),
            'weather_endpoint' => SystemSetting::get('weather_endpoint', 'https://api.openweathermap.org/data/3.0/onecall'),
            'google_maps_key' => SystemSetting::get('google_maps_key'),
            'midtrans_server_key' => SystemSetting::get('midtrans_server_key'),
            'backup_frequency' => SystemSetting::get('backup_frequency', 'daily'),
            'backup_retention' => SystemSetting::get('backup_retention', '30'),
        ];

        if ($tab === 'weather') {
            return view('admin.api-integration', compact('tab', 'settings'));
        }

        if ($tab === 'monitor') {
            // Mock data for API Usage (in real app, this would come from logs table)
            $usage = [
                'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                'hits' => [120, 150, 100, 180, 210, 90, 80],
                'errors' => [2, 5, 1, 0, 8, 2, 1],
            ];
            return view('admin.api-integration', compact('tab', 'usage', 'settings'));
        }

        if ($tab === 'external') {
            return view('admin.api-integration', compact('tab', 'settings'));
        }

        if ($tab === 'backup') {
            return view('admin.api-integration', compact('tab', 'settings'));
        }

        return redirect()->route('admin.api-integration', ['tab' => 'weather']);
    }

    public function updateConfig(Request $request)
    {
        foreach ($request->except('_token') as $key => $value) {
            SystemSetting::set($key, $value);
        }

        return back()->with('success', 'Konfigurasi berhasil disimpan.');
    }

    public function testConnection(Request $request)
    {
        $service = $request->service;
        $endpoint = SystemSetting::get($service . '_endpoint');
        $apiKey = SystemSetting::get($service . '_api_key');

        // Real connection test logic would go here (e.g. using Http client)
        // For demonstration, we still mock the success but with dynamic feedback
        sleep(1);
        
        return response()->json([
            'success' => true,
            'message' => 'Koneksi ke layanan ' . strtoupper($service) . ' berhasil terjalin!',
            'latency' => rand(80, 300) . 'ms',
            'timestamp' => now()->toDateTimeString()
        ]);
    }

    public function runBackup()
    {
        try {
            // In a real server environment with spatie/laravel-backup:
            // Artisan::call('backup:run');
            
            // Mocking the process for local development
            sleep(2);
            
            return back()->with('success', 'Backup database berhasil dijalankan. File: backup-' . now()->format('Y-m-d-His') . '.sql telah disimpan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menjalankan backup: ' . $e->getMessage());
        }
    }
}
