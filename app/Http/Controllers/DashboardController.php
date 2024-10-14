<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{

    public function index (){
        return Inertia::render('Dashboard',[
            'userCount'=>User::all()->count(),
            'rolesCount'=>Role::all()->count()
        ]);
    }

}
