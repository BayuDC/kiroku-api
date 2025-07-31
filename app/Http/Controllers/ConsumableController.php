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
}
