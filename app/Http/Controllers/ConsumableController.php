<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consumable;
use App\Http\Requests\StoreConsumableRequest;
use App\Http\Requests\UpdateConsumableRequest;

class ConsumableController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $query = Consumable::with('category');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('name', 'LIKE', '%' . $search . '%');
        }

        if ($request->has('limit') && is_numeric($request->limit)) {
            $query->limit($request->limit);
        }

        $consumables = $query->get();
        return response()->json($consumables);
    }

    /**
     * Display a paginated listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function paginate(Request $request) {
        $query = Consumable::with('category');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('name', 'LIKE', '%' . $search . '%');
        }

        // Filter by category if provided
        if ($request->has('category_id') && !empty($request->category_id)) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by stock status if provided
        if ($request->has('stock_status')) {
            if ($request->stock_status === 'low') {
                // Assuming low stock is less than 10
                $query->where('stock', '<', 10);
            } elseif ($request->stock_status === 'out') {
                $query->where('stock', '<=', 0);
            } elseif ($request->stock_status === 'available') {
                $query->where('stock', '>', 0);
            }
        }

        $perPage = $request->get('per_page', 10); // Default 10 items per page
        $consumables = $query->orderBy('id', 'asc')->paginate($perPage);
        return response()->json($consumables);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreConsumableRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreConsumableRequest $request) {
        $consumable = Consumable::create($request->validated());
        $consumable->load('category');
        return response()->json($consumable, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $consumable = Consumable::with('category')->find($id);
        if (!$consumable) {
            return response()->json(['message' => 'Barang tidak ditemukan'], 404);
        }
        return response()->json($consumable);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateConsumableRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateConsumableRequest $request, $id) {
        $consumable = Consumable::find($id);

        if (!$consumable) {
            return response()->json(['message' => 'Barang tidak ditemukan'], 404);
        }

        $consumable->update($request->validated());
        $consumable->load('category');
        return response()->json($consumable);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $consumable = Consumable::find($id);

        if (!$consumable) {
            return response()->json(['message' => 'Barang tidak ditemukan'], 404);
        }

        $consumable->delete();
        return response()->json(['message' => 'Barang berhasil dihapus'], 200);
    }

    /**
     * Display the usage history for a specific consumable.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function history(Request $request, $id) {
        $consumable = Consumable::find($id);

        if (!$consumable) {
            return response()->json(['message' => 'Barang tidak ditemukan'], 404);
        }

        $perPage = $request->get('per_page', 10); // Default 10 items per page

        $usages = $consumable->usages()
            ->with(['staff:id,name'])
            ->withPivot('quantity')
            ->orderBy('date', 'desc')
            ->paginate($perPage);

        return response()->json([
            'data' => $usages->map(function ($usage) {
                return [
                    'usage_id' => $usage->id,
                    'used_by' => $usage->used_by,
                    'staff' => $usage->staff ? $usage->staff->name : null,
                    'date' => $usage->date,
                    'quantity' => $usage->pivot->quantity,
                ];
            }),
            'current_page' => $usages->currentPage(),
            'per_page' => $usages->perPage(),
            'total' => $usages->total(),
            'last_page' => $usages->lastPage(),
            'from' => $usages->firstItem(),
            'to' => $usages->lastItem(),
            'has_more_pages' => $usages->hasMorePages(),
        ]);
    }
}
