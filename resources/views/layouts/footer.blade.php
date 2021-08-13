    <!-- BEGIN: Footer-->
    <footer class="footer footer-static footer-light">
        <p class="clearfix blue-grey lighten-2 mb-0">
            <span class="float-md-left d-block d-md-inline-block mt-25">COPYRIGHT &copy; <?php echo date('Y');?>
            <a class="text-bold-800 grey darken-2" href="/inicio">
            Editorial Barreto,</a>Todos los derechos reservados</span>
            <span class="float-md-right d-none d-md-block">Versión aplicación web: <span class="primary text-bold-700">{{ $get_version }}</span><i class=""></i></span>
            <button class="btn btn-primary btn-icon scroll-top" type="button"><i class="feather icon-arrow-up"></i></button>
        </p>
    </footer>
    <!-- END: Footer-->


    <!-- BEGIN: Vendor JS-->
    <script src="{{asset('js/vendors.min.js')}}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script defer src="{{asset('js/app-menu.min.js')}}"></script>
    <script defer src="{{asset('js/app.min.js')}}"></script>
    <script defer src="{{asset('js/components.min.js')}}"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: librerias JS-->
    <script defer data-pace-options='{ "ajax": false }' src="{{asset('js/pace.min.js')}}"></script>
    <script src="{{asset('js/select2.full.min.js')}}"></script>
    <script src="{{asset('js/datatables.min.js')}}"></script>
    <script src="{{asset('js/jquery.inputmask.min.js')}}"></script>
    <script src="{{asset('js/jquery.steps.min.js')}}"></script>
    <script src="{{asset('js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('js/additional-methods.min.js')}}"></script>
    <script src="{{asset('js/messages_es.js')}}"></script>
    <script src="{{asset('js/datatables.buttons.min.js')}}"></script>
    <script src="{{asset('js/datatables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('js/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('js/date-range-picker/moment.min.js')}}"></script>
    <script src="{{asset('js/date-range-picker/daterangepicker.js')}}"></script>
    <script src="{{asset('js/fileinput.min.js')}}"></script>
    <script src="{{asset('js/fileinput-locale-es.js')}}"></script>
    <script src="{{asset('js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('js/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('js/durationpicker.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

    <!-- END: librerias JS-->

    {{-- FUNCIONES PERSONALIZADAS --}}
    <script src="{{asset('js/functions.js')}}"></script>
    <script src="{{asset('js/grid-base.js')}}"></script>
    <script src="{{asset('js/modules/teleoperadores/wizard-steps.js')}}"></script>
    <script src="{{asset('js/form-select2.js')}}"></script>
    <script src="{{asset('js/ordentrabajo.js')}}"></script>

    

    @yield('custom-js')


</body>

</html>
