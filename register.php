<!-- Start Header Area -->
<?php include "header.php" ;
// if( isset($_SESSION['user']) && $_SESSION['user'] != '' ) {
//     echo "<script type=\"text/javascript\">
//             window.location.href = \"profile\";
//           </script>";
// }
$countryList     = getCountriesList();
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
                        <li class="active"><a href="register">Register</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumbs -->
<!-- Shop Login -->
<section class="shop login section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3 col-12">
                <div class="login-form">
                    <h2>Register</h2>
                    <p>Please register in order to checkout more quickly</p>
                    <!-- Form -->
                    <form class="form" method="post" action="authorize.php">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Your Name<span>*</span></label>
                                    <input type="text" name="reg-name" required="required">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Your Mobile<span>*</span></label>
                                    <input type="text" name="reg-mobile" required="required">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Your Email<span>*</span></label>
                                    <input type="text" name="reg-email" required="required">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Your Password<span>*</span></label>
                                    <input type="password" name="reg-password" required="required">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Your Address<span>*</span></label>
                                    <input type="text" name="reg-address" required="required">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Your City<span>*</span></label>
                                    <input type="text" name="reg-city" required="required">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Your State<span>*</span></label>
                                    <input type="text" name="reg-state" required="required">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Country<span>*</span></label>
                                    <select name="reg-country" id="country" required="required">
					<option value="">Select your Country</option>
                                        <?php for($i=0; $o = mysqli_fetch_object($countryList); $i++) {
                                            echo '<option value="'.$o->iPostID.'">'.$o->vCountryName.'</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Your Pincode<span>*</span></label>
                                    <input type="text" name="reg-pincode" required="required">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group login-btn">
                                    <button class="btn" type="submit">Register</button>
                                    <a href="login" class="btn">Login</a>
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
<!--/ End Login -->

<!-- Start Footer Area -->
<?php include "footer.php" ?>
<!-- /End Footer Area -->

</body>
</html>
