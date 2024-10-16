<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{

    public function index (){
        // dd(auth()->user()->getPermissionsViaRoles());
        return Inertia::render('Dashboard',[
            'translations' => __('messages'),
            'userCount'=>User::all()->count(),
            'rolesCount'=>Role::all()->count()
        ]);
    }

}
