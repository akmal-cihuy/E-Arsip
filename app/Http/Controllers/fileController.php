<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\file;
use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class fileController extends Controller {
    public function index(Request $request) {
        $query = File::with(['category', 'folder', 'user']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('file_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('folder_id')) {
            $query->where('folder_id', $request->folder_id);
        }

        if ($request->filled('date_start') && $request->filled('date_end')) {
            $query->whereBetween('file_date', [$request->date_start, $request->date_end]);
        }

        $files = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::all();
        $folders = Folder::all();

        return view('files.index', compact('files', 'categories', 'folders'));
    }

    public function create() {
        $categories = Category::all();
        $folders = Folder::all();
        return view('files.create', compact('categories', 'folders'));
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'folder_id' => 'nullable|exists:folders,id',
            'file_date' => 'required|date',
            'description' => 'nullable|string',
            'status' => 'required|in:aktif,rahasia,arsip_lama',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,zip|max:20480', // Max 20MB
        ]);

        $uploadedFile = $request->file('file');
        $extension = $uploadedFile->getClientOriginalExtension();
        $fileName = time() . '_' . Str::slug(pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $extension;
        $filePath = $uploadedFile->storeAs('files', $fileName, 'public');

        $file = File::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'folder_id' => $request->folder_id,
            'user_id' => Auth::id(),
            'file_date' => $request->file_date,
            'description' => $request->description,
            'status' => $request->status,
            'file_name' => $uploadedFile->getClientOriginalName(),
            'file_path' => $filePath,
            'file_type' => strtolower($extension),
            'file_size' => $uploadedFile->getSize(),
        ]);

        ActivityLog::log('Upload File', "Mengunggah file {$file->name}", $file->id);

        return redirect()->route('files.show', $file->id)->with('success', 'File berhasil diunggah.');
    }

    public function show(File $file) {
        $file->load(['category', 'folder', 'user', 'activityLogs.user']);
        return view('files.show', compact('file'));
    }

    public function download(File $file) {
        if (!Storage::disk('public')->exists($file->file_path)) {
            abort(404, 'File fisik tidak ditemukan pada server.');
        }

        $file->increment('download_count');
        ActivityLog::log('Download File', "Mengunduh file {$file->name}", $file->id);

        return Storage::disk('public')->download($file->file_path, $file->file_name);
    }

    public function preview(File $file) {
        if (!in_array(strtolower($file->file_type), ['pdf', 'jpg', 'jpeg', 'png'])) {
            return back()->with('error', 'Format file tidak mendukung pratinjau langsung.');
        }

        $path = Storage::disk('public')->path($file->file_path);
        return response()->file($path);
    }

    public function destroy(File $file) {
        if (Storage::disk('public')->exists($file->file_path)) {
            Storage::disk('public')->delete($file->file_path);
        }

        $name = $file->name;
        $file->delete();

        ActivityLog::log('Hapus File', "Menghapus file {$name}");

        return redirect()->route('files.index')->with('success', 'File berhasil dihapus.');
    }
}