<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TeacherController extends Controller
{
    public function index()
    {
        return view('teachers.index');
    }

    public function getData()
    {
        $teachers = Teacher::query();

        return DataTables::of($teachers)
            ->addColumn('status', function ($teacher) {
                return $teacher->is_active 
                    ? '<span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Aktif</span>'
                    : '<span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Nonaktif</span>';
            })
            ->addColumn('action', function ($teacher) {
                return '
                    <button onclick="editTeacher('.$teacher->id.')" class="px-3 py-1 text-xs text-white bg-blue-500 rounded hover:bg-blue-600">Edit</button>
                    <button onclick="deleteTeacher('.$teacher->id.')" class="px-3 py-1 text-xs text-white bg-red-500 rounded hover:bg-red-600">Hapus</button>
                ';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'required|unique:teachers',
            'nama_lengkap' => 'required',
            'jabatan' => 'required',
            'no_hp' => 'required',
            'email' => 'required|email|unique:teachers',
            'alamat' => 'required',
            'is_active' => 'boolean'
        ]);

        Teacher::create($validated);

        return response()->json(['success' => true, 'message' => 'Data guru berhasil ditambahkan']);
    }

    public function show($id)
    {
        $teacher = Teacher::findOrFail($id);
        return response()->json($teacher);
    }

    public function update(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);

        $validated = $request->validate([
            'nip' => 'required|unique:teachers,nip,'.$id,
            'nama_lengkap' => 'required',
            'jabatan' => 'required',
            'no_hp' => 'required',
            'email' => 'required|email|unique:teachers,email,'.$id,
            'alamat' => 'required',
            'is_active' => 'boolean'
        ]);

        $teacher->update($validated);

        return response()->json(['success' => true, 'message' => 'Data guru berhasil diupdate']);
    }

    public function destroy($id)
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->delete();

        return response()->json(['success' => true, 'message' => 'Data guru berhasil dihapus']);
    }
}