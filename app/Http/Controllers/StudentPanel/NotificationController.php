<?php

namespace App\Http\Controllers\StudentPanel;

use App\Http\Controllers\Controller;
use App\Models\SystemNotification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $data['title'] = 'Notifications';
        $data['notifications'] = SystemNotification::query()
            ->where('reciver_id', Auth::id())
            ->latest()
            ->paginate(20);

        return view('student-panel.notifications', compact('data'));
    }
}
