<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Repositories\Contracts\LogRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function __construct(
        protected LogRepositoryInterface $logs,
        protected UserRepositoryInterface $users,
    ) {
        $this->middleware('permission:read logs', ['only' => ['index']]);
        $this->middleware('permission:view logs', ['only' => ['view']]);
        $this->middleware('permission:update logs', ['only' => ['undo']]);
    }

    public function index(Request $request)
    {
        // Define the filters
        $filters = [
            'module_name' => $request->module,
            'action' => $request->action,
            'by_user_id' => $request->by_user_id,
        ];

        $logs = $this->logs->paginateFiltered($filters, 10);

        // Retrieve users, modules, and actions for the filter dropdowns
        $users = $this->users->latestAll();
        $modules = ['User', 'Role', 'Permission'];
        $actions = ['Create', 'Update', 'Delete'];

        return Inertia('Logs/index', [
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
            'log' => $log
        ]);
    }
    public function undo(Log $log)
    {
        // Get the module name from the log
        $moduleName = $log->module_name;
        $modelClass = $moduleName === 'Role'
            ? \Spatie\Permission\Models\Role::class
            : "App\\Models\\$moduleName";

        $usesSoftDeletes = method_exists($modelClass, 'restore');
        $query = $usesSoftDeletes ? $modelClass::withTrashed() : $modelClass::query();

        switch ($log->action) {
            case 'create':
                // Force delete even if the model uses SoftDeletes.
                $modelInstance = $query->findOrFail($log->affected_record_id);
                $usesSoftDeletes ? $modelInstance->forceDelete() : $modelInstance->delete();
                break;

            case 'update':
                $modelInstance = $query->findOrFail($log->affected_record_id);
                $modelInstance->update(json_decode($log->original_data, true));
                break;

            case 'delete':
                $originalData = json_decode($log->original_data, true);

                // Restore instead of recreating if the model supports SoftDeletes.
                $trashed = $usesSoftDeletes ? $query->find($originalData['id'] ?? null) : null;
                if ($trashed) {
                    $trashed->restore();
                } else {
                    $modelClass::create($originalData);
                }
                break;

            default:
                return redirect()->back()->with('error', 'Unknown action, cannot undo.');
        }

        return redirect()->route('logs')
            ->with('success', 'Action Undoed successfully!');
    }
}
