<?php

namespace App\Http\Controllers;

use App\Models\Concert;
use App\Models\TicketCategory;
use Illuminate\Http\Request;

class ConcertController extends Controller
{
    /**
     * Homepage with featured concerts, banner, and search
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $artist = $request->query('artist');
        $city = $request->query('city');

        $query = Concert::with(['ticketCategories' => function ($q) {
            $q->where('is_active', true)->orderBy('price', 'asc');
        }]);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('artist_name', 'like', "%{$search}%")
                  ->orWhere('venue_name', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
            });
        }

        if ($artist) {
            $query->where('artist_name', 'like', "%{$artist}%");
        }

        if ($city) {
            $query->where('city', 'like', "%{$city}%");
        }

        $concerts = $query->orderBy('is_featured', 'desc')
                          ->orderBy('concert_date', 'asc')
                          ->get();

        $featuredConcerts = Concert::where('is_featured', true)
                                   ->where('status', 'active')
                                   ->take(3)
                                   ->get();

        $artists = Concert::select('artist_name')->distinct()->pluck('artist_name');
        $cities = Concert::select('city')->distinct()->pluck('city');

        return view('concerts.index', compact('concerts', 'featuredConcerts', 'artists', 'cities', 'search', 'artist', 'city'));
    }

    /**
     * Concert detail page with ticket categories & seating layout
     */
    public function show($slug)
    {
        $concert = Concert::with(['ticketCategories' => function ($q) {
            $q->where('is_active', true)->orderBy('price', 'desc');
        }])->where('slug', $slug)->firstOrFail();

        $otherConcerts = Concert::where('id', '!=', $concert->id)
                                ->where('status', 'active')
                                ->take(3)
                                ->get();

        return view('concerts.show', compact('concert', 'otherConcerts'));
    }
}
