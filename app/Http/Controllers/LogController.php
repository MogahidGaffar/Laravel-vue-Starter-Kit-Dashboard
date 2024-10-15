<?php

namespace App\Http\Controllers;
use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;

class LogController extends Controller
{

    public function index(Request $request)
    {
        // Define the filters
        $filters = [
            'module_name' => $request->module,
            'action' => $request->action,
            'by_user_id' => $request->by_user_id,
        ];
        // Start the logs query
        $logsQuery = Log::with('user')->latest();
    
        // Apply the filters if they exist
        if ($filters['module_name']) {
            $logsQuery->where('module_name', $filters['module_name']);
        }
    
        if ($filters['action']) {
            $logsQuery->where('action', $filters['action']);
        }
    
        if ($filters['by_user_id']) {
            $logsQuery->where('by_user_id', $filters['by_user_id']);
        }
    
        // Paginate the filtered logs
        $logs = $logsQuery->paginate(10);
    
        // Retrieve users, modules, and actions for the filter dropdowns
        $users = User::latest()->get();
        $modules = ['User', 'Role', 'Permission'];
        $actions = ['Create', 'Update', 'Delete'];
    
        return Inertia('Logs/index', [
            'translations' => __('messages'),
             'filters' => $filters,
            'logs' => $logs,
            'users' => $users,
            'modules' => $modules,
            'actions' => $actions,
        ]);
    }


    public function view(Log $log)
    {
        return Inertia('Logs/view', [
            'translations' => __('messages'),
            'log' => $log
        ]);
    }
    public function undo(Log $log)
    {
        // Get the module name from the log
        $moduleName = $log->module_name; 
        $modelClass = "App\\Models\\$moduleName";
    
        if ($log->action === 'create') { // If the action is create, delete the created record 
            $modelInstance = $modelClass::findOrFail($log->affected_record_id);
            $modelInstance->delete();
        } elseif ($log->action === 'update') {  // If the action is update, update the model with original data
            $modelInstance = $modelClass::findOrFail($log->affected_record_id);
            if ($modelInstance) {
                $modelInstance->update(json_decode($log->original_data, true));
            } 
        } elseif ($log->action === 'delete') {// If the action is delete, recreate the model with original data
            $modelClass::create(json_decode($log->original_data, true));
        }
        return redirect()->route('logs')
        ->with('success', 'Action Undoed successfully!');
   
    }
    

}
