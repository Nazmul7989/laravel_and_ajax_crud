
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="description" content="">
    <meta name="author" content="Nazmul">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="#">

    <title>Writing Test</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('admin/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/bootstrap-reset.css') }}" rel="stylesheet">
    <!--external css-->
    <link href="{{ asset('admin/assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css') }}" rel="stylesheet" type="text/css" media="screen"/>
    <link rel="stylesheet" href="{{ asset('admin/css/owl.carousel.css') }}" type="text/css">

    <!--right slidebar-->
    <link href="{{ asset('admin/css/slidebars.css') }}" rel="stylesheet">


    <!--  summernote -->
    <link href="{{ asset('admin/assets/summernote/dist/summernote.css') }}" rel="stylesheet">

    <!--  datatable -->
    <link href="{{ asset('css/dataTables.min.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->

    <link href="{{ asset('admin/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/style-responsive.css') }}" rel="stylesheet" />



</head>

<body>

<section id="container">
    @include('admin.partials.header')
    @include('admin.partials.sidebar')


    <!--main content start-->
        <section id="main-content">
            <section class="wrapper">

                @yield('content')

            </section>
        </section>
        <!--main content end-->



    @include('admin.partials.footer')


</section>

<!-- js placed at the end of the document so the pages load faster -->
<script src="{{ asset('admin/js/jquery.js') }} "></script>
<script src="{{ asset('admin/js/bootstrap.bundle.min.js') }}"></script>
<script class="include" type="text/javascript" src="{{ asset('admin/js/jquery.dcjqaccordion.2.7.js') }}"></script>
<script src="{{ asset('admin/js/jquery.scrollTo.min.js') }}"></script>
<script src="{{ asset('admin/js/jquery.nicescroll.js') }}" type="text/javascript"></script>
<script src="{{ asset('admin/js/owl.carousel.js') }}"></script>
<script src="{{ asset('admin/js/jquery.customSelect.min.js') }}" ></script>
<script src="{{ asset('admin/js/respond.min.js') }}" ></script>

<!--right slidebar-->
<script src="{{ asset('admin/js/slidebars.min.js') }}"></script>

<!--common script for all pages-->
<script src="{{ asset('admin/js/common-scripts5e1f.js?v=2') }}"></script>


<!--datatable-->
<script src="{{ asset('js/dataTables.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#data').DataTable();
    });
</script>

<!--summernote-->
<script src="{{ asset('admin/assets/summernote/dist/summernote.min.js') }}"></script>
<script>

    jQuery(document).ready(function(){

        $('.summernote').summernote({
            height: 200,                 // set editor height

            minHeight: null,             // set minimum height of editor
            maxHeight: null,             // set maximum height of editor

            focus: true                 // set focus to editable area after initializing summernote
        });
    });

</script>

{{--delete confirmation by using sweet alert--}}
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


{{--image select--}}
<script>
    $(document).ready(function (){
        $('#thumbnail').change(function (e){
            var reader = new FileReader();
            reader.onload = function (e){
                $('#showImage').attr('src',e.target.result);
            }

            reader.readAsDataURL(e.target.files['0'])
        })

    })
</script>



@stack('script');

</body>
</html>
