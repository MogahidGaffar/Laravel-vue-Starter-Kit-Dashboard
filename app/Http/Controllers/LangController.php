<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App;


class LangController extends Controller
{
    public function change(Request $request): RedirectResponse

    {
        // dd($request->lang);
        App::setLocale($request->lang);
        session()->put('locale', $request->lang);
        return redirect()->back();
    }
}
