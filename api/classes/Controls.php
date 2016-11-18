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
    public static function GetProducListByLocationId($LocationId)
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
            throw new Exception("There was a problem selecting the product list");
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

    
    
}
?>