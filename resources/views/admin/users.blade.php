<x-admin-layout>
    <x-slot name="title">Manajemen Pengguna</x-slot>

    <!-- Page Header -->
    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-end gap-4" x-data="{ showAddModal: false }">
        <div>
            <h1 class="text-4xl font-bold text-on-surface tracking-tight">Manajemen <span class="gradient-text">Pengguna</span></h1>
            <p class="text-on-surface-variant mt-2 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-primary-500"></span>
                Kelola hak akses dan peran seluruh pengguna dalam sistem.
            </p>
        </div>
        <button @click="$dispatch('open-user-modal')" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-2xl font-bold flex items-center gap-2 transition-all hover:scale-105 active:scale-95 premium-shadow">
            <span class="material-symbols-outlined">person_add</span> Tambah Pengguna
        </button>
    </div>

    <!-- Advanced Search & Filters -->
    <div class="bg-white/50 backdrop-blur-xl border border-white/20 rounded-3xl p-6 mb-8 premium-shadow">
        <form action="{{ route('admin.users') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1 relative">
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." 
                    class="w-full pl-12 pr-4 py-3 bg-white/50 border border-outline-variant rounded-2xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition-all">
            </div>
            <div class="w-full md:w-48">
                <select name="role" class="w-full px-4 py-3 bg-white/50 border border-outline-variant rounded-2xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition-all">
                    <option value="">Semua Role</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="petani" {{ request('role') == 'petani' ? 'selected' : '' }}>Petani</option>
                    <option value="pembeli" {{ request('role') == 'pembeli' ? 'selected' : '' }}>Pembeli</option>
                </select>
            </div>
            <button type="submit" class="bg-surface-container-high text-on-surface px-8 py-3 rounded-2xl font-bold hover:bg-surface-container-highest transition-all">
                Filter
            </button>
            @if(request()->anyFilled(['search', 'role']))
                <a href="{{ route('admin.users') }}" class="flex items-center justify-center px-4 py-3 text-red-500 hover:bg-red-50 rounded-2xl transition-all">
                    <span class="material-symbols-outlined">close</span>
                </a>
            @endif
        </form>
    </div>

    <!-- User Table Card -->
    <div class="bg-white/80 backdrop-blur-xl border border-white/20 rounded-[2rem] overflow-hidden premium-shadow" x-data="{ selectedUser: null }">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low/50 text-[11px] font-bold text-on-surface-variant uppercase tracking-widest border-b border-outline-variant">
                        <th class="px-8 py-5">Identitas Pengguna</th>
                        <th class="px-8 py-5 text-center">Peran Sistem</th>
                        <th class="px-8 py-5 text-center">Status Akun</th>
                        <th class="px-8 py-5">Tanggal Bergabung</th>
                        <th class="px-8 py-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant">
                    @forelse($users as $user)
                    <tr class="hover:bg-primary-500/5 transition-colors group">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center font-bold text-primary-700 shadow-inner">
                                    {{ substr($user->nama, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-base font-bold text-on-surface tracking-tight">{{ $user->nama }}</p>
                                    <p class="text-xs text-on-surface-variant">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-center">
                            <span class="inline-flex px-4 py-1.5 rounded-xl text-[10px] font-bold uppercase tracking-wider shadow-sm
                                {{ $user->role === 'admin' ? 'bg-purple-500/10 text-purple-600 border border-purple-500/20' : 
                                   ($user->role === 'petani' ? 'bg-green-500/10 text-green-600 border border-green-500/20' : 
                                   'bg-blue-500/10 text-blue-600 border border-blue-500/20') }}">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-center">
                            <div class="inline-flex items-center gap-2 px-3 py-1 bg-green-500/10 text-green-600 rounded-lg text-[10px] font-bold border border-green-500/20 uppercase tracking-wider">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                Aktif
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <p class="text-sm font-medium text-on-surface-variant">{{ $user->created_at->translatedFormat('d M Y') }}</p>
                            <p class="text-[10px] text-on-surface-variant/60">{{ $user->created_at->diffForHumans() }}</p>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <div class="flex justify-end gap-2">
                                <button @click="$dispatch('open-user-modal', { user: {{ json_encode($user) }} })" 
                                    class="w-10 h-10 flex items-center justify-center text-on-surface-variant hover:text-primary-600 hover:bg-primary-500/10 rounded-xl transition-all">
                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                </button>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-10 h-10 flex items-center justify-center text-on-surface-variant hover:text-red-500 hover:bg-red-500/10 rounded-xl transition-all">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <span class="material-symbols-outlined text-6xl text-on-surface-variant/20 mb-4">search_off</span>
                                <p class="text-lg font-bold text-on-surface-variant">Tidak ada pengguna ditemukan</p>
                                <p class="text-sm text-on-surface-variant/60">Coba ubah kata kunci atau filter Anda</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($users->hasPages())
        <div class="px-8 py-6 bg-surface-container-low/30 border-t border-outline-variant">
            {{ $users->links() }}
        </div>
        @endif
    </div>

    <!-- User Modal (Create/Edit) -->
    <div x-data="{ 
        open: false, 
        editMode: false, 
        userId: '',
        formData: {
            nama: '',
            email: '',
            role: 'petani',
            password: ''
        },
        actionUrl: '{{ route('admin.users.store') }}'
    }" 
    @open-user-modal.window="
        open = true; 
        if($event.detail.user) {
            editMode = true;
            userId = $event.detail.user.id;
            formData.nama = $event.detail.user.nama;
            formData.email = $event.detail.user.email;
            formData.role = $event.detail.user.role;
            formData.password = '';
            actionUrl = '/admin/users/' + userId;
        } else {
            editMode = false;
            formData.nama = '';
            formData.email = '';
            formData.role = 'petani';
            formData.password = '';
            actionUrl = '{{ route('admin.users.store') }}';
        }
    "
    x-show="open" 
    x-cloak
    class="fixed inset-0 z-[100] flex items-center justify-center p-4">
        
        <!-- Overlay -->
        <div class="absolute inset-0 bg-black/60 backdrop-blur-md" @click="open = false" x-transition:enter="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="opacity-100" x-transition:leave-end="opacity-0"></div>

        <!-- Modal Content -->
        <div class="relative w-full max-w-lg bg-white rounded-[2.5rem] p-8 shadow-2xl premium-shadow" x-transition:enter="scale-95 opacity-0" x-transition:enter-end="scale-100 opacity-100">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-bold text-on-surface" x-text="editMode ? 'Edit Pengguna' : 'Tambah Pengguna Baru'"></h2>
                <button @click="open = false" class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-surface-container-high transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <form :action="actionUrl" method="POST" class="space-y-6">
                @csrf
                <template x-if="editMode">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-on-surface-variant ml-1 uppercase tracking-wider">Nama Lengkap</label>
                    <input type="text" name="nama" x-model="formData.nama" required
                        class="w-full px-5 py-4 bg-surface-container-low border border-outline-variant rounded-2xl focus:ring-2 focus:ring-primary-500 outline-none transition-all">
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-on-surface-variant ml-1 uppercase tracking-wider">Alamat Email</label>
                    <input type="email" name="email" x-model="formData.email" required
                        class="w-full px-5 py-4 bg-surface-container-low border border-outline-variant rounded-2xl focus:ring-2 focus:ring-primary-500 outline-none transition-all">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-on-surface-variant ml-1 uppercase tracking-wider">Peran (Role)</label>
                        <select name="role" x-model="formData.role" required
                            class="w-full px-5 py-4 bg-surface-container-low border border-outline-variant rounded-2xl focus:ring-2 focus:ring-primary-500 outline-none transition-all">
                            <option value="admin">Admin</option>
                            <option value="petani">Petani</option>
                            <option value="pembeli">Pembeli</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-on-surface-variant ml-1 uppercase tracking-wider" x-text="editMode ? 'Password (Opsional)' : 'Password'"></label>
                        <input type="password" name="password" x-model="formData.password" :required="!editMode"
                            class="w-full px-5 py-4 bg-surface-container-low border border-outline-variant rounded-2xl focus:ring-2 focus:ring-primary-500 outline-none transition-all">
                    </div>
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white py-4 rounded-2xl font-bold text-lg transition-all hover:scale-[1.02] active:scale-[0.98] premium-shadow">
                        Simpan Data Pengguna
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
