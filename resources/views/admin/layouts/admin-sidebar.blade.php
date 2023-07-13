@php
    $currentRouteName = Route::currentRouteName();
    $role = Auth::guard('admin')->user();
    $role_id = $role->user_type;
    
    $permissions = App\Models\RoleHasPermissions::where('role_id',$role_id)->pluck('permission_id');
    
    foreach ($permissions as $permission) {
        $permission_ids[] = $permission;
    }
    
    $category = Spatie\Permission\Models\Permission::where('name','categories')->first();
    $tag = Spatie\Permission\Models\Permission::where('name','tags')->first();
    $slider = Spatie\Permission\Models\Permission::where('name','sliders')->first();
    $design = Spatie\Permission\Models\Permission::where('name','designs')->first();
    $dealer = Spatie\Permission\Models\Permission::where('name','dealers')->first();
    $discount = Spatie\Permission\Models\Permission::where('name','westage.discount')->first();
    $role = Spatie\Permission\Models\Permission::where('name','roles')->first();
    $user = Spatie\Permission\Models\Permission::where('name','users')->first();

    
@endphp

<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link {{ $currentRouteName == 'admin.dashboard' ? '' : 'collapsed' }}"
                href="{{ route('admin.dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() != 'tags' && Route::currentRouteName() != 'tags.create' && Route::currentRouteName() != 'tags.edit' && Route::currentRouteName() != 'categories' && Route::currentRouteName() != 'categories.add-category' && Route::currentRouteName() != 'categories.edit-category' && Route::currentRouteName() != 'sliders' && Route::currentRouteName() != 'sliders.edit-slider' && Route::currentRouteName() != 'sliders.add-slider' && Route::currentRouteName() != 'designs' && Route::currentRouteName() != 'designs.create' && Route::currentRouteName() != 'designs.edit'  && Route::currentRouteName() != 'dealers' && Route::currentRouteName() != 'dealers.create' && Route::currentRouteName() != 'dealers.edit' && Route::currentRouteName() != 'westage.discount' && Route::currentRouteName() != 'westage.discount.create' && Route::currentRouteName() != 'westage.discount.edit'  ? 'collapsed' : '' }}  {{ Route::currentRouteName() == 'tags' || Route::currentRouteName() == 'tags.create' || Route::currentRouteName() == 'tags.edit' || Route::currentRouteName() == 'categories' || Route::currentRouteName() == 'categories.edit-category' || Route::currentRouteName() == 'categories.add-category' || Route::currentRouteName() == 'designs' || Route::currentRouteName() == 'designs.create' || Route::currentRouteName() == 'designs.edit' || Route::currentRouteName() == 'dealers' || Route::currentRouteName() == 'dealers.create' || Route::currentRouteName() == 'dealers.edit' || Route::currentRouteName() == 'westage.discount' || Route::currentRouteName() == 'westage.discount.create' || Route::currentRouteName() == 'westage.discount.edit' ? 'active-tab' : '' }}"
                data-bs-target="#catalogue-nav" data-bs-toggle="collapse" href="#"
                aria-expanded="{{ Route::currentRouteName() == 'tags' || Route::currentRouteName() == 'tags.create' || Route::currentRouteName() == 'tags.edit' || Route::currentRouteName() == 'categories' || Route::currentRouteName() == 'categories.edit-category' || Route::currentRouteName() == 'categories.add-category' || Route::currentRouteName() == 'sliders' || Route::currentRouteName() == 'sliders.add-slider' || Route::currentRouteName() == 'sliders.edit-slider' || Route::currentRouteName() == 'designs' || Route::currentRouteName() == 'designs.create' || Route::currentRouteName() == 'designs.edit' || Route::currentRouteName() == 'dealers' || Route::currentRouteName() == 'dealers.create' || Route::currentRouteName() == 'dealers.edit' || Route::currentRouteName() == 'westage.discount' || Route::currentRouteName() == 'westage.discount.create' || Route::currentRouteName() == 'westage.discount.edit' ? 'true' : 'false' }}">
                <i class="bi bi-layout-text-window-reverse"></i><span>Master</span><i
                    class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="catalogue-nav"
                class="nav-content collapse {{ Route::currentRouteName() == 'tags' || Route::currentRouteName() == 'tags.create' || Route::currentRouteName() == 'tags.edit' || Route::currentRouteName() == 'categories' || Route::currentRouteName() == 'categories.edit-category' || Route::currentRouteName() == 'categories.add-category' || Route::currentRouteName() == 'sliders' || Route::currentRouteName() == 'sliders.add-slider' || Route::currentRouteName() == 'sliders.edit-slider' || Route::currentRouteName() == 'designs' || Route::currentRouteName() == 'designs.create' || Route::currentRouteName() == 'designs.edit' || Route::currentRouteName() == 'dealers' || Route::currentRouteName() == 'dealers.create' || Route::currentRouteName() == 'dealers.edit' || Route::currentRouteName() == 'westage.discount' || Route::currentRouteName() == 'westage.discount.create' || Route::currentRouteName() == 'westage.discount.edit' ? 'show' : '' }}"
                data-bs-parent="#sidebar-nav">

                @if(in_array($category->id, $permission_ids))
                <li>
                    <a href="{{ route('categories') }}"
                        class="{{ Route::currentRouteName() == 'categories' || Route::currentRouteName() == 'categories.edit-category' || Route::currentRouteName() == 'categories.add-category' ? 'active' : '' }}">
                        <i
                            class="{{ Route::currentRouteName() == 'categories' || Route::currentRouteName() == 'categories.edit-category' || Route::currentRouteName() == 'categories.add-category' ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Categories</span>
                    </a>
                </li>
                @endif
                @if(in_array($tag->id, $permission_ids))
                <li>
                    <a href="{{ route('tags') }}"
                        class="{{ Route::currentRouteName() == 'tags' || Route::currentRouteName() == 'tags.edit' || Route::currentRouteName() == 'tags.create' ? 'active' : '' }}">
                        <i
                            class="{{ Route::currentRouteName() == 'tags' || Route::currentRouteName() == 'tags.edit' || Route::currentRouteName() == 'tags.create' ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Tags</span>
                    </a>
                </li>
                @endif
                @if(in_array($slider->id, $permission_ids))
                <li>
                    <a href="{{ route('sliders') }}"
                        class="{{ Route::currentRouteName() == 'sliders' || Route::currentRouteName() == 'sliders.add-slider' || Route::currentRouteName() == 'sliders.edit-slider' ? 'active' : '' }}">
                        <i
                            class="{{ Route::currentRouteName() == 'sliders' || Route::currentRouteName() == 'sliders.add-slider' || Route::currentRouteName() == 'sliders.edit-slider' ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Sliders</span>
                    </a>
                </li>
                @endif
                @if(in_array($design->id, $permission_ids))
                <li>
                    <a href="{{ route('designs') }}"
                        class="{{ Route::currentRouteName() == 'designs' || Route::currentRouteName() == 'designs.create' || Route::currentRouteName() == 'designs.edit' ? 'active' : '' }}">
                        <i
                            class="{{ Route::currentRouteName() == 'designs' || Route::currentRouteName() == 'designs.create' || Route::currentRouteName() == 'designs.edit' ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Designs</span>
                    </a>
                </li>
                @endif
                @if(in_array($dealer->id, $permission_ids))
                <li>
                    <a href="{{ route('dealers') }}" class="{{ Route::currentRouteName() == 'dealers' || Route::currentRouteName() == 'dealers.create' || Route::currentRouteName() == 'dealers.edit'  ? 'active' : '' }}">
                        <i class="{{Route::currentRouteName() == 'dealers' || Route::currentRouteName() == 'dealers.create' || Route::currentRouteName() == 'dealers.edit'  ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Dealer</span>
                    </a>
                </li>
                @endif
                @if(in_array($discount->id, $permission_ids))
                <li>
                    <a href="{{route('westage.discount')}}" class="{{ Route::currentRouteName() == 'westage.discount' || Route::currentRouteName() == 'westage.discount.create' || Route::currentRouteName() == 'westage.discount.edit'  ? 'active' : '' }}">
                        <i class="{{Route::currentRouteName() == 'westage.discount' || Route::currentRouteName() == 'westage.discount.create' || Route::currentRouteName() == 'westage.discount.edit'  ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Westage Disount</span>
                    </a>
                </li> 
                @endif
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
                @if(in_array($role->id, $permission_ids))
                <li>
                    <a href="{{ route('roles') }}"
                        class="{{ Route::currentRouteName() == 'roles' || Route::currentRouteName() == 'roles.create' || Route::currentRouteName() == 'roles.edit' ? 'active-link' : '' }}">
                        <i
                            class="{{ Route::currentRouteName() == 'roles' || Route::currentRouteName() == 'roles.create' || Route::currentRouteName() == 'roles.edit' ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>User
                            Type</span>
                    </a>
                </li>
                @endif
                @if(in_array($user->id, $permission_ids))
                <li>
                    <a href="{{route('users')}}" class="{{ Route::currentRouteName() == 'users' || Route::currentRouteName() == 'users.create' || Route::currentRouteName() == 'users.edit' ? 'active-link' : '' }}">
                        <i class="{{ Route::currentRouteName() == 'users' || Route::currentRouteName() == 'users.create' || Route::currentRouteName() == 'users .edit' ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Users</span>
                    </a>
                </li>
                @endif
            </ul>
        </li>

        </li>
    </ul>
</aside>
