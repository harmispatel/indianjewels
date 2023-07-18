@php
    $currentRouteName = Route::currentRouteName();
    $role = Auth::guard('admin')->user();
    $role_id = $role->user_type;
    
    $permissions = App\Models\RoleHasPermissions::where('role_id', $role_id)->pluck('permission_id');
    
    foreach ($permissions as $permission) {
        $permission_ids[] = $permission;
    }
    
    $category = Spatie\Permission\Models\Permission::where('name', 'categories')->first();
    $tag = Spatie\Permission\Models\Permission::where('name', 'tags')->first();
    $slider = Spatie\Permission\Models\Permission::where('name', 'sliders')->first();
    $design = Spatie\Permission\Models\Permission::where('name', 'designs')->first();
    $dealer = Spatie\Permission\Models\Permission::where('name', 'dealers')->first();
    $discount = Spatie\Permission\Models\Permission::where('name', 'westage.discount')->first();
    $role = Spatie\Permission\Models\Permission::where('name', 'roles')->first();
    $user = Spatie\Permission\Models\Permission::where('name', 'users')->first();
    $scheme = Spatie\Permission\Models\Permission::where('name', 'reports.scheme')->first();
    $dealer_performace = Spatie\Permission\Models\Permission::where('name', 'reports.dealer.performace')->first();
    $summary_items = Spatie\Permission\Models\Permission::where('name', 'reports.summary.items')->first();
    $reports_star = Spatie\Permission\Models\Permission::where('name', 'reports.star')->first();
    $order = Spatie\Permission\Models\Permission::where('name', 'order')->first();
    $marketing = Spatie\Permission\Models\Permission::where('name', 'marketing')->first();
    $import_export = Spatie\Permission\Models\Permission::where('name', 'import.export')->first();
    
@endphp

