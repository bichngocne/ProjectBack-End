<?php
class voucherModel extends Model
{
    public function getAllVouchers()
    {
        $sql = parent::$connection->prepare("SELECT * FROM `vouchers`");
        return parent::select($sql);
    }
}