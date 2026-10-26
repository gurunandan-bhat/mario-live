<?php
    session_start();
    include "config/api.php";
    require_once('config/ti-salt.php');
    $salt_obj = new SaltIT;

    //User Login
    if(isset($_POST["email"]) && $_POST["email"] != '' && 
       isset($_POST["password"]) && $_POST["password"] != '' ) {
            $email    = $_POST["email"];
            $password = $salt_obj->EnCode(md5($_POST["password"]));
            $userdata = authorizeUser($email,$password);
            unset($_SESSION['message']);
            if($userdata->num_rows > 0 ) {
                $user = mysqli_fetch_object($userdata);
                $_SESSION['user'] = $user->iMemberID; 
                $_SESSION['name'] = $user->vName;
                echo "<script type=\"text/javascript\">
                         window.location.href = \"profile\";
                      </script>";
            } else {
                $_SESSION['message'] = 'Invalid Email or Password !';
                echo "<script type=\"text/javascript\">
                         window.location.href = \"login\";
                      </script>";
            }
    }

    //User Sign Up
    if(isset($_POST["reg-email"]) && $_POST["reg-email"] != '' && isset($_POST["reg-password"]) && $_POST["reg-password"] != ''
    && isset($_POST["reg-mobile"]) && $_POST["reg-mobile"] != '' && isset($_POST["reg-name"]) && $_POST["reg-name"] != '' 
    && isset($_POST["reg-address"]) && $_POST["reg-address"] != '' && isset($_POST["reg-city"]) && $_POST["reg-city"] != ''
    && isset($_POST["reg-state"]) && $_POST["reg-state"] != '' && isset($_POST["reg-country"]) && $_POST["reg-country"] != ''
    && isset($_POST["reg-pincode"]) && $_POST["reg-pincode"] != '')  {
        $name     = $_POST["reg-name"];
        $mobile   = $_POST["reg-mobile"];
        $email    = $_POST["reg-email"];
        $password = $salt_obj->EnCode(md5($_POST["reg-password"]));
        $address  = $_POST["reg-address"];
        $city     = $_POST["reg-city"];
        $state    = $_POST["reg-state"];
        $country  = $_POST["reg-country"];
        $pincode  = $_POST["reg-pincode"];
        $memberId = (mysqli_fetch_object(getLastestUserId())->MUID + 1);
        //echo $name.'|'.$mobile.'|'.$email.'|'.$password.'|'.$address.'|'.$city.'|'.$state.'|'.$country.'|'.$pincode.'|'.$memberId;
        insertNewUser($memberId,$name,$email,$password,$mobile,$address,$city,$state,$country,$pincode);
        echo "<script type=\"text/javascript\">
                window.location.href = \"login\";
            </script>";
    }

    //User Profile Update
    if(isset($_POST["upd-email"]) && $_POST["upd-email"] != '' && isset($_POST["upd-mobile"]) && $_POST["upd-mobile"] != '' 
    && isset($_POST["upd-name"]) && $_POST["upd-name"] != ''   && isset($_POST["upd-address"]) && $_POST["upd-address"] != '' 
    && isset($_POST["upd-city"]) && $_POST["upd-city"] != ''   && isset($_POST["upd-state"]) && $_POST["upd-state"] != '' 
    && isset($_POST["upd-country"]) && $_POST["upd-country"] != '' && isset($_POST["upd-pincode"]) && $_POST["upd-pincode"] != '')  {
        $name     = $_POST["upd-name"];
        $mobile   = $_POST["upd-mobile"];
        $email    = $_POST["upd-email"];
        $address  = $_POST["upd-address"];
        $city     = $_POST["upd-city"];
        $state    = $_POST["upd-state"];
        $country  = $_POST["upd-country"];
        $pincode  = $_POST["upd-pincode"];
        updateUser($_SESSION['user'],$name,$email,$mobile,$address,$city,$state,$country,$pincode);
        echo "<script type=\"text/javascript\">
                window.location.href = \"update-profile\";
            </script>";
    }

    //User Password Update
    if(isset($_POST["old-password"]) && $_POST["old-password"] != '' && isset($_POST["upd-password"]) && $_POST["upd-password"] != '')  {
        $oldpassword = $salt_obj->EnCode(md5($_POST["old-password"]));
        $newpassword = $salt_obj->EnCode(md5($_POST["upd-password"]));
        $message = updateUserPassword($_SESSION['user'],$oldpassword,$newpassword);
        echo "<script type=\"text/javascript\">
                window.location.href = \"change-password\";
            </script>";
    }

    //User Address Update
    if(isset($_POST["upd-addr-email"]) && $_POST["upd-addr-email"] != '' && isset($_POST["upd-addr-contact"]) && $_POST["upd-addr-contact"] != '' 
    && isset($_POST["upd-addr-name"]) && $_POST["upd-addr-name"] != ''   && isset($_POST["upd-addr-address"]) && $_POST["upd-addr-address"] != '' 
    && isset($_POST["upd-addr-city"]) && $_POST["upd-addr-city"] != ''   && isset($_POST["upd-addr-state"]) && $_POST["upd-addr-state"] != '' 
    && isset($_POST["upd-addr-country"]) && $_POST["upd-addr-country"] != '' && isset($_POST["upd-addr-pincode"]) && $_POST["upd-addr-pincode"] != ''
    && isset($_POST["upd-addr-id"]) && $_POST["upd-addr-id"] != '')  {
        $name     = $_POST["upd-addr-name"];
        $mobile   = $_POST["upd-addr-contact"];
        $email    = $_POST["upd-addr-email"];
        $address  = $_POST["upd-addr-address"];
        $city     = $_POST["upd-addr-city"];
        $state    = $_POST["upd-addr-state"];
        $country  = $_POST["upd-addr-country"];
        $pincode  = $_POST["upd-addr-pincode"];
        $addrId   = $_POST["upd-addr-id"];
        updateProfileAddress($addrId,$name,$email,$mobile,$address,$city,$state,$country,$pincode);
        //echo $name.'|'.$mobile.'|'.$email.'|'.$address.'|'.$city.'|'.$state.'|'.$country.'|'.$pincode.'|'.$addrId;
        echo "<script type=\"text/javascript\">
                window.location.href = \"manage-address\";
            </script>";
    }

    //User New Address Update
    if(isset($_POST["new-addr-email"]) && $_POST["new-addr-email"] != '' && isset($_POST["new-addr-contact"]) && $_POST["new-addr-contact"] != '' 
    && isset($_POST["new-addr-name"]) && $_POST["new-addr-name"] != ''   && isset($_POST["new-addr-address"]) && $_POST["new-addr-address"] != '' 
    && isset($_POST["new-addr-city"]) && $_POST["new-addr-city"] != ''   && isset($_POST["new-addr-state"]) && $_POST["new-addr-state"] != '' 
    && isset($_POST["new-addr-country"]) && $_POST["new-addr-country"] != '' && isset($_POST["new-addr-pincode"]) && $_POST["new-addr-pincode"] != '')  {
        $name     = $_POST["new-addr-name"];
        $mobile   = $_POST["new-addr-contact"];
        $email    = $_POST["new-addr-email"];
        $address  = $_POST["new-addr-address"];
        $city     = $_POST["new-addr-city"];
        $state    = $_POST["new-addr-state"];
        $country  = $_POST["new-addr-country"];
        $pincode  = $_POST["new-addr-pincode"];
        addNewUserAddress($_SESSION['user'],$name,$email,$mobile,$address,$city,$state,$country,$pincode);
        //echo $name.'|'.$mobile.'|'.$email.'|'.$address.'|'.$city.'|'.$state.'|'.$country.'|'.$pincode.'|'.$addrId;
        echo "<script type=\"text/javascript\">
                window.location.href = \"manage-address\";
            </script>";
    }
?>