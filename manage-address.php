<!-- Start Header Area -->
<?php include "header.php" ;
if(isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    $useraddrlist = getAllAddressByUserId($user);
    $countryList  = getCountriesList();
} else {
    echo "<script type=\"text/javascript\">
                                window.location.href = \"login\";
                  </script>";
}
?>
<!-- End Header Area -->

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
                        <a href="manage-address"><h4 class="title active">Manage Addresses</h4></a>
                        <a href="change-password"><h4 class="title">Change Password</h4></a>
                        <a href="logout"><h4 class="title">Logout</h4></a>
                    </div>
                    <!--/ End Shop By Price -->
                </div>
            </div>
            <div class="col-lg-9 col-md-8 col-12">
                <div class="row">
                    <?php
                    if($useraddrlist->num_rows > 0)     {
                        for($i=0; $o = mysqli_fetch_object($useraddrlist); $i++) {
                    ?>
                        <div class="col-12">
                            <div class="row order-item">
                                <div class="col-lg-9 col-md-6 col-12 order-product-meta">
                                    <h6 class="product-name address-name"><a><b><?php echo ucwords($o->vCountryName);?></b></a></h6><br>
                                    <span><?php echo ucwords($o->vAddress).', '.ucwords($o->vCity);?></span><br>
                                    <span><?php echo ucwords($o->vState) ?>, <?php echo ucwords(getCountryNameById($o->iPostCountryID)).', '.$o->vPincode;?></span><br>
                                    <span>Contact : <?php echo $o->vPhone;?></span><br>
                                    <span>Email : <?php echo $o->vEmail;?></span>
                                </div>
                                <div class="col-lg-3 col-md-6 col-12 order-product-meta">
                                    <div class="list-content">
                                        <div class="product-content">
                                            <a class="edit-address" href="update-address/<?= $o->iMAddrID; ?>"><div class="order-meta-data-2 address-manage"><span><b>EDIT</b></span></div></a>
                                            <a class="delete-address" href="delete-address/<?= $o->iMAddrID; ?>"><div class="order-meta-data-2 address-manage"><span><b>DELETE</b></span></div></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }
                    } else { ?>
                        <div class="col-lg-12 col-md-8 col-12">
                            <h3><br><center><span>No Address Found</span></center></h3>
                        </div>
                    <?php } ?>
                    <div class="col-lg-12 col-md-8 col-12">
                        <center><a class="btn add-new-addrs" href="new-address"><center>Add New Address</center></a></center>
                    </div>
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
