<?php $dash.='-- '; ?>

@foreach($subcategories as $subcategory)
<tr>
    <?php 
    $status = $subcategory->status;
    $checked = ($status == 1) ? 'checked' : '';
    $checkVal = ($status == 1) ? 0 : 1;
    $subcategory_id = isset($subcategory->id) ? $subcategory->id : '';
    ?>
    <td>{{ $subcategory->id}}</td>
    <td>{{$dash}}{{$subcategory->name}}</td>
    @if($subcategory->image)
    <td><img src="{{asset('public/images/category_image/'.$subcategory->image)}}" alt="" width="100" height="100"></td>
    @else
    <td><img src="{{asset('public/images/category_image/not-found1.png')}}" alt="" width="100" height="100"></td>
    @endif
    <td><div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" onchange="changeStatus('{{$checkVal,$subcategory_id}}')" id="statusBtn" {{$checked}}></div></td>
    <td><a href="{{route('categories.edit-category',encrypt($subcategory_id))}}" class="btn btn-sm btn-primary me-1"><i class="bi bi-pencil"></i></a>
        <a onclick="deleteCategories('{{encrypt($subcategory_id)}}')" class="btn btn-sm btn-danger me-1"><i class="bi bi-trash"></i></a></td>
    </tr>
    @if(count($subcategory->subcategory))
        @include('admin.categories.sub-category-list',['subcategories' => $subcategory->subcategory])
    @endif
    @endforeach