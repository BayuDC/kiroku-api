<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usage;
use App\Models\Consumable;
use Illuminate\Support\Facades\DB;

class UsageController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $query = Usage::with('staff')->withCount('consumables');

        // Optional search by used_by
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('used_by', 'LIKE', '%' . $search . '%');
        }

        $usages = $query->orderBy('date', 'desc')->get();
        return response()->json($usages);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $usage = Usage::with(['staff', 'consumables'])->find($id);

        if (!$usage) {
            return response()->json(['message' => 'Pemakaian tidak ditemukan'], 404);
        }

        return response()->json($usage);
    }

    public function store(Request $request) {
        $request->validate([
            'used_by' => 'required|string',
            'consumables' => 'required|array|min:1',
            'consumables.*.id' => 'required|integer|exists:consumables,id',
            'consumables.*.quantity' => 'required|integer|min:1',
        ]);

        $consumableResults = [];
        $allValid = true;

        // Check stock availability for all consumables first
        foreach ($request->consumables as $consumableData) {
            $consumable = Consumable::find($consumableData['id']);

            if (!$consumable) {
                $consumableResults[] = 'Barang tidak ditemukan';
                $allValid = false;
            } elseif ($consumable->stock < $consumableData['quantity']) {
                $consumableResults[] = 'Stok tidak cukup';
                $allValid = false;
            } else {
                $consumableResults[] = 'OK';
            }
        }

        // If all checks pass, create the usage and update stocks
        if ($allValid) {
            try {
                \DB::beginTransaction();

                // Create the usage record
                $usage = Usage::create([
                    'used_by' => $request->used_by,
                    'date' => now(),
                    'staff_id' => auth()->id(),
                ]);

                // Process each consumable
                foreach ($request->consumables as $consumableData) {
                    $consumable = Consumable::find($consumableData['id']);

                    // Attach to usage with quantity
                    $usage->consumables()->attach($consumable->id, [
                        'quantity' => $consumableData['quantity']
                    ]);

                    // Reduce stock
                    $consumable->decrement('stock', $consumableData['quantity']);
                }

                \DB::commit();

                return response()->json([
                    'message' => 'Pemakaian berhasil dicatat',
                    'consumables' => $consumableResults
                ], 201);
            } catch (\Exception $e) {
                \DB::rollback();
                return response()->json([
                    'message' => 'Pemakaian gagal dicatat',
                    'consumables' => array_fill(0, count($request->consumables), 'Error sistem')
                ], 500);
            }
        } else {
            return response()->json([
                'message' => 'Pemakaian gagal dicatat',
                'consumables' => $consumableResults
            ], 400);
        }
    }

    public function destroy($id) {
        $usage = Usage::with('consumables')->find($id);

        if (!$usage) {
            return response()->json(['message' => 'Pemakaian tidak ditemukan'], 404);
        }

        try {
            DB::beginTransaction();

            // Return stock for each consumable
            foreach ($usage->consumables as $consumable) {
                $quantity = $consumable->pivot->quantity;
                $consumable->increment('stock', $quantity);
            }

            // Delete the usage (this will also delete the pivot table records due to cascade)
            $usage->delete();

            DB::commit();

            return response()->json(['message' => 'Pemakaian berhasil dihapus dan stok dikembalikan'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Gagal menghapus pemakaian'], 500);
        }
    }
}
