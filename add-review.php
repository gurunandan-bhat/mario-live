<?php
    session_start();
    include "config/api.php";
    if(!isset($_SESSION['user']))
        echo "<script type=\"text/javascript\">
                  window.location.href = \"login\";
              </script>";
    if(isset($_POST['review']) && $_POST['review'] != '' && isset($_POST['prodid']) && $_POST['prodid'] != '' &&
       isset($_POST['prodname']) && $_POST['prodname'] != '' && isset($_POST['prodcatid']) && $_POST['prodcatid'] != '' &&
       isset($_POST['produrl']) && $_POST['produrl'] != '') {
        $user     = mysqli_fetch_object(getUserById($_SESSION['user']));
        $userId   = $_SESSION['user'];
        $userName = $user->vName;
        $review   = $_POST['review'];
        $prodId   = $_POST['prodid'];
        $prodName = $_POST['prodname'];
        $prodCID  = $_POST['prodcatid'];
        $prodUrl  = $_POST['produrl'];
        addNewReview($prodId,$prodName,$prodCID,$userId,$userName,$review);
        echo "<script type=\"text/javascript\">
                  window.location.href = product/".$prodUrl.";
              </script>";
    }
?>