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
        $inventories = Inventory::select('id', 'nama_barang')
            ->orderBy('nama_barang')
            ->get();

        $students = Student::select('id', 'nama_lengkap')
            ->orderBy('nama_lengkap')
            ->get();

        $teachers = Teacher::select('id', 'nama_lengkap')
            ->orderBy('nama_lengkap')
            ->get();

        return view('peminjaman.index', compact('inventories', 'students', 'teachers'));
    }

    public function data(): JsonResponse
    {
        $query = Peminjaman::with(['barang', 'peminjam'])
            ->latest('tanggal_pinjam');

        return DataTables::of($query)
            ->addColumn('peminjam', function (Peminjaman $row) {
                return $row->peminjam_nama ?? '-';
            })
            ->addColumn('role', function (Peminjaman $row) {
                return ucfirst($row->role_label);
            })
            ->addColumn('barang', function (Peminjaman $row) {
                return $row->barang?->nama_barang ?? '-';
            })
            ->addColumn('tanggal_pinjam', function (Peminjaman $row) {
                return optional($row->tanggal_pinjam)?->format('d M Y') ?? '-';
            })
            ->addColumn('tanggal_kembali', function (Peminjaman $row) {
                return optional($row->tanggal_kembali)?->format('d M Y') ?? '-';
            })
            ->addColumn('status', function (Peminjaman $row) {
                $colors = [
                    'dipinjam' => 'bg-blue-100 text-blue-800',
                    'dikembalikan' => 'bg-green-100 text-green-800',
                    'rusak' => 'bg-red-100 text-red-800',
                    'hilang' => 'bg-gray-100 text-gray-800',
                ];
                $color = $colors[$row->status] ?? 'bg-gray-100 text-gray-800';
                return '<span class="px-2 py-1 text-xs rounded-full ' . $color . '">' . ucfirst($row->status) . '</span>';
            })
            ->addColumn('action', function (Peminjaman $row) {
                $editBtn = '<button onclick="editPeminjaman(' . $row->id . ')" class="text-blue-600 hover:text-blue-900 mr-3">Edit</button>';
                $deleteBtn = '<button onclick="deletePeminjaman(' . $row->id . ')" class="text-red-600 hover:text-red-900">Delete</button>';
                return $editBtn . $deleteBtn;
            })
            ->rawColumns(['action', 'status'])
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
        
        // Check if item is already borrowed
        $isBorrowed = Peminjaman::where('barang_id', $attributes['barang_id'])
            ->where('status', 'dipinjam')
            ->exists();

        if ($isBorrowed) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Barang sedang dipinjam.'], 422);
            }
            return back()->withErrors(['barang_id' => 'Barang sedang dipinjam.']);
        }

        $attributes['added_by'] = (string) Auth::id();
        $attributes['status'] = 'dipinjam';

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
                'tanggal_pinjam' => optional($peminjaman->tanggal_pinjam)?->format('Y-m-d'),
                'tanggal_kembali' => optional($peminjaman->tanggal_kembali)?->format('Y-m-d'),
                'status' => $peminjaman->status,
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
            'peminjam_id' => (string) $validated['peminjam_id'],
            'barang_id' => (string) $validated['barang_id'],
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
