<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Attendance System') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.tsx'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-900">
    <div class="max-w-7xl mx-auto px-4 py-6">
        <header class="mb-6 rounded-2xl bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-semibold">{{ config('app.name', 'Laravel App') }}</h1>
                    <p class="mt-1 text-sm text-slate-600">Task assignment, attendance, and leave request management.</p>
                </div>
                <div class="flex flex-wrap gap-3 text-sm">
                    @auth
                        <span class="rounded-full bg-slate-100 px-3 py-2">Signed in as {{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ url('/logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="rounded-lg bg-slate-800 px-4 py-2 text-white hover:bg-slate-700">Logout</button>
                        </form>
                    @else
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}" class="rounded-lg bg-slate-800 px-4 py-2 text-white hover:bg-slate-700">Login</a>
                        @endif
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="rounded-lg bg-slate-100 px-4 py-2 text-slate-900 hover:bg-slate-200">Register</a>
                        @endif
                    @endauth
                </div>
            </div>
        </header>

        @if (session('success'))
            <div class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 p-4 text-emerald-900">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 rounded-xl bg-rose-50 border border-rose-200 p-4 text-rose-900">
                <div class="font-semibold">Please fix the following errors:</div>
                <ul class="mt-2 list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid gap-6 xl:grid-cols-3">
            <section class="rounded-2xl bg-white p-6 shadow-sm">
                <h2 class="text-xl font-semibold">Assign a Task</h2>
                <p class="mt-2 text-sm text-slate-600">Create a task and assign it to a user ID.</p>
                <form method="POST" action="{{ url('/tasks/assign') }}" class="mt-4 space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Title</label>
                        <input name="title" value="{{ old('title') }}" type="text" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2" placeholder="Task title" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Description</label>
                        <textarea name="description" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2" rows="3" placeholder="Task details" required>{{ old('description') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Assigned To (user id)</label>
                        <input name="assigned_to" value="{{ old('assigned_to') }}" type="number" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2" placeholder="User ID" required>
                    </div>
                    <button type="submit" class="mt-2 inline-flex items-center justify-center rounded-lg bg-slate-800 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700">Assign Task</button>
                </form>
            </section>

            <section class="rounded-2xl bg-white p-6 shadow-sm">
                <h2 class="text-xl font-semibold">Send Leave Request</h2>
                <p class="mt-2 text-sm text-slate-600">Submit a new leave request for approval.</p>
                <form method="POST" action="{{ url('/leave-requests/send') }}" class="mt-4 space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Date</label>
                        <input name="date" value="{{ old('date') }}" type="date" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Reason</label>
                        <textarea name="reason" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2" rows="3" placeholder="Reason for leave" required>{{ old('reason') }}</textarea>
                    </div>
                    <button type="submit" class="mt-2 inline-flex items-center justify-center rounded-lg bg-slate-800 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700">Send Request</button>
                </form>
            </section>

            <section class="rounded-2xl bg-white p-6 shadow-sm">
                <h2 class="text-xl font-semibold">Mark Attendance</h2>
                <p class="mt-2 text-sm text-slate-600">Record your attendance for a date.</p>
                <form method="POST" action="{{ url('/attendance/mark') }}" class="mt-4 space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Date</label>
                        <input name="date" value="{{ old('date') }}" type="date" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2" required>
                    </div>
                    <button type="submit" class="mt-2 inline-flex items-center justify-center rounded-lg bg-slate-800 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700">Mark Present</button>
                </form>
            </section>
        </div>

        <div class="mt-8 grid gap-6 lg:grid-cols-3">
            <div class="rounded-2xl bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold">Quick links</h3>
                <ul class="mt-4 space-y-3 text-sm text-slate-600">
                    <li><a href="{{ url('/tasks') }}" class="text-slate-800 hover:text-slate-900">View my tasks</a></li>
                    <li><a href="{{ url('/leave-requests') }}" class="text-slate-800 hover:text-slate-900">View leave requests</a></li>
                    <li><a href="{{ url('/attendance') }}" class="text-slate-800 hover:text-slate-900">View attendance records</a></li>
                </ul>
            </div>

            <div class="rounded-2xl bg-white p-6 shadow-sm xl:col-span-2">
                <h3 class="text-lg font-semibold">Recent data</h3>
                <div class="mt-6 space-y-6">
                    @if (!empty($tasks) && $tasks->count())
                        <div>
                            <h4 class="text-md font-semibold">Tasks</h4>
                            <div class="mt-3 space-y-3">
                                @foreach ($tasks as $task)
                                    <div class="rounded-xl border border-slate-200 p-4">
                                        <div class="flex items-center justify-between gap-3">
                                            <p class="font-semibold text-slate-900">{{ $task->title }}</p>
                                            <span class="rounded-full bg-slate-100 px-3 py-1 text-xs uppercase tracking-[0.15em] text-slate-600">{{ $task->status }}</span>
                                        </div>
                                        <p class="mt-2 text-sm text-slate-600">{{ $task->description }}</p>
                                        <p class="mt-3 text-xs text-slate-500">Assigned to user ID: {{ $task->assigned_to }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if (!empty($leaveRequests) && $leaveRequests->count())
                        <div>
                            <h4 class="text-md font-semibold">Leave Requests</h4>
                            <div class="mt-3 space-y-3">
                                @foreach ($leaveRequests as $requestItem)
                                    <div class="rounded-xl border border-slate-200 p-4">
                                        <p class="font-semibold text-slate-900">{{ $requestItem->date }}</p>
                                        <p class="mt-1 text-sm text-slate-600">{{ $requestItem->reason }}</p>
                                        <p class="mt-2 text-xs text-slate-500">Status: {{ $requestItem->status }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if (!empty($attendances) && $attendances->count())
                        <div>
                            <h4 class="text-md font-semibold">Attendance</h4>
                            <div class="mt-3 space-y-3">
                                @foreach ($attendances as $attendance)
                                    <div class="rounded-xl border border-slate-200 p-4">
                                        <div class="flex items-center justify-between gap-3">
                                            <p class="font-semibold text-slate-900">{{ $attendance->date }}</p>
                                            <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs uppercase tracking-[0.15em] text-emerald-700">{{ $attendance->status }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if (empty($tasks) && empty($leaveRequests) && empty($attendances))
                        <div class="rounded-xl border border-slate-200 p-6 text-sm text-slate-600">
                            No records available yet. Use the forms above to create tasks, leave requests, or mark attendance.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
</html>