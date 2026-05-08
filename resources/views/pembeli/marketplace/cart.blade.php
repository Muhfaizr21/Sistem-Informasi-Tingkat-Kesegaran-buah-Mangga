@extends('layouts.pembeli')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="relative animate-in fade-in duration-700" x-data="cartManager()">
    <!-- Header -->
    <div class="mb-12 animate-in fade-in slide-in-from-left duration-700">
        <div class="inline-flex items-center gap-2 text-[0.7rem] font-bold uppercase tracking-[0.2em] mb-3" style="color: var(--mango-green);">
            <span class="w-8 h-[2px]" style="background: var(--gold);"></span>
            Your Selection
        </div>
        <h1 style="font-family: 'Playfair Display', serif; font-size: clamp(2.2rem, 5vw, 3.2rem); line-height: 1.1; color: var(--leaf-dark);">
            Keranjang <span style="color: var(--gold);">Belanja</span>
        </h1>
        <p class="text-sm mt-2" style="color: var(--text-light);">Tinjau kembali pilihan mangga terbaik Anda sebelum dikirim.</p>
    </div>

    @if(session('success'))
    <div class="mb-8 p-6 rounded-[2rem] flex items-center gap-4 shadow-sm animate-in zoom-in duration-500" style="background: rgba(16, 185, 129, 0.05); border: 1px solid rgba(16, 185, 129, 0.1);">
        <div class="w-10 h-10 bg-emerald-500 text-white rounded-full flex items-center justify-center">
            <span class="material-symbols-outlined">check</span>
        </div>
        <span class="font-bold text-emerald-700">{{ session('success') }}</span>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        <!-- Cart Items Column -->
        <div class="lg:col-span-8 space-y-8">
            @if(count($groupedCart) > 0)
            <div class="flex items-center justify-between px-8 py-4 bg-white rounded-3xl border border-var(--gold-pale) shadow-sm">
                <div class="flex items-center gap-3">
                    <label class="relative flex items-center cursor-pointer">
                        <input type="checkbox" @change="toggleSelectAll($event)" :checked="selectAll" class="peer h-6 w-6 cursor-pointer appearance-none rounded-md border border-slate-300 transition-all checked:border-var(--gold) checked:bg-var(--gold) focus:ring-0">
                        <span class="absolute text-white opacity-0 peer-checked:opacity-100 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor" stroke="currentColor" stroke-width="1"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                        </span>
                    </label>
                    <span class="text-xs font-black uppercase tracking-widest" style="color: var(--text-dark);">Pilih Semua</span>
                </div>
                <button @click="removeSelected" x-show="selectedCount > 0" class="text-[10px] font-black uppercase tracking-widest text-red-500 hover:underline">Hapus Terpilih</button>
            </div>
            @endif

            @forelse($groupedCart as $petaniId => $group)
            <div class="bg-white rounded-[2.5rem] border overflow-hidden shadow-sm hover:shadow-md transition-shadow" style="border-color: var(--gold-pale);">
                <div class="px-8 py-5 flex items-center justify-between border-b" style="background: var(--cream); border-color: var(--gold-pale);">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center font-black text-sm" style="background: var(--gold); color: white;">
                            {{ substr($group['petani_nama'], 0, 1) }}
                        </div>
                        <div>
                            <p class="text-[0.6rem] font-black uppercase tracking-widest mb-0.5" style="color: var(--text-light);">Penjual</p>
                            <span class="font-black" style="color: var(--text-dark);">{{ $group['petani_nama'] }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="p-8 space-y-8">
                    @foreach($group['items'] as $id => $item)
                    <div class="flex flex-col sm:flex-row items-center gap-6 group/item" data-id="{{ $id }}" data-price="{{ $item['harga'] }}">
                        <label class="relative flex items-center cursor-pointer">
                            <input type="checkbox" 
                                   value="{{ $id }}" 
                                   x-model="selectedItems"
                                   class="peer h-6 w-6 cursor-pointer appearance-none rounded-md border border-slate-300 transition-all checked:border-var(--gold) checked:bg-var(--gold) focus:ring-0">
                            <span class="absolute text-white opacity-0 peer-checked:opacity-100 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor" stroke="currentColor" stroke-width="1"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            </span>
                        </label>

                        <div class="w-24 h-24 rounded-[1.5rem] overflow-hidden shrink-0 border-2 shadow-sm group-hover/item:scale-105 transition-transform" style="background: var(--gold-pale); border-color: var(--gold-pale);">
                            @if($item['foto'])
                                <img src="{{ str_starts_with($item['foto'], 'http') ? $item['foto'] : asset('storage/' . $item['foto']) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-var(--gold) opacity-20">
                                    <span class="material-symbols-outlined text-4xl">image</span>
                                </div>
                            @endif
                        </div>
                        
                        <div class="flex-1 text-center sm:text-left">
                            <h3 style="font-family: 'Lora', serif; font-size: 1.1rem; font-weight: 600; color: var(--leaf-dark);" class="group-hover/item:text-var(--gold) transition-colors mb-1">{{ $item['nama'] }}</h3>
                            <p class="text-[0.6rem] font-bold uppercase tracking-widest mb-3" style="color: var(--text-light);">
                                Rp{{ number_format($item['harga'], 0, ',', '.') }} <span class="opacity-60">/ kg</span>
                            </p>
                            
                            <div class="flex items-center justify-center sm:justify-start">
                                <div class="inline-flex items-center rounded-xl border border-var(--gold-pale) bg-var(--cream) p-1">
                                    <button @click="updateQty('{{ $id }}', -1)" class="w-8 h-8 rounded-lg flex items-center justify-center hover:bg-white transition-colors" style="color: var(--gold);">
                                        <span class="material-symbols-outlined text-sm">remove</span>
                                    </button>
                                    <span class="w-12 text-center text-xs font-black" style="color: var(--text-dark);" x-text="items['{{ $id }}'].qty">{{ $item['jumlah'] }}</span>
                                    <button @click="updateQty('{{ $id }}', 1)" class="w-8 h-8 rounded-lg flex items-center justify-center hover:bg-white transition-colors" style="color: var(--gold);">
                                        <span class="material-symbols-outlined text-sm">add</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-center sm:text-right min-w-[120px]">
                            <p class="text-[0.6rem] font-bold uppercase tracking-widest mb-1" style="color: var(--text-light);">Subtotal</p>
                            <p class="text-lg font-black" style="color: var(--text-dark);">Rp<span x-text="formatNumber(items['{{ $id }}'].qty * items['{{ $id }}'].price)">{{ number_format($item['harga'] * $item['jumlah'], 0, ',', '.') }}</span></p>
                        </div>
                        
                        <form action="{{ route('pembeli.cart.remove') }}" method="POST" class="shrink-0">
                            @csrf
                            <input type="hidden" name="id" value="{{ $id }}">
                            <button type="submit" class="w-10 h-10 rounded-xl flex items-center justify-center transition-all hover:bg-red-50 hover:text-red-500 active:scale-90" style="color: var(--text-light);">
                                <span class="material-symbols-outlined text-[20px]">delete</span>
                            </button>
                        </form>
                    </div>
                    @if(!$loop->last) <hr style="border-color: var(--gold-pale); opacity: 0.5;"> @endif
                    @endforeach
                </div>
            </div>
            @empty
            <div class="py-20 px-6 bg-white rounded-[3rem] border border-dashed text-center flex flex-col items-center justify-center min-h-[400px]" style="border-color: var(--gold-pale);">
                <div class="w-20 h-20 bg-var(--gold-pale) rounded-full flex items-center justify-center mb-8 relative" style="background: var(--gold-pale);">
                    <span class="material-symbols-outlined text-4xl opacity-20" style="color: var(--gold);">shopping_basket</span>
                    <div class="absolute -top-1 -right-1 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center text-[10px] font-black">0</div>
                </div>
                <h3 style="font-family: 'Playfair Display', serif; font-size: 1.8rem; color: var(--leaf-dark);" class="mb-2">Keranjang Kosong</h3>
                <p class="text-sm max-w-xs mx-auto mb-10" style="color: var(--text-light);">Sepertinya Anda belum menemukan mangga idaman hari ini.</p>
                <a href="{{ route('pembeli.marketplace.katalog') }}" class="inline-flex items-center justify-center px-10 py-4 rounded-xl font-black text-[0.7rem] uppercase tracking-widest transition-all shadow-lg no-underline" style="background: var(--text-dark); color: white;">
                    <span>MULAI BELANJA</span>
                    <span class="material-symbols-outlined text-sm ml-2">arrow_forward</span>
                </a>
            </div>
            @endforelse
        </div>

        <!-- Summary Column -->
        @if(count($groupedCart) > 0)
        <div class="lg:col-span-4">
            <div class="bg-white rounded-[3rem] p-10 border shadow-xl sticky top-24" style="border-color: var(--gold-pale);">
                <h3 style="font-family: 'Playfair Display', serif; font-size: 1.5rem; color: var(--leaf-dark);" class="mb-10 text-center">Ringkasan Belanja</h3>
                
                <div class="space-y-6 mb-10">
                    <div class="flex justify-between items-center">
                        <span class="text-[0.7rem] font-bold uppercase tracking-widest" style="color: var(--text-light);">Subtotal Produk</span>
                        <span class="text-lg font-black" style="color: var(--text-dark);">Rp<span x-text="formatNumber(totalSelectedPrice)">0</span></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-[0.7rem] font-bold uppercase tracking-widest" style="color: var(--text-light);">Biaya Admin</span>
                        <span class="text-lg font-black" style="color: var(--text-dark);" x-text="selectedCount > 0 ? 'Rp2.500' : 'Rp0'">Rp2.500</span>
                    </div>
                    <div class="pt-8 border-t space-y-2" style="border-color: var(--gold-pale);">
                        <p class="text-[0.6rem] font-black uppercase tracking-[0.3em] text-center" style="color: var(--text-light);">Total Pembayaran</p>
                        <p class="text-4xl font-black text-center" style="color: var(--gold);">Rp<span x-text="formatNumber(totalSelectedPrice > 0 ? totalSelectedPrice + 2500 : 0)">0</span></p>
                    </div>
                </div>
                
                <button @click="proceedToCheckout" 
                        :disabled="selectedCount === 0"
                        class="w-full py-5 rounded-2xl font-black text-[0.75rem] tracking-[0.2em] uppercase transition-all shadow-xl active:scale-[0.98] flex items-center justify-center gap-3 disabled:opacity-50 disabled:grayscale"
                        style="background: var(--gold); color: white; box-shadow: 0 10px 25px rgba(212,160,23,0.3);">
                    CHECKOUT (<span x-text="selectedCount">0</span>)
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </button>
                
                <div class="mt-8 flex items-center justify-center gap-2 opacity-30">
                    <span class="material-symbols-outlined text-sm">lock</span>
                    <span class="text-[8px] font-black uppercase tracking-widest">Secured Checkout</span>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function cartManager() {
    return {
        items: {
            @foreach($groupedCart as $group)
                @foreach($group['items'] as $id => $item)
                '{{ $id }}': {
                    id: '{{ $id }}',
                    qty: {{ $item['jumlah'] }},
                    price: {{ $item['harga'] }},
                    minOrder: {{ $item['minimal_order'] }}
                },
                @endforeach
            @endforeach
        },
        selectedItems: [],
        selectAll: false,

        get selectedCount() {
            return this.selectedItems.length;
        },

        get totalSelectedPrice() {
            return this.selectedItems.reduce((total, id) => {
                const item = this.items[id];
                return total + (item.qty * item.price);
            }, 0);
        },

        toggleSelectAll(e) {
            this.selectAll = e.target.checked;
            if (this.selectAll) {
                this.selectedItems = Object.keys(this.items);
            } else {
                this.selectedItems = [];
            }
        },

        updateQty(id, delta) {
            const item = this.items[id];
            const newQty = item.qty + delta;
            
            if (newQty < item.minOrder) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops!',
                    text: `Minimal pembelian untuk produk ini adalah ${item.minOrder} kg`,
                    confirmButtonColor: '#D4A017'
                });
                return;
            }

            // AJAX Update to Session
            $.ajax({
                url: "{{ route('pembeli.cart.update') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    jumlah: newQty
                },
                success: (res) => {
                    if (res.success) {
                        item.qty = newQty;
                    }
                },
                error: (xhr) => {
                    const msg = xhr.responseJSON ? xhr.responseJSON.message : 'Gagal memperbarui stok';
                    Swal.fire({ icon: 'error', title: 'Error', text: msg });
                }
            });
        },

        formatNumber(num) {
            return new Intl.NumberFormat('id-ID').format(num);
        },

        proceedToCheckout() {
            if (this.selectedCount === 0) return;
            
            // Redirect with selected items in query or session
            // For now, let's just pass them as a list.
            const url = new URL("{{ route('pembeli.checkout.index') }}");
            this.selectedItems.forEach(id => url.searchParams.append('items[]', id));
            window.location.href = url.toString();
        },

        removeSelected() {
            Swal.fire({
                title: 'Hapus Terpilih?',
                text: "Item yang dipilih akan dihapus dari keranjang.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#D4A017',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // This would need a batch remove route
                    // Simplified: just loop through and remove
                    alert('Batch remove implementation needed');
                }
            });
        }
    }
}
</script>
@endpush
@endsection
