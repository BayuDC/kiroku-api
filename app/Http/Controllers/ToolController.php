<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Tool;
use App\Http\Requests\StoreToolRequest;
use App\Http\Requests\UpdateToolRequest;

class ToolController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $query = Tool::with('category');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('name', 'LIKE', '%' . $search . '%');
        }

        $tools = $query->get();
        return response()->json($tools);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreToolRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreToolRequest $request) {
        $tool = Tool::create($request->validated());
        $tool->load('category');
        return response()->json($tool, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $tool = Tool::with('category')->find($id);
        if (!$tool) {
            return response()->json(['message' => 'Alat tidak ditemukan'], 404);
        }
        return response()->json($tool);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateToolRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateToolRequest $request, $id) {
        $tool = Tool::find($id);

        if (!$tool) {
            return response()->json(['message' => 'Alat tidak ditemukan'], 404);
        }

        $tool->update($request->validated());
        $tool->load('category');
        return response()->json($tool);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $tool = Tool::find($id);

        if (!$tool) {
            return response()->json(['message' => 'Alat tidak ditemukan'], 404);
        }

        $tool->delete();
        return response()->json(['message' => 'Alat berhasil dihapus'], 200);
    }
}
