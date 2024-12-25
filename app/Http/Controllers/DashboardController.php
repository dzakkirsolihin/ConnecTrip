<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $dashboard = Destination::all(); // Mengambil semua data dari model Destination
        return view('user.dashboard', compact('dashboard'));
    }
} 