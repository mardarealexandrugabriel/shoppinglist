<?php
    require_once('core/init.php');
$action = "AddANewLocation";
    switch($action)
    {
        case "GetProductListByName":
            $productlist = array();
            try
            {
                $productlist = Controls::GetProductListByName("Produ");
            }
            catch(Exception $ex)
            {
                die($ex->getMessage());
            }
            echo "<pre>";
                print_r($productlist);
            echo "</pre>";
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