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


<!-- Select 2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>


{{-- Common Script --}}
<script type="text/javascript">
//Initialize Select2 Elements


//Initialize Select2 Elements
$('.select2bs4').select2({
  theme: 'bootstrap5'
})
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
