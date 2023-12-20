<?php

namespace App\Http\Controllers;

use App\Models\{
    User,
    Design,
    Category,
};

class DashboardController extends Controller
{
    public function index()
    {
        // Total of all Categories
        $data['total_categories'] = Category::count();

        // Total of all Sliders
        $data['total_designs'] = Design::count();

        // // Total of all dealers
        $data['total_dealers'] = User::where('user_type',1)->count();

        return view('admin.dashboard', $data);
    }
}
