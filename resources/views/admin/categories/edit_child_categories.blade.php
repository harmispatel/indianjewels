@php
    $quote .= '»';
@endphp

@foreach($sub_categories as $subcategory)
    @if($category_details->id != $subcategory->id )
        <option value="{{ $subcategory->id }}" {{ ($category_details->parent_category == $subcategory->id) ? 'selected' : '' }}>
        	{{$quote}} {{$subcategory->name}}
        </option>
    @endif
    @if(count($subcategory->subcategories) > 0)
        @include('admin.categories.edit_child_categories',['sub_categories' => $subcategory->subcategories])
    @endif
@endforeach
