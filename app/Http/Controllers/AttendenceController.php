<?php
namespace App\Http\Controllers;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function markAttendance(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
        ]);

        Attendance::create([
            'user_id' => auth()->id(),
            'date' => $request->date,
            'status' => 'present',
        ]);

        return redirect()->back()->with('success', 'Attendance marked successfully!');
    }

    public function viewAttendance()
    {
        $attendances = Attendance::where('user_id', auth()->id())->get();
        return view('attendance.view-attendance', compact('attendances'));
    }
}
