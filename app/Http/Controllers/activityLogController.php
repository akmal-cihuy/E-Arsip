<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;

class ActivityLogController extends Controller {
    public function index(Request $request) {
        $query = ActivityLog::with(['user', 'file']);

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('activity')) {
            $query->where('activity', 'like', "%{$request->activity}%");
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $activities = $query->latest()->paginate(15)->withQueryString();
        $users = User::all();

        return view('activities.index', compact('activities', 'users'));
    }
}