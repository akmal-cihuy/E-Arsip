<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Document;
use App\Models\Folder;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller {
    public function index() {
        $totalDocs = Document::count();
        $totalFolders = Folder::count();
        $totalCategories = Category::count();
        $totalUsers = User::count();
        $totalStorageBytes = Document::sum('file_size');

        $formattedStorage = $this->formatBytes($totalStorageBytes);
        $recentDocs = Document::with(['category', 'user'])->latest()->take(5)->get();
        $recentActivities = ActivityLog::with('user')->latest()->take(6)->get();

        // 1. Data Dokumen per Bulan (Tahun Berjalan)
        $monthlyDocs = Document::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
        ->whereYear('created_at', date('Y'))
        ->groupBy('month')
        ->pluck('count', 'month')->toArray();

        $chartMonthlyData = [];
        for ($m = 1; $m <= 12; $m++) {
            $chartMonthlyData[] = $monthlyDocs[$m] ?? 0;
        }

        // 2. Data Dokumen per Kategori
        $categoryData = Category::withCount('documents')->get();
        $chartCategoryLabels = $categoryData->pluck('name')->toArray();
        $chartCategoryData = $categoryData->pluck('documents_count')->toArray();

        return view('dashboard.index', compact(
            'totalDocs', 'totalFolders', 'totalCategories', 'totalUsers', 'formattedStorage',
            'recentDocs', 'recentActivities', 'chartMonthlyData', 'chartCategoryLabels', 'chartCategoryData'
        ));
    }

    private function formatBytes($bytes): string {
        if ($bytes >= 1073741824) return number_format($bytes / 1073741824, 2) . ' GB';
        if ($bytes >= 1048576) return number_format($bytes / 1048576, 2) . ' MB';
        if ($bytes >= 1024) return number_format($bytes / 1024, 2) . ' KB';
        return $bytes . ' B';
    }
}