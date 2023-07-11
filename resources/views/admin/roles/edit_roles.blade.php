@extends('admin.layouts.admin-layout')

@section('title', 'Roles')

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>User Type</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item "><a href="{{ route('roles') }}">User Type</a></li>
                        <li class="breadcrumb-item active">Edit</li>
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

                    <form class="form" action="{{ route('roles.update') }}" method="POST" enctype="multipart/form-data">

                        <div class="card-body">
                            @csrf
                            <div class="form_box">
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>User Type Details</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <input type="hidden" name="id" value="{{ encrypt($role->id) }}">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="firstname" class="form-label">Name <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="name" id="name"
                                                        class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                                        placeholder="Enter Name"
                                                        value="{{ isset($role->name) ? $role->name : '' }}">
                                                    @if ($errors->has('name'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('name') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="prmission_box">
                                            <h3>Permission<span class="text-danger">*</span></h3>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="accordion" id="accordionOne">
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="headingOne">
                                                                <button class="accordion-button collapsed" type="button"
                                                                    data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                                    aria-expanded="false" aria-controls="collapseOne">
                                                                    User Type
                                                                </button>
                                                            </h2>
                                                            <div id="collapseOne" class="accordion-collapse collapse"
                                                                aria-labelledby="headingOne" data-bs-parent="#accordionOne">
                                                                @foreach ($permission->slice(0, 4) as $value)
                                                                    <div class="accordion-body">
                                                                        <label>
                                                                            <input type="checkbox" name="permission[]"
                                                                                value="{{ $value->id }}" class="mr-3"
                                                                                {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
                                                                            @if ($value->name == 'roles')
                                                                                View
                                                                            @elseif($value->name == 'roles.create')
                                                                                Add
                                                                            @elseif($value->name == 'roles.edit')
                                                                                Update
                                                                            @else
                                                                                Delete
                                                                            @endif
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="accordion" id="accordionTwo">
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="headingTwo">
                                                                <button class="accordion-button collapsed" type="button"
                                                                    data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                                                    aria-expanded="false" aria-controls="collapseTwo">
                                                                    Tags
                                                                </button>
                                                            </h2>
                                                            <div id="collapseTwo" class="accordion-collapse collapse"
                                                                aria-labelledby="headingTwo" data-bs-parent="#accordionTwo">
                                                                @foreach ($permission->slice(4, 4) as $value)
                                                                    <div class="accordion-body">
                                                                        <label>
                                                                            <input type="checkbox" name="permission[]"
                                                                                value="{{ $value->id }}" class="mr-3"
                                                                                {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
                                                                            @if ($value->name == 'tags')
                                                                                View
                                                                            @elseif($value->name == 'tags.create')
                                                                                Add
                                                                            @elseif($value->name == 'tags.edit')
                                                                                Update
                                                                            @else
                                                                                Delete
                                                                            @endif
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="accordion" id="accordionThree">
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="headingThree">
                                                                <button class="accordion-button collapsed" type="button"
                                                                    data-bs-toggle="collapse"
                                                                    data-bs-target="#collapseThree" aria-expanded="false"
                                                                    aria-controls="collapseThree">
                                                                    Designs
                                                                </button>
                                                            </h2>
                                                            <div id="collapseThree" class="accordion-collapse collapse"
                                                                aria-labelledby="headingThree"
                                                                data-bs-parent="#accordionThree">
                                                                @foreach ($permission->slice(8, 4) as $value)
                                                                    <div class="accordion-body">
                                                                        <label>
                                                                            <input type="checkbox" name="permission[]"
                                                                                value="{{ $value->id }}"
                                                                                class="mr-3"
                                                                                {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
                                                                            @if ($value->name == 'designs')
                                                                                View
                                                                            @elseif($value->name == 'designs.create')
                                                                                Add
                                                                            @elseif($value->name == 'designs.edit')
                                                                                Update
                                                                            @else
                                                                                Delete
                                                                            @endif
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="accordion" id="accordionFour">
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="headingFour">
                                                                <button class="accordion-button collapsed" type="button"
                                                                    data-bs-toggle="collapse"
                                                                    data-bs-target="#collapseFour" aria-expanded="false"
                                                                    aria-controls="collapseFour">

                                                                    Categories
                                                                </button>
                                                            </h2>
                                                            <div id="collapseFour" class="accordion-collapse collapse"
                                                                aria-labelledby="headingFour"
                                                                data-bs-parent="#accordionFour">
                                                                @foreach ($permission->slice(12, 4) as $value)
                                                                    <div class="accordion-body">
                                                                        <label>
                                                                            <input type="checkbox" name="permission[]"
                                                                                value="{{ $value->id }}"
                                                                                class="mr-3"
                                                                                {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
                                                                            @if ($value->name == 'categories')
                                                                                View
                                                                            @elseif($value->name == 'categories.add')
                                                                                Add
                                                                            @elseif($value->name == 'categories.edit')
                                                                                Update
                                                                            @else
                                                                                Delete
                                                                            @endif
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <button class="btn form_button">Update</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection
