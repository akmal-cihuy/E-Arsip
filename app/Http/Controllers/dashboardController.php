<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\file;
use App\Models\Folder;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller {
    public function index() {
        $totalFiles = File::count();
        $totalFolders = Folder::count();
        $totalCategories = Category::count();
        $totalUsers = User::count();
        $totalStorageBytes = File::sum('file_size');

        $formattedStorage = $this->formatBytes($totalStorageBytes);
        $recentFiles = File::with(['category', 'user'])->latest()->take(5)->get();
        $recentActivities = ActivityLog::with('user')->latest()->take(6)->get();

        // 1. Data File per Bulan (Tahun Berjalan)
        $monthlyFiles = File::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
        ->whereYear('created_at', date('Y'))
        ->groupBy('month')
        ->pluck('count', 'month')->toArray();

        $chartMonthlyData = [];
        for ($m = 1; $m <= 12; $m++) {
            $chartMonthlyData[] = $monthlyFiles[$m] ?? 0;
        }

        // 2. Data File per Kategori
        $categoryData = Category::withCount('files')->get();
        $chartCategoryLabels = $categoryData->pluck('name')->toArray();
        $chartCategoryData = $categoryData->pluck('files_count')->toArray();

        return view('dashboard.index', compact(
            'totalFiles', 'totalFolders', 'totalCategories', 'totalUsers', 'formattedStorage',
            'recentFiles', 'recentActivities', 'chartMonthlyData', 'chartCategoryLabels', 'chartCategoryData'
        ));
    }

    private function formatBytes($bytes): string {
        if ($bytes >= 1073741824) return number_format($bytes / 1073741824, 2) . ' GB';
        if ($bytes >= 1048576) return number_format($bytes / 1048576, 2) . ' MB';
        if ($bytes >= 1024) return number_format($bytes / 1024, 2) . ' KB';
        return $bytes . ' B';
    }
}