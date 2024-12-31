<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\View\View;
use App\Models\TripProposal;

class AdminController extends Controller
{
    public function dashboard(Request $request): View
    {
        $status = $request->get('status', 'pending');
        $proposals = TripProposal::with('user')
            ->where('status', $status)
            ->latest()
            ->paginate(10);
            
        $counts = [
            'pending' => TripProposal::where('status', 'pending')->count(),
            'approved' => TripProposal::where('status', 'approved')->count(),
            'rejected' => TripProposal::where('status', 'rejected')->count(),
        ];

        return view('admin.dashboard-admin', compact('proposals', 'counts', 'status'));
    }

    public function updateStatus(Request $request, TripProposal $proposal)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
            'rejection_reason' => 'required_if:status,rejected',
        ]);

        $proposal->update($validated);

        return back()->with('success', 'Trip proposal status updated successfully');
    }
}
