<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Log;
class UserObserver 
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        if (!app()->runningInConsole()) { // Stop Observer  During DB Seeding
        Log::create([
            'module_name' => 'User',
            'action' => 'create',
            'badge' => 'success',
            'affected_record_id' => $user->id,
            'updated_data' => json_encode($user),
           'by_user_id' => auth()->id() ?? $user->id, 
        ]);
    }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        // Get the original data before the update
        $originalData = $user->getOriginal();

        Log::create([
            'module_name' => 'User',
            'action' => 'update',
            'badge' => 'primary',
            'affected_record_id' => $user->id,
            'original_data' => json_encode($originalData),
            'updated_data' => json_encode($user),
           'by_user_id'=> auth()->id(),
        ]);
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        Log::create([
            'module_name' => 'User',
            'action' => 'delete',
            'badge' => 'danger',
            'affected_record_id' => $user->id,
            'original_data' => json_encode($user),
           'by_user_id'=> auth()->id(),
        ]);
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
