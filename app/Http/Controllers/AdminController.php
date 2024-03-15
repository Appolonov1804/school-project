<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;


class AdminController extends Controller
{
    public function admin() 
    {
        return view('admin.roster.roster');
    }
}
