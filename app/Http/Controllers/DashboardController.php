<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\Kategori;
use App\Services\DashboardService;

class DashboardController extends Controller
{
    public function __construct(
        private DashboardService $dashboardService
    ) {}

    public function index()
    {
        if (auth()->user()->role === 'admin') {
            $data = $this->dashboardService->getAdminData();
            return view('admin.dashboard', $data);
        }

        $kendaraans = Kendaraan::where('status', 'tersedia')->latest()->get();

        $kategoris = Kategori::with('kendaraans')->get();

    return view('customer.dashboard', compact('kendaraans', 'kategoris'));
    }
}