<?= $this->extend('layout/user/user_layout') ?>
<?= $this->section('header') ?>
<!-- ======= Header ======= -->
<header id="header" class="header fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

        <a href="index.php" class="logo d-flex align-items-center">
            <img src="assets/templates/flexstart/assets/img/logo.svg" alt="">
            <span>Rewaste World</span>
        </a>

        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
                <li><a class="nav-link scrollto" href="#about">Tentang</a></li>
                <li><a class="nav-link scrollto" href="#features">Visi & Misi</a></li>
                <li><a class="nav-link scrollto" href="#faq">Pertanyaan</a></li>
                <li><a class="nav-link scrollto" href="#contact">Kontak Kami</a></li>
                <li><a class="getstarted scrollto" href="/user" target="_blank">Login</a></li>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->

    </div>
</header><!-- End Header -->

<!-- ======= Hero Section ======= -->
<section id="hero" class="hero d-flex align-items-center">

    <div class="container">
        <div class="row">
            <div class="col-lg-6 d-flex flex-column justify-content-center">
                <h1 data-aos="fade-up">Jagalah Kebersihan!</h1>
                <h2 data-aos="fade-up" data-aos-delay="400">
                    Kirim Limbah/Sampah yang ada dirumah, kami tukar dengan uang.
                </h2>
                <div data-aos="fade-up" data-aos-delay="600">
                    <div class="text-center text-lg-start">
                        <a href="user/register" target="_blank" class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                            <span>Daftar Sekarang</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 hero-img" data-aos="zoom-out" data-aos-delay="200">
                <img src="assets/templates/flexstart/assets/img/hero-img1.svg" class="img-fluid" alt="">
            </div>
        </div>
    </div>

