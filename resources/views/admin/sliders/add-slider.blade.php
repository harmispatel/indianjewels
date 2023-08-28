@extends('admin.layouts.admin-layout')

@section('title', __('Top Banner'))

@section('content')


{{-- Page Title --}}
    <div class="pagetitle">
        <h1>Top Banner</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item "><a href="{{ route('sliders') }}">Top Banner</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </nav>
            </div>
            
        </div>
    </div>


    {{-- New Clients add Section --}}
    <section class="section dashboard">
        <div class="row">
        

    {{-- Clients Card --}}
    <div class="col-md-12">
        <div class="card">
            <form action="{{ route('sliders.store-slider') }}" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                    @csrf
                    <div class="form_box">
                        <div class="form_box_inr">
                            <div class="box_title">
                                <h2>Top Banner Details</h2>
                            </div>
                            <div class="form_box_info">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="image" class="form-label">Image <span
                                                class="text-danger">*</span></label>
                                            <input type="file" name="image" id= "image" class="form-control @error('image') is-invalid @enderror" placeholder="image">
                                            @if ($errors->has('image'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('image') }}
                                                </div>
                                            @endif<br>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="banner_text" class="form-label">Banner Text </label>
                                            <textarea name="banner_text" id="banner_text" class="form-control" placeholder="Enter Banner Text"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="tags" class="form-label">Tags
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select name="tags[]" id="tags"
                                                class="select2 form-control form-select {{ $errors->has('tags') ? 'is-invalid' : '' }}"
                                                multiple>
                                                @if (count($tags) > 0)
                                                    @foreach ($tags as $tag)
                                                        <option value="{{ $tag->id }}" {{ in_array($tag->id, (array) old('tags', [])) ? "selected" : "" }}>{{ $tag->name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @if ($errors->has('tags'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('tags') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <button class="btn form_button">{{ __('Save') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('page-js')
    <script type="text/javascript">
        $('#tags').select2({
            placeholder: "-- select tags --",
            allowClear: true

        });
    </script>
@endsection