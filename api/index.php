<?php
    require_once('core/init.php');
    $prod = new Product();
    try
    {
        $prod->GetProductByName("Product2");
    }
    catch(Exception $ex){
        die($ex->getMessage());
    }
    echo json_encode($prod->ProductToArray());
?>