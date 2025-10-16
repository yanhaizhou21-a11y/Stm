<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Student;
use App\Models\Category;
use App\Models\Inventory;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'teachers' => Teacher::where('is_active', true)->count(),
            'students' => Student::where('is_active', true)->count(),
            'inventories' => Inventory::where('is_active', true)->count(),
            'categories' => Category::where('is_active', true)->count(),
        ];

        return view('dashboard', compact('stats'));
    }
}