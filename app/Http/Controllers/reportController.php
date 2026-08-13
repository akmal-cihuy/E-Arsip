<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Document;
use App\Models\Folder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ReportController extends Controller {
    public function index(Request $request) {
        $query = Document::with(['category', 'folder', 'user']);

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('folder_id')) {
            $query->where('folder_id', $request->folder_id);
        }
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        if ($request->filled('date_start') && $request->filled('date_end')) {
            $query->whereBetween('document_date', [$request->date_start, $request->date_end]);
        }

        $totalDocs = (clone $query)->count();
        $totalDownloads = (clone $query)->sum('download_count');
        $totalSize = (clone $query)->sum('file_size');
        $documents = $query->latest()->paginate(15)->withQueryString();

        $categories = Category::all();
        $folders = Folder::all();
        $users = User::all();

        // Export CSV / Excel
        if ($request->get('export') === 'csv') {
            return $this->exportCsv($query->get());
        }

        return view('reports.index', compact(
            'documents', 'categories', 'folders', 'users',
            'totalDocs', 'totalDownloads', 'totalSize'
        ));
    }

    private function exportCsv($docs) {
        $filename = "laporan_arsip_" . date('Ymd_His') . ".csv";
        $handle = fopen('php://output', 'w');

        ob_start();
        fputcsv($handle, ['Nama Dokumen', 'Kategori', 'Folder', 'Uploader', 'Tgl Dokumen', 'Tipe', 'Ukuran (Byte)', 'Total Download']);

        foreach ($docs as $d) {
            fputcsv($handle, [
                $d->name,
                $d->category->name ?? '-',
                $d->folder->name ?? 'Root',
                $d->user->name ?? '-',
                $d->document_date->format('Y-m-d'),
                $d->file_type,
                $d->file_size,
                $d->download_count
            ]);
        }

        fclose($handle);
        $content = ob_get_clean();

        return Response::make($content, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }
}