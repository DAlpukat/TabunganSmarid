<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{

    // Menampilkan daftar semua berita untuk admin
    public function index()
    {
        $announcements = Announcement::latest()->paginate(10);
        return view('announcements.admin_index', compact('announcements'));
    }

    public function publicIndex()
    {
        $announcements = Announcement::latest()->paginate(9); // Tampilkan 9 berita per halaman
        return view('announcements.public_index', compact('announcements'));
    }

    // Menampilkan form untuk membuat berita baru
    public function create()
    {
        return view('announcements.create');
    }

    // Menyimpan berita baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $data = $request->only('title', 'content');
        $data['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('announcements', 'public');
        }

        Announcement::create($data);

        return redirect()->route('announcements.index')->with('success', 'Berita berhasil dibuat!');
    }

    // Menampilkan detail berita (bisa untuk admin atau user biasa)
    public function show(Announcement $announcement)
    {
        return view('announcements.show', compact('announcement'));
    }

    // Menampilkan form untuk edit berita
    public function edit(Announcement $announcement)
    {
        return view('announcements.edit', compact('announcement'));
    }

    // Mengupdate data berita
    public function update(Request $request, Announcement $announcement)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $data = $request->only('title', 'content');

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($announcement->image_path) {
                Storage::disk('public')->delete($announcement->image_path);
            }
            $data['image_path'] = $request->file('image')->store('announcements', 'public');
        }

        $announcement->update($data);

        return redirect()->route('announcements.index')->with('success', 'Berita berhasil diperbarui!');
    }

    // Menghapus berita
    public function destroy(Announcement $announcement)
    {
        if ($announcement->image_path) {
            Storage::disk('public')->delete($announcement->image_path);
        }
        
        $announcement->delete();

        return redirect()->route('announcements.index')->with('success', 'Berita berhasil dihapus!');
    }
}