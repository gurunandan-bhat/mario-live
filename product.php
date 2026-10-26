<!-- Start Header Area -->
<?php include "header.php";
$user = 0;
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
}
$isProduct = false;
if (isset($_GET['key'])) {
    $productUrlName   = $_GET['key'];
    $_SESSION['PREV'] = $_GET['key'];
}
$product       = mysqli_fetch_object(getProductByUrlName($productUrlName));
if (isset($_SESSION["cart"])) {
    foreach ($_SESSION['cart'] as $key => $value)
        if ($value['productId'] == $product->iProdID) {
            $isProduct = true;
            break;
        }
}
$productsByCat = getProductsByCategory($product->iPCatID);
$category      = mysqli_fetch_object(getCategoryById($product->iPCatID));
$productImages = getProductImagesById($product->iProdID);
$productColors = getProductColorsById($product->iProdID);
$productAttrbs = getProductAttrbsById($product->iProdID);
$productSpecs  = $marioDB->productAttributes($product->iProdID);
$productReviews = getLimitedReviewsByProductId($product->iProdID);
$allAttrNames  = getAllProductAttributeNames();
$productSubSets = getProductSubSets($product->iProdID);
$soldOut       = ($product->cSoldOut == 'Y') ? true : false;
?>
<!-- End Header Area -->
<!-- Breadcrumbs -->
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-inner">
                    <ul class="bread-list">
                        <li><a href="index">Home<i class="ti-arrow-right"></i></a></li>
                        <li><a href="category/<?= $category->vUrlName; ?>"><?= ucwords($category->vName); ?><i class="ti-arrow-right"></i></a></li>
                        <li class="active"><a href="product/<?= $product->vUrlName; ?>"><?= $product->vName ?></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumbs -->

