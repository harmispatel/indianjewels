@php
$currentRouteName = Route::currentRouteName();
$page_key = (isset(Route::current()->parameters()['page_key'])) ? Route::current()->parameters()['page_key'] : '';
@endphp

<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        {{-- Dashboard Nav --}}
        <li class="nav-item">
            <a class="nav-link {{ $currentRouteName == 'admin.dashboard' ? '' : 'collapsed' }}" href="{{ route('admin.dashboard') }}">
                <i class="fa-solid fa-gauge"></i><span>Dashboard</span>
            </a>
        </li>

        {{-- Master Nav --}}
        @canany(['categories.index', 'tags.index', 'designs.index', 'dealers.index', 'customers.index'])
        <li class="nav-item">
            <a class="nav-link {{ $currentRouteName != 'tags.index' && $currentRouteName != 'tags.create' && $currentRouteName != 'tags.edit' && $currentRouteName != 'categories.index' && $currentRouteName != 'categories.add-category' && $currentRouteName != 'categories.edit-category' && $currentRouteName != 'designs.index' && $currentRouteName != 'designs.create' && $currentRouteName != 'designs.edit' && $currentRouteName != 'dealers.index' && $currentRouteName != 'dealers.create' && $currentRouteName != 'dealers.edit' && $currentRouteName != 'customers.index' ? 'collapsed' : '' }}  {{ $currentRouteName == 'tags.index' || $currentRouteName == 'tags.create' || $currentRouteName == 'tags.edit' || $currentRouteName == 'categories.index' || $currentRouteName == 'categories.edit-category' || $currentRouteName == 'categories.add-category' || $currentRouteName == 'designs.index' || $currentRouteName == 'designs.create' || $currentRouteName == 'designs.edit' || $currentRouteName == 'dealers.index' || $currentRouteName == 'dealers.create' || $currentRouteName == 'dealers.edit' || $currentRouteName == 'customers.index' || $currentRouteName == 'customers.edit' ? 'active-tab' : '' }}" data-bs-target="#catalogue-nav" data-bs-toggle="collapse" href="#" aria-expanded="{{ $currentRouteName == 'tags.index' || $currentRouteName == 'tags.create' || $currentRouteName == 'tags.edit' || $currentRouteName == 'categories.index' || $currentRouteName == 'categories.edit-category' || $currentRouteName == 'categories.add-category' || $currentRouteName == 'designs.index' || $currentRouteName == 'designs.create' || $currentRouteName == 'designs.edit' || $currentRouteName == 'dealers.index' || $currentRouteName == 'dealers.create' || $currentRouteName == 'dealers.edit' || $currentRouteName == 'customers.index' || $currentRouteName == 'customers.edit' ? 'true' : 'false' }}">
                <i class="bi bi-layout-text-window-reverse"></i><span>Master</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="catalogue-nav" class="nav-content collapse {{ $currentRouteName == 'tags.index' || $currentRouteName == 'tags.create' || $currentRouteName == 'tags.edit' || $currentRouteName == 'categories.index' || $currentRouteName == 'categories.edit-category' || $currentRouteName == 'categories.add-category' || $currentRouteName == 'designs.index' || $currentRouteName == 'designs.create' || $currentRouteName == 'designs.edit' || $currentRouteName == 'dealers.index' || $currentRouteName == 'dealers.create' || $currentRouteName == 'dealers.edit' || $currentRouteName == 'customers.index' || $currentRouteName == 'customers.edit' ? 'show' : '' }}" data-bs-parent="#sidebar-nav">

                {{-- Categories --}}
                @can('categories.index')
                <li>
                    <a href="{{ route('categories.index') }}" class="{{ $currentRouteName == 'categories.index' || $currentRouteName == 'categories.edit-category' || $currentRouteName == 'categories.add-category' ? 'active' : '' }}">
                        <i class="{{ $currentRouteName == 'categories.index' || $currentRouteName == 'categories.edit-category' || $currentRouteName == 'categories.add-category' ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Categories</span>
                    </a>
                </li>
                @endcan

                {{-- Tags --}}
                @can('tags.index')
                <li>
                    <a href="{{ route('tags.index') }}" class="{{ $currentRouteName == 'tags.index' || $currentRouteName == 'tags.edit' || $currentRouteName == 'tags.create' ? 'active' : '' }}">
                        <i class="{{ $currentRouteName == 'tags.index' || $currentRouteName == 'tags.edit' || $currentRouteName == 'tags.create' ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Tags</span>
                    </a>
                </li>
                @endcan

                {{-- Designs --}}
                @can('designs.index')
                <li>
                    <a href="{{ route('designs.index') }}" class="{{ $currentRouteName == 'designs.index' || $currentRouteName == 'designs.create' || $currentRouteName == 'designs.edit' ? 'active' : '' }}">
                        <i class="{{ $currentRouteName == 'designs.index' || $currentRouteName == 'designs.create' || $currentRouteName == 'designs.edit' ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Designs</span>
                    </a>
                </li>
                @endcan

                {{-- Dealers --}}
                @can('dealers.index')
                <li>
                    <a href="{{ route('dealers.index') }}" class="{{ $currentRouteName == 'dealers.index' || $currentRouteName == 'dealers.create' || $currentRouteName == 'dealers.edit' ? 'active' : '' }}">
                        <i class="{{ $currentRouteName == 'dealers.index' || $currentRouteName == 'dealers.create' || $currentRouteName == 'dealers.edit' ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Dealers</span>
                    </a>
                </li>
                @endcan

                {{-- Customers --}}
                @can('customers.index')
                <li>
                    <a href="{{ route('customers.index') }}" class="{{( $currentRouteName == 'customers.index' || $currentRouteName == 'customers.edit') ? 'active' : '' }}">
                        <i class="{{ $currentRouteName == 'customers.index' ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Customers</span>
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endcan

        {{-- Orders Nav --}}
        @can('orders.index')
        <li class="nav-item">
            <a class="nav-link {{ ($currentRouteName == 'orders.index' || $currentRouteName == 'orders.show') ? '' : 'collapsed' }}" href="{{ route('orders.index') }}">
                <i class="fa-solid fa-cart-shopping"></i><span>Orders</span>
            </a>
        </li>
        @endcan

        {{-- Banners Nav --}}
        @canany(['top-banners.index', 'middle-banners.index', 'bottom-banners.index'])
        <li class="nav-item">
            <a class="nav-link {{ $currentRouteName != 'top-banners.index' && $currentRouteName != 'top-banners.create' && $currentRouteName != 'top-banners.edit' && $currentRouteName != 'middle-banners.index' && $currentRouteName != 'middle-banners.create' && $currentRouteName != 'middle-banners.edit' && $currentRouteName != 'bottom-banners.index' && $currentRouteName != 'bottom-banners.create' && $currentRouteName != 'bottom-banners.edit' ? 'collapsed' : '' }} {{ $currentRouteName == 'top-banners.index' || $currentRouteName == 'top-banners.create' || $currentRouteName == 'top-banners.edit' || $currentRouteName == 'middle-banners.index' || $currentRouteName == 'middle-banners.create' || $currentRouteName == 'middle-banners.edit' || $currentRouteName == 'bottom-banners.index' || $currentRouteName == 'bottom-banners.create' || $currentRouteName == 'bottom-banners.edit' ? 'active-tab' : '' }}" data-bs-target="#banners-nav" data-bs-toggle="collapse" href="#" aria-expanded="{{ $currentRouteName == 'top-banners.index' || $currentRouteName == 'top-banners.create' || $currentRouteName == 'top-banners.edit' || $currentRouteName == 'middle-banners.index' || $currentRouteName == 'middle-banners.create' || $currentRouteName == 'middle-banners.edit' || $currentRouteName == 'bottom-banners.index' || $currentRouteName == 'bottom-banners.create' || $currentRouteName == 'bottom-banners.edit' ? 'true' : 'false' }}">
                <i class="fa-solid fa-image {{ $currentRouteName == 'top-banners.index' || $currentRouteName == 'top-banners.create' || $currentRouteName == 'top-banners.edit' || $currentRouteName == 'middle-banners.index' || $currentRouteName == 'middle-banners.create' || $currentRouteName == 'middle-banners.edit' || $currentRouteName == 'bottom-banners.index' || $currentRouteName == 'bottom-banners.create' || $currentRouteName == 'bottom-banners.edit' ? 'icon-tab' : '' }}"></i><span>Banners</span><i class="bi bi-chevron-down ms-auto {{ $currentRouteName == 'top-banners.index' || $currentRouteName == 'top-banners.create' || $currentRouteName == 'top-banners.edit' || $currentRouteName == 'middle-banners.index' || $currentRouteName == 'middle-banners.create' || $currentRouteName == 'middle-banners.edit' || $currentRouteName == 'bottom-banners.index' || $currentRouteName == 'bottom-banners.create' || $currentRouteName == 'bottom-banners.edit' ? 'icon-tab' : '' }}"></i>
            </a>
            <ul id="banners-nav" class="nav-content sidebar-ul collapse {{ $currentRouteName == 'top-banners.index' || $currentRouteName == 'top-banners.create' || $currentRouteName == 'top-banners.edit' || $currentRouteName == 'middle-banners.index' || $currentRouteName == 'middle-banners.create' || $currentRouteName == 'middle-banners.edit' || $currentRouteName == 'bottom-banners.index' || $currentRouteName == 'bottom-banners.create' || $currentRouteName == 'bottom-banners.edit' ? 'show' : '' }}" data-bs-parent="#sidebar-nav">

                {{-- Top Banners --}}
                @can('top-banners.index')
                <li>
                    <a href="{{ route('top-banners.index') }}" class="{{ $currentRouteName == 'top-banners.index' || $currentRouteName == 'top-banners.create' || $currentRouteName == 'top-banners.edit' ? 'active' : '' }}">
                        <i class="{{ $currentRouteName == 'top-banners.index' || $currentRouteName == 'top-banners.create' || $currentRouteName == 'top-banners.edit' ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Top Banners</span>
                    </a>
                </li>
                @endcan

                {{-- Middle Banners --}}
                @can('middle-banners.index')
                <li>
                    <a href="{{ route('middle-banners.index') }}" class="{{ $currentRouteName == 'middle-banners.index' || $currentRouteName == 'middle-banners.create' || $currentRouteName == 'middle-banners.edit' ? 'active' : '' }}">
                        <i class="{{ $currentRouteName == 'middle-banners.index' || $currentRouteName == 'middle-banners.create' || $currentRouteName == 'middle-banners.edit' ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Middle Banners</span>
                    </a>
                </li>
                @endcan

                {{-- Bottom Banners --}}
                @can('bottom-banners.index')
                <li>
                    <a href="{{ route('bottom-banners.index') }}" class="{{ $currentRouteName == 'bottom-banners.index' || $currentRouteName == 'bottom-banners.create' || $currentRouteName == 'bottom-banners.edit' ? 'active' : '' }}">
                        <i class="{{ $currentRouteName == 'bottom-banners.index' || $currentRouteName == 'bottom-banners.create' || $currentRouteName == 'bottom-banners.edit' ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Bottom Banners</span>
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endcan

        {{-- Pages Nav --}}
        <li class="nav-item">
            <a class="nav-link {{ $currentRouteName != 'pages.index' ? 'collapsed' : '' }} {{ $currentRouteName == 'pages.index' ? 'active-tab' : '' }}" data-bs-target="#pages-nav" data-bs-toggle="collapse" href="#" aria-expanded="{{ $currentRouteName == 'pages.index' ? 'true' : 'false' }}">
                <i class="bi bi-file-text {{ $currentRouteName == 'pages.index' ? 'icon-tab' : '' }}"></i><span>Pages</span><i class="bi bi-chevron-down ms-auto {{ $currentRouteName == 'pages.index' ? 'icon-tab' : '' }}"></i>
            </a>
            <ul id="pages-nav" class="nav-content sidebar-ul collapse {{ $currentRouteName == 'pages.index' ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('pages.index','faq') }}" class="{{ ($currentRouteName == 'pages.index' && $page_key == 'faq') ? 'active' : '' }}">
                        <i class="{{ ($currentRouteName == 'pages.index' && $page_key == 'faq') ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>FAQ</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('pages.index','contact-us') }}" class="{{ ($currentRouteName == 'pages.index' && $page_key == 'contact-us') ? 'active' : '' }}">
                        <i class="{{ ($currentRouteName == 'pages.index' && $page_key == 'contact-us') ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Contact US</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('pages.index','about-us') }}" class="{{ ($currentRouteName == 'pages.index' && $page_key == 'about-us') ? 'active' : '' }}">
                        <i class="{{ ($currentRouteName == 'pages.index' && $page_key == 'about-us') ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>About US</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('pages.index','customization') }}" class="{{ ($currentRouteName == 'pages.index' && $page_key == 'customization') ? 'active' : '' }}">
                        <i class="{{ ($currentRouteName == 'pages.index' && $page_key == 'customization') ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Customization</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('pages.index', 'shopping-and-returns') }}" class="{{ ($currentRouteName == 'pages.index' && $page_key == 'shopping-and-returns') ? 'active' : '' }}">
                        <i class="{{ ($currentRouteName == 'pages.index' && $page_key == 'shopping-and-returns') ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Shopping & Returns</span>
                    </a>
                </li>
            </ul>
        </li>

        {{-- Womans Club --}}
        <li class="nav-item">
            <a class="nav-link {{ ($currentRouteName == 'womans-club.index' || $currentRouteName == 'womans-club.details') ? '' : 'collapsed' }}" href="{{ route('womans-club.index') }}">
                <i class="fa-solid fa-person-dress"></i><span>Womans Club</span>
            </a>
        </li>

        {{-- Testimonials --}}
        <li class="nav-item">
            <a class="nav-link {{ ($currentRouteName == 'testimonials.index' || $currentRouteName == 'testimonials.create' || $currentRouteName == 'testimonials.edit') ? '' : 'collapsed' }}" href="{{ route('testimonials.index') }}">
                <i class="bi bi-chat-quote"></i><span>Testimonials</span>
            </a>
        </li>

        {{-- Reports --}}
        <li class="nav-item">
            <a class="nav-link {{ $currentRouteName == 'reports.summary' || $currentRouteName == 'reports.star' || $currentRouteName == 'reports.scheme' || $currentRouteName == 'reports.performance' || $currentRouteName == 'reports.performance.details' ? '' : 'collapsed' }}" data-bs-target="#report-nav" data-bs-toggle="collapse" href="#">
                <i class="fa-solid fa-file"></i> <span>Reports</span> <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="report-nav" class="nav-content collapse {{ $currentRouteName == 'reports.summary' || $currentRouteName == 'reports.star' || $currentRouteName == 'reports.scheme' || $currentRouteName == 'reports.performance' || $currentRouteName == 'reports.performance.details' ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ $currentRouteName == 'reports.summary' || $currentRouteName == 'reports.star' ? '' : 'collapsed' }}" data-bs-target="#item-reports" data-bs-toggle="collapse" href="#">
                        <span> Item Reports</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="item-reports" class="nav-content collapse {{ $currentRouteName == 'reports.summary' || $currentRouteName == 'reports.star' ? 'show' : '' }}" data-bs-parent="#report-nav">
                        {{-- <ol>
                            <a href="{{ route('reports.summary') }}" class="{{ $currentRouteName == 'reports.summary' ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Summary</span>
                        </a>
                        </ol> --}}
                        <ol>
                            <a href="{{ route('reports.star') }}" class="{{ $currentRouteName == 'reports.star' ? 'active' : '' }}">
                                <i class="bi bi-circle"></i><span>Star Report</span>
                            </a>
                        </ol>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $currentRouteName == 'reports.scheme' || $currentRouteName == 'reports.performance' || $currentRouteName == 'reports.performance.details' ? '' : 'collapsed' }}" data-bs-target="#dealer-reports" data-bs-toggle="collapse" href="#">
                        <span> Dealer Reports</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="dealer-reports" class="nav-content collapse {{ $currentRouteName == 'reports.scheme' || $currentRouteName == 'reports.performance' || $currentRouteName == 'reports.performance.details' ? 'show' : '' }}" data-bs-parent="#report-nav">
                        {{-- <ol>
                            <a href="{{ route('reports.scheme') }}" class="{{ $currentRouteName == 'reports.scheme' ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Scheme</span>
                        </a>
                        </ol> --}}
                        <ol>
                            <a href="{{ route('reports.performance') }}" class="{{ $currentRouteName == 'reports.performance' || $currentRouteName == 'reports.performance.details' ? 'active' : '' }}">
                                <i class="bi bi-circle"></i><span>Performance</span>
                            </a>
                        </ol>
                    </ul>
                </li>
            </ul>
        </li>

        {{-- Users Nav --}}
        @canany(['roles.index', 'users.index'])
        <li class="nav-item">
            <a class="nav-link {{ $currentRouteName != 'roles.index' && $currentRouteName != 'roles.create' && $currentRouteName != 'roles.edit' && $currentRouteName != 'users.index' && $currentRouteName != 'users.create' && $currentRouteName != 'users.edit' && $currentRouteName != 'users.show' ? 'collapsed' : '' }} {{ $currentRouteName == 'roles.index' || $currentRouteName == 'roles.create' || $currentRouteName == 'roles.edit' || $currentRouteName == 'users.index' || $currentRouteName == 'users.create' || $currentRouteName == 'users.edit' || $currentRouteName == 'users.show' ? 'active-tab' : '' }}" data-bs-target="#users-nav" data-bs-toggle="collapse" href="#" aria-expanded="{{ $currentRouteName == 'roles.index' || $currentRouteName == 'roles.create' || $currentRouteName == 'roles.edit' || $currentRouteName == 'users.index' || $currentRouteName == 'users.create' || $currentRouteName == 'users.edit' || $currentRouteName == 'users.show' ? 'true' : 'false' }}">
                <i class="fa-solid fa-users {{ $currentRouteName == 'roles.index' || $currentRouteName == 'roles.create' || $currentRouteName == 'roles.edit' || $currentRouteName == 'users.index' || $currentRouteName == 'users.create' || $currentRouteName == 'users.edit' || $currentRouteName == 'users.show' ? 'icon-tab' : '' }}"></i><span>Users</span><i class="bi bi-chevron-down ms-auto {{ $currentRouteName == 'roles.index' || $currentRouteName == 'roles.create' || $currentRouteName == 'roles.edit' || $currentRouteName == 'users.index' || $currentRouteName == 'users.create' || $currentRouteName == 'users.edit' || $currentRouteName == 'users.show' ? 'icon-tab' : '' }}"></i>
            </a>
            <ul id="users-nav" class="nav-content sidebar-ul collapse {{ $currentRouteName == 'roles.index' || $currentRouteName == 'roles.create' || $currentRouteName == 'roles.edit' || $currentRouteName == 'users.index' || $currentRouteName == 'users.create' || $currentRouteName == 'users.edit' || $currentRouteName == 'users.show' ? 'show' : '' }}" data-bs-parent="#sidebar-nav">

                {{-- Roles --}}
                @can('roles.index')
                <li>
                    <a href="{{ route('roles.index') }}" class="{{ $currentRouteName == 'roles.index' || $currentRouteName == 'roles.create' || $currentRouteName == 'roles.edit' ? 'active' : '' }}">
                        <i class="{{ $currentRouteName == 'roles.index' || $currentRouteName == 'roles.create' || $currentRouteName == 'roles.edit' ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Roles</span>
                    </a>
                </li>
                @endcan

                {{-- Users --}}
                @can('users.index')
                <li>
                    <a href="{{ route('users.index') }}" class="{{ $currentRouteName == 'users.index' || $currentRouteName == 'users.create' || $currentRouteName == 'users.edit' || $currentRouteName == 'users.show' ? 'active' : '' }}">
                        <i class="{{ $currentRouteName == 'users.index' || $currentRouteName == 'users.create' || $currentRouteName == 'users.edit' || $currentRouteName == 'users.show' ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Users</span>
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endcan

        {{-- Settings --}}
        @can('settings.index')
        <li class="nav-item">
            <a class="nav-link {{ $currentRouteName == 'settings.index' ? '' : 'collapsed' }}" href="{{ route('settings.index') }}">
                <i class="bi bi-gear"></i> <span>Settings</span>
            </a>
        </li>
        @endcan
    </ul>
</aside>
