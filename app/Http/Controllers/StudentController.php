<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StudentController extends Controller
{
    public function index()
    {
        return view('students.index');
    }

    public function getData()
    {
        $students = Student::query();

        return DataTables::of($students)
            ->addColumn('status', function ($student) {
                return $student->is_active 
                    ? '<span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Aktif</span>'
                    : '<span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Nonaktif</span>';
            })
            ->addColumn('action', function ($student) {
                return '
                    <button onclick="editStudent('.$student->id.')" class="px-3 py-1 text-xs text-white bg-blue-500 rounded hover:bg-blue-600">Edit</button>
                    <button onclick="deleteStudent('.$student->id.')" class="px-3 py-1 text-xs text-white bg-red-500 rounded hover:bg-red-600">Hapus</button>
                ';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nisn' => 'required|unique:students',
            'nama_lengkap' => 'required',
            'kelas' => 'required',
            'jurusan' => 'required',
            'angkatan' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required',
            'is_active' => 'boolean'
        ]);

        Student::create($validated);

        return response()->json(['success' => true, 'message' => 'Data siswa berhasil ditambahkan']);
    }

    public function show($id)
    {
        $student = Student::findOrFail($id);
        return response()->json($student);
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $validated = $request->validate([
            'nisn' => 'required|unique:students,nisn,'.$id,
            'nama_lengkap' => 'required',
            'kelas' => 'required',
            'jurusan' => 'required',
            'angkatan' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required',
            'is_active' => 'boolean'
        ]);

        $student->update($validated);

        return response()->json(['success' => true, 'message' => 'Data siswa berhasil diupdate']);
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return response()->json(['success' => true, 'message' => 'Data siswa berhasil dihapus']);
    }
}