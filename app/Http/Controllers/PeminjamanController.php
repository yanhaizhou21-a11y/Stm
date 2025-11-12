<?php

namespace App\Http\Controllers;

use App\Http\Requests\Peminjaman\StorePeminjamanRequest;
use App\Http\Requests\Peminjaman\UpdatePeminjamanRequest;
use App\Models\Inventory;
use App\Models\Peminjaman;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use InvalidArgumentException;
use Yajra\DataTables\Facades\DataTables;

class PeminjamanController extends Controller
{
    public function index(): View
    {
        $peminjaman = Peminjaman::with(['barang', 'peminjam'])
            ->latest('tanggal_pinjam')
            ->get();

        $inventories = Inventory::select('id', 'nama_barang')
            ->orderBy('nama_barang')
            ->get();

        $students = Student::select('id', 'nama_lengkap')
            ->orderBy('nama_lengkap')
            ->get();

        $teachers = Teacher::select('id', 'nama_lengkap')
            ->orderBy('nama_lengkap')
            ->get();

        return view('peminjaman.index', compact('peminjaman', 'inventories', 'students', 'teachers'));
    }

    public function data(): JsonResponse
    {
        $query = Peminjaman::with(['barang', 'peminjam', 'addedBy'])
            ->latest('tanggal_pinjam');

        return DataTables::of($query)
            ->addColumn('peminjam', function (Peminjaman $row) {
                return $row->role_label;
            })
            ->addColumn('nama', function (Peminjaman $row) {
                return $row->peminjam_nama ?? '-';
            })
            ->addColumn('barang', function (Peminjaman $row) {
                return $row->barang?->nama_barang ?? '-';
            })
            ->addColumn('id_barang', function (Peminjaman $row) {
                return $row->barang_id ?? '-';
            })
            ->editColumn('tanggal_pinjam', function (Peminjaman $row) {
                return optional($row->tanggal_pinjam)?->format('d M Y H:i') ?? '-';
            })
            ->editColumn('tanggal_kembali', function (Peminjaman $row) {
                return optional($row->tanggal_kembali)?->format('d M Y H:i') ?? '-';
            })
            ->addColumn('keterangan', function (Peminjaman $row) {
                return $row->keterangan ?? '-';
            })
            ->addColumn('action', function (Peminjaman $row) {
                $editBtn = '<button type="button" class="px-3 py-1.5 text-sm font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 transition" data-edit-button data-id="' . $row->id . '">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </button>';
                $deleteBtn = '<button type="button" onclick="deletePeminjaman(' . $row->id . ')" class="px-3 py-1.5 text-sm font-medium text-red-600 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 transition ml-2">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Hapus
                </button>';
                return $editBtn . $deleteBtn;
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function checkPeminjam(): JsonResponse
    {
        $role = request()->query('role');
        $code = trim((string) request()->query('code', ''));

        if ($code === '' || !in_array($role, ['student', 'teacher'], true)) {
            return response()->json(['error' => 'Parameter tidak valid'], 422);
        }

        if ($role === 'student') {
            $student = Student::where('nisn', $code)->first();
            if (! $student) {
                return response()->json(['error' => 'Siswa tidak ditemukan'], 404);
            }
            return response()->json([
                'id' => $student->id,
                'nama' => $student->nama_lengkap,
                'role' => 'student',
            ]);
        }

        $teacher = Teacher::where('nip', $code)->first();
        if (! $teacher) {
            return response()->json(['error' => 'Guru tidak ditemukan'], 404);
        }
        return response()->json([
            'id' => $teacher->id,
            'nama' => $teacher->nama_lengkap,
            'role' => 'teacher',
        ]);
    }

    public function store(StorePeminjamanRequest $request)
    {
        $attributes = $this->mapRequestToAttributes($request->validated());
        $attributes['added_by'] = Auth::id();

        $created = Peminjaman::create($attributes);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'id' => $created->id]);
        }

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dibuat.');
    }

    public function edit(Peminjaman $peminjaman): JsonResponse
    {
        $peminjaman->load(['barang', 'peminjam']);

        return response()->json([
            'data' => [
                'id' => $peminjaman->id,
                'peminjam_id' => $peminjaman->peminjam_id,
                'role' => $this->mapRoleClassToKey($peminjaman->role),
                'barang_id' => $peminjaman->barang_id,
                'tanggal_pinjam' => optional($peminjaman->tanggal_pinjam)->format('Y-m-d'),
                'tanggal_kembali' => optional($peminjaman->tanggal_kembali)->format('Y-m-d'),
                'keterangan' => $peminjaman->keterangan,
            ],
        ]);
    }

    public function update(UpdatePeminjamanRequest $request, Peminjaman $peminjaman)
    {
        $attributes = $this->mapRequestToAttributes($request->validated());

        $peminjaman->update($attributes);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil diperbarui.');
    }

    public function destroy(Peminjaman $peminjaman)
    {
        $peminjaman->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dihapus.');
    }

    /**
     * @param  array<string, mixed>  $validated
     * @return array<string, mixed>
     */
    protected function mapRequestToAttributes(array $validated): array
    {
        $roleClass = $this->mapRoleKeyToClass($validated['role']);

        $this->ensurePeminjamExists($roleClass, (int) $validated['peminjam_id']);

        return [
            'role' => $roleClass,
            'peminjam_id' => (int) $validated['peminjam_id'],
            'barang_id' => (int) $validated['barang_id'],
            'tanggal_pinjam' => $validated['tanggal_pinjam'],
            'tanggal_kembali' => $validated['tanggal_kembali'] ?? null,
            'keterangan' => $validated['keterangan'] ?? null,
        ];
    }

    protected function mapRoleKeyToClass(string $role): string
    {
        return match ($role) {
            'student' => Student::class,
            'teacher' => Teacher::class,
            default => throw new InvalidArgumentException('Role peminjam tidak dikenali.'),
        };
    }

    protected function mapRoleClassToKey(string $roleClass): string
    {
        return match ($roleClass) {
            Student::class => 'student',
            Teacher::class => 'teacher',
            default => 'student',
        };
    }

    protected function ensurePeminjamExists(string $roleClass, int $peminjamId): void
    {
        if (! $roleClass::whereKey($peminjamId)->exists()) {
            abort(422, 'Data peminjam tidak ditemukan.');
        }
    }
}
