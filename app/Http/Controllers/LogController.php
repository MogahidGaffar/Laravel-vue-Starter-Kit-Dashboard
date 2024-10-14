<?php

namespace App\Http\Controllers;
use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{

    public function index()
    {
        $logs = Log::with('user')->latest()->paginate(10);
        return Inertia('Logs/index', [
            'logs' => $logs
        ]);
    }


    public function view(Log $log)
    {
        return Inertia('Logs/view', [
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
