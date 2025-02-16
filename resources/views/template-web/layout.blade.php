<!doctype html>
<html lang="en">

<head>
	<!--favicon-->
	<link rel="icon" href="{{ asset('web') }}/images/logo.png" type="image/png"/>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">

    <title>No Limits Gym</title>

    <!-- CSS FILES -->
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400&family=Sono:wght@200;300;400;500;700&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('web') }}/css/bootstrap.min.css">

    <link rel="stylesheet" href="{{ asset('web') }}/css/bootstrap-icons.css">

    <link rel="stylesheet" href="{{ asset('web') }}/css/owl.carousel.min.css">

    <link rel="stylesheet" href="{{ asset('web') }}/css/owl.theme.default.min.css">

    <link href="{{ asset('web') }}/css/templatemo-pod-talk.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/boxicons/css/boxicons.min.css" rel="stylesheet">
    <!--

TemplateMo 584 Pod Talk

https://templatemo.com/tm-584-pod-talk

-->
</head>

<body>

    <main>

      
        @include('template-web.navbar')



       @yield('content')
    </main>

    @include('sweetalert::alert')

    @include('template-web.footer')

    <!-- JAVASCRIPT FILES -->
    <script src="{{ asset('web') }}/js/jquery.min.js"></script>
    <script src="{{ asset('web') }}/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('web') }}/js/owl.carousel.min.js"></script>
    <script src="{{ asset('web') }}/js/custom.js"></script>
    @yield('script')
</body>

</html>