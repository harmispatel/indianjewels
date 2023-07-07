@extends('admin.layouts.admin-layout')

@section('title', __('Sliders'))

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>Sliders</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item "><a href="{{ route('sliders') }}">Sliders</a></li>
                    </ol>
                </nav>
            </div>
            
        </div>
    </div>

    {{-- New Clients add Section --}}
    <section class="section dashboard">
        <div class="row">
            {{-- Error Message Section --}}
            @if (session()->has('error'))
                <div class="col-md-12">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            {{-- Success Message Section --}}
            @if (session()->has('success'))
                <div class="col-md-12">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif
    
            {{-- Clients Card --}}
            <div class="col-md-12">
                <div class="card">
                    <form action="{{ route('sliders.update-slider') }}" method="POST" enctype="multipart/form-data"> 
                        <div class="card-body">
                        @csrf
                        <div class="form_box">
                            <div class="form_box_inr">
                                <div class="box_title">
                                    <h2>Sliders Details</h2>
                                </div>
                                <div class="form_box_info">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <input type="hidden" name="id" value="{{encrypt($data->id)}}">
                                            <div class="form-group">
                                            <label for="image" class="form-label">Image <span
                                                class="text-danger">*</span></label>
                                                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" placeholder="image">
                                                <div class="mt-2">
                                                @if($data->image)
                                                <img src="{{ asset('public/images/slider_image/'.$data->image) }}" width="100" height="100">
                                                @else
                                                <img src="{{ asset('public/images/slider_image/not-found4.png') }}" width="100" height="100">
                                                @endif
                                                </div>
                                            </div>
                                        </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                <label for="banner_text" class="form-label">Banner Text </label>
                                                    <textarea name="banner_text" id="banner_text" value="{{ $data->banner_text }}" class="form-control" placeholder="Enter Banner Text"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                        <div class="card-footer text-center">
                                            <button class="btn btn-success">Update</button>
                                        </div>
                                    </div>
                            </div>                            
                        </div>     
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection