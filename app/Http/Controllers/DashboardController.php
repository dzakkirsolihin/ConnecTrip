<?php

namespace App\Http\Controllers;

use App\Models\TripSubmission;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $dashboard = TripSubmission::all(); // Mengambil semua data dari model Destination
        return view('user.dashboard', compact('dashboard'));
    }
} 