<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Document;
use App\Models\Folder;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        // 1. Buat Akun Pengguna
        $admin = User::create([
            'name' => 'Administrator E-Arsip',
            'email' => 'admin@perusahaan.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        $petugas = User::create([
            'name' => 'Budi Santoso',
            'email' => 'petugas@perusahaan.com',
            'password' => Hash::make('password123'),
            'role' => 'petugas',
            'is_active' => true,
        ]);

        // 2. Kategori Dokumen
        $categories = [
            ['name' => 'Surat Masuk', 'description' => 'Arsip seluruh korespondensi surat masuk eksternal'],
            ['name' => 'Surat Keluar', 'description' => 'Arsip seluruh surat resmi keluar perusahaan'],
            ['name' => 'Laporan Keuangan', 'description' => 'Audit, neraca, dan laporan tahunan kas'],
            ['name' => 'Kontrak & Kerjasama', 'description' => 'Perjanjian kerja bersama dan MoU pihak ketiga'],
            ['name' => 'SDM & Personalia', 'description' => 'Berkas pegawai, rekrutmen, dan SK pengangkatan'],
        ];

        $categoryModels = [];
        foreach ($categories as $cat) {
            $categoryModels[] = Category::create($cat);
        }

        // 3. Folder Direktori
        $folders = ['Keuangan', 'HRD', 'Legal', 'Marketing', 'Operasional'];
        $folderModels = [];
        foreach ($folders as $folderName) {
            $folderModels[] = Folder::create([
                'name' => $folderName,
                'description' => 'Folder dokumen ' . $folderName,
                'created_by' => $admin->id,
            ]);
        }

        // Buat dummy PDF file pada storage public
        $dummyContent = "%PDF-1.4\n1 0 obj<</Type/Catalog/Pages 2 0 R>>endobj 2 0 obj<</Type/Pages/Kids[3 0 R]/Count 1>>endobj 3 0 obj<</Type/Page/MediaBox[0 0 612 792]/Parent 2 0 R/Resources<<>>>>endobj\nxref\n0 4\n0000000000 65535 f\n0000000010 00000 n\n0000000053 00000 n\n0000000102 00000 n\ntrailer<</Size 4/Root 1 0 R>>\nstartxref\n178\n%%EOF";
        Storage::disk('public')->put('documents/sample_document.pdf', $dummyContent);

        // 4. Seeder Dokumen
        for ($i = 1; $i <= 10; $i++) {
            $doc = Document::create([
                'category_id' => $categoryModels[$i % 5]->id,
                'folder_id' => $folderModels[$i % 5]->id,
                'user_id' => ($i % 2 === 0) ? $admin->id : $petugas->id,
                'name' => 'Dokumen Pengarsipan Contoh ' . $i,
                'file_name' => "dokumen_arsip_{$i}.pdf",
                'file_path' => 'documents/sample_document.pdf',
                'file_type' => 'pdf',
                'file_size' => 1024 * rand(150, 4500),
                'document_date' => now()->subDays(rand(1, 90)),
                'description' => 'Dokumen digital arsip otomatis untuk pengujian sistem.',
                'status' => 'aktif',
            ]);

            ActivityLog::create([
                'user_id' => $doc->user_id,
                'document_id' => $doc->id,
                'activity' => 'Upload Dokumen',
                'description' => "Menambahkan arsip {$doc->name}",
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
            ]);
        }
    }
}