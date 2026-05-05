<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BuyerController extends Controller
{
    public function dashboard()
    {
        return view('buyer.dashboard');
    }

    public function catalog()
    {
        $products = \App\Models\Product::latest()->get();
        return view('buyer.catalog', compact('products'));
    }

    public function orderHistory()
    {
        return view('buyer.order-history');
    }

    public function checkout()
    {
        return view('buyer.checkout');
    }

    public function accountSetting()
    {
        return view('buyer.account-setting');
    }

    public function marketAnalytics()
    {
        return view('buyer.market-analytics');
    }
}
