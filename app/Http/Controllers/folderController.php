<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FolderController extends Controller {
    public function index() {
        $folders = Folder::withCount('documents')
            ->whereNull('parent_id')
            ->with('subfolders')
            ->latest()
            ->paginate(12);

        $allFolders = Folder::all();
        return view('folders.index', compact('folders', 'allFolders'));
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:folders,id',
        ]);

        $folder = Folder::create([
            'name' => $request->name,
            'description' => $request->description,
            'parent_id' => $request->parent_id,
            'created_by' => Auth::id(),
        ]);

        ActivityLog::log('Buat Folder', "Membuat folder baru: {$folder->name}");

        return redirect()->route('folders.index')->with('success', 'Folder berhasil dibuat.');
    }

    public function show(Folder $folder) {
        $folder->load(['subfolders.documents', 'documents.category', 'documents.user', 'parent']);
        $subfolders = $folder->subfolders()->withCount('documents')->get();
        $documents = $folder->documents()->with(['category', 'user'])->latest()->paginate(10);
        $allFolders = Folder::where('id', '!=', $folder->id)->get();

        return view('folders.show', compact('folder', 'subfolders', 'documents', 'allFolders'));
    }

    public function update(Request $request, Folder $folder) {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:folders,id|different:id',
        ]);

        $folder->update($request->only('name', 'description', 'parent_id'));
        ActivityLog::log('Edit Folder', "Mengubah data folder: {$folder->name}");

        return back()->with('success', 'Folder berhasil diperbarui.');
    }

    public function destroy(Folder $folder) {
        $name = $folder->name;
        $folder->delete();
        ActivityLog::log('Hapus Folder', "Menghapus folder {$name}");

        return redirect()->route('folders.index')->with('success', 'Folder berhasil dihapus.');
    }
}