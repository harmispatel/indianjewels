@php
    $quote .= '»';
    $role = Auth::guard('admin')->user()->user_type;
    $cat_edit = Spatie\Permission\Models\Permission::where('name','categories.edit')->first();
    $cat_delete = Spatie\Permission\Models\Permission::where('name','categories.destroy')->first();
    $permissions = App\Models\RoleHasPermissions::where('role_id', $role)->pluck('permission_id');
    foreach ($permissions as $permission) {
        $permission_ids[] = $permission;
    }
@endphp

@foreach ($subcategories as $subcategory)
    @php
        $status = $subcategory->status;
        $checked = $status == 1 ? 'checked' : '';
        $checkVal = $status == 1 ? 0 : 1;
    @endphp

    <tr>
        <td>{{ $subcategory->id }}</td>
        <td> {{ $quote }} {{ $subcategory->name }}</td>
        <td>
            @if (!empty($subcategory->image) && file_exists('public/images/uploads/category_images/' . $subcategory->image))
                <img src="{{ asset('public/images/uploads/category_images/' . $subcategory->image) }}" width="60">
            @else
                <img src="{{ asset('public/images/uploads/category_images/no_image.jpg') }}" width="60">
            @endif
        </td>
        <td>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch"
                    onchange="changeStatus({{ $checkVal }},'{{ encrypt($subcategory->id) }}')" id="statusBtn"
                    {{ $checked }}>
            </div>
        </td>
        <td>
            @if (in_array($cat_edit->id, $permission_ids))
                <a onclick="editCategory('{{ encrypt($subcategory->id) }}')" class="btn btn-sm custom-btn me-1"><i
                        class="bi bi-pencil"></i></a>
            @else
                <a onclick="editCategory('{{ encrypt($subcategory->id) }}')"
                    class="btn btn-sm custom-btn me-1 disabled"><i class="bi bi-pencil"></i></a>
            @endif
            @if (in_array($cat_delete->id, $permission_ids))
                <a onclick="deleteCategory('{{ encrypt($subcategory->id) }}')" class="btn btn-sm btn-danger me-1"><i
                        class="bi bi-trash"></i></a>
            @else
                <a onclick="deleteCategory('{{ encrypt($subcategory->id) }}')"
                    class="btn btn-sm btn-danger me-1 disabled"><i class="bi bi-trash"></i></a>
            @endif
        </td>
    </tr>

    @if (count($subcategory->subcategories))
        @include('admin.categories.sub_categories', ['subcategories' => $subcategory->subcategories])
    @endif
@endforeach
