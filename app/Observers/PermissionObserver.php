<?php

namespace App\Observers;

use Spatie\Permission\Models\Permission;
use App\Models\Log;
class PermissionObserver 
{
    /**
     * Handle the User "created" event.
     */
    public function created(Permission $permission): void
    {
        if (!app()->runningInConsole()) { // Stop Observer  During DB Seeding
            Log::create([
                'module_name' => 'Permission',
                'action' => 'create',
                'badge' => 'success',
                'affected_record_id' => $permission->id,
                'updated_data' => json_encode($permission),
               'by_user_id' => auth()->id() ,
            ]);
        }
    
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(Permission $permission): void
    {
        // Get the original data before the update
        $originalData = $permission->getOriginal();

        Log::create([
            'module_name' => 'Permission',
            'action' => 'update',
            'badge' => 'primary',
            'affected_record_id' => $permission->id,
            'original_data' => json_encode($originalData),
            'updated_data' => json_encode($permission),
           'by_user_id'=> auth()->id(),
        ]);
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(Permission $permission): void
    {
        Log::create([
            'module_name' => 'Permission',
            'action' => 'delete',
            'badge' => 'danger',
            'affected_record_id' => $permission->id,
            'original_data' => json_encode($permission),
           'by_user_id'=> auth()->id(),
        ]);
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(Permission $permission): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(Permission $permission): void
    {
        //
    }
}
