<!-- Start Header Area -->
<?php include "header.php";
if (isset($_GET['page']))
    $page = $_GET['page'];
else
    $page = 1;

$pageLimit = 15;
$offset    = ($page - 1) * $pageLimit;

$vUrlName = $_GET['key'];
$categoryProductList = $marioDB->deepCategoryProducts($vUrlName);
$categoryNode = $categoryTree->find($vUrlName);

?>
<!-- End Header Area -->
<!-- Breadcrumbs -->
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-inner">
                    <ul class="bread-list">
                        <li><a href="index">Home</a></li>
                        <?php
                        foreach ($categoryNode->crumbs() as $crumb) { ?>
                            <li class="active">
                                <a href="category/<?= $crumb['vUrlName']; ?>">
                                    <i class="ti-arrow-right"></i>
                                    <?= $crumb['vName']; ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumbs -->
<!-- Product Style -->
<section class="product-area shop-sidebar shop section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2 col-md-4 col-12">
                <?php if (sizeof($categoryProductList) > 0) {  ?>
                    <div class="shop-sidebar">
                        <!-- Shop By Price -->
                        <div class="single-widget range">
                            <h3 class="title">Sort By</h3>
                            <ul class="check-box-list">
                                <li>
                                    <label class="checkbox-inline" for="1" id="lblhl">
                                        <input type="radio" id="hl" name="sort-order" value="hl">Price High to Low
                                    </label>
                                </li>
                                <li>
                                    <label class="checkbox-inline" for="2" id="lbllh">
                                        <input type="radio" id="lh" name="sort-order" value="lh">Price Low to High
                                    </label>
                                </li>
                                <li>
                                    <label class="checkbox-inline" for="3" id="lblaz">
                                        <input type="radio" id="az" name="sort-order" value="az">A - Z
                                    </label>
                                </li>
                            </ul>
                        </div>
                        <!--/ End Shop By Price -->
                        <!-- Subcatgories -->
                        <?php
                        if ($categoryNode && sizeof($categoryNode->children)) { ?>
                            <div class="single-widget range">
                                <h3 class="title">Subcategories</h3>
                                <ul class="check-box-list">
                                    <?php
                                    foreach ($categoryNode->children as $category) { ?>
                                        <li>
                                            <a href="category/<?= $category->vUrlName; ?>">&#x25BA;&nbsp;&nbsp;<?= $category->vName; ?></a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        <?php } ?>
                        <!-- End of Subcatgories -->
                    </div>
                <?php } ?>
            </div>
            <div class="col-lg-10 col-md-8 col-12">
                <div class="row product-list">
                    <?php
                    if (sizeof($categoryProductList) > 0) {
                        foreach ($categoryProductList as $product) {
                    ?>
                            <div class="col-lg-3 col-md-6 col-12">
                                <div class="single-product">
                                    <div class="product-img">
                                        <a href="product/<?= $product['vProdUrlName']; ?>">
                                            <img class="default-img" src="uploads/products/sml_<?= $product['vProdImage']; ?>" alt="<?= $product['vProdImage_AltTag']; ?>">
                                        </a>
                                    </div>
                                    <div class="product-content">
                                        <h3>
                                            <a href="product/<?= $product['vProdUrlName']; ?>">
                                                <?= $product['vProdName']; ?>
                                            </a>
                                        </h3>
                                        <?php if ($product['iStockQty'] > 0 && $product['iSold'] > 0) { ?>
                                            <span class="special-quantity-message">
                                                Sold: <?= $product['iSold']; ?> of <?= $product['iStockQty']; ?>
                                            </span>
                                        <?php } ?>
                                        <div class="product-price">
                                            <span style="font-family:Arial, Helvetica, sans-serif;font-weight:600;">
                                                <b>&#8377; </b>
                                                <?= $product['fPrice']; ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    } else { ?>
                        <div class="col-lg-12 col-md-8 col-12">
                            <h3><br>
                                <center><span>No Results Found</span></center>
                            </h3>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!--/ End Product Style 1  -->

<!-- Start Footer Area -->
<?php include "footer.php" ?>
<!-- /End Footer Area -->
<script>
    $(".checkbox-inline").click(function() {
        var order = $(this).attr("id").replace('lbl', '');
        $('#' + order).prop("checked", true);
        var data = 'category=<?php echo $_GET['key'] ?>&offset=<?php echo $offset ?>&pageLimit=<?php echo $pageLimit ?>&order=' + order;
        $.ajax({
            url: 'config/api.php',
            type: 'GET',
            data: data,
            success: function(response) {
                $('.product-list').html(response);
            },
            error: function(response) {
                alert(data.responseText);
            }
        });
    });
</script>
</body>

</html>