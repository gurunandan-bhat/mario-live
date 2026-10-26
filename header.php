<?php
include "config/config.php";
include "config/Category.php";
include "config/CategoryTree.php";
include "config/MarioDB.php";
include "config/api.php";

session_start();
$title = $desc = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search']))
    if ($_POST['search'] != '') {
        $query = htmlspecialchars(htmlspecialchars($_POST['search'], ENT_QUOTES), ENT_QUOTES);
        header("location:" . SITE_ADDRESS . "search/" . $query);
        // echo "<script type=\"text/javascript\">
        //             window.location.href = ".SITE_ADDRESS."search/".$query.";
        //       </script>";
    }
$searchKeyword = (isset($_GET['type']) && $_GET['type'] == "search") ? htmlspecialchars_decode($_GET['key']) : '';
$cart_total = 0;
if (isset($_SESSION["cart"]))
    $cart_total    = (isset($_SESSION['cart'])) ? sizeof($_SESSION['cart']) : 0;

$marioDB = new MarioDB;
if (isset($_GET['type']) && isset($_GET['key'])) {
    if ($_GET['type'] == "product") {
        $meta = $marioDB->productMeta($_GET['key']);
        $title = $meta['pName'] . "| Mario Miranda " . $meta['meta'];
        $desc = $meta['pName'] . ", Buy Mario Miranda " . $meta['cName'] . " online";
    }
    if ($_GET['type'] == "category") {
        $meta = $marioDB->categoryMeta($_GET['key']);
        $title = "Mario Miranda | " . $meta['cName'];
        $desc = "Buy Mario Miranda " . $meta['cName'] . " online";
    }
}
$categoryTree = $marioDB->categoryTree();

?>
<!DOCTYPE html>
<html lang="zxx">

<head>
    <!-- Meta Tag -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name='title' content='<?= $title ?>'>
    <meta name='description' content='<?= $desc ?>'>
    <base href="<?php echo SITE_ADDRESS; ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Title Tag  -->
    <title><?= $title; ?></title>
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
            "url": "https://www.mariodemiranda.com/",
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
    <header class="header shop v1">
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
                                    <input type="text" id="filler-bar" placeholder="Search Products" name="search" value="<?php echo $searchKeyword; ?>">
                                    <button class="btnn" value="search"><i class="ti-search"></i></button>
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
                                    <input name="search" id="filler-bar" placeholder="Search Products" type="search" value="<?php echo $searchKeyword; ?>">
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
                                <div class="row category-menu-w-images">
                                    <div class="category-menu">
                                        <?php
                                        foreach ($categoryTree->root->children  as $category) { ?>
                                            <div class="home-cat-item">
                                                <a href="category/<?= $category->vUrlName; ?>">
                                                    <img style="border-radius: 50%;" src="uploads/prodcat/<?= $category->vMenuImage; ?>" class="category-img" alt="<?= $category->vUrlName; ?>">
                                                </a>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <!-- Main Menu -->
                                <nav class="navbar navbar-expand-lg">
                                    <div class="navbar-collapse">
                                        <div class="nav-inner">
                                            <ul class="nav main-menu menu navbar-nav">
                                                <li><a href="index">Home</a></li>
                                                <?php
                                                foreach ($categoryTree->root->children as $category) {
                                                    $subCategories = $category->children;
                                                ?>
                                                    <li>
                                                        <a href="<?= SITE_ADDRESS; ?>category/<?= $category->vUrlName; ?>">
                                                            <?= ucwords($category->vName); ?>
                                                            <?= sizeof($subCategories) > 0 ? '<i class="ti-angle-down"></i>' : ''; ?>
                                                        </a>
                                                        <?php
                                                        if (sizeof($subCategories) > 0) { ?>
                                                            <ul class="dropdown">
                                                                <?php
                                                                foreach ($subCategories as $subCategory) { ?>
                                                                    <li>
                                                                        <a href="<?= SITE_ADDRESS; ?>category/<?= $subCategory->vUrlName; ?>">
                                                                            <?= $subCategory->vName . ' (' . $subCategory->count . ')'; ?>
                                                                        </a>
                                                                    </li>
                                                                <?php } ?>
                                                            </ul>
                                                        <?php } ?>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                </nav>
                                <div class="text-center">
                                    <img src="/uploads/free_banner.jpg" alt="Free Shipping" />
                                </div
                                    <!--/ End Main Menu -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ End Header Inner -->
    </header>
    <!--/ End Header -->