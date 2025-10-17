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
                    <div class="flex gap-2">
                        <button onclick="editTeacher('.$teacher->id.')" class="px-3 py-1.5 text-xs text-dark bg-blue-600 rounded-lg hover:bg-blue-700 transition shadow-md flex items-center gap-1 font-medium">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                            </svg>
                            Edit
                        </button>
                        <button onclick="deleteTeacher('.$teacher->id.')" class="px-3 py-1.5 text-xs text-dark  bg-red-600 rounded-lg hover:bg-red-700 transition shadow-md flex items-center gap-1 font-medium">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            Hapus
                        </button>
                    </div>
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