<x-admin-layout>
    <x-slot name="title">Pengaturan Sistem</x-slot>

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-on-surface tracking-tight">Pengaturan Sistem</h1>
            <p class="text-base text-on-surface-variant mt-1">Kelola parameter inti sistem, notifikasi, dan pantau aktivitas user.</p>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="location.reload()" class="p-2.5 bg-surface-container-low border border-outline-variant text-on-surface-variant rounded-xl hover:bg-white transition-all shadow-sm">
                <span class="material-symbols-outlined text-[20px]">refresh</span>
            </button>
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
    <div class="mb-8 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl flex items-center gap-3 animate-fade-in">
        <span class="material-symbols-outlined">check_circle</span>
        <span class="text-sm font-bold">{{ session('success') }}</span>
    </div>
    @endif

    <!-- Tab Navigation -->
    <div class="flex items-center gap-1 bg-surface-container-low p-1.5 rounded-2xl mb-8 w-fit border border-outline-variant overflow-x-auto max-w-full">
        <a href="{{ route('admin.config', ['tab' => 'general']) }}" 
           class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center gap-2 whitespace-nowrap {{ $tab === 'general' ? 'bg-white text-primary-600 shadow-sm' : 'text-on-surface-variant hover:bg-white/50' }}">
            <span class="material-symbols-outlined text-[18px]">settings</span>
            Umum
        </a>
        <a href="{{ route('admin.config', ['tab' => 'notifications']) }}" 
           class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center gap-2 whitespace-nowrap {{ $tab === 'notifications' ? 'bg-white text-primary-600 shadow-sm' : 'text-on-surface-variant hover:bg-white/50' }}">
            <span class="material-symbols-outlined text-[18px]">notifications</span>
            Notifikasi
        </a>
        <a href="{{ route('admin.config', ['tab' => 'file']) }}" 
           class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center gap-2 whitespace-nowrap {{ $tab === 'file' ? 'bg-white text-primary-600 shadow-sm' : 'text-on-surface-variant hover:bg-white/50' }}">
            <span class="material-symbols-outlined text-[18px]">folder_open</span>
            Manajemen File
        </a>
        <a href="{{ route('admin.config', ['tab' => 'logs']) }}" 
           class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center gap-2 whitespace-nowrap {{ $tab === 'logs' ? 'bg-white text-primary-600 shadow-sm' : 'text-on-surface-variant hover:bg-white/50' }}">
            <span class="material-symbols-outlined text-[18px]">history</span>
            Log & Audit
        </a>
    </div>

    <form action="{{ route('admin.config.update') }}" method="POST">
        @csrf
        
        @if($tab === 'general')
        <!-- GENERAL CONFIG -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-surface-container-lowest border border-outline-variant rounded-[40px] p-8 premium-shadow">
                <h3 class="text-xl font-bold text-on-surface mb-6">Nama Sistem & Logo</h3>
                <div class="space-y-6">
                    <div>
                        <label class="block text-xs font-black text-on-surface-variant uppercase tracking-widest mb-2">Nama Aplikasi</label>
                        <input type="text" name="app_name" value="{{ $settings['app_name'] }}" class="w-full bg-surface border-outline-variant rounded-2xl px-4 py-3 text-sm font-bold focus:ring-primary-500">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-on-surface-variant uppercase tracking-widest mb-2">Logo URL</label>
                        <div class="flex gap-4">
                            <input type="text" name="app_logo" value="{{ $settings['app_logo'] }}" class="flex-1 bg-surface border-outline-variant rounded-2xl px-4 py-3 text-sm font-bold focus:ring-primary-500" placeholder="https://example.com/logo.png">
                            <div class="w-12 h-12 rounded-xl bg-surface border border-outline-variant flex items-center justify-center overflow-hidden">
                                @if($settings['app_logo'])
                                    <img src="{{ $settings['app_logo'] }}" class="w-full h-full object-contain">
                                @else
                                    <span class="material-symbols-outlined text-on-surface-variant">image</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-surface-container-lowest border border-outline-variant rounded-[40px] p-8 premium-shadow">
                <h3 class="text-xl font-bold text-on-surface mb-6">Regional & Localization</h3>
                <div class="space-y-6">
                    <div>
                        <label class="block text-xs font-black text-on-surface-variant uppercase tracking-widest mb-2">Timezone</label>
                        <select name="timezone" class="w-full bg-surface border-outline-variant rounded-2xl px-4 py-3 text-sm font-bold focus:ring-primary-500">
                            <option value="Asia/Jakarta" {{ $settings['timezone'] == 'Asia/Jakarta' ? 'selected' : '' }}>Asia/Jakarta (WIB)</option>
                            <option value="Asia/Makassar" {{ $settings['timezone'] == 'Asia/Makassar' ? 'selected' : '' }}>Asia/Makassar (WITA)</option>
                            <option value="Asia/Jayapura" {{ $settings['timezone'] == 'Asia/Jayapura' ? 'selected' : '' }}>Asia/Jayapura (WIT)</option>
                            <option value="UTC" {{ $settings['timezone'] == 'UTC' ? 'selected' : '' }}>Universal Coordinated Time (UTC)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-on-surface-variant uppercase tracking-widest mb-2">Bahasa Default</label>
                        <select name="locale" class="w-full bg-surface border-outline-variant rounded-2xl px-4 py-3 text-sm font-bold focus:ring-primary-500">
                            <option value="id" {{ $settings['locale'] == 'id' ? 'selected' : '' }}>Bahasa Indonesia</option>
                            <option value="en" {{ $settings['locale'] == 'en' ? 'selected' : '' }}>English</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 bg-surface-container-lowest border border-outline-variant rounded-[40px] p-8 premium-shadow">
                <h3 class="text-xl font-bold text-on-surface mb-6">Email Configuration (SMTP)</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div>
                        <label class="block text-xs font-black text-on-surface-variant uppercase tracking-widest mb-2">Host</label>
                        <input type="text" name="mail_host" value="{{ $settings['mail_host'] }}" class="w-full bg-surface border-outline-variant rounded-2xl px-4 py-3 text-sm font-bold focus:ring-primary-500">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-on-surface-variant uppercase tracking-widest mb-2">Port</label>
                        <input type="text" name="mail_port" value="{{ $settings['mail_port'] }}" class="w-full bg-surface border-outline-variant rounded-2xl px-4 py-3 text-sm font-bold focus:ring-primary-500">
                    </div>
                    <div class="md:col-span-2 flex items-end">
                        <button type="submit" class="w-full py-3.5 bg-primary-600 text-white rounded-2xl font-bold premium-shadow hover:bg-primary-700 transition-all">Simpan Konfigurasi Umum</button>
                    </div>
                </div>
            </div>
        </div>

        @elseif($tab === 'notifications')
        <!-- NOTIFICATIONS CONFIG -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded-[40px] p-8 premium-shadow max-w-4xl">
            <h3 class="text-xl font-bold text-on-surface mb-8">Notification Channels</h3>
            <div class="space-y-6">
                <!-- Email Alert -->
                <div class="flex items-center justify-between p-6 bg-surface rounded-3xl border border-outline-variant">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-primary-50 text-primary-600 flex items-center justify-center">
                            <span class="material-symbols-outlined">mail</span>
                        </div>
                        <div>
                            <p class="font-bold text-on-surface">Email Alert</p>
                            <p class="text-xs text-on-surface-variant">Kirim notifikasi laporan dan sistem via email.</p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="hidden" name="notify_email" value="0">
                        <input type="checkbox" name="notify_email" value="1" {{ $settings['notify_email'] == '1' ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-14 h-8 bg-surface-container-high rounded-full peer peer-checked:after:translate-x-6 after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-primary-600"></div>
                    </label>
                </div>

                <!-- SMS Alert -->
                <div class="flex items-center justify-between p-6 bg-surface rounded-3xl border border-outline-variant">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center">
                            <span class="material-symbols-outlined">sms</span>
                        </div>
                        <div>
                            <p class="font-bold text-on-surface">SMS Alert (Optional)</p>
                            <p class="text-xs text-on-surface-variant">Layanan pesan singkat untuk notifikasi kritikal.</p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="hidden" name="notify_sms" value="0">
                        <input type="checkbox" name="notify_sms" value="1" {{ $settings['notify_sms'] == '1' ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-14 h-8 bg-surface-container-high rounded-full peer peer-checked:after:translate-x-6 after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-primary-600"></div>
                    </label>
                </div>

                <!-- Push Notification -->
                <div class="flex items-center justify-between p-6 bg-surface rounded-3xl border border-outline-variant">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                            <span class="material-symbols-outlined">send_to_mobile</span>
                        </div>
                        <div>
                            <p class="font-bold text-on-surface">Push Notification</p>
                            <p class="text-xs text-on-surface-variant">Notifikasi langsung ke aplikasi mobile petani.</p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="hidden" name="notify_push" value="0">
                        <input type="checkbox" name="notify_push" value="1" {{ $settings['notify_push'] == '1' ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-14 h-8 bg-surface-container-high rounded-full peer peer-checked:after:translate-x-6 after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-primary-600"></div>
                    </label>
                </div>
            </div>
            <div class="mt-8">
                <button type="submit" class="w-full py-4 bg-primary-600 text-white rounded-3xl font-bold premium-shadow hover:bg-primary-700 transition-all">Simpan Pengaturan Notifikasi</button>
            </div>
        </div>

        @elseif($tab === 'file')
        <!-- FILE MANAGEMENT CONFIG -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-surface-container-lowest border border-outline-variant rounded-[40px] p-8 premium-shadow">
                <h3 class="text-xl font-bold text-on-surface mb-6">Limitasi & Izin</h3>
                <div class="space-y-6">
                    <div>
                        <label class="block text-xs font-black text-on-surface-variant uppercase tracking-widest mb-2">Upload Ukuran Max (KB)</label>
                        <input type="number" name="max_upload_size" value="{{ $settings['max_upload_size'] }}" class="w-full bg-surface border-outline-variant rounded-2xl px-4 py-3 text-sm font-bold focus:ring-primary-500">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-on-surface-variant uppercase tracking-widest mb-2">Allowed File Types</label>
                        <input type="text" name="allowed_files" value="{{ $settings['allowed_files'] }}" class="w-full bg-surface border-outline-variant rounded-2xl px-4 py-3 text-sm font-bold focus:ring-primary-500" placeholder="jpg,png,pdf">
                    </div>
                    <button type="submit" class="w-full py-3.5 bg-primary-600 text-white rounded-2xl font-bold premium-shadow hover:bg-primary-700 transition-all">Update File Limits</button>
                </div>
            </div>

            <div class="bg-surface-container-lowest border border-outline-variant rounded-[40px] p-8 premium-shadow">
                <h3 class="text-xl font-bold text-on-surface mb-6">Storage Management</h3>
                <div class="space-y-6">
                    <div class="p-6 bg-surface rounded-3xl border border-outline-variant">
                        <p class="text-[10px] font-black text-on-surface-variant uppercase mb-4">Penyimpanan Saat Ini</p>
                        <div class="h-4 w-full bg-surface-container-high rounded-full overflow-hidden mb-4">
                            <div class="h-full bg-primary-600 rounded-full" style="width: 45%"></div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-bold">4.5 GB / 10 GB</span>
                            <span class="text-xs text-on-surface-variant">45% digunakan</span>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <button type="button" class="flex-1 py-3 bg-surface border border-outline-variant rounded-xl text-xs font-bold hover:bg-white transition-all">Bersihkan Cache</button>
                        <button type="button" class="flex-1 py-3 bg-surface border border-outline-variant rounded-xl text-xs font-bold hover:bg-white transition-all">Optimasi Gambar</button>
                    </div>
                </div>
            </div>
        </div>

        @elseif($tab === 'logs')
        <!-- LOG & AUDIT TAB -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded-[40px] overflow-hidden premium-shadow">
            <div class="p-8 border-b border-outline-variant flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold text-on-surface">Activity Log & Audit</h3>
                    <p class="text-sm text-on-surface-variant">Jejak aktivitas seluruh pengguna sistem.</p>
                </div>
                <button type="button" class="px-6 py-2.5 bg-surface border border-outline-variant rounded-xl text-sm font-bold hover:bg-white transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">download</span>
                    Export Compliance Report
                </button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-surface">
                        <tr>
                            <th class="px-8 py-4 text-[10px] font-black text-on-surface-variant uppercase tracking-widest">Waktu</th>
                            <th class="px-8 py-4 text-[10px] font-black text-on-surface-variant uppercase tracking-widest">Pengguna</th>
                            <th class="px-8 py-4 text-[10px] font-black text-on-surface-variant uppercase tracking-widest">Aksi</th>
                            <th class="px-8 py-4 text-[10px] font-black text-on-surface-variant uppercase tracking-widest">Tabel</th>
                            <th class="px-8 py-4 text-[10px] font-black text-on-surface-variant uppercase tracking-widest">IP Address</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant">
                        @forelse($logs as $log)
                        <tr class="hover:bg-surface/50 transition-colors">
                            <td class="px-8 py-5 text-sm font-medium text-on-surface-variant">{{ \Carbon\Carbon::parse($log->created_at)->format('d M Y H:i:s') }}</td>
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center text-xs font-bold text-primary-600">
                                        {{ substr($log->user_name, 0, 1) }}
                                    </div>
                                    <span class="text-sm font-bold text-on-surface">{{ $log->user_name }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider {{ str_contains($log->aksi, 'Hapus') ? 'bg-red-50 text-red-600' : (str_contains($log->aksi, 'Update') ? 'bg-amber-50 text-amber-600' : 'bg-emerald-50 text-emerald-600') }}">
                                    {{ $log->aksi }}
                                </span>
                            </td>
                            <td class="px-8 py-5 text-sm font-bold text-on-surface-variant">{{ $log->tabel_terkait }}</td>
                            <td class="px-8 py-5 text-[11px] font-mono text-on-surface-variant opacity-60">{{ $log->ip_address }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-20 text-center">
                                <span class="material-symbols-outlined text-6xl text-outline-variant mb-4">history</span>
                                <p class="text-on-surface-variant font-bold">Belum ada log aktivitas tercatat.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($logs->hasPages())
            <div class="p-8 bg-surface">
                {{ $logs->links() }}
            </div>
            @endif
        </div>
        @endif
    </form>
</x-admin-layout>
