<!-- Start Header Area -->
<?php include "header.php" ;
if(isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    $countryList  = getCountriesList();
} else {
    echo "<script type=\"text/javascript\">
                                window.location.href = \"login\";
                  </script>";
}
?>
<!-- End Header Area -->

<section class="product-area shop-sidebar shop section">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-12">
                <div class="shop-sidebar">
                    <!-- Shop By Price -->
                    <div class="single-widget range profile-menu">
                        <a href="profile"><h4 class="title" >My Orders</h4></a>
                        <a href="update-profile"><h4 class="title">Update Profile</h4></a>
                        <a href="manage-address"><h4 class="title active">Manage Addresses</h4></a>
                        <a href="change-password"><h4 class="title">Change Password</h4></a>
                        <a href="logout"><h4 class="title">Logout</h4></a>
                    </div>
                    <!--/ End Shop By Price -->
                </div>
            </div>

            <div class="col-lg-9 col-md-8 col-12 shop login section update-address">
                <div class="login-form format">
                    <h2>New Address Update</h2>
                    <!-- Form -->
                    <form class="form" method="post" action="authorize.php">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Name<span>*</span></label>
                                    <input type="text" name="new-addr-name" id="new-addr-name" placeholder="" required="required">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Email Address<span>*</span></label>
                                    <input type="email" name="new-addr-email" id="new-addr-email" placeholder="" required="required">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Phone Number<span>*</span></label>
                                    <input type="number" name="new-addr-contact" id="new-addr-contact" placeholder="" required="required">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Address Line<span>*</span></label>
                                    <input type="text" name="new-addr-address" id="new-addr-address" placeholder="" required="required">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>City<span>*</span></label>
                                    <input type="text" name="new-addr-city" id="new-addr-city" placeholder="" required="required">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>State<span>*</span></label>
                                    <input type="text" name="new-addr-state" id="new-addr-state" placeholder="" required="required">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Country<span>*</span></label>
                                    <select name="new-addr-country" id="new-addr-country" required="required">
                                        <?php for($i=0; $o = mysqli_fetch_object($countryList); $i++) {
                                            echo '<option value="'.$o->iPostID.'">'.$o->vCountryName.'</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Postal Code<span>*</span></label>
                                    <input type="text" name="new-addr-pincode" id="new-addr-pincode" placeholder="" required="required">
                                </div>
                            </div>
                            <div class="col-lg-12 col-12">
                                <div class="col-lg-5 col-md-5 col-12">
                                    <div class="form-group update-address button5">
                                        <button class="btn save-changes-btn" type="submit">Save Changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!--/ End Form -->
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
