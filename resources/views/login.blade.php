<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Male_Fashion Template">
    <meta name="keywords" content="Male_Fashion, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ladybird store</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>

<body>
    <section class="contact spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 mx-auto">
                    <div class="section-title">
                        <h2>Login</h2>
                    </div>
                    <div class="contact__form">
                        @if (session()->has('success'))
                            <div class="alert alert-success">
                                <p>{{ session()->get('success') }}</p>
                            </div>
                        @endif
                        @if (session()->has('error'))
                            <div class="alert alert-danger">
                                <p>{{ session()->get('error') }}</p>
                            </div>
                        @endif
                        <form action="{{ URL::to('/loginUser') }}" method="POST">
                            @csrf
                            <!-- <p>Cross-Site Request Forgery token.
                                This token helps ensure that the form submission is coming
                                 from the authenticated user and not from a malicious site.</p> -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <input type="email" name="email" placeholder="Email">
                                </div>
                                <div class="col-lg-12">
                                    <input type="password" name="password" placeholder="Password">
                                </div>
                                <div class="col-lg-12">
                                    <button type="submit" name="login" class="site-btn">Sign in</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="section-title">
                        <p>
                            <a href="{{ URL::to('/register') }}" class="btn btn-primary">Register</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
