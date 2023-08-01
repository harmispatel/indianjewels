<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Design, Category, Dealer};

class DashboardController extends Controller
{
    public function index()
    {
        // Total of all Categories
        $data['total_categories'] = Category::count();

        // Total of all Designs
        $data['total_designs'] = Design::count();

        // // Total of all dealers
        $data['total_dealers'] = Dealer::count();

        return view('admin.dashboard', $data);
    }
}
