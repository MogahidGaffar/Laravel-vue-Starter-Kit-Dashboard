<?php 

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
    use App\Notifications\ExportNotification;

class ExportController extends Controller
{

   public function export()
{
    $user = auth()->user();
    $user->notify(new ExportNotification('started'));  // Notify that the export has started
    // Queue the export and chain the notification when finished
    Excel::queue(new UsersExport, 'users.xlsx', 'public') // Save to 'public' disk
        ->chain([
            function () use ($user) {
                // Generate the public URL (relative path) to the file
                $filePath = '/storage/users.xlsx'; // This corresponds to /storage/app/public/users.xlsx
                // Notify the user with the finished status and the shorter file path
                $user->notify(new ExportNotification('finished', $filePath));
            }
        ]);

    return redirect()->route('users.index')
        ->with('success', __('messages.Export_process_started_You_will_be_notified_when_it_finishes'));
}

}