<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\Notification;
use App\Models\User;
use App\Models\Booking;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $userCount = User::count();
        $bookingCount = Booking::count();
        $facilityCount = Facility::count();
        $futsalManagerCount = User::where('user_type', 'futsal_manager')->count();
        return view('admin.dashboard', compact('user', 'userCount', 'bookingCount', 'facilityCount', 'futsalManagerCount'));
    }

    public function notifications()
    {
        $notifications = Notification::with('facility.user')->where('is_read', false)->get();
        return view('admin.notifications.index', ['notifications' => $notifications]);
    }

    public function markAsRead(Notification $notification)
    {
        $notification->update(['is_read' => true]);
        return redirect()->route('admin.notifications.index');
    }


    public function viewSubmission($id)
    {
        try {
            $facility = Facility::findOrFail($id);

            return view('user.facility_submissions.view', compact('facility'));
        } catch (\Exception $e) {
            return redirect()->route('user.facility_submissions.create')->with('error', 'Facility not found.');
        }
    }

}

