<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $userCount = User::count();

        return view('index', compact('userCount'));
    }
}
