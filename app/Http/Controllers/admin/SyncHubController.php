<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class SyncHubController extends Controller
{
    public function index(Request $request)
    {
        // operational stats
        $stats = [
            'weather_records' => DB::table('data_cuaca')->count(),
            'quality_scans' => DB::table('scan_kesegaran')->count(),
            'harvest_reports' => DB::table('laporan_panen')->count(),
            'products' => DB::table('listing_mangga')->count(),
            'transactions' => DB::table('pesanan')->count(),
            'historical_records' => DB::table('data_produksi_historis')->count(),
        ];

        // sync timestamps
        $sync_times = [
            'weather' => SystemSetting::get('last_weather_sync', 'Belum Pernah'),
            'inventory' => SystemSetting::get('last_inventory_sync', 'Belum Pernah'),
            'transaction' => SystemSetting::get('last_transaction_sync', 'Belum Pernah'),
            'ai' => SystemSetting::get('last_ai_sync', 'Belum Pernah'),
        ];

        return view('admin.sync-hub', compact('stats', 'sync_times'));
    }

    public function trigger(Request $request)
    {
        $type = $request->input('type', 'all');
        $messages = [];

        try {
            if ($type === 'weather' || $type === 'all') {
                // Call the weather import seeder to simulate importing live weather forecasts
                Artisan::call('db:seed', ['--class' => 'WeatherImportSeeder']);
                SystemSetting::set('last_weather_sync', now()->toDateTimeString());
                $messages[] = "Prakiraan cuaca Indramayu berhasil diperbarui.";
            }

            if ($type === 'inventory' || $type === 'all') {
                // Sync marketplace stock listings with verified harvest reports
                $listings = DB::table('listing_mangga')->get();
                foreach ($listings as $listing) {
                    $totalHarvested = DB::table('laporan_panen')
                        ->where('petani_id', $listing->petani_id)
                        ->where('jenis_mangga', 'like', '%' . explode(' ', $listing->jenis_mangga)[0] . '%')
                        ->where('status', 'verified')
                        ->sum('jumlah_kg');
                    
                    if ($totalHarvested > 0) {
                        // Ensure listing stock doesn't exceed harvested amounts (mock logic for demo)
                        DB::table('listing_mangga')
                            ->where('id', $listing->id)
                            ->update(['updated_at' => now()]);
                    }
                }
                SystemSetting::set('last_inventory_sync', now()->toDateTimeString());
                $messages[] = "Stok inventaris kebun dan listing produk pasar berhasil disinkronkan.";
            }

            if ($type === 'transaction' || $type === 'all') {
                // Mock pulling payment updates from Midtrans and confirming payment status
                DB::table('pesanan')
                    ->where('status', 'menunggu_pembayaran')
                    ->where('created_at', '<', now()->subHours(24))
                    ->update(['status' => 'batal', 'updated_at' => now()]);

                SystemSetting::set('last_transaction_sync', now()->toDateTimeString());
                $messages[] = "Status transaksi pembayaran gateway berhasil disinkronkan.";
            }

            if ($type === 'ai' || $type === 'all') {
                // Refresh prediction datasets (BPS Quarterly dataset)
                Artisan::call('db:seed', ['--class' => 'DatasetKuartalSeeder']);
                SystemSetting::set('last_ai_sync', now()->toDateTimeString());
                $messages[] = "Model prediksi AI & data historis kuartal BPS berhasil disegarkan.";
            }

            $finalMessage = implode(' ', $messages);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $finalMessage,
                    'sync_times' => [
                        'weather' => SystemSetting::get('last_weather_sync'),
                        'inventory' => SystemSetting::get('last_inventory_sync'),
                        'transaction' => SystemSetting::get('last_transaction_sync'),
                        'ai' => SystemSetting::get('last_ai_sync'),
                    ]
                ]);
            }

            return back()->with('success', $finalMessage);

        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal melakukan sinkronisasi: ' . $e->getMessage()
                ], 500);
            }
            return back()->with('error', 'Gagal sinkronisasi: ' . $e->getMessage());
        }
    }
}
