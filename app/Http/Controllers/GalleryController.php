<?php

namespace App\Http\Controllers;

use App\Models\GalleryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = GalleryItem::query();

        if ($request->search) {
            $query->where('title', 'like', "%{$request->search}%")
                  ->orWhere('category', 'like', "%{$request->search}%");
        }

        if ($request->category) {
            $query->where('category', $request->category);
        }

        $galleryItems = $query->orderBy('sort_order')->latest()->paginate(20);
        $categories = GalleryItem::distinct()->pluck('category')->filter();
        return view('admin.gallery.index', compact('galleryItems', 'categories'));
    }

    public function create()
    {
        $categories = GalleryItem::distinct()->pluck('category')->filter();
        return view('admin.gallery.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'category' => 'required|string|max:100',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable',
        ]);

        $validated['image'] = $request->file('image')->store('gallery', 'public');
        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        GalleryItem::create($validated);

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery image uploaded successfully.');
    }

    public function edit(GalleryItem $galleryItem)
    {
        $categories = GalleryItem::distinct()->pluck('category')->filter();
        return view('admin.gallery.edit', compact('galleryItem', 'categories'));
    }

    public function update(Request $request, GalleryItem $galleryItem)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'category' => 'required|string|max:100',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable',
        ]);

        if ($request->hasFile('image')) {
            if ($galleryItem->image && Storage::disk('public')->exists($galleryItem->image)) {
                Storage::disk('public')->delete($galleryItem->image);
            }
            $validated['image'] = $request->file('image')->store('gallery', 'public');
        } else {
            unset($validated['image']);
        }

        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $galleryItem->update($validated);

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery image updated successfully.');
    }

    public function destroy(GalleryItem $galleryItem)
    {
        if ($galleryItem->image && Storage::disk('public')->exists($galleryItem->image)) {
            Storage::disk('public')->delete($galleryItem->image);
        }
        $galleryItem->delete();
        return redirect()->route('admin.gallery.index')->with('success', 'Gallery image deleted.');
    }
}
