@php
    $currentRouteName = Route::currentRouteName();
@endphp

<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        {{-- Dashboard Nav --}}
        <li class="nav-item">
            <a class="nav-link {{ $currentRouteName == 'admin.dashboard' ? '' : 'collapsed' }}"
                href="{{ route('admin.dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        {{-- Master Nav --}}
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() != 'tags' && Route::currentRouteName() != 'tags.create' && Route::currentRouteName() != 'tags.edit' && Route::currentRouteName() != 'categories' && Route::currentRouteName() != 'categories.add-category' && Route::currentRouteName() != 'categories.edit-category' && Route::currentRouteName() != 'sliders' && Route::currentRouteName() != 'sliders.edit-slider' && Route::currentRouteName() != 'sliders.add-slider' && Route::currentRouteName() != 'designs' && Route::currentRouteName() != 'designs.create' && Route::currentRouteName() != 'designs.edit'  && Route::currentRouteName() != 'dealers' && Route::currentRouteName() != 'dealers.create' && Route::currentRouteName() != 'dealers.edit' ? 'collapsed' : '' }}  {{ Route::currentRouteName() == 'tags' || Route::currentRouteName() == 'tags.create' || Route::currentRouteName() == 'tags.edit' || Route::currentRouteName() == 'categories' || Route::currentRouteName() == 'categories.edit-category' || Route::currentRouteName() == 'categories.add-category' || Route::currentRouteName() == 'designs' || Route::currentRouteName() == 'designs.create' || Route::currentRouteName() == 'designs.edit' || Route::currentRouteName() == 'dealers' || Route::currentRouteName() == 'dealers.create' || Route::currentRouteName() == 'dealers.edit' ? 'active-tab' : '' }}"
                data-bs-target="#catalogue-nav" data-bs-toggle="collapse" href="#"
                aria-expanded="{{ Route::currentRouteName() == 'tags' || Route::currentRouteName() == 'tags.create' || Route::currentRouteName() == 'tags.edit' || Route::currentRouteName() == 'categories' || Route::currentRouteName() == 'categories.edit-category' || Route::currentRouteName() == 'categories.add-category' || Route::currentRouteName() == 'sliders' || Route::currentRouteName() == 'sliders.add-slider' || Route::currentRouteName() == 'sliders.edit-slider' || Route::currentRouteName() == 'designs' || Route::currentRouteName() == 'designs.create' || Route::currentRouteName() == 'designs.edit' || Route::currentRouteName() == 'dealers' || Route::currentRouteName() == 'dealers.create' || Route::currentRouteName() == 'dealers.edit' ? 'true' : 'false' }}">
                <i class="bi bi-layout-text-window-reverse"></i><span>Master</span><i
                    class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="catalogue-nav"
                class="nav-content collapse {{ Route::currentRouteName() == 'tags' || Route::currentRouteName() == 'tags.create' || Route::currentRouteName() == 'tags.edit' || Route::currentRouteName() == 'categories' || Route::currentRouteName() == 'categories.edit-category' || Route::currentRouteName() == 'categories.add-category' || Route::currentRouteName() == 'sliders' || Route::currentRouteName() == 'sliders.add-slider' || Route::currentRouteName() == 'sliders.edit-slider' || Route::currentRouteName() == 'designs' || Route::currentRouteName() == 'designs.create' || Route::currentRouteName() == 'designs.edit' || Route::currentRouteName() == 'dealers' || Route::currentRouteName() == 'dealers.create' || Route::currentRouteName() == 'dealers.edit' ? 'show' : '' }}"
                data-bs-parent="#sidebar-nav">

                <li>
                    <a href="{{ route('categories') }}"
                        class="{{ Route::currentRouteName() == 'categories' || Route::currentRouteName() == 'categories.edit-category' || Route::currentRouteName() == 'categories.add-category' ? 'active' : '' }}">
                        <i
                            class="{{ Route::currentRouteName() == 'categories' || Route::currentRouteName() == 'categories.edit-category' || Route::currentRouteName() == 'categories.add-category' ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Categories</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('tags') }}"
                        class="{{ Route::currentRouteName() == 'tags' || Route::currentRouteName() == 'tags.edit' || Route::currentRouteName() == 'tags.create' ? 'active' : '' }}">
                        <i
                            class="{{ Route::currentRouteName() == 'tags' || Route::currentRouteName() == 'tags.edit' || Route::currentRouteName() == 'tags.create' ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Tags</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('sliders') }}"
                        class="{{ Route::currentRouteName() == 'sliders' || Route::currentRouteName() == 'sliders.add-slider' || Route::currentRouteName() == 'sliders.edit-slider' ? 'active' : '' }}">
                        <i
                            class="{{ Route::currentRouteName() == 'sliders' || Route::currentRouteName() == 'sliders.add-slider' || Route::currentRouteName() == 'sliders.edit-slider' ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Sliders</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('designs') }}"
                        class="{{ Route::currentRouteName() == 'designs' || Route::currentRouteName() == 'designs.create' || Route::currentRouteName() == 'designs.edit' ? 'active' : '' }}">
                        <i
                            class="{{ Route::currentRouteName() == 'designs' || Route::currentRouteName() == 'designs.create' || Route::currentRouteName() == 'designs.edit' ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Designs</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dealers') }}" class="{{ Route::currentRouteName() == 'dealers' || Route::currentRouteName() == 'dealers.create' || Route::currentRouteName() == 'dealers.edit'  ? 'active' : '' }}">
                        <i class="{{Route::currentRouteName() == 'dealers' || Route::currentRouteName() == 'dealers.create' || Route::currentRouteName() == 'dealers.edit'  ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Dealer</span>
                    </a>
                </li>
            </ul>
        </li>

        {{-- Orders Nav --}}
        <li class="nav-item">
            <a class="nav-link {{ $currentRouteName == '' ? '' : 'collapsed' }}"
                href="{{ route('admin.order') }}">
                <i class="bi bi-grid"></i>
                <span>Orders</span>
            </a>
        </li>

        {{-- Report Nav --}}
        <li class="nav-item">
            <a class="nav-link collapsed"  data-bs-target="#report-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-layout-text-window-reverse"></i><span>Reports</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            
            <ul id="report-nav"
                class="nav-content sidebar-ul collapse {{ Route::currentRouteName() == 'reports.summary.items' || Route::currentRouteName() == 'reports.star' || Route::currentRouteName() == 'reports.scheme' ||  Route::currentRouteName() == 'reports.dealer.performace' ? 'show' : '' }}"
                data-bs-parent="#sidebar-nav">

                <li>
                    <a href="#" class="">
                        <i class=""></i><span> -- Item Report</span>
                    </a>
                    <ul id="report-nav"
                        class="nav-content sidebar-ul collapse {{ Route::currentRouteName() == 'reports.summary.items' || Route::currentRouteName() == 'reports.star' ? 'show' : '' }}"
                        data-bs-parent="#sidebar-nav">
                        <ol>
                            <a href="{{ route('reports.summary.items') }}" class="{{ Route::currentRouteName() == 'reports.summary.items'  ? 'active-link' : '' }}">
                                <i class="{{ Route::currentRouteName() == 'reports.summary.items'  ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Summary for Item</span>
                            </a>
                        </ol>
                        <ol>
                            <a href="{{ route('reports.star') }}" class="{{ Route::currentRouteName() == 'reports.star'  ? 'active-link' : '' }}">
                                <i class="{{ Route::currentRouteName() == 'reports.star'  ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Star Report</span>
                            </a>
                        </ol>
                    </ul>
                </li>
                <li>
                    <a href="#" class="">
                        <i class=""></i><span> -- Dealer Report</span>
                    </a>
                    <ul id="report-nav"
                        class="nav-content sidebar-ul collapse {{ Route::currentRouteName() == 'reports.scheme' ||  Route::currentRouteName() == 'reports.dealer.performace' ? 'show' : '' }}""
                        data-bs-parent="#sidebar-nav">
                        <ol>
                            <a href="{{ route('reports.scheme') }}" class="{{ Route::currentRouteName() == 'reports.scheme'  ? 'active-link' : '' }}">
                                <i class="{{ Route::currentRouteName() == 'reports.scheme'  ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Scheme Report</span>
                            </a>
                        </ol>
                        <ol>
                            <a href="{{ route('reports.dealer.performace') }}" class="{{ Route::currentRouteName() == 'reports.dealer.performace'  ? 'active-link' : '' }}">
                                <i class="{{ Route::currentRouteName() == 'reports.dealer.performace'  ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Dealer Performance</span>
                            </a>
                        </ol>
                    </ul>
                </li>
            </ul>
        </li>

        {{-- User Nav --}}
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() != 'roles' && Route::currentRouteName() != 'roles.create' && Route::currentRouteName() != 'roles.edit' &&  Route::currentRouteName() != 'users' && Route::currentRouteName() != 'users.create' && Route::currentRouteName() != 'users.edit' ? 'collapsed' : '' }} {{ Route::currentRouteName() == 'roles' || Route::currentRouteName() == 'roles.create' || Route::currentRouteName() == 'roles.edit' || Route::currentRouteName() == 'users' || Route::currentRouteName() == 'users.create' || Route::currentRouteName() == 'users.edit' ? 'active-tab' : '' }}"
                data-bs-target="#users-nav" data-bs-toggle="collapse" href="#"
                aria-expanded="{{ Route::currentRouteName() == 'roles' || Route::currentRouteName() == 'roles.create' || Route::currentRouteName() == 'roles.edit' ||  Route::currentRouteName() == 'users' || Route::currentRouteName() == 'users.create' || Route::currentRouteName() == 'users.edit' ? 'true' : 'false' }}">
                <i
                    class="bi bi-people {{ Route::currentRouteName() == 'roles' || Route::currentRouteName() == 'roles.create' || Route::currentRouteName() == 'roles.edit' ||  Route::currentRouteName() == 'users' || Route::currentRouteName() == 'users.create' || Route::currentRouteName() == 'users.edit' ? 'icon-tab' : '' }}"></i><span>Users</span><i
                    class="bi bi-chevron-down ms-auto {{ Route::currentRouteName() == 'roles' || Route::currentRouteName() == 'roles.create' || Route::currentRouteName() == 'roles.edit' || Route::currentRouteName() == 'users' || Route::currentRouteName() == 'users.create' || Route::currentRouteName() == 'users.edit' ? 'icon-tab' : '' }}"></i>
            </a>
            <ul id="users-nav"
                class="nav-content sidebar-ul collapse {{ Route::currentRouteName() == 'roles' || Route::currentRouteName() == 'roles.create' || Route::currentRouteName() == 'roles.edit' ||  Route::currentRouteName() == 'users' || Route::currentRouteName() == 'users.create' || Route::currentRouteName() == 'users.edit' ? 'show' : '' }}"
                data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('roles') }}"
                        class="{{ Route::currentRouteName() == 'roles' || Route::currentRouteName() == 'roles.create' || Route::currentRouteName() == 'roles.edit' ? 'active-link' : '' }}">
                        <i
                            class="{{ Route::currentRouteName() == 'roles' || Route::currentRouteName() == 'roles.create' || Route::currentRouteName() == 'roles.edit' ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>User
                            Type</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('users')}}" class="{{ Route::currentRouteName() == 'users' || Route::currentRouteName() == 'users.create' || Route::currentRouteName() == 'users.edit' ? 'active-link' : '' }}">
                        <i class="{{ Route::currentRouteName() == 'users' || Route::currentRouteName() == 'users.create' || Route::currentRouteName() == 'users .edit' ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Users</span>
                    </a>
                </li>

            </ul>
        </li>

        {{-- Marketing Nav --}}
        <li class="nav-item">
            <a class="nav-link {{ $currentRouteName == '' ? '' : 'collapsed' }}"
                href="{{ route('admin.marketing') }}">
                <i class="bi bi-grid"></i>
                <span>Marketing</span>
            </a>
        </li>

        </li>
    </ul>
</aside>
