<?php
session_start();
require_once './config/database.php';
spl_autoload_register(
    function ($classname) {
        require "./app/Models/$classname.php";
    }
);
$addressModel = new AddressModel();

if (isset($_POST["provinceId"])) {
    $districtList = $addressModel->getDistric($_POST["provinceId"]);

    $_SESSION["districtList"] = $districtList;
    $_SESSION["provinceId"] = $_POST["provinceId"];
    
    header("Location: Topay.php");
}