</section><!-- End Hero -->
<!-- End Header -->
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Start main content -->
<main id="main">
    <!-- ======= About Section ======= -->
    <section id="about" class="about">

        <div class="container" data-aos="fade-up">
            <div class="row gx-0">

                <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="content">
                        <h3>Tentang Kami</h3>
                        <h2>Deskripsi singkat tentang kami</h2>
                        <p>
                            Rewaste World merupakan perusahaan yang menyediakan solusi pengolahan sampah dengan melakukan penyaluran limbah ke perusahaan pengolah limbah untuk mengurangi limbah yang ada dimasyarakat dan juga menjaga kelestarian lingkungan di Indonesia.
                        </p>
                    </div>
                </div>

                <div class="col-lg-6 d-flex align-items-center" data-aos="zoom-out" data-aos-delay="200">
                    <img src="assets/templates/flexstart/assets/img/about.png" class="img-fluid" alt="">
                </div>

            </div>
        </div>

    </section><!-- End About Section -->

    <!-- ======= Features Section ======= -->
    <section id="features" class="features">

        <div class="container" data-aos="fade-up">

            <header class="section-header">
                <h2>Visi & Misi</h2>
                <p>Berikut Visi dan Misi kami</p>
            </header>

            <!-- Feature Tabs -->
            <div class="row feture-tabs" style="margin-top: -20px;" data-aos="fade-up">
                <div class="col-lg-12">
                    <!-- Tabs -->
                    <ul class="nav nav-pills mb-3">
                        <li>
                            <a class="nav-link active" data-bs-toggle="pill" href="#tab1">Visi</a>
                        </li>
                        <li>
                            <a class="nav-link" data-bs-toggle="pill" href="#tab2">Misi</a>
                        </li>
                    </ul><!-- End Tabs -->

                    <!-- Tab Content -->
                    <div class="tab-content">

                        <div class="tab-pane fade show active" id="tab1">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-check2"></i>
                                <h4>Berkontribusi Dalam Mengurangi Limbah Yang Masih Dapat Didaur Ulang Sehingga Dapat Menjaga Kelestarian Lingkungan</h4>
                            </div>
                        </div><!-- End Tab 1 Content -->

                        <div class="tab-pane fade show" id="tab2">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-check2"></i>
                                <h4>Berkontribusi Signifikan Dalam Mengurangi Polusi Limbah Nasional Dan Menciptakan Lingkungan Hidup Yang Ideal Dan Berkelanjutan</h4>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-check2"></i>
                                <h4>Meningkatkan Tingkat Daur Ulang Sampah Organik Dan Anorganik Di Indonesia</h4>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-check2"></i>
                                <h4>Membantu Menyalurkan Limbah Yang Dapat Didaur Ulang Kepada Perusahaan Pengolah Limbah</h4>
                            </div>
                        </div><!-- End Tab 2 Content -->

                    </div>

                </div>

            </div><!-- End Feature Tabs -->

        </div>

    </section><!-- End Features Section -->

    <!-- ======= F.A.Q Section ======= -->
    <section id="faq" class="faq">

        <div class="container" data-aos="fade-up">

            <header class="section-header">
                <h2>F.A.Q</h2>
                <p>Frequently Asked Questions</p>
            </header>

            <div class="row">
                <div class="col-lg-6">
                    <!-- F.A.Q List 1-->
                    <div class="accordion accordion-flush" id="faqlist1">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-content-1">
                                    Non consectetur a erat nam at lectus urna duis?
                                </button>
                            </h2>
                            <div id="faq-content-1" class="accordion-collapse collapse" data-bs-parent="#faqlist1">
                                <div class="accordion-body">
                                    Feugiat pretium nibh ipsum consequat. Tempus iaculis urna id volutpat lacus
                                    laoreet non curabitur
                                    gravida. Venenatis lectus magna fringilla urna porttitor rhoncus dolor purus
                                    non.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-content-2">
                                    Feugiat scelerisque varius morbi enim nunc faucibus a pellentesque?
                                </button>
                            </h2>
                            <div id="faq-content-2" class="accordion-collapse collapse" data-bs-parent="#faqlist1">
                                <div class="accordion-body">
                                    Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id
                                    interdum velit laoreet id
                                    donec ultrices. Fringilla phasellus faucibus scelerisque eleifend donec pretium.
                                    Est pellentesque
                                    elit ullamcorper dignissim. Mauris ultrices eros in cursus turpis massa
                                    tincidunt dui.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-content-3">
                                    Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi?
                                </button>
                            </h2>
                            <div id="faq-content-3" class="accordion-collapse collapse" data-bs-parent="#faqlist1">
                                <div class="accordion-body">
                                    Eleifend mi in nulla posuere sollicitudin aliquam ultrices sagittis orci.
                                    Faucibus pulvinar
                                    elementum integer enim. Sem nulla pharetra diam sit amet nisl suscipit. Rutrum
                                    tellus pellentesque
                                    eu tincidunt. Lectus urna duis convallis convallis tellus. Urna molestie at
                                    elementum eu facilisis
                                    sed odio morbi quis
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-lg-6">

                    <!-- F.A.Q List 2-->
                    <div class="accordion accordion-flush" id="faqlist2">

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2-content-1">
                                    Ac odio tempor orci dapibus. Aliquam eleifend mi in nulla?
                                </button>
                            </h2>
                            <div id="faq2-content-1" class="accordion-collapse collapse" data-bs-parent="#faqlist2">
                                <div class="accordion-body">
                                    Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id
                                    interdum velit laoreet id
                                    donec ultrices. Fringilla phasellus faucibus scelerisque eleifend donec pretium.
                                    Est pellentesque
                                    elit ullamcorper dignissim. Mauris ultrices eros in cursus turpis massa
                                    tincidunt dui.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2-content-2">
                                    Tempus quam pellentesque nec nam aliquam sem et tortor consequat?
                                </button>
                            </h2>
                            <div id="faq2-content-2" class="accordion-collapse collapse" data-bs-parent="#faqlist2">
                                <div class="accordion-body">
                                    Molestie a iaculis at erat pellentesque adipiscing commodo. Dignissim
                                    suspendisse in est ante in.
                                    Nunc vel risus commodo viverra maecenas accumsan. Sit amet nisl suscipit
                                    adipiscing bibendum est.
                                    Purus gravida quis blandit turpis cursus in
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2-content-3">
                                    Varius vel pharetra vel turpis nunc eget lorem dolor?
                                </button>
                            </h2>
                            <div id="faq2-content-3" class="accordion-collapse collapse" data-bs-parent="#faqlist2">
                                <div class="accordion-body">
                                    Laoreet sit amet cursus sit amet dictum sit amet justo. Mauris vitae ultricies
                                    leo integer malesuada
                                    nunc vel. Tincidunt eget nullam non nisi est sit amet. Turpis nunc eget lorem
                                    dolor sed. Ut
                                    venenatis tellus in metus vulputate eu scelerisque. Pellentesque diam volutpat
                                    commodo sed egestas
                                    egestas fringilla phasellus faucibus. Nibh tellus molestie nunc non blandit
                                    massa enim nec.
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </section><!-- End F.A.Q Section -->

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">

        <div class="container" data-aos="fade-up">

            <header class="section-header">
                <h2>Kontak</h2>
                <p>Hubungi Kami</p>
            </header>

            <div class="row gy-4">

                <div class="col-lg-12">

                    <div class="row gy-4">
                        <div class="col-md-6">
                            <div class="info-box">
                                <i class="bi bi-geo-alt"></i>
                                <h3>Alamat</h3>
                                <p>Jl. Benda No.25 KM 12.5 Pangkalan 2,<br>Banter Gebang Bekasi Jawa barat</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <i class="bi bi-telephone"></i>
                                <h3>Telepon</h3>
                                <p>+6285123456789<br>0219238231</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <i class="bi bi-envelope"></i>
                                <h3>Email</h3>
                                <p>RewasteWorld@gmail.com</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <i class="bi bi-clock"></i>
                                <h3>Jam Buka</h3>
                                <p>Senin - Jumat<br>08.00 - 16.00</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section><!-- End Contact Section -->

</main><!-- End #main -->
<!-- End main content -->
<?= $this->endSection() ?>