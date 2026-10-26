<!-- Start Header Area -->
<?php include "header.php" ;
	if(isset($_SESSION['user'])) {
		$user = $_SESSION['user'];
	} else {
		echo "<script type=\"text/javascript\">
					window.location.href = \"login\";
				</script>";
	}
	$orders = getAllOrdersByUser($user);
?>
<!-- End Header Area -->
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-inner">
                    <ul class="bread-list">
                        <li><a href="index">Home<i class="ti-arrow-right"></i></a></li>
                        <li class="active"><a href="profile">My Profile</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Product Style -->
<section class="product-area shop-sidebar shop section">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-3 col-md-4 col-12">
						<div class="shop-sidebar">
							<!-- Shop By Price -->
							<div class="single-widget range profile-menu">
                                <a href="profile"><h4 class="title active" >My Orders</h4></a>
                                <a href="update-profile"><h4 class="title">Update Profile</h4></a>
                                <a href="manage-address"><h4 class="title">Manage Addresses</h4></a>
								<a href="change-password"><h4 class="title">Change Password</h4></a>
                                <a href="logout"><h4 class="title">Logout</h4></a>
							</div>
							<!--/ End Shop By Price -->
						</div>
					</div>
					<div class="col-lg-9 col-md-8 col-12">
						<div class="row">
						<?php 
							if($orders->num_rows > 0)	{ 
							for($i=0; $order = mysqli_fetch_object($orders); $i++) {
								$orderData = getOrderDataById($order->iOrdID);
								for($i=0; $orderdata = mysqli_fetch_object($orderData); $i++) {
									$product = mysqli_fetch_object(getProductById($orderdata->iProdID));
									$orderAttr = getOrderAttrDataByOrderDataId($orderdata->iOrdDatID);
									$orderColr = mysqli_fetch_object(getOrderColorDataByOrderDataId($orderdata->iOrdDatID));
						?>
								<?php if(!empty($product)) { ?>
								<div class="col-12">
									<div class="row order-item">
										<div class="col-lg-4 col-md-6 col-sm-6">
											<div class="single-product">
												<div>
													<a href="product/<?php echo $product-> vUrlName;?>">
														<img class="order-default-img" src="uploads/products/sml_<?php echo $product-> vSmallImage;?>" alt="<?php echo $product-> vSmallImage_AltTag;?>">
													</a>
												</div>
											</div>
										</div>
										<div class="col-lg-5 col-md-6 col-12 order-product-meta">
											<div>
												<div>
													<span class="order-product-title"><b><a href="product/<?php echo $product-> vUrlName;?>"><?php echo $product-> vName;?></a></b></span>
													<div>
														<b><span class="order-product-title">₹ <?php echo $orderdata-> fRate;?></span></b>
													</div>
													<div>
														<span >Quantity : <?php echo $orderdata-> iQty;?></span>
													</div>
													<?php if(!empty($orderColr)) { 
														echo "<div>";
														echo "<span >Color : ".$orderColr-> vName."</span>";
														echo "</div>";
													} ?>
													<?php if(!empty($orderAttr)) {
														for($i=0; $orderattr = mysqli_fetch_object($orderAttr); $i++) {?>
													<div>
														<span><?php echo mysqli_fetch_object(getAttributeNameByAttributeId($orderattr->iAttribID))->vName; ?> : <?php echo $orderattr->vValue;?></span>
													</div>
													<?php }} ?>
												</div>
											</div>
										</div>
										<div class="col-lg-3 col-md-6 col-12  order-product-meta">
											<div class="list-content">
												<div class="product-content">
													<div class="order-meta-data-2"><span>Order ID<br><b><?php echo $order->iOrdID;?></b></span></div>
													<div class="order-meta-data-2"><span>Ordered On<br><b><?php echo date_format(date_create($order-> dtDt),"d M Y");?></b></span></div>
													<div class="order-meta-data-2"><span><b><?php echo getOrderStatus($order->cStatus);?></b></span></div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<?php } ?>
						<?php } }
						} else { ?>
							<div class="col-lg-12 col-md-8 col-12">
								<h3><br><center><span>No Orders Found</span></center></h3>
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
</body>
</html>