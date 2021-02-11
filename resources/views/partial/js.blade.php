 <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{asset('assets/libs/popper.js/dist/umd/popper.min.js')}}"></script>
    <script src="{{asset('assets/libs/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <!-- apps -->
    <script src="{{asset('dist/js/app.min.js')}}"></script>
    <script src="{{asset('dist/js/app.init.js')}}"></script>
    <script src="{{asset('dist/js/app-style-switcher.js')}}"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{asset('assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js')}}"></script>
    <script src="{{asset('assets/extra-libs/sparkline/sparkline.js')}}"></script>
    <!--Wave Effects -->
    <script src="{{asset('dist/js/waves.js')}}"></script>
    <!--Menu sidebar -->
    <script src="{{asset('dist/js/sidebarmenu.js')}}"></script>
    <!--Custom JavaScript -->
    <script src="{{asset('dist/js/custom.min.js')}}"></script>
    <!-- This Page JS -->
    <script src="{{asset('assets/extra-libs/c3/d3.min.js')}}"></script>
    <script src="{{asset('assets/extra-libs/c3/c3.min.js')}}"></script>
    <script src="{{asset('assets/libs/raphael/raphael.min.js')}}"></script>
    <script src="{{asset('assets/libs/morris.js/morris.min.js')}}"></script>
    <script src="{{asset('assets/libs/moment/min/moment.min.js')}}"></script>
    <script src="{{asset('assets/libs/fullcalendar/dist/fullcalendar.min.js')}}"></script>
    <script src="{{asset('dist/js/pages/calendar/cal-init.js')}}"></script>



    <script type="text/javascript">
        $('[data-toggle="tooltip"]').tooltip();
        $('#calendar').fullCalendar('option', 'height', 650);


        $( document ).ajaxError(function( event, jqxhr, settings, thrownError ) {


            if (jqxhr.status == 401) 
            {
                alert("Session expired. You'll be take to the login page");
                location.href = "{{ config('app.url')}}"; 
            }
            else if(jqxhr.status == 403)
            {
                alert("Sorry, You're not allowed to visit requested page. Taking you to Dashboard Page.");
                location.href = "{{ config('app.url')}}";
            }
            else
            {
                alert("Something Went Wrong");
            }
    

    });
    </script>