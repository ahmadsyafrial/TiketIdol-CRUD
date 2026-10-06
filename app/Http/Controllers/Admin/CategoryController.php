<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Concert;
use App\Models\TicketCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function store(Request $request, $concertId)
    {
        $concert = Concert::findOrFail($concertId);

        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'code' => 'nullable|string|max:30',
            'type' => 'required|in:standing,seated',
            'color_hex' => 'required|string|max:10',
            'price' => 'required|numeric|min:0',
            'quota' => 'required|integer|min:1',
            'benefits' => 'nullable|string',
            'entry_gate' => 'required|string|max:100',
            'seat_section' => 'nullable|string|max:100',
        ]);

        $validated['concert_id'] = $concert->id;
        $validated['available_quota'] = $validated['quota'];
        $validated['is_active'] = true;

        TicketCategory::create($validated);

        return redirect()->route('admin.concerts.show', $concert->id)
                         ->with('success', "Kategori tiket '{$validated['name']}' berhasil ditambahkan ke konser.");
    }

    public function update(Request $request, $id)
    {
        $category = TicketCategory::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'code' => 'nullable|string|max:30',
            'type' => 'required|in:standing,seated',
            'color_hex' => 'required|string|max:10',
            'price' => 'required|numeric|min:0',
            'quota' => 'required|integer|min:1',
            'available_quota' => 'required|integer|min:0',
            'benefits' => 'nullable|string',
            'entry_gate' => 'required|string|max:100',
            'seat_section' => 'nullable|string|max:100',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $category->update($validated);

        return redirect()->route('admin.concerts.show', $category->concert_id)
                         ->with('success', "Kategori tiket '{$category->name}' berhasil diperbarui.");
    }

    public function destroy($id)
    {
        $category = TicketCategory::findOrFail($id);
        $concertId = $category->concert_id;
        $categoryName = $category->name;
        $category->delete();

        return redirect()->route('admin.concerts.show', $concertId)
                         ->with('success', "Kategori tiket '{$categoryName}' berhasil dihapus.");
    }
}
