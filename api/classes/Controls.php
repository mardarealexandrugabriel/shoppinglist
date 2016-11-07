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
    
}
?>