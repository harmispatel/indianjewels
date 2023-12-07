@extends('admin.layouts.admin-layout')

@section('title', 'Impel Jewellers | Edit Role')

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>Roles</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item "><a href="{{ route('roles') }}">Roles</a></li>
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
                                        <h2>Role Details</h2>
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


                                                    <div class="col-md-3">
                                                        <div class="accordion" id="accordionFive">
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="headingFive">
                                                                    <button class="accordion-button collapsed" type="button"
                                                                        data-bs-toggle="collapse"
                                                                        data-bs-target="#collapseFive" aria-expanded="false"
                                                                        aria-controls="collapseFive">
                                                                        Users
                                                                    </button>
                                                                </h2>
                                                                <div id="collapseFive" class="accordion-collapse collapse"
                                                                    aria-labelledby="headingFive"
                                                                    data-bs-parent="#accordionFive">
                                                                    @foreach ($permission->slice(16, 4) as $value)
                                                                        <div class="accordion-body">
                                                                            <label>
                                                                                <input type="checkbox" name="permission[]"
                                                                                    value="{{ $value->id }}"
                                                                                    class="mr-3" {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
                                                                                        @if ($value->name == 'users')
                                                                                            View
                                                                                        @elseif($value->name == 'users.create')
                                                                                            Add
                                                                                        @elseif($value->name == 'users.edit')
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
                                                    <div class="accordion" id="accordionSix">
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="headingSix">
                                                                <button class="accordion-button collapsed" type="button"
                                                                    data-bs-toggle="collapse"
                                                                    data-bs-target="#collapseSix" aria-expanded="false"
                                                                    aria-controls="collapseSix">
                                                                    Sliders
                                                                </button>
                                                            </h2>
                                                            <div id="collapseSix" class="accordion-collapse collapse"
                                                                aria-labelledby="headingSix"
                                                                data-bs-parent="#accordionSix">
                                                                @foreach ($permission->slice(20, 4) as $value)
                                                                    <div class="accordion-body">
                                                                        <label>
                                                                            <input type="checkbox" name="permission[]"
                                                                                value="{{ $value->id }}"
                                                                                class="mr-3" {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>

                                                                                    @if ($value->name == 'sliders')
                                                                                        View
                                                                                    @elseif($value->name == 'sliders.add-slider')
                                                                                        Add
                                                                                    @elseif($value->name == 'sliders.edit-slider')
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
                                                    <div class="accordion" id="accordionSeven">
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="headingSeven">
                                                                <button class="accordion-button collapsed" type="button"
                                                                    data-bs-toggle="collapse"
                                                                    data-bs-target="#collapseSeven" aria-expanded="false"
                                                                    aria-controls="collapseSeven">
                                                                    Dealers
                                                                </button>
                                                            </h2>
                                                            <div id="collapseSeven" class="accordion-collapse collapse"
                                                                aria-labelledby="headingSeven"
                                                                data-bs-parent="#accordionSeven">
                                                                @foreach ($permission->slice(24, 4) as $value)
                                                                    <div class="accordion-body">
                                                                        <label>
                                                                            <input type="checkbox" name="permission[]"
                                                                                value="{{ $value->id }}"
                                                                                class="mr-3" {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
                                                                                    @if ($value->name == 'dealers')
                                                                                        View
                                                                                    @elseif($value->name == 'dealers.create')
                                                                                        Add
                                                                                    @elseif($value->name == 'dealers.edit')
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
                                                    <div class="accordion" id="accordionEight">
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="headingSeven">
                                                                <button class="accordion-button collapsed" type="button"
                                                                    data-bs-toggle="collapse"
                                                                    data-bs-target="#collapseEight" aria-expanded="false"
                                                                    aria-controls="collapseEight">
                                                                    Wastage Discount
                                                                </button>
                                                            </h2>
                                                            <div id="collapseEight" class="accordion-collapse collapse"
                                                                aria-labelledby="headingSeven"
                                                                data-bs-parent="#accordionEight">
                                                                @foreach ($permission->slice(28, 4) as $value)
                                                                    <div class="accordion-body">
                                                                        <label>
                                                                            <input type="checkbox" name="permission[]"
                                                                                value="{{ $value->id }}"
                                                                                class="mr-3" {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
                                                                                    @if ($value->name == 'westage.discount')
                                                                                        View
                                                                                    @elseif($value->name == 'westage.discount.create')
                                                                                        Add
                                                                                    @elseif($value->name == 'westage.discount.edit')
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
                                                    <div class="accordion" id="accordionNine">
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="heading">
                                                                <button class="accordion-button collapsed" type="button"
                                                                    data-bs-toggle="collapse"
                                                                    data-bs-target="#collapseNine" aria-expanded="false"
                                                                    aria-controls="collapseNine">
                                                                    Summary For Item
                                                                </button>
                                                            </h2>
                                                            <div id="collapseNine" class="accordion-collapse collapse"
                                                                aria-labelledby="heading"
                                                                data-bs-parent="#accordionNine">
                                                                @foreach ($permission->slice(32, 1) as $value)
                                                                    <div class="accordion-body">
                                                                        <label>
                                                                            <input type="checkbox" name="permission[]"
                                                                                value="{{ $value->id }}"
                                                                                class="mr-3" {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
                                                                                @if($value->name == 'reports.summary.items')
                                                                                View
                                                                                @endif
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="accordion" id="accordionTen">
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="heading">
                                                                <button class="accordion-button collapsed" type="button"
                                                                    data-bs-toggle="collapse"
                                                                    data-bs-target="#collapseTen" aria-expanded="false"
                                                                    aria-controls="collapseTen">
                                                                    Star Report
                                                                </button>
                                                            </h2>
                                                            <div id="collapseTen" class="accordion-collapse collapse"
                                                                aria-labelledby="heading"
                                                                data-bs-parent="#accordionTen">
                                                                @foreach ($permission->slice(33, 1) as $value)
                                                                    <div class="accordion-body">
                                                                        <label>
                                                                            <input type="checkbox" name="permission[]"
                                                                                value="{{ $value->id }}"
                                                                                class="mr-3" {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
                                                                                @if($value->name == 'reports.star')
                                                                                View
                                                                                @endif
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="accordion" id="accordionEleven">
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="heading">
                                                                <button class="accordion-button collapsed" type="button"
                                                                    data-bs-toggle="collapse"
                                                                    data-bs-target="#collapseEleven" aria-expanded="false"
                                                                    aria-controls="collapseEleven">
                                                                    Scheme Report
                                                                </button>
                                                            </h2>
                                                            <div id="collapseEleven" class="accordion-collapse collapse"
                                                                aria-labelledby="heading"
                                                                data-bs-parent="#accordionEleven">
                                                                @foreach ($permission->slice(34, 1) as $value)
                                                                    <div class="accordion-body">
                                                                        <label>
                                                                            <input type="checkbox" name="permission[]"
                                                                                value="{{ $value->id }}"
                                                                                class="mr-3" {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
                                                                                @if($value->name == 'reports.scheme')
                                                                                View
                                                                                @endif
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="accordion" id="accordionTwelve">
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="heading">
                                                                <button class="accordion-button collapsed" type="button"
                                                                    data-bs-toggle="collapse"
                                                                    data-bs-target="#collapseTwelve" aria-expanded="false"
                                                                    aria-controls="collapseTwelve">
                                                                    Dealer Performance
                                                                </button>
                                                            </h2>
                                                            <div id="collapseTwelve" class="accordion-collapse collapse"
                                                                aria-labelledby="heading"
                                                                data-bs-parent="#accordionTwelve">
                                                                @foreach ($permission->slice(35, 1) as $value)
                                                                    <div class="accordion-body">
                                                                        <label>
                                                                            <input type="checkbox" name="permission[]"
                                                                                value="{{ $value->id }}"
                                                                                class="mr-3" {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
                                                                                @if($value->name == 'reports.dealer.performace')
                                                                                View
                                                                                @endif
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="accordion" id="accordionThirteen">
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="heading">
                                                                <button class="accordion-button collapsed" type="button"
                                                                    data-bs-toggle="collapse"
                                                                    data-bs-target="#collapseThirteen" aria-expanded="false"
                                                                    aria-controls="collapseThirteen">
                                                                    Orders
                                                                </button>
                                                            </h2>
                                                            <div id="collapseThirteen" class="accordion-collapse collapse"
                                                                aria-labelledby="heading"
                                                                data-bs-parent="#accordionThirteen">
                                                                @foreach ($permission->slice(36, 1) as $value)
                                                                    <div class="accordion-body">
                                                                        <label>
                                                                            <input type="checkbox" name="permission[]"
                                                                                value="{{ $value->id }}"
                                                                                class="mr-3" {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
                                                                                @if($value->name == 'order')
                                                                                View
                                                                                @endif
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="accordion" id="accordionFourteen">
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="heading">
                                                                <button class="accordion-button collapsed" type="button"
                                                                    data-bs-toggle="collapse"
                                                                    data-bs-target="#collapseFourteen" aria-expanded="false"
                                                                    aria-controls="collapseFourteen">
                                                                    Marketing
                                                                </button>
                                                            </h2>
                                                            <div id="collapseFourteen" class="accordion-collapse collapse"
                                                                aria-labelledby="heading"
                                                                data-bs-parent="#accordionFourteen">
                                                                @foreach ($permission->slice(37, 1) as $value)
                                                                    <div class="accordion-body">
                                                                        <label>
                                                                            <input type="checkbox" name="permission[]"
                                                                                value="{{ $value->id }}"
                                                                                class="mr-3" {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
                                                                                @if($value->name == 'marketing')
                                                                                View
                                                                                @endif
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="accordion" id="accordionFifteen">
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="heading">
                                                                <button class="accordion-button collapsed" type="button"
                                                                    data-bs-toggle="collapse"
                                                                    data-bs-target="#collapseFifteen" aria-expanded="false"
                                                                    aria-controls="collapseFifteen">
                                                                    Import/Export
                                                                </button>
                                                            </h2>
                                                            <div id="collapseFifteen" class="accordion-collapse collapse"
                                                                aria-labelledby="heading"
                                                                data-bs-parent="#accordionFifteen">
                                                                @foreach ($permission->slice(38, 1) as $value)
                                                                    <div class="accordion-body">
                                                                        <label>
                                                                            <input type="checkbox" name="permission[]"
                                                                                value="{{ $value->id }}"
                                                                                class="mr-3" {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
                                                                                @if($value->name == 'import.export')
                                                                                View
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
