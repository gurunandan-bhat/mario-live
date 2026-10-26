<?php
    session_start();
    include('config/api.php');
    if(isset($_SESSION['user'])) {
        $user = $_SESSION['user'];
        if (isset($_GET['key']))    {
            $addrId   = $_GET['key'];
            deleteUserAddressById($addrId,$user);
            echo "<script type=\"text/javascript\">
                      window.location.href = \"../manage-address\";
                  </script>";
        }
    } else {
        echo "<script type=\"text/javascript\">
                    window.location.href = \"login\";
            </script>";
    }
?>