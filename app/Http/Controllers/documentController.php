<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Document;
use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentController extends Controller {
    public function index(Request $request) {
        $query = Document::with(['category', 'folder', 'user']);

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
            $query->whereBetween('document_date', [$request->date_start, $request->date_end]);
        }

        $documents = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::all();
        $folders = Folder::all();

        return view('documents.index', compact('documents', 'categories', 'folders'));
    }

    public function create() {
        $categories = Category::all();
        $folders = Folder::all();
        return view('documents.create', compact('categories', 'folders'));
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'folder_id' => 'nullable|exists:folders,id',
            'document_date' => 'required|date',
            'description' => 'nullable|string',
            'status' => 'required|in:aktif,rahasia,arsip_lama',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,zip|max:20480', // Max 20MB
        ]);

        $uploadedFile = $request->file('file');
        $extension = $uploadedFile->getClientOriginalExtension();
        $fileName = time() . '_' . Str::slug(pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $extension;
        $filePath = $uploadedFile->storeAs('documents', $fileName, 'public');

        $doc = Document::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'folder_id' => $request->folder_id,
            'user_id' => Auth::id(),
            'document_date' => $request->document_date,
            'description' => $request->description,
            'status' => $request->status,
            'file_name' => $uploadedFile->getClientOriginalName(),
            'file_path' => $filePath,
            'file_type' => strtolower($extension),
            'file_size' => $uploadedFile->getSize(),
        ]);

        ActivityLog::log('Upload Dokumen', "Mengunggah arsip {$doc->name} (#{$doc->document_number})", $doc->id);

        return redirect()->route('documents.show', $doc->id)->with('success', 'Dokumen berhasil diunggah.');
    }

    public function show(Document $document) {
        $document->load(['category', 'folder', 'user', 'activityLogs.user']);
        return view('documents.show', compact('document'));
    }

    public function download(Document $document) {
        if (!Storage::disk('public')->exists($document->file_path)) {
            abort(404, 'File fisik tidak ditemukan pada server.');
        }

        $document->increment('download_count');
        ActivityLog::log('Download Dokumen', "Mengunduh file {$document->name}", $document->id);

        return Storage::disk('public')->download($document->file_path, $document->file_name);
    }

    public function preview(Document $document) {
        if (!in_array(strtolower($document->file_type), ['pdf', 'jpg', 'jpeg', 'png'])) {
            return back()->with('error', 'Format file tidak mendukung pratinjau langsung.');
        }

        $path = Storage::disk('public')->path($document->file_path);
        return response()->file($path);
    }

    public function destroy(Document $document) {
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $name = $document->name;
        $document->delete();

        ActivityLog::log('Hapus Dokumen', "Menghapus dokumen {$name}");

        return redirect()->route('documents.index')->with('success', 'Dokumen berhasil dihapus.');
    }
}