<?php
    require_once('core/init.php');
$action = "GetProductListByName";
    switch($action)
    {
        case "GetProductListByName":
            $productlist = array();
            try
            {
                $productlist = Controls::GetProductListByName("Product");
            }
            catch(Exception $ex)
            {
                die($ex->getMessage());
            }
            echo "<pre>";
            print_r($productlist);
            echo "</pre>";
        break;

        case "actiune2":
        break;
        case "actiune3":
        break;
        case "actiune4":
        break;
        case "actiune5":
        break;

    }

    
?>