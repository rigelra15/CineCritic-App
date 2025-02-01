<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cast;
use App\Models\Film;

class CastController extends Controller
{
    public function index()
    {
        $casts = Cast::orderBy('created_at', 'desc')->paginate(10);
        return view('casts.index', compact('casts'));
    }

    public function create()
    {
        return view('casts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:1',
            'bio' => 'required|string',
            'photo' => 'string|nullable',
        ]);

        Cast::create($request->all());

        return redirect()->route('casts.index')->with('success', 'Cast berhasil ditambahkan!');
    }

    public function show(Cast $cast)
    {
        return view('casts.show', compact('cast'));
    }

    public function edit(Cast $cast)
    {
        return view('casts.edit', compact('cast'));
    }

    public function update(Request $request, Cast $cast)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:1',
            'bio' => 'required|string',
            'photo' => 'string|nullable',
        ]);

        $cast->update($request->all());

        return redirect()->route('casts.index')->with('success', 'Cast berhasil diperbarui!');
    }

    public function destroy(Cast $cast)
    {
        $cast->delete();

        return redirect()->route('casts.index')->with('success', 'Cast berhasil dihapus!');
    }
}
