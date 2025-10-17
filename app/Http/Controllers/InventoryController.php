<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class InventoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)->get();
        return view('inventories.index', compact('categories'));
    }

    public function getData()
    {
        $inventories = Inventory::with('category');

        return DataTables::of($inventories)
            ->addColumn('kategori', function ($inventory) {
                return $inventory->category->nama_kategori ?? '-';
            })
            ->addColumn('status_badge', function ($inventory) {
                $colors = [
                    'Baik' => 'bg-green-100 text-green-800',
                    'Rusak' => 'bg-red-100 text-red-800',
                    'Diperbaiki' => 'bg-yellow-100 text-yellow-800'
                ];
                $color = $colors[$inventory->status] ?? 'bg-gray-100 text-gray-800';
                return '<span class="px-2 py-1 text-xs rounded-full '.$color.'">'.$inventory->status.'</span>';
            })
            ->addColumn('active_status', function ($inventory) {
                return $inventory->is_active 
                    ? '<span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Aktif</span>'
                    : '<span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Nonaktif</span>';
            })
            ->addColumn('action', function ($inventory) {
                return '
                    <div class="flex gap-2">
                        <button onclick="editInventory('.$inventory->id.')" class="px-3 py-1.5 text-xs text-white bg-green-500 rounded-lg hover:bg-green-600 transition shadow-sm flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                            </svg>
                            Edit
                        </button>
                        <button onclick="deleteInventory('.$inventory->id.')" class="px-3 py-1.5 text-xs text-white bg-red-500 rounded-lg hover:bg-red-600 transition shadow-sm flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            Hapus
                        </button>
                    </div>
                ';
            })
            ->rawColumns(['kategori', 'status_badge', 'active_status', 'action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_barang' => 'required|unique:inventories',
            'nama_barang' => 'required',
            'kategori_id' => 'required|exists:categories,id',
            'deskripsi' => 'nullable',
            'status' => 'required',
            'lokasi_barang' => 'required',
            'is_active' => 'boolean'
        ]);

        Inventory::create($validated);

        return response()->json(['success' => true, 'message' => 'Data inventaris berhasil ditambahkan']);
    }

    public function show($id)
    {
        $inventory = Inventory::with('category')->findOrFail($id);
        return response()->json($inventory);
    }

    public function update(Request $request, $id)
    {
        $inventory = Inventory::findOrFail($id);

        $validated = $request->validate([
            'kode_barang' => 'required|unique:inventories,kode_barang,'.$id,
            'nama_barang' => 'required',
            'kategori_id' => 'required|exists:categories,id',
            'deskripsi' => 'nullable',
            'status' => 'required',
            'lokasi_barang' => 'required',
            'is_active' => 'boolean'
        ]);

        $inventory->update($validated);

        return response()->json(['success' => true, 'message' => 'Data inventaris berhasil diupdate']);
    }

    public function destroy($id)
    {
        $inventory = Inventory::findOrFail($id);
        $inventory->delete();

        return response()->json(['success' => true, 'message' => 'Data inventaris berhasil dihapus']);
    }
}