<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        {{-- Dashboard Nav --}}
        <li class="nav-item">
            <a class="nav-link {{ $currentRouteName == 'admin.dashboard' ? '' : 'collapsed' }}"
                href="{{ route('admin.dashboard') }}">
                <i class="fa-solid fa-gauge"></i>
                <span>Dashboard</span>
            </a>
        </li>

        {{-- Master Nav --}}
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() != 'tags' && Route::currentRouteName() != 'tags.create' && Route::currentRouteName() != 'tags.edit' && Route::currentRouteName() != 'categories' && Route::currentRouteName() != 'categories.add-category' && Route::currentRouteName() != 'categories.edit-category' && Route::currentRouteName() != 'sliders' && Route::currentRouteName() != 'sliders.edit-slider' && Route::currentRouteName() != 'sliders.add-slider' && Route::currentRouteName() != 'designs' && Route::currentRouteName() != 'designs.create' && Route::currentRouteName() != 'designs.edit' && Route::currentRouteName() != 'dealers' && Route::currentRouteName() != 'dealers.create' && Route::currentRouteName() != 'dealers.edit' && Route::currentRouteName() != 'westage.discount' && Route::currentRouteName() != 'westage.discount.create' && Route::currentRouteName() != 'westage.discount.edit' && Route::currentRouteName() != 'import.export' ? 'collapsed' : '' }}  {{ Route::currentRouteName() == 'tags' || Route::currentRouteName() == 'tags.create' || Route::currentRouteName() == 'tags.edit' || Route::currentRouteName() == 'categories' || Route::currentRouteName() == 'categories.edit-category' || Route::currentRouteName() == 'categories.add-category' || Route::currentRouteName() == 'designs' || Route::currentRouteName() == 'designs.create' || Route::currentRouteName() == 'designs.edit' || Route::currentRouteName() == 'dealers' || Route::currentRouteName() == 'dealers.create' || Route::currentRouteName() == 'dealers.edit' || Route::currentRouteName() == 'westage.discount' || Route::currentRouteName() == 'westage.discount.create' || Route::currentRouteName() == 'westage.discount.edit' || Route::currentRouteName() == 'import.export' ? 'active-tab' : '' }}"
                data-bs-target="#catalogue-nav" data-bs-toggle="collapse" href="#"
                aria-expanded="{{ Route::currentRouteName() == 'tags' || Route::currentRouteName() == 'tags.create' || Route::currentRouteName() == 'tags.edit' || Route::currentRouteName() == 'categories' || Route::currentRouteName() == 'categories.edit-category' || Route::currentRouteName() == 'categories.add-category' || Route::currentRouteName() == 'sliders' || Route::currentRouteName() == 'sliders.add-slider' || Route::currentRouteName() == 'sliders.edit-slider' || Route::currentRouteName() == 'designs' || Route::currentRouteName() == 'designs.create' || Route::currentRouteName() == 'designs.edit' || Route::currentRouteName() == 'dealers' || Route::currentRouteName() == 'dealers.create' || Route::currentRouteName() == 'dealers.edit' || Route::currentRouteName() == 'westage.discount' || Route::currentRouteName() == 'westage.discount.create' || Route::currentRouteName() == 'westage.discount.edit' || Route::currentRouteName() == 'import.export' ? 'true' : 'false' }}">
                <i class="bi bi-layout-text-window-reverse"></i><span>Master</span><i
                    class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="catalogue-nav"
                class="nav-content collapse {{ Route::currentRouteName() == 'tags' || Route::currentRouteName() == 'tags.create' || Route::currentRouteName() == 'tags.edit' || Route::currentRouteName() == 'categories' || Route::currentRouteName() == 'categories.edit-category' || Route::currentRouteName() == 'categories.add-category' || Route::currentRouteName() == 'sliders' || Route::currentRouteName() == 'sliders.add-slider' || Route::currentRouteName() == 'sliders.edit-slider' || Route::currentRouteName() == 'designs' || Route::currentRouteName() == 'designs.create' || Route::currentRouteName() == 'designs.edit' || Route::currentRouteName() == 'dealers' || Route::currentRouteName() == 'dealers.create' || Route::currentRouteName() == 'dealers.edit' || Route::currentRouteName() == 'westage.discount' || Route::currentRouteName() == 'westage.discount.create' || Route::currentRouteName() == 'westage.discount.edit' || Route::currentRouteName() == 'import.export' ? 'show' : '' }}"
                data-bs-parent="#sidebar-nav">

                @if (in_array($category->id, $permission_ids))
                    <li>
                        <a href="{{ route('categories') }}"
                            class="{{ Route::currentRouteName() == 'categories' || Route::currentRouteName() == 'categories.edit-category' || Route::currentRouteName() == 'categories.add-category' ? 'active' : '' }}">
                            <i
                                class="{{ Route::currentRouteName() == 'categories' || Route::currentRouteName() == 'categories.edit-category' || Route::currentRouteName() == 'categories.add-category' ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Categories</span>
                        </a>
                    </li>
                @endif
                @if (in_array($tag->id, $permission_ids))
                    <li>
                        <a href="{{ route('tags') }}"
                            class="{{ Route::currentRouteName() == 'tags' || Route::currentRouteName() == 'tags.edit' || Route::currentRouteName() == 'tags.create' ? 'active' : '' }}">
                            <i
                                class="{{ Route::currentRouteName() == 'tags' || Route::currentRouteName() == 'tags.edit' || Route::currentRouteName() == 'tags.create' ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Tags</span>
                        </a>
                    </li>
                @endif
                @if (in_array($slider->id, $permission_ids))
                    <li>
                        <a href="{{ route('sliders') }}"
                            class="{{ Route::currentRouteName() == 'sliders' || Route::currentRouteName() == 'sliders.add-slider' || Route::currentRouteName() == 'sliders.edit-slider' ? 'active' : '' }}">
                            <i
                                class="{{ Route::currentRouteName() == 'sliders' || Route::currentRouteName() == 'sliders.add-slider' || Route::currentRouteName() == 'sliders.edit-slider' ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Sliders</span>
                        </a>
                    </li>
                @endif
                @if (in_array($design->id, $permission_ids))
                    <li>
                        <a href="{{ route('designs') }}"
                            class="{{ Route::currentRouteName() == 'designs' || Route::currentRouteName() == 'designs.create' || Route::currentRouteName() == 'designs.edit' ? 'active' : '' }}">
                            <i
                                class="{{ Route::currentRouteName() == 'designs' || Route::currentRouteName() == 'designs.create' || Route::currentRouteName() == 'designs.edit' ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Designs</span>
                        </a>
                    </li>
                @endif
                @if (in_array($dealer->id, $permission_ids))
                    <li>
                        <a href="{{ route('dealers') }}"
                            class="{{ Route::currentRouteName() == 'dealers' || Route::currentRouteName() == 'dealers.create' || Route::currentRouteName() == 'dealers.edit' ? 'active' : '' }}">
                            <i
                                class="{{ Route::currentRouteName() == 'dealers' || Route::currentRouteName() == 'dealers.create' || Route::currentRouteName() == 'dealers.edit' ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Dealer</span>
                        </a>
                    </li>
                @endif

                @if (in_array($discount->id, $permission_ids))
                    <li>
                        <a href="{{ route('westage.discount') }}"
                            class="{{ Route::currentRouteName() == 'westage.discount' || Route::currentRouteName() == 'westage.discount.create' || Route::currentRouteName() == 'westage.discount.edit' ? 'active' : '' }}">
                            <i
                                class="{{ Route::currentRouteName() == 'westage.discount' || Route::currentRouteName() == 'westage.discount.create' || Route::currentRouteName() == 'westage.discount.edit' ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Westage
                                Discount</span>
                        </a>
                    </li>
                @endif
                @if (in_array($import_export->id, $permission_ids))
                <li>
                    <a href="{{ route('import.export') }}"
                        class="{{ Route::currentRouteName() == 'import.export'  ? 'active' : '' }}">
                        <i
                            class="{{ Route::currentRouteName() == 'import.export'  ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Import/Export</span>
                    </a>
                </li>
                @endif
            </ul>
        </li>

        {{-- Orders Nav --}}
