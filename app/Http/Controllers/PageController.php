<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    // Display a listing of the resource.
    public function index($page_slug)
    {
        if ($page_slug == 'faq') {
            $page_title = 'FAQ Page';
        } else if ($page_slug == 'stores') {
            $page_title = 'Stores Page';
        } else if ($page_slug == 'about-us') {
            $page_title = 'About US Page';
        } else if ($page_slug == 'customization') {
            $page_title = 'Customization Page';
        } else if ($page_slug == 'shopping-and-returns') {
            $page_title = 'Shopping and Resturns Page';
        } else {
            return redirect()->back()->with('error', 'You have no rights for this action!');
        }

        if (Auth::guard('admin')->user()->can('pages.index')) {
            $page_details = Page::where('slug', $page_slug)->first();
            return view('admin.pages.index', compact(['page_details', 'page_title', 'page_slug']));
        } else {
            return redirect()->route('admin.dashboard')->with('error', 'You have no rights for this action!');
        }
    }

    // Update Page
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'image',
        ]);

        try {
            $page_name = $request->name;
            $page_slug = $request->slug;
            $page_content = $request->content;

            $page_exist = Page::where('slug', $page_slug)->first();
            $page_id = (isset($page_exist->id)) ? $page_exist->id : '';
            if (!empty($page_id)) {
                $page = Page::find($page_id);
                $page->name = $page_name;
                $page->content = $page_content;

                // Upload Image if Exists
                if ($request->hasFile('image')) {
                    // Delete Old
                    if (isset($page->image) && !empty($page->image) && file_exists('public/images/uploads/pages/' . $page->image)) {
                        unlink('public/images/uploads/pages/' . $page->image);
                    }

                    $image_name = 'page_' . $page_slug . '.' . $request->file('image')->getClientOriginalExtension();
                    $request->file('image')->move(public_path('images/uploads/pages/'), $image_name);
                    $page->image = $image_name;
                }
                $page->update();
            } else {
                $page = new Page();
                $page->name = $page_name;
                $page->slug = $page_slug;
                $page->content = $page_content;

                // Upload Image if Exists
                if ($request->hasFile('image')) {
                    $image_name = 'page_' . $page_slug . '.' . $request->file('image')->getClientOriginalExtension();
                    $request->file('image')->move(public_path('images/uploads/pages/'), $image_name);
                    $page->image = $image_name;
                }

                $page->save();
            }

            return redirect()->back()->with('success', 'Page Details has been Updated.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Oops, Something went wrong!');
        }
    }
}
