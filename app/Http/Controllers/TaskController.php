<?phpnamespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function assignTask(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'assigned_to' => 'required',
        ]);

        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'assigned_to' => $request->assigned_to,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Task assigned successfully!');
    }

    public function viewTasks()
    {
        $tasks = Task::where('assigned_to', auth()->id())->get();
        return view('tasks.view-tasks', compact('tasks'));
    }
}
