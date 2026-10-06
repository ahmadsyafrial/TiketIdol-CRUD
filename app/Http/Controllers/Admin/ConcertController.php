<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Concert;
use App\Models\TicketCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ConcertController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $status = $request->query('status');

        $query = Concert::withCount(['ticketCategories', 'orders'])->with('ticketCategories');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('artist_name', 'like', "%{$search}%")
                  ->orWhere('venue_name', 'like', "%{$search}%");
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        $concerts = $query->orderBy('concert_date', 'asc')->paginate(10);

        return view('admin.concerts.index', compact('concerts', 'search', 'status'));
    }

    public function create()
    {
        return view('admin.concerts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'artist_name' => 'required|string|max:255',
            'fandom_name' => 'nullable|string|max:255',
            'venue_name' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'concert_date' => 'required|date',
            'gate_open_time' => 'required|string|max:100',
            'poster_url' => 'nullable|url|max:500',
            'banner_url' => 'nullable|url|max:500',
            'description' => 'required|string',
            'terms_conditions' => 'nullable|string',
            'promoter_name' => 'required|string|max:255',
            'status' => 'required|in:upcoming,active,sold_out,completed',
            'is_featured' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(5);
        $validated['is_featured'] = $request->has('is_featured');

        $concert = Concert::create($validated);

        return redirect()->route('admin.concerts.show', $concert->id)
                         ->with('success', 'Konser idol baru berhasil ditambahkan! Silakan tambahkan kategori tiket untuk konser ini.');
    }

    public function show($id)
    {
        $concert = Concert::with(['ticketCategories', 'orders.attendees'])->findOrFail($id);
        return view('admin.concerts.show', compact('concert'));
    }

    public function edit($id)
    {
        $concert = Concert::findOrFail($id);
        return view('admin.concerts.edit', compact('concert'));
    }

    public function update(Request $request, $id)
    {
        $concert = Concert::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'artist_name' => 'required|string|max:255',
            'fandom_name' => 'nullable|string|max:255',
            'venue_name' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'concert_date' => 'required|date',
            'gate_open_time' => 'required|string|max:100',
            'poster_url' => 'nullable|url|max:500',
            'banner_url' => 'nullable|url|max:500',
            'description' => 'required|string',
            'terms_conditions' => 'nullable|string',
            'promoter_name' => 'required|string|max:255',
            'status' => 'required|in:upcoming,active,sold_out,completed',
            'is_featured' => 'boolean',
        ]);

        $validated['is_featured'] = $request->has('is_featured');

        $concert->update($validated);

        return redirect()->route('admin.concerts.show', $concert->id)
                         ->with('success', 'Informasi konser berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $concert = Concert::findOrFail($id);
        $title = $concert->title;
        $concert->delete();

        return redirect()->route('admin.concerts.index')
                         ->with('success', "Konser '{$title}' dan seluruh kategorinya berhasil dihapus.");
    }
}
