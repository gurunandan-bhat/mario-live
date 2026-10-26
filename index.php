<?php
include "config/config.php";
include "config/MarioDB.php";
include "config/api.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST")
    if (isset($_POST['search'])   && $_POST['search'] != '') {
        header("location:" . SITE_ADDRESS . "search/" . $_POST['search']);
        // echo "<script type=\"text/javascript\">
        //             window.location.href = ".SITE_ADDRESS."search/".$_POST['search'].";
        //       </script>";
    }

$cart_total = 0;
if (isset($_SESSION["cart"]))
    $cart_total    = (isset($_SESSION['cart'])) ? sizeof($_SESSION['cart']) : 0;

$marioDB            = new MarioDB;
$menuCategories     = $marioDB->menuCategories();
$homepageSections   = $marioDB->homepageSections();
$showcaseProducts   = $marioDB->showcaseProducts();
$weeklyCartoons     = $marioDB->weeklyCartoons();
$testimonials       = $marioDB->testimonials();
?>
<!DOCTYPE html>
<html lang="zxx">

<head>
    <!-- Meta Tag -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name='copyright' content=''>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="google-site-verification" content="11o8VjSLGIffF_ELH5I0E8SWwr3e8zJaub9gn0Oeg08" />
<!-- Title Tag  -->
    <title>Buy Mario de Miranda's works | Mario Gallery and Shop | Premium Art Gifts</title>
    <META name="description" content="Mario Gallery which is dedicated to the work of Legendary Artist Mario de Miranda.Buy indian art online." />
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Organization",
            "name": "Mario de Miranda",
            "alternateName": "Mario Gallery",
            "url": "https://www.mariodemiranda.com/",
            "logo": "https://www.mariodemiranda.com/assets2/images/main-logo.png",
            "contactPoint": {
                "@type": "ContactPoint",
                "telephone": "",
                "contactType": ""
            },
            "sameAs": [
                "https://www.facebook.com/MarioGallery",
                "https://www.instagram.com/world_of_mario/"
            ]
        }
    </script>
    <script type="application/ld+json">
        {
            "@context": "https://schema.org/",
            "@type": "Person",
            "name": "Mario de Miranda",
            "url": "https://mariodemiranda.com/about-mario",
            "image": "https://mariodemiranda.com/images/mario-mascot.png",
            "sameAs": [
                "https://www.facebook.com/MarioGallery",
                "https://en.wikipedia.org/wiki/Mario_Miranda",
                "https://www.instagram.com/world_of_mario/",
                "https://www.youtube.com/watch?v=ZYm9DiIsXyQ"
            ],
            "jobTitle": "Indian cartoonist",
            "worksFor": {
                "@type": "Organization",
                "name": "Mario Gallery"
            }
        }
    </script>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="images/favicon.png">
    <!-- Web Font -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">

    <!-- StyleSheet -->

    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="css/magnific-popup.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="css/font-awesome.css">
    <!-- Fancybox -->
    <link rel="stylesheet" href="css/jquery.fancybox.min.css">
    <!-- Themify Icons -->
    <link rel="stylesheet" href="css/themify-icons.css">
    <!-- Nice Select CSS -->
    <link rel="stylesheet" href="css/nice-select.css">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="css/animate.css">
    <!-- Flex Slider CSS -->
    <link rel="stylesheet" href="css/flex-slider.min.css">
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="css/owl-carousel.css">
    <!-- Slicknav -->
    <link rel="stylesheet" href="css/slicknav.min.css">

    <!-- Eshop StyleSheet -->
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/responsive.css">

    <!-- Color CSS -->
    <link rel="stylesheet" href="css/color/color1.css">
    <link rel="stylesheet" href="#" id="colors">

</head>
<style>
    @media (max-width: 766px) {
        .header-inner {
            overflow-x: scroll !important;
            display: flex !important;
        }

        .category-img {
            width: 50px !important;
            height: 50px;
        }

        .menu-area {
            display: flex !important;
        }

        .category-menu {
            display: flex !important;
            visibility: visible !important;
        }

        .home-cat-item {
            text-align: center;
            padding-top: 10px !important;
            padding-left: 20px !important;
            width: 90px !important;
        }
    }
</style>

