@php
    $currentRouteName = Route::currentRouteName();
@endphp

<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link {{ ($currentRouteName == 'admin.dashboard') ? '' : 'collapsed' }}" href="{{ route('admin.dashboard') }}">
            <i class="bi bi-grid"></i>
            <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ (Route::currentRouteName() != 'tags' && Route::currentRouteName() != 'tags.create' && Route::currentRouteName() != 'tags.edit' && Route::currentRouteName() != 'admin.categories' && Route::currentRouteName() != 'categories.add-category' && Route::currentRouteName() != 'categories.edit-category' && Route::currentRouteName() != 'sliders' && Route::currentRouteName() != 'sliders.edit-slider' &&  Route::currentRouteName() != 'sliders.add-slider' && Route::currentRouteName() != 'designs' && Route::currentRouteName() != 'designs.create' && Route::currentRouteName() != 'designs.edit' )  ? 'collapsed' : '' }}  {{ (Route::currentRouteName() == 'tags' || Route::currentRouteName() == 'tags.create' || Route::currentRouteName() == 'tags.edit' || Route::currentRouteName() == 'admin.categories'|| Route::currentRouteName() == 'categories.edit-category' || Route::currentRouteName() == 'categories.add-category' || Route::currentRouteName() == 'designs' || Route::currentRouteName() == 'designs.create' || Route::currentRouteName() == 'designs.edit') ? 'active-tab' : '' }}" data-bs-target="#catalogue-nav" data-bs-toggle="collapse" href="#" aria-expanded="{{ (Route::currentRouteName() == 'tags' || Route::currentRouteName() == 'tags.create' || Route::currentRouteName() == 'tags.edit' || Route::currentRouteName() == 'admin.categories'|| Route::currentRouteName() == 'categories.edit-category' || Route::currentRouteName() == 'categories.add-category' || Route::currentRouteName() == 'sliders'|| Route::currentRouteName() == 'sliders.add-slider' || Route::currentRouteName() == 'sliders.edit-slider' || Route::currentRouteName() == 'designs' || Route::currentRouteName() == 'designs.create' || Route::currentRouteName() == 'designs.edit') ? 'true' : 'false' }}">
                <i class="bi bi-layout-text-window-reverse"></i><span>Master</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="catalogue-nav" class="nav-content collapse {{ (Route::currentRouteName() == 'tags' || Route::currentRouteName() == 'tags.create' || Route::currentRouteName() == 'tags.edit' || Route::currentRouteName() == 'admin.categories'|| Route::currentRouteName() == 'categories.edit-category' || Route::currentRouteName() == 'categories.add-category' ||Route::currentRouteName() == 'sliders'|| Route::currentRouteName() == 'sliders.add-slider' || Route::currentRouteName() == 'sliders.edit-slider' || Route::currentRouteName() == 'designs' || Route::currentRouteName() == 'designs.create' || Route::currentRouteName() == 'designs.edit') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">

                <li>
                    <a href="{{ route('admin.categories') }}" class="{{(Route::currentRouteName() == 'admin.categories'|| Route::currentRouteName() == 'categories.edit-category' || Route::currentRouteName() == 'categories.add-category') ? 'active' : '' }}">
                        <i class="{{ (Route::currentRouteName() == 'admin.categories' || Route::currentRouteName() == 'categories.edit-category' || Route::currentRouteName() == 'categories.add-category') ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Categories</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('tags')}}" class="{{(Route::currentRouteName() == 'tags'|| Route::currentRouteName() == 'tags.edit' || Route::currentRouteName() == 'tags.create') ? 'active' : '' }}">
                        <i class="{{ (Route::currentRouteName() == 'tags' || Route::currentRouteName() == 'tags.edit' || Route::currentRouteName() == 'tags.create') ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Tags</span>
                    </a>
                </li> 
                <li>
                    <a href="{{ route('sliders') }}" class="{{(Route::currentRouteName() == 'sliders'|| Route::currentRouteName() == 'sliders.add-slider' || Route::currentRouteName() == 'sliders.edit-slider') ? 'active' : '' }}">
                        <i class="{{ (Route::currentRouteName() == 'sliders' || Route::currentRouteName() == 'sliders.add-slider' || Route::currentRouteName() == 'sliders.edit-slider') ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Sliders</span>
                    </a>
                </li> 
                    <li>  
                    <a href="{{ route('designs') }}" class="{{ (Route::currentRouteName() == 'designs' || Route::currentRouteName() == 'designs.create' || Route::currentRouteName() == 'designs.edit') ? 'active' : '' }}">
                        <i class="{{ (Route::currentRouteName() == 'designs' || Route::currentRouteName() == 'designs.create' || Route::currentRouteName() == 'designs.edit') ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Designs</span>
                    </a>
                </li>
                {{-- <li>
                    <a href="#">
                        <i class="bi bi-circle"></i><span>Data Tables</span>
                    </a>
                </li> --}}
            </ul>
        </li>
    </ul>
  </aside>
