<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArtworkController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $artworks = Auth::user()->artworks;

        // Passe a variável $artworks para a view
        return view('artwork.index', ['artworks' => $artworks]);
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('artwork.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Valide os dados do formulário
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5000',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        // Salve a obra de arte no sistema de arquivos (pasta public/images) ou em um serviço de armazenamento como o Amazon S3
        $imagePath = $request->file('image')->store('images', 'public');

        // Crie a obra de arte no banco de dados associada ao usuário autenticado
        Auth::user()->artworks()->create([
            'image_path' => $imagePath,
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        return redirect()->route('artwork.index')->with('status', 'Artwork added successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Artwork $artwork)
    {
        // Verifique se o usuário autenticado é o proprietário da obra de arte
        $this->authorize('update', $artwork);
        return view('artwork.edit', compact('artwork'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Artwork $artwork)
    {
        // Verifique se o usuário autenticado é o proprietário da obra de arte
        $this->authorize('update', $artwork);

        // Valide os dados do formulário
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        // Atualize a obra de arte no banco de dados
        $artwork->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        return redirect()->route('artwork.index')->with('status', 'Artwork updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Artwork $artwork)
    {
        // Verifique se o usuário autenticado é o proprietário da obra de arte
        $this->authorize('delete', $artwork);

        // Exclua a obra de arte do sistema de arquivos (ou do serviço de armazenamento) e do banco de dados
        $artwork->delete();

        return redirect()->route('artwork.index')->with('status', 'Artwork deleted successfully!');
    }
}
