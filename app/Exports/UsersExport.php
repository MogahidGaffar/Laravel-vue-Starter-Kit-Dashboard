<?php 

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection, ShouldQueue
{
    public function collection()
    {
        return User::all();
    }

  
    
}
