<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title><?= $title; ?></title>
    <meta content="" name="description">

    <meta content="" name="keywords">

    <!-- Favicons -->
    <!-- <link href="assets/templates/flexstart/assets/img/favicon.png" rel="icon">
    <link href="assets/templates/flexstart/assets/img/apple-touch-icon.png" rel="apple-touch-icon"> -->

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/templates/flexstart/assets/plugins/aos/aos.css" rel="stylesheet">
    <link href="assets/templates/flexstart/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/templates/flexstart/assets/plugins/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/templates/flexstart/assets/plugins/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/templates/flexstart/assets/plugins/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/templates/flexstart/assets/plugins/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/templates/flexstart/assets/css/style.css" rel="stylesheet">

</head>

<body>

    <!-- ======= Header ======= -->
    <?= $this->renderSection('header') ?>
    <!-- End Header -->

    <!-- ======= Content ======= -->
    <?= $this->renderSection('content') ?>
    <!-- ======= End Content ======= -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="container">
            <div class="copyright">
                &copy; Copyright 2022. All Rights Reserved
            </div>
            <div class="social-links mt-3 text-center">
                <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
            </div>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/templates/flexstart/assets/plugins/purecounter/purecounter.js"></script>
    <script src="assets/templates/flexstart/assets/plugins/aos/aos.js"></script>
    <script src="assets/templates/flexstart/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/templates/flexstart/assets/plugins/glightbox/js/glightbox.min.js"></script>
    <script src="assets/templates/flexstart/assets/plugins/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/templates/flexstart/assets/plugins/swiper/swiper-bundle.min.js"></script>
    <script src="assets/templates/flexstart/assets/plugins/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/templates/flexstart/assets/js/main.js"></script>

</body>

</html>