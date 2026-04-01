<?php
namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
    public function sendLeaveRequest(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'reason' => 'required',
        ]);

        LeaveRequest::create([
            'user_id' => auth()->id(),
            'date' => $request->date,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Leave request sent successfully!');
    }

    public function viewLeaveRequests()
    {
        $leaveRequests = LeaveRequest::where('user_id', auth()->id())->get();
        return view('leave-requests.view-leave-requests', compact('leaveRequests'));
    }
}
