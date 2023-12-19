@php
    $quote .= '»';
@endphp

@foreach ($subcategories as $subcategory)
    <tr>
        <td>{{ $subcategory->id }}</td>
        <td> {{ $quote }} {{ $subcategory->name }}</td>
        <td>
            @if (!empty($subcategory->image) && file_exists('public/images/uploads/category_images/' . $subcategory->image))
                <img src="{{ asset('public/images/uploads/category_images/' . $subcategory->image) }}" width="60">
            @else
                <img src="{{ asset('public/images/default_images/not-found/no_img1.jpg') }}" width="60">
            @endif
        </td>
        <td>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" onchange="changeStatus('{{ encrypt($subcategory->id) }}')" id="statusBtn" {{ ($subcategory->status == 1) ? 'checked' : '' }}>
            </div>
        </td>
        <td>
            <a onclick="editCategory('{{ encrypt($subcategory->id) }}')" class="btn btn-sm custom-btn me-1"><i class="bi bi-pencil"></i></a>
            <a onclick="deleteCategory('{{ encrypt($subcategory->id) }}')" class="btn btn-sm btn-danger me-1"><i class="bi bi-trash"></i></a>
        </td>
    </tr>
    @if (count($subcategory->subcategories))
        @include('admin.categories.sub_categories', ['subcategories' => $subcategory->subcategories])
    @endif
@endforeach