<!-- Shop Single -->
<input type="hidden" class="userid" name="userid" value="<?= $user; ?>" />
<input type="hidden" class="productid" name="productid" value="<?= $product->iProdID; ?>" />
<input type="hidden" class="productcatid" name="productcatid" value="<?= $product->iPCatID; ?>" />
<section class="shop single section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-12">
                <!-- Product Slider -->
                <div class="product-gallery">
                    <!-- Images slider -->
                    <div class="flexslider-thumbnails">
                        <ul class="slides ">
                            <li data-thumb="uploads/products/<?= $product->vImage; ?>">
                                <img src="uploads/products/<?= $product->vImage; ?>" alt="<?= $product->vImage_AltTag; ?>">
                            </li>
                            <?php
                            if ($productImages->num_rows > 0) {
                                for ($i = 0; $o = mysqli_fetch_object($productImages); $i++) {
                            ?>
                                    <li data-thumb="uploads/product_images/<?= $o->vPic; ?>">
                                        <img src="uploads/product_images/<?= $o->vPic; ?>" alt="<?= $o->vTitle; ?>" style="height:auto;">
                                    </li>
                                <?php }
                            }
                            if ($product->vYTID != '') { ?>
                                <li data-thumb="http://img.youtube.com/vi/<?= $product->vYTID; ?>/mqdefault.jpg">
                                    <div class="plyr__video-embed plyr-video">
                                        <iframe class="youtube" src="https://www.youtube.com/embed/<?= $product->vYTID; ?>" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <!-- End Images slider -->
                </div>
                <!-- End Product slider -->
                <!-- Product Info -->
                <div class="product-info">
                    <div class="nav-main">
                        <!-- Tab Nav -->
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#description" role="tab">Description</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#reviews" role="tab">Reviews</a></li>
                        </ul>
                        <!--/ End Tab Nav -->
                    </div>
                    <div class="tab-content" id="myTabContent">
                        <!-- Description Tab -->
                        <div class="tab-pane fade show active" id="description" role="tabpanel">
                            <div class="tab-single">
                                <div class="row">
                                    <div class="col-12">
                                        <?php
                                        if (sizeof($productSpecs) > 0) { ?>
                                            <div class="single-des">
                                                <h4>Product Features:</h4>
                                                <ul>
                                                    <?php
                                                    foreach ($productSpecs as $spec) { ?>
                                                        <li>
                                                            <b><?= $spec['attribName']; ?> :</b>
                                                            <?= $spec['attribValue']; ?>
                                                        </li>
                                                    <?php
                                                    } ?>
                                                </ul>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/ End Description Tab -->
                        <!-- Reviews Tab -->
                        <div class="tab-pane fade" id="reviews" role="tabpanel">
                            <div class="tab-single review-panel">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="ratting-main">
                                            <?php
                                            if ($productReviews->num_rows > 0) {
                                                for ($i = 0; $o = mysqli_fetch_object($productReviews); $i++) { ?>
                                                    <!-- Single Rating -->
                                                    <div class="single-rating">
                                                        <div class="rating-author">
                                                            <img src="images/user.jpg" alt="<?= str_replace(' ', '_', strtolower($o->reviewer_name)); ?>">
                                                        </div>
                                                        <div class="rating-des">
                                                            <h6><?= ucwords($o->reviewer_name); ?></h6>
                                                            <p class="review-date"><?= date_format(date_create($o->datetime), "D, d M Y"); ?></p>
                                                            <p><?= $o->review; ?></p>
                                                        </div>
                                                    </div>
                                                    <!--/ End Single Rating -->
                                        </div>
                                    <?php }
                                            } else { ?>
                                    <h4>No Reviews Yet. Become the first person to review the product!</h4>
                                <?php } ?>
                                <!-- Review -->
                                <div class="comment-review">
                                    <div class="add-review">
                                        <h5>Add A Review</h5>
                                    </div>
                                    <!--/ End Review -->
                                    <!-- Form -->
                                    <form class="form" method="post" action="add-review.php">
                                        <div class="row">
                                            <div class="col-lg-12 col-12">
                                                <div class="form-group">
                                                    <label>Write a review<span>*</span></label>
                                                    <textarea name="review" rows="6" columns="200" placeholder="Enter your review here" required></textarea>
                                                    <input type="hidden" name="prodid" value="<?= $product->iProdID; ?>" />
                                                    <input type="hidden" name="prodcatid" value="<?= $product->iPCatID; ?>" />
                                                    <input type="hidden" name="prodname" value="<?= $product->vName; ?>" />
                                                    <input type="hidden" name="produrl" value="<?= $productUrlName; ?>" />
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-12">
                                                <div class="form-group button5">
                                                    <button type="submit" class="btn">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <!--/ End Form -->
                                </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ End Reviews Tab -->
                        </div>
                    </div>
                </div>
                <!-- End Product Info -->
            </div>
        </div>
        <div class="col-lg-6 col-12">
            <form method="POST">
                <div class="product-des">
                    <!-- Description -->
                    <?php
                    $pCatID = $category->iPCatID;
                    if ($pCatID == 128) { ?>
                        <span class="s_chart" style="float:right"><a href="images/mask.jpg">
                                <p>Size chart</p><img src="images/size.jpg" height="50" width="50">
                            </a></span>
                        <?php } else {
                        if (($pCatID == 9) || ($pCatID == 95)) { ?>
                            <span class="s_chart" style="float:right"><a href="images/size.jpg">
                                    <p>Size chart</p><img src="images/size.jpg" height="50" width="50">
                                </a></span>
                    <?php }
                    } ?>
                    <div class="short">
                        <h4><?= $product->vName ?></h4>
                        <div class="rating-main">
                            <?php
                            if ($productReviews->num_rows > 0) {
                            ?>
                                <a href="reviews/<?= $product->vUrlName ?>" class="total-review"><b><?= $productReviews->num_rows ?></b> Reviews</a>
                            <?php } ?>
                        </div>
                        <p class="price"><b style="font-family:Arial, Helvetica, sans-serif;font-weight:600;">&#8377;</b>
                            <span class="discount product-rate" style="font-family:Arial, Helvetica, sans-serif;font-weight:600;">
                                <?= ($product->fOPrice > 0) ? $product->fOPrice : $product->fPrice; ?>
                            </span>
                            <s><?= ($product->fOPrice > 0) ? $product->fPrice : ''; ?></s>
                        </p>
                        <input type="number" class="pPrice" value="<?= ($product->fOPrice > 0) ? $product->fOPrice : $product->fPrice; ?>" hidden>
                        <?php if ($product->vDescription != '') { ?>
                            <p class="description"><?= $product->vShortDesc; ?></p>
                        <?php } ?>
                    </div>
                    <!--/ End Description -->
                    <?php
                    if ($productColors->num_rows > 0 || $productAttrbs->num_rows > 0) { ?>
                        <br>
                        <h5>Available Options </h5><br>
                        <?php if ($productColors->num_rows > 0) { ?>
                            <div class="color">
                                <input class="prod-color-order" name="prod-color-order" type="hidden" />
                                <h4>Color</h4>
                                <ul>
                                    <?php for ($i = 0; $o = mysqli_fetch_object($productColors); $i++) { ?>
                                        <li>
                                            <a id="<?= $o->iColorID; ?>" class="prod-color" name="<?= $o->vName; ?>" style="background-color: <?= $o->vColor; ?>">
                                                <img src="assets2/images/check.png" height="10">
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        <?php } ?>
                        <!--/ End Color -->
                        <!-- Size -->
                        <?php if ($productAttrbs->num_rows > 0) { ?>
                            <div class="size">
                                <input class="prod-size-order" name="prod-size-order" type="hidden" />
                                <h4><b>Size</b></h4>
                                <ul>
                                    <?php for ($i = 0; $o = mysqli_fetch_object($productAttrbs); $i++) {
                                        $s = explode(" ", $o->vValue);
                                        if (sizeof($s) > 1) {
                                            if ($s[0] == "Kids") { ?>
                                                <input type="text" class="s_c" value="size" hidden>
                                                <li style="text-align:center;">
                                                    <label style="font-size:12px;" for="<?= $o->iProdAttribID ?>"><?= $s[0]; ?></label>
                                                    <a id="<?= $o->iProdAttribID ?>" class="prod-size" name="<?= ($o->fOPrice < $o->fPrice && $o->fOPrice != 0) ? $o->fOPrice : $o->fPrice; ?>">
                                                        <?= $s[1]; ?>
                                                    </a>
                                                </li>
                                            <?php
                                            } else {
                                            ?>
                                                <div>
                                                    <input type="radio" class="prod-size-1" name="size" id="<?= $o->iProdAttribID; ?>" value="<?= $o->vValue; ?>">
                                                    <label for="<?= $o->iProdAttribID; ?>"><?= $o->vValue; ?></label>
                                                </div>
                                            <?php }
                                        } else {
                                            ?>
                                            <input type="text" class="s_c" value="size" hidden>
                                            <li>
                                                <a id="<?= $o->iProdAttribID; ?>" class="prod-size" name="<?= ($o->fOPrice < $o->fPrice && $o->fOPrice != 0) ? $o->fOPrice : $o->fPrice; ?>">
                                                    <?= $o->vValue; ?>
                                                </a>
                                            </li>
                                    <?php }
                                    } ?>
                                </ul>
                            </div>
                        <?php }
                    }
                    if ($product->iStockQty > 0 && $product->iSold > 0) { ?>
                        <div>
                            <span class="special-quantity-message">
                                Sold: <?= $product->iSold; ?> of <?= $product->iStockQty; ?>
                            </span>
                        </div>
                    <?php } ?>
                    <!-- Product Buy -->
                    <div class="row">
                        <div class="product-buy">
                            <?php if (!$isProduct) { ?>
                                <div class="quantity">
                                    <h6><b>Quantity :</b></h6>
                                    <!-- Input Order -->
                                    <div class="input-group">
                                        <div class="button minus">
                                            <button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
                                                <i class="ti-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text" name="quant[1]" class="input-number" data-min="1" data-max="1000" value="1" readonly>
                                        <div class="button plus">
                                            <button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[1]">
                                                <i class="ti-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!--/ End Input Order -->
                                </div>
                            <?php } ?>
                            <div class="add-to-cart">
                                <?php
                                if ($category->iParentID == 3) { ?>
                                    <a class="btn" href="mailto:archauto@gmail.com">Contact Us</a>
                                    <?php
                                } else {
                                    if ($isProduct) { ?>
                                        <button type="button" class="btn add-to-cart-btn" onclick="cart">Go To Cart</button>
                                    <?php } else { ?>
                                        <button type="button" class="btn add-to-cart-btn" <?= $soldOut ? 'disabled="disabled"' : '' ?>>Add to cart</button>
                                <?php }
                                } ?>
                                <a class="btn min add-wishlist"><i class="ti-heart"></i></a>
                            </div>
                            <p class="cat">
                                <b>Category :</b>
                                <a href="category/<?= $category->vUrlName; ?>">
                                    <?= ucwords($category->vName); ?>
                                </a>
                            </p>
                        </div>
                    </div>
                    <!--/ End Product Buy -->
                </div>
            </form>
        </div>
    </div>
</section>
<!--/ End Shop Single -->

<!-- Start Most Popular -->
<div class="product-area most-popular related-product section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>You May Also Like</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="owl-carousel popular-slider">
                    <?php for ($i = 0; $o = mysqli_fetch_object($productsByCat); $i++) {
                        if ($product->iProdID == $o->iProdID) {
                            continue;
                        }
                    ?>
                        <!-- Start Single Product -->
                        <div class="single-product">
                            <div class="product-img">
                                <a href="product/<?php echo $o->vUrlName; ?>">
                                    <img class="default-img" src="uploads/products/sml_<?= $o->vSmallImage; ?>" alt="<?= $o->vSmallImage_AltTag; ?>">
                                    <img class="hover-img" src="uploads/products/sml_<?= $o->vSmallImage; ?>" alt="<?= $o->vSmallImage_AltTag; ?>">
                                </a>
                            </div>
                            <div class="product-content">
                                <h3><a href="product/<?= $o->vUrlName; ?>"><?= $o->vName; ?></a></h3>
                                <div class="product-price">
                                    <?php if ($o->fOPrice > 0) { ?>
                                        <span class="old" style="font-family:Arial, Helvetica, sans-serif;font-weight:600;">
                                            <b>&#8377;</b> <?= $o->fPrice; ?>
                                        </span>
                                        <span style="font-family:Arial, Helvetica, sans-serif;font-weight:600;">
                                            <b>&#8377;</b> <?= $o->fOPrice; ?>
                                        </span>
                                    <?php } else { ?>
                                        <span style="font-family:Arial, Helvetica, sans-serif;font-weight:600;">
                                            <b>&#8377;</b> <?= $o->fPrice; ?>
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
        <div class="view-more">
            <center>
                <a href="category/<?= $category->vUrlName; ?>" class="btn">View More</a>
            </center>
        </div>
    </div>
</div>
<!-- End Most Popular Area -->

<!-- Start Footer Area -->
<?php include "footer.php" ?>
<!-- /End Footer Area -->
</body>

</html>