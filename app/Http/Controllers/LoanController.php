<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\Tool;
use App\Http\Requests\StoreLoanRequest;
use App\Http\Requests\ReturnLoanRequest;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $query = Loan::with('staff')->withCount('tools');

        // Optional search by used_by
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('used_by', 'LIKE', '%' . $search . '%');
        }

        // Filter by status (active/returned)
        if ($request->has('status')) {
            if ($request->status === 'active') {
                $query->active();
            } elseif ($request->status === 'returned') {
                $query->returned();
            }
        }

        // Sort by active loans first, then returned loans, both by loan_date desc
        $loans = $query->orderByRaw('return_date IS NULL DESC, loan_date DESC')->get();
        return response()->json($loans);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $loan = Loan::with(['staff', 'tools'])->find($id);

        if (!$loan) {
            return response()->json(['message' => 'Peminjaman tidak ditemukan'], 404);
        }

        return response()->json($loan);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLoanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLoanRequest $request) {
        $toolResults = [];
        $allValid = true;

        // Check tool availability for all tools first
        foreach ($request->tools as $toolData) {
            $tool = Tool::find($toolData['id']);

            if (!$tool) {
                $toolResults[] = 'Alat tidak ditemukan';
                $allValid = false;
            } elseif ($tool->status !== 'available') {
                $toolResults[] = 'Alat tidak tersedia';
                $allValid = false;
            } else {
                $toolResults[] = 'OK';
            }
        }

        // If all checks pass, create the loan and update tool status
        if ($allValid) {
            try {
                DB::beginTransaction();

                // Create the loan record
                $loan = Loan::create([
                    'used_by' => $request->used_by,
                    'loan_date' => now(),
                    'staff_id' => auth()->id(),
                ]);

                // Process each tool
                foreach ($request->tools as $toolData) {
                    $tool = Tool::find($toolData['id']);

                    // Attach to loan with condition
                    $loan->tools()->attach($tool->id, [
                        'condition_before' => $toolData['condition_before'] ?? 'good'
                    ]);

                    // Update tool status to borrowed
                    $tool->update(['status' => 'borrowed']);
                }

                DB::commit();

                return response()->json([
                    'message' => 'Peminjaman berhasil dicatat',
                    'tools' => $toolResults,
                    'loan' => $loan->load(['staff', 'tools'])
                ], 201);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json([
                    'message' => 'Peminjaman gagal dicatat',
                    'tools' => array_fill(0, count($request->tools), 'Error sistem')
                ], 500);
            }
        } else {
            return response()->json([
                'message' => 'Peminjaman gagal dicatat',
                'tools' => $toolResults
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage (for returning loans).
     *
     * @param  \App\Http\Requests\ReturnLoanRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReturnLoanRequest $request, $id) {
        $loan = Loan::with('tools')->find($id);

        if (!$loan) {
            return response()->json(['message' => 'Peminjaman tidak ditemukan'], 404);
        }

        if (!$loan->isActive()) {
            return response()->json(['message' => 'Peminjaman sudah dikembalikan'], 400);
        }

        try {
            DB::beginTransaction();

            // Update return date
            $loan->update([
                'return_date' => now()
            ]);

            // Process each tool return
            foreach ($request->tools as $toolData) {
                $tool = Tool::find($toolData['id']);

                if ($tool) {
                    // Update condition_after in pivot table
                    $loan->tools()->updateExistingPivot($tool->id, [
                        'condition_after' => $toolData['condition_after'] ?? 'good'
                    ]);

                    // Update tool status back to available
                    $tool->update(['status' => 'available']);

                    // Update tool condition in main table based on condition_after
                    $conditionAfter = $toolData['condition_after'] ?? 'good';
                    $tool->update(['condition' => $conditionAfter]);
                }
            }

            DB::commit();

            return response()->json([
                'message' => 'Peminjaman berhasil dikembalikan',
                'loan' => $loan->fresh(['staff', 'tools'])
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Gagal mengembalikan peminjaman'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $loan = Loan::with('tools')->find($id);

        if (!$loan) {
            return response()->json(['message' => 'Peminjaman tidak ditemukan'], 404);
        }

        try {
            DB::beginTransaction();

            // If loan is still active, return tools to available status
            if ($loan->isActive()) {
                foreach ($loan->tools as $tool) {
                    $tool->update(['status' => 'available']);
                }
            }

            // Delete the loan (this will also delete the pivot table records due to cascade)
            $loan->delete();

            DB::commit();

            return response()->json(['message' => 'Peminjaman berhasil dihapus'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Gagal menghapus peminjaman'], 500);
        }
    }
}
