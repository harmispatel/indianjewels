 <!-- Vendor JS Files -->
 <script src="{{ asset('public/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
 
 
 
 
 {{-- Jquery --}}
 <script src="{{ asset('public/assets/js/jquery.min.js') }}"></script>
 
 <script src="{{ asset('public/assets/vendor/simple-datatables/simple-datatables.js') }}"></script>

{{-- Sweet Alert --}}
<script src="{{ asset('public/assets/js/sweet-alert.js') }}"></script>

{{-- Toastr --}}
<script src="{{ asset('public/assets/vendor/toastr/js/toastr.min.js') }}"></script>

<!-- Template Main JS File -->
<script src="{{ asset('public/assets/js/main.js') }}"></script>


{{-- Common Script --}}
<script type="text/javascript">

    // Toastr Msg Settings
    toastr.options =
    {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        timeOut: 4000
    }


    @if(Session::has('message'))
  toastr.options =
  {
  	"closeButton" : true,
  	"progressBar" : true
  }
  		toastr.success("{{ session('message') }}");
  @endif

  @if(Session::has('error'))
  toastr.options =
  {
  	"closeButton" : true,
  	"progressBar" : true
  }
  		toastr.error("{{ session('error') }}");
  @endif   

</script>
