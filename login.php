<!-- Start Header Area -->
<?php include "header.php" ; 
    $message = '';
    if(isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
    }
    if( isset($_SESSION['user']) && $_SESSION['user'] != '' ) {
        echo "<script type=\"text/javascript\">
                window.location.href = \"profile\";
              </script>";
    }
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
                            <li class="active"><a href="login">Login</a></li>
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
                        <h2>Login</h2>
                        <p>Please register for faster checkout</p>
                        <center><span class="login-error"><?php echo $message; ?></span></center>
                        <!-- Form -->
                        <form class="form" method="POST" action="authorize.php">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Your Email<span>*</span></label>
                                        <input type="email" id="email" name="email" required="required">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Your Password<span>*</span></label>
                                        <input type="password" id="password" name="password" required="required">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group login-btn">
                                        <button class="btn" type="submit">Login</button>
                                        <a href="register" class="btn">Register</a>
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