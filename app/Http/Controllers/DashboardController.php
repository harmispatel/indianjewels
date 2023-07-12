<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Slider, Category, Dealer};

class DashboardController extends Controller
{
    public function index()
    {
        // Total of all Categories
        $data['total_categories'] = Category::count();

        // Total of all Sliders
        $data['total_sliders'] = Slider::count();

        // // Total of all dealers
        $data['total_dealers'] = Dealer::count();

        return view('admin.dashboard', $data);
    }
}
