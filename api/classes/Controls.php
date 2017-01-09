<?php
class Controls{
    
    public static function GetProductListByName($name)
    {
        $db = DB::getInstance()->get('products', array('ProductName', 'LIKE', '%'.$name.'%'));
        if($db->error())
        {
            throw new Exception("There was a problem selecting the product list");
        }
        else
        {
            if(!$db->count())
            {
                throw new Exception("No produduct with name : ".escape($name));
            }
            else
            {
                return $db->results();
            }
        }
    }
    public static function GetLocatiosListByCompanyId($company_id)
    {
        $db = DB::getInstance()->get('locations', array('company_id', '=', $company_id));
        $result = array();
        if($db->error())
        {
            throw new Exception("There was a problem selecting the cpmany list");
        }
        else
        {
            foreach($db->results() as $row)
            {
                $location = new Location();
                $location->SetAttributesFromDB($row);
                array_push($result, $location->LocationToArray());
            }
            
        }
        return $result;
        
    }
    public static function GetProductListByLocationId($LocationId)
    {
        $db = DB::getInstance()->query("SELECT DISTINCT(`ProductId`), `ProductName`, `ProductDescription`, `ProductAddedBy`, `ProductEnterDate` FROM `locations` JOIN `priceandstock` ON `locations`.`LocationId` = `priceandstock`.`location_id` JOIN `products` ON `priceandstock`.`product_id` = `products`.`ProductId` WHERE `LocationId` = ? GROUP BY `ProductId`", array($LocationId));
        $result = array();
        if($db->error() || $db->count()==0)
        {
            throw new Exception("There was a problem selecting the product list");
        }
        else
        {
            foreach($db->results() as $row)
            {
                $product = new Product();
                $product->SetAttributesFromDB($row);
                array_push($result, $product->ProductToArray());
            }
            
        }
        return $result;
        
    }
    public static function GetPricesByProductIdLocationId($product_id,$location_id)
    {
        $db = DB::getInstance()->query("SELECT * FROM `priceandstock` WHERE `product_id` = ? AND `location_id` = ?", array($product_id,$location_id));
        $result = array();
        if($db->error() || $db->count()==0)
        {
            throw new Exception("There was a problem selecting the prices list");
        }
        else
        {
            foreach($db->results() as $row)
            {
                $pricestock = new PriceStock();
                $pricestock->SetAttributesFromDB($row);
                array_push($result, $pricestock->PriceStockToArray());
            }
            
        }
        return $result;
    }
    public static function GetPricesByProductId($product_id)
    {
        $db = DB::getInstance()->get('priceandstock', array('product_id', '=', $product_id));
        if($db->error())
        {
            throw new Exception("There was a problem selecting the price and stock");
        }
        else
        {
            if(!$db->count())
            {
                throw new Exception("No produduct with id : ".escape($product_id));
            }
            else
            {
                
                return $db->results();
            }
        }
        
        
    }
    public static function GetNearByLocations($lat,$lng,$maxdistance)
    {
        $locationarray = array();
        $db = DB::getInstance()->get('locations', array("1","=", "1"));
        if($db->error())
        {
            throw new Exception("There was a problem selecting the price and stock");
        }
        else
        {
            if(!$db->count())
            {
                throw new Exception("No Locations");
            }
            else
            {


                $alllocations = $db->results();
                foreach($alllocations as $row)
                {
                    $location = new Location();
                    $location->SetAttributesFromDB($row);
                    if($lat != '' && $lat !='' && $maxdistance != '')
                    {
                        //vad daca e in apropiere 
                        //echo pow(abs($lat*10000)-abs($location->GetLat()*10000),2) ." ". pow(abs($lng*10000) - abs($location->GetLng()*10000),2) ." ". pow(abs($maxdistance*10000*0.01),2)."<br>";
                        if( pow(abs($lat*10000)-abs($location->GetLat()*10000),2) + pow(abs($lng*10000) - abs($location->GetLng()*10000),2) <= pow(abs($maxdistance*10000*0.01),2))
                            array_push($locationarray,$location->LocationToArray());
                    }
                    else
                    {
                        array_push($locationarray,$location->LocationToArray());
                    }
                }
                return $locationarray;
            }
        }
        

    }
    public static function GetProductPricesGeneral($product_id, $lat, $lng, $maxdistance)
    {
        $generalarray = array();
        //iau locatii de langa mine
        $locationarray = self::GetNearByLocations($lat, $lng, $maxdistance);
        //pentru fiecare locatie de langa mine iau pricestock de la produul X
        foreach($locationarray as $lrow)
        {
            $partarray = array();
            $pricestockarray = array();
            try
            {
                
                $pricestockarray = self::GetPricesByProductIdLocationId($product_id, $lrow["LocationId"]);
                $partarray = $lrow;
                $partarray["PriceAndStock"] = array();
                $partarray["PriceAndStock"] = $pricestockarray;
                array_push($generalarray, $partarray);
            }
            catch(Exception $ex)
            {
                //nothing;
            }   

        }
        return $generalarray;
        
    }
    public static function Login($Username, $Password)
    {
        $db = DB::getInstance()->get('users', array("Username","=", $Username));
        if($db->error())
        {
            throw new Exception("There was a problem selecting the user");
        }
        else
        {
            if(!$db->count())
            {
                throw new Exception("Invalid Username and Password");
            }
            else
            {
                $user = new User();
                $user->SetAttributesFromDB($db->results()[0]);               
                if($user->GetPassword() == md5($Password))
                    return $user->UserToArray();
                else
                    throw new Exception("Invalid Username and Password");
            }

        }

    }
}
?>