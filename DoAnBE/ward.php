<?php
    session_start();
    require_once './config/database.php';
    spl_autoload_register(
        function ($classname)
        {
            require "./app/Models/$classname.php";
        }
    );
    $addressModel = new AddressModel();

    if (isset($_POST["districtID"])) {
    $wards = $addressModel->getWards($_POST["districtID"]);

    $_SESSION["wardList"] = $wards;
    $_SESSION["districtID"] = $_POST["districtID"];

    header("Location: Topay.php");
    }
