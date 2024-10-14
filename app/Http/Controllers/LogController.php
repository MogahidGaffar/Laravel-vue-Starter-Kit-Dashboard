<?php

namespace App\Http\Controllers;
use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    
    public function index()
    {
        $logs =Log::latest()->paginate(10);
     return Inertia('Logs/index',[
        'logs'=>$logs
     ]);
    }
}
