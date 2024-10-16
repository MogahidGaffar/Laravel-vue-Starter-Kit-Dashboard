<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Inertia\Response;
class NotificationController extends Controller
{
    public function index(Request $request): Response
    {

        $notifications = $request->user()->notifications()->paginate(10);

        // Format the notification data
        $formattedNotifications = $notifications->map(function ($notification) {
            return [
                'id' => $notification->id,
                'type' => class_basename($notification->type), 
                'data' => $notification->data, 
                'read_at' => $notification->read_at, 
                'created_at' => $notification->created_at->diffForHumans(),
            ];
        });

        return inertia(
            'Notification/index',
            [
            'translations' => __('messages'),
                'notifications' => $formattedNotifications,
        //         'pagination' => [
        //     'current_page' => $notifications->currentPage(),
        //     'last_page' => $notifications->lastPage(),
        //     'per_page' => $notifications->perPage(),
        //     'total' => $notifications->total(),
        // ],
            ]
        );
    }
}