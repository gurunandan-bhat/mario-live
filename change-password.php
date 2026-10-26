<!-- Start Header Area -->
<?php include "header.php" ;
// 	echo "<script type=\"text/javascript\">
// 	window.location.href = \"index\";
//   </script>";
?>
<!-- End Header Area -->
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-inner">
                    <ul class="bread-list">
                        <li><a href="index">Home<i class="ti-arrow-right"></i></a></li>
                        <li class="active"><a href="change-password">Update Password</a></li>
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
                                <a href="profile"><h4 class="title" >My Orders</h4></a>
                                <a href="update-profile"><h4 class="title">Update Profile</h4></a>
                                <a href="manage-address"><h4 class="title">Manage Addresses</h4></a>
								<a href="change-password"><h4 class="title active">Change Password</h4></a>
                                <a href="logout"><h4 class="title">Logout</h4></a>
							</div>
							<!--/ End Shop By Price -->
						</div>
					</div>
					<div class="col-lg-9 col-md-8 col-12">
						<!-- Shop Login -->
						<section class="shop login section update-profile">
							<div class="container">
								<div class="col-lg-12 col-12">
									<div class="login-form">
										<h2>Password Update</h2>
										<!-- Form -->
										<form class="form" method="post" action="authorize.php">
											<div class="row">
												<div class="col-12">
													<div class="form-group">
														<label><b>Ensure to save your changes</b></label><br>
														<label>Current Password<span>*</span></label>
														<input type="password" name="old-password" required="required">
													</div>
												</div>
												<div class="col-12">
													<div class="form-group">
														<label>New Password<span>*</span></label>
														<input type="password" name="upd-password" required="required">
													</div>
												</div>
												<div class="col-12">
													<div class="form-group">
														<label>Confirm New Password<span>*</span></label>
														<input type="password" name="con-password" required="required">
													</div>
												</div>
												<div class="col-12">
													<div class="form-group login-btn">
														<button class="btn save-changes-btn" type="submit">Save Changes</button>
													</div>
												</div>
											</div>
										</form>
										<!--/ End Form -->
									</div>
								</div>
							</div>
						</section>
						<!--/ End Login -->
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