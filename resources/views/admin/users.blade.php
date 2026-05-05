<x-admin-layout>
    <x-slot name="title">Manajemen Pengguna</x-slot>

    <div class="mb-8 flex justify-between items-end">
        <div>
            <h1 class="text-3xl font-bold text-on-surface">Manajemen Pengguna</h1>
            <p class="text-base text-on-surface-variant mt-1">Kelola hak akses dan peran seluruh pengguna dalam sistem.</p>
        </div>
        <button class="bg-primary-container text-on-primary px-6 py-2.5 rounded-xl font-bold flex items-center gap-2 shadow-lg shadow-primary-container/20 hover:bg-primary transition-all active:scale-95">
            <span class="material-symbols-outlined">person_add</span> Tambah Pengguna
        </button>
    </div>

    <!-- User Table -->
    <div class="bg-surface-container-lowest border border-outline-variant rounded-2xl overflow-hidden shadow-sm">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-surface-container-low text-[10px] font-bold text-on-surface-variant uppercase tracking-widest border-b border-outline-variant">
                    <th class="px-6 py-4">Nama & Email</th>
                    <th class="px-6 py-4">Role</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Terdaftar Pada</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant">
                @foreach($users as $user)
                <tr class="hover:bg-surface-container-low transition-colors group">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-surface-container-high flex items-center justify-center font-bold text-primary">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-on-surface">{{ $user->name }}</p>
                                <p class="text-xs text-on-surface-variant">{{ $user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider 
                            {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700' : ($user->role === 'petani' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700') }}">
                            {{ $user->role }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-green-500"></span>
                            <span class="text-xs font-medium">Aktif</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-on-surface-variant">
                        {{ $user->created_at->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <button class="p-2 text-on-surface-variant hover:text-primary hover:bg-primary/10 rounded-lg">
                                <span class="material-symbols-outlined text-[20px]">edit</span>
                            </button>
                            <button class="p-2 text-on-surface-variant hover:text-red-500 hover:bg-red-50 rounded-lg">
                                <span class="material-symbols-outlined text-[20px]">delete</span>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-admin-layout>
