<?php

namespace App\Observers;

use App\Models\ListingMangga;
use App\Models\Notifikasi;

class ListingObserver
{
    /**
     * Handle the ListingMangga "created" event.
     */
    public function created(ListingMangga $listingMangga): void
    {
        // Temukan petani
        $petani = $listingMangga->petani;
        if (!$petani) return;

        // Temukan semua pembeli yang memfavoritkan petani ini
        $favorits = $petani->favoritedBy()->with('pembeli.user')->get();

        foreach ($favorits as $fav) {
            if ($fav->pembeli && $fav->pembeli->user) {
                Notifikasi::send(
                    $fav->pembeli->user->id,
                    'stok_baru',
                    'Stok Baru dari Petani Favorit! 🥭',
                    "{$petani->user->nama} baru saja mengunggah stok {$listingMangga->jenis_mangga} baru. Segera cek sebelum kehabisan!",
                    'listing',
                    $listingMangga->id
                );
            }
        }
    }

    /**
     * Handle the ListingMangga "updated" event.
     */
    public function updated(ListingMangga $listingMangga): void
    {
        //
    }

    /**
     * Handle the ListingMangga "deleted" event.
     */
    public function deleted(ListingMangga $listingMangga): void
    {
        //
    }

    /**
     * Handle the ListingMangga "restored" event.
     */
    public function restored(ListingMangga $listingMangga): void
    {
        //
    }

    /**
     * Handle the ListingMangga "force deleted" event.
     */
    public function forceDeleted(ListingMangga $listingMangga): void
    {
        //
    }
}
