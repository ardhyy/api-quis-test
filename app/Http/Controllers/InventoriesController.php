<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InventoriesModel as Inventory;

class InventoriesController extends Controller
{
    public function index()
    {
        try {
            $inventories = Inventory::select('name', 'price', 'amount', 'unit')->get();
            if ($inventories->isEmpty()) {
                return response()->json(['message' => 'No inventories found.'], 404);
            }
            return response()->json($inventories, 200);
        } catch (\Exception $e) {
            return response()->json(['code' => 500, 'error' => 'Failed to fetch inventories', 'message' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $inventory = Inventory::findOrFail($id);

            if (!$inventory) {
                return response()->json(['code' => 404, 'message' => 'Inventory not found.'], 404);
            }

            return response()->json($inventory, 200);
        } catch (\Exception $e) {
            return response()->json(['code' => 500, 'error' => 'Failed show inventory', 'message' => $e->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:155',
            'price' => 'required|integer',
            'amount' => 'required|integer',
            'unit' => 'required|string|max:55',
        ]);

        try {
            $inventory = Inventory::create($validatedData);

            return response()->json(['message' => 'Inventory created successfully', 'data' => $inventory]);
        } catch (\Exception $e) {
            return response()->json(['code' => 500, 'error' => 'Failed to create inventory', 'message' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:155',
            'price' => 'required|integer',
            'amount' => 'required|integer',
            'unit' => 'required|string|max:55',
        ]);

        try {
            $inventory = Inventory::findOrFail($id);
            $inventory->update($validatedData);
            return response()->json(['message' => 'Inventory updated successfully', 'data' => $inventory]);
        } catch (\Exception $e) {
            return response()->json(['code' => 500, 'error' => 'Failed to update inventory', 'message' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $inventory = Inventory::findOrFail($id);

            $inventory->delete();

            return response()->json(['message' => 'Inventory deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['code' => 500, 'error' => 'Failed to delete inventory', 'message' => $e->getMessage()]);
        }
    }
}
