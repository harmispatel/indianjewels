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
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Import/Export</li>
                </ol>
            </nav>
        </div>
        <div class="col-md-4" style="text-align: right;">
            
        </div>
    </div>
</div>

@endsection