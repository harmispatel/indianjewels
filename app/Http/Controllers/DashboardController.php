<?php

namespace App\Http\Controllers;

use App\Models\{
    Admin,
    User,
    Design,
    Category,
    Page,
    Tag,
};

class DashboardController extends Controller
{
    public function index()
    {
        // Categories Count
        $data['active_categories'] = Category::where('status',1)->count();
        $data['inactive_categories'] = Category::where('status',0)->count();

        // Tags Count
        $data['active_tags'] = Tag::where('status',1)->count();
        $data['inactive_tags'] = Tag::where('status',0)->count();

        // Designs Count
        $data['active_designs'] = Design::where('status',1)->count();
        $data['inactive_designs'] = Design::where('status',0)->count();

        // Users Count
        $data['active_users'] = Admin::where('status',1)->count();
        $data['inactive_users'] = Admin::where('status',0)->count();

        // Dealers Count
        $data['active_dealers'] = Admin::where('user_type', 1)->where('status',1)->count();
        $data['inactive_dealers'] = Admin::where('user_type', 1)->where('status',0)->count();

        // Customers Count
        $data['active_customers'] = Admin::where('user_type', 2)->where('status',1)->count();
        $data['inactive_customers'] = Admin::where('user_type', 2)->where('status',0)->count();

        // Pages Count
        $data['active_pages'] = Page::where('status',1)->count();
        $data['inactive_pages'] = Page::where('status',0)->count();

        // Orders Count
        $data['active_orders'] = 0;
        $data['inactive_orders'] = 0;

        return view('admin.dashboard', $data);
    }
}
