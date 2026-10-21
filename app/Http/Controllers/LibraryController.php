<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLibrary;
use App\Http\Requests\UpdatedLibrary;
use App\Models\library;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return response()->json([
            'status' => 'success',
            'message' => 'Library retrieved successfully',
            'data' => library::query()
                ->latest()
                ->paginate(10)
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLibrary $request)
    {
        //
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;
        $library = library::create($data);
        return response()->json([
            'status' => 'success',
            'message' => 'Library created successfully',
            'data' => $library
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $library = library::findorfail($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Library retrieved successfully',
            'data' => $library
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatedLibrary $request, string $id)
    {
        //
        $library = library::findorfail($id);
        $data = $request->validated();
        $library->update($data);
        return response()->json([
            'status' => 'success',
            'message' => 'Library updated successfully',
            'data' => $library
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $library = library::findorfail($id);
        $library->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Library deleted successfully'
        ]); 
    }
}
