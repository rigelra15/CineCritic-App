<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Film;
use App\Models\Genre;
use App\Models\Cast;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FilmController extends Controller
{
    public function index(Request $request)
    {
        $query = Film::with('genre');

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $films = $query->paginate(10);

        return view('films.index', compact('films'));
    }


    public function show($id)
    {
        $film = Film::with('genre')->findOrFail($id);
        return view('films.show', compact('film'));
    }

    public function create()
    {
        return view('films.create', [
            'genres' => Genre::all(),
            'casts' => Cast::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'required',
            'release_year' => 'required|string|max:4',
            'poster_method' => 'required|in:upload,url',
            'poster_file' => 'nullable|required_if:poster_method,upload|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'poster_url' => 'nullable|required_if:poster_method,url|url',
            'genre_id' => 'required|exists:genres,id'
        ]);

        $posterPath = null;
        if ($request->poster_method === 'upload' && $request->hasFile('poster_file')) {
            $posterPath = $request->file('poster_file')->store('posters', 'public');
        } elseif ($request->poster_method === 'url') {
            $posterPath = $request->poster_url;
        }

        $film = Film::create([
            'title' => $request->title,
            'summary' => $request->summary,
            'release_year' => $request->release_year,
            'poster' => $posterPath,
            'genre_id' => $request->genre_id
        ]);

        $film->casts()->sync(explode(',', $request->cast_ids) ?? []);

        return redirect()->route('films.index')->with('success', 'Film berhasil ditambahkan!');
    }


    public function edit(Film $film)
    {
        $genres = Genre::all();
        $casts = Cast::all();
        return view('films.edit', compact('film', 'genres', 'casts'));
    }


    public function update(Request $request, Film $film)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'required',
            'release_year' => 'required|string|max:4',
            'poster_method' => 'required|in:upload,url',
            'poster_file' => 'nullable|required_if:poster_method,upload|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'poster_url' => 'nullable|required_if:poster_method,url|url',
            'genre_id' => 'required|exists:genres,id'
        ]);

        $posterPath = $film->poster;
        if ($request->poster_method === 'upload' && $request->hasFile('poster_file')) {
            if ($film->poster && !Str::startsWith($film->poster, 'http')) {
                Storage::disk('public')->delete($film->poster);
            }
            $posterPath = $request->file('poster_file')->store('posters', 'public');
        } elseif ($request->poster_method === 'url') {
            $posterPath = $request->poster_url;
        }

        $film->update([
            'title' => $request->title,
            'summary' => $request->summary,
            'release_year' => $request->release_year,
            'poster' => $posterPath,
            'genre_id' => $request->genre_id
        ]);

        $film->casts()->sync(explode(',', $request->cast_ids) ?? []);

        return redirect()->route('films.index')->with('success', 'Film berhasil diperbarui!');
    }


    public function destroy(Film $film)
    {
        $film->delete();
        return redirect()->route('films.index')->with('success', 'Film berhasil dihapus!');
    }

    public function __construct()
    {
        $this->middleware('auth')->only(['create', 'store', 'edit', 'update', 'destroy']);
        $this->middleware('admin')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }
}
