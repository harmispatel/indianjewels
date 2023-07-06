@extends('admin.layouts.admin-layout')

@section('title', 'Dashboard')

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    {{-- Dashboard Section --}}
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <h1>Dashboard</h1>
            </div>
        </div>
    </section>

@endsection

{{-- Custom JS --}}
@section('page-js')

    <script type="text/javascript">

        @if (Session::has('success'))
            toastr.success('{{ Session::get('success') }}')
        @endif

        // @if (Session::has('error'))
        //     toastr.error('{{ Session::get('error') }}')
        // @endif

    </script>

@endsection