<<<<<<< HEAD
        @if (in_array($order->id, $permission_ids))
            <li class="nav-item">
                <a class="nav-link {{ $currentRouteName == 'order' ? '' : 'collapsed' }}" href="{{ route('order') }}">
                    <!-- <i class="bi bi-cart-fill"></i> -->
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span>Orders</span>
                </a>
            </li>
        @endif
=======
        <li class="nav-item">
            <a class="nav-link {{ $currentRouteName == 'admin.order' ? '' : 'collapsed' }}"
                href="{{ route('admin.order') }}">
                <!-- <i class="bi bi-cart-fill"></i> -->
                <i class="fa-solid fa-cart-shopping"></i>
                <span>Orders</span>
            </a>
        </li>
>>>>>>> 52b9ed3b56895a6cdb24453a231027a11f98cb87

        {{-- Report Nav --}}
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() != 'reports.summary.items' && Route::currentRouteName() != 'reports.star' && Route::currentRouteName() != 'reports.scheme' && Route::currentRouteName() != 'reports.dealer.performace' ? 'collapsed' : '' }} {{ Route::currentRouteName() == 'reports.summary.items' || Route::currentRouteName() == 'reports.star' || Route::currentRouteName() == 'reports.scheme' || Route::currentRouteName() == 'reports.dealer.performace' ? 'active-tab' : '' }}"
                data-bs-target="#report-nav" data-bs-toggle="collapse" href="#">
                <!-- <i class="bi bi-file-text"></i> -->
                <i class="fa-solid fa-file"></i>
                <span>Reports</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>

            <ul id="report-nav"
                class="nav-content collapse {{ Route::currentRouteName() == 'reports.summary.items' || Route::currentRouteName() == 'reports.star' || Route::currentRouteName() == 'reports.scheme' || Route::currentRouteName() == 'reports.dealer.performace' ? 'show' : '' }} {{ Route::currentRouteName() == 'reports.summary.items' || Route::currentRouteName() == 'reports.star' || Route::currentRouteName() == 'reports.scheme' || Route::currentRouteName() == 'reports.dealer.performace' ? 'active-tab' : '' }}"
                data-bs-parent="#sidebar-nav"
                aria-expanded="{{ Route::currentRouteName() == 'reports.summary.items' || Route::currentRouteName() == 'reports.star' || Route::currentRouteName() == 'reports.scheme' || Route::currentRouteName() == 'reports.dealer.performace' ? 'true' : 'false' }}">

                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() != 'reports.summary.items' && Route::currentRouteName() != 'reports.star' ? 'collapsed' : '' }} {{ Route::currentRouteName() == 'reports.summary.items' || Route::currentRouteName() == 'reports.star' ? 'active-tab' : '' }}"
                        data-bs-target="#item-reports" data-bs-toggle="collapse" href="#"
                        aria-expanded="{{ Route::currentRouteName() == 'reports.summary.items' || Route::currentRouteName() == 'reports.star' ? 'true' : 'false' }}">
                        <i class=""></i><span> Item Reports</span>
                        <i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="item-reports"
                        class="nav-content collapse {{ Route::currentRouteName() == 'reports.summary.items' || Route::currentRouteName() == 'reports.star' ? 'show' : '' }} {{ Route::currentRouteName() == 'reports.summary.items' || Route::currentRouteName() == 'reports.star' ? 'active-tab' : '' }}"
                        data-bs-parent="#report-nav">
                        @if (in_array($summary_items->id, $permission_ids))
                            <ol>
                                <a href="{{ route('reports.summary.items') }}"
                                    class="{{ Route::currentRouteName() == 'reports.summary.items' ? 'active' : '' }}">
                                    <i
                                        class="{{ Route::currentRouteName() == 'reports.summary.items' ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Summary
                                        for Item</span>
                                </a>
                            </ol>
                        @endif
                        @if (in_array($reports_star->id, $permission_ids))
                            <ol>
                                <a href="{{ route('reports.star') }}"
                                    class="{{ Route::currentRouteName() == 'reports.star' ? 'active' : '' }}">
                                    <i
                                        class="{{ Route::currentRouteName() == 'reports.star' ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Star
                                        Report</span>
                                </a>
                            </ol>
                        @endif
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() != 'reports.scheme' && Route::currentRouteName() != 'reports.dealer.performace' ? 'collapsed' : '' }} {{ Route::currentRouteName() == 'reports.scheme' || Route::currentRouteName() == 'reports.dealer.performace' ? 'active-tab' : '' }}"
                        aria-expanded="{{ Route::currentRouteName() == 'reports.scheme' || Route::currentRouteName() == 'reports.dealer.performace' ? 'true' : 'false' }}"
                        data-bs-target="#dealer-report" data-bs-toggle="collapse" href="#">
                        <i class=""></i><span> Dealer Reports</span>
                        <i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="dealer-report"
                        class="nav-content collapse {{ Route::currentRouteName() == 'reports.scheme' || Route::currentRouteName() == 'reports.dealer.performace' ? 'show' : '' }}"
                        data-bs-parent="#report-nav">
                        @if (in_array($scheme->id, $permission_ids))
                            <ol>
                                <a href="{{ route('reports.scheme') }}"
                                    class="{{ Route::currentRouteName() == 'reports.scheme' ? 'active' : '' }}">
                                    <i
                                        class="{{ Route::currentRouteName() == 'reports.scheme' ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Scheme
                                        Report</span>
                                </a>
                            </ol>
                        @endif
                        @if (in_array($dealer_performace->id, $permission_ids))
                            <ol>
                                <a href="{{ route('reports.dealer.performace') }}"
                                    class="{{ Route::currentRouteName() == 'reports.dealer.performace' ? 'active' : '' }}">
                                    <i
                                        class="{{ Route::currentRouteName() == 'reports.dealer.performace' ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Dealer
                                        Performance</span>
                                </a>
                            </ol>
                        @endif
                    </ul>
                </li>
            </ul>
        </li>

        {{-- User Nav --}}
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() != 'roles' && Route::currentRouteName() != 'roles.create' && Route::currentRouteName() != 'roles.edit' && Route::currentRouteName() != 'users' && Route::currentRouteName() != 'users.create' && Route::currentRouteName() != 'users.edit' ? 'collapsed' : '' }} {{ Route::currentRouteName() == 'roles' || Route::currentRouteName() == 'roles.create' || Route::currentRouteName() == 'roles.edit' || Route::currentRouteName() == 'users' || Route::currentRouteName() == 'users.create' || Route::currentRouteName() == 'users.edit' ? 'active-tab' : '' }}"
                data-bs-target="#users-nav" data-bs-toggle="collapse" href="#"
                aria-expanded="{{ Route::currentRouteName() == 'roles' || Route::currentRouteName() == 'roles.create' || Route::currentRouteName() == 'roles.edit' || Route::currentRouteName() == 'users' || Route::currentRouteName() == 'users.create' || Route::currentRouteName() == 'users.edit' ? 'true' : 'false' }}">
                <i
                    class="fa-solid fa-users {{ Route::currentRouteName() == 'roles' || Route::currentRouteName() == 'roles.create' || Route::currentRouteName() == 'roles.edit' || Route::currentRouteName() == 'users' || Route::currentRouteName() == 'users.create' || Route::currentRouteName() == 'users.edit' ? 'icon-tab' : '' }}"></i><span>Users</span><i
                    class="bi bi-chevron-down ms-auto {{ Route::currentRouteName() == 'roles' || Route::currentRouteName() == 'roles.create' || Route::currentRouteName() == 'roles.edit' || Route::currentRouteName() == 'users' || Route::currentRouteName() == 'users.create' || Route::currentRouteName() == 'users.edit' ? 'icon-tab' : '' }}"></i>
                <!-- <i class="fa-solid fa-users"></i> -->
            </a>
            <ul id="users-nav"
                class="nav-content sidebar-ul collapse {{ Route::currentRouteName() == 'roles' || Route::currentRouteName() == 'roles.create' || Route::currentRouteName() == 'roles.edit' || Route::currentRouteName() == 'users' || Route::currentRouteName() == 'users.create' || Route::currentRouteName() == 'users.edit' ? 'show' : '' }}"
                data-bs-parent="#sidebar-nav">
                @if (in_array($role->id, $permission_ids))
                    <li>
                        <a href="{{ route('roles') }}"
                            class="{{ Route::currentRouteName() == 'roles' || Route::currentRouteName() == 'roles.create' || Route::currentRouteName() == 'roles.edit' ? 'active-link' : '' }}">
                            <i
                                class="{{ Route::currentRouteName() == 'roles' || Route::currentRouteName() == 'roles.create' || Route::currentRouteName() == 'roles.edit' ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>User
                                Type</span>
                        </a>
                    </li>
                @endif
                @if (in_array($user->id, $permission_ids))
                    <li>
                        <a href="{{ route('users') }}"
                            class="{{ Route::currentRouteName() == 'users' || Route::currentRouteName() == 'users.create' || Route::currentRouteName() == 'users.edit' ? 'active-link' : '' }}">
                            <i
                                class="{{ Route::currentRouteName() == 'users' || Route::currentRouteName() == 'users.create' || Route::currentRouteName() == 'users .edit' ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Users</span>
                        </a>
                    </li>
                @endif
            </ul>
        </li>

        {{-- Marketing Nav --}}
        @if (in_array($marketing->id, $permission_ids))
            <li class="nav-item">
                <a class="nav-link {{ $currentRouteName == 'marketing' ? '' : 'collapsed' }}"
                    href="{{ route('marketing') }}">
                    <i class="bi bi-megaphone"></i>
                    <span>Marketing</span>
                </a>
            </li>
        @endif

        </li>
    </ul>
</aside>
 