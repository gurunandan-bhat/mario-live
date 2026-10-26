<!-- Start Header Area -->
<?php include "header.php" ;
if(isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
} else {
    echo "<script type=\"text/javascript\">
                            window.location.href = \"index\";
                          </script>";
}
$countryList = getCountriesList();
$profile     = mysqli_fetch_object(getUserById($user));
?>
<!-- End Header Area -->
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-inner">
                    <ul class="bread-list">
                        <li><a href="index">Home<i class="ti-arrow-right"></i></a></li>
                        <li class="active"><a href="update-profile">Update Profile</a></li>
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
                        <a href="update-profile"><h4 class="title active">Update Profile</h4></a>
                        <a href="manage-address"><h4 class="title">Manage Addresses</h4></a>
                        <a href="change-password"><h4 class="title">Change Password</h4></a>
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
                                <h2>Profile Update</h2>
                                <!-- Form -->
                                <form class="form" method="post" action="authorize.php">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-12">
                                            <div class="form-group">
                                                <label>Your Name<span>*</span></label>
                                                <input type="text" name="upd-name" value="<?= ucwords($profile->vName);?>" required="required">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-12">
                                            <div class="form-group">
                                                <label>Your Mobile<span>*</span></label>
                                                <input type="text" name="upd-mobile" value="<?= ucwords($profile->vContact);?>" required="required">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-12">
                                            <div class="form-group">
                                                <label>Your Email<span>*</span></label>
                                                <input type="text" name="upd-email" value="<?= $profile->vEmail;?>" required="required" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-12">
                                            <div class="form-group">
                                                <label>Your Address<span>*</span></label>
                                                <input type="text" name="upd-address" value="<?= ucwords($profile->vAddress);?>" required="required">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-12">
                                            <div class="form-group">
                                                <label>Your City<span>*</span></label>
                                                <input type="text" name="upd-city" value="<?= ucwords($profile->vCity);?>" required="required">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-12">
                                            <div class="form-group">
                                                <label>Your State<span>*</span></label>
                                                <input type="text" name="upd-state" value="<?= ucwords($profile->vState);?>" required="required">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-12">
                                            <div class="form-group">
                                                <label>Country<span>*</span></label>
                                                <select name="upd-country" id="country" required="required">
                                                    <?php for($i=0; $o = mysqli_fetch_object($countryList); $i++) {
                                                        if( $o->iPostID == $profile->iPostCountryID )
                                                            echo '<option value="'.$o->iPostID.'" selected>'.$o->vCountryName.'</option>';
                                                        else
                                                            echo '<option value="'.$o->iPostID.'">'.$o->vCountryName.'</option>';
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-12">
                                            <div class="form-group">
                                                <label>Your Pincode<span>*</span></label>
                                                <input type="text" name="upd-pincode" value="<?= ucwords($profile->vZipcode);?>" required="required">
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
