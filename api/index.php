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
            $results = array();
            $results["Errors"] = array();
            $validate = new Validate();
            $validation = $validate -> check(array(
                'ProductName' => array(
                    'required' => true,
                ),
                'ProductDescription' => array(
                    'required' => true,
                ),
            ));
            $validation->checkLogin();
            if(!$validation->passed())
            {
                $errorsarray = $validation->errors();
                foreach($errorsarray as $err)
                {
                    array_push($results["Errors"], $err);
                }                
            }
            else
            {
                $product = new Product();
                $product -> SetName(Input::get("AddANewProduct"));
                $product -> SetDescription(Input::get("ProductDescription"));
                $product -> SetAddedBy (Session::get("UserId"));
                try
                {
                    $product->AddANewProduct();

                }
                catch(Exception $ex)
                {
                    array_push($results["Errors"], $ex->getMessage());
                }
            }
            if(!empty($results["Errors"]))
            {
                echo json_encode($results);
            }

        break;
        case "AddANewPriceStock":
            $results = array();
            $results["Errors"] = array();
            $validate = new Validate();
            $validation = $validate -> check(array(
                'Price' => array(
                    'required' => true,
                ),
                'Stock' => array(
                    'required' => true,
                ),
                'product_id' => array(
                    'required' => true,
                ) 
            ));
            $validation->checkLogin();
            if(!$validation->passed())
            {
                $errorsarray = $validation->errors();
                foreach($errorsarray as $err)
                {
                    array_push($results["Errors"], $err);
                }                
            }
            else
            {
                $pricestock = new PriceStock();
                if(Session::get("IsManager") == 1)
                {
                    if(Input::get("location_id") == "" || !Controls::CheckLocationAccess(Input::get("location_id")))
                    {
                        array_push($results["Errors"], "Invalid Location");
                        echo json_encode($results);
                        break;             
                    }
                    else
                    {
                        $pricestock->SetLocationId(Input::get("location_id"));
                    }
                }
                else
                {
                    $pricestock->SetLocationId(Session::get("LocationId"));
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
                    array_push($results["Errors"], $ex->getMessage());
                }
            }
            if(!empty($results["Errors"]))
            {
                echo json_encode($results);
            }        
            
        break;
                
        
        case "AddANewCompany":
            $results = array();
            $results["Errors"] = array();
            $validate = new Validate();
            $validation = $validate -> check(array(
                'CompanyName' => array(
                    'required' => true,
                )
            ));
            if(!$validation->passed())
            {
                $errorsarray = $validation->errors();
                foreach($errorsarray as $err)
                {
                    array_push($results["Errors"], $err);
                }                
            }
            else
            {
                $company = new Company();
                $company -> SetName(Input::get("CompanyName"));
                try
                {
                    $company -> AddANewCompany();
                }
                catch(Exception $ex)
                {
                    array_push($results["Errors"], $ex->getMessage());
                }

            }
            if(!empty($results["Errors"]))
            {
                echo json_encode($results);
            }      
            
        break;
        
                
        case "AddANewLocation":
            $results = array();
            $results["Errors"] = array();
            $validate = new Validate();
            $validation = $validate -> check(array(
                'LocationAdress' => array(
                    'required' => true,
                ),
                'LocationName' => array(
                    'required' => true,
                ),
                'LocationLat' => array(
                    'required' => true,
                ),
                'LocationLng' => array(
                    'required' => true,
                )  
            ));
            $validation->checkLogin();
            $validation->checkManager();
            if(!$validation->passed())
            {
                $errorsarray = $validation->errors();
                foreach($errorsarray as $err)
                {
                    array_push($results["Errors"], $err);
                }                
            }
            else
            {
                $location = new Location();
                $location -> SetCompanyId(Session::get("CompanyId"));
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
                    array_push($results["Errors"], $ex->getMessage());
                }
            }
             if(!empty($results["Errors"]))
            {
                echo json_encode($results);
            }   
        break;

        case "AddANewUser":
            $results = array();
            $results["Errors"] = array();
            $validate = new Validate();
            $validation = $validate -> check(array(
                'Name' => array(
                    'required' => true,
                ),
                'Username' => array(
                    'required' => true,
                ),
                'Password' => array(
                    'required' => true,
                ),
                'LocationId' => array(
                    'required' => true,
                ),
                'CompanyId' => array(
                    'required' => true,
                )    
            ));
            if(!$validation->passed())
            {
                $errorsarray = $validation->errors();
                foreach($errorsarray as $err)
                {
                    array_push($results["Errors"], $err);
                }                
            }
            else
            {
                $user = new User();
                $user->SetName(Input::get("Name"));
                $user->SetUsername(Input::get("Username"));
                $user->SetPassword(md5(Input::get("Password")));
                $user->SetLocationId(Input::get("LocationId"));
                $user->SetCompanyId(Input::get("CompanyId"));
                if(Input::get("IsManager") == "1")
                {
                    $user->SetIsManager(Input::get("IsManager"));
                    $user->SetLocationId("0");
                }
                else
                {
                    $user->SetIsManager("0");
                    $user->SetCompanyId(Session::get("CompanyId"));
                }
                try
                {
                    $user->AddANewUser();
                }
                catch(Exception $ex)
                {
                    array_push($results["Errors"], $ex->getMessage());
                }  
            }
            if(!empty($results["Errors"]))
            {
                echo json_encode($results);
            } 
        break;
        case "GetLocationsListByCompanyId":
            $locationlist = array();
            $company_id = Input::get("CompanyId");
            $locationlist = Controls::GetLocatiosListByCompanyId($company_id);
            echo json_encode($locationlist);
        break;

        
        case "GetProductListByLocationId":
            $productlist = array();
            $location_id = Input::get("LocationId");
            try
            {
                  $productlist = Controls::GetProductListByLocationId($location_id);
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
        case "AddAutomaticPriceStock":
            $results = array();
            $results["Errors"] = array();
            $t = time();
            $t = date("Y-m-d h-i-s",$t);
            $t = str_replace("-","",$t);
            $t = str_replace(" ","",$t);
            $UploadFileName = $t.".json";
            $UploadFilePath = "temp/".$UploadFileName;
            if(!Session::exists("UserId"))
            {
                array_push($results["Errors"], "You are not authorized to do that, please Login");
            }
            else
            {
                if(!Controls::checkFile("JsonFile"))
                {
                    array_push($results["Errors"], "Json File is missing");
                }
                else
                {
                    move_uploaded_file($_FILES["JsonFile"]["tmp_name"], $UploadFilePath);
                    $structure = file_get_contents($UploadFilePath);
                    $data = json_decode($structure, true);
                    if($data == null)
                    {
                        array_push($results["Errors"], "Json File is not in a correct format.");
                    }
                    else
                    {
                        foreach($data as $lkey => $location)
                        {
                            if(Session::get("IsManager") == 1)
                            {
                                if(!Controls::CheckLocationAccess($lkey))
                                {
                                    array_push($results["Errors"], "Invalid Location");
                                    echo json_encode($results);
                                    unlink($UploadFilePath);
                                    die();             
                                }
                            }
                            else
                            {
                                $lkey==Session::get("LocationId");
                            }
                            foreach($location as $pkey => $product)
                            {
                                $pricestock = new PriceStock();
                                $pricestock->SetLocationId($lkey);
                                $pricestock->SetProductId($pkey);
                                $pricestock->SetPrice($product["Price"]);
                                $pricestock->SetStock($product["Stock"]);
                                try
                                {
                                    $pricestock->AddANewPriceStock();
                                }
                                catch(Exception $ex)
                                {
                                    unlink($UploadFilePath);
                                    array_push($results["Errors"], $ex->getMessage());
                                }
                            }
                        }
                    }
                    unlink($UploadFilePath);
                }

            }
            if(!empty($results["Errors"]))
            {
                echo json_encode($results);
            } 
            
        break;
        case "LogIn":
            $results = array();
            $results["Errors"] = array();
            $results["User"] = array();
            $validate = new Validate();
            $validation = $validate -> check(array(
                'Username' => array(
                    'required' => true,
                ),
                'Password' => array(
                    'required' => true,
                )
            ));
            if(!$validation->passed())
            {
                $errorsarray = $validation->errors();
                foreach($errorsarray as $err)
                {
                    array_push($results["Errors"], $err);
                }                
            }
            else
            {
                $response = "";
                $Username = Input::get("Username");
                $Password = Input::get("Password");
                try
                {
                    $response = Controls::Login($Username, $Password);
                    $user = array();
                    $user["Name"] = $response["UName"];
                    $user["Username"] = $response["Username"];
                    $user["LocationId"] = $response["LocationId"];
                    $user["UserId"] = $response["UserId"];
                    $user["CompanyId"] = $response["CompanyId"];
                    $user["IsManager"] = $response["IsManager"];
                    Session::put("UserId",$user["UserId"]);
                    Session::put("LocationId",$user["LocationId"]);
                    Session::put("IsManager",$user["IsManager"]);
                    Session::put("CompanyId",$user["CompanyId"]);
                    array_push($results["User"], $user);
                    unset($results["Errors"]);
                    echo json_encode($results);
    
                }
                catch(Exception $ex)
                {
                    session_destroy();
                    array_push($results["Errors"], $ex->getMessage());
                }  
            }
            if(!empty($results["Errors"]))
            {
                unset($results["User"]);
                echo json_encode($results);
            }  
        break;
        case "LogOut":
           Session::clean();
        break;
        case "SessionTest":
            if(Session::exists("UserId"))
                echo Session::get("UserId");
            else
                echo "No session";
        break;
        
    
    }

    
?>