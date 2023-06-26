@extends('admin.layouts.admin-layout')

@section('title', __('Categories'))

@section('content')

<div class="pagetitle">
        <h1> Categories </h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Categories</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Category</h2>
            </div>
        </div>
    </div>
     
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form action="{{ route('categories.update-category',$categories->id) }}" method="POST" enctype="multipart/form-data"> 
        @csrf
         <div class="row">
            <div class="col-md-12 mb-2">
                <div class="form-group">
                    <strong>Name</strong>
                    <input type="text" name="name" value="{{ $categories->name }}" class="form-control" placeholder="Name">
                </div>
            </div>
            <div class="col-md-12 mb-2 status-div">
                <div class="form-group">
                    <strong>Perent Categories </strong>
                    <select name="parent_category" id="parent_category" class="form-control">
                        <option value="">Select Perent Categories  </option>
                    </select>
                </div>
            </div>
            <div class="col-md-12 mb-2">
                <div class="form-group">
                    <strong>Image</strong>
                    <input type="file" name="image" class="form-control" placeholder="image">
                    <img src="public/images/category_image/{{ $categories->image }}" width="50px" height="50px">
                </div>
            </div>
            <div class="col-md-12 mb-2">
                <div class="form-group">
                    <strong>Status</strong>
                    <select class="form-control" name="status">
                        <option {{ ($categories->status) == '1' ? 'selected' : '' }} value="1">Active</option>
                        <option {{ ($categories->status) == '0' ? 'selected' : '' }}  value="0">InActive</option>
                    </select>
                </div>
            </div>
            <div class="col-md-12 mb-2 text-center">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
     
    </form>
@endsection