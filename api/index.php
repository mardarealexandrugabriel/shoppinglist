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
            $product -> SetName(Input::get("ProductName"));
            $product -> SetDescription(Input::get("ProductDescription"));
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
            $location -> SetCompanyId("1");
            $location -> SetAddress(Input::get("LocationAdress"));
            $location -> SetName(Input::get("LocationName"));
            $location -> SetLat(Input::get("LocationLat"));
            $location -> SetLng(Input::get("LocationLng"));
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
        case "GetLocationsListByCompanyId":
            $locationlist = array();
            $company_id = Input::get("CompanyId");
            $locationlist = Controls::GetLocatiosListByCompanyId($company_id);
            echo json_encode($locationlist);
        break;

        
        case "GetProducListByLocationId":
            $productlist = array();
            $location_id = Input::get("LocationId");
            try
            {
                  $productlist = Controls::GetProducListByLocationId($location_id);
                  echo json_encode($productlist);
            }
            catch(Exception $ex)
            {
                die($ex->getMessage());
            }

        break;
        case "GetPricesByProductIdLocationId":
            $pricestocklist = array();
            $location_id = Input::get("LocationId");
            $product_id = Input::get("ProductId");
            try
            {
                  $pricestocklist = Controls::GetPricesByProductIdLocationId($product_id,$location_id);
                  echo json_encode($pricestocklist);
            }
            catch(Exception $ex)
            {
                die($ex->getMessage());
            }
        break;
        case "GetProductPricesGeneral":
            $generallist = array();
            $product_id = Input::get("ProductId");
            $lat = Input::get("Lat");
            $lng = Input::get("Lng");
            $maxdistance = Input::get("MaxDistance");
            try
            {
                  $generallist = Controls::GetProductPricesGeneral($product_id, $lat, $lng, $maxdistance);
                  echo json_encode($generallist);
            }
            catch(Exception $ex)
            {
                die($ex->getMessage());
            }
        break;

    }

    
?>