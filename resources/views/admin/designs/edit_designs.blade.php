@extends('admin.layouts.admin-layout')

@section('title', 'Impel Jewellers | Edit Design')

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>Designs</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item "><a href="{{ route('designs') }}">Designs</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </nav>
            </div>

        </div>
    </div>

    {{-- Edit Design Section --}}
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <form class="form" action="{{ route('designs.update') }}" method="POST"
                        enctype="multipart/form-data">
                        <div class="card-body">
                            @csrf
                            <div class="form_box">
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>General Information</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <input type="hidden" name="id" value="{{ encrypt($data->id) }}">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="name" class="form-label">Design Name <span class="text-danger">*</span></label>
                                                    <input type="text" name="name" id="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" placeholder="Enter Design Name" value="{{ isset($data->name) ? $data->name : old('name') }}">
                                                    @if ($errors->has('name'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('name') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="code" class="form-label">Design No. <span class="text-danger">*</span></label>
                                                    <input type="text" name="code" id="code" class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" placeholder="Enter Design No." value="{{ isset($data->code) ? $data->code : old('code') }}">
                                                    @if ($errors->has('code'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('code') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="category_id" class="form-label">
                                                        Design Category
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <select name="category_id" id="category_id"
                                                        class="form-control {{ $errors->has('category_id') ? 'is-invalid' : '' }}">
                                                        <option value="">-- Select Category --</option>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}"
                                                                @if ($data->category_id == $category->id) selected='selected' @endif>
                                                                {{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('code'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('code') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="gender_id" class="form-label">Gender Type<span
                                                        class="text-danger">*</span></label>
                                                <select name="gender_id" id="gender_id"
                                                    class="form-control {{ $errors->has('gender_id') ? 'is-invalid' : '' }}">
                                                    <option value="">-- Select Gender --</option>
                                                    @foreach ($genders as $gender)
                                                        <option value="{{ $gender->id }}"
                                                            @if ($data->gender_id == $gender->id) selected='selected' @endif>
                                                            {{ $gender->name }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('gender_id'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('gender_id') }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="metal_id" class="form-label">Metal Type<span
                                                        class="text-danger">*</span></label>
                                                <select name="metal_id" id="metal_id"
                                                    class="form-control {{ $errors->has('metal_id') ? 'is-invalid' : '' }}">
                                                    <option value="">-- Select Metal --</option>
                                                    @foreach ($metals as $metal)
                                                        <option value="{{ $metal->id }}"
                                                            @if ($data->metal_id == $metal->id) selected='selected' @endif>
                                                            {{ $metal->name }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('metal_id'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('metal_id') }}
                                                    </div>
                                                @endif
                                            </div>
                                            @php
                                                $tagselected = isset($data->tags) ? json_decode($data->tags) : '';
                                            @endphp
                                            <div class="col-md-6">
                                                <label for="tags" class="form-label">Tags</label>
                                                <select name="tags[]" id="tags"
                                                    class="select2 form-select {{ $errors->has('tags') ? 'is-invalid' : '' }}"
                                                    multiple>
                                                    @if (count($tags) > 0)
                                                        @foreach ($tags as $tag)
                                                            <option value="{{ $tag->id }}"
                                                                @if ($tagselected) {{ in_array($tag->id, $tagselected) ? 'selected' : '' }} @endif>
                                                                {{ $tag->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @if ($errors->has('tags'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('tags') }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="gemstone_price" class="form-label">
                                                        GemStone Price
                                                    </label>
                                                    <input type="number" name="gemstone_price" id="gemstone_price" class="form-control" placeholder="Enter GemStone Price" value="{{isset($data->gemstone_price) ? $data->gemstone_price : old('gemstone_price')}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="price" class="form-label">
                                                        Price
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" name="price" id="price"
                                                        class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}"
                                                        placeholder="Enter Item price" value="{{isset($data->price) ? $data->price : old('price')}}">
                                                    @if ($errors->has('price'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('price') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="highest_selling">Top Selling Item</label>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="highest_selling" role="switch" id="highest_selling"
                                                        value="1" {{ $data->highest_selling == 1 ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="description" class="form-label">Design Description</label>
                                                <textarea name="description" placeholder="Enter Design Description" id="description"
                                                    class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" cols="20" rows="3">{{ isset($data->description) ? $data->description : old('description') }}</textarea>
                                                @if ($errors->has('description'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('description') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>Weight Information</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <div>
                                            <h5><b>Gross Weight :</b></h5>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <div class="form-group">
                                                    <label for="" class="form-label">14 K / 68 Touch</label>
                                                    <input type="number" id="14_gross" weight-name="14_gross" name="gweight1" step="any" class="form-control gross-weight" value="{{ $data->gweight1 }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="form-label">18 K / 75 Touch</label>
                                                    <input type="number" step="any" id="18_gross" weight-name="18_gross" name="gweight2" class="form-control gross-weight" value="{{ $data->gweight2 }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="form-label">20 K / 83 Touch</label>
                                                    <input type="number" step="any" id="20_gross" weight-name="20_gross" name="gweight3" class="form-control gross-weight" value="{{ $data->gweight3 }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="form-label">22 K / 92 Touch</label>
                                                    <input type="number" step="any" id="22_gross" weight-name="22_gross" name="gweight4" class="form-control gross-weight" value="{{ $data->gweight4 }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <h5><b>Less Weight :</b></h5>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="">Less Gems Stone</label>
                                                    <input type="number" id="less_gems_stone" name="less_gems_stone" step="any" class="form-control less-weight" value="{{ $data->less_gems_stone }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="">Less C.Z. Stone</label>
                                                    <input type="number" id="less_cz_stone" name="less_cz_stone" step="any" class="form-control less-weight" value="{{ $data->less_cz_stone }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <h5><b>Net Weight :</b></h5>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <div class="form-group">
                                                    <label for="" class="form-label">14 K / 68 Touch</label>
                                                    <input type="number" step="any" style="background: #e9e9e9" id="14_net" name="nweight1" class="form-control" value="{{ $data->nweight1 }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="form-label">18 K / 75 Touch</label>
                                                    <input type="number" step="any" style="background: #e9e9e9" id="18_net" name="nweight2" class="form-control" value="{{ $data->nweight2 }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="form-label">20 K / 83 Touch</label>
                                                    <input type="number" step="any" style="background: #e9e9e9" id="20_net" name="nweight3" class="form-control" value="{{ $data->nweight3 }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="form-label">22 K / 92 Touch</label>
                                                    <input type="number" step="any" style="background: #e9e9e9" name="nweight4" id="22_net" class="form-control" value="{{ $data->nweight4 }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <h5><b>Percentage :</b></h5>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <input type="number" step="any" name="percentage" class="form-control" value="{{ $data->percentage }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>Design Image Information</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="image" class="form-label">Main Image</label>
                                                {{-- <input type="file" name="image" id="image"
                                                    class="form-control"> --}}
                                                <div class="mt-2 mult-img-box">
                                                    @if(isset($data->image) && !empty($data->image) && file_exists('public/images/uploads/item_images/'.$data->code.'/'.$data->image))
                                                        <img src="{{ asset('public/images/uploads/item_images/'.$data->code.'/'.$data->image) }}" alt="" width="100" height="100">
                                                    @else
                                                        <img src="{{ asset('public/images/default_images/not-found/no_img1.jpg') }}" width="100" height="100">
                                                    @endif
                                                </div>
                                            </div>

                                            @php
                                                $item_images = isset($data->designImages) ? $data->designImages : [];
                                            @endphp
                                            <div class="col-md-6">
                                                <label for="images" class="form-label">Multiple Images</label>
                                                {{-- <input type="file" name="multiImage[]" id="images" class="form-control" multiple> --}}
                                                @if (count($item_images) > 0)
                                                    <div class="mt-2">
                                                        <div class="d-flex aline-item-center flex-wrap">
                                                            @foreach ($item_images as $image)
                                                                <div class="mult-img-box">
                                                                    @if(isset($image->image) && !empty($image->image) && file_exists('public/images/uploads/item_images/'.$data->code.'/'.$image->image))
                                                                        <a href="#" onclick="Imgdelete('{{ encrypt($image->id) }}')" class="img-delete">
                                                                            <i class="bi bi-trash text-danger"></i>
                                                                        </a>
                                                                        <img class="ml-2" src="{{ asset('public/images/uploads/item_images/'.$data->code.'/'.$image->image) }}" width="100" height="100">
                                                                    @else
                                                                        <img class="ml-2" src="{{ asset('public/images/default_images/not-found/no_img1.jpg') }}" width="100" height="100">
                                                                    @endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
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

@section('page-js')
    <script type="text/javascript">
        $('#tags').select2({
            placeholder: "-- select tags --"
        });

        function Imgdelete(id) {
            $.ajax({
                url: "{{ route('designs-image.destroy') }}",
                type: 'post',
                dataType: 'JSON',
                data: {
                    "id": id,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(response) {
                    toastr.success(response.message);
                    setTimeout(() => {
                        location.reload();
                    }, 1300);

                }
            });

        }

        $('.gross-weight').on('keyup change',function(){
            var grossWeight = $(this).val();
            var less_gems_stone = $('#less_gems_stone').val();
            var less_cz_stone = $('#less_cz_stone').val();
            var weight_name = $(this).attr('weight-name');
            var amount = 0;

            if(weight_name == '14_gross'){
                amount = grossWeight - less_gems_stone;
                amount = amount - less_cz_stone;
                $('#14_net').val(amount.toFixed(2));
                if(grossWeight == '' || grossWeight == 0){
                    $('#14_net').val('');
                }
            }else if(weight_name == '18_gross'){
                amount = grossWeight - less_gems_stone;
                amount = amount - less_cz_stone;
                $('#18_net').val(amount.toFixed(2));
                if(grossWeight == '' || grossWeight == 0){
                    $('#18_net').val('');
                }
            }else if(weight_name == '20_gross'){
                amount = grossWeight - less_gems_stone;
                amount = amount - less_cz_stone;
                $('#20_net').val(amount.toFixed(2));
                if(grossWeight == '' || grossWeight == 0){
                    $('#20_net').val('');
                }
            }else if(weight_name == '22_gross'){
                amount = grossWeight - less_gems_stone;
                amount = amount - less_cz_stone;
                $('#22_net').val(amount.toFixed(2));
                if(grossWeight == '' || grossWeight == 0){
                    $('#22_net').val('');
                }
            }

        });

        $('.less-weight').on('keyup change', function(){
            var gross_w14 = $('#14_gross').val();
            var gross_w18 = $('#18_gross').val();
            var gross_w20 = $('#20_gross').val();
            var gross_w22 = $('#22_gross').val();
            var less_gems_stone = $('#less_gems_stone').val();
            var less_cz_stone = $('#less_cz_stone').val();

            // 14K
            if(gross_w14 == '' || gross_w14 == 0){
                $('#14_net').val('');
            }else{
                var amount = gross_w14 - less_gems_stone;
                amount = amount - less_cz_stone;
                $('#14_net').val(amount.toFixed(2));
            }

            // 18K
            if(gross_w18 == '' || gross_w18 == 0){
                $('#18_net').val('');
            }else{
                var amount = gross_w18 - less_gems_stone;
                amount = amount - less_cz_stone;
                $('#18_net').val(amount.toFixed(2));
            }

            // 20K
            if(gross_w20 == '' || gross_w20 == 0){
                $('#20_net').val('');
            }else{
                var amount = gross_w20 - less_gems_stone;
                amount = amount - less_cz_stone;
                $('#20_net').val(amount.toFixed(2));
            }

            // 22K
            if(gross_w22 == '' || gross_w22 == 0){
                $('#22_net').val('');
            }else{
                var amount = gross_w22 - less_gems_stone;
                amount = amount - less_cz_stone;
                $('#22_net').val(amount.toFixed(2));
            }
        });
    </script>
@endsection
