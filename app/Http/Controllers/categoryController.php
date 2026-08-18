<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller {
    public function index() {
        $categories = Category::withCount('documents')->latest()->paginate(10);
        return view('categories.index', compact('categories'));
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:100|unique:categories,name',
            'description' => 'nullable|string|max:255',
        ]);

        $cat = Category::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        ActivityLog::log('Buat Kategori', "Menambahkan kategori arsip {$cat->name}");

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, Category $category) {
        $request->validate([
            'name' => 'required|string|max:100|unique:categories,name,' . $category->id,
            'description' => 'nullable|string|max:255',
        ]);

        $category->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        ActivityLog::log('Edit Kategori', "Mengubah kategori arsip {$category->name}");

        return back()->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category) {
        if ($category->documents()->count() > 0) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih memiliki dokumen terkait.');
        }

        $name = $category->name;
        $category->delete();
        ActivityLog::log('Hapus Kategori', "Menghapus kategori arsip {$name}");

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}