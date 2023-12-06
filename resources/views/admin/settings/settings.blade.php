@extends('admin.layouts.admin-layout')

@section('title', 'IMPEL | Settings')

@section('content')

{{-- Page Title --}}
<div class="pagetitle">
    <h1>Settings</h1>
    <div class="row">
        <div class="col-md-8">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item active">Settings</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

{{-- Settings Form Section --}}
<section class="section dashboard">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form class="form" action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                    <div class="card-body">
                        @csrf
                        <div class="form_box">
                            <div class="form_box_inr">
                                <div class="box_title">
                                    <h2>Google Sheet Settings</h2>
                                </div>
                                <div class="form_box_info">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <div class="form-group">
                                                <label for="sheets_names" class="form-label">Sheets Names</label>
                                                <input type="text" name="settings[sheets_names]" id="sheets_names" class="form-control" placeholder="Enter Google Sheets Names" value="{{ (isset($settings['sheets_names'])) ? $settings['sheets_names'] : '' }}">
                                                <code>Note : Enter Your Google Sheets Name Like (Sheet1,Sheet2,Sheet3,...)</code>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="spread_sheet_id" class="form-label">Spread Sheet ID</label>
                                                <input type="text" name="settings[spread_sheet_id]" id="spread_sheet_id" class="form-control" placeholder="Enter Google Spread Sheet ID" value="{{ (isset($settings['spread_sheet_id'])) ? $settings['spread_sheet_id'] : '' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="developer_key" class="form-label">Developer Key</label>
                                                <input type="text" name="settings[developer_key]" id="developer_key" class="form-control" placeholder="Enter Developer Key" value="{{ (isset($settings['developer_key'])) ? $settings['developer_key'] : '' }}">
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

@section('page-js')
<script type="text/javascript">

    @if (Session::has('success'))
        toastr.success('{{ Session::get('success') }}')
    @endif

</script>
@endsection
