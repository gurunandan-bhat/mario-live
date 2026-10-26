<?php
    session_start();
    unset($_SESSION["user"]);
    unset($_SESSION["cart"]);
    unset($_SESSION["message"]);
    unset($_SESSION['PREV']);
    unset($_SESSION['coupon']);
    session_unset();
    session_destroy();
    echo "<script type=\"text/javascript\">
            window.location.href = \"index\";
        </script>";
?>