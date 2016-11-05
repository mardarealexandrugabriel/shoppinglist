<?php
    require_once('core/init.php');
    $action = Input::get("action");
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    error_reporting(E_ALL);
    switch($action)
    {
        case "GetProductListByName":
            $productlist = array();
            try
            {
                $pname = Input::get("ProductName");
                $productlist = Controls::GetProductListByName($pname);
            }
            catch(Exception $ex)
            {
                die($ex->getMessage());
            }
                echo json_encode($productlist);
        break;

        case "AddANewProduct":
            $product = new Product();
            $product -> SetName("Produs2-a");
            $product -> SetDescription("Produs2 adaugat din aplicatie");
            $product -> SetAddedBy ("1");
            try
            {
                $product->AddANewProduct();

            }
            catch(Exception $ex)
            {
                die($ex->getMessage());
            }
        break;
                
        
        case "AddANewCompany":
            $company = new Company();
            $company -> SetName("Companie1csfromsite");
            $company -> SetUsername("Username1");
            $company -> SetPassword(Hash::make("parola"));
            try
            {
                $company -> AddANewCompany();
            }
            catch(Exception $ex)
            {
                die($ex->getMessage());
            }
        break;
        
        
        
        case "AddANewLocation":
            $location = new Location();
            $location -> SetCompanyId("102");
            $location -> SetAddress("Str.PEtru asdf");
            $location -> SetLat(21.256);
            $location -> SetLng(45.268);
            try
            {
                $location -> AddANewLocation();
            }
            catch(Exception $ex)
            {
                die($ex->getMessage());
            }
        break;
        
        
        
        case "actiune5":
        break;

    }

    
?>