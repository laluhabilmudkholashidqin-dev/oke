<?php

namespace App\Http\Controllers;

use App\Models\FavoriteLocation;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'city' => 'required|string|max:100'
        ]);

        // Check if already exists
        $exists = FavoriteLocation::where('user_id', auth()->id())
                                 ->where('city', $validated['city'])
                                 ->exists();

        if ($exists) {
            return back()->withError('Lokasi ini sudah ada di favorit');
        }

        FavoriteLocation::create([
            'user_id' => auth()->id(),
            'city' => $validated['city']
        ]);

        return back()->with('success', 'Lokasi berhasil ditambahkan ke favorit');
    }

    public function destroy(FavoriteLocation $favorite)
    {
        $this->authorize('delete', $favorite);
        $favorite->delete();

        return back()->with('success', 'Lokasi favorit berhasil dihapus');
    }

    public function getFavorites()
    {
        if (!auth()->check()) {
            return response()->json([], 401);
        }

        $favorites = FavoriteLocation::where('user_id', auth()->id())->get();
        return response()->json($favorites);
    }
}
