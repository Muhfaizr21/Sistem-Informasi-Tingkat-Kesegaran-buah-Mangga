<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function users()
    {
        $users = \App\Models\User::where('id', '!=', auth()->id())->latest()->get();
        return view('admin.users', compact('users'));
    }

    public function mapping()
    {
        return view('admin.mapping');
    }

    public function qualityMonitor()
    {
        return view('admin.quality-monitor');
    }

    public function harvestReport()
    {
        $reports = \App\Models\HarvestReport::with('user')->latest()->get();
        return view('admin.harvest-report', compact('reports'));
    }

    public function apiIntegration()
    {
        return view('admin.api-integration');
    }

    public function config()
    {
        return view('admin.config');
    }
}
