<?php

namespace App\Http\Controllers;

use App\Http\Requests\tugas\StoreTugas;
use App\Models\Tugas;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

class TugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return response()->json([
            'status' => 'success',
            'message' => 'Tugas retrieved successfully',
            'data' => Tugas::query()
                ->latest()
                ->paginate(10)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTugas $request)
    {
        //
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        $tugas = Tugas::create($data);
        
        return response()->json([
            'status' => 'success',
            'message' => 'Tugas created successfully',
            'data' => $tugas
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $tugas = Tugas::findorfail($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Tugas retrieved successfully',
            'data' => $tugas
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreTugas $request, string $id)
    {
        //
        $tugas = Tugas::findorfail($id);
        $data = $request->validated();
        $tugas->update($data);
        return response()->json([
            'status' => 'success',
            'message' => 'Tugas updated successfully',
            'data' => $tugas
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $tugas = Tugas::findorfail($id);
        $tugas->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Tugas deleted successfully'
        ]);
    }
}
