<?php

namespace App\Observers;

use Spatie\Permission\Models\Role;
use App\Models\Log;
class RoleObserver 
{
    /**
     * Handle the User "created" event.
     */
    public function created(Role $role): void
    {
        if (!app()->runningInConsole()) { // Stop Observer  During DB Seeding
        Log::create([
            'module_name' => 'Role',
            'action' => 'create',
            'badge' => 'success',
            'affected_record_id' => $role->id,
            'updated_data' => json_encode($role),
           'by_user_id' => auth()->id() ,
        ]);
    }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(Role $role): void
    {
        // Get the original data before the update
        $originalData = $role->getOriginal();

        Log::create([
            'module_name' => 'Role',
            'action' => 'update',
            'badge' => 'primary',
            'affected_record_id' => $role->id,
            'original_data' => json_encode($originalData),
            'updated_data' => json_encode($role),
           'by_user_id'=> auth()->id(),
        ]);
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(Role $role): void
    {
        Log::create([
            'module_name' => 'Role',
            'action' => 'delete',
            'badge' => 'danger',
            'affected_record_id' => $role->id,
            'original_data' => json_encode($role),
           'by_user_id'=> auth()->id(),
        ]);
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(Role $role): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(Role $role): void
    {
        //
    }
}
