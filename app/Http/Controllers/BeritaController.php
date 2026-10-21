<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBeritaRequest;
use App\Http\Requests\UpdatedBerita;
use App\Models\Berita;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return response()->json([
            'status' => 'success',
            'message' => 'Berita retrieved successfully',
            'data' => Berita::query()
                ->latest()
                ->paginate(10)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBeritaRequest $request)
    {
        //
        $data = $request->validated();

        $gambarPath = null;

        // Cek apakah user mengirim file fisik dari komputer
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('berita', 'public');
        }
        // Jika dikirim sebagai string (misal URL / teks)
        else if (is_string($request->gambar)) {
            $gambarPath = $request->gambar;
        }

        // Timpa key 'gambar' dengan path yang benar (baik itu path storage atau string URL)
        $data['gambar'] = $gambarPath;


        $berita = Berita::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Berita created successfully',
            'data' => $berita
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $berita = Berita::find($id);

        if (!$berita) {
            return response()->json([
                'status' => 'error',
                'message' => 'Berita tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Berita retrieved successfully',
            'data' => $berita
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatedBerita $request, string $id)
    {
        //
        $berita = Berita::find($id);

        if (!$berita) {
            return response()->json([
                'status' => 'error',
                'message' => 'Berita tidak ditemukan'
            ], 404);
        }

        $data = $request->validated();

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        $berita->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Berita updated successfully',
            'data' => $berita
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $berita = Berita::findOrFail($id);

        $berita->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Berita deleted successfully'
        ]);
    }
}
