<?php
    require_once('core/init.php');
    //test
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
        case "AddANewPriceStock":
            $pricestock = new PriceStock();
            if(Input::get("location_id") != "")
            {
                $pricestock->SetLocationId(Input::get("location_id"));
            }
            else
            {
                $pricestock->SetLocationId("1");
            }
            $pricestock->SetProductId(Input::get("product_id"));
            $pricestock->SetPrice(Input::get("Price"));
            $pricestock->SetStock(Input::get("Stock"));
            try
            {
                $pricestock->AddANewPriceStock();

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
            $location -> SetAddress("Str.PEtrus asdf");
            $location -> SetName("Nume locatisoe 1");
            $location -> SetLat(21.2526);
            $location -> SetLng(45.2268);
            try
            {
                $location -> AddANewLocation();
            }
            catch(Exception $ex)
            {
                die($ex->getMessage());
            }
        break;

        case "AddANewUser":

            $user = new User();
            $user->SetName("Nume user 1");
            $user->SetUsername("username1");
            $user->SetPassword("password1");
            try
            {
                  $user->AddANewUser();
            }
            catch(Exception $ex)
            {
                die($ex->getMessage());
            }
        break;
        case "GetProducListByCompanyId":
            $productlist = array();
            $company_id = Input::get("CompanyId");
            $productlist = Controls::GetLocatiosListByCompanyId($company_id);
            echo json_encode($productlist);
          
            
        break;

        
        
        case "actiune5":
        break;

    }

    
?>