<body class="js">

    <!-- Preloader -->
    <!-- <div class="preloader">
             <div class="preloader-inner">
             <div class="preloader-icon">
             <span></span>
             <span></span>
             </div>
             </div>
             </div> -->
    <!-- End Preloader -->

    <!-- Header -->
    <header class="header shop v3">
        <div class="middle-inner">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-12">
                        <!-- Logo -->
                        <div class="logo">
                            <a href="index"><img src="images/logo.png" alt="logo"></a>
                        </div>
                        <!--/ End Logo -->
                        <!-- Search Form -->
                        <div class="search-top">
                            <div class="top-search"><a href="#0"><i class="ti-search"></i></a></div>
                            <!-- Search Form -->
                            <div class="search-top">
                                <form class="search-form" method="POST">
                                    <input type="text" id="filler-bar" placeholder="Search Products" name="search">
                                    <button value="search" type="submit"><i class="ti-search"></i></button>
                                    <div id="filler-result"></div>
                                </form>
                            </div>
                            <!--/ End Search Form -->
                        </div>
                        <!--/ End Search Form -->
                        <div class="mobile-nav"></div>
                    </div>
                    <div class="col-lg-6 offset-lg-1 col-md-7 col-12">
                        <div class="search-bar-top">
                            <div class="search-bar">
                                <form method="POST">
                                    <input name="search" id="filler-bar" placeholder="Search Products" type="search">
                                    <button class="btnn"><i class="ti-search"></i></button>
                                    <div id="filler-result"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-12">
                        <div class="right-bar">
                            <!-- Search Form -->
                            <div class="sinlge-bar">
                                <a href="wishlist" class="single-icon"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
                            </div>
                            <div class="sinlge-bar">
                                <a href="profile" class="single-icon"><i class="fa fa-user-circle-o" aria-hidden="true"></i></a>
                            </div>
                            <div class="sinlge-bar shopping">
                                <a href="cart" class="single-icon"><i class="ti-bag"></i> <span class="total-count"><?php echo $cart_total; ?></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header Inner -->
        <div class="header-inner">
            <div class="container-fluid">
                <div class="cat-nav-head">
                    <div class="row">
                        <div class="col-12">
                            <div class="menu-area">
                                <!--/ Start Main Menu -->
                                <div class="row">
                                    <div class="category-menu">
                                        <?php
                                        foreach ($menuCategories as $category) {
                                        ?>
                                            <div class="home-cat-item">

                                                <a href="<?= $category['vUrlName']; ?>">
                                                    <img style="border-radius: 50%;" src="uploads/prodcat/<?= $category['vMenuImage']; ?>" class="category-img" alt="<?= $category['vUrlName']; ?>">
                                                </a>
                                                <br>
                                                <center><span><?= ucwords($category['vName']); ?></span></center>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <!--/ End Main Menu -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ End Header Inner -->
        <div class="text-center">
            <img src="/uploads/free_banner.jpg" alt="Free Shipping" />
        </div>
    </header>
    <!--/ End Header -->

    <!-- Start Area 2 -->
    <section class="hero-area4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <a href="/ai"><img src="uploads/new-feature/new.png" class="img-responsive w-100 img-fluid" /></a>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Hero Area 2 -->

    <?php
    foreach ($homepageSections as $section) {

        $sectionProducts = $section['aProducts'];
        if ($section['iHPSecID'] != 3) {
    ?>
            <!-- Start Most Popular -->
            <div class="product-area most-popular section">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="section-title">
                                <h2><?= $section['hpsName']; ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="owl-carousel popular-slider">
                                <?php
                                foreach ($sectionProducts as $product) {
                                ?>
                                    <!-- Start Single Product -->
                                    <div class="single-product">
                                        <div class="product-img">
                                            <a href="<?= SITE_ADDRESS ?>product/<?= $product['vUrlName']; ?>">
                                                <img class="default-img" src="uploads/products/sml_<?= $product['vSmallImage']; ?>" alt="<?= $product['vSmallImage_AltTag']; ?>" style="width:100%; height:auto; border:none;">
                                                <img class="hover-img" src="uploads/products/sml_<?= $product['vSmallImage']; ?>" alt="<?= $product['vSmallImage_AltTag']; ?>" style="width:100%; height:auto; border:none;">
                                            </a>
                                        </div>
                                        <div class="product-content">
                                            <h3>
                                                <a href="<?= SITE_ADDRESS; ?>product/<?= $product['vUrlName']; ?>">
                                                    <?= $product['pName']; ?>
                                                </a>
                                            </h3>
                                            <div class="product-price">
                                                <?php if ($product['fOPrice'] > 0) { ?>
                                                    <span class="old" style="font-family:Arial, Helvetica, sans-serif;">
                                                        &#8377;<?= $product['fPrice']; ?>
                                                    </span>
                                                    <span style="font-family:Arial, Helvetica, sans-serif;font-weight:600;">
                                                        <b>&#8377;</b><?= $product['fOPrice']; ?>
                                                    </span>
                                                <?php } else { ?>
                                                    <span style="font-family:Arial, Helvetica, sans-serif;font-weight:600;">
                                                        <b>&#8377;</b><?= $product['fPrice']; ?>
                                                    </span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Single Product -->
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Most Popular Area -->
        <?php } else { ?>
            <section class="product-area most-popular section">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="section-title">
                                <h2><?= $section['hpsName']; ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <?php
                        foreach ($sectionProducts as $product) { ?>
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="shop-single-blog single-product">
                                    <a href="<?= SITE_ADDRESS; ?>product/<?= $product['vUrlName']; ?>">
                                        <img class="default-img" src="<?= SITE_ADDRESS; ?>uploads/products/sml_<?= $product['vSmallImage']; ?>" alt="<?= $product['vSmallImage_AltTag']; ?>" style="width:100%; height:auto; border:none;">
                                    </a>
                                    <div class="content product-content">
                                        <h3>
                                            <a href="<?= SITE_ADDRESS; ?>product/<?= $product['vUrlName']; ?>">
                                                <?= $product['pName']; ?>
                                            </a>
                                        </h3>
                                        <div class="product-price">
                                            <?php if ($product['fOPrice'] > 0) { ?>
                                                <span class="old" style="font-family:Arial, Helvetica, sans-serif;">
                                                    &#8377;<?= $product['fPrice']; ?>
                                                </span>
                                                <span style="font-family:Arial, Helvetica, sans-serif;font-weight:600;">
                                                    <b>&#8377;</b><?= $product['fOPrice']; ?>
                                                </span>
                                            <?php } else { ?>
                                                <span style="font-family:Arial, Helvetica, sans-serif;font-weight:600;">
                                                    <b>&#8377;</b><?= $product['fPrice']; ?>
                                                </span>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </section>
    <?php
        }
    } ?>

    <?php if (sizeof($weeklyCartoons) > 0) { ?>
        <!-- Start Cowndown Area -->
        <section class="cown-down">
            <div class="section-inner ">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="section-title">
                                <h2></h2>
                            </div>
                        </div>
                        <?php if (sizeof($weeklyCartoons) != 1) { ?>
                            <div class="col-lg-6 col-12 padding-right">
                                <div class="owl-carousel cartoon-slider">
                                    <?php foreach ($weeklyCartoons as $cartoon) { ?>
                                        <div class="item">
                                            <div class="image">
                                                <img src="<?= SITE_ADDRESS ?>uploads/cartoon/<?= $cartoon['vPic']; ?>" alt="<?= $cartton['vPic_AltTag']; ?>">
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } else {
                            $cartoon = $weeklyCartoons[0];
                        ?>
                            <div class="col-lg-6 col-12 padding-right">
                                <div class="image">
                                    <img src="<?= SITE_ADDRESS ?>uploads/cartoon/<?= $cartoon['vPic']; ?>" alt="<?= $cartoon['vPic_AltTag']; ?>">
                                </div>
                            </div>
                        <?php } ?>
                        <div class="col-lg-6 col-12 padding-left">
                            <div class="content">
                                <div class="heading-block">
                                    <h2 class="title">Weekly Cartoon</h2>
                                    <p class="text">
                                        Every Friday, we send you
                                        some pictures drawn by
                                        Mario. It may be cartoons,
                                        illustrations or a sketch. It
                                        is part of a series running
                                        over 3/4 weeks and follows a
                                        theme. It could be based on a
                                        city such as New York or
                                        Mario's take on "Doctors" or
                                        "Politicians" or a particular
                                        style of drawing. Please
                                        register for your weekly
                                        chuckle.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /End Cowndown Area -->
    <?php } ?>

    <?php if (sizeof($testimonials) > 0) { ?>
        <!-- Start Testimonials Area -->
        <section id="testimonials">
            <div class="section-inner ">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="section-title">
                                <h2>Testimonials</h2>
                            </div>
                        </div>
                        <div class="owl-carousel popular-slider">
                            <?php foreach ($testimonials as $record) { ?>
                                <div class="testimonial-item">
                                    <h3><?= $record['person_name']; ?></h3><br>
                                    <p>
                                        <img src="images/quote-sign-left.png" class="quote-sign-left" alt="">
                                        <?= $record['comment']; ?>
                                        <img src="images/quote-sign-right.png" class="quote-sign-right" alt="">
                                    </p>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /End Testimonials Area -->
    <?php } ?>

    <!-- Start Google Reviews Area -->
    <section class="cown-down">
        <div class="section-inner ">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title">
                            <h2>Google Reviews</h2>
                        </div>
                        <div data-romw-token="kt5NroDMsFRo7ec5UWJMIwJXPi4xInmraPewDlyF6YFiY8MA3J"></div>
                        <script src="https://reviewsonmywebsite.com/js/v2/embed.js?id=c338ae55b38e487f19ae" type="text/javascript"></script>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /End Google Reviews Area -->

    <!-- Start Footer Area -->
    <?php include "footer.php" ?>
    <!-- /End Footer Area -->
</body>

</html>