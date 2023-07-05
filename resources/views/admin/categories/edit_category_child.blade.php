<?php $dash.='-- '; ?>
@foreach($subcategories as $subcategory)
    @if($data->id != $subcategory->id )
        <option value="{{$subcategory->id}}" @if($data->parent_category == $subcategory->id ) selected @endif >
        	{{$dash}}{{$subcategory->name}}
        </option>
    @endif
    @if(count($subcategory->subcategory))
        @include('admin.categories.edit_category_child',['subcategories' => $subcategory->subcategory])
    @endif
@endforeach