<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function index()
    {
        return view('categories.index');
    }

    public function getData()
    {
        $categories = Category::query();

        return DataTables::of($categories)
            ->addColumn('status', function ($category) {
                return $category->is_active 
                    ? '<span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Aktif</span>'
                    : '<span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Nonaktif</span>';
            })
            ->addColumn('action', function ($category) {
                return '
                    <button onclick="editCategory('.$category->id.')" class="px-3 py-1 text-xs text-white bg-blue-500 rounded hover:bg-blue-600">Edit</button>
                    <button onclick="deleteCategory('.$category->id.')" class="px-3 py-1 text-xs text-white bg-red-500 rounded hover:bg-red-600">Hapus</button>
                ';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required',
            'deskripsi' => 'nullable',
            'is_active' => 'boolean'
        ]);

        Category::create($validated);

        return response()->json(['success' => true, 'message' => 'Kategori berhasil ditambahkan']);
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'nama_kategori' => 'required',
            'deskripsi' => 'nullable',
            'is_active' => 'boolean'
        ]);

        $category->update($validated);

        return response()->json(['success' => true, 'message' => 'Kategori berhasil diupdate']);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json(['success' => true, 'message' => 'Kategori berhasil dihapus']);
    }
}