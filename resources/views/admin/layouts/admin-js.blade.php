<!-- Vendor JS Files -->
<script src="{{ asset('public/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('public/assets/js/jquery.min.js') }}"></script>
<script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('public/assets/js/sweet-alert.js') }}"></script>
<script src="{{ asset('public/assets/vendor/toastr/js/toastr.min.js') }}"></script>
<script src="{{ asset('public/assets/js/main.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/super-build/ckeditor.js"></script>

@php
    $route = Route::current()->getName();
@endphp

{{-- Common Script --}}
<script type="text/javascript">

    //Initialize Select2 Elements
    $('.select2bs4').select2({
    theme: 'bootstrap5'
    })

    // Toastr Msg Settings
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        timeOut: 4000
    }

    @if(Session::has('message'))
        toastr.success("{{ session('message') }}");
    @endif

    @if(Session::has('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if(Session::has('error'))
        toastr.error("{{ session('error') }}");
    @endif

    @if($route == 'designs.create' || $route == 'designs.edit' || $route == 'dealers.create' || $route == 'dealers.edit' || $route == 'sliders.add-slider' || $route == 'sliders.edit-slider' || $route == 'categories.add' || $route == 'categories.edit' || $route == 'users.create' || $route == 'users.edit' || $route == 'roles.create' || $route == 'roles.edit' || $route == 'westage.discount.create' || $route == 'westage.discount.edit')
        $('body').addClass('toggle-sidebar');
    @endif

</script>
