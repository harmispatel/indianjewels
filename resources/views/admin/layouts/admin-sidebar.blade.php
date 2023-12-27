@php
    $currentRouteName = Route::currentRouteName();
@endphp

<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        {{-- Dashboard Nav --}}
        <li class="nav-item">
            <a class="nav-link {{ $currentRouteName == 'admin.dashboard' ? '' : 'collapsed' }}" href="{{ route('admin.dashboard') }}">
                <i class="fa-solid fa-gauge"></i><span>Dashboard</span>
            </a>
        </li>

        {{-- Master --}}
        <li class="nav-item">
            <a class="nav-link {{ $currentRouteName != 'tags.index' && $currentRouteName != 'tags.create' && $currentRouteName != 'tags.edit' && $currentRouteName != 'categories.index' && $currentRouteName != 'categories.add-category' && $currentRouteName != 'categories.edit-category' && $currentRouteName != 'designs.index' && $currentRouteName != 'designs.create' && $currentRouteName != 'designs.edit' && $currentRouteName != 'dealers.index' && $currentRouteName != 'dealers.create' && $currentRouteName != 'dealers.edit' && $currentRouteName != 'customers.index' ? 'collapsed' : '' }}  {{ $currentRouteName == 'tags.index' || $currentRouteName == 'tags.create' || $currentRouteName == 'tags.edit' || $currentRouteName == 'categories.index' || $currentRouteName == 'categories.edit-category' || $currentRouteName == 'categories.add-category' || $currentRouteName == 'designs.index' || $currentRouteName == 'designs.create' || $currentRouteName == 'designs.edit' || $currentRouteName == 'dealers.index' || $currentRouteName == 'dealers.create' || $currentRouteName == 'dealers.edit' || $currentRouteName == 'customers.index' || $currentRouteName == 'customers.edit' ? 'active-tab' : '' }}" data-bs-target="#catalogue-nav" data-bs-toggle="collapse" href="#" aria-expanded="{{ $currentRouteName == 'tags.index' || $currentRouteName == 'tags.create' || $currentRouteName == 'tags.edit' || $currentRouteName == 'categories.index' || $currentRouteName == 'categories.edit-category' || $currentRouteName == 'categories.add-category' || $currentRouteName == 'designs.index' || $currentRouteName == 'designs.create' || $currentRouteName == 'designs.edit' || $currentRouteName == 'dealers.index' || $currentRouteName == 'dealers.create' || $currentRouteName == 'dealers.edit' || $currentRouteName == 'customers.index' || $currentRouteName == 'customers.edit' ? 'true' : 'false' }}">
                <i class="bi bi-layout-text-window-reverse"></i><span>Master</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="catalogue-nav" class="nav-content collapse {{ $currentRouteName == 'tags.index' || $currentRouteName == 'tags.create' || $currentRouteName == 'tags.edit' || $currentRouteName == 'categories.index' || $currentRouteName == 'categories.edit-category' || $currentRouteName == 'categories.add-category' || $currentRouteName == 'designs.index' || $currentRouteName == 'designs.create' || $currentRouteName == 'designs.edit' || $currentRouteName == 'dealers.index' || $currentRouteName == 'dealers.create' || $currentRouteName == 'dealers.edit' || $currentRouteName == 'customers.index' || $currentRouteName == 'customers.edit' ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('categories.index') }}" class="{{ $currentRouteName == 'categories.index' || $currentRouteName == 'categories.edit-category' || $currentRouteName == 'categories.add-category' ? 'active' : '' }}">
                        <i class="{{ $currentRouteName == 'categories.index' || $currentRouteName == 'categories.edit-category' || $currentRouteName == 'categories.add-category' ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Categories</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('tags.index') }}" class="{{ $currentRouteName == 'tags.index' || $currentRouteName == 'tags.edit' || $currentRouteName == 'tags.create' ? 'active' : '' }}">
                        <i class="{{ $currentRouteName == 'tags.index' || $currentRouteName == 'tags.edit' || $currentRouteName == 'tags.create' ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Tags</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('designs.index') }}" class="{{ $currentRouteName == 'designs.index' || $currentRouteName == 'designs.create' || $currentRouteName == 'designs.edit' ? 'active' : '' }}">
                        <i class="{{ $currentRouteName == 'designs.index' || $currentRouteName == 'designs.create' || $currentRouteName == 'designs.edit' ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Designs</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dealers.index') }}" class="{{ $currentRouteName == 'dealers.index' || $currentRouteName == 'dealers.create' || $currentRouteName == 'dealers.edit' ? 'active' : '' }}">
                        <i class="{{ $currentRouteName == 'dealers.index' || $currentRouteName == 'dealers.create' || $currentRouteName == 'dealers.edit' ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Dealers</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('customers.index') }}" class="{{( $currentRouteName == 'customers.index' || $currentRouteName == 'customers.edit') ? 'active' : '' }}">
                        <i class="{{ $currentRouteName == 'customers.index' ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Customers</span>
                    </a>
                </li>
            </ul>
        </li>

        {{-- Orders --}}
        <li class="nav-item">
            <a class="nav-link {{ ($currentRouteName == 'orders.index' || $currentRouteName == 'orders.show') ? '' : 'collapsed' }}" href="{{ route('orders.index') }}">
                <i class="fa-solid fa-cart-shopping"></i><span>Orders</span>
            </a>
        </li>

        {{-- Banners --}}
        <li class="nav-item">
            <a class="nav-link {{ $currentRouteName != 'top-banners.index' && $currentRouteName != 'top-banners.create' && $currentRouteName != 'top-banners.edit' && $currentRouteName != 'middle-banners.index' && $currentRouteName != 'middle-banners.create' && $currentRouteName != 'middle-banners.edit' && $currentRouteName != 'bottom-banners.index' && $currentRouteName != 'bottom-banners.create' && $currentRouteName != 'bottom-banners.edit' ? 'collapsed' : '' }} {{ $currentRouteName == 'top-banners.index' || $currentRouteName == 'top-banners.create' || $currentRouteName == 'top-banners.edit' || $currentRouteName == 'middle-banners.index' || $currentRouteName == 'middle-banners.create' || $currentRouteName == 'middle-banners.edit' || $currentRouteName == 'bottom-banners.index' || $currentRouteName == 'bottom-banners.create' || $currentRouteName == 'bottom-banners.edit' ? 'active-tab' : '' }}" data-bs-target="#banners-nav" data-bs-toggle="collapse" href="#" aria-expanded="{{ $currentRouteName == 'top-banners.index' || $currentRouteName == 'top-banners.create' || $currentRouteName == 'top-banners.edit' || $currentRouteName == 'middle-banners.index' || $currentRouteName == 'middle-banners.create' || $currentRouteName == 'middle-banners.edit' || $currentRouteName == 'bottom-banners.index' || $currentRouteName == 'bottom-banners.create' || $currentRouteName == 'bottom-banners.edit' ? 'true' : 'false' }}">
                <i class="fa-solid fa-image {{ $currentRouteName == 'top-banners.index' || $currentRouteName == 'top-banners.create' || $currentRouteName == 'top-banners.edit' || $currentRouteName == 'middle-banners.index' || $currentRouteName == 'middle-banners.create' || $currentRouteName == 'middle-banners.edit' || $currentRouteName == 'bottom-banners.index' || $currentRouteName == 'bottom-banners.create' || $currentRouteName == 'bottom-banners.edit' ? 'icon-tab' : '' }}"></i><span>Banners</span><i class="bi bi-chevron-down ms-auto {{ $currentRouteName == 'top-banners.index' || $currentRouteName == 'top-banners.create' || $currentRouteName == 'top-banners.edit' || $currentRouteName == 'middle-banners.index' || $currentRouteName == 'middle-banners.create' || $currentRouteName == 'middle-banners.edit' || $currentRouteName == 'bottom-banners.index' || $currentRouteName == 'bottom-banners.create' || $currentRouteName == 'bottom-banners.edit' ? 'icon-tab' : '' }}"></i>
            </a>
            <ul id="banners-nav" class="nav-content sidebar-ul collapse {{ $currentRouteName == 'top-banners.index' || $currentRouteName == 'top-banners.create' || $currentRouteName == 'top-banners.edit' || $currentRouteName == 'middle-banners.index' || $currentRouteName == 'middle-banners.create' || $currentRouteName == 'middle-banners.edit' || $currentRouteName == 'bottom-banners.index' || $currentRouteName == 'bottom-banners.create' || $currentRouteName == 'bottom-banners.edit' ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('top-banners.index') }}" class="{{ $currentRouteName == 'top-banners.index' || $currentRouteName == 'top-banners.create' || $currentRouteName == 'top-banners.edit' ? 'active' : '' }}">
                        <i class="{{ $currentRouteName == 'top-banners.index' || $currentRouteName == 'top-banners.create' || $currentRouteName == 'top-banners.edit' ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Top Banners</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('middle-banners.index') }}" class="{{ $currentRouteName == 'middle-banners.index' || $currentRouteName == 'middle-banners.create' || $currentRouteName == 'middle-banners.edit' ? 'active' : '' }}">
                        <i class="{{ $currentRouteName == 'middle-banners.index' || $currentRouteName == 'middle-banners.create' || $currentRouteName == 'middle-banners.edit' ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Middle Banners</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('bottom-banners.index') }}" class="{{ $currentRouteName == 'bottom-banners.index' || $currentRouteName == 'bottom-banners.create' || $currentRouteName == 'bottom-banners.edit' ? 'active' : '' }}">
                        <i class="{{ $currentRouteName == 'bottom-banners.index' || $currentRouteName == 'bottom-banners.create' || $currentRouteName == 'bottom-banners.edit' ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Bottom Banners</span>
                    </a>
                </li>
            </ul>
        </li>

        {{-- Pages Nav --}}
        <li class="nav-item">
            <a class="nav-link {{ ($currentRouteName == 'pages.index' || $currentRouteName == 'pages.create' || $currentRouteName == 'pages.edit') ? '' : 'collapsed' }}" href="{{ route('pages.index') }}">
                <i class="bi bi-file-text"></i> <span>Pages</span>
            </a>
        </li>

        {{-- Reports --}}
        <li class="nav-item">
            <a class="nav-link {{ $currentRouteName != 'reports.summary.items' && $currentRouteName != 'reports.star' && $currentRouteName != 'reports.scheme' && $currentRouteName != 'reports.dealer.performace' ? 'collapsed' : '' }} {{ $currentRouteName == 'reports.summary.items' || $currentRouteName == 'reports.star' || $currentRouteName == 'reports.scheme' || $currentRouteName == 'reports.dealer.performace' ? 'active-tab' : '' }}" data-bs-target="#report-nav" data-bs-toggle="collapse" href="#">
                <i class="fa-solid fa-file"></i> <span>Reports</span> <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="report-nav"
                class="nav-content collapse {{ $currentRouteName == 'reports.summary.items' || $currentRouteName == 'reports.star' || $currentRouteName == 'reports.scheme' || $currentRouteName == 'reports.dealer.performace' ? 'show' : '' }} {{ $currentRouteName == 'reports.summary.items' || $currentRouteName == 'reports.star' || $currentRouteName == 'reports.scheme' || $currentRouteName == 'reports.dealer.performace' ? 'active-tab' : '' }}"
                data-bs-parent="#sidebar-nav"
                aria-expanded="{{ $currentRouteName == 'reports.summary.items' || $currentRouteName == 'reports.star' || $currentRouteName == 'reports.scheme' || $currentRouteName == 'reports.dealer.performace' ? 'true' : 'false' }}">

                <li class="nav-item">
                    <a class="nav-link {{ $currentRouteName != 'reports.summary.items' && $currentRouteName != 'reports.star' ? 'collapsed' : '' }} {{ $currentRouteName == 'reports.summary.items' || $currentRouteName == 'reports.star' ? 'active-tab' : '' }}"
                        data-bs-target="#item-reports" data-bs-toggle="collapse" href="#"
                        aria-expanded="{{ $currentRouteName == 'reports.summary.items' || $currentRouteName == 'reports.star' ? 'true' : 'false' }}">
                        <i class=""></i><span> Item Reports</span>
                        <i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="item-reports"
                        class="nav-content collapse {{ $currentRouteName == 'reports.summary.items' || $currentRouteName == 'reports.star' ? 'show' : '' }} {{ $currentRouteName == 'reports.summary.items' || $currentRouteName == 'reports.star' ? 'active-tab' : '' }}"
                        data-bs-parent="#report-nav">
                            <ol>
                                <a href="{{ route('reports.summary.items') }}"
                                    class="{{ $currentRouteName == 'reports.summary.items' ? 'active' : '' }}">
                                    <i
                                        class="{{ $currentRouteName == 'reports.summary.items' ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Summary
                                        for Item</span>
                                </a>
                            </ol>
                            <ol>
                                <a href="{{ route('reports.star') }}"
                                    class="{{ $currentRouteName == 'reports.star' ? 'active' : '' }}">
                                    <i
                                        class="{{ $currentRouteName == 'reports.star' ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Star
                                        Report</span>
                                </a>
                            </ol>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $currentRouteName != 'reports.scheme' && $currentRouteName != 'reports.dealer.performace' ? 'collapsed' : '' }} {{ $currentRouteName == 'reports.scheme' || $currentRouteName == 'reports.dealer.performace' ? 'active-tab' : '' }}"
                        aria-expanded="{{ $currentRouteName == 'reports.scheme' || $currentRouteName == 'reports.dealer.performace' ? 'true' : 'false' }}"
                        data-bs-target="#dealer-report" data-bs-toggle="collapse" href="#">
                        <i class=""></i><span> Dealer Reports</span>
                        <i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="dealer-report"
                        class="nav-content collapse {{ $currentRouteName == 'reports.scheme' || $currentRouteName == 'reports.dealer.performace' ? 'show' : '' }}"
                        data-bs-parent="#report-nav">
                            <ol>
                                <a href="{{ route('reports.scheme') }}"
                                    class="{{ $currentRouteName == 'reports.scheme' ? 'active' : '' }}">
                                    <i
                                        class="{{ $currentRouteName == 'reports.scheme' ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Scheme
                                        Report</span>
                                </a>
                            </ol>
                            <ol>
                                <a href="{{ route('reports.dealer.performace') }}"
                                    class="{{ $currentRouteName == 'reports.dealer.performace' ? 'active' : '' }}">
                                    <i
                                        class="{{ $currentRouteName == 'reports.dealer.performace' ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Dealer
                                        Performance</span>
                                </a>
                            </ol>
                    </ul>
                </li>
            </ul>
        </li>

        {{-- Users --}}
        <li class="nav-item">
            <a class="nav-link {{ $currentRouteName != 'roles.index' && $currentRouteName != 'roles.create' && $currentRouteName != 'roles.edit' && $currentRouteName != 'users.index' && $currentRouteName != 'users.create' && $currentRouteName != 'users.edit' && $currentRouteName != 'users.show' ? 'collapsed' : '' }} {{ $currentRouteName == 'roles.index' || $currentRouteName == 'roles.create' || $currentRouteName == 'roles.edit' || $currentRouteName == 'users.index' || $currentRouteName == 'users.create' || $currentRouteName == 'users.edit' || $currentRouteName == 'users.show' ? 'active-tab' : '' }}" data-bs-target="#users-nav" data-bs-toggle="collapse" href="#" aria-expanded="{{ $currentRouteName == 'roles.index' || $currentRouteName == 'roles.create' || $currentRouteName == 'roles.edit' || $currentRouteName == 'users.index' || $currentRouteName == 'users.create' || $currentRouteName == 'users.edit' || $currentRouteName == 'users.show' ? 'true' : 'false' }}">
                <i class="fa-solid fa-users {{ $currentRouteName == 'roles.index' || $currentRouteName == 'roles.create' || $currentRouteName == 'roles.edit' || $currentRouteName == 'users.index' || $currentRouteName == 'users.create' || $currentRouteName == 'users.edit' || $currentRouteName == 'users.show' ? 'icon-tab' : '' }}"></i><span>Users</span><i class="bi bi-chevron-down ms-auto {{ $currentRouteName == 'roles.index' || $currentRouteName == 'roles.create' || $currentRouteName == 'roles.edit' || $currentRouteName == 'users.index' || $currentRouteName == 'users.create' || $currentRouteName == 'users.edit' || $currentRouteName == 'users.show' ? 'icon-tab' : '' }}"></i>
            </a>
            <ul id="users-nav" class="nav-content sidebar-ul collapse {{ $currentRouteName == 'roles.index' || $currentRouteName == 'roles.create' || $currentRouteName == 'roles.edit' || $currentRouteName == 'users.index' || $currentRouteName == 'users.create' || $currentRouteName == 'users.edit' || $currentRouteName == 'users.show' ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('roles.index') }}" class="{{ $currentRouteName == 'roles.index' || $currentRouteName == 'roles.create' || $currentRouteName == 'roles.edit' ? 'active-link' : '' }}">
                        <i class="{{ $currentRouteName == 'roles.index' || $currentRouteName == 'roles.create' || $currentRouteName == 'roles.edit' ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Roles</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('users.index') }}" class="{{ $currentRouteName == 'users.index' || $currentRouteName == 'users.create' || $currentRouteName == 'users.edit' || $currentRouteName == 'users.show' ? 'active-link' : '' }}">
                        <i class="{{ $currentRouteName == 'users.index' || $currentRouteName == 'users.create' || $currentRouteName == 'users.edit' || $currentRouteName == 'users.show' ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Users</span>
                    </a>
                </li>
            </ul>
        </li>

        {{-- Settings --}}
        <li class="nav-item">
            <a class="nav-link {{ $currentRouteName == 'settings' ? '' : 'collapsed' }}" href="{{ route('settings') }}">
                <i class="bi bi-gear"></i> <span>Settings</span>
            </a>
        </li>
    </ul>
</aside>
