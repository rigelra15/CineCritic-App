<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Film;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['index']);
    }

    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'admin') {
            $reviews = Review::with('film', 'user')->latest()->paginate(10);
        } else {
            $reviews = Review::with('film')
                ->where('user_id', Auth::id())
                ->latest()
                ->paginate(10);
        }

        return view('reviews.index', compact('reviews'));
    }

    public function store(Request $request, $filmId)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'point' => 'required|integer|min:1|max:5'
        ]);

        $film = Film::findOrFail($filmId);

        if (Review::where('user_id', Auth::id())->where('film_id', $film->id)->exists()) {
            return redirect()->back()->with('error', 'Anda sudah memberikan review untuk film ini.');
        }

        Review::create([
            'user_id' => Auth::id(),
            'film_id' => $film->id,
            'content' => $request->content,
            'point' => $request->point
        ]);

        return redirect()->route('reviews.index')->with('success', 'Review berhasil ditambahkan!');
    }

    public function destroy(Review $review)
    {
        $user = Auth::user();

        if ($user->role !== 'admin') {
            return abort(403, 'Anda tidak memiliki izin untuk menghapus review ini.');
        }

        $review->delete();
        return redirect()->route('reviews.index')->with('success', 'Review berhasil dihapus.');
    }
}
