@extends('admin.layouts.admin-layout')

@section('title', 'Import/Export')

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>Import/Export</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item active">Import/Export</li>
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
                    <form class="form" action="{{ route('import.data') }}" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            @csrf
                            <div class="form_box">
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>Import/Export Information</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <div class="row align-items-end">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="import" class="form-label">Import Data<span
                                                            class="text-danger">*</span></label>
                                                    <input type="file" name="import" id="import"
                                                        class="form-control {{ $errors->has('import') ? 'is-invalid' : '' }}">
                                                    @if ($errors->has('import'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('import') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-grop">
                                                    <a href="{{asset('public/images/uploads/excel_file/ExcelDemo.xlsx')}}" class="form-control btn form_button" target="_blank">Demo Excel File Format</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <button class="btn form_button">Upload</button>
                        </div>
                    </form>
                    <form action="{{ route('export.data') }}" class="form" method="post">
                        @csrf
                        <div class="card-footer text-center">

                            <button class="btn form_button">Export</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('page-js')
    <script type="text/javascript">
        $(function() {

            // Toastr Options
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "timeOut": 10000
            }

            @if (Session::has('success'))
                toastr.success('{{ Session::get('success') }}')
            @endif

        });
    </script>
@endsection
