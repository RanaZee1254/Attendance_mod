<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use App\Models\Task;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function studentManagement()
    {
        $students = User::where('role', 'student')->get();
        return view('admin.student-management', compact('students'));
    }

    public function attendanceReport()
    {
        $attendances = Attendance::all();
        return view('admin.attendance-report', compact('attendances'));
    }

    public function leaveRequests()
    {
        $leaveRequests = LeaveRequest::where('status', 'pending')->get();
        return view('admin.leave-requests', compact('leaveRequests'));
    }

    public function tasks()
    {
        $tasks = Task::all();
        return view('admin.tasks', compact('tasks'));
    }
}
