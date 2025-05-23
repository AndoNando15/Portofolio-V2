<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Meta -->
    <meta name="description" content="Responsive Bootstrap4 Dashboard Template">
    <meta name="author" content="ParkerThemes">
    <link rel="shortcut icon" href="img/fav.png">

    <!-- Title -->
    <title>Le Rouge Admin Template - 404</title>


    <!-- Font for coming soon page -->
    <link href="../../css-1?family=Erica+One&display=swap" rel="stylesheet">

    <!-- *************
   ************ Common Css Files *************
  ************ -->
    <!-- Bootstrap css -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Icomoon Font Icons css -->
    <link rel="stylesheet" href="fonts/style.css">
    <!-- Main css -->
    <link rel="stylesheet" href="css/main.css">

    <!-- *************
   ************ Vendor Css Files *************
  ************ -->
    <!-- Particles CSS -->
    <link rel="stylesheet" href="vendor/particles/particles.css">

</head>

<body class="authentication">

    <div id="particles-js"></div>
    <div class="countdown-bg"></div>

    <div class="error-screen">
        @foreach ($errors as $error)
            <h1>{!! $error->keterangan !!}</h1>
        @endforeach

        <a href="/error" class="btn btn-primary">Go back to Dashboard</a>
    </div>


    <!--**************************
   **************************
    **************************
       Required JavaScript Files
    **************************
   **************************
  **************************-->
    <!-- Required jQuery first, then Bootstrap Bundle JS -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/moment.js"></script>

    <!-- *************
   ************ Vendor Js Files *************
  ************* -->
    <!-- Particles JS -->
    <script src="vendor/particles/particles.min.js"></script>
    <script src="vendor/particles/particles-custom-error.js"></script>

</body>

</html>
