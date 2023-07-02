<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Http\Requests\UpdateBikeRequest;
use App\Models\Bike;

class BikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bikes = Bike::with('items')->get();
        $total = $bikes->count();

        return response()->json([
            'status' => true,
            'total' => $total,
            'data' => $bikes,
        ], 200);
    }

    /**
     * Display a listing of the resource with filter parameters.
     */
    public function search(Request $request)
    {
        $query = Bike::query();

        // Filter by BIKE.NAME - exact match
        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        // Filter by BIKE.MANUFACTURER - like match
        if ($request->has('manufacturer')) {
            $query->where('manufacturer', '=', $request->input('manufacturer'));
        }

        // Filter by ITEM.TYPE - like match
        if ($request->has('item_type')) {
            $query->whereHas('items', function ($q) use ($request) {
                $q->where('type', 'like', '%' . $request->input('item_type') . '%');
            });
        }

        // Order by BIKE.NAME (asc/desc)
        if ($request->has('sort')) {
            $sortDirection = $request->input('sort') === 'desc' ? 'desc' : 'asc';
            $query->orderBy('name', $sortDirection);
        }

        $bikes = $query->with('items')->get();
        $total = $bikes->count();

        return response()->json([
            'status' => true,
            'total' => $total,
            'data' => $bikes,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string|min:1|max:100',
                'description' => 'nullable|string|max:65535',
                'price' => 'nullable|numeric|between:0,99999999.99',
                'manufacturer' => 'nullable|string|max:100',
                'item_ids' => 'array|nullable',
                'item_ids.*' => 'exists:items,id',
            ]);
    
            $bike = Bike::create($data);

            if ($request->has('item_ids')) {
                $bike->items()->sync($request->input('item_ids'));
                $bike->load('items');
            }
    
            return response()->json([
                'status' => true,
                'data' => $bike,
            ], 201);

        } catch (ValidationException $exception) {
            return response()->json([
                'status' => false,
                'errors' => $exception->errors()
            ], 400);
        }

        
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $bike = Cache::remember('bike_' . $id, 3600, function () use ($id) {
                return Bike::with('items')->findOrFail($id);
            });
    
            return response()->json([
                'status' => true,
                'data' => $bike,
            ], 201);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'errors' => 'The bike does not exist',
            ], 404);
        }
    }
